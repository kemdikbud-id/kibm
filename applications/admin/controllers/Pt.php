<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property PerguruanTinggi_model $pt_model
 * @property Program_studi_model $prodi_model
 */
class Pt extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
		$this->load->model(MODEL_PROGRAM_STUDI, 'prodi_model');
	}
	
	public function index()
	{
		$this->smarty->display();
	}
	
	public function data_pt_all()
	{
		$data_set = $this->pt_model->list_all();
		echo json_encode(array('data' => $data_set));
	}
	
	public function sinkronisasi()
	{
		$kode_pt = $this->input->post('kode_pt');
		$sync_result = $this->pt_model->sync_pt_dikti($kode_pt);
		
		header('Content-type: application/json');
		echo json_encode($sync_result);
	}
	
	public function program_studi($perguruan_tinggi_id)
	{
		$pt = $this->pt_model->get_single($perguruan_tinggi_id);
		$prodi_set = $this->prodi_model->list_by_pt($pt->npsn);
		
		$this->smarty->assign('pt', $pt);
		$this->smarty->assign('prodi_set', $prodi_set);
		$this->smarty->display();
	}
}
