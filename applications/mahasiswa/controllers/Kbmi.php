<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Program_studi_model $program_studi_model
 * @property Mahasiswa_model $mahasiswa_model
 * @property Dosen_model $dosen_model
 * @property Kegiatan_model $kegiatan_model
 * @property Proposal_model $proposal_model
 * @property Anggota_proposal_model $anggota_model
 * @property Syarat_model $syarat_model
 * @property Isian_model $isian_model
 * @property PerguruanTinggi_model $pt_model
 */
class Kbmi extends Mahasiswa_Controller
{
	const CAPTCHA_TIMEOUT = 120;
	const CAPTCHA_LENGTH = 8;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_PROGRAM_STUDI, 'program_studi_model');
		$this->load->model(MODEL_MAHASISWA, 'mahasiswa_model');
		$this->load->model(MODEL_DOSEN, 'dosen_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_ANGGOTA_PROPOSAL, 'anggota_model');
		$this->load->model(MODEL_SYARAT, 'syarat_model');
		$this->load->model(MODEL_ISIAN, 'isian_model');
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
	}
	
	public function identitas()
	{
		$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);
		
		// If expired, redirect ke home
		if (time() < strtotime($kegiatan->tgl_awal_upload) || strtotime($kegiatan->tgl_akhir_upload) < time())
		{
			redirect('home'); exit();
		}
		
		$proposal = $this->proposal_model->get_by_ketua($kegiatan->id, $this->session->user->mahasiswa_id);
		
		// Tombol Berikutnya di klik
		if ($this->input->method() == 'post')
		{
			// Update jika belum di submit
			if (!$proposal->is_submited)
			{
				$proposal->judul = trim($this->input->post('judul'));
				$proposal->mulai_berjalan = trim($this->input->post('mulai_berjalan'));
				$proposal->updated_at = date('Y-m-d H:i:s');
				$this->proposal_model->update($proposal->id, $proposal);
			}
			
			redirect('kbmi/step/1');
			exit();
		}
		
		$proposal->anggota_proposal_set = $this->anggota_model->list_by_proposal($proposal->id);
		if ($proposal->dosen_id != '') $proposal->dosen = $this->dosen_model->get($proposal->dosen_id);
		$this->smarty->assign('proposal', $proposal);
		
		$mahasiswa = $this->session->user->mahasiswa;
		$this->smarty->assign('mahasiswa', $mahasiswa);
		
		$program_studi_set = $this->program_studi_model->list_by_pt($this->session->perguruan_tinggi->npsn);
		$this->smarty->assignForCombo('program_studi_set', $program_studi_set, 'id', 'nama');
		
		$this->smarty->display();
	}
	
	public function cari_mahasiswa()
	{
		try
		{
			$mahasiswa = $this->mahasiswa_model->get_by_nim(
				$this->session->perguruan_tinggi->npsn,
				$this->input->post('program_studi_id'),
				$this->input->post('nim'));
			
			if ($mahasiswa != NULL)
			{
				
				$mahasiswa->program_studi = $this->program_studi_model->get($mahasiswa->program_studi_id);
				echo json_encode(['result' => true, 'mahasiswa' => $mahasiswa]);
				exit();
			}
		}
		catch (Exception $exc)
		{
			echo json_encode(['result' => false, 'message' => $exc->getMessage()]);
			exit();
		}
		
		echo json_encode(['result' => false, 'message' => 'Mahasiswa tidak ditemukan']);
	}
	
	public function tambah_anggota()
	{
		if ($this->input->method() == 'post')
		{
			$anggota = new stdClass();
			$anggota->proposal_id	= $this->input->post('proposal_id');
			$anggota->no_urut		= $this->input->post('no_urut');
			$anggota->mahasiswa_id	= $this->input->post('mahasiswa_id');
			$anggota->created_at	= date('Y-m-d H:i:s');

			if ($this->anggota_model->add($anggota))
			{
				echo json_encode(['result' => true, 'anggota_id' => $anggota->id]);
			}
			else
			{
				echo json_encode(['result' => false]);
			}	
		}
	}
	
	public function update_anggota()
	{
		if ($this->input->method() == 'post')
		{
			$anggota = $this->anggota_model->get($this->input->post('anggota_id'));
			$anggota->mahasiswa_id = $this->input->post('mahasiswa_id');
			$anggota->updated_at = date('Y-m-d H:i:s');
			
			$update_result = $this->anggota_model->update($anggota);
			
			echo json_encode(['result' => $update_result]);
		}
	}
	
	public function delete_anggota()
	{
		if ($this->input->method() == 'post')
		{			
			$update_result = $this->anggota_model->delete($this->input->post('anggota_id'));
			
			echo json_encode(['result' => $update_result]);
		}
	}
    
    public function cari_dosen()
    {
        try
        {
            $dosen = $this->dosen_model->get_by_nidn(
                $this->session->perguruan_tinggi->npsn,
                $this->input->post('program_studi_id'),
                $this->input->post('nidn'));

            if ($dosen != NULL)
            {
                echo json_encode(['result' => true, 'dosen' => $dosen]);
                exit();
            }
        }
        catch (Exception $exc)
        {
            echo json_encode(['result' => false, 'message' => $exc->getMessage()]);
            exit();
        }

        echo json_encode(['result' => false, 'message' => 'Dosen tidak ditemukan']);
    }
	
	public function update_dosen()
	{
		if ($this->input->method() == 'post')
		{
			$update_result = $this->proposal_model->update_dosen(
				$this->session->perguruan_tinggi->id,
				$this->input->post('proposal_id'),
				$this->input->post('dosen_id'));
			
			echo json_encode(['result' => $update_result]);
		}
	}
    
    public function step($step)
	{
		$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);
		$mahasiswa = $this->session->user->mahasiswa;
		$pt = $this->pt_model->get_single($mahasiswa->perguruan_tinggi_id);
		$jumlah_isian = $this->kegiatan_model->get_jumlah_isian($kegiatan->id, $pt->bentuk_pendidikan_id);
		$isian = $this->isian_model->get_single($kegiatan->id, $pt->bentuk_pendidikan_id, $mahasiswa->is_disabilitas, $step);

		// If expired, redirect ke home
		if (time() < strtotime($kegiatan->tgl_awal_upload) || strtotime($kegiatan->tgl_akhir_upload) < time())
		{
			redirect('home'); exit();
		}
		
		// Prevent URL Hack
		if ($step < 0 || $step > $jumlah_isian || !is_numeric($step))
		{
			show_error('Halaman tidak ditemukan.');
		}
		
		$proposal = $this->proposal_model->get_by_ketua($kegiatan->id, $this->session->user->mahasiswa_id);
		$isian_proposal = $this->proposal_model->get_isian_proposal($proposal->id, $isian->id);

		if ($this->input->method() == 'post')
		{
			if ($this->input->post('tombol') == 'Upload')
			{
				$this->_step_upload($step, $proposal, $isian, $isian_proposal);
			}
			elseif ($this->input->post('tombol') == 'Change Upload')
			{
				$this->_step_delete_upload($step, $isian_proposal);
			}
			else
			{
				$this->_step($step, $proposal, $isian->id, $jumlah_isian);
			}
		}

		$this->smarty->assign('isian', $isian);
		$this->smarty->assign('isian_proposal', $isian_proposal);
		$this->smarty->assign('step', $step);
		$this->smarty->assign('proposal', $proposal);
		$this->smarty->assign('upload_error', $this->session->flashdata('upload_error'));
		$this->smarty->display();
	}
	
	/**
	 * @param int $step
	 * @param Proposal_model $proposal
	 * @param int $isian_id
	 * @param int $jumlah_isian
	 */
	private function _step($step, $proposal, $isian_id, $jumlah_isian)
	{
		if ($step >= 1 && $step <= $jumlah_isian)
		{
			// Data proposal diupdate jika belum disubmit
			if ( ! $proposal->is_submited)
			{
				$this->proposal_model->update_isian_proposal($proposal->id, $isian_id, $this->input->post('isian'));
			}
			
			if ($this->input->post('tombol') == 'Sebelumnya')
			{
				// First Step
				if ($step == 1)
				{
					redirect('kbmi/identitas'); exit();
				}
				else
				{
					$step--;
					redirect("kbmi/step/{$step}"); exit();
				}
			}

			if ($this->input->post('tombol') == 'Berikutnya')
			{
				// Last Step
				if ($step == $jumlah_isian)
				{
					redirect("kbmi/upload"); exit();
				}
			
				$step++;
				redirect("kbmi/step/{$step}"); exit();
			}
		}
	}

	/**
	 * @param int $step
	 * @param Proposal_model $proposal
	 * @param Isian_model $isian
	 * @param IsianProposal_model $isian_proposal
	 */
	private function _step_upload($step, $proposal, $isian, $isian_proposal)
	{
		$this->load->library('upload');

		$upload_path = FCPATH . 'upload/isian/' . $proposal->id . '/';

		if ( ! file_exists($upload_path))
		{
			mkdir($upload_path, 0777, TRUE);
		}

		$this->upload->initialize([
			'encrypt_name'	=> TRUE,
			'upload_path'	=> $upload_path,
			'allowed_types'	=> explode(',', $isian->allowed_types),
			'max_size'		=> (int)$isian->max_size * 1024
		]);

		if ($this->upload->do_upload('file'))
		{
			$upload_data = $this->upload->data();
			$isian_proposal->nama_file = $upload_data['file_name'];
			$isian_proposal->nama_asli = $upload_data['orig_name'];
			$isian_proposal->updated_at = date('Y-m-d H:i:s');
			$this->db->update('isian_proposal', $isian_proposal, ['id' => $isian_proposal->id]);
		}
		else
		{
			$this->session->set_flashdata('upload_error', $this->upload->display_errors());
		}

		redirect(site_url('kbmi/step/'.$step));
		exit();
	}

	/**
	 * @param int $step
	 * @param IsianProposal_model $isian_proposal
	 */
	private function _step_delete_upload($step, $isian_proposal)
	{
		// Hapus file
		unlink(FCPATH . 'upload/isian/' . $isian_proposal->proposal_id . '/' . $isian_proposal->nama_file);

		$isian_proposal->nama_file = NULL;
		$isian_proposal->nama_asli = NULL;
		$isian_proposal->updated_at = date('Y-m-d H:i:s');
		$this->db->update('isian_proposal', $isian_proposal, ['id' => $isian_proposal->id]);

		redirect(site_url('kbmi/step/'.$step));
		exit();
	}
	
	public function upload()
	{
		$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);
		$pt = $this->pt_model->get_single($this->session->user->mahasiswa->perguruan_tinggi_id);
		$jumlah_isian = $this->kegiatan_model->get_jumlah_isian($kegiatan->id, $pt->bentuk_pendidikan_id);

		if ($this->input->post('tombol') == 'Sebelumnya')
		{
			redirect("kbmi/step/" . $jumlah_isian); exit();
		}
		
		if ($this->input->post('tombol') == 'Berikutnya')
		{
			redirect("kbmi/confirm"); exit();
		}
		
		$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);
		
		// If expired, redirect ke home
		if (time() < strtotime($kegiatan->tgl_awal_upload) || strtotime($kegiatan->tgl_akhir_upload) < time())
		{
			redirect('home'); exit();
		}
		
		$proposal = $this->proposal_model->get_by_ketua($kegiatan->id, $this->session->user->mahasiswa_id);
		$syarat_set = $this->syarat_model->list_by_kegiatan($kegiatan->id, $proposal->id);
		
		if ($this->input->post('tombol') == 'Unggah')
		{
			$this->load->library('upload');

			$upload_path = FCPATH . 'upload/lampiran/';

			if ( ! file_exists($upload_path))
			{
				mkdir($upload_path, 0777, TRUE);
			}
			
			foreach ($syarat_set as &$syarat)
			{
				$this->upload->initialize([
					'encrypt_name'	=> TRUE,
					'upload_path'	=> $upload_path,
					'allowed_types'	=> explode(',', $syarat->allowed_types),
					'max_size'		=> (int)$syarat->max_size * 1024
				]);
				
				if ($this->upload->do_upload('file_syarat_' . $syarat->id))
				{
					$data = $this->upload->data();
					
					$file_row_exist = $this->db->where(array(
						'proposal_id' => $proposal->id,
						'syarat_id' => $syarat->id
					))->count_all_results('file_proposal') > 0;

					// if file record exist : update
					if ($file_row_exist)
					{
						$this->db->update('file_proposal', array(
							'nama_asli' => $data['orig_name'],
							'nama_file' => $data['file_name']
						), array('proposal_id' => $proposal->id, 'syarat_id' => $syarat->id));
					}
					else // insert
					{
						$this->db->insert('file_proposal', array(
							'proposal_id' => $proposal->id,
							'nama_asli' => $data['orig_name'],
							'nama_file' => $data['file_name'],
							'syarat_id' => $syarat->id
						));
					}
				}
				else
				{
					if ($this->upload->display_errors('', '') == 'You did not select a file to upload.' && $syarat->is_wajib == 0)
					{
						// Jika tidak wajib, maka tidak diperlukan file untuk upload
					}
					else
					{
						$syarat->upload_error_msg = $this->upload->display_errors('', '');
					}
				}
			}
			
			redirect('kbmi/upload');
			exit();
		}

		$this->smarty->assign('syarat_set', $syarat_set);
		$this->smarty->assign('proposal', $proposal);
		$this->smarty->display();
	}
	
	public function confirm()
	{
		$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);

		// If expired, redirect ke home
		if (time() < strtotime($kegiatan->tgl_awal_upload) || strtotime($kegiatan->tgl_akhir_upload) < time())
		{
			redirect('home'); exit();
		}

		$proposal = $this->proposal_model->get_by_ketua($kegiatan->id, $this->session->user->mahasiswa_id);
		$kelengkapan = $this->proposal_model->get_kelengkapan_proposal($proposal->id);
		
		// Jika sudah submit, redirect ke halaman submit
		if ($proposal->is_submited)
		{
			redirect('kbmi/submited'); exit();
		}
		
		// Tombol Sebelumnya ke halaman upload
		if ($this->input->post('tombol') == 'Sebelumnya')
		{
			redirect("kbmi/upload"); exit();
		}
		
		// Tombol Submit Proposal
		if ($this->input->post('tombol') == 'Submit Proposal')
		{
			// Memastikan waktu submit sesuai jadwal
			if (time() < strtotime($kegiatan->tgl_akhir_upload))
			{
				$expiration = time() - $this::CAPTCHA_TIMEOUT;

				// Hapus file captcha lama yang expired
				$captcha_set = $this->db
					->where('length(word)', $this::CAPTCHA_LENGTH)
					->where('captcha_time < ', $expiration)
					->get('captcha')->result();
				foreach ($captcha_set as $captcha_row)
					@unlink('./assets/captcha/'.$captcha_row->filename);
				// Hapus record db
				$this->db
					->where('length(word)', $this::CAPTCHA_LENGTH)
					->where('captcha_time < ', $expiration)
					->delete('captcha');

				// ambil data captcha
				$captcha_count = $this->db->query(
					"SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?",
					[$this->input->post('captcha'), $this->input->ip_address(), $expiration])
					->row()->count;

				// Jika captcha match
				if ($captcha_count > 0)
				{				
					// Proses submit proposal
					$this->proposal_model->submit($proposal->id);

					redirect('kbmi/submited');
					exit();
				}
				else
				{
					$this->smarty->assign('error_message', 'Kode keamanan tidak sesuai. Silahkan ulangi.');
				}
			}
			else
			{
				$error_message = 'Batas waktu submit sudah selesai. Batas Akhir : ' . strftime('%d/%m/%Y %H:%M:%S', strtotime($kegiatan->tgl_akhir_upload)) . ' . Waktu sistem : ' . strftime('%d/%m/%Y %H:%M:%S');
				$this->smarty->assign('error_message', $error_message);
			}
		}
		
		$this->smarty->assign('kelengkapan', $kelengkapan);
		$this->smarty->assign('img_captcha', $this->get_captcha());
		$this->smarty->display();
	}
	
	public function get_captcha()
	{		
		$this->load->helper('captcha');
			
		// Captcha Parameter
		$captcha_params = [
			'img_path'		=> FCPATH . 'assets/captcha/',
			'img_url'		=> base_url('../assets/captcha/'),
			'font_path'		=> FCPATH . 'assets/fonts/OpenSans-Semibold.ttf',
			'img_width'     => 300,
			'img_height'    => 60,
			'expiration'    => $this::CAPTCHA_TIMEOUT,
			'word_length'   => $this::CAPTCHA_LENGTH,
			'font_size'     => 28,
			'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz',
			'img_id'		=> time(),

			// White background and border, black text and red grid
			'colors'        => [
				'background'	=> [255, 255, 255],
				'border'		=> [0, 0, 0],
				'text'			=> [0, 0, 0],
				'grid'			=> [rand(0, 255), rand(0, 255), rand(0, 255)]
			]
		];
		
		$captcha = create_captcha($captcha_params);
		
		if ($captcha)
		{
			$data = [
				'captcha_time'  => $captcha['time'],
				'ip_address'    => $this->input->ip_address(),
				'word'          => $captcha['word'],
				'filename'		=> $captcha['filename']
			];

			$this->db->insert('captcha', $data);

			return $captcha['image'];
		}
		else
		{
			return 'Captcha Error: GD Extension / Image Path Not Writeable';
		}
	}
	
	public function submited()
	{
		$this->smarty->display();
	}

	private function proses_tahapan($tahapan)
	{
		$tahapans = [
			'kemajuan' => [
				'syarat' => 'Laporan Kemajuan',
				'path' => 'upload/laporan-kemajuan/',
				'url' => 'kbmi/kemajuan',
				'template' => 'kbmi/kemajuan.tpl'
			],
			'akhir' => [
				'syarat' => 'Laporan Akhir',
				'path' => 'upload/laporan-akhir/',
				'url' => 'kbmi/laporan-akhir',
				'template' => 'kbmi/laporan-akhir.tpl'
			],
		];

		$proposal_id = $this->input->get('id');
		$pt_id = $this->session->user->mahasiswa->perguruan_tinggi_id;
		$proposal = $this->proposal_model->get_single($proposal_id, $pt_id);
		$kegiatan = $this->kegiatan_model->get_single($proposal->kegiatan_id);
		$syarat = $this->syarat_model->get_single_by_name(
			$proposal->kegiatan_id, $tahapans[$tahapan]['syarat'], $proposal->id);

		if ($this->input->method() == 'post')
		{
			$this->load->library('upload');

			$upload_path = FCPATH . $tahapans[$tahapan]['path'];

			if ( ! file_exists($upload_path))
				mkdir($upload_path, 0777, TRUE);

			$this->upload->initialize([
				'encrypt_name'	=> TRUE,
				'upload_path'	=> $upload_path,
				'allowed_types'	=> explode(',', $syarat->allowed_types),
				'max_size'		=> (int)$syarat->max_size * 1024
			]);

			if ($this->upload->do_upload('file_syarat_' . $syarat->id))
			{
				$data = $this->upload->data();

				$file_row_exist = $this->db->where(array(
						'proposal_id' => $proposal->id,
						'syarat_id' => $syarat->id
					))->count_all_results('file_proposal') > 0;

				// if file record exist : update
				if ($file_row_exist)
				{
					$this->db->update('file_proposal', array(
						'nama_asli' => $data['orig_name'],
						'nama_file' => $data['file_name']
					), array('proposal_id' => $proposal->id, 'syarat_id' => $syarat->id));
				}
				else // insert
				{
					$this->db->insert('file_proposal', array(
						'proposal_id' => $proposal->id,
						'nama_asli' => $data['orig_name'],
						'nama_file' => $data['file_name'],
						'syarat_id' => $syarat->id
					));
				}

				redirect("{$tahapans[$tahapan]['url']}?id={$proposal->id}");
				exit();
			}
			else
			{
				$syarat->upload_error_msg = $this->upload->display_errors('', '');
			}
		}

		// Formating tanggal
		$now = date('Y-m-d H:i:s');

		if ($tahapan == 'kemajuan')
		{
			$kegiatan->tgl_awal_upload_kemajuan_dmy =
				strftime('%d %B %Y %T', strtotime($kegiatan->tgl_awal_upload_kemajuan));
			$kegiatan->tgl_akhir_upload_kemajuan_dmy =
				strftime('%d %B %Y %T', strtotime($kegiatan->tgl_akhir_upload_kemajuan));
			$kegiatan->in_jadwal =
				$kegiatan->tgl_awal_upload_kemajuan <= $now && $now <= $kegiatan->tgl_akhir_upload_kemajuan;
		}

		if ($tahapan == 'akhir')
		{
			$kegiatan->tgl_awal_laporan_akhir_dmy =
				strftime('%d %B %Y %T', strtotime($kegiatan->tgl_awal_laporan_akhir));
			$kegiatan->tgl_akhir_laporan_akhir_dmy =
				strftime('%d %B %Y %T', strtotime($kegiatan->tgl_akhir_laporan_akhir));
			$kegiatan->in_jadwal =
				$kegiatan->tgl_awal_laporan_akhir <= $now && $now <= $kegiatan->tgl_akhir_laporan_akhir;
		}

		$this->smarty->assign('proposal', $proposal);
		$this->smarty->assign('kegiatan', $kegiatan);
		$this->smarty->assign('syarat', $syarat);
		$this->smarty->display($tahapans[$tahapan]['template']);
	}

	/**
	 * Halaman untuk mengupload laporan kemajuan
	 */
	public function kemajuan()
	{
		return $this->proses_tahapan('kemajuan');
	}

	/**
	 * Halaman untuk mengupload laporan akhir
	 */
	public function laporan_akhir()
	{
		return $this->proses_tahapan('akhir');
	}
}
