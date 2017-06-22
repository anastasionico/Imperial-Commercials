<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Blog_model extends MY_Model {

    public $before_create = array( 'created_at' );
    public $before_update = array( 'updated_at' );

    protected $_table = 'blog';

    public function create($domain_id)
    {
        $address = (substr($this->input->post('url'), 0, 1) == '/') 
            ? substr($this->input->post('url'), 1)
            : $this->input->post('url');

        $blog_id = $this->insert(array(
            'domain_id' => $domain_id,
            'name' => $this->input->post('name'),
            'address' => $address,
            'content' => $this->input->post('content'),
        ));

        return $blog_id;
    }
}

//EOF
