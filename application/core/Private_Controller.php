<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Private_Controller extends CI_Controller
{
	public $models = array();
	public $data = array();

	public $view = TRUE;
	public $layout = TRUE;

	public $before_filters = array( 'authenticate_user' );
	public $after_filters = array();

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('inflector');
		
		$model = strtolower(singular(get_class($this)));

        // set website
        if(substr($_SERVER['HTTP_HOST'], 0, 3) === "www") {
            list( , $website_name) = explode('.', $_SERVER['HTTP_HOST']);
        }
        else {
            list($website_name) = explode('.', $_SERVER['HTTP_HOST']);
        }
        $this->load->model('domain_model');
        $this->data['domain'] = $this->domain_model->get_by('name', $website_name);

        // autoload model
		if (file_exists(APPPATH . 'models/' . $model . '_model.php'))
		{
			$this->models[] = $model;
		}

		foreach ($this->models as $model)
		{
			$this->load->model($model . '_model');
		}
	}

	public function _remap($method, $parameters)
	{
		if (method_exists($this, $method))
		{
			$this->_run_filters('before', $method, $parameters);
			call_user_func_array(array($this, $method), $parameters);
			$this->_run_filters('after', $method, $parameters);
		}
		else
    	{
       		show_404();
		}

		$view = strtolower(get_class($this)) . '/' . $method;
		$view = (is_string($this->view) && !empty($this->view)) ? $this->view : $view;

		if ($this->view !== FALSE)
		{
			$this->data['yield'] = $this->load->view($view, $this->data, TRUE);

            // if we have defined the layout in the controller
			if (is_string($this->layout) && !empty($this->layout))
			{
				$layout = $this->layout;
			}
            // default to admin.php for customers, staff for staff (order dispatchers)
			else
			{
                $layout = $this->data['domain']['name'] . '/layouts/admin';
			}

			if ($this->layout)
			{
				$this->load->view($layout, $this->data);
			}
			else
			{
				echo $this->data['yield'];
			}
        }
	}

	protected function _run_filters($what, $action, $parameters)
	{
		$what = $what . '_filters';
		
		foreach ($this->$what as $filter => $details)
		{
			if (is_string($details))
			{
				$this->$details($action, $parameters);
			}
			elseif (is_array($details))
			{
				if (in_array($action, @$details['only']) || !in_array($action, @$details['except']))
				{
					$this->$filter($action, $parameters);
				}
			}
		}
	}

    protected function authenticate_user()
    {
        $auth = (isset($this->auth)) ? $this->auth : TRUE; // Assume authentication is on unless told otherwise
        if($auth !== FALSE) {
            $this->data['access'] = $this->permission_model->module_access($this->session->userdata('user_id'), get_class($this));
            if($this->user_model->logged_in() && $this->data['access'] >= 1)
            {
                $this->data['user'] = $this->user_model
                    ->get($this->session->userdata('user_id'));

                $this->data['menu_items'] = $this->permission_model
                    ->get_modules($this->data['user']['id']);
            }
            else
            {
                redirect('login');
            }
        }
    }
}
//EOF
