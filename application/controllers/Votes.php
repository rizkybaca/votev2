<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Votes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Votes_model', 'votes');

	}

  public function candidate()
  {
    $data['title']='Candidates';
    $data['user']=$this->votes->getUserBySession();
    $data['candidate']=$this->votes->getAllCandidate();

    $this->form_validation->set_rules('nim', 'NIM', 'required|trim|is_unique[candidate.nim]|numeric');
    $this->form_validation->set_rules('name', 'Full name', 'required|trim');
    $this->form_validation->set_rules('vision', 'Vision', 'required|trim');
    $this->form_validation->set_rules('mission', 'Mission', 'required|trim');

    if ($this->form_validation->run()==FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('votes/candidate', $data);
      $this->load->view('templates/footer');
    } else {
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
        } else {
          echo $this->upload->display_errors();
        }

      }

    $data=[
      'nim'=>$this->input->post('nim', true),
      'name'=>$this->input->post('name', true),
      'image'=>$new_image,
      'vision'=>$this->input->post('vision', true),
      'mission'=>$this->input->post('mission', true)
    ];
    $this->db->insert('candidate', $data);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Candidate added!</div>');
    redirect('votes/candidate');
    }
  }

  public function editCandidate($id) {
    $data['title']='Edit Candidate';
    $data['user']=$this->votes->getUserBySession();
    $data['candidate']=$this->votes->getCandidateById($id);

    $this->form_validation->set_rules('nim', 'NIM', 'required|trim');
    $this->form_validation->set_rules('name', 'Full name', 'required|trim');
    $this->form_validation->set_rules('vision', 'Vision', 'required|trim');
    $this->form_validation->set_rules('mission', 'Mission', 'required|trim');
    
    if ($this->form_validation->run()==FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('votes/candidate-edit', $data);
      $this->load->view('templates/footer');
    } else {
      
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
      $this->db->where('id', $this->input->post('id'));
      $this->db->update('candidate');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Candidate updated!</div>');
      redirect('votes/candidate');
    }
  }

  public function deleteCandidate($id)
  {
    $data['candidate']=$this->votes->getCandidateById($id);
    $old_image=$data['candidate']['image'];
    if ($old_image != 'default.jpg') {
      unlink(FCPATH.'assets/img/candidate/'.$old_image);
    }
    $this->votes->deleteDataCandidate($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Candidate deleted!</div>');
    redirect('votes/candidate');
  }

	public function voter()
	{
		$data['title']='Voter';
		$data['user']=$this->votes->getUserBySession();
		$data['voter']=$this->votes->getAllVoter();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('votes/voter', $data);
		$this->load->view('templates/footer');
	}

	public function import()
  {
    if ( isset($_POST['upload'])) {

      $file = $_FILES['file']['tmp_name'];

      // Medapatkan ekstensi file csv yang akan diimport.
      $ekstensi  = explode('.', $_FILES['file']['name']);

      // Tampilkan peringatan jika submit tanpa memilih menambahkan file.
      if (empty($file)) {
        echo 'File tidak boleh kosong!';
      } else {
        // Validasi apakah file yang diupload benar-benar file csv.
        if (strtolower(end($ekstensi)) === 'csv' && $_FILES["file"]["size"] > 0) {

          $i = 0;
          $handle = fopen($file, "r");
          while (($row = fgetcsv($handle, 2048))) {
          $i++;
          if ($i == 1) continue;

          // Data yang akan disimpan ke dalam databse
          $data = [
            'nim' => $row[1],
            'password' => $row[2],
            'name' => $row[3],
            'role_id' => $row[4],
            'is_active' => $row[5],
          ];

          // Simpan data ke database.
          $this->votes->save($data);
          }

          fclose($handle);
          redirect('votes/voter');

        } else {
          echo 'Format file tidak valid!';
        }
      }
      }
  }


}