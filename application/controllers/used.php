<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Used extends Public_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('partial');

        $this->load->model('vehicle_model');
        $this->load->model('cap_model');
        $this->load->model('page_model');
        $this->load->model('page_content_model');
    }

    public function index($type, $sort_by = 'created_at', $sort_order = 'desc') {
        $type = preg_replace('/\D/', '', $type);
        
        // type = vans (1) trucks (2) ford (3)
        $types = $this->vehicle_model->get_types(TRUE);
        if($type == 1) {
            $this->data['seo']['title'] = 'Used Vans For Sale | VW, Ford & Fiat - Imperial Commercials';
        }
        $ford_only = 0;
        if($type == 3) { // ford
            $this->data['seo']['title'] = 'Used Ford Vans For Sale | Ford Transits & Rangers - Imperial';

            $this->layout = $this->data['domain']['name'] . '/layouts/application-ford';
            $ford_only = 1;
        }

        if($this->input->post()) {
            $url = $this->vehicle_model->search_construct_url($types[$type]['url']);
            redirect($url);
        }

        if(empty($type)) {
            show_404();
            exit();
        }

        $this->data['stock'] = $this->vehicle_model->get_all_search($type, $sort_by, $sort_order );
        $this->data['type'] = $types[$type];

        //
        $this->data['menu_make_models'] = $this->vehicle_model->get_make_models($type);
        //

        $this->data['menu_transmissions'] = $this->vehicle_model->get_transmission($ford_only);
        $this->data['menu_prices'] = $this->vehicle_model->get_prices();
        $this->data['menu_locations'] = $this->vehicle_model->get_locations($type);
        $this->data['menu_manufacturers'] = $this->vehicle_model->get_manufacturers($type);


        // should return nulls, but needed for sidebar to work
        $this->data['selected'] = $this->vehicle_model->search_selected_from_url();

        $this->data['content'] = $this->page_content_model->load_content(19);
        
        $this->view = $this->data['domain']['name'] . '/templates/used';
    }

    public function search() {
        

        $types = $this->vehicle_model->get_types();

        $this->data['type']['url'] = $this->uri->segment(3);

        if(empty($this->data['type']) ) {
            show_404();
            exit();
        }
        $ford_only = 0;
        // work out type
        switch($this->data['type']['url']) {
            case 'ford': // ford
                $this->layout = $this->data['domain']['name'] . '/layouts/application-ford';
                $ford_only = 1;
                $type = 3;
                break;
            case 'vans':
                $type = 1;
                break;
            case 'trucks':
                $type = 2;
                break;
            }
        
        $this->data['stock'] = $this->vehicle_model->search_vehicles_from_url();

        $this->data['menu_manufacturers'] = $this->vehicle_model->get_manufacturers($type);
        $this->data['menu_make_models'] = $this->vehicle_model->get_make_models($type);
        $this->data['menu_transmissions'] = $this->vehicle_model->get_transmission($ford_only);
        $this->data['menu_prices'] = $this->vehicle_model->get_prices();
        $this->data['menu_locations'] = $this->vehicle_model->get_locations($type);
        $this->data['selected'] = $this->vehicle_model->search_selected_from_url();

        $this->data['content'] = $this->page_content_model->load_content(19);
        $this->view = $this->data['domain']['name'] . '/templates/used';
    }

    public function search_count() {
        $vehicles = $this->vehicle_model->search_vehicles_from_url();

        $this->view = FALSE;
        header('Content-Type: application/json');
        echo json_encode(array(
            'count' => count($vehicles),
        ));
    }

    public function vehicle($id) {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT); // seo urls have words
        //print_r($id);
        $this->load->model('location_model');

        $this->data['vehicle'] = $this->vehicle_model->get($id);
       // print_r($this->data['vehicle']);

        
        $this->data['vehicle_location'] = $this->location_model->get($this->data['vehicle']['location_id']);
        $this->data['stocks'] = $this->vehicle_model->get_also_viewed($this->data['vehicle']['id']);

        if(! empty($this->data['vehicle']['cap_id']) ) {
            $cap_id = $this->cap_model->cap_model->get_cap_id($this->data['vehicle']['cap_id']);
        }
        else if($this->data['vehicle']['derivative'] != 0) {
            $cap_id = $this->data['vehicle']['derivative'];
        }

        /*
        if(! empty($cap_id) ) {
            $this->data['options'] = $this->cap_model->get_options_bundle($cap_id);
            $this->data['technical'] = $this->cap_model->get_technical_data($cap_id);
            $this->data['equipment'] = $this->cap_model->get_equipment($cap_id);
        }
         */

        $this->data['content'] = $this->page_content_model->load_content(19);
        $this->view = $this->data['domain']['name'] . '/templates/vehicle';
    }

}
