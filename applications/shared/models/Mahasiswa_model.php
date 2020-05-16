<?php
use GuzzleHttp\Client;

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db 
 * @property Program_studi_model $program_studi_model
 * @property PerguruanTinggi_model $pt_model
 * @property int $id
 * @property int $perguruan_tinggi_id 
 * @property string $nim
 * @property string $nama
 * @property string $email
 * @property string $no_hp
 * @property int $program_studi_id
 * @property Program_studi_model $program_studi 
 * @property GuzzleHttp\Client $client
 */
class Mahasiswa_model extends CI_Model
{
	/**
	 * @param int $id
	 * @return Mahasiswa_model
	 */
	function get($id)
	{
		return $this->db->get_where('mahasiswa', ['id' => $id])->row();
	}
	
	/**
	 * @param Mahasiswa_model $model
	 */
	function update($model)
	{
		return $this->db->update('mahasiswa', $model, ['id' => $model->id]);
	}
	
	/**
	 * @param string $npsn Kode Perguruan Tinggi
	 * @param int $program_studi_id program_studi untuk pencarian ke api forlap
	 * @param string $nim NIM Mahasiswa
	 * @return Mahasiswa_model
	 */
	function get_by_nim($npsn, $program_studi_id, $nim)
	{
		$mahasiswa = $this->db
			->select('m.*, pt.id_institusi')
			->from('mahasiswa m')
			->join('perguruan_tinggi pt', 'pt.id = m.perguruan_tinggi_id')
			->where('pt.npsn', $npsn)
			->where('m.nim', $nim)
			->get()->first_row();
		
		// Jika tidak ada dalam DB
		if ($mahasiswa == NULL)
		{
			
			// Ambil konfigurasi
			$this->config->load('pddikti');
			$pddikti_url = $this->config->item('pddikti_url');
			$pddikti_auth = $this->config->item('pddikti_auth');
			
			$this->client = new Client([
				'base_uri' => $pddikti_url,
				'headers' => [
					'Accept' => 'application/json',
					'Authorization' => 'Bearer ' . $pddikti_auth
				],
				'verify' => FALSE	// Disable CA Verification !
			]);
			
			$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
			$pt = $this->pt_model->get_by_npsn($npsn);

			$this->load->model(MODEL_PROGRAM_STUDI, 'program_studi_model');
			$program_studi = $this->program_studi_model->get($program_studi_id);
			$program_studi->kode_prodi = trim($program_studi->kode_prodi);

			// Cari dari Forlap
			$response = $this->client->get("pt/{$pt->npsn}/prodi/{$program_studi->id_pdpt}/mahasiswa/{$nim}");
			

			if ($response->getStatusCode() == 200)
			{
				$body = $response->getBody();
				$mahasiswa_pddikti = json_decode($body);
				
				if ( ! isset($mahasiswa_pddikti[0]))
				{
					throw new Exception("Mahasiswa tidak ditemukan");
				}
				// cek jika mahasiswa sudah lulus
				else if ($mahasiswa_pddikti[0]->terdaftar->tgl_keluar != '')
				{
					throw new Exception("Mahasiswa \"{$mahasiswa_pddikti[0]->terdaftar->nim} {$mahasiswa_pddikti[0]->nama}\" sudah tidak aktif / lulus");
				}
				else
				{
					// Insert Mahasiswa dari Pddikti
					$this->insert_from_pddikti($mahasiswa_pddikti[0]);

					// di query ulang
					$mahasiswa = $this->get_by_nim($npsn, $program_studi_id, $nim);
				}
			}
		}
		
		return $mahasiswa;
	}
	
	function insert_from_pddikti($param)
	{
		// get perguruan tinggi id
		$pt = $this->db->get_where('perguruan_tinggi', ['npsn' => $param->terdaftar->kode_pt])->row();
		
		// get program studi id
		$program_studi = $this->db->get_where('program_studi', [
			'perguruan_tinggi_id' => $pt->id,
			'nama' => "{$param->terdaftar->jenjang_didik->nama} {$param->terdaftar->nama_prodi}"
		])->row();
		
		return $this->db->insert('mahasiswa', [
			'perguruan_tinggi_id' => $pt->id,
			'nim' => trim($param->terdaftar->nim),
			'nama' => $param->nama,
			'program_studi_id' => $program_studi->id,
			'angkatan' => strftime('%Y', strtotime($param->terdaftar->tgl_masuk)),
			'email' => $param->email,
			'no_hp' => $param->handphone,
			'id_pdpt' => strtolower($param->id),
			'created_at' => date('Y-m-d H:i:s')
		]);
	}
}
