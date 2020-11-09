<?php

/**
 * Class LaporanPendampingan_model
 * @property CI_DB_query_builder $db
 */
class LaporanPendampingan_model extends CI_Model
{
	public function get_single($tahapan_pendampingan_id, $proposal_id)
	{
		return $this->db->get_where('laporan_pendampingan', [
			'tahapan_pendampingan_id' => $tahapan_pendampingan_id,
			'proposal_id' => $proposal_id
		], 1)->first_row();
	}

	public function list_by_dosen($dosen_id, $kegiatan_id)
	{
		return $this->db
			->select('lp.id, lp.proposal_id, lp.tahapan_pendampingan_id, length(lp.laporan) as laporan')
			->select('lp.created_at', 'lp.updated_at')
			->from('laporan_pendampingan lp')
			->join('proposal p', 'p.id = lp.proposal_id')
			->where('p.kegiatan_id', $kegiatan_id)
			->where('p.dosen_id', $dosen_id)
			->get()->result();
	}

	public function add($laporan_pendampingan)
	{
		return $this->db->insert('laporan_pendampingan', $laporan_pendampingan);
	}

	public function update($laporan_pendampingan)
	{
		return $this->db->update('laporan_pendampingan', $laporan_pendampingan, ['id' => $laporan_pendampingan->id]);
	}
}
