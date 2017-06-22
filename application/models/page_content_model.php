<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Page_content_model extends MY_Model {

    protected $_table = 'page_content';

    public $protected_attributes = array( 'id' );
    
    public function load_content($page_id) {

        $data = $this->get_many_by('page_id', $page_id);

        if(empty($data)) {
            return NULL;
        }

        $content = array();

        foreach($data as $row) {
            $content[$row['name']] = $row['content'];
        }

        return $content;
    }

}
//EOF
