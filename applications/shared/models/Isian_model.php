<?php

/**
 * Class Isian_model
 * @property CI_DB_query_builder $db
 */
class Isian_model extends CI_Model
{
	function get_single($kegiatan_id, $bentuk_pendidikan_id, $isian_ke)
	{
		$isian = $this->db->get_where('isian', [
			'kegiatan_id' => $kegiatan_id,
			'bentuk_pendidikan_id' => $bentuk_pendidikan_id,
			'isian_ke' => $isian_ke
		])->row();

		if ($isian != null)
		{
			$isian->kelompok_isian = $this->db->get_where('kelompok_isian', ['id' => $isian->kelompok_isian_id])->row();
		}

		return $isian;
	}
}
