<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Location_model extends MY_Model {

    //protected $module_id = 7;

    //public $before_create = array( 'created_at', 'updated_at' );

    public $protected_attributes = array( 'id' );

    //public $has_many = array( 'user' );

    // function to geocode address, it will return false if unable to geocode address
    public function geocode($address) {
 
        // url encode the address
        $address = urlencode($address);
         
        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDj8w13rbTUCPIGgdHBgXaiF5FZKqQ32Fo&address={$address}";
     
        // get the json response
        $resp_json = file_get_contents($url);
         
        // decode the json
        $resp = json_decode($resp_json, true);
     
        // response status will be 'OK', if able to geocode given address 
        if($resp['status']=='OK'){
     
            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $formatted_address = $resp['results'][0]['formatted_address'];
             
            // verify if data is complete
            if($lati && $longi && $formatted_address){

                return array(
                    'lat' => $lati,
                    'lng' => $longi,
                    'formatted_address' => $formatted_address
                );
                 
            }else{
                return false;
            }
             
        }else{
            return false;
        }
    }

    public function get_nearest($lat, $lng, $radius = 838) {

        // Start XML file, create parent node
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        // Search the rows in the markers table
        $query = sprintf("SELECT
            id, address, name, manufacturer, phone, content, lat, lng,
            ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance
            FROM locations HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
          mysql_real_escape_string($lat),
          mysql_real_escape_string($lng),
          mysql_real_escape_string($lat),
          mysql_real_escape_string($radius));

        $result = $this->db->query($query)->result_array();

        return (! empty($result) ) ? $result : NULL;
    }

    
}
//EOF
