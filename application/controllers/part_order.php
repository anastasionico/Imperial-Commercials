<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Part_order extends MY_Controller {

    public function index()
    {
        $this->data['sites'] = $this->part_order_model->get_sites($this->data['user']['id']);
        if(! empty($this->data['sites']) ) {
            $this->data['outstanding_orders'] = $this->part_order_model->get_outstanding_list($this->data['sites']);
        }
    }

    public function order_list($site_id)
    {
        $this->data['site'] = $this->part_order_model->get_site($site_id);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }
        $this->data['orders'] = $this->part_order_model->get_order_list($this->data['site']);
    }

    public function order($site, $id)
    {
        $this->load->helper('form');
        $this->data['site'] = $this->part_order_model->get_site($site);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }
        $this->data['order'] = $this->part_order_model->get_order($this->data['site'], $id);

        $this->view = '/part_order/order/default';
    }

    public function submit_quote($site, $id)
    {
        $this->data['site'] = $this->part_order_model->get_site($site);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }

        $this->part_order_model->submit_quote($this->data['site'], $id);

        // email out
        $this->data['order'] = $this->part_order_model->get_order($this->data['site'], $id);
        $this->data['message'] = ($this->data['order']['storder'] == 1) ? "Your order has been dispatched." : "Your order has been quoted.";
        $this->data['email'] = $this->load->view('part_order/order/email', $this->data, TRUE);

        // Mail it
        if(! empty($this->data['order']['email'])) {
            $this->load->library('email');
            $result = $this->email
                ->from('no-reply@orwelldirect.co.uk')
                ->to($this->data['order']['email'])
                ->subject('Order notification')
                ->message($this->data['email'])
                ->send();
        }

        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'Order has been quoted.'
        ));
        redirect($this->uri->segment(1) . '/part_order/' . $site . '/' . $id);
    }

    public function add_note($site, $id)
    {
        $this->data['site'] = $this->part_order_model->get_site($site);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }

        $this->load->model('note_model');
        $this->note_model->insert(array(
            'module_id' => 7,
            'row_id' => $id,
            'user_id' => $this->data['user']['id'],
            'user_fullname' => $this->data['user']['fullname'],
            'message' => $this->input->post('note', TRUE)
        ));

        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'Your note has been added.'
        ));
        redirect($this->uri->segment(1) . '/part_order/' . $site . '/' . $id);
    }

    public function dispatch($site, $id)
    {
        $this->data['site'] = $this->part_order_model->get_site($site);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }

        $this->part_order_model->dispatch($this->data['site'], $id);

        // email out
        $this->data['order'] = $this->part_order_model->get_order($this->data['site'], $id);
        $this->data['message'] = 'Your order has been dispatched.';
        $this->data['email'] = $this->load->view('part_order/order/email', $this->data, TRUE);

        // Mail it
        if(! empty($this->data['order']['email'])) {
            $this->load->library('email');
            $result = $this->email
                ->from('no-reply@orwelldirect.co.uk')
                ->to($this->data['order']['email'])
                ->subject('Order dispatched')
                ->message($this->data['email'])
                ->send();
        }

        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'Order has been dispatched.'
        ));
        redirect($this->uri->segment(1) . '/part_order/' . $site . '/' . $id);
    }


    public function test() {
        $this->view = FALSE;

        $this->data['site'] = $this->part_order_model->get_site('imperial1');
        $this->data['order'] = $this->part_order_model->get_order($this->data['site'], 1);
        $this->data['message'] = 'Your order has been dispatched.';
        $this->data['email'] = $this->load->view('part_order/order/email', $this->data, TRUE);
        $this->load->library('email');
        $result = $this->email
            ->from('no-reply@orwelldirect.co.uk')
            ->to('send2tomhughes@gmail.com')
            ->subject('Order dispatched')
            ->message($this->data['email'])
            ->send();
    }

}
//EOF
