<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model');
		
	}

	public function index()
	{
		$data['title']='Candidate';
		$data['user']=$this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();
		$data['candidate']=$this->db->get('candidate')->result_array();

		$this->form_validation->set_rules('nim', 'NIM', 'required|trim|is_unique[candidate.nim, user.nim]|numeric');
		$this->form_validation->set_rules('name', 'Full name', 'required|trim');
		$this->form_validation->set_rules('vision', 'Vision', 'required|trim');
		$this->form_validation->set_rules('mission', 'Mission', 'required|trim');
		if ($this->form_validation->run()==FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/candidate', $data);
			$this->load->view('templates/footer');
		} else {
			$data['candidate']=$this->admin->addCandidate();
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New candidate success created!</div>');
			redirect('admin/candidate');
		}
	}