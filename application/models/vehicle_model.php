<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Vehicle_model extends MY_Model {

    public $before_create = array( 'created_at', 'updated_at' );

    public $protected_attributes = array( 'id' );

//    public $has_many = array( 'user' );

    public function get_all() {
        $data = $this->db
            ->order_by("created_at", "asc")
            ->where('sold', 0)
            ->where('active_status', 1)
            ->get('vehicles')
            ->result_array();

        foreach($data as &$row) {
            $row['price_month'] = ceil($row['price_month']);
            $row['additional_images'] = $this->db
                ->where('vehicle_id', $row['id'])
                ->get('vehicle_additional_images')
                ->result_array();

            // build seo url
            $title = $row['manufacturer_text'] . ' '. $row['model_text'];
            $title = explode(' ', $title);
            $url = '';
            foreach($title as $sec) {
                if(preg_match("/\\d/", $sec) == 0) { // if no numbers
                    $url .= ' ' . strtolower($sec);
                }
            }
            $row['url'] = $row['id'] . '-' . url_title($url);
        }

        return $data;
    }

    public function get_all_by_location($location_id) {
        $data = $this->db
            ->select("*")
            ->order_by("created_at", "asc")
            ->where('sold', 0)
            ->where('active_status', 1)
            ->where('location_id', $location_id)
            ->get('vehicles')
            ->result_array();

        foreach($data as &$row) {
            $row['price_month'] = ceil($row['price_month']);
            $row['additional_images'] = $this->db
                ->where('vehicle_id', $row['id'])
                ->get('vehicle_additional_images')
                ->result_array();

            // build seo url
            $title = $row['manufacturer_text'] . ' '. $row['model_text'];
            $title = explode(' ', $title);
            $url = '';
            foreach($title as $sec) {
                if(preg_match("/\\d/", $sec) == 0) { // if no numbers
                    $url .= ' ' . strtolower($sec);
                }
            }
            $row['url'] = $row['id'] . '-' . url_title($url);
        }

        return $data;
    }

    public function get_all_search($type, $sort_by, $sort_order) {
        
        $sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
        
        // build the search query
        $type = preg_replace('/\D/', '', $type);
        $where = "sold = 0 AND active_status = 1";
       
        if($type <= 2) { // van or truck
            $where .= " AND type_id = " . $type;
        }
        else if($type == 3) { // ford
            $where .= " AND vehicles.manufacturer = 296";
        }
        

        $data = $this->db->select('vehicles.*,  locations.address, locations.phone')
                        ->from('vehicles')
                        ->join('locations', "vehicles.location_id = locations.id")
                        ->where($where)
                        ->order_by($sort_by, $sort_order)
                        ->get()
                        ->result_array();            


        /*$data = $this->db
            ->order_by("created_at", "asc")
            ->where($where)
            ->join('locations', "vehicles.location_id = locations.id")
            ->get('vehicles')
            ->result_array();
        */
        // loop the data and some some more joins
        foreach($data as &$row) {
            $row['price_month'] = ceil($row['price_month']);
            $row['additional_images'] = $this->db
                ->where('vehicle_id', $row['id'])
                ->get('vehicle_additional_images')
                ->result_array();

            // build seo url
            $title = $row['manufacturer_text'] . ' '. $row['model_text'];
            $title = explode(' ', $title);
            $url = '';
            foreach($title as $sec) {
                if(preg_match("/\\d/", $sec) == 0) { // if no numbers
                    $url .= ' ' . strtolower($sec);
                }
            }
            $row['url'] = $row['id'] . '-' . url_title($url);
        }

        return $data;
    }

    public function get($id) {
        $row = parent::get($id);

        $row['price_month'] = ceil($row['price_month']);
        $row['additional_images'] = $this->db
            ->where('vehicle_id', $id)
            ->order_by('sort')
            ->get('vehicle_additional_images')
            ->result_array();
        
        return $row;
    }

    public function get_by_body($id) {
        $data = $this->db
            ->where('body_type_id', $id)
            ->where('sold', 0)
            ->where('active_status', 1)
            ->order_by("priority", "desc")
            ->get('vehicles')
            ->result_array();

        foreach($data as &$row) {
            $row['price_month'] = ceil($row['price_month']);
            $row['additional_images'] = $this->db
                ->where('vehicle_id', $row['id'])
                ->get('vehicle_additional_images')
                ->result_array();

            // build seo url
            $title = $row['manufacturer_text'] . ' '. $row['model_text'];
            $title = explode(' ', $title);
            $url = '';
            foreach($title as $sec) {
                if(preg_match("/\\d/", $sec) == 0) { // if no numbers
                    $url .= ' ' . strtolower($sec);
                }
            }
            $row['url'] = $row['id'] . '-' . url_title($url);
        }

        return $data;
    }

    public function get_also_viewed($vehicle_id, $limit = 3) {
        $vehicle = $this->vehicle_model->get($vehicle_id);

        $data = $this->db
            ->where('sold', 0)
            ->where('active_status', 1)
            ->where('model_text LIKE', $vehicle['model_text'])
            ->where('id !=', $vehicle['id'])
            ->order_by("priority", "desc")
            ->limit($limit)
            ->get('vehicles')
            ->result_array();

        if(empty($data)) {
            return NULL;
        }

        foreach($data as &$row) {
            $row['price_month'] = ceil($row['price_month']);
            $row['additional_images'] = $this->db
                ->where('vehicle_id', $row['id'])
                ->get('vehicle_additional_images')
                ->result_array();

            // build seo url
            $title = $row['manufacturer_text'] . ' '. $row['model_text'];
            $title = explode(' ', $title);
            $url = '';
            foreach($title as $sec) {
                if(preg_match("/\\d/", $sec) == 0) { // if no numbers
                    $url .= ' ' . strtolower($sec);
                }
            }
            $row['url'] = $row['id'] . '-' . url_title($url);
        }

        return $data;
    }

    public function get_by_manufacturer($id) {
        $data = $this->db
            ->where('manufacturer', $id)
            ->where('sold', 0)
            ->where('active_status', 1)
            ->order_by("priority", "desc")
            ->get('vehicles')
            ->result_array();

        foreach($data as &$row) {
            $row['price_month'] = ceil($row['price_month']);
            $row['additional_images'] = $this->db
                ->where('vehicle_id', $row['id'])
                ->get('vehicle_additional_images')
                ->result_array();

            // build seo url
            $title = $row['manufacturer_text'] . ' '. $row['model_text'];
            $title = explode(' ', $title);
            $url = '';
            foreach($title as $sec) {
                if(preg_match("/\\d/", $sec) == 0) { // if no numbers
                    $url .= ' ' . strtolower($sec);
                }
            }
            $row['url'] = $row['id'] . '-' . url_title($url);
        }

        return $data;
    }

    public function get_all_autotrader() {
        $data = $this->db
            ->select('vehicles.*, locations.autotrader_did')
            ->from('vehicles')
            ->join('locations', 'vehicles.location_id = locations.id')
            ->order_by("priority", "desc")
            ->where('sold', 0)
            ->where('active_status', 1)
            ->where('autotrader_did !=', 0)
            ->get()
            ->result_array();

        foreach($data as &$row) {
            $row['price_month'] = ceil($row['price_month']);
            $row['additional_images'] = $this->db
                ->where('vehicle_id', $row['id'])
                ->get('vehicle_additional_images')
                ->result_array();

            // build seo url
            $title = $row['manufacturer_text'] . ' '. $row['model_text'];
            $title = explode(' ', $title);
            $url = '';
            foreach($title as $sec) {
                if(preg_match("/\\d/", $sec) == 0) { // if no numbers
                    $url .= ' ' . strtolower($sec);
                }
            }
            $row['url'] = $row['id'] . '-' . url_title($url);
        }

        return $data;
    }

    public function get_all_cargurus() {
        $data = $this->db
            ->select('vehicles.*, locations.autotrader_did')
            ->from('vehicles')
            ->join('locations', 'vehicles.location_id = locations.id')
            ->order_by("priority", "desc")
            ->where('sold', 0)
            ->where('active_status', 1)
            ->get()
            ->result_array();

        foreach($data as &$row) {
            $row['price_month'] = ceil($row['price_month']);
            $row['additional_images'] = $this->db
                ->where('vehicle_id', $row['id'])
                ->get('vehicle_additional_images')
                ->result_array();

            // build seo url
            $title = $row['manufacturer_text'] . ' '. $row['model_text'];
            $title = explode(' ', $title);
            $url = '';
            foreach($title as $sec) {
                if(preg_match("/\\d/", $sec) == 0) { // if no numbers
                    $url .= ' ' . strtolower($sec);
                }
            }
            $row['url'] = $row['id'] . '-' . url_title($url);
        }

        return $data;
    }

    public function get_body_types() {
        $data = $this->db
            ->get('vehicle_body_types')
            ->result_array();

        $body_types = array();

        // make it drop down compatible
        foreach($data as $row) { 
            $body_types[$row['id']] = $row['name'];
        }

        return $body_types;
    }

    public function get_types($include_ford = FALSE) {
        $vehicle_types = array(
            1 => array('id' => 1, 'name' => 'Van', 'url' => 'vans'),
            2 => array('id' => 2, 'name' => 'Truck', 'url' => 'trucks'),
        );
        if($include_ford == TRUE) {
            $vehicle_types[3] = array(
                'id' => 3,
                'name' => 'Ford',
                'url' => 'ford',
            );
        }

        return $vehicle_types;
    }

    /*
     * CAP reg lookup function. June 2015
     *
     * If succesful lookup will return array with vehicle details, NULL otherwise.
     *
     * @param string
     * @return Array
     */
    public function lookup($reg) {
        $reg = preg_replace('#\W#', '', $reg); // validation, only alphanumerical
        // check db cache, see if this reg has been looked up before

        $subscriber_id = 156343;
        $password = '343Imp';

        // perform lookup at CAP
        $cap_address = file_get_contents("http://webservices.capnetwork.co.uk/CAPDVLA_Webservice/CAPDVLA.asmx/DVLALookupVRM?SubscriberID=" . $subscriber_id . "&Password=" . $password . "&vrm=" . $reg);
        $xml = @simplexml_load_string($cap_address);

        if($xml->MATCHLEVEL->DVLA == 1) {

            $first_reg = (string) $xml->DATA->DVLA->FIRSTREG_DATE; 
            $first_reg = (ctype_space($first_reg) || $first_reg == '') ? (string) $xml->DATA->DVLA->REGISTRATIONDATE : $first_reg;
            $first_reg = date_create_from_format('Ymd', $first_reg);
            $first_reg_db = date_format($first_reg, "Y-m-d");
            $formatted_lookup = array(
                'first_reg_uk' => date_format($first_reg, "d/m/y"),
                'make_model' => (string) $xml->DATA->DVLA->MANUFACTURER . ' ' . (string) $xml->DATA->DVLA->MODEL,
                'body_type' => (string) $xml->DATA->DVLA->BODYTYPE,
                'engine' => (string) $xml->DATA->DVLA->ENGINECAPACITY,
                'colour' => (string) $xml->DATA->DVLA->COLOUR,
                'wheelbase' => (string) $xml->DATA->DVLA->WHEELPLAN,
                'gearbox' => strtolower((string) $xml->DATA->CAP->TRANSMISSION),
                'vin' => (string) $xml->DATA->DVLA->VIN,
                'seats' => (string) $xml->DATA->DVLA->SEATING,

                'MANUFACTURER_CODE' => (string) $xml->DATA->CAP->MANUFACTURER_CODE,
                'MANUFACTURER' => (string) $xml->DATA->CAP->MANUFACTURER,
                'RANGE_CODE' => (string) $xml->DATA->CAP->RANGE_CODE,
                'RANGE' => (string) $xml->DATA->CAP->RANGE,
                'MODEL_CODE' => (string) $xml->DATA->CAP->MODEL_CODE,
                'MODEL' => (string) $xml->DATA->CAP->MODEL,
                'MODELDATEDESC_SHORT' => (string) $xml->DATA->CAP->MODELDATEDESC_SHORT,
                'MODELDATEDESC_LONG' => (string) $xml->DATA->CAP->MODELDATEDESC_LONG,
                'DERIVATIVE' => (string) $xml->DATA->CAP->DERIVATIVE,
                'DERIVATIVEDATEDESC_SHORT' => (string) $xml->DATA->CAP->DERIVATIVEDATEDESC_SHORT,
                'DERIVATIVEDATEDESC_LONG' => (string) $xml->DATA->CAP->DERIVATIVEDATEDESC_LONG,
                'INTRODUCED' => (string) $xml->DATA->CAP->INTRODUCED,
                'DISCONTINUED' => (string) $xml->DATA->CAP->DISCONTINUED,
                'RUNOUTDATE' => (string) $xml->DATA->CAP->RUNOUTDATE,
                'DOORS' => (string) $xml->DATA->CAP->DOORS,
                'DRIVETRAIN' => (string) $xml->DATA->CAP->DRIVETRAIN,
                'FUELDELIVERY' => (string) $xml->DATA->CAP->FUELDELIVERY,
                'TRANSMISSION' => (string) $xml->DATA->CAP->TRANSMISSION,
                'FUELTYPE' => (string) $xml->DATA->CAP->FUELTYPE,
                'PLATE' => (string) $xml->DATA->CAP->PLATE,
                'PLATE_SEQNO' => (string) $xml->DATA->CAP->PLATE_SEQNO,
                'PLATE_YEAR' => (string) $xml->DATA->CAP->PLATE_YEAR,
                'PLATE_MONTH' => (string) $xml->DATA->CAP->PLATE_MONTH,
            );
            $lookup = array(
                'reg' => $reg,
                'vin' => $formatted_lookup['vin'],
                'xml_dump' => $xml->asXML(),
            );
            //$this->db->insert('vehicles_lookups', $lookup);

            return $formatted_lookup;
        }
        
        // CAP lookup failed, cache in DB
//        $stmt = 'INSERT INTO `vehicles_lookups` (reg, failed) VALUES (?, ?)';
//        $this->db->query($stmt, array($reg, 1));
        return NULL;
    }
    
    public function get_manufacturers($type_id) {
        if($type_id == 1) { // vans and fords
            $models = $this->db
                ->query('SELECT DISTINCT model_text, manufacturer,
                    manufacturer_text FROM vehicles WHERE sold = 0 AND active_status = 1 AND type_id = 1 ORDER BY manufacturer')
                ->result_array();
        }
        else if($type_id == 2) { // truck, only truck
            $models = $this->db
                ->query('SELECT DISTINCT model_text, manufacturer,
                    manufacturer_text FROM vehicles WHERE sold = 0 AND active_status = 1 AND type_id = 2 ORDER BY manufacturer')
                ->result_array();
        }
        else { // jus fords
            $models = $this->db
                ->query('SELECT DISTINCT model_text, manufacturer,
                    manufacturer_text FROM vehicles WHERE sold = 0 AND active_status = 1 AND manufacturer = 296 ORDER BY manufacturer')
                ->result_array();
        }

        $last_manufacturer = NULL;
        $manufacturers = array();
        foreach($models as $model) {
            if(empty($model['manufacturer_text'])) {
                continue;
            }

            if($model['manufacturer'] == $last_manufacturer) {
                continue;
            }
            else {
                $manufacturers[] = array(
                    'id' => $model['manufacturer'],
                    'name' => $model['manufacturer_text'],
                );
            }
            $last_manufacturer = $model['manufacturer'];
        }

        return $manufacturers;
    }

    public function get_make_models($type_id) {
        if($type_id == 1) { // vans and fords
            $models = $this->db
                ->query("SELECT DISTINCT vehicle_model.model_text, vehicle_model.manufacturer,  vehicle_model.manufacturer_text 
                        FROM vehicle_model
                        JOIN vehicles on vehicle_model.id = vehicles.model_id
                        WHERE vehicles.sold = 0 AND vehicles.active_status = 1 AND vehicles.type_id = $type_id 
                        ORDER BY vehicle_model.manufacturer")
                ->result_array();
        }
        else if($type_id == 2) { // truck, only truck
            $models = $this->db
                ->query("SELECT DISTINCT vehicle_model.model_text, vehicle_model.manufacturer,  vehicle_model.manufacturer_text 
                        FROM vehicle_model
                        JOIN vehicles on vehicle_model.id = vehicles.model_id
                        WHERE vehicles.sold = 0 AND vehicles.active_status = 1 AND vehicles.type_id = $type_id 
                        ORDER BY vehicle_model.manufacturer")
                ->result_array();
        }
        else { // just fords
            $models = $this->db
                ->query("SELECT DISTINCT vehicle_model.model_text, vehicle_model.manufacturer,  vehicle_model.manufacturer_text 
                        FROM vehicle_model
                        JOIN vehicles on vehicle_model.id = vehicles.model_id
                        WHERE vehicles.sold = 0 AND vehicles.active_status = 1 AND vehicles.manufacturer = 296 
                        ORDER BY vehicle_model.manufacturer")
                ->result_array();
        }

        /*
        //This are the old queries when the vehicle_models didn't exist
        if($type_id == 1) { // vans and fords
            $models = $this->db
                ->query('SELECT DISTINCT model_text, manufacturer,
                    manufacturer_text FROM vehicles WHERE sold = 0 AND active_status = 1 AND type_id = 1 ORDER BY manufacturer')
                ->result_array();
        }
        else if($type_id == 2) { // truck, only truck
            $models = $this->db
                ->query('SELECT DISTINCT model_text, manufacturer,
                    manufacturer_text FROM vehicles WHERE sold = 0 AND active_status = 1 AND type_id = 2 ORDER BY manufacturer')
                ->result_array();
        }
        else { // just fords
            $models = $this->db
                ->query('SELECT DISTINCT model_text, manufacturer,
                    manufacturer_text FROM vehicles WHERE sold = 0 AND active_status = 1 AND manufacturer = 296 ORDER BY manufacturer')
                ->result_array();
        }
        */

        // build a multidimensional array containing manufacturers and then 
        // the models
        $last_manufacturer = NULL;
        $make_models = array();
        foreach($models as $model) {
            if(empty($model['manufacturer_text'])) {
                continue;
            }

            if($model['manufacturer'] == $last_manufacturer) {
                $make_models[$model['manufacturer']]['models'][] = array(
                    'model' => $model['model_text'],
                );
            }
            else {
                $make_models[$model['manufacturer']] = array(
                    'manufacturer' => $model['manufacturer_text'],
                    'models' => array(),
                );
                $make_models[$model['manufacturer']]['models'][] = array(
                    'model' => $model['model_text'],
                );
            }
            $last_manufacturer = $model['manufacturer'];
        }

        return $make_models;
    }


    // sold stuff?
    public function get_transmission($ford_only = 0) { 
        if($ford_only == 0) {
            $transmissions = $this->db
                ->query('SELECT DISTINCT transmission FROM vehicles WHERE transmission != "" AND sold = 0')
                ->result_array();
        }
        else {
            $transmissions = $this->db
                ->query('SELECT DISTINCT transmission FROM vehicles WHERE manufacturer = 296 AND transmission != "" AND sold = 0')
                ->result_array();
        }

        return $transmissions;
    }
    public function get_locations($type_id) { 
        if($type_id != 3) {
            $locations = $this->db
                ->query('SELECT DISTINCT vehicles.location_id, locations.* FROM vehicles
                JOIN locations on vehicles.location_id = locations.id
                WHERE vehicles.sold = 0 AND vehicles.active_status = 1 AND vehicles.type_id = ' . $type_id . ' ORDER BY locations.name ASC')
                ->result_array();
        }
        else {
            $locations = $this->db
                ->query('SELECT DISTINCT vehicles.location_id, locations.* FROM vehicles
                JOIN locations on vehicles.location_id = locations.id
                 WHERE vehicles.sold = 0 AND vehicles.active_status = 1 AND vehicles.manufacturer = 296 ORDER BY locations.name ASC')
                ->result_array();
        }

        return $locations;
    }
    public function get_prices() {
        $from = array(
            '0' => '&pound;0',
            '500' => '&pound;500',
            '1000' => '&pound;1,000',
            '1500' => '&pound;1,500',
            '2000' => '&pound;2,000',
            '2500' => '&pound;2,500',
            '3000' => '&pound;3,000',
            '3500' => '&pound;3,500',
            '4000' => '&pound;4,000',
            '4500' => '&pound;4,500',
            '5000' => '&pound;5,000',
            '5500' => '&pound;5,500',
            '6000' => '&pound;6,000',
            '6500' => '&pound;6,500',
            '7000' => '&pound;7,000',
            '7500' => '&pound;7,500',
            '8000' => '&pound;8,000',
            '8500' => '&pound;8,500',
            '9000' => '&pound;9,000',
            '9500' => '&pound;9,500',
            '10000' => '&pound;10,000',
            '11000' => '&pound;11,000',
            '12000' => '&pound;12,000',
            '13000' => '&pound;13,000',
            '14000' => '&pound;14,000',
            '15000' => '&pound;15,000',
            '16000' => '&pound;16,000',
            '17000' => '&pound;17,000',
            '18000' => '&pound;18,000',
            '19000' => '&pound;19,000',
            '20000' => '&pound;20,000',
            '22500' => '&pound;22,500',
            '25000' => '&pound;25,000',
            '27500' => '&pound;27,500',
            '30000' => '&pound;30,000',
            '35000' => '&pound;35,000',
            '40000' => '&pound;40,000',
        );

        $to = array(
            '500' => '&pound;500',
            '1000' => '&pound;1,000',
            '1500' => '&pound;1,500',
            '2000' => '&pound;2,000',
            '2500' => '&pound;2,500',
            '3000' => '&pound;3,000',
            '3500' => '&pound;3,500',
            '4000' => '&pound;4,000',
            '4500' => '&pound;4,500',
            '5000' => '&pound;5,000',
            '5500' => '&pound;5,500',
            '6000' => '&pound;6,000',
            '6500' => '&pound;6,500',
            '7000' => '&pound;7,000',
            '7500' => '&pound;7,500',
            '8000' => '&pound;8,000',
            '8500' => '&pound;8,500',
            '9000' => '&pound;9,000',
            '9500' => '&pound;9,500',
            '10000' => '&pound;10,000',
            '11000' => '&pound;11,000',
            '12000' => '&pound;12,000',
            '13000' => '&pound;13,000',
            '14000' => '&pound;14,000',
            '15000' => '&pound;15,000',
            '16000' => '&pound;16,000',
            '17000' => '&pound;17,000',
            '18000' => '&pound;18,000',
            '19000' => '&pound;19,000',
            '20000' => '&pound;20,000',
            '22500' => '&pound;22,500',
            '25000' => '&pound;25,000',
            '27500' => '&pound;27,500',
            '30000' => '&pound;30,000',
            '35000' => '&pound;35,000',
            '40000' => '&pound;40,000',
        );

        return array(
            'from' => $from,
            'to' => $to,
        );
    }

    public function search_construct_url($type_url) {

            $url = '/used/search/' . $type_url;

            if(! empty($this->input->post('postcode')) )
                $url .= '/postcode/' . $this->input->post('postcode');
            if(! empty($this->input->post('manufacturer')) )
                $url .= '/manufacturer/' . $this->input->post('manufacturer');
            if(! empty($this->input->post('model')) )
                $url .= '/model/' . $this->input->post('model');
            if(! empty($this->input->post('transmission')) )
                $url .= '/transmission/' . $this->input->post('transmission');
            if(! empty($this->input->post('price-from')) )
                $url .= '/from/' . $this->input->post('price-from');
            if(! empty($this->input->post('price-to')) )
                $url .= '/to/' . $this->input->post('price-to');
            if(! empty($this->input->post('location')) )
                $url .= '/location/' . $this->input->post('location');

            return $url;
    }

    public function search_vehicles_from_url() {

        $types = $this->get_types();

        $where = "sold = 0 AND active_status = 1";
        $error = 0;
        $ford_only = 0;

        for($i = 3; $i < 50; ++$i) {
            if($this->uri->segment($i) == NULL)
                break;
            switch($this->uri->segment($i)) {
                case 'vans':
                    $where .= " AND type_id = 1";
                    break;
                case 'trucks':
                    $where .= " AND type_id = 2";
                    break;
                case 'ford':
                    $where .= " AND manufacturer = 296";
                    $ford_only = 1;
                    break;
                case 'postcode':
                    // geocode the address where they are
                    $this->load->model('location_model');
                    $postcode = urldecode($this->uri->segment($i + 1));
                    $geocode = $this->location_model->geocode($postcode);
                    if(empty($geocode)) {
                        return NULL;
                    }
                    break;
                case 'manufacturer':
                    $man_id = preg_replace('/\D/', '', $this->uri->segment($i + 1));
                    if($ford_only == 0) {
                        $where .= " AND vehicles.manufacturer = " . $man_id;
                    }
                    continue 2;
                    break;
                case 'model':
                    $where .= " AND model_text LIKE '%" . urldecode($this->uri->segment($i + 1)) . "%'";
                    continue 2;
                    break;
                case 'transmission':
                    $where .= " AND transmission = '" . urldecode($this->uri->segment($i + 1)) . "'";
                    continue 2;
                    break;
                case 'from':
                    $from = preg_replace('/\D/', '', $this->uri->segment($i + 1));
                    $where .= "  AND price >= " . $from;
                    continue 2;
                    break;
                case 'to':
                    $to = preg_replace('/\D/', '', $this->uri->segment($i + 1));
                    $where .= " AND price <= " . $to;
                    continue 2;
                    break;
                case 'location':
                    $where .= " AND location_id = " . urldecode($this->uri->segment($i + 1));
                    continue 2;
                    break;
            }
        }
        
        // load the vehicles
        if(empty($geocode)) {
            $vehicles = $this->db
                    ->select("vehicles.*, locations.name, locations.address, locations.phone ")
                    ->join('locations', "vehicles.location_id = locations.id")
                    ->where($where)
                    ->get('vehicles')->result_array();
                   
                    
                    
        }
        else {
            // if we have geocode (i.e. postcode search) then use this select statement
            $query = sprintf("
                SELECT vehicles.*, locations.address, locations.phone, locations.name as location_name, locations.manufacturer as location_manufacturer,
                    ( 3959 * acos( cos( radians('%s') ) * cos( radians( locations.lat ) ) * cos( radians( locations.lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( locations.lat ) ) ) ) AS location_distance
                FROM locations JOIN vehicles ON locations.id = vehicles.location_id
                WHERE " . $where . " HAVING location_distance < '%s' ORDER BY location_distance LIMIT 0 , 40",
              mysql_real_escape_string($geocode['lat']),
              mysql_real_escape_string($geocode['lng']),
              mysql_real_escape_string($geocode['lat']),
              mysql_real_escape_string(838)); // 838 is nationwide
            $vehicles = $this->db->query($query)->result_array();
            //echo $this->db->last_query();
            //print_r($geocode);
            //print_r($vehicles);
        }

        //$query = $this->db->last_query();
        //echo $query;
        foreach($vehicles as &$row) {
            $row['price_month'] = ceil($row['price_month']);
            $row['additional_images'] = $this->db
                ->where('vehicle_id', $row['id'])
                ->get('vehicle_additional_images')
                ->result_array();

            // build seo url
            $title = $row['manufacturer_text'] . ' '. $row['model_text'];
            $title = explode(' ', $title);
            $url = '';
            foreach($title as $sec) {
                if(preg_match("/\\d/", $sec) == 0) { // if no numbers
                    $url .= ' ' . strtolower($sec);
                }
            }
            $row['url'] = $row['id'] . '-' . url_title($url);

            // set location_distance text
            if(isset($row['location_distance'])) {
                $row['location_distance'] = number_format($row['location_distance'], 1) . ' miles from ' . strtoupper($postcode);
            }
        }
        
        return $vehicles;
    }

    public function search_selected_from_url() {

        $selected = array(
            'postcode' => NULL,
            'manufacturer' => NULL,
            'model' => NULL,
            'transmission' => NULL,
            'price-from' => NULL,
            'price-to' => NULL,
            'location' => NULL,
        );

        for($i = 3; $i < 50; ++$i) {
            if($this->uri->segment($i) == NULL)
                break;
            switch($this->uri->segment($i)) {
                case 'postcode':
                    $selected['postcode'] = urldecode($this->uri->segment($i + 1));
                    $selected['postcode'] = preg_replace("/[^ \w]+/", '', $selected['postcode']);
                    continue 2;
                    break;
                case 'manufacturer':
                    $selected['manufacturer'] = urldecode($this->uri->segment($i + 1));
                    continue 2;
                    break;
                case 'model':
                    $selected['model'] = urldecode($this->uri->segment($i + 1));
                    continue 2;
                    break;
                case 'transmission':
                    $selected['transmission'] = urldecode($this->uri->segment($i + 1));
                    continue 2;
                    break;
                case 'from':
                    $selected['price-from'] = urldecode($this->uri->segment($i + 1));
                    continue 2;
                    break;
                case 'to':
                    $selected['price-to'] = urldecode($this->uri->segment($i + 1));
                    continue 2;
                    break;
                case 'location':
                    $selected['location'] = urldecode($this->uri->segment($i + 1));
                    continue 2;
                    break;
            }
        }
        
        return $selected;
    }
    public function getVehicleByLocation($location_id){
        $this->query = $this->db->select('id, manufacturer_text, model_text, price, image, derivative_text')
                    ->from('vehicles')
                    ->where('location_id', $location_id)
                    ->where('sold', 0)
                    ->where('active_status', 1)
                    ->limit(6)
                    ->get();
        return $this->query->result_array();
    }

    public function getModels(){
        $this->query = $this->db->get('vehicle_model');
        return $this->query->result_array();
    }
    public function getModel_textFromId($id){
        $this->query = $this->db->select('model_text')
                                ->from('vehicle_model')
                                ->where('id', $id)
                                ->get();
        return $this->query->row();   
    }

    public function addModel($newModelName, $manufacturer){
        //echo "this is model: ". $newModelName ." ". $manufacturer ."<br>"; 
        
        $this->query = $this->db->select('manufacturer_text')
                                ->from('vehicle_model')
                                ->where("manufacturer" ,$manufacturer)
                                ->get();
        
        $manufacturer_text = $this->query->row_array();
        $manufacturer_text = $manufacturer_text['manufacturer_text'];

        $data = array(
                'model_text' => $newModelName,
                'manufacturer' => $manufacturer,
                'manufacturer_text' => $manufacturer_text
        );
        //echo "data= ";
        //print_r($data);
        
        $this->db->insert('vehicle_model', $data);        
        
        $this->query2 = $this->db->select('id')
                                ->from('vehicle_model')
                                ->order_by('id', "desc")
                                ->limit('1')
                                ->get();
        
        $last_id = $this->query2->row();                                

        return $last_id->id;
    }

    public function setAdditionalImage($file_name,$vehicle){
        $data = array(
            "vehicle_id" => $vehicle,
            'image' => $file_name,
        );
        

        $this->db->insert('vehicle_additional_images', $data);
        
        return $this->db->insert_id();

    }
    
    public function orderAdditionalImage($images){
        foreach ($images["item"] as $id_image => $image) {
            $this->db->set("sort", $id_image)
                    ->where("id",$image)
                    ->update("vehicle_additional_images");
        }
    }
    public function duplicateVehicle($id){
        
        $this->query = $this->db->get_where("vehicles","id = $id");
        $vehicleOld = $this->query->row_array();
        unset($vehicleOld['id']);
        
        $this->db->insert("vehicles", $vehicleOld);
        
        print_r($this->db->insert_id());
    
    }    
    public function resizeImage($image_id, $size = 1024){
        
        $image = $this->db->get_where("vehicle_additional_images","id = $image_id")->row_array();
        

        $image_url = $this->config->item('docroot') . "/assets/img/vehicles/".$image['image'];
        
        $this->load->helper('Smartimage');
        
        $img = new SmartImage($image_url);
        $img->resize($size, $size);
        $img->saveImage($image_url, 80);
        return $image;
        
    }
}
