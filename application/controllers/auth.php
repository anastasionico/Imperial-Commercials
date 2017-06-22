<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        // set website
        if(substr($_SERVER['HTTP_HOST'], 0, 3) === "www") {
            list( , $website_name) = explode('.', $_SERVER['HTTP_HOST']);
        }
        else {
            list($website_name) = explode('.', $_SERVER['HTTP_HOST']);
        }
        $this->load->model('domain_model');
        $this->data['domain'] = $this->domain_model->get_by('name', $website_name);
    }

    public function login()
    {
        if($this->uri->segment(2))
        {
            show_404();
        }

        if($_POST)
        {

            $login = $this->user_model->login(
                $this->input->post('username', TRUE),
                $this->input->post('password', TRUE),
                $this->data['domain']['id']
            );
            
            if($login === TRUE)
            {
                redirect('admin');
            }
            else
            {

                echo 'error';
                //echo "error";
                // login errors to flashdata?
                //redirect('login');
            }
        }
        else
        {
            $this->load->view('auth/header');
            $this->load->view('auth/login', $this->data);
            $this->load->view('auth/footer');
        }
    }

    public function index()
    {
        $this->load->view('auth/header');
        $this->load->view('auth/nologin', $this->data);
        $this->load->view('auth/footer');
    }

    public function logout()
    {
        $login = $this->user_model->logout();
        redirect($this->uri->segment(1));
    }

}
//EOF
