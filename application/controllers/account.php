<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function change_password()
    {
        if($_POST)
        {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('alert', array(
                    'type' => 'danger',
                    'message' => validation_errors()
                ));
            }
            else
            {
                $this->user_model->change_password();

                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Password has been successfully changed.'
                ));
            }

            redirect($this->uri->segment(1) . '/account');
        }
        else
        {
            show_404();
        }
    }

    public function index()
    {
        /*
         * load the BS3 view if its not orwell
         * orwell still using BS2
         */
        if($this->data['user']['company']['id'] > 1)
        {
            $this->view = 'account/index_bs3';
        }
    }

}
//EOF
