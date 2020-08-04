<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model 
 * @property Proposal_model $proposal_model
 * @property Meeting_model $meeting_model
 * @property PerguruanTinggi_model $pt_model
 */
class Home extends Mahasiswa_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->check_credentials();
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_MEETING, 'meeting_model');
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
	}
	
	public function index()
	{
		$kegiatan_kbmi = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);
		$kegiatan_startup = $this->kegiatan_model->get_aktif(PROGRAM_STARTUP);
		$kegiatan_online_workshop = $this->kegiatan_model->get_aktif(PROGRAM_ONLINE_WORKSHOP);
		$mahasiswa = $this->session->user->mahasiswa;
		
		$proposal_kbmi_set = $this->proposal_model->list_by_mahasiswa($mahasiswa->id, PROGRAM_KBMI);
		$proposal_startup_set = $this->proposal_model->list_by_mahasiswa($mahasiswa->id, PROGRAM_STARTUP);
		$meeting_set = $this->meeting_model->list_by_mahasiswa($mahasiswa->id);
		$pt = $this->pt_model->get_single($mahasiswa->perguruan_tinggi_id);

		// Mendapatkan jenis program Akademik / Vokasi / Disabilitas
		if ($mahasiswa->is_disabilitas)
		{
			$jenis_program = 'Disabilitas';
		}
		else if ($pt->bentuk_pendidikan_id == 20)
		{
			$jenis_program = 'Vokasi';
		}
		else
		{
			$jenis_program = 'Akademik';
		}
		
		$this->smarty->assign('kegiatan_kbmi', $kegiatan_kbmi);
		$this->smarty->assign('kegiatan_startup', $kegiatan_startup);
		$this->smarty->assign('proposal_kbmi_set', $proposal_kbmi_set);
		$this->smarty->assign('proposal_startup_set', $proposal_startup_set);
		$this->smarty->assign('meeting_set', $meeting_set);
		$this->smarty->assign('jenis_program', $jenis_program);
		$this->smarty->display();
	}
}
