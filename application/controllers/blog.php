<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Public_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('manufacturer_model');
        $this->load->model('vehicle_model');
        $this->load->model('page_content_model');
        $this->load->model('cap_model');

        $this->data['stock_manufacturers'] = $this->manufacturer_model->get_stock_man();
    }

    public function index() {
        $this->data['blogs'] = $this->blog_model->get_all();

        $this->view = $this->data['domain']['name'] . '/templates/blog';
    }

    public function post($address) {
        $this->data['blog'] = $this->blog_model->get($address);

        if(empty($this->data['blog']))
        {
            show_404();
        }

        $this->view = $this->data['domain']['name'] . '/templates/blog_post';
    }

}
//EOF
