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

	public function getVoterById($id)
	{
		return $this->db->get_where('user', ['role_id'=>'2', 'id'=>$id])->row_array();
	}

	public function save($data)
  {
      return $this->db->insert('user', $data);
  }

  public function getAllCandidate()
	{
		return $this->db->get('candidate')->result_array();
	}

	public function getCandidateById($id)
	{
		return $this->db->get_where('candidate', ['id'=>$id])->row_array();
	}

	public function deleteDataCandidate($id)
	{ 
    $this->db->delete('candidate', ['id'=>$id]);
	}

	public function importDataVoter($data)
	{
		$count=count($data);
		if ($count>0) {
			$this->db->replace('user', $data);
		}
	}

	public function editDataVoter($id)
	{
		$data=[
			'nim'=>$this->input->post('nim', true),
			'name'=>$this->input->post('name', true)
		];
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('user', $data);
	}

	public function deleteDataVoter($id)
	{
		$this->db->delete('user', ['id'=>$id]);
	}



}