<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * 
 * @property int $id 
 * @property string $kode_prodi
 * @property string $nama
 * @property string $id_pdpt
 */
class Program_studi_model extends CI_Model
{
	function list_by_pt($npsn)
	{
		return $this->db->select('ps.id, ps.kode_prodi, ps.nama, ps.created_at, ps.updated_at')
			->from('program_studi ps')
			->join('perguruan_tinggi pt', 'pt.id = ps.perguruan_tinggi_id')
			->where('pt.npsn', $npsn)
			->order_by('ps.nama')
			->get()->result();
	}
	
	/**
	 * @param int $id
	 * @return Program_studi_model
	 */
	function get($id)
	{
		return $this->db->get_where('program_studi', ['id' => $id])->row();
	}
	
	/**
	 * @param string $id_pdpt
	 * @return Program_studi_model
	 */
	function get_by_id_pdpt($id_pdpt)
	{
		return $this->db->get_where('program_studi', ['id_pdpt' => $id_pdpt], 1)->row();
	}
	
	/**
	 * @param Program_studi_model $model
	 * @return bool
	 */
	function add(&$model)
	{
		$insert_result = $this->db->insert('program_studi', $model);
		$model->id = $this->db->insert_id();
		return $insert_result;
	}
}
