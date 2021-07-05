<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model', 'admin');
		
	}

	public function index()
	{

		$data['title']='Dashboard';
		$data['user']=$this->admin->getUserBySession();
		$data['v']=$this->admin->getVoterStat();
		

		$data['candidate']=$this->admin->getCandidateStat();
		$data['vote']=$this->admin->getVoteStat();

		$this->load->view('templates/chart_header', $data);
		$this->load->view('templates/chart_sidebar', $data);
		$this->load->view('templates/chart_topbar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/chart_footer');
	}

	public function role()
	{
		$data['title']='Role';
		$data['user']=$this->admin->getUserBySession();
		$data['role']=$this->db->get('user_role')->result_array();

		$this->form_validation->set_rules('role', 'Role', 'required|trim');

		if ($this->form_validation->run()==FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/role', $data);
			$this->load->view('templates/footer');
		} else {
			$this->db->insert('user_role', ['role'=>$this->input->post('role')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role added.</div>');
			redirect('admin/role');
		}
		
	}

	public function roleEdit($id)
	{
		$data['title']='Form Edit Role';
		$data['user']=$this->admin->getUserBySession();
		$data['role']=$this->admin->getRoleById($id);
		
		$this->form_validation->set_rules('role', 'Role', 'required|trim');
		
		if ($this->form_validation->run()==FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/role-edit', $data);
			$this->load->view('templates/footer');
		}
		else{
			$this->admin->editDataRole($id);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role updated!</div>');
			redirect('admin/role');
		}	
	}

	public function roleDelete($id)
	{
		$this->admin->deleteRole($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role deleted!</div>');
		redirect('admin/role');
	}

	public function roleaccess($role_id)
	{
		$data['title']='Role Access';
		$data['user']=$this->admin->getUserBySession();
		$data['role']=$this->db->get_where('user_role', ['id'=>$role_id])->row_array();

		$this->db->where('id !=', 1);
		$data['menu']=$this->db->get('user_menu')->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/role-access', $data);
		$this->load->view('templates/footer');
	}

	public function changeaccess()
	{
		$menu_id=$this->input->post('menuId');
		$role_id=$this->input->post('roleId');

		$data=[
			'role_id'=>$role_id,
			'menu_id'=>$menu_id
		];

		$result=$this->db->get_where('user_access_menu', $data);

		if ($result->num_rows()<1) {
			$this->db->insert('user_access_menu', $data);
		} else {
			$this->db->delete('user_access_menu', $data);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access changed!</div>');
	}


	public function editCandidate()
	{
		$data['user']=$this->admin->getUserBySession();
		if ($this->form_validation->run()==FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer');
		} else {
			$name=$this->input->post('name');
			$nim=$this->input->post('nim');

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
					$this->db->set('image', $new_image);
				} else {
					echo $this->upload->display_errors();
				}

			}

			$this->db->set('name', $name);
			$this->db->where('nim', $nim);
			$this->db->update('user');

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
			redirect('user');
		}
	}

	public function activate()
	{

		$data['title']='Activate User';
		$data['user']=$this->admin->getUserBySession();
		$data['committees']=$this->admin->getAllCommittees();
		$data['voter']=$this->admin->getAllVoter();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/activate-user', $data);
		$this->load->view('templates/footer');
	}

	public function activateCommittees()
	{
		$data=['is_active'=>1];

		$this->db->where('role_id', "4");
		$this->db->update('user', $data);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Committees now is active!</div>');
		redirect('admin/activate');
	}

	public function nonActivateCommittees()
	{
		$data=['is_active'=>0];

		$this->db->where('role_id', "4");
		$this->db->update('user', $data);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Committees now is nonactive!</div>');
		redirect('admin/activate');
	}

	public function activateVoter()
	{
		$data=['is_active'=>1];

		$this->db->where('role_id', "2");
		$this->db->update('user', $data);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Voter now is active!</div>');
		redirect('admin/activate');
	}

	public function nonActivateVoter()
	{
		$data=['is_active'=>0];

		$this->db->where('role_id', "2");
		$this->db->update('user', $data);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Voter now is nonactive!</div>');
		redirect('admin/activate');
	}



}