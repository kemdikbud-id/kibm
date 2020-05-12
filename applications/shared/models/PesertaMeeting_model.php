<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_Input $input
 */
class PesertaMeeting_model extends CI_Model
{
	public function list_all_by_meeting($meeting_id)
	{
		return $this->db
			->select('pm.id, pt.nama_pt, m.nim, m.nama, pm.kehadiran_1, pm.kehadiran_2')
			->from('peserta_meeting pm')
			->join('mahasiswa m', 'm.id = pm.mahasiswa_id')
			->join('perguruan_tinggi pt', 'pt.id = m.perguruan_tinggi_id')
			->where('pm.meeting_id', $meeting_id)
			->get()->result();
	}
}
