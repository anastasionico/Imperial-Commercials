<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Part_list_part_model extends MY_Model {

    public $_table = 'part_lists_parts';

    public $belongs_to = array( 'part_list', 'part_index' );

    public $validate = array(
        array( 'field' => 'part_list_id', 
               'label' => 'List ID',
               'rules' => 'required' ),
        array( 'field' => 'manufacturer_id',
               'label' => 'Manufacturer ID',
               'rules' => 'required' ),
        array( 'field' => 'pnumber',
               'label' => 'Part Number',
               'rules' => 'required' ),
        array( 'field' => 'description',
               'label' => 'Description',
               'rules' => 'required' ),
        array( 'field' => 'price',
               'label' => 'Price',
               'rules' => 'required' ),
    );

}
//EOF
