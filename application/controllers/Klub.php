<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Klub extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies

	}

	// List all your items
	public function index()
	{
		$this->load->model('klub_model');
		$data["klub_list"] = $this->klub_model->getDataKlub();
		$this->load->view('klub_datatable',$data);
	}

	public function datatable()
	{
		$this->load->model('klub_model');
		$data["klub_list"] = $this->klub_model->getDataKlub();
		$this->load->view('klub_datatable',$data);
	}

	// Add a new item
	public function create()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->load->model('klub_model');	
		if($this->form_validation->run()==FALSE){
			$this->load->view('tambah_klub_view');

		}else{
				$config['upload_path']          = './assets/uploads/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = '1000000000';
                $config['max_width']            = '10240';
                $config['max_height']           = '7680';

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());
						$this->load->view('tambah_klub_view',$error);
                }
                else
                {
						$this->klub_model->insertKlub();
						$this->session->set_flashdata('input', 'Data Berhasil di Inputkan');
						redirect('klub');

                }

	}
}

	//Update one item
	public function update( $id )
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		//sebelum update data harus ambil data lama yang akan di update
		$this->load->model('klub_model');
		$data['klub']=$this->klub_model->getKlub($id);
		$filename='logo';

		//skeleton code
		if($this->form_validation->run()==FALSE){

		//setelah load data dikirim ke view
			$this->load->view('edit_klub_view',$data);

		}else{
				$config['upload_path']          = './assets/uploads/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = '1000000000';
                $config['max_width']            = '10240';
                $config['max_height']           = '7680';

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());
						$this->load->view('tambah_klub_view',$error);
                }
                else
                {		
                		$image_data = $this->upload->data();
                		$configer=array(
                			'image_library' => 'gd2',
                			'sourcer_image' => $image_data['full_path'],
                			'mintain_ratio' => TRUE,
                			'width' 		=> '250',
                			'height'		=> '250',
                			);
                		$this->load->library('image_lib', $config);
                		$this->image_lib->clear();
                		$this->image_lib->initialize($configer);
                		$this->image_lib->resize();
                		$this->klub_model->updateById($id);
						$this->session->set_flashdata('input', 'Data Berhasil di Update');
						redirect('klub');

                }


			$this->klub_model->updateById($id);
			$this->session->set_flashdata('update', 'Data Berhasil di Update');
			redirect('klub');

		}
	}

	//Delete one item
	public function delete( $id )
	{
		$this->load->helper('url','form');
		$this->load->model('klub_model');
		$this->klub_model->deleteById($id);
		$this->session->set_flashdata('pesan', 'Data Berhasil di Hapus');
		redirect('klub');
	}
}

/* End of file Klub.php */
