<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Offer_model extends MY_Model {
    public function store($file_name){
        $this->load->helper('url');
        //die(var_dump($this->input->post()));
        
        $data = array(
            'img' => $file_name,
            'title' => $this->input->post('title'),
            'url' => $this->input->post('url'),
            'offer_detail' => $this->input->post('offer_detail'),
            'location_id' => $this->input->post('location_id'),
        );
        return $this->db->insert('offers', $data);
    }

    public function show($id){
        return $this->db->get_where('offers',array('location_id' => $id))->result_array();
    }

    public function destroy($id){
        return $this->db->delete('offers', array('id' => $id));
    }
}

//EOF
