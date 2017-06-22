<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Public_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('manufacturer_model');
        $this->load->model('vehicle_model');
        $this->load->model('page_content_model');
        $this->load->model('cap_model');

        $this->data['stock_manufacturers'] = $this->manufacturer_model->get_stock_man();
    }

    public function body_type($id) {
        $this->data['stock'] = $this->vehicle_model->get_by_body($id);

        $uri_string = uri_string();
        $address = (! empty($uri_string) ) ? $uri_string : 'index';

        $page = $this->page_model->get_by(array(
            'domain_id' => $this->data['domain']['id'],
            'address' => $address,
        ));
        $this->data['content'] = $this->page_content_model->load_content($page['id']);
        $this->data['name'] = $this->db->where('id', $id)->get('vehicle_body_types')->row_array();

        $this->view = $this->data['domain']['name'] . '/templates/body_type';
    }

    public function manufacturer($address) {
        $page = $this->page_model->get_by(array(
            'domain_id' => $this->data['domain']['id'],
            'address' => $address,
        ));

        $this->data['stock'] = $this->vehicle_model->get_by_manufacturer($page['manufacturer_id']);

        $this->data['content'] = $this->page_content_model->load_content($page['id']);

        $this->view = $this->data['domain']['name'] . '/templates/manufacturer';
    }

    public function vehicle($id) {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT); // seo urls have words
        $this->load->model('location_model');

        $this->data['vehicle'] = $this->vehicle_model->get($id);
        $this->data['vehicle_location'] = $this->location_model->get($this->data['vehicle']['location_id']);
        $this->data['stocks'] = $this->vehicle_model->get_also_viewed($this->data['vehicle']['id']);

        if(! empty($this->data['vehicle']['cap_id']) ) {
            $cap_id = $this->cap_model->cap_model->get_cap_id($this->data['vehicle']['cap_id']);
        }
        else if($this->data['vehicle']['derivative'] != 0) {
            $cap_id = $this->data['vehicle']['derivative'];
        }

        /*
        if(! empty($cap_id) ) {
            $this->data['options'] = $this->cap_model->get_options_bundle($cap_id);
            $this->data['technical'] = $this->cap_model->get_technical_data($cap_id);
            $this->data['equipment'] = $this->cap_model->get_equipment($cap_id);
        }
         */

        $this->view = $this->data['domain']['name'] . '/templates/vehicle';
    }

    public function page() {
        $this->data['stock'] = $this->vehicle_model->get_all();
        $this->data['stock_12'] = array_slice($this->data['stock'], 3, 12);

        // get the address, get the page row
        $uri_string = uri_string();
        $address = (! empty($uri_string) ) ? $uri_string : 'index';
        $page = $this->page_model->get_by(array(
            'domain_id' => $this->data['domain']['id'],
            'address' => $address,
        ));
        if( empty($page) ) {
            show_404();
            exit();
        }
        $this->data['content'] = $this->page_content_model->load_content($page['id']);

        // could this go in the controller?
        $this->view = $this->data['domain']['name'] . '/templates/' . $page['template'];
    }

    /*
     * call me request POST
     */
    public function callme()
    {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('name_first', 'First Name', 'required');
        $this->form_validation->set_rules('name_last', 'Last Name', 'required');
        $this->form_validation->set_rules('number', 'Number', 'required');

		if ($this->form_validation->run() == FALSE)
		{
            if(validation_errors())
            {
                $this->session->set_flashdata('alert', array(
                    'type' => 'danger',
                    'message' => validation_errors()
                    )
                );
            }
            redirect('/');
            exit();
		}
		else
		{
            // email sales admin
            $message = 'FIRST NAME: ' . $_POST['name_first'] . '<br>
            LAST NAME: ' . $_POST['name_last'] . '<br>
            NUMBER: ' . $_POST['number'] . '<br>
            TIME: ' . $_POST['day'] . ' ' . $_POST['time'] . '<br>
            PAGE ADDRESS: ' . $_SERVER['HTTP_REFERER'];

            $htmessage = "<html>
            <head>
            <title>LEADGEN</title>
            </head>
            <body>
            " . $message . "
            </body>
            </html>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: S&B Commercials PLC <sbcommercialsplc@gmail.com>' . "\r\n";
            mail('enquiry@bestvandeals.com', 'Website Call Me Request', $message, $headers);
            $this->load->model('contact_model');
            $result = $this->contact_model->post_allclients_contact(array(
                'firstname' => $this->input->post('name_first'),
                'lastname' => $this->input->post('name_last'),
                'phone1' => $this->input->post('number'),
                'addednote' => htmlspecialchars(strip_tags($message), ENT_XML1),
            ));
            

            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Your call me request has been sent to our sales team. We look forward to speaking to you.'
                )
            );

            redirect('/');
        }
    }

    /*
     * enquiry POST
     */
    public function enquiry()
    {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('name_first', 'First Name', 'required');
        $this->form_validation->set_rules('name_last', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE)
		{
            if(validation_errors())
            {
                $this->session->set_flashdata('alert', array(
                    'type' => 'danger',
                    'message' => validation_errors()
                    )
                );
            }
            redirect('/');
            exit();
		}
		else
		{
            // email sales admin
            $message = 'FIRST NAME: ' . $_POST['name_first'] . '<br>
            LAST NAME: ' . $_POST['name_last'] . '<br>
            NUMBER: ' . $_POST['number'] . '<br>
            EMAIL: ' . $_POST['email'] . '<br>
            PAGE ADDRESS: ' . $_SERVER['HTTP_REFERER'];

            $htmessage = "<html>
            <head>
            <title>LEADGEN</title>
            </head>
            <body>
            " . $message . "
            </body>
            </html>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: S&B Commercials PLC <sbcommercialsplc@gmail.com>' . "\r\n";
            mail('enquiry@bestvandeals.com', 'Website Enquiry', $message, $headers);
            $this->load->model('contact_model');
            $result = $this->contact_model->post_allclients_contact(array(
                'firstname' => $this->input->post('name_first'),
                'lastname' => $this->input->post('name_last'),
                'email' => $this->input->post('email'),
                'addednote' => htmlspecialchars(strip_tags($message), ENT_XML1),
            ));

            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Your enquiry has been sent to our sales team. We look forward to speaking to you.'
                )
            );

            redirect('/');
        }
    }

    /*
     * enquiry POST
     */
    public function subscribe()
    {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE)
		{
            if(validation_errors())
            {
                $this->session->set_flashdata('alert', array(
                    'type' => 'danger',
                    'message' => validation_errors()
                    )
                );
            }
            redirect('/');
            exit();
		}
		else
		{
            // email sales admin
            $message = 'NAME: ' . $_POST['name'] . '<br />
            NUMBER: ' . $_POST['number'] . '<br />
            EMAIL: ' . $_POST['email'] . '<br />
            PAGE ADDRESS: ' . $_SERVER['HTTP_REFERER'];

            $htmessage = "<html>
            <head>
            <title>LEADGEN</title>
            </head>
            <body>
            " . $message . "
            </body>
            </html>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: S&B Commercials PLC <sbcommercialsplc@gmail.com>' . "\r\n";
            mail('enquiry@bestvandeals.com', 'Buyers Guide Subscription', $message, $headers);

            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Your email has been subscribed to our buyers guide.'
                )
            );

            redirect('/');
        }
    }

    public function test() {
        $this->view = FALSE;

        /* all clients integration
        print_r($result);
         */

    }


}
//EOF
