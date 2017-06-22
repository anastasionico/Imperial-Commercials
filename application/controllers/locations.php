<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locations extends Public_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('manufacturer_model');
        $this->load->model('vehicle_model');
        $this->load->model('offer_model');
        $this->load->model('page_content_model');
        $this->load->model('cap_model');
    }

    public function index($ford_only = 0) {

        if($ford_only == 1) {
            $this->layout = $this->data['domain']['name'] . '/layouts/application-ford';
            $this->data['locations'] = $this->location_model
                ->get_many_by('manufacturer', 'FORD TRANSIT CENTRE');
        }
        else {
            $this->data['locations'] = $this->location_model
                ->order_by('name')
                ->get_all();
        }

        $this->view = $this->data['domain']['name'] . '/templates/locations';
    }

    public function view($id) {
        $id = preg_replace("/[^0-9]/","",$id); // clear up the seo bollocks

        $this->load->model("vehicle_model");
        $this->data['vehicleList'] = $this->vehicle_model->get_all_by_location("$id");
        $this->data['offers'] = $this->offer_model->show($id);
        $this->data['vehicleByLocation'] = $this->vehicle_model->getVehicleByLocation("$id");
        

        $this->data['location'] = $this->location_model->get($id);
        if(empty($this->data['location'])) {
            show_404();
        }

        $this->view = $this->data['domain']['name'] . '/templates/locations/view';
    }

    /*
     * old function I got from the google maps tutorial,
     * not longer used
     */
    public function lookup() {
        $this->view = FALSE;

        // Get parameters from URL
        $center_lat = $_GET["lat"];
        $center_lng = $_GET["lng"];
        $radius = $_GET["radius"];

        // Start XML file, create parent node
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        // Search the rows in the markers table
        $query = sprintf("SELECT
            address, name, lat, lng,
            ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance
            FROM locations HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
          mysql_real_escape_string($center_lat),
          mysql_real_escape_string($center_lng),
          mysql_real_escape_string($center_lat),
          mysql_real_escape_string($radius));

        $result = $this->db->query($query)->result_array();

        if (!$result) {
          die("Invalid query: " . mysql_error());
        }

        header("Content-type: text/xml");

        // Iterate through the rows, adding XML nodes for each
        foreach($result as $row) {
          $node = $dom->createElement("marker");
          $newnode = $parnode->appendChild($node);
          $newnode->setAttribute("name", $row['name']);
          $newnode->setAttribute("address", $row['address']);
          $newnode->setAttribute("lat", $row['lat']);
          $newnode->setAttribute("lng", $row['lng']);
          $newnode->setAttribute("distance", $row['distance']);
        }

        echo $dom->saveXML();
    }

    public function nearest() {

        // geocode the address where they are
        $geocode = $this->location_model->geocode($this->input->post('search'));
        if(empty($geocode)) {
            $this->session->set_flashdata('alert', array(
                'type' => 'danger',
                'message' => 'An error occurred, we could not find that address',
            ));
            redirect('locations');
        }
        // get the nearest dealers
        $result = $this->location_model->get_nearest($geocode['lat'], $geocode['lng']);
        if(empty($result)) {
            $this->session->set_flashdata('alert', array(
                'type' => 'danger',
                'message' => 'An error occurred, we could not find any stores close enough to that address',
            ));
            redirect('locations');
        }

        $this->data['locations'] = $result;
        $this->view = $this->data['domain']['name'] . '/templates/locations/nearest';
    }


}
//EOF
