<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model 
 * @property Meeting_model $meeting_model
 */
class Online_workshop extends Mahasiswa_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->check_credentials();
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_MEETING, 'meeting_model');
	}
	
	public function index()
	{
		$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_ONLINE_WORKSHOP);
		$meeting_set = $this->meeting_model->list_all($kegiatan->id);

		$this->smarty->assign('kegiatan', $kegiatan);
		$this->smarty->assign('meeting_set', $meeting_set);
		$this->smarty->display();
	}
	
	public function register($meeting_id)
	{
		$this->smarty->display();
	}
}