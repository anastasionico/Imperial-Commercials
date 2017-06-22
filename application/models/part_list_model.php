<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Part_list_model extends MY_Model {

    protected $module_id = 11;

    public $protected_attributes = array( 'id' );

    public $belongs_to = array( 'manufacturer', 'user' );
    public $has_many = array( 'part_list_part' );

    public $validate = array(
        array( 'field' => 'manufacturer_id', 
               'label' => 'Manufacturer',
               'rules' => 'required' ),
        array( 'field' => 'name',
               'label' => 'Name',
               'rules' => 'required' ),
    );

}
//EOF
