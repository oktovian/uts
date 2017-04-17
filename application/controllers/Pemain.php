<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemain extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies

	}

	// List all your items
	public function index( $idKlub )
	{
		$this->load->model('klub_model');		
		$data["pemain_list"] = $this->klub_model->getKlubByPemain($idKlub);
		$this->load->view('pemain', $data);
	}
	public function create($idKlub)
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Pemain', 'trim|required');
		$this->form_validation->set_rules('posisi', 'Posisi', 'trim|required');
		$this->load->model('klub_model');	
		if($this->form_validation->run()==FALSE){
			$this->load->view('tambah_pemain_view');

		}else{
			
				$this->klub_model->insertPemain($idKlub);
				$this->session->set_flashdata('input', 'Data Berhasil di Inputkan');
				redirect('pemain');

              }
	}

	//Update one item
	public function update( $id = NULL )
	{

	}

	//Delete one item
	public function delete( $id = NULL )
	{

	}
}

/* End of file Pemain.php */
/* Location: ./application/controllers/Pemain.php */
