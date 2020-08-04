<?php
use GuzzleHttp\Client;

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property Client $client
 * @property Program_studi_model $prodi_model
 * @property int $id
 * @property int $bentuk_pendidikan_id
 * @property string $npsn
 * @property string $nama_pt
 * @property string $email_pt
 * @property string $alamat_jalan
 * @property string $alamat_kecamatan
 * @property string $alamat_kota
 * @property string $alamat_provinsi
 * @property string $id_institusi
 */
class PerguruanTinggi_model extends CI_Model
{
	
	public function list_all()
	{
		return $this->db
			->select('pt.id, npsn, nama_pt, email_pt')
			->select('count(ps.id) as jumlah_prodi', FALSE)
			->from('perguruan_tinggi pt')
			->join('program_studi ps', 'ps.perguruan_tinggi_id = pt.id', 'LEFT')
			->group_by('pt.id, npsn, nama_pt, email_pt')
			->get()->result();
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
	 * @param string $npsn
	 * @return PerguruanTinggi_model
	 */
	public function get_by_npsn($npsn)
	{
		return $this->db->get_where('perguruan_tinggi', ['npsn' => $npsn])->row();
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
	
	public function add(stdClass &$model)
	{
		$insert_result = $this->db->insert('perguruan_tinggi', $model);
		$model->id = $this->db->insert_id();
		return $insert_result;
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
	
	/**
	 * Sinkronisasi data dari PD Dikti
	 * @param string $kode_pt
	 */
	public function sync_pt_dikti($kode_pt)
	{
		// Ambil konfigurasi
		$this->config->load('pddikti');
		$pddikti_url = $this->config->item('pddikti_url');
		$pddikti_auth = $this->config->item('pddikti_auth');
		
		$this->load->model(MODEL_PROGRAM_STUDI, 'prodi_model');

		// GuzzleHttp\Client
		$this->client = new Client([
			'base_uri' => $pddikti_url,
			'headers' => [
				'Accept' => 'application/json',
				'Authorization' => 'Bearer ' . $pddikti_auth
			],
			'verify' => FALSE	// Disable CA Verification !
		]);
		
		$kode_pt = trim($kode_pt);
		$response = $this->client->get("pt/{$kode_pt}");
		
		if ($response->getStatusCode() == 200)
		{
			$pt_dikti_set = json_decode($response->getBody());
			
			// Jika tidak ada record sama sekali
			if (count($pt_dikti_set) == 0)
			{
				return false;
			}
			else
			{
				$pt_dikti = $pt_dikti_set[0];
			
				$pt = $this->get_by_npsn($kode_pt);

				// Jika belum ada, insert baru
				if ($pt == null)
				{
					$pt = new stdClass();
					$pt->id_institusi = strtolower($pt_dikti->id);
					$pt->npsn = $pt_dikti->kode;
					$pt->nama_pt = $pt_dikti->nama;
					$pt->email_pt = $pt_dikti->email;
					$pt->bentuk_pendidikan_id = $pt_dikti->bentuk_pendidikan->id;
					$this->add($pt);
				}
				else
				{
					$pt->id_institusi = strtolower($pt_dikti->id);
					$pt->nama_pt = $pt_dikti->nama;
					$pt->email_pt = $pt_dikti->email;
					$pt->updated_at = date('Y-m-d H:i:s');
					$this->update($pt, $pt->id);
				}
				
				// Ambil data Prodi
				$response = $this->client->get("pt/{$kode_pt}/prodi");
				
				if ($response->getStatusCode() == 200)
				{
					$prodi_dikti_set = json_decode($response->getBody());
					
					foreach ($prodi_dikti_set as $prodi_dikti)
					{
						$prodi = $this->prodi_model->get_by_pt_kode_nama(
							$pt->id, 
							$prodi_dikti->kode, 
							"{$prodi_dikti->jenjang_didik->nama} {$prodi_dikti->nama}");
						
						if ($prodi == null)
						{
							$prodi = new stdClass();
							$prodi->id_pdpt = strtolower($prodi_dikti->id);
							$prodi->perguruan_tinggi_id = $pt->id;
							$prodi->kode_prodi = $prodi_dikti->kode;
							$prodi->nama = "{$prodi_dikti->jenjang_didik->nama} {$prodi_dikti->nama}";
							$this->prodi_model->add($prodi);
						}
						else
						{
							$prodi->id_pdpt = strtolower($prodi_dikti->id);
							$prodi->updated_at = date('Y-m-d H:i:s');
							$this->prodi_model->update($prodi);
						}
					}
				}
				
				return true;
			}
		}
		else
		{
			return false;
		}
	}
}
