<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Company_model extends MY_Model {

    protected $module_id = 7;

    public $before_create = array( 'created_at', 'updated_at' );

    public $protected_attributes = array( 'id' );

    public $has_many = array( 'user' );

    public $validate = array(
        array( 'field' => 'name', 
               'label' => 'name',
               'rules' => 'required' ),
        array( 'field' => 'url',
               'label' => 'url',
               'rules' => 'required' )
    );

}
//EOF
