<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation', 'session'));
	}


	function index()
	{
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|required');
		if($this->form_validation->run() == FALSE) {
			$this->load->view('login/login_v');
		} else {
			$this->_login();
		}
	}
	function _login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('users',['email' =>$email])->row_array();

		if($user){
			if(password_verify($password,$user['password'])){
				$data = ['email' => $user['email']];
				$this->session->set_userdata($data);
				redirect(base_url('user/user'));
			}else{
				$this->session->set_flashdata('message','<div class="alert
			alert-danger" role="alert">Wrong password!</div>');
			redirect(base_url('login'));
			}

		}else{
			$this->session->set_flashdata('message','<div class="alert
			alert-danger" role="alert">Email is not registered!</div>');
			redirect(base_url('login'));
		}
	}
	public function logout(){
		$this->session->unset_userdata('email');

		$this->session->set_flashdata('message','<div class="alert
		alert-danger" role="alert">You Have been logout!</div>');
		redirect(base_url('login'));
		}

}
?>