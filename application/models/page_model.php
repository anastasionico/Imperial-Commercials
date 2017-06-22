<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Page_model extends MY_Model {

//    protected $module_id = 1;

    public $before_create = array( 'created_at', 'updated_at' );

    public $protected_attributes = array( 'id' );

    public function create($domain_id, $template_name)
    {
        $address = (substr($this->input->post('url'), 0, 1) == '/') 
            ? substr($this->input->post('url'), 1)
            : $this->input->post('url');

        $page_id = $this->insert(array(
            'domain_id' => $domain_id,
            'name' => $this->input->post('name'),
            'address' => $address,
            'template' => $template_name,
        ));

        $this->db->insert('page_content', array(
            'page_id' => $page_id,
            'name' => 'main',
            'friendly_name' => 'Main',
            'type' => 'tinymce',
            'content' => $this->input->post('content'),
        ));

        return $page_id;
    }

    public function post_form_submit($form)
    {
        switch($form) {
        case 'callme':
          $subject = 'Contact us: call back form submit';
          $message = 'URL : ' . $this->input->post('request_page') . '<br>';
          $message .= 'Name First: ' . $this->input->post('name_first') . '<br>';
          $message .= 'Name Last: ' . $this->input->post('name_last') . '<br>';
          $message .= 'Number : ' . $this->input->post('number') . '<br>';
          $message .= 'Day : ' . $this->input->post('day') . '<br>';
          $message .= 'Time : ' . $this->input->post('time') . '<br>';
          $message .= 'Message : ' . $this->input->post('message') . '<br>';
          if($this->input->post('informed') == 'on') {
              $message .= 'Informed Tickbox : checked<br>';
          }
          else {
              $message .= 'Informed Tickbox : not checked<br>';
          }
          break;
        case 'part_exchange':
          $subject = 'Contact us: Part Exchange form submit';
          $message = 'URL : ' . $this->input->post('request_page') . '<br>';
          $message .= 'Name First: ' . $this->input->post('name_first') . '<br>';
          $message .= 'Name Last: ' . $this->input->post('name_last') . '<br>';
          $message .= 'Number : ' . $this->input->post('number') . '<br>';
          $message .= 'Email : ' . $this->input->post('email') . '<br>';
          $message .= 'Vehicle REG : ' . $this->input->post('reg') . '<br>';
          $message .= 'Message : ' . $this->input->post('message') . '<br>';
          if($this->input->post('informed') == 'on') {
              $message .= 'Informed Tickbox : checked<br>';
          }
          else {
              $message .= 'Informed Tickbox : not checked<br>';
          }
          break;
        case 'enquiry':
          $subject = 'Contact us: Enquiry form submit';
          $message = 'URL : ' . $this->input->post('request_page') . '<br>';
          $message .= 'Name First: ' . $this->input->post('name_first') . '<br>';
          $message .= 'Name Last: ' . $this->input->post('name_last') . '<br>';
          $message .= 'Number : ' . $this->input->post('number') . '<br>';
          $message .= 'Email : ' . $this->input->post('email') . '<br>';
          $message .= 'Message : ' . $this->input->post('message') . '<br>';
          if($this->input->post('informed') == 'on') {
              $message .= 'Informed Tickbox : checked<br>';
          }
          else {
              $message .= 'Informed Tickbox : not checked<br>';
          }
          break;
        case 'test_drive':
          $subject = 'Contact us: test drive form submit';
          $message = 'URL : ' . $this->input->post('request_page') . '<br>';
          $message .= 'Name First: ' . $this->input->post('name_first') . '<br>';
          $message .= 'Name Last: ' . $this->input->post('name_last') . '<br>';
          $message .= 'Number : ' . $this->input->post('number') . '<br>';
          $message .= 'Email : ' . $this->input->post('email') . '<br>';
          $message .= 'Message : ' . $this->input->post('message') . '<br>';
          if($this->input->post('informed') == 'on') {
              $message .= 'Informed Tickbox : checked<br>';
          }
          else {
              $message .= 'Informed Tickbox : not checked<br>';
          }
          break;
        case 'book_service':
          $subject = 'Contact us: Book service form submit';
          $message = 'URL : ' . $this->input->post('request_page') . '<br>';
          $message .= 'Name First: ' . $this->input->post('name_first') . '<br>';
          $message .= 'Name Last: ' . $this->input->post('name_last') . '<br>';
          $message .= 'Number : ' . $this->input->post('number') . '<br>';
          $message .= 'Email : ' . $this->input->post('email') . '<br>';
          $message .= 'Vehicle REG : ' . $this->input->post('reg') . '<br>';
          $message .= 'Message : ' . $this->input->post('message') . '<br>';
          if($this->input->post('informed') == 'on') {
              $message .= 'Informed Tickbox : checked<br>';
          }
          else {
              $message .= 'Informed Tickbox : not checked<br>';
          }
          break;
        }

        $this->emailnote('hello@imperialcommercials.co.uk', $subject, $message);
        //$this->emailnote('tom.hughes@imperialuk.co.uk', $subject, $message);

        return TRUE;
    }

    public function emailnote($to, $subject, $message) {
        $htmessage = "<html>
            <head>
            <title>" . $subject . "</title>
            </head>
            <body>
            " . $message . "
            </body>
            </html>";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//        $headers .= 'To: <' . $to . '>' . "\r\n"; // seems to duplicate
        $headers .= 'From: NOTIFICATION EMAIL<sbcommercialsplc@gmail.com>' . "\r\n";

        mail($to, $subject, $htmessage, $headers);
        return;
    }

}
//EOF
