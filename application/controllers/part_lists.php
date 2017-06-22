<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Part_lists extends MY_Controller {

    public function index() {
        $this->load->model('manufacturer_model');
        $this->data['manufacturers'] = $this->manufacturer_model->with('part_list')->get_all();
    }

    public function edit($id) {
        $this->load->model('manufacturer_model');
        $this->load->model('part_model');
        $this->data['manufacturers'] = $this->manufacturer_model->get_all();
        $this->data['part_list'] = $this->part_list_model->with('part_list_part')->get($id);
        foreach($this->data['part_list']['part_list_part'] as &$part_list) {
            $part_list['image'] = $this->part_model->check_image($part_list['pnumber'], TRUE);
        }

        if($_POST) {
            $this->load->model('part_list_part_model');

            $this->part_list_model->update($id, array(
                'manufacturer_id' => $this->input->post('manufacturer_id'),
                'name' => $this->input->post('name'),
                'imprest' => ($this->input->post('imprest') == 1) ? 1 : 0,
            ));

            // had to remove the update from below as there was no way of knowing
            // what lines had been removed by the user on the edit form
            $this->db->delete('part_lists_parts', array('part_list_id' => $id)); 

            // loop the part_list_parts
            foreach($_POST as $name => $value) {
                if(substr($name, 0, 4) == 'part' && ! empty($value)) {
                    $line_number = preg_replace('/\D/', '', $name);
                    $this->part_list_part_model->insert(array(
                        'part_list_id' => $id,
                        'manufacturer_id' => $this->input->post('manufacturer_id'),
                        'pnumber' => $this->input->post('part_' . $line_number),
                        'description' => $this->input->post('description_' . $line_number),
                        'price' => $this->input->post('price_' . $line_number),
                        'discount_code' => $this->input->post('discount_code_' . $line_number),
                        'imprest_quantity' => $this->input->post('imprest_quantity_' . $line_number),
                        'imprest_bin_location' => $this->input->post('imprest_bin_location_' . $line_number),
                    ));
                }
            }
            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Part list updated.'
            ));
            redirect($this->uri->segment(1) . '/part_lists/' . $id);

        }
    }

    public function add() {
        $this->load->model('manufacturer_model');
        $this->data['manufacturers'] = $this->manufacturer_model->get_all();

        if($_POST)
        {
            $id = $this->part_list_model->insert(array(
                'manufacturer_id' => $this->input->post('manufacturer_id'),
                'name' => $this->input->post('name'),
                'imprest' => ($this->input->post('imprest') == 1) ? 1 : 0,
            ));

            if($id) {
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Part list added.'
                ));
                redirect($this->uri->segment(1) . '/part_lists/' . $id);
            }
            else {
                $this->session->set_flashdata('alert', array(
                    'type' => 'error',
                    'message' => validation_errors()
                ));
                redirect($this->uri->segment(1) . '/part_lists/add');
            }
        }
    }

    public function image($list_id, $part_id) {
        $this->load->model('part_list_part_model');
        $this->load->model('part_model');
        $this->data['part_list'] = $this->part_list_model->get($list_id);
        $this->data['part'] = $this->part_list_part_model->get($part_id);
        $this->data['part']['image'] = $this->part_model->check_image($this->data['part']['pnumber']);

        // new image upload
        if(isset($_FILES['picture']['name']))
        {
            //ini_set("memory_limit","200M"); // why not? shouldnt have bought such an expensive camara!

            $fileinfo = array (
                array('name' => $this->data['part']['pnumber'] . '.jpg', 'width' => 75, 'height' => 56),
                array('name' => $this->data['part']['pnumber'] . '_1.jpg', 'width' => 500, 'height' => 375)
            );

            $filename_base = FCPATH . '/assets/img/parts/catalog/';
            $filename = $filename_base . $this->data['part']['pnumber'] . "_o.jpg";
            move_uploaded_file($_FILES['picture']["tmp_name"], $filename);
            list($width_orig, $height_orig) = getimagesize($filename);
            $ratio_orig = $width_orig / $height_orig;
            $image = imagecreatefromjpeg($filename);

            foreach($fileinfo as $dim)
            {
                $output_filename = $filename_base . $dim['name'];
                $width = $dim['width'];
                $height = $dim['height'];
                if($dim['name'] == 'medium' && $width/$height > $ratio_orig)
                {
                    $height = $width/$ratio_orig;
                }
                else
                {
                    if ($width/$height > $ratio_orig) $width = $height*$ratio_orig;
                    else $height = $width/$ratio_orig;
                }
                $image_p = imagecreatetruecolor($width, $height);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($image_p, $output_filename, 80);
                imagedestroy($image_p);
            }
            imagedestroy($image);
            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Image upload completed',
            ));
            redirect($this->uri->segment(1) . '/part_lists/image/' . $list_id . '/' . $part_id);
        }
    }

}
//EOF
