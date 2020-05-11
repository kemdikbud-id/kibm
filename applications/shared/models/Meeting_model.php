<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Meeting_model extends CI_Model
{
	public function list_all($kegiatan_id)
	{
		return $this->db
			->order_by('waktu_mulai ASC')
			->get_where('meeting', ['kegiatan_id' => $kegiatan_id])->result();
	}
	
	/**
	 * Mendapatkan list meeting / online workshop berdasarkan mahasiswa
	 * @param int $mahasiswa_id
	 * @param int $kegiatan_id
	 */
	public function list_by_mahasiswa($mahasiswa_id)
	{
		return array();
	}
	
	public function add()
	{
		$post = $this->input->post();
		
		$meeting = new stdClass();
		$meeting->kegiatan_id = $post['kegiatan_id'];
		$meeting->topik = $post['topik'];
		$meeting->pemateri = $post['pemateri'];
		$meeting->waktu_mulai = "{$post['waktu_mulai_Year']}-{$post['waktu_mulai_Month']}-{$post['waktu_mulai_Day']} {$post['waktu_mulai_time']}";
		$meeting->meeting_url = $post['meeting_url'];
		$meeting->meeting_password = $post['meeting_password'];
		$meeting->tgl_awal_registrasi = "{$post['awal_registrasi_Year']}-{$post['awal_registrasi_Month']}-{$post['awal_registrasi_Day']} {$post['awal_registrasi_time']}";
		$meeting->tgl_akhir_registrasi = "{$post['akhir_registrasi_Year']}-{$post['akhir_registrasi_Month']}-{$post['akhir_registrasi_Day']} {$post['akhir_registrasi_time']}";
		$meeting->kode_kehadiran_1 = $post['kode_kehadiran_1'];
		$meeting->kode_kehadiran_2 = $post['kode_kehadiran_2'];
		$meeting->kapasitas = $post['kapasitas'];
		return $this->db->insert('meeting', $meeting);
	}
	
	public function get_single($id)
	{
		return $this->db->get_where('meeting', ['id' => $id], 1)->row();
	}
	
	public function update($id)
	{
		$post = $this->input->post();
		
		$meeting = $this->get_single($id);
		$meeting->topik = $post['topik'];
		$meeting->pemateri = $post['pemateri'];
		$meeting->waktu_mulai = "{$post['waktu_mulai_Year']}-{$post['waktu_mulai_Month']}-{$post['waktu_mulai_Day']} {$post['waktu_mulai_time']}";
		$meeting->meeting_url = $post['meeting_url'];
		$meeting->meeting_password = $post['meeting_password'];
		$meeting->tgl_awal_registrasi = "{$post['awal_registrasi_Year']}-{$post['awal_registrasi_Month']}-{$post['awal_registrasi_Day']} {$post['awal_registrasi_time']}";
		$meeting->tgl_akhir_registrasi = "{$post['akhir_registrasi_Year']}-{$post['akhir_registrasi_Month']}-{$post['akhir_registrasi_Day']} {$post['akhir_registrasi_time']}";
		$meeting->kode_kehadiran_1 = $post['kode_kehadiran_1'];
		$meeting->kode_kehadiran_2 = $post['kode_kehadiran_2'];
		$meeting->kapasitas = $post['kapasitas'];
		
		return $this->db->update('meeting', $meeting, ['id' => $id]);
	}
}
