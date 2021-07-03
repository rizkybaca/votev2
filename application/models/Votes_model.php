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

	public function getCandidateById($id)
	{
		return $this->db->get_where('candidate', ['id'=>$id])->row_array();
	}

	public function editDataCandidate()
	{
		$idn 			= $this->input->post('id', true);
    $nim      = $this->input->post('nim', true);
    $name     = $this->input->post('name', true);
    $vision   = $this->input->post('vision', true);
    $mission  = $this->input->post('mission', true);
    
    $upload_image=$_FILES['image']['name'];

    if ($upload_image) {
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size']     = '2048';
      $config['upload_path'] = './assets/img/candidate/';
      $this->load->library('upload', $config);

      if ($this->upload->do_upload('image')) {
        $old_image=$data['candidate']['image'];

        if ($old_image != 'default.jpg') {
          unlink(FCPATH.'assets/img/candidate/'.$old_image);
        }

        $new_image=$this->upload->data('file_name');
        $this->db->set('image', $new_image);
      } else {
        echo $this->upload->display_errors();
      }
    }
    
    $this->db->set('nim', $nim);
    $this->db->set('name', $name);
    $this->db->set('vision', $vision);
    $this->db->set('mission', $mission);
    $this->db->where('id', $idn);
    $this->db->update('candidate');
	}


}