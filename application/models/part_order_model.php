<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Part_order_model extends MY_Model {

    public function get_site($id)
    {
        return $this->db
            ->select('part_orders_sites.*, users.fullname, companies.name as company_name')
            ->join('companies', 'part_orders_sites.company_id = companies.id')
            ->join('users', 'part_orders_sites.user_id = users.id')
            ->where('part_orders_sites.id', $id)
            ->get('part_orders_sites')
            ->row_array();
    }

    public function get_sites($user_id)
    {
        // get the users groups
        $groups = $this->db
            ->where('user_id', $user_id)
            ->get('part_orders_groups_users')
            ->result_array();

        if( empty($groups) ) {
            return NULL;
        }

        foreach($groups as $group)
        {
            $this->db->or_where('group_id', $group['group_id']);
        }

        $sites = $this->db
            ->select('part_orders_sites.*, users.fullname, companies.name as company_name')
            ->order_by('user_id')
            ->join('companies', 'part_orders_sites.company_id = companies.id')
            ->join('users', 'part_orders_sites.user_id = users.id')
            ->get('part_orders_sites')
            ->result_array();

        return $sites;
    }

    public function get_outstanding_list($sites)
    {
        $outstanding_orders = array();
        foreach($sites as $site_row)
        {
            $site = $site_row['id'];
            // new system
            $sql = "SELECT part_orders.id, part_orders.status, part_orders.time as timestamp,
                part_orders.unread_notes, users.username, companies.name as company_name,
                CASE 
                    WHEN (status = 1) THEN 'Awaiting Quote'
                    WHEN (status = 2) THEN 'Quoted'
                    WHEN (status = 3) THEN 'Awaiting Dispatch'
                    WHEN (status = 4) THEN 'Dispatched'
                END as status_human
                FROM part_orders
                INNER JOIN `users` ON part_orders.user_id = users.id
                INNER JOIN `companies` ON part_orders.company_id = companies.id
                WHERE (part_orders.status = 3 OR part_orders.status = 1) AND part_orders.company_id = " . $site_row['company_id'];
            if(!empty($site_row['user_id'])) $sql .= " AND part_orders.user_id = " . $site_row['user_id'];
            $sql .= " ORDER BY id DESC";
            $rows = $this->db->query($sql)->result_array();

            if(count($rows) > 0)
            {
                foreach($rows as $row)
                {
                    $row['site'] = $site;
                    $outstanding_orders[] = $row;
                }
            }
        } // foreach sites

        return ( count($outstanding_orders) > 0 ) ? $outstanding_orders : NULL;
    }

    public function get_order_list($site)
    {
        $backdate = time() - 7776000;

        // new system
        $sql = "SELECT part_orders.id, part_orders.status, part_orders.time as timestamp, part_orders.unread_notes, users.username,
            CASE 
                WHEN (status = 1) THEN 'Awaiting Quote'
                WHEN (status = 2) THEN 'Quoted'
                WHEN (status = 3) THEN 'Awaiting Dispatch'
                WHEN (status = 4) THEN 'Dispatched'
            END as status_human
            FROM part_orders INNER JOIN users ON part_orders.user_id = users.id
            WHERE part_orders.company_id = " . $site['company_id'];
        if(!empty($site['user_id'])) $sql .= " AND part_orders.user_id = " . $site['user_id'];

        $sql .= " ORDER BY part_orders.time DESC";
        $orders = $this->db->query($sql)->result_array();

        return $orders;
    }

    public function get_order($site, $id)
    {
        // new system
        $this->load->model('note_model');
        $this->load->model('part_model');

        $order = $this->db
            ->query("SELECT part_orders.*, users.email 
            FROM `part_orders` INNER JOIN `users` on `part_orders`.`user_id` = `users`.`id`
            WHERE `part_orders`.`id` = " . $id . " LIMIT 1")
            ->row_array();
        $order['invoiceaddress'] = $this->db->query("SELECT addresses.name, addresses.address_1, addresses.address_2, addresses.citytown, addresses.county, addresses.postcode
          FROM `users` INNER JOIN `addresses` ON users.default_address = addresses.id WHERE users.id = " . $order['user_id'] . " LIMIT 1")->row_array();
        $order['deliveryaddress'] = $this->db->query("SELECT * FROM `addresses` WHERE `id` = " . $order['addresses_id'] . " LIMIT 1")->row_array();
        $order['notes'] = $this->note_model->get_many_by(array(
            'module_id' => 7,
            'row_id' => $order['id']
        ));

        $order['items'] = $this->db
            ->where('orders_id', $order['id'])
            ->get('part_orders_items')
            ->result_array();

        // set unread notes to 0 as a read has taken place
        $this->db
          ->where('id', $order['id'])
          ->update('part_orders', array('unread_notes' => 0)); 

        return $order;
    }

    public function submit_quote($site, $id)
    {
        foreach($_POST as $name => $value)
        {
            // FILTER OUT ANYTHING OTHER THEN PARTS <<<< ADD THE FIELDS BELOW
            if($name != 'model' && $name != 'action' && $name != 'orderid')
            {
                // TRIM THE JS COUNTER NUMBER AFTER FORM ID
                $tablerow = explode('_', $name);
                // CHECK THERE IS A VALUE 
                if($value)
                {
                    // ADD TO ARRAYS
                    if($tablerow[0] == 'partno') $partnos[] = $value;
                    else if ($tablerow[0] == 'description') $descriptions[] = $value;
                    else if ($tablerow[0] == 'price') $prices[] = $value;
                    else if ($tablerow[0] == 'quantity') $quantitys[] = $value;
                    else if ($tablerow[0] == 'stock') $stocks[] = $value;
                }
                // stop error if the user hasnt filled out stock
                if(! $value && $tablerow[0] == 'stock')
                {
                    $stocks[] = '';
                }
            }
        }
        $i = 0;
        $records = ( isset($partnos) ) ? count($partnos) : 0;
        // remove whats there already
        $this->db->delete('part_orders_items', array('orders_id' => $id)); 

        // LOOP THROUGH THE ARRAYS AND UPDATE orders_special_items
        while($i < $records)
        {
            // check DB table has quote_stock
            $data = array(
               'orders_id' => $id,
               'quote_pnumber' => $partnos[$i],
               'quote_description' => $descriptions[$i],
               'price' => $prices[$i],
               'quantity' => $quantitys[$i],
               'quote_stock' => $stocks[$i]
            );
            $this->db->insert('part_orders_items', $data); 
            $i++;
        }
        // UPDATE STATUS, IF STRAIGHT TO ORDER GO 3 (AWAITING DISPATCH) OR NOT GO 2 (QUOTED)
        $query = $this->db->get_where('part_orders', array('id' => $id))->row_array();

        $storder = $query['storder'];
        if($storder == 1)
        {
            $data = array(
                'status' => 4,
                'wipno' => $_POST['wipno']
            );
            $this->db->where('id', $id);
            $this->db->update('part_orders', $data); 
            //
            // ACCOUNTS  == CHANGE ==
            $order = $this->db->query("SELECT *
                                  FROM part_orders INNER JOIN addresses ON part_orders.addresses_id = addresses.id
                                  INNER JOIN users ON part_orders.user_id = users.id
                                  WHERE part_orders.id = " . $id)->row_array();
            $customer_code = (! empty($order['customer_code']) ) ? $order['customer_code'] : 0;
        }
        else
        {
            $data = array(
                'status' => 2,
            );
            $this->db->where('id', $id);
            $this->db->update('part_orders', $data); 
        }

        return;
    }

    public function dispatch($site, $id)
    {
        // new system
        $data = array(
            'status' => 4,
            'wipno' => $_POST['wipno']
        );
        $this->db->where('id', $id);
        $this->db->update('part_orders', $data); 

        $order = $this->db->query("SELECT *
                              FROM part_orders INNER JOIN addresses ON part_orders.addresses_id = addresses.id
                              INNER JOIN users ON part_orders.user_id = users.id
                              WHERE part_orders.id = " . $id)->row_array();
        $customer_code = (! empty($order['customer_code']) ) ? $order['customer_code'] : 0;

        return;
    }

}
//EOF
