<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->form_validation->set_rules('nim', 'NIM', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if ($this->form_validation->run()==FALSE) {
			$data['title']='HMP evotingV2 | Login Page';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$nim=$this->input->post('nim');
		$password=$this->input->post('password');

		$user=$this->db->get_where('user', ['nim'=>$nim])->row_array();

		if ($user) {
			if ($user['is_active']==1) {
				if (password_verify($password, $user['password'])) {
					$data=[
						'nim'=>$user['nim'],
						'role_id'=>$user['role_id']
					];
					$this->session->set_userdata($data);
					redirect('user/index');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah!</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Belum waktunya akses!.</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIM belum terdaftar! Hubungi pantita untuk lebih lanjut.</div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('nim');
		$this->session->unset_userdata('role_id');


		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda telah berhasil logout!</div>');
		redirect('auth');
	}


}