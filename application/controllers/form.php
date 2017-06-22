<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function post($form)
    {
        if($this->input->post()) {

            switch($form) {
            case 'callme':
                $this->form_validation->set_rules('name_first', 'First Name', 'required');
                $this->form_validation->set_rules('name_last', 'Last Name', 'required');
                $this->form_validation->set_rules('number', 'Number', 'required');
                break;
            case 'test_drive':
                $this->form_validation->set_rules('name_first', 'First Name', 'required');
                $this->form_validation->set_rules('name_last', 'Last Name', 'required');
                $this->form_validation->set_rules('number', 'Number', 'required');
                break;
            case 'enquiry':
                $this->form_validation->set_rules('name_first', 'First Name', 'required');
                $this->form_validation->set_rules('name_last', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                break;
            case 'part_exchange':
                $this->form_validation->set_rules('name_first', 'First Name', 'required');
                $this->form_validation->set_rules('name_last', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                break;
            case 'book_service':
                $this->form_validation->set_rules('name_first', 'First Name', 'required');
                $this->form_validation->set_rules('name_last', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                break;
            default :
                show_404();
                exit();
            }

            if ($this->form_validation->run() == FALSE)
            {
                if(validation_errors())
                {
                    $this->session->set_flashdata('refer', preg_replace('#[^A-Za-z0-9-./]#', '', $this->input->post('request_page')));
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => validation_errors()
                        )
                    );
                }
            }
            else
            {
                $this->load->model('page_model');
                $this->page_model->post_form_submit($form);
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Your request has been sent to our contact team. We look forward to speaking to you.'
                    )
                );
            }
            redirect('/locations');
            //redirect($this->input->post('request_path'));
            exit();
        }
    }

}
//EOF
