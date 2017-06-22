<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    public function index() {
        $this->data['user_accounts'] = $this->user_model->with('company')->get_all();
    }

    public function edit($section, $id, $page = NULL) {
        $this->data['user_account'] = $this->user_model
            ->with('permissions')
            ->with('company')
            ->get($id);

        $this->data['dispatch_groups'] = $this->db->get_where('part_orders_groups', array('supplier_url' => $this->data['domain']['name']))->result_array();
        $this->data['section'] = $section;

        $order_site = $this->db
            ->where('user_id', $this->data['user_account']['id'])
            ->get('part_orders_sites')->row_array();

        $this->data['dispatch_from'] = (! empty($order_site) ) ? $order_site['group_id'] : 0;

        switch($page) {

        case 'dispatch_groups':
            $this->view = 'users/dispatch_groups';

            foreach($this->data['dispatch_groups'] as &$group) {
                $check = $this->db->get_where('part_orders_groups_users', array(
                    'user_id' => $id,
                    'group_id' => $group['id'],
                ))->row_array();
                $group['checked'] = (empty($check)) ? 0 : 1;
            }

            if($_POST) {
                $this->db->delete('part_orders_groups_users', array('user_id' => $id)); 

                foreach($_POST as $name => $value) {
                    if($value == 1) {
                        list( , $group_id) = explode('_', $name);
                        $this->db->insert('part_orders_groups_users', array(
                            'user_id' => $id,
                            'group_id' => $group_id,
                        ));
                    }
                }

                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'User dispatch groups updated.'
                ));
                redirect($this->uri->segment(1) . '/users/' . $section . '/' . $id . '/dispatch_groups');
            }

            break;

        case 'part_lists':
            $this->view = 'users/parts_lists';
            $this->load->model('manufacturer_model');
            $this->load->model('user_part_list_model');
            $this->data['manufacturers'] = $this->manufacturer_model->with('part_list')->get_all();

            if($_POST) {
                $this->db->delete('users_part_lists', array('user_id' => $id)); 

                foreach($_POST as $name => $value) {
                    if($value == 1) {
                        list( , $part_list_id) = explode('_', $name);
                        $this->user_part_list_model->insert(array(
                            'user_id' => $id,
                            'part_list_id' => $part_list_id,
                        ));
                    }
                }

                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'User part lists updated.'
                ));
                redirect($this->uri->segment(1) . '/users/' . $section . '/' . $id . '/part_lists');
            }

            foreach($this->data['manufacturers'] as &$manufacturer) {
                foreach($manufacturer['part_list'] as &$part_list) {
                    $check = $this->user_part_list_model->get_by(array(
                        'user_id' => $id,
                        'part_list_id' => $part_list['id'],
                    ));
                    $part_list['checked'] = (empty($check)) ? 0 : 1;
                }
            }
            break;

        case 'passwordreset':

            $this->view = 'users/passwordreset';
            $config = array(
                array('field' => 'password1', 'label' => 'Password', 'rules' => 'required'),
                array('field' => 'password2', 'label' => 'Repeat Password', 'rules' => 'required|matches[password1]'),
            );
            $this->load->library('form_validation');
            $this->form_validation->set_rules($config);
            if($this->input->post()) {
                if($this->form_validation->run() == TRUE) {
                    $this->load->helper('bcrypt');
                    $bcrypt = new Bcrypt();
                    $user = array('password' => $bcrypt->hash($this->input->post('password1')));
                    $update = $this->user_model->update($id, $user, TRUE);
                    if($update) {
                        $this->session->set_flashdata('alert', array(
                            'type' => 'success',
                            'message' => 'User password updated.'
                        ));
                    }
                }
                else {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'error',
                        'message' => validation_errors(),
                    ));
                }
                redirect($this->uri->segment(1) . '/users/' . $section . '/' . $id . '/passwordreset');
            }
            break;

        case 'permissions':

            if($_POST) {
                $this->permission_model->update_user($id);

                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'User updated.'
                ));
                redirect($this->uri->segment(1) . '/users/' . $section . '/' . $id . '/permissions');
            }
            $this->load->model('module_model');
            $this->data['modules'] = $this->module_model->get_all();

            $this->view = 'users/permissions';
            break;

        case 'imprest_list':

            if($_POST) {
                if($this->input->post('account_number')
                   && $this->input->post('site_code_' . $this->input->post('account_number')) ) {

                    $this->db->delete('users_imprest_lists', array('user_id' => $this->data['user_account']['id'])); 
                    $this->db->insert('users_imprest_lists', array(
                        'user_id' => $this->data['user_account']['id'],
                        'account_number' => $this->input->post('account_number'),
                        'site_code' => $this->input->post('site_code_' . $this->input->post('account_number')),
                    ));

                    $this->session->set_flashdata('alert', array(
                        'type' => 'success',
                        'message' => 'User imprest list updated.'
                    ));
                }
                else {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'error',
                        'message' => 'You must select an Account number and site code.'
                    ));

                }
                redirect($this->uri->segment(1) . '/users/' . $section . '/' . $id . '/imprest_list');
            }

            $this->data['imprest_list'] = $this->db->get_where('users_imprest_lists', array(
                    'user_id' => $this->data['user_account']['id'],
                ))->row_array();

            $this->data['accounts'] = $this->db
                ->query('select distinct account_number from part_imprest_lists where domain_id = ' . $this->data['domain']['id'])
                ->result_array();
            foreach($this->data['accounts'] as &$account) {
                $account['site_codes'] =  $this->db
                    ->query('select distinct site_code from part_imprest_lists where domain_id = ' . $this->data['domain']['id']
                . ' AND account_number = \'' . $account['account_number'] . '\'')
                    ->result_array();
            }

            $this->view = 'users/imprest_list';
            break;

        case NULL:
            $this->load->model('address_model');
            $this->data['address'] = $this->address_model
              ->get($this->data['user_account']['default_address']);
            $this->data['discount_account_numbers'] = $this->db
                ->query('select distinct account_number from part_contract_pricing where domain_id = ' . $this->data['domain']['id'])
                ->result_array();

            if($_POST) {
                $this->user_model->update($id, array(
                    'username' => $this->input->post('username'),
                    'fullname' => $this->input->post('fullname'),
                    'email' => $this->input->post('email'),
                    'part_option_m1' => $this->input->post('part_option_m1'),
                    'part_option_m2' => $this->input->post('part_option_m2'),
                    'discount_account_number' => $this->input->post('discount_account_number'),
                ), TRUE);
                // if their a customer update the part_orders_sites table
                if($this->data['user_account']['staff'] == 0) {
                    $this->db->delete('part_orders_sites', array('user_id' => $id)); 
                    $this->db->insert('part_orders_sites', array(
                        'group_id' => $this->input->post('group_id'),
                        'company_id' => $this->data['user_account']['company_id'],
                        'user_id' => $id,
                    ));
                }

                $this->load->model('address_model');
                if($this->data['user_account']['default_address'] != 0) {
                    // update address
                    $this->address_model->update($this->data['user_account']['default_address'], array(
                        'name' => $this->input->post('address_name'),
                        'address_1' => $this->input->post('address_1'),
                        'address_2' => $this->input->post('address_2'),
                        'citytown' => $this->input->post('address_citytown'),
                        'county' => $this->input->post('address_county'),
                        'postcode' => $this->input->post('address_postcode'),
                    ));
                }
                else {
                    // add address
                    $address_id = $this->address_model->insert(array(
                        'user_id' => $id,
                        'company_id' => $this->data['user_account']['company_id'],
                        'name' => $this->input->post('address_name'),
                        'address_1' => $this->input->post('address_1'),
                        'address_2' => $this->input->post('address_2'),
                        'citytown' => $this->input->post('address_citytown'),
                        'county' => $this->input->post('address_county'),
                        'postcode' => $this->input->post('address_postcode'),
                    ));
                    $this->user_model->update($id, array(
                        'default_address' => $address_id,
                    ), TRUE);
                }
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'User details updated.'
                ));
                redirect($this->uri->segment(1) . '/users/' . $section . '/' . $id . '');
            }

            break;
        }
    }

    public function add($default_company_id, $section)
    {
        if($_POST)
        {
            $this->view = FALSE;

            $default_module_name = ($this->input->post('account_type') == 'customer') ? 'parts' : 'part_order';
            $staff = ($this->input->post('account_type') == 'customer') ? 0 : 1;

            $id = $this->user_model->insert(array(
                'username' => $this->input->post('username'),
                'fullname' => $this->input->post('fullname'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'company_id' => $this->input->post('company_id'),
                'default_module_name' => $default_module_name,
                'staff' => $staff,
                'part_option_m1' => $this->input->post('part_option_m1'),
                'part_option_m2' => $this->input->post('part_option_m2'),
            ));

            if($id) {
                $this->load->model('permission_model');
                // modules ids: part_order is 4, parts is 7
                $module_id = ($default_module_name == 'part_order') ? 4 : 7;
                $this->permission_model->insert(array(
                    'user_id' => $id,
                    'module_id' => $module_id,
                    'access' => 1,
                ));
                // if their a customer add them to the part_orders_sites table
                if($staff == 0) {
                    $this->db->insert('part_orders_sites', array(
                        'group_id' => $this->input->post('group_id'),
                        'company_id' => $this->input->post('company_id'),
                        'user_id' => $id,
                    ));
                }
                // add address
                $this->load->model('address_model');
                $address_id = $this->address_model->insert(array(
                    'user_id' => $id,
                    'company_id' => $this->input->post('company_id'),
                    'name' => $this->input->post('address_name'),
                    'address_1' => $this->input->post('address_1'),
                    'address_2' => $this->input->post('address_2'),
                    'citytown' => $this->input->post('address_citytown'),
                    'county' => $this->input->post('address_county'),
                    'postcode' => $this->input->post('address_postcode'),
                ));
                $this->user_model->update($id, array(
                    'default_address' => $address_id,
                ), TRUE);

                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'User added.'
                ));
                $section = ($this->input->post('account_type') == 'customer') ? 'customers' : 'suppliers';
                redirect($this->uri->segment(1) . '/users/' . $section . '/' . $id);
            }
            else {
                $this->session->set_flashdata('alert', array(
                    'type' => 'error',
                    'message' => validation_errors()
                ));
                redirect($this->uri->segment(1) . '/users/add/' . $default_company_id . '/' . $section);
            }
        }
        $this->load->model('module_model');
        $this->data['modules'] = $this->module_model->get_all();
        $this->data['companys'] = $this->company_model->get_all();
        $this->data['dispatch_groups'] = $this->db->get_where('part_orders_groups', array('supplier_url' => $this->data['domain']['name']))->result_array();
        $this->data['default_company_id'] = $default_company_id;
        $this->data['section'] = $section;

        $this->load->helper('form');
    }

}
//EOF
