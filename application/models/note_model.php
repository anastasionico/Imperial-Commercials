<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Note_model extends MY_Model {

    public $before_create = array( 'created_at' );

}

//EOF
