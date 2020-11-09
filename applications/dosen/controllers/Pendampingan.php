<?php

/**
 * Class Pendampingan
 * @property Proposal_model $proposal_model
 * @property Kegiatan_model $kegiatan_model
 * @property TahapanPendampingan_model $tpendampingan_model
 * @property LaporanPendampingan_model $lpendampingan_model
 */
class Pendampingan extends Dosen_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_TAHAPAN_PENDAMPINGAN, 'tpendampingan_model');
		$this->load->model(MODEL_LAPORAN_PENDAMPINGAN, 'lpendampingan_model');
	}

	public function index()
	{
		$kegiatan_aktif = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);
		$dosen = $this->session->user->dosen;
		$proposal_set = $this->proposal_model->list_by_dosen($dosen->id, $kegiatan_aktif->id);
		$tahapan_pendampingan_set = $this->tpendampingan_model->list_by_kegiatan($kegiatan_aktif->id);
		$laporan_pendampingan_set = $this->lpendampingan_model->list_by_dosen($dosen->id, $kegiatan_aktif->id);

		$now = date('Y-m-d H:i:s');
		foreach ($tahapan_pendampingan_set as $tp)
		{
			$tp->is_waktu_pelaporan = ($tp->tgl_awal_laporan <= $now && $now <= $tp->tgl_akhir_laporan) ? true : false;
		}

		$this->smarty->assign('proposal_set', $proposal_set);
		$this->smarty->assign('tahapan_pendampingan_set', $tahapan_pendampingan_set);
		$this->smarty->assign('laporan_pendampingan_set', $laporan_pendampingan_set);
		$this->smarty->display();
	}

	public function lapor($tahapan_pendampingan_id, $proposal_id)
	{
		$tahapan_pendampingan = $this->tpendampingan_model->get_single($tahapan_pendampingan_id);
		$dosen = $this->session->user->dosen;
		$proposal = $this->proposal_model->get_single($proposal_id, $dosen->perguruan_tinggi_id);
		$lap_pendampingan = $this->lpendampingan_model->get_single($tahapan_pendampingan_id, $proposal_id);

		if ($this->input->method() == 'post')
		{
			$folder_target = FCPATH.'upload/laporan-pendampingan/';
			if ( ! file_exists($folder_target))
			{
				mkdir($folder_target);
			}

			$this->load->library('upload');
			$this->upload->initialize([
				'encrypt_name'	=> TRUE,
				'upload_path'	=> $folder_target,
				'allowed_types'	=> 'pdf',
				'max_size'		=> 5 * 1024
			]);

			if ($this->upload->do_upload('file'))
			{
				$data = $this->upload->data();
				$upload_berhasil = true;
				$attachment_nama_asli = $data['orig_name'];
				$attachment_nama_file = $data['file_name'];
			}
			else
			{
				$upload_berhasil = false;
				$attachment_nama_file = null;
				$attachment_nama_asli = null;

				$upload_error_msg = $this->upload->display_errors('', '');

				if ($upload_error_msg != 'You did not select a file to upload.')
				{
					if ($upload_error_msg == 'The filetype you are attempting to upload is not allowed.')
					{
						$this->session->set_flashdata('upload_error_msg', 'File yang boleh diupload hanya PDF');
					}
					else
					{
						$this->session->set_flashdata('upload_error_msg', $this->upload->display_errors());
					}

					redirect("pendampingan/lapor/{$tahapan_pendampingan_id}/{$proposal_id}");
					exit();
				}
			}

			if ($lap_pendampingan != null)
			{
				$lap_pendampingan->tahapan_pendampingan_id = $tahapan_pendampingan_id;
				$lap_pendampingan->proposal_id = $proposal_id;
				$lap_pendampingan->laporan = $this->input->post('laporan');
				if ($upload_berhasil)
				{
					$lap_pendampingan->attachment_nama_file = $attachment_nama_file;
					$lap_pendampingan->attachment_nama_asli = $attachment_nama_asli;
				}
				$lap_pendampingan->updated_at = date('Y-m-d H:i:s');
				$result = $this->lpendampingan_model->update($lap_pendampingan);
			}
			else
			{
				$lap_pendampingan = new stdClass();
				$lap_pendampingan->tahapan_pendampingan_id = $tahapan_pendampingan_id;
				$lap_pendampingan->proposal_id = $proposal_id;
				$lap_pendampingan->laporan = $this->input->post('laporan');
				if ($upload_berhasil)
				{
					$lap_pendampingan->attachment_nama_file = $attachment_nama_file;
					$lap_pendampingan->attachment_nama_asli = $attachment_nama_asli;
				}
				$lap_pendampingan->created_at = date('Y-m-d H:i:s');
				$result = $this->lpendampingan_model->add($lap_pendampingan);
			}

			$this->session->set_flashdata('success', $result);
			redirect("pendampingan/lapor/{$tahapan_pendampingan_id}/{$proposal_id}");
			exit();
		}

		if ($lap_pendampingan == null)
		{
			$lap_pendampingan = new stdClass();
			$lap_pendampingan->laporan = '';
			$lap_pendampingan->attachment_nama_file = '';
		}

		$this->smarty->assign('tahapan_pendampingan', $tahapan_pendampingan);
		$this->smarty->assign('proposal', $proposal);
		$this->smarty->assign('laporan_pendampingan', $lap_pendampingan);
		$this->smarty->display();
	}

	public function hapus_attachment($tahapan_pendampingan_id, $proposal_id)
	{
		$lap_pendampingan = $this->lpendampingan_model->get_single($tahapan_pendampingan_id, $proposal_id);

		$lap_pendampingan->attachment_nama_file = null;
		$lap_pendampingan->attachment_nama_asli = null;
		$lap_pendampingan->updated_at = date('Y-m-d H:i:s');
		$result = $this->lpendampingan_model->update($lap_pendampingan);

		$this->session->set_flashdata('hapus_attachment_success', $result);
		redirect("pendampingan/lapor/{$tahapan_pendampingan_id}/{$proposal_id}");
		exit();
	}
}
