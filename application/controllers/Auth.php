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
		if ($this->session->userdata('nim')) {
			redirect('user');
		}
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
					if ($user['role_id']==1) {
						redirect('admin/index');
					} else {
						redirect('voter/index');
					}
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

	public function regist()
	{
		if ($this->session->userdata('nim')) {
			redirect('user');
		}

		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('nim', 'NIM', 'required|trim|is_unique[user.nim]', [
			'is_unique' => 'Nim has already registered!'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]|matches[password2]', [
			'matches' => 'Password dont match!',
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');


		if ($this->form_validation->run()==FALSE) {
			$data['title']='CI | Registration Page';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/regist');
			$this->load->view('templates/auth_footer');
		} else {
			$data=[
				'name'=>htmlspecialchars($this->input->post('name', true)),
				'nim'=>htmlspecialchars($this->input->post('nim', true)),
				'password'=>htmlspecialchars(password_hash($this->input->post('password1', true), PASSWORD_DEFAULT)),
				'role_id'=>1,
				'is_active'=>1,
				'date_created'=>time()
			];
			$this->db->insert('user', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat! Akunmu telah dibuat. Silakan login!</div>');
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

	public function blocked()
	{
		$data['title']='My Profile';
		$this->load->view('auth/blocked',$data);

	}


}