<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 */
class PerguruanTinggi_model extends CI_Model
{
	public $id;
	public $npsn;
	public $nama_pt;
	public $email_pt;
	
	public $alamat_jalan;
	public $alamat_kecamatan;
	public $alamat_kota;
	public $alamat_provinsi;
	
	public function list_all()
	{
		return $this->db->get('perguruan_tinggi')->result();
	}
	
	public function list_all_order_name()
	{
		return $this->db->select('id, nama_pt')->order_by('nama_pt')->get('perguruan_tinggi')->result();
	}
	
	/**
	 * Pencarian berbasis Full-Text Search
	 * @param string $nama_pt
	 */
	public function list_by_fts($nama_pt)
	{
		return $this->db
			->select('id, nama_pt as value')
			->from('perguruan_tinggi')
			->where("(nama_pt like '{$nama_pt}%' or nama_pt like '% {$nama_pt}%')", NULL, TRUE)	// full-text matching
			->order_by('nama_pt')
			->limit(10)
			->get()
			->result_array();
	}
	
	/**
	 * @param int $id
	 * @return PerguruanTinggi_model
	 */
	public function get_single($id)
	{
		return $this->db->get_where('perguruan_tinggi', ['id' => $id])->row();
	}
	
	/**
	 * Get npsn / kode_pt
	 * @param int $id
	 * @return string
	 */
	public function get_npsn_by_id($id)
	{
		return $this->db->select('npsn')
			->get_where('perguruan_tinggi', ['id' => $id])->row()->npsn;
	}
	
	public function update(stdClass $model, $id)
	{
		return $this->db->update('perguruan_tinggi', $model, ['id' => $id]);
	}
	
	public function list_by_name($nama_pt)
	{
		$nama_pt = strtolower($nama_pt);
		
		return $this->db
			->select('*')->from('perguruan_tinggi')
			->like('nama_pt', $nama_pt)
			->get()
			->result();
	}
	
	public function list_by_tahapan_kegiatan($kegiatan_id, $tahapan_id)
	{
		/*
		 select distinct pt.id, pt.nama_pt
		from tahapan_proposal tp
		join proposal p on p.id = tp.proposal_id
		join perguruan_tinggi pt on pt.id = p.perguruan_tinggi_id
		where tp.kegiatan_id = '2' and tp.tahapan_id = '1'
		order by 2
		 */
		
		return $this->db
			->select('DISTINCT pt.id, pt.nama_pt', FALSE)
			->from('tahapan_proposal tp')
			->join('proposal p', 'p.id = tp.proposal_id')
			->join('perguruan_tinggi pt', 'pt.id = p.perguruan_tinggi_id')
			->where(['tp.kegiatan_id' => $kegiatan_id, 'tp.tahapan_id' => $tahapan_id])
			->order_by('pt.nama_pt')
			->get()->result();
	}
}
