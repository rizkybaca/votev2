<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

	public function index()
	{
		$data['user']=$this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();
		echo "Welcome, ". $data['user']['name'];
	}

}