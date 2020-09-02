<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_table_komponen_penilaian extends CI_Migration
{
	function up()
	{
		echo "  > alter table komponen_penilaian ... ";
		$this->dbforge->add_column('komponen_penilaian', [
			'bentuk_pendidikan_id INT NOT NULL AFTER tahapan_id',
			'is_disabilitas BOOLEAN NOT NULL AFTER bentuk_pendidikan_id',
			'CONSTRAINT komponen_penilaian_bentuk_pendidikan_fk FOREIGN KEY (bentuk_pendidikan_id) REFERENCES bentuk_pendidikan (id)',
		]);
		echo "OK\n";

		echo "  > insert komponen_penilaian tahun 2020 ... ";
		$this->db->query("alter table komponen_penilaian auto_increment = 64");
		// Akademik
		$bentuk_pendidikan_akademik = [19, 21, 22, 23, 34];
		foreach ($bentuk_pendidikan_akademik as $bp)
		{
			$this->db->insert_batch('komponen_penilaian', [
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 0,
					'urutan' => 1, 'kriteria' => 'Masalah, Solusi dan Produk/Jasa yang ditawarkan', 'bobot' => 15],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 0,
					'urutan' => 2, 'kriteria' => 'Sumberdaya', 'bobot' => 10],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 0,
					'urutan' => 3, 'kriteria' => 'Pesaing dan keunggulan pesaing', 'bobot' => 10],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 0,
					'urutan' => 4, 'kriteria' => 'Target Pelangaan dan Ketersediaan Pasar', 'bobot' => 15],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 0,
					'urutan' => 5, 'kriteria' => 'Strategi Pemasaran dan Akuisisi Pelanggan', 'bobot' => 15],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 0,
					'urutan' => 6, 'kriteria' => 'Business Model', 'bobot' => 15],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 0,
					'urutan' => 7, 'kriteria' => 'Rencana Pengembangan', 'bobot' => 10],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 0,
					'urutan' => 8, 'kriteria' => 'Laporan Keuangan dan Proyeksi Keuangan', 'bobot' => 10],
			]);
		}
		// Politeknik
		$this->db->insert_batch('komponen_penilaian', [
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 1, 'kriteria' => 'Ringkasan Eksekutif', 'bobot' => 5],
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 2, 'kriteria' => 'Deskripsi Usaha', 'bobot' => 10],
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 3, 'kriteria' => 'Target Pasar', 'bobot' => 10],
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 4, 'kriteria' => 'Analisis Pesaing/Kompetitor', 'bobot' => 15],
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 5, 'kriteria' => 'Rencana Pemasaran dan Penjualan', 'bobot' => 15],
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 6, 'kriteria' => 'Rencana Operasi', 'bobot' => 15],
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 7, 'kriteria' => 'Kesiapan Tim Manajemen', 'bobot' => 5],
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 8, 'kriteria' => 'Pengembangan Masa Depan Usaha dan Inovasi', 'bobot' => 10],
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 9,
				'kriteria' => 'Rencana Finansial Pengembangan Inovasi Bisnis (Laporan Keuangan dan Proyeksi Keuangan)',
				'bobot' => 10],
			['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => 20, 'is_disabilitas' => 0,
				'urutan' => 10, 'kriteria' => 'Foto-dokumentasi dan dokumen pendukung lain, CV', 'bobot' => 5],
		]);
		// Disabilitas
		$bentuk_pendidikan_all = [19, 20, 21, 22, 23, 34];
		foreach ($bentuk_pendidikan_all as $bp)
		{
			$this->db->insert_batch('komponen_penilaian', [
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 1, 'kriteria' => 'Ringkasan Eksekutif', 'bobot' => 5],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 2, 'kriteria' => 'Deskripsi Usaha', 'bobot' => 10],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 3, 'kriteria' => 'Target Pasar', 'bobot' => 10],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 4, 'kriteria' => 'Analisis Pesaing/Kompetitor', 'bobot' => 15],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 5, 'kriteria' => 'Rencana Pemasaran dan Penjualan', 'bobot' => 15],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 6, 'kriteria' => 'Rencana Operasi', 'bobot' => 15],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 7, 'kriteria' => 'Kesiapan Tim Manajemen', 'bobot' => 5],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 8, 'kriteria' => 'Pengembangan Masa Depan Usaha dan Inovasi', 'bobot' => 10],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 9,
					'kriteria' => 'Rencana Finansial Pengembangan Inovasi Bisnis (Laporan Keuangan dan Proyeksi Keuangan)',
					'bobot' => 10],
				['kegiatan_id' => 15, 'tahapan_id' => 1, 'bentuk_pendidikan_id' => $bp, 'is_disabilitas' => 1,
					'urutan' => 10, 'kriteria' => 'Foto-dokumentasi dan dokumen pendukung lain, CV', 'bobot' => 5],
			]);
		}

		$komponen_penilaian_set = $this->db->get_where('komponen_penilaian', ['kegiatan_id' => 15])->result();
		foreach ($komponen_penilaian_set as $kp)
		{
			// Non Disabilitas
			if ($kp->is_disabilitas == 0)
			{
				// Akademik
				if ($kp->bentuk_pendidikan_id != 20)
				{
					if ($kp->urutan == 1)
					{
						$this->db->insert('komponen_penilaian_isian', [
							'komponen_penilaian_id' => $kp->id, 'isian_ke' => 1, 'pertanyaan' => 'Ringkasan',
							'urutan' => 1
						]);
					}

					if ($kp->urutan != 8)
					{
						$this->db->insert('komponen_penilaian_isian', [
							'komponen_penilaian_id' => $kp->id, 'isian_ke' => ($kp->urutan + 1), 'pertanyaan' => NULL,
							'urutan' => ($kp->urutan + 1)
						]);
					}
				}
				else
				{
					if ($kp->urutan != 10)
					{
						$this->db->insert('komponen_penilaian_isian', [
							'komponen_penilaian_id' => $kp->id, 'isian_ke' => $kp->urutan, 'pertanyaan' => NULL,
							'urutan' => $kp->urutan
						]);
					}
				}
			}
			elseif ($kp->is_disabilitas == 1)
			{
				if ($kp->urutan != 10)
				{
					$this->db->insert('komponen_penilaian_isian', [
						'komponen_penilaian_id' => $kp->id, 'isian_ke' => $kp->urutan, 'pertanyaan' => NULL,
						'urutan' => $kp->urutan
					]);
				}
			}
		}
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback table komponen_penilaian ... ";
		$this->db->query("alter table komponen_penilaian drop foreign key komponen_penilaian_bentuk_pendidikan_fk");
		$this->dbforge->drop_column('komponen_penilaian', 'bentuk_pendidikan_id');
		$this->dbforge->drop_column('komponen_penilaian', 'is_disabilitas');
		$this->db->query("delete from komponen_penilaian_isian");
		$this->db->delete('komponen_penilaian', ['kegiatan_id' => 15]);
		echo "OK\n";
	}
}
