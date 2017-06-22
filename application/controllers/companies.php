<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies extends MY_Controller {

    public function index($section = NULL) {
        if($section == NULL) {
            redirect($this->uri->segment(1) . '/companies/customers');
        }
        $companies = $this->company_model->with('user')->get_all();

        // determine if the companies are customers or suppliers or both
        $this->data['suppliers'] = array();
        $this->data['customers'] = array();
        $this->data['awaiting'] = array();
        $this->data['section'] = $section;
        // first loop all companies and see why type of users, set the company flags
        foreach($companies as $company) {
            $supplier = 0;
            $customer = 0;
            foreach($company['user'] as $user) {
                if($user['staff'] == 0) {
                    $customer = 1;
                }
                else if($user['staff'] == 1) {
                    $supplier = 1;
                }
            }
            if($supplier == 1) {
                $this->data['suppliers'][] = $company;
            }
            if($customer == 1) {
                $this->data['customers'][] = $company;
            }
            if($customer == 0 && $supplier == 0) {
                $this->data['awaiting'][] = $company;
            }
        }
    }

    public function edit($section, $id) {
        $this->load->helper(array('form', 'url'));

        $this->data['section'] = $section;
        $this->data['discounts_m1'] = $this->db->get('part_discount_m1')->result_array();
        $this->data['discounts_m2'] = $this->db->get('part_discount_m2')->result_array();

        // company info update
        if($this->input->post('name')) {
            $update = $this->company_model->update($id, array(
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'part_discount_m1_id' => $this->input->post('part_discount_m1_id'),
                'part_discount_m2_id' => $this->input->post('part_discount_m2_id'),
            ));
            if($update) {
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'The record has been quoted.'
                ));
                redirect($this->uri->segment(1) . '/companies/' . $section . '/' . $id);
            }
        }

        // new logo upload
        if($this->input->post('logo_update')) {
            $config['upload_path'] = './assets/img/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']	= '500';
            $config['max_width']  = '300';
            $config['max_height']  = '140';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload())
            {
                $this->session->set_flashdata('alert', array(
                    'type' => 'error',
                    'message' => $this->upload->display_errors()
                ));
            }
            else
            {
                $upload_data = $this->upload->data();
                $this->company_model->update($id, array(
                    'logo' => $upload_data['file_name'],
                ), TRUE);
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'The logo has been quoted.'
                ));
            }
            redirect($this->uri->segment(1) . '/companies/' . $section . '/' . $id);
        }

        $this->data['company'] = $this->company_model->with('user')->get($id);

        if(empty($this->data['company']))
            show_404();
    }

    public function add()
    {
        $this->data['discounts_m1'] = $this->db->get('part_discount_m1')->result_array();
        $this->data['discounts_m2'] = $this->db->get('part_discount_m2')->result_array();

        if($this->input->post('name')) {
            $this->view = FALSE;
            $id = $this->company_model->insert(array(
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'part_discount_m1_id' => $this->input->post('part_discount_m1_id'),
                'part_discount_m2_id' => $this->input->post('part_discount_m2_id'),
            ));
            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Company added.'
            ));
            redirect($this->uri->segment(1) . '/companies/awaiting/' . $id);
        }

        $this->load->helper('form');
    }

    public function delete($id)
    {
        $company = $this->company_model->with('user')->get($id);
        foreach($company['user'] as $user) {
            $this->user_model->delete($user['id']);
        }
        $this->db->delete('companies', array('id' => $id)); 
        
        $this->view = FALSE;
        redirect($this->uri->segment(1) . '/companies');
    }

}
//EOF
