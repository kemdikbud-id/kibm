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
		$mahasiswa = $this->session->user->mahasiswa;
		$meeting_set = $this->meeting_model->list_with_mahasiswa($kegiatan->id, $mahasiswa->id);

		$this->smarty->assign('kegiatan', $kegiatan);
		$this->smarty->assign('meeting_set', $meeting_set);
		$this->smarty->display();
	}
	
	public function register($meeting_id)
	{
		$meeting = $this->meeting_model->get_single($meeting_id);
		$mahasiswa = $this->session->user->mahasiswa;
		
		if (!$this->meeting_model->is_peserta_exist($meeting->id, $mahasiswa->id))
		{
			$this->meeting_model->add_peserta($meeting->id, $mahasiswa->id);
		}
		
		$kegiatan = $this->kegiatan_model->get_single($meeting->kegiatan_id);
		
		$this->session->set_flashdata('result', [
			'page_title' => "Program Online Workshop <small>Tahun {$kegiatan->tahun}</small>",
			'message' => 'Pendaftaran workshop berhasil. Pastikan mengingat jadwal.',
			'link_1' => anchor('home', 'Kembali ke Beranda'),
			'link_2' => anchor('online-workshop', 'Kembali ke Daftar Online Workshop')
		]);
		
		redirect('alert/success');
	}
}