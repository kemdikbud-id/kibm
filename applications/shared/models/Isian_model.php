<?php

/**
 * Class Isian_model
 * @property CI_DB_query_builder $db
 * @property int $id
 * @property string $allowed_types
 * @property int $max_size
 */
class Isian_model extends CI_Model
{
	/**
	 * @param int $kegiatan_id
	 * @param int $bentuk_pendidikan_id
	 * @param int $is_disabilitas
	 * @param int $isian_ke
	 * @return Isian_model
	 */
	function get_single($kegiatan_id, $bentuk_pendidikan_id, $is_disabilitas, $isian_ke)
	{
		$isian = $this->db->get_where('isian', [
			'kegiatan_id' => $kegiatan_id,
			'bentuk_pendidikan_id' => $bentuk_pendidikan_id,
			'is_disabilitas' => $is_disabilitas,
			'isian_ke' => $isian_ke
		])->row();

		if ($isian != null)
		{
			$isian->kelompok_isian = $this->db->get_where('kelompok_isian', ['id' => $isian->kelompok_isian_id])->row();
		}

		return $isian;
	}
}
