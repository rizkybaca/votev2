<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Voting_model', 'voting');
	}

	public function index()
	{
		$data['title']='Voting';
		$data['user']=$this->voting->getUserBySession();
		$data['candidate']=$this->voting->getAllCandidate();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('voting/index', $data);
		$this->load->view('templates/footer');
	}

}