<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Manufacturer_model extends MY_Model {

    public $protected_attributes = array( 'id' );

    public $has_many = array( 'part_list' );

    public function get_stock_man() {
        $mans = $this->db->query('SELECT DISTINCT(manufacturer) AS id,
            manufacturer_text as name
            FROM vehicles
            WHERE active_status = 1
            ORDER BY id')->result_array();

        foreach($mans as &$man) {
            switch($man['name']) {
            case 'MERCEDES-BENZ':
                $man['name'] = 'Mercedes-Benz';
                break;
            default :
                $man['name'] = ucfirst(strtolower($man['name']));
                break;
            }

            $man['url'] = strtolower(url_title($man['name']));
        }

        return $mans;
    }

}
//EOF
