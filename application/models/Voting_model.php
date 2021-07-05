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

	public function getCandidateStat()
	{
		$q="SELECT `vote`.*, `candidate`.`name`
					FROM `vote` JOIN `candidate`
					ON `vote`.`candidate_id` = `candidate`.`id`
					ORDER BY `candidate`.`id` ASC 					
				";
		return $this->db->query($q)->result_array();
	}

	public function getVoteStat()
	{
		$q="SELECT
					COUNT(`id`) AS `voting`
					FROM `vote`
					GROUP BY `candidate_id` 					
				";
		return $this->db->query($q)->result_array();
	}



	public function getCandidateById($id)
	{
		return $this->db->get_where('candidate', ['id'=>$id])->row_array();
	}

	public function getAllVote()
	{
		return $this->db->get('vote')->result_array();
	}
	
}