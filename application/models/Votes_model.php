<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Votes_model extends CI_Model
{
	public function __construct() {
    parent::__construct();
  }

	public function getUserBySession()
	{
		return $data['user']=$this->db->get_where('user', ['nim' => $this->session->userdata('nim')])->row_array();
	}

	public function getAllVoter()
	{
		return $this->db->get_where('user', ['role_id'=>'2'])->result_array();
	}

	public function save($data)
    {
        return $this->db->insert('user', $data);
    }

  public function getAllCandidate()
	{
		return $this->db->get('candidate')->result_array();
	}


}