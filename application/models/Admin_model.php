<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Admin_model extends CI_Model
{

	public function addCandidate()
	{
		$data=[
			'nim'=>$this->input->post('nim', true),
			'name'=>$this->input->post('name', true),
			'image'=>$this->input->post('image', true),
			'vision'=>$this->input->post('vision', true)
		];
		$upload_image=$_FILES['image']['name'];

			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']     = '2048';
				$config['upload_path'] = './assets/img/profile/';
				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					$old_image=$data['user']['image'];

					if ($old_image != 'default.jpg') {
						unlink(FCPATH.'assets/img/profile/'.$old_image);
					}

					$new_image=$this->upload->data('file_name');
					$data=['image' => $new_image];
				} else {
					echo $this->upload->display_errors();
				}
			}
		return $this->db->insert('candidate', $data);
	}
}