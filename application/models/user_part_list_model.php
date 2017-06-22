<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class User_part_list_model extends MY_Model {

    public $_table = 'users_part_lists';

//    public $protected_attributes = array( 'id' );

    public $belongs_to = array( 'part_list', 'user' );

}
//EOF
