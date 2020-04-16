 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class Register extends CI_Controller {
     
     function __construct(){
         parent::__construct();
         $this->load->library(array('form_validation'));
         $this->load->helper(array('url','form'));
         $this->load->model('m_account'); //call model
     }
 
     public function index() {
		 
        $this->form_validation->set_rules('nama', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim','valid_email');
        $this->form_validation->set_rules('password1', 'Password', 'required|min_length[8]','matches[password2]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password1]');
         if($this->form_validation->run() == FALSE) {
             $this->load->view('register/register_v');
         }else{

            $data = array(
            'nama' => htmlspecialchars($this->input->post('nama',true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'username' => htmlspecialchars($this->input->post('username',true)),
            'password' => md5($this->input->post('password1'),PASSWORD_DEFAULT),
			
        );
			$this->m_account->daftar($data);


            redirect(base_url('login/login'));
		 } 
         
     }
 
 }