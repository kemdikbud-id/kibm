<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model 
 * @property Meeting_model $meeting_model
 * @property PesertaMeeting_model $peserta_model
 */
class Online_workshop extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_MEETING, 'meeting_model');
		$this->load->model(MODEL_PESERTA_MEETING, 'peserta_model');
	}
	
	public function peserta()
	{
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_online_workshop());
		
		if ($this->input->get('meeting_id'))
		{
			$this->smarty->assign('meeting_set', $this->meeting_model->list_all($this->input->get('kegiatan_id')));
			$this->smarty->assign('data_set', $this->peserta_model->list_all_by_meeting($this->input->get('meeting_id')));
		}
		
		$this->smarty->display();
	}
	
	/**
	 * Ajax Request
	 */
	public function data_meeting($id = 0)
	{
		$meeting_set = $this->meeting_model->list_all($id);
		
		foreach ($meeting_set as &$meeting)
		{
			$meeting->waktu_mulai = strftime('%d %B %Y', strtotime($meeting->waktu_mulai));
		}
		
		echo json_encode($meeting_set);
	}
}
