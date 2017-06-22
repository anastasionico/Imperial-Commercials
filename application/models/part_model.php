<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Part_model extends MY_Model {

    protected $module_id = 7;

    function __construct() {
        // Call the Model constructor
        parent::__construct();

        $this->load->model('address_model');
        $this->load->model('part_list_model');
        $this->load->model('part_list_part_model');
    }

    /*
     * The master part pricing lookup function
     * as kerridge rounds things up in our favour (long story)
     */
    public function lookup_price($part_number, $manufacturer_id, $company_id, $quantity = 0) {
        // clean up the part number
        $part_number = str_replace(" ", "", $part_number);
        $part_number = str_replace("/", "", $part_number);

        // check the main part_lists_parts table
        $stmt = $this->db
            ->select('pnumber, description, price as rrp, discount_code')
            ->where('pnumber', $part_number)
            ->limit(1)
            ->get('part_lists_parts');
        $part = $stmt->row_array();

        /* if no result and the first letter of part number isnt 'A',
        lookup again with an 'A' (some people forget the leading A) */
        if(!$part && substr($part_number, 0, 1) != 'A') {
            $stmt = $this->db
                ->select('pnumber, description, price as rrp, discount_code')
                ->where('pnumber', 'A' . $part_number)
                ->limit(1)
                ->get('part_lists_parts');
            $part = $stmt->row_array();
        }

        $lookup = $this->lookup_adp($part_number, $manufacturer_id, $company_id, $quantity);

        if($lookup) {
            return $lookup;
        }
        // this is fail back onto the part_lists_part table
        else if($part) {

            // check if it has a fixed price
            $fixed_price = $this->get_fixed_price($manufacturer_id, $part['pnumber']);
            if(! empty($fixed_price)) {
                $part['price'] = $fixed_price['price'];
                $part['line_price'] = ($quantity) ? number_format($part['price'] * $quantity, 2, '.', '') : $part['price'];
            }
            else if(! empty($part['discount_code']) ) {

                // apply discount if possible
                $discount = $this->get_discount_codes($company_id, $manufacturer_id);
                // if the discount code in kerridge exists in our discount codes table
                if(isset($discount[$part['discount_code']])) { 
                    $part['price'] = number_format(ceil($part['rrp'] * (100 - $discount[$part['discount_code']])) / 100, 2, '.', '');
                    if($quantity) $part['line_price'] = number_format(ceil(($quantity * $part['rrp']) * (100 - $discount[$part['discount_code']])) / 100, 2, '.', '');
                    else $part['line_price'] = $part['price'];
                }
                else {
                    $part['price'] = $part['rrp']; // no need for formatting ['rrp'] as its out of the DB
                    $part['line_price'] = ($quantity) ? number_format($part['price'] * $quantity, 2, '.', '') : $part['price'];
                }
            }
            else {
                $part['price'] = $part['rrp'];
                $part['line_price'] = ($quantity > 0) ? number_format($quantity * $part['price'], 2, '.', '') : $part['price'];
            }

            return $part;
        }
        else {
            return NULL;
        }
    }

    /*
     * Looks up part in `parts_adp`, if found applys the $company_id discount
     * returns $part[pnumber, title, rrp, price] with price being discounted
     * Requires get_discount_codes()
     */
    public function lookup_adp($part_number, $manufacturer_id, $company_id, $quantity = 0) {
        if($part_number) {
            // clean up the part number
            $part_number = str_replace(" ", "", $part_number);
            $part_number = str_replace("/", "", $part_number);
            // lookup
            $stmt = $this->db
                ->select('pnumber, title, price AS rrp, discount_code')
                ->where('pnumber', $part_number)
                ->limit(1)
                ->get('part_pricefile_m' . $manufacturer_id);
            $part = $stmt->row_array();

            /* if no result and the first letter of part number isnt 'A',
            lookup again with an 'A' (some people forget the leading A) */
            if(!$part && substr($part_number, 0, 1) != 'A') {
                $stmt = $this->db
                    ->select('pnumber, title, price AS rrp, discount_code')
                    ->where('pnumber', 'A' . $part_number)
                    ->limit(1)
                    ->get('part_pricefile_m' . $manufacturer_id);
                $part = $stmt->row_array();
            }

            // if we have a part, grab discount codes and add discount to array
            if($part) {
                // check if it has a fixed price
                $fixed_price = $this->get_fixed_price($manufacturer_id, $part['pnumber']);
                $discount = $this->get_discount_codes($company_id, $manufacturer_id);
                if(! empty($fixed_price)) {
                    $part['price'] = $fixed_price['price'];
                    $part['line_price'] = ($quantity) ? number_format($part['price'] * $quantity, 2, '.', '') : $part['price'];
                }
                else if(isset($discount[$part['discount_code']])) { // if the discount code in kerridge exists in our discount codes table
                    $part['price'] = number_format(ceil($part['rrp'] * (100 - $discount[$part['discount_code']])) / 100, 2, '.', '');
                    if($quantity) $part['line_price'] = number_format(ceil(($quantity * $part['rrp']) * (100 - $discount[$part['discount_code']])) / 100, 2, '.', '');
                    else $part['line_price'] = $part['price'];
                }
                else {
                    $part['price'] = $part['rrp']; // no need for formatting ['rrp'] as its out of the DB
                    $part['line_price'] = ($quantity) ? number_format($part['price'] * $quantity, 2, '.', '') : $part['price'];
                }
            }
        }
        /* unset($part['discount_code']); // not needed anymore */
        return (!empty($part)) ? $part : NULL;
    }

    /*
     * Returns $array[$discount_code] = percent discount
     * Where $discount_code is 01, 02, 1C etc
     */
    function get_discount_codes($company_id, $manufacturer_id) {
        if($company_id) {

            $company = $this->company_model->get($company_id);
            if($company['part_discount_m' . $manufacturer_id . '_id'] == 0)
                return NULL;

            $stmt = $this->db
                ->where('id', $company['part_discount_m' . $manufacturer_id . '_id'])
                ->limit(1)
                ->get('part_discount_m' . $manufacturer_id);
            $codes = $stmt->row_array();

            /* Have to clean them up, mysql made me put 'c' in the column names,
            this loop removes that */
            $return_codes = array(); 
            if($codes) {
                foreach($codes as $code => $discount) {
                    if($code != 'id' && $code != 'name') {
                        $cleanup = substr($code, 1, 2);
                        $return_codes[$cleanup] = $discount; 
                    }
                }
            }

        }
        return $return_codes;
    }

    /*
     * Returns a list of users part lists 
     */
    function get_user_part_lists($user_id)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->where('imprest', 0)
            ->join('part_lists', 'users_part_lists.part_list_id = part_lists.id')
            ->get('users_part_lists')
            ->result_array();
    }

    /*
     * Returns a list of parts for a parts list
     */
    function get_part_list_parts($list_id)
    {
        $list = $this->part_list_model->get($list_id);

        $parts = $this->db
            ->where('part_list_id', $list_id)
            ->get('part_lists_parts')
            ->result_array();

//        $group_ids = array();
//        $groups = array();

        foreach($parts as &$part)
        {
            /*
            $part['groups'] = $this->db
                ->where('part_id', $part['part_id'])
                ->join('part_groups', 'part_groups.id = part_group_parts.group_id')
                ->get('part_group_parts')
                ->result_array();
             */

            $part['image'] = $this->check_image($part['pnumber']);

            $price_line = $this->lookup_price($part['pnumber'], $list['manufacturer_id'], $this->data['user']['company']['id'], 1);
            $part['rrp'] = $price_line['rrp'];
            $part['price'] = $price_line['price'];

            //$part['stock'] = $this->stock_check($part['pnumber']);

            /*
            // class names used for JS plugin
            $part['groups_class'] = '';
            foreach($part['groups'] as $group)
            {
                $part['groups_class'] .= ' group-' . $group['addr'];
                if(in_array($group['id'], $group_ids) == FALSE)
                {
                    $group_ids[] = $group['id'];
                    $groups[$group['group_id']] = $group;
                }
            }
             */
        }

        return array(
            'parts' => $parts,
//            'groups' => $groups
        );
    }

    function get_parts()
    {
        return $this->db
            ->get('part_index')
            ->result_array();
    }

    function get_contract_price($part_number)
    {
        if(empty($this->data['user']['discount_account_number'])) {
            return NULL;
        }
        else {
            return $this->db
                ->where('account_number', $this->data['user']['discount_account_number'])
                ->where('domain_id', $this->data['domain']['id'])
                ->where('part_number', $part_number)
                ->limit(1)
                ->order_by('company_number', 'desc')
                ->get('part_contract_pricing')
                ->row_array();
        }
    }

    function get_fixed_price($manufacturer_id, $part_number)
    {
        $contract_price = $this->get_contract_price($part_number);
        if(! empty($contract_price)) {
            return $contract_price;
        }
        else {
            return $this->db
                ->where('manufacturer_id', $manufacturer_id)
                ->where('pnumber', $part_number)
                ->limit(1)
                ->get('part_price_fix')
                ->row_array();
        }
    }

    /*
    // unused?
    // unused?
    function get_vehicle($vehicle_id)
    {
        return $this->db
            ->where('id', $vehicle_id)
            ->limit(1)
            ->get('part_vehicles')
            ->row_array();
    }
     */

    function get_epc_login($company_id, $user_id)
    {
        return $this->db
            ->where('company_id', $company_id)
            ->where('user_id', $user_id)
            ->limit(1)
            ->get('part_epc_logins')
            ->row_array();
    }

    /*
     * Returns a list of parts given a group id
     */
    function get_by_group($group_id)
    {
        $parts = $this->db
            ->where('group_id', $group_id)
            ->join('part_index', 'part_index.id = part_group_parts.part_id')
            ->get('part_group_parts')
            ->result_array();

        foreach($parts as &$part)
        {
            $part['image'] = $this->check_image($part['pnumber']);
            //$part['stock'] = $this->stock_check($part['pnumber']);
        }

        return $parts;
    }

    function check_image($pnumber, $thumb = NULL)
    {
        $dir = '/assets/img/parts/catalog';
        $filename = FCPATH . $dir . '/' . $pnumber . '_1.jpg';
        if (file_exists($filename))
        {
            if($thumb) {
                return $dir . '/' . $pnumber . '.jpg';
            }
            else {
                return $dir . '/' . $pnumber . '_1.jpg';
            }
        }
        else
        {
            if($thumb) {
                return $dir . '/_none_thumb.jpg';
            }
            else {
                return $dir . '/_none.jpg';
            }
        }
    }

    /*
     * Gets impress stock list
     *
     * DEFAULTS TO MB STOCK ONLY, PRICES DONT WORK FOR OTHER MANUFACTURERS
     * AS THERES NO MANUFACTURER ID FOR THE IMPREST LINES
     *
     *
     * REMEMEBER TO UPDATE post_imprest WHEN YOU FIX THIS
     */
    function get_imprest($user_id)
    {
        $imprest_list = $this->db->get_where('users_imprest_lists', array(
                'user_id' => $user_id,
            ))->row_array();

        if(! empty($imprest_list) ) {
            $list = $this->db
                ->where('domain_id', $this->data['domain']['id'])
                ->where('account_number', $imprest_list['account_number'])
                ->where('site_code', $imprest_list['site_code'])
//                ->join('part_lists', 'users_part_lists.part_list_id = part_lists.id')
                ->get('part_imprest_lists')
                ->result_array();
        }

        if(empty($list)) {
            return NULL;
        }
        else {
            foreach($list as &$part) {
                //$part['image'] = $this->check_image($part['part_number']);

                // HERES WHERE I BODGE IT WITH JUST MB FOR THE TIME BEING
                $price_line = $this->lookup_price($part['part_number'], 1, $this->data['user']['company']['id'], 1);
                // CHANGE THE 1 TO MANUFACTURER_ID

                $part['rrp'] = $price_line['rrp'];
                $part['price'] = $price_line['price'];
            }
            return $list;
        }
    }

    /*
     * Adds posted part items to cart library
     */
    function checkout()
    {
        $cart_data = array();

        foreach($this->input->post() as $name => $value)
        {
            if(substr($name, 0, 2) == "bb")
            {
                $input_id = explode('_', $name);
                //$vehicle_id = substr($input_id[0], 2);// validate?
                $part_id = $input_id[1];// validate?

                $part = $this->part_list_part_model->get($part_id);
                $lookup = $this->lookup_price($part['pnumber'], $part['manufacturer_id'], $this->data['user']['company']['id'], $value);
                $list = $this->part_list_model->get($part['part_list_id']);
                //$vehicle = $this->get_vehicle($vehicle_id);

                $cart_data[] = array(
                    'id'      => $part['id'], 
                    'qty'     => $value, // validate?
                    'price'   => $lookup['price'],
                    'name'    => $part['description'],
                    'options' => array(
                        'pnumber' => $part['pnumber'],
                        'list_id' => $list['id'],
                        'list_name' => $list['name']
                    )
                );
            }
        }

        $this->cart->destroy();
        $this->cart->insert($cart_data);

        return TRUE;
    }

    /*
     * Updates checkout quantitys
     */
    function update_checkout()
    {
        $cart_data = array();

        foreach($this->input->post() as $name => $value)
        {
            if(substr($name, 0, 3) == "row")
            {
                list( , $row_no) = explode('_', $name);

                $cart_data[] = array(
                    'rowid'   => $this->input->post('row_' . $row_no),
                    'qty'     => $this->input->post('qty_' . $row_no),
                );
            }
        }

        $this->cart->update($cart_data);

        return TRUE;
    }

    /*
     * Adds posted part items to cart library
     */
    function checkout_imprest()
    {
        $validation = 0;
        foreach($this->input->post() as $name => $value) {
            if(substr($name, 0, 5) == "order") {
                if($value >= 1) {
                    $validation = 1;
                }
            }
        }
        if($validation == 0)
            return FALSE;

        foreach($this->input->post() as $name => $value) {
            if(substr($name, 0, 5) == "order") {
                if($value >= 1) {
                    list( , $part_id) = explode('_', $name);



                    $part = $this->db->where('id', $part_id)->get('part_imprest_lists')->row_array();
                    // need to change the number (second parameter)
                    $lookup = $this->lookup_price($part['part_number'], 1, $this->data['user']['company']['id'], $value);
//                    $list = $this->part_list_model->get($part['part_list_id']);

                    $cart_data[] = array(
                        'id'      => $part['id'], 
                        'qty'     => $value, // validate?
                        'price'   => $lookup['price'],
                        'name'    => $part['part_number'],
                        'options' => array(
                            'pnumber' => $part['part_number'],
                        )
                    );

                }
            }
        }

        $this->cart->destroy();
        $this->cart->insert($cart_data);

        return TRUE;
    }

    function post_order()
    {
        // resolve delivery address
        $address_id = $this->input->post('sel_addr');
        if($address_id == 'new')
        {
            $address_id = $this->address_model->insert(array(
                'user_id' => $this->data['user']['id'],
                'company_id' => $this->data['user']['company']['id'],
                'name' => $this->input->post('del_name'),
                'address_1' => $this->input->post('del_address1'),
                'address_2' => $this->input->post('del_address2'),
                'citytown' => $this->input->post('del_citytown'),
                'county' => $this->input->post('del_county'),
                'postcode' => $this->input->post('del_postcode')
            ));
        }
        // add the order
        $order = array(
            'user_id' => $this->data['user']['id'],
            'company_id' => $this->data['user']['company']['id'],
            'time' => time(),
            'addresses_id' => $address_id,
            'status' => 3,
            'reg_no' => $this->input->post('reg'),
            'chassis_number' => $this->input->post('chassis_number'),
            'order_no' => $this->input->post('order_number'),
            'quote' => 0
        );
        $this->db->insert('part_orders', $order); 
        $order_id = $this->db->insert_id();

        foreach($this->cart->contents() as $checkout_item)
        {
            $part = $this->part_list_part_model->get($checkout_item['id']);
            $lookup = $this->lookup_price($part['pnumber'], $part['manufacturer_id'], $this->data['user']['company']['id'], $value);
            $list = $this->part_list_model->get($part['part_list_id']);

            $order_item = array(
                'orders_id' => $order_id,
                'part_id' => $part['id'],
                'manufacturer_id' => $part['manufacturer_id'],
                'pnumber' => $part['pnumber'],
                'description' => $part['description'],
                'list_id' => $list['id'],
                'quantity' => $checkout_item['qty'],
                'price' => $lookup['price']
            );

            $this->db->insert('part_orders_items', $order_item);
        }

        $this->notify($this->data['user']['company']['id'], $this->data['user']['id'], 'order');

        $this->cart->destroy();

        return $order_id;
    }

    function notify($company_id, $user_id, $event)
    {
        $user = $this->user_model
            ->with('company')
            ->get($user_id);

        $site = $this->db
            ->select('part_orders_sites.*, part_orders_groups.email as email')
            ->where('part_orders_sites.user_id', $user_id)
            ->join('part_orders_groups', 'part_orders_sites.group_id = part_orders_groups.id')
            ->get('part_orders_sites')
            ->row_array();

        switch($event)
        {
        case 'order':
            $email = array(
                'title' => 'Order',
                'content' => 'New ' . $user['company']['name'] . ' ' . $user['fullname'] . ' order.'
            );
            break;
        case 'quote':
            $email = array(
                'title' => 'Quote Order',
                'content' => 'New ' . $user['company']['name'] . ' ' . $user['fullname'] . ' quote order.'
            );
            break;
        case 'quote_reply':
            $email = array(
                'title' => 'Quote Sent for Order',
                'content' => 'New ' . $user['company']['name'] . ' ' . $user['fullname'] . ' has replied to quote order.'
            );
            break;

        }

        $email['to'] = $site['email'];

        mail($email['to'], $email['title'], $email['content'], 'From: No Reply <sbcommercialsplc@gmail.com>' . "\r\n" . 'X-Mailer: PHP/' . phpversion());
    }

    // this has just been thrown in from the old site,
    // i know its awful i dont know where it came from...
    function getExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }

    function post_quote($manufacturer_id)
    {
        // resolve delivery address
        $address_id = $this->input->post('sel_addr');
        if($address_id == 'new')
        {
            $address_id = $this->address_model->insert(array(
                'user_id' => $this->data['user']['id'],
                'company_id' => $this->data['user']['company']['id'],
                'name' => $this->input->post('del_name'),
                'address_1' => $this->input->post('del_address1'),
                'address_2' => $this->input->post('del_address2'),
                'citytown' => $this->input->post('del_citytown'),
                'county' => $this->input->post('del_county'),
                'postcode' => $this->input->post('del_postcode')
            ));
        }

        /*
         * add image, this was copied over from the old system
         * and i did not have time to rewrite it. need to use 
         * CI built in upload really
         */
        if($_FILES['image']['name'])
        {
            $filename = stripslashes($_FILES['image']['name']);
            $extension = $this->getExtension($filename);
            $extension = strtolower($extension);
            $allowed = array('pdf', 'jpg', 'jpeg', 'png', 'gif');
            if(in_array($extension, $allowed))
            {
                $image_name = time() . '.' . $extension;
                $newname = FCPATH . "/assets/doc/parts/" . $image_name;
                $copied = copy($_FILES['image']['tmp_name'], $newname);
            }
        }
        else
        {
            $image_name = '';
        }

        $storder = ($this->input->post('storder') == 'yes') ? 1 : 0;
        $status = ($this->input->post('storder') == 'yes') ? 3 : 1;

        // add the order
        $order = array(
            'user_id' => $this->data['user']['id'],
            'company_id' => $this->data['user']['company']['id'],
            'time' => time(),
            'addresses_id' => $address_id,
            'status' => $status,
            'order_no' => $this->input->post('order_number'),
            'reg_no' => $this->input->post('reg'),
            'chassis_number' => $this->input->post('chassis_number'),
            'quote' => 1,
            'quote_text' => $this->input->post('shopping_list'),
            'quote_vehicle' => $this->input->post('reg') . ' - ' . $this->input->post('chassis_number'),
            'quote_image' => $image_name,
            'storder' => $storder
        );

        $this->db->insert('part_orders', $order); 
        $order_id = $this->db->insert_id();

        // add quote parts
        foreach($this->input->post() as $name => $value) {
            if(strpos($name, '_') === FALSE) {
                continue;
            }
            list($list_name, $list_id) = explode('_', $name);
            if($list_name == 'part' && $list_id && strlen($value) > 1) {
                $qty = $this->input->post('quantity_' . $list_id);
                if($qty >= 1) {
                    $part = $this->lookup_price($value, $manufacturer_id, $this->data['user']['company']['id'], $qty);
                    if($part) {
                        $order_item = array(
                            'orders_id' => $order_id,
                            'price' => $part['price'],
                            'quantity' => $qty,
                            'quote_pnumber' => $part['pnumber'],
                            'quote_description' => $part['title']
                        );
                    }
                    else
                    {
                        $order_item = array(
                            'orders_id' => $order_id,
                            'price' => 0,
                            'quantity' => $qty,
                            'quote_pnumber' => $value,
                            'quote_description' => 'AWAIT QUOTE'
                        );
                    }

                    $this->db->insert('part_orders_items', $order_item);
                }
            }
        }

        $this->notify($this->data['user']['company']['id'], $this->data['user']['id'], 'quote');

        return $order_id;
    }

    /*
     * DEFAULTS TO MB, NEEDS UPDATE WITH THE MANUFACTURER ID LINE
     */
    function post_imprest()
    {
        $validation = 0;
        foreach($this->input->post() as $name => $value) {
            if(substr($name, 0, 5) == "order") {
                if($value >= 1) {
                    $validation = 1;
                }
            }
        }
        if($validation == 0)
            return NULL;

        // add the order
        $order = array(
            'user_id' => $this->data['user']['id'],
            'company_id' => $this->data['user']['company']['id'],
            'time' => time(),
            'addresses_id' => $this->data['user']['default_address'],
            'status' => 3,
            'order_no' => 'Imprest Stock',
            'quote' => 0,
            'impress' => 1,
        );

        $this->db->insert('part_orders', $order); 
        $order_id = $this->db->insert_id();

        foreach($this->input->post() as $name => $value) {
            if(substr($name, 0, 5) == "order") {
                if($value >= 1) {
                    list( , $part_id) = explode('_', $name);



                    $part = $this->db->where('id', $part_id)->get('part_imprest_lists')->row_array();
                    // need to change the number (second parameter)
                    $lookup = $this->lookup_price($part['part_number'], 1, $this->data['user']['company']['id'], $value);
                    $list = $this->part_list_model->get($part['part_list_id']);

                    $order_item = array(
                        'orders_id' => $order_id,
                        'part_id' => $part['id'],
                        'manufacturer_id' => 1,
                        'pnumber' => $part['part_number'],
                    //    'description' => $part['description'],
                    //    'list_id' => $list['id'],
                        'quantity' => $value,
                        'price' => $lookup['price']
                    );

                    $this->db->insert('part_orders_items', $order_item);
                }
            }
        }

        $this->notify($this->data['user']['company']['id'], $this->data['user']['id'], 'order');

        return $order_id;
    }

    function get_order($company_id, $user_id, $order_id)
    {
        $order = $this->db
            ->where('part_orders.id', $order_id)
            ->where('part_orders.user_id', $user_id)
            ->where('part_orders.company_id', $company_id)
            ->get('part_orders')
            ->row_array();

        $this->load->model('note_model');
        $order['address'] = $this->address_model->get($order['addresses_id']);
        $order['notes'] = $this->note_model->get_many_by(array(
            'module_id' => $this->module_id,
            'row_id' => $order['id']
        ));

        $order['order_items'] = $this->db
            ->where('orders_id', $order['id'])
            ->get('part_orders_items')
            ->result_array();

        return $order;
    }

    function order_confirm_quote($order_id) {
        // LOOP POSTS AND UPDATE QUANTITYS
        foreach($this->input->post() as $name => $value) {
            if(substr($name, 0, 2) == "bb") {
                $inputid = explode('_', $name);
                $itemuid = $inputid[1];
                $this->db
                    ->where('unique_id', $itemuid)
                    ->update('part_orders_items', array('quantity' => $value)); 
            }
        }
        // UPDATE ORDER STATUS & ORDER NO
        $data = array(
            'status' => 3,
            'order_no' => $this->input->post('order_number')
        );
        $this->db
            ->where('id', $order_id)
            ->update('part_orders', $data); 

        $this->notify($this->data['user']['company']['id'], $this->data['user']['id'], 'quote_reply');
        return;
    }

    function get_part_orders_statuses() {
        return $this->db
            ->get('part_orders_statuses')
            ->result_array();
    }

    function get_orders($company_id, $user_id, $status_id = NULL) {
        $this->db
            ->where('user_id', $user_id)
            ->where('company_id', $company_id);

        if($status_id !== NULL) {
            $this->db->where('status', $status_id);
        }

        $orders = $this->db
            ->order_by('time', 'desc')
            ->get('part_orders')
            ->result_array();

        foreach($orders as &$order) {
            $sum = $this->db
                ->query('SELECT SUM(quantity * price) as value FROM `part_orders_items` WHERE `orders_id` = ' . $order['id'])
                ->row_array();
            $order['value'] = $sum['value'];
        }

        return $orders;
    }


    /*
    function stock_check($part_number) {
        $adp_sites = array(
            'WG' => 1,
            'ST' => 3,
            'TH' => 4,
        );

        // find out our site which user is ordering from
        if(isset($this->data['user'])) {
            $order_site = $this->db
                ->where('sbdirect_user_id', $this->data['user']['id'])
                ->get('part_orders_sites')
                ->row_array();
        }
        $location = (isset($order_site['dispatched_from'])) ? $order_site['dispatched_from'] : 'WG';

        // clean up the part number
        $part_number = str_replace(" ", "", $part_number);
        $part_number = str_replace("/", "", $part_number);
        // lookup
        $part = $this->db
            ->where('pnumber', $part_number)
            ->limit(1)
            ->get('part_adp')
            ->row_array();

    /* if no result and the first letter of part number isnt 'A',
    lookup again with an 'A' (some people forget the leading A) 
        if(empty($part) && substr($part_number, 0, 1) != 'A') { 
            $part = $this->db
                ->where('pnumber', 'A' . $part_number)
                ->limit(1)
                ->get('part_adp')
                ->row_array();
        }

        if(empty($part)) {
            return array(
                'local' => 0,
                'group' => 0,
                'norecord' => 1,
            );
        }

        $group_stock = 0;
        foreach(range(1, 7) as $site_no) {
            $group_stock += $part['stock_0' . $site_no];
        }

        return array(
            'local' => round($part['stock_0' . $adp_sites[$location]]),
            'group' => round($group_stock),
        );

    }
     */

}
//EOF
