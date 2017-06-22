<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autotrader extends Public_Controller {

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

    public function index($cargurus = 0) {
        //if cargurus is 0 send the file to autotrader 
        $this->view = FALSE;
        if($cargurus == 1) {
            $vehicles = $this->vehicle_model->get_all_cargurus();
        }
        else {
            $vehicles = $this->vehicle_model->get_all_autotrader();
        }
        // $output creates as CSV file with the data to sent to the third website
        $output = '"Feed_Id","Vehicle_ID","FullRegistration","Colour","FuelType","Year","Mileage","Bodytype","Doors","Make","Model","Variant","EngineSize","Price","Transmissio n","PictureRefs","ServiceHistory","PreviousOwners","Category","FourWheelDrive","Options","Comments","New","Used","Site","Origin","v5","Condition","ExDem o","FranchiseApproved","TradePrice","TradePriceExtra","ServiceHistoryText","Cap_Id","Attention_Grabber"';
        $output .= "\r\n";
        //insert the data into the CSV file
        foreach($vehicles as $vehicle) {
            $output .= '"' . $vehicle['location_id'] . '",'; // feed id
            $output .= '"' . $vehicle['id'] . '",'; // vehicle id
            $output .= '"' . $vehicle['registration'] . '",'; // fullregistration
            $output .= '"' . $vehicle['colour'] . '",'; // colour
            $output .= '"' . $vehicle['fuel_type'] . '",'; // FuelType
            if(is_numeric($vehicle['model_year'])) {
                $output .= '"' . $vehicle['model_year'] . '",'; //year
            }
            else {
                $output .= '"",';
            }
            $output .= '"' . preg_replace('/\D/', '', $vehicle['mileage']) . '",'; // mileage (only numbers)
            $output .= '"",'; // Bodytype
            $output .= '"",'; // doors
            $output .= '"' . trim($vehicle['manufacturer_text']) . '",'; // make
            //,"PictureRefs","ServiceHistory","PreviousOwners",
            //"Category","FourWheelDrive","Options","Comments","New","Used","Site","Origin","v5","Condition","ExDem o",
            //"FranchiseApproved","TradePrice","TradePriceExtra","ServiceHistoryText","Cap_Id","Attention_Grabber"';
            $output .= '"' . $vehicle['model_text'] . '",'; // model
            $output .= '"' . $vehicle['derivative_text'] . '",'; // model

            if(strlen($vehicle['engine_size']) <= 4) {
                $output .= '"' . $vehicle['engine_size'] . '",'; // engine size
            }
            else {
                $output .= '"",'; // engine size
            }

            $output .= '"' . preg_replace('/\D/', '', $vehicle['price']) . '",'; // price
            $output .= '"' . $vehicle['transmission'] . '",';
            // picture refs
            $output .= '"' . base_url('assets/img/vehicles/' . $vehicle['image']);
            foreach($vehicle['additional_images'] as $image) {
                $output .= ',' . base_url('assets/img/vehicles/' . $image['image']);
            }
            $output .= '",';

            $output .= '"",'; //service history
            if(is_numeric($vehicle['previous_owners'])) {
                $output .= '"' . $vehicle['previous_owners'] . '",'; //previous owners
            }
            else {
                $output .= '"0",'; //previous owners
            }
            $output .= '"COMM",'; // category
            $output .= '"",'; // four wheel drive
            $output .= '"",'; // options (Should contain all the feature information in a comma (,) delimited format e.g. “Anti-Lock Brakes,Alarm,Alloy Wheels,Automatic Gearbox,Sony CD,Central Locking”)
            if (strlen($vehicle['description']) > 1450) {
                $output .= '"' . str_replace(array("\"", "\r", "\n"), '', substr($vehicle['description'], 0, 1450) ) . '...",'; // comments
            }
            else {
                $output .= '"' . str_replace(array("\"", "\r", "\n"), '', $vehicle['description']) . '",'; // comments
            }
            $output .= '"N",'; // new
            $output .= '"Y",'; // used
            $output .= '"C",'; // site
            $output .= '"UK",'; // origin
            $output .= '"",'; // v5
            $output .= '"",'; // v5 "Condition",
            $output .= '"",'; // v5 "ExDem o",
            $output .= '"",'; // v5 "FranchiseApproved",
            $output .= '"",'; // v5 "TradePrice",
            if($cargurus == 1) {
                $output .= '"1",'; // v5 "TradePriceExtra",
            }
            else {
                $output .= '"+ VAT",'; // v5 "TradePriceExtra",
            }
            $output .= '"",'; // v5 "ServiceHistoryText",
            $output .= '"",'; // v5 "Cap_Id",
            $output .= '"' . $vehicle['autotrader_attention_grabbers'] . '"' . "\r\n"; // v5 Attention grabber

        }


        // setup a tmp file and put the output into the temporary file
        $tmpfname = tempnam('/tmp', 'tmp');
        $myfile = fopen($tmpfname, "w") or die("Unable to open file!");
        fwrite($myfile, $output);
        fclose($myfile);
        //autotrader need a special format in the title (has to be .txt)
        $remote_file = 'IMPERIAL-' . date('dmY') . '_' . date('Hi') . '-DMS14.txt';

        if($cargurus == 1) {
            $conn_id = ftp_connect('ftp.cargurus.co.uk') or die("Couldn't connect to ftp server"); 
            $login_result = ftp_login($conn_id, 'imperialcommercials', 'pFQLp9');
            ftp_chdir($conn_id, '/'); 
            ftp_pasv($conn_id, true);
            if (ftp_put($conn_id, $remote_file, $tmpfname, FTP_ASCII))
            {
                $ftp_result = "SUCCESS: uploaded the file to cargurus.";
            }
            else
            {
                $ftp_result = "FAILED: There was a problem while uploading the file to cargurus.";
            }
            ftp_close($conn_id);
        }
        else {
            // set up basic connection
            $conn_id = ftp_connect('ftp.autotrader.co.uk') or die("Couldn't connect to ftp server"); 
            
            // login with username and password
            $login_result = ftp_login($conn_id, 'imperialcoms', '6T9NQ9FRS3Hpr7x');
            ftp_chdir($conn_id, '/'); 

            // use passive mode, active hardly ever works
            ftp_pasv($conn_id, true);

            // upload a file
            if (ftp_put($conn_id, $remote_file, $tmpfname, FTP_ASCII))
            {
                $ftp_result = "SUCCESS: uploaded the file.";
            }
            else
            {
                $ftp_result = "FAILED: There was a problem while uploading the file.";
            }
            // close the connection
            ftp_close($conn_id);
        }

        // delete the tmp file
//        unlink($tmpfname);
        
        echo $ftp_result;

        /*
        $out = fopen('php://output', 'w');
        fputcsv($out, array("this",'is some', 'csv "stuff", you know.'));
        fclose($out);
         */


//        print_r($vehicles);

    }

    public function search() {
        $types = $this->vehicle_model->get_types();

        $this->data['type']['url'] = $this->uri->segment(3);
        if(empty($this->data['type']) ) {
            show_404();
            exit();
        }
        $ford_only = 0;
        if($this->data['type']['url'] == 'ford') { // ford
            $this->layout = $this->data['domain']['name'] . '/layouts/application-ford';
            $ford_only = 1;
        }

        $this->data['stock'] = $this->vehicle_model->search_vehicles_from_url();

        $this->data['menu_make_models'] = $this->vehicle_model->get_make_models($ford_only);
        $this->data['menu_transmissions'] = $this->vehicle_model->get_transmission($ford_only);
        $this->data['menu_prices'] = $this->vehicle_model->get_prices();
        $this->data['menu_locations'] = $this->vehicle_model->get_locations();

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
        $this->load->model('location_model');

        $this->data['vehicle'] = $this->vehicle_model->get($id);
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

