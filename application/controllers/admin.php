<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Private_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('partial');
        $this->load->helper('url');
        $this->load->model('vehicle_model');
        $this->load->model('cap_model');
        $this->load->model('offer_model');
        $this->load->model('page_model');
        $this->load->model('page_content_model');
        $this->load->model('location_model');

        $this->load->library('form_validation');
    }

    public function index(){
        $this->data['vehicles'] = $this->vehicle_model->get_all();
        $this->data['locations'] = $this->location_model->get_all();
    }
    public function index_location($location_id)
    {
        $this->data['vehicles'] = $this->vehicle_model->get_all_by_location($location_id);
        $this->data['location'] = $this->location_model->get($location_id);
        $this->data['locations'] = $this->location_model->get_all();
    }

    public function location_catalogue($location_id){
        $this->data['vehicles'] = $this->vehicle_model->get_all_by_location($location_id);
        $this->data['location'] = $this->location_model->get($location_id);
        $this->data['locations'] = $this->location_model->get_all();
    }

    public function vehicles($action = NULL, $param1 = NULL) {
        $manufacturers = array();
        foreach($this->cap_model->get_manufacturers() as $manufacturer) {
            $manufacturers[$manufacturer['code']] = $manufacturer['name'];
        } 
        $this->data['manufacturers'] = $manufacturers;
        $this->data['body_types'] = $this->vehicle_model->get_body_types();
        $this->data['finance_types'] = array();
        foreach($this->db->get('finance_types')->result_array() as $finance_type) {
            $this->data['finance_types'][$finance_type['id']] = $finance_type['name'];
        }
        $locations = array();
        foreach($this->location_model->get_all() as $location) {
            $locations[$location['id']] = $location['name'] . ' - ' . $location['manufacturer'];
        } 
        $this->data['locations'] = $locations;
        $types = array();
        foreach($this->vehicle_model->get_types() as $type) {
            $types[$type['id']] = $type['name'];
        } 
        $this->data['types'] = $types;

        switch($action) {
        case 'add' : 
            
            $session_id = $this->session->userdata('user_id');
            $this->userManager = $this->user_model->isManager($session_id);
            $this->data['userManager']= $this->userManager->manager;

            $this->data['modelOfVehicle'] = $this->vehicle_model->getModels();
            if($this->input->post()) {
                
                
                // image upload first
                $config['upload_path'] = $this->config->item('docroot') . '/assets/img/vehicles/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']	= '20480';
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload())
                {
                    $file_name = NULL;
                }
                else
                {
                    $file_data = $this->upload->data();
                    $file_name = $file_data['file_name'];
                    //print_r($file_data);
                }
                $description = $this->cap_model->get_description_from_id($this->input->post('derivative'));

                $vehicle = array(
                    'updated_at' => date('Y-m-d H:i:s'),
                    'manufacturer' => $this->input->post('manufacturer'),
                    'manufacturer_text' => $description['manufacturer_text'],
                    'model' => $this->input->post('model'),
                    'model_text' => $description['model_text'],
                    'derivative' => $this->input->post('derivative'),
                    'derivative_text' => $description['derivative_text'],
                    'type_id' => $this->input->post('type'),
                    'body_type_id' => $this->input->post('body_type'),
                    'price' => $this->input->post('price'),
                    'price_month' => $this->input->post('price_month'),
                    'price_month_term' => $this->input->post('price_month_term'),
                    'upfront_months' => $this->input->post('upfront_months'),
                    'finance_type_id' => $this->input->post('finance_type'),
                    'colour' => $this->input->post('colour'),
                    'registered' => $this->input->post('registered'),
                    'mileage' => $this->input->post('mileage'),
                    'registration' => $this->input->post('registration'),
                    'previous_owners' => $this->input->post('previous_owners'),
                    'image' => $file_name,
                    'active_status' => 1,
                    'list_on_autotrader' => $this->input->post('list_on_autotrader'),
                    'no_vat' => $this->input->post('no_vat'),
                    'sold' => $this->input->post('sold'),
                    'new' => $this->input->post('new'),
                    'priority' => $this->input->post('priority'),
                    'bullet_point_1' => $this->input->post('bullet_point_1'),
                    'bullet_point_2' => $this->input->post('bullet_point_2'),
                    'bullet_point_3' => $this->input->post('bullet_point_3'),
                    'bullet_point_4' => $this->input->post('bullet_point_4'),
                    'description' => $this->input->post('description'),
                    'fuel_type' => $this->input->post('fuel_type'),
                    'transmission' => $this->input->post('transmission'),
                    'number_of_seats' => $this->input->post('number_of_seats'),
                    'model_year' => $this->input->post('model_year'),
                    'engine_size' => $this->input->post('engine_size'),
                    'load_width' => $this->input->post('load_width'),
                    'load_height' => $this->input->post('load_height'),
                    'load_length' => $this->input->post('load_length'),
                    'load_seats' => $this->input->post('load_seats'),
                    'load_weight' => $this->input->post('load_weight'),
                    'location_id' => $this->input->post('location'),
                );
                $this->vehicle_model->insert($vehicle);
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Vehicle was successfully added.'
                ));
                redirect('admin/vehicles/edit/' . $this->db->insert_id());
              
            }

            $this->view = 'admin/vehicles/add';

            break;
            /* THIS IS THE ONLY MEHTOD BEING USED TO ADD */
        case 'add_manual' : 
            if($this->input->post()) {
               // die(var_dump($this->input->post()));

                // VALIDATION RULES
                if(array_key_exists('autotrader_attention_grabbers', $this->input->post())){
                    $autotrader_attention_grabbers = $this->input->post('autotrader_attention_grabbers');
                }else{
                    $autotrader_attention_grabbers = null;
                }
                if( empty($this->input->post('manufacturer')) ) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => 'You must select a manufacturer from the drop down.'
                    ));
                    redirect('admin/vehicles/add');
                }
                if( empty($this->input->post('model_uid')) ) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => 'You must select a model from the drop down or add a new one.'
                    ));
                    redirect('admin/vehicles/add');
                }
                if( empty($this->input->post('location')) ) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => 'You must select a location from the drop down.'
                    ));
                    redirect('admin/vehicles/add');
                }
                if( empty($this->input->post('type')) ) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => 'You must select a type from the drop down.'
                    ));
                    redirect('admin/vehicles/add');
                }
                if( empty($this->input->post('engine_size')) ) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => 'You must type the engine size (4 digits format, no letters)'
                    ));
                    redirect('admin/vehicles/add');
                }

                // image upload first
                $config['upload_path'] = FCPATH.'assets/img/vehicles/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']	= '20480';
                $this->load->library('upload', $config);
                
                if ( ! $this->upload->do_upload()){
                    $errors = $this->upload->display_errors();
                    die(var_dump($errors));
                    $file_name = NULL;
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => 'You must select a main image for this vehicle'
                    ));
                    redirect('admin/vehicles/add');
                }else{
                    $file_data = $this->upload->data();
                    $file_name = $file_data['file_name'];
                    //print_r($file_data);
                }



                $newModelName = $this->input->post('newModelName');
                if(!empty($newModelName) ){
                    $manufacturer_id =  $this->input->post('manufacturer');
                    //echo $newModelName ." ". $manufacturer; 
                    $model_uid = $this->vehicle_model->addModel($newModelName, $manufacturer_id);
                    $model_text = $newModelName; 
                }else{
                    $model_uid = $this->input->post('model_uid');
                    $model_name = $this->vehicle_model->getModel_textFromId($model_uid);
                    $model_text = $model_name->model_text;  
                    //echo $model_uid .' '. $model_text;    
                }
                
                $manufacturer = $this->cap_model->get_manufacturer($this->input->post('manufacturer'));
                
                $vehicle = array(

                    'updated_at' => date('Y-m-d H:i:s'),
                    'manufacturer' => $this->input->post('manufacturer'),
                    'manufacturer_text' => $manufacturer['name'],
                    'model_id' => $model_uid,
                    'model_text' => $model_text,
                    'derivative' => 0,
                    'derivative_text' => $this->input->post('derivative'),
                    'type_id' => $this->input->post('type'),
                    'body_type_id' => $this->input->post('body_type'),
                    'price' => $this->input->post('price'),
                    'price_month' => $this->input->post('price_month'),
                    'price_month_term' => $this->input->post('price_month_term'),
                    'upfront_months' => $this->input->post('upfront_months'),
                    'finance_type_id' => $this->input->post('finance_type'),
                    'colour' => $this->input->post('colour'),
                    'registered' => $this->input->post('registered'),
                    'mileage' => $this->input->post('mileage'),
                    'registration' => $this->input->post('reg_no'),
                    'previous_owners' => $this->input->post('previous_owners'),
                    'image' => $file_name,
                    'active_status' => 1,
                    'list_on_autotrader' => $this->input->post('list_on_autotrader'),
                    'autotrader_attention_grabbers' => $autotrader_attention_grabbers,
                    'no_vat' => $this->input->post('no_vat'),
                    'sold' => $this->input->post('sold'),
                    'new' => $this->input->post('new'),
                    'priority' => $this->input->post('priority'),
                    'bullet_point_1' => $this->input->post('bullet_point_1'),
                    'bullet_point_2' => $this->input->post('bullet_point_2'),
                    'bullet_point_3' => $this->input->post('bullet_point_3'),
                    'bullet_point_4' => $this->input->post('bullet_point_4'),
                    'description' => $this->input->post('description'),
                    'fuel_type' => $this->input->post('fuel_type'),
                    'transmission' => $this->input->post('transmission'),
                    'number_of_seats' => $this->input->post('number_of_seats'),
                    'model_year' => $this->input->post('model_year'),
                    'engine_size' => $this->input->post('engine_size'),
                    'load_width' => $this->input->post('load_width'),
                    'load_height' => $this->input->post('load_height'),
                    'load_length' => $this->input->post('load_length'),
                    'load_seats' => $this->input->post('load_seats'),
                    'load_weight' => $this->input->post('load_weight'),
                    'location_id' => $this->input->post('location'),
                    'video' => $this->input->post('video'),
                );
                //echo "<pre>"; print_r($vehicle);echo "</pre>";
                
                $this->vehicle_model->insert($vehicle);
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Vehicle was successfully added.'
                ));
                redirect('admin/vehicles/edit/' . $this->db->insert_id());
                
            }

            $this->view = 'admin/vehicles/add_manual';

            break;

        case 'edit': 
            
            $this->data['modelOfVehicle'] = $this->vehicle_model->getModels();
            
            /*
            $model_name = $this->vehicle_model->getModel();
            $model_uid = $this->input->post('model_uid');
            $model_name = $this->vehicle_model->getModel_textFromId($model_uid);
            $model_text = $model_name->model_text;  
            */
            
            $this->data['vehicle'] = $this->vehicle_model->get($param1);
            


            if(count($this->data['vehicle']['additional_images']) > 0 && count($this->data['vehicle']['additional_images']) < 5 ) {
                $new_active_status = 0;
                $this->session->set_flashdata('alert', array(
                    'type' => 'danger',
                    'message' => 'The vehicle does not reach the minimum amount of 6 images.'
                ));
            }else{
                $new_active_status = 1;
            }

            $this->vehicle_model->update($param1, array(
                'active_status' => $new_active_status
            ));


            if($this->input->post('imageupload')) {

                // image upload first
                $config['upload_path'] = $this->config->item('docroot') . '/assets/img/vehicles/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']	= '20480';
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload()){
                    $file_name = NULL;
                
                }else {
                    
                    $file_data = $this->upload->data();
                    $file_name = $file_data['file_name'];

                    if($this->input->post('imageadditional')) {
                        $this->db->insert('vehicle_additional_images', array(
                            'vehicle_id' => $param1,
                            'image' => $file_name,
                        ));
                    }
                    else {
                        $this->vehicle_model->update($param1, array(
                            'image' => $file_name,
                        ));
                    }



                    $this->session->set_flashdata('alert', array(
                        'type' => 'success',
                        'message' => 'Vehicle was successfully updated.'
                    ));

                    redirect('admin/vehicles/edit/' . $param1);
                }
            }
           
            if($this->input->post('manufacturer')) {
                $model_uid = $this->input->post('model_uid');
                
                $model_name = $this->vehicle_model->getModel_textFromId($model_uid);
                $model_text = $model_name->model_text;  
                //echo $model_uid .' '. $model_text;
                
                
                $manufacturer = $this->cap_model->get_manufacturer($this->input->post('manufacturer'));
                $vehicle = array(
                    'updated_at' => date('Y-m-d H:i:s'),
                    'manufacturer' => $this->input->post('manufacturer'),
                    'manufacturer_text' => $manufacturer['name'],
                    'model_id' => $model_uid,
                    'model_text' => $model_text,
                    'derivative' => 0,
                    'derivative_text' => $this->input->post('derivative'),
                    'type_id' => $this->input->post('type'),
                    'body_type_id' => $this->input->post('body_type'),
                    'price' => $this->input->post('price'),
                    'price_month' => $this->input->post('price_month'),
                    'price_month_term' => $this->input->post('price_month_term'),
                    'upfront_months' => $this->input->post('upfront_months'),
                    'finance_type_id' => $this->input->post('finance_type'),
                    'colour' => $this->input->post('colour'),
                    'registered' => $this->input->post('registered'),
                    'mileage' => $this->input->post('mileage'),
                    'registration' => $this->input->post('registration'),
                    'previous_owners' => $this->input->post('previous_owners'),
                    //'image' => $this->input->post('image'),
                    'active_status' => $new_active_status,
                    'list_on_autotrader' => $this->input->post('list_on_autotrader'),
                     'autotrader_attention_grabbers' => $this->input->post('autotrader_attention_grabbers'),
                    'no_vat' => $this->input->post('no_vat'),
                    'sold' => $this->input->post('sold'),
                    'new' => $this->input->post('new'),
                    'priority' => $this->input->post('priority'),
                    'bullet_point_1' => $this->input->post('bullet_point_1'),
                    'bullet_point_2' => $this->input->post('bullet_point_2'),
                    'bullet_point_3' => $this->input->post('bullet_point_3'),
                    'bullet_point_4' => $this->input->post('bullet_point_4'),
                    'description' => $this->input->post('description'),
                    'fuel_type' => $this->input->post('fuel_type'),
                    'transmission' => $this->input->post('transmission'),
                    'number_of_seats' => $this->input->post('number_of_seats'),
                    'model_year' => $this->input->post('model_year'),
                    'engine_size' => $this->input->post('engine_size'),
                    'load_width' => $this->input->post('load_width'),
                    'load_height' => $this->input->post('load_height'),
                    'load_length' => $this->input->post('load_length'),
                    'load_seats' => $this->input->post('load_seats'),
                    'load_weight' => $this->input->post('load_weight'),
                    'location_id' => $this->input->post('location'),
                );

                /*
                // if derivative hasnt been updated
                if(empty($this->input->post('derivative'))) { 
                    unset($vehicle['manufacturer']);
                    unset($vehicle['model']);
                    unset($vehicle['derivative']);
                }
                else { // otherwise grab the descriptions from CAP
                    $description = $this->cap_model->get_description_from_id($this->input->post('derivative'));
                    $vehicle['manufacturer_text'] = $description['manufacturer_text'];
                    $vehicle['model_text'] = $description['model_text'];
                    $vehicle['derivative_text'] = $description['derivative_text'];
                }
                 */

                $this->vehicle_model->update($param1, $vehicle);

                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Vehicle was successfully updated.'
                ));
                redirect('admin/vehicles/edit/' . $param1);
               
            }

            $this->view = 'admin/vehicles/edit';

            break;
        }
    }

    public function pages($action = NULL, $param1 = NULL) {

        switch($action) {
        case 'add' :
            if($this->input->post()) {
                // post function
                $result = $this->page_model->create($this->data['domain']['id'], 'default');

                if($result) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'success',
                        'message' => 'Vehicle was successfully updated.'
                    ));
                    redirect('admin/pages/edit/' . $result);
                }
                else {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'success',
                        'message' => 'An error occurred, check you have completed all the fields.'
                    ));
                    redirect('admin/pages/add');
               }
            }
            $this->view = 'admin/pages/add';
            break;

        case 'edit' : 
            $this->data['page'] = $this->page_model->get($param1);
            $this->data['contents'] = $this->page_content_model->get_many_by('page_id', $this->data['page']['id']);
            $this->view = 'admin/pages/edit';
            break;
        default :
            $this->data['pages'] = $this->page_model->get_all();
            break;
        }

    }

    public function page_content($page_content_id) {

        $content = $this->page_content_model->get($page_content_id);

        switch($content['type']) {
        case 'tinymce' :
            $this->page_content_model->update($content['id'], array(
                'content' => $this->input->post('content'),
            ));
            break;
        }

        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'Page content was successfully updated.'
        ));
        redirect('admin/pages/edit/' . $content['page_id']);
    }

    public function ajax($action, $param1 = NULL) {
        $this->view = FALSE;

        switch($action) {
        case 'models':
            $data = $this->cap_model->get_models($param1);
            break;
        case 'derivatives':
            $data = $this->cap_model->get_derivatives($param1);
            break;
        case 'technical_data':
            $data = $this->cap_model->get_technical_data($param1);
            break;
        default:
            $data = array();
            break;
        }

        if(empty($data)) {
            show_404();
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function blog($action = NULL, $param1 = NULL) {
        $this->load->model('blog_model');

        switch($action) {
        case 'add' :
            if($this->input->post()) {
                // post function
                $result = $this->blog_model->create($this->data['domain']['id']);

                if($result) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'success',
                        'message' => 'Blog post was successfully updated.'
                    ));
                    redirect('admin/blog/edit/' . $result);
                }
                else {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'error',
                        'message' => 'An error occurred, check you have completed all the fields.'
                    ));
                    redirect('admin/blog/add');
               }
            }
            $this->view = 'admin/blog/add';
            break;

        case 'edit' : 
            $this->data['blog'] = $this->blog_model->get($param1);
            if($this->input->post()) {
                // post function
                $result = $this->blog_model->update($this->data['domain']['id'], array(
                    'content' => $this->input->post('content'),
                ));

                if($result) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'success',
                        'message' => 'Blog post was successfully updated.'
                    ));
                    redirect('admin/blog/edit/' . $result);
                }
                else {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'error',
                        'message' => 'An error occurred, check you have completed all the fields.'
                    ));
                    redirect('admin/blog/add');
               }
            }
            $this->view = 'admin/blog/edit';
            break;
        default :
            $this->data['blogs'] = $this->blog_model->get_all();
            break;
        }

    }

    public function locations($action = NULL, $param1 = NULL) {
        $this->load->model('location_model');

        switch($action) {
        case 'add' :
            if($this->input->post()) {
                // post function
                $result = $this->location_model->insert(array(
                    'name' => $this->input->post('name'),
                    'manufacturer' => $this->input->post('manufacturer'),
                    'address' => $this->input->post('address'),
                    'phone' => $this->input->post('phone'),
                    'lat' => $this->input->post('lat'),
                    'lng' => $this->input->post('lng'),
                    'opening_content' => $this->input->post('opening_content'),
                    'content' => $this->input->post('content'),
                ));

                if($result) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'success',
                        'message' => 'The location data was successfully updated.'
                    ));
                    redirect('admin/locations/edit/' . $result);
                }
                else {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'error',
                        'message' => 'An error occurred, check you have completed all the fields.'
                    ));
                    redirect('admin/locations/add');
               }
            }
            $this->view = 'admin/locations/add';
            break;

        case 'edit' : 
            $this->data['location'] = $this->location_model->get($param1);
            $this->data['offers'] = $this->offer_model->show($param1);
            
            if($this->input->post()) {
                // post function
                $result = $this->location_model->update($param1, array(
                    'name' => $this->input->post('name'),
                    'manufacturer' => $this->input->post('manufacturer'),
                    'address' => $this->input->post('address'),
                    'phone' => $this->input->post('phone'),
                    'lat' => $this->input->post('lat'),
                    'lng' => $this->input->post('lng'),
                    'opening_content' => $this->input->post('opening_content'),
                    'content' => $this->input->post('content'),
                    'autotrader_did' => $this->input->post('autotrader_did'),
                ));

                if($result) {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'success',
                        'message' => 'Location data was successfully updated.'
                    ));
                    redirect('admin/locations/edit/' . $param1);
                }
                else {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'error',
                        'message' => 'An error occurred, check you have completed all the fields.'
                    ));
                    redirect('admin/locations/add');
               }
            }
            $this->view = 'admin/locations/edit';
            break;
        default :
            $this->data['locations'] = $this->location_model->get_all();
            break;
        }

    }

    public function vehicle_lookup($reg) {
        $this->view = FALSE;
        $this->load->model('vehicle_model');
        $xml = $this->vehicle_model->lookup($reg);

        if($xml != NULL) {
            header('Content-Type: application/json');
            echo json_encode($xml);
        }
        else {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array(
                'message' => 'VRM Not found.',
                'code' => 1
            )));
        }
    }
    
    public function delete_picture($vehicle_id, $picture_id) {
        $this->view = FALSE;

        $this->db
            ->where('id', $picture_id)
            ->where('vehicle_id', $vehicle_id)
            ->delete('vehicle_additional_images');

        redirect('admin/vehicles/edit/' . $vehicle_id . '#images');
    }

    public function users($action = NULL, $param1 = NULL) {
        switch($action) {
            case 'add' :
                if($this->input->post()){
                    $this->load->helper('form');
                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('fullname', 'Fullname', 'required|alpha_numeric_spaces');
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                    $this->form_validation->set_rules('username', 'Username', 'required');
                    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

                    if($this->form_validation->run() !== FALSE){
                        $this->load->model('user_model');
                        $this->user_model->set_user();
                        redirect('admin/users'); 
                    }
                }
                $this->view = 'admin/users/add';
                break;
            
            case 'edit' :
                $this->load->model("user_model");
                if($this->input->post()) {
                    $result = $this->user_model->update_user($param1);
                    $this->user_model->change_password($param1);
                    if($result) {
                        redirect('admin/users');
                    }
                    else {
                        redirect('admin/users/add');
                    }
                }else{
                   $this->data['user'] = $this->user_model->getById($param1);
                }
                $this->view = 'admin/users/edit';

                break;
            case 'delete':
                $this->load->model("user_model");
                $result = $this->user_model->delete($param1);
                redirect('admin/users');
                break;
            default :
                $this->data['users'] = $this->user_model->get_all();
                break;
        }

    }


    public function AddAdditionaImage($vehicle){
        $config = array();
        $config['upload_path'] = $this->config->item('docroot').'/assets/img/vehicles/';
        $config['allowed_types'] = 'gif|jpg|png';
        //$config['max_size']      = '0';
        //$config['overwrite']     = FALSE;

        $this->load->library('upload');

        $files = $_FILES;
        for($i=0; $i< count($files['additionalImage']['name']); $i++){
            
            $_FILES['userfile']['name']= $files['additionalImage']['name'][$i] . "";
            $_FILES['userfile']['type']= $files['additionalImage']['type'][$i];
            $_FILES['userfile']['tmp_name']= $files['additionalImage']['tmp_name'][$i];
            $_FILES['userfile']['error']= $files['additionalImage']['error'][$i];
            $_FILES['userfile']['size']= $files['additionalImage']['size'][$i];    
            
            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload('userfile')){
                
                $error = array('error' => $this->upload->display_errors());
                print_r($error);exit();
                
                //VIEW BOLOW DOESN'T WORK TO CHECK
                //$this->load->view("admin/vehicles/edit/$vehicle", $error);
             }else{            
                $data['vehicle'] = $vehicle;
                $file_name = $this->upload->data()['file_name'];

                $new_vehicle_id = $this->vehicle_model->setAdditionalImage($file_name,$vehicle);
               
                $this->vehicle_model->resizeImage($new_vehicle_id,1024);
                
            }
        }
       redirect("admin/vehicles/edit/$vehicle ");     
       
    }
    
    public function orderAdditionalImage(){
        $this->view = false;
        $output = array();
        
        $list = $_POST['list']; 
        $list = parse_str($list, $output);
        $this->vehicle_model->orderAdditionalImage($output);
    }

    public function duplicateVehicle(){
        $this->view = false;
        $vehicle = $_POST['vehicle']; 
        $vehicleNew = $this->vehicle_model->duplicateVehicle($vehicle);
        //print_r($vehicleNew);
    }    
    
    public function resizeImage($image_id,  $size = 1024){
        $this->view = false;
        
        $image = $this->vehicle_model->resizeImage($image_id,$size);
        
        redirect("admin/vehicles/edit/".$image['vehicle_id']);
    }

    public function addOffer(){
        $this->view = false;
        $this->load->model('offer_model');

        $name = $_FILES["file"]["name"];
        $ext = end((explode(".", $name))); # extra () to prevent notice
        $config['upload_path'] = FCPATH.'perch/resources/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 0;
        
        $this->load->library('upload', $config);

        if( ! $this->upload->do_upload()){
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
            //redirect($_SERVER['HTTP_REFERER']);
        }else{
            $upload_data = $this->upload->data();
             
            $this->form_validation->set_rules('url', 'url', 'required|valid_url');
            $this->form_validation->set_rules('title', 'title', 'required');
            $this->form_validation->set_rules('offer_detail', 'offer_detail', 'required|min_length:15');

            if ($this->form_validation->run() === FALSE){
                echo "validation failed <a href='$_SERVER[HTTP_REFERER]'>Check your data and try again</a>";  
            }else{
                $file_name = $upload_data['file_name'];
                $this->offer_model->store($file_name);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } 
    }
    public function destroyOffer($id){
        $this->offer_model->destroy($id);
        redirect($_SERVER['HTTP_REFERER']);
    }   
}
//EOF   
