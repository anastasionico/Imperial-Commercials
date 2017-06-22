<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Part_discounts extends MY_Controller {

    public function index() {
        $this->load->model('manufacturer_model');
        $this->data['manufacturers'] = $this->manufacturer_model->get_all();
        foreach($this->data['manufacturers'] as &$manufacturer)
            $manufacturer['discounts'] = $this->db->get('part_discount_m' . $manufacturer['id'])->result_array();
    }

    public function edit($manufacturer_id, $id) {
        $this->load->model('manufacturer_model');

        $columns[1] = array('00', '03', '05', '07', '08', '09', '10', '11', '13', '16', '18', '20', '23', '26', '28', '30', '32', '35', '38', '40', '43', '44', '46', '47', '55', '56', '57', '58', '59', '60', '61', '62');
        $columns[2] = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '10', '1A', '1B', '1L', '1T', '2A', '2B', '2L', '2R', '2S', '2T', '2W', '3A', '3B', '3R', '3T', '4A', '4B', '4P', '4R', '4T', '5A', '5B', '5P', '5R', '5T', '6A', '6B', '6R', '6T', '7A', '7B', '7R', '7T', '8A', '8B', '8T', '9A', '9B', 'A', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DU', 'EC', 'GA', 'GB', 'GC', 'GD', 'GE', 'GF', 'GG', 'GH', 'JD', 'JF', 'JK', 'JX', 'KG', 'KM', 'KQ', 'KR', 'KS', 'KU', 'LB', 'LC', 'LH', 'LI', 'LL', 'LM', 'LS', 'LW', 'LY', 'MA', 'MC', 'MH', 'MM', 'MS', 'MU', 'MY', 'NT', 'PA', 'PB', 'PF', 'PG', 'PJ', 'PK', 'PL', 'PN', 'PP', 'TA', 'TB', 'TC', 'TD', 'TE', 'TF', 'TG', 'XD', 'XE', 'XF', 'XH', 'XL', 'XP', 'YE', 'YL', 'YT', 'YW', 'YY', 'ZA');
        $this->data['discount'] = $this->db->get_where('part_discount_m' . $manufacturer_id, array('id' => $id), 1)->row_array();
        $this->data['manufacturer'] = $this->manufacturer_model->get($manufacturer_id);
        $this->data['columns'] = $columns[$manufacturer_id];

        if($_POST)
        {
            $data = array('name' => $this->input->post('name'));
            foreach($columns[$manufacturer_id] as $column)
                $data['c' . $column] = $this->input->post('c' . $column);

            $this->db->where('id', $id);
            $this->db->update('part_discount_m' . $manufacturer_id, $data);
            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Discount list added.'
            ));
            redirect($this->uri->segment(1) . '/part_discounts/edit/' . $manufacturer_id . '/' . $id);
        }
    }

    public function add($manufacturer_id) {
        $this->load->model('manufacturer_model');

        $columns[1] = array('00', '03', '05', '07', '08', '09', '10', '11', '13', '16', '18', '20', '23', '26', '28', '30', '32', '35', '38', '40', '43', '44', '46', '47', '55', '56', '57', '58', '59', '60', '61', '62');
        $columns[2] = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '10', '1A', '1B', '1L', '1T', '2A', '2B', '2L', '2R', '2S', '2T', '2W', '3A', '3B', '3R', '3T', '4A', '4B', '4P', '4R', '4T', '5A', '5B', '5P', '5R', '5T', '6A', '6B', '6R', '6T', '7A', '7B', '7R', '7T', '8A', '8B', '8T', '9A', '9B', 'A', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DU', 'EC', 'GA', 'GB', 'GC', 'GD', 'GE', 'GF', 'GG', 'GH', 'JD', 'JF', 'JK', 'JX', 'KG', 'KM', 'KQ', 'KR', 'KS', 'KU', 'LB', 'LC', 'LH', 'LI', 'LL', 'LM', 'LS', 'LW', 'LY', 'MA', 'MC', 'MH', 'MM', 'MS', 'MU', 'MY', 'NT', 'PA', 'PB', 'PF', 'PG', 'PJ', 'PK', 'PL', 'PN', 'PP', 'TA', 'TB', 'TC', 'TD', 'TE', 'TF', 'TG', 'XD', 'XE', 'XF', 'XH', 'XL', 'XP', 'YE', 'YL', 'YT', 'YW', 'YY', 'ZA');
        $this->data['manufacturer'] = $this->manufacturer_model->get($manufacturer_id);
        $this->data['columns'] = $columns[$manufacturer_id];

        if($_POST)
        {
            $data = array('name' => $this->input->post('name'));
            foreach($columns[$manufacturer_id] as $column)
                $data['c' . $column] = $this->input->post('c' . $column);

            $this->db->insert('part_discount_m' . $manufacturer_id, $data);
            $row_id = $this->db->insert_id();

            if($row_id) {
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Discount list added.'
                ));
                redirect($this->uri->segment(1) . '/part_discounts/edit/' . $manufacturer_id . '/' . $row_id);
            }
            else {
                $this->session->set_flashdata('alert', array(
                    'type' => 'error',
                    'message' => 'There was an error, please check your input values.',
                ));
                redirect($this->uri->segment(1) . '/part_discounts/' . $manufacturer_id . '/add');
            }
        }
    }

}
//EOF
