<?php

/**
 * Class TahapanPendampingan_model
 * @property CI_DB_query_builder $db
 * @property string $tgl_awal_laporan
 * @property string $tgl_akhir_laporan
 */
class TahapanPendampingan_model extends CI_Model
{
	public function get_single($id)
	{
		return $this->db->get_where('tahapan_pendampingan', ['id' => $id], 1)->first_row();
	}

	/**
	 * @param $kegiatan_id
	 * @return TahapanPendampingan_model[]
	 */
	public function list_by_kegiatan($kegiatan_id)
	{
		return $this->db
			->order_by('tgl_awal_laporan')
			->get_where('tahapan_pendampingan', ['kegiatan_id' => $kegiatan_id])->result();
	}
}
