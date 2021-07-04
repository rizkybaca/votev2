<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Voting_model extends CI_Model
{
	public function getUserBySession()
	{
		return $data['user']=$this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();
	}

	public function getAllCandidate()
	{
		return $this->db->get('candidate')->result_array();
	}
	
}