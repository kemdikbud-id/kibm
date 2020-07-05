<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_isian extends CI_Migration
{
	function up()
	{
		echo "  > create table kelompok_isian ... ";
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('kelompok_isian TEXT NOT NULL');
		$this->dbforge->create_table('kelompok_isian');
		echo "OK\n";

		echo "  > create table isian ... ";
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'kegiatan_id INT NOT NULL',
			'kelompok_isian_id INT NOT NULL',
			'isian_ke INT NOT NULL',
			'judul_isian TEXT NOT NULL',
			'keterangan TEXT NULL',
			'placeholder TEXT NULL',
			"jenis VARCHAR(10) NOT NULl COMMENT 'text;textarea;radio'",
			'radio_options TEXT NULL COMMENT \'isinya | delimited\'',
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP',
			'FOREIGN KEY fk_isian_kegiatan (kegiatan_id) REFERENCES kegiatan (id)',
			'FOREIGN KEY fk_isian_kelompok_isian (kelompok_isian_id) REFERENCES kelompok_isian (id)'
		]);
		$this->dbforge->create_table('isian');
		echo "OK\n";

		echo "  > insert data kelompok_isian ... ";
		$this->db->insert_batch('kelompok_isian', [
			['id' => 1, 'kelompok_isian' => 'Noble Purpose'],
			['id' => 2, 'kelompok_isian' => 'Sasaran Pelanggan'],
			['id' => 3, 'kelompok_isian' => 'Informasi Produk'],
			['id' => 4, 'kelompok_isian' => 'Hubungan dengan Pelanggan'],
			['id' => 5, 'kelompok_isian' => 'Sumber Daya'],
			['id' => 6, 'kelompok_isian' => 'Pernyataan'],
			['id' => 7, 'kelompok_isian' => 'Keuangan'],
		]);
		echo "OK\n";

		echo "  > insert data isian ... ";
		// Kegiatan KBMI tahun 2019
		$kegiatan_id = $this->db->get_where('kegiatan', ['program_id' => 2, 'tahun' => 2019])->row()->id;
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 1, 'isian_ke' => 1, 'jenis' => 'textarea',
			'judul_isian' => 'Hal mulia apa yang tim Anda ingin wujudkan dalam membangun bisnis?',
			'keterangan' => 'Contoh: 1) Noble purpose-nya Steve Jobs (Apple, Inc.) adalah memberikan kontribusi ' .
				'kepada dunia dengan menciptakan alat untuk pikiran demi kemajuan umat manusia. 2) Noble ' .
				'purpose-nya Mursida Rambe (BMT Beringharjo Yogyakarta) membantu sebanyak mungkin kaum papa ' .
				'dari jeratan rentenir.',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 1, 'isian_ke' => 2, 'jenis' => 'textarea',
			'judul_isian' => 'Apa atau siapa yang menjadi pemicu hal mulia yang ingin diwujudkan tersebut?',
			'keterangan' => 'Contoh: Mursida Rambe menyaksikan seorang ibu-ibu tua dan anaknya diusir dari ' .
				'rumah gubuknya oleh rentenir karena tidak mampu membayar hutangnya.',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 1, 'isian_ke' => 3, 'jenis' => 'text',
			'judul_isian' => 'Topik Bisnis',
			'placeholder' => 'Contoh: Pendidikan bisnis untuk anak-anak.',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 1, 'isian_ke' => 4, 'jenis' => 'text',
			'judul_isian' => 'Goal/target omset dan net profit usaha Anda di tahun ini?',
			'keterangan' => 'Contoh: Omset 500 juta per tahun dan net profit 100 juta',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 1, 'isian_ke' => 5, 'jenis' => 'text',
			'judul_isian' => 'Realitas omset dan net profit usaha Anda di tahun ini?',
			'keterangan' => 'Contoh: Omset 100 juta per tahun dan net profit 20 juta, dan bagi yang belum ' .
				'memulai bisnis, isi ini dengan "belum memulai bisnis"',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 2, 'isian_ke' => 6, 'jenis' => 'text',
			'judul_isian' => 'Segmen spesifik pelanggan mana yang akan Anda sasar?',
			'placeholder' => 'Contoh: Orang tua yang memiliki anak usia 10-15 tahun.',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 2, 'isian_ke' => 7, 'jenis' => 'text',
			'judul_isian' => 'Area mana yang akan menjadi target ideal jangkauan bisnis Anda?',
			'placeholder' => 'Contoh: Indonesia',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 2, 'isian_ke' => 8, 'jenis' => 'text',
			'judul_isian' => 'Dalam 4 bulan pertama bisnis Anda berjalan, daerah mana yang akan menjadi awal ' .
				'target pasar Anda?',
			'placeholder' => 'Contoh: Kota Yogyakarta',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 2, 'isian_ke' => 9, 'jenis' => 'textarea',
			'judul_isian' => 'Coba Anda amati dan tanyakan kepada calon pelanggan yang Anda sasar. ' .
				'Aktifitas apa saja yang perlu mereka lakukan untuk mendapatkan produk/jasa yang menjadi ' .
				'konteks bisnis Anda?',
			'keterangan' => 'Contoh : Orang tua dengan profesi pengusaha melakukan hal-hal untuk mendidik ' .
				'anaknya supaya belajar bisnis sedini mungkin, orang tua itu mencarikan pendidikan bisnis, ' .
				'mencari buku bisnis untuk anak, mencari game bisnis online maupun offline untuk anak, mencari ' .
				'mentor bisnis untuk anak.'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 2, 'isian_ke' => 10, 'jenis' => 'textarea',
			'judul_isian' => 'Kesulitan apa saja yang benar-benar dirasakan oleh calon pelanggan Anda, terkait ' .
				'dengan hal-hal yang perlu dilakukan untuk mendapatkan produk/jasa yang menjadi konteks bisnis ' .
				'Anda?',
			'keterangan' => 'Contoh : orang tua kesulitan mencari game bisnis offline, kesulitan mencari ' .
				'pendidikan bisnis anak'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 2, 'isian_ke' => 11, 'jenis' => 'textarea',
			'judul_isian' => 'Jika kesulitan-kesulitan tersebut dapat terselesaikan, harapan apa saja yang ingin ' .
				'diwujudkan oleh calon pelanggan Anda?',
			'keterangan' => 'Harapan orang tua : adanya sebuah komunitas bisnis untuk anak'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 2, 'isian_ke' => 12, 'jenis' => 'textarea',
			'judul_isian' => 'Dari semua kesulitan dan harapan calon pelanggan anda, produk/layanan anda akan ' .
				'menyelesaikan kesulitan dan memenuhi harapan yang mana?',
			'keterangan' => 'Jasa : Sekolah bisnis untuk anak setiap sabtu-minggu'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 3, 'isian_ke' => 13, 'jenis' => 'text',
			'judul_isian' => 'Produk/jasa apa yang Anda tawarkan kepada calon pelanggan Anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 3, 'isian_ke' => 14, 'jenis' => 'textarea',
			'judul_isian' => 'Referensi produk/layanan apa saja atau hasil riset maupun jurnal dari pakar siapa ' .
				'yang Anda jadikan pertimbangan untuk membuat produk/layanan Anda?',
			'keterangan' => 'Isian pisahkan dengan koma'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 3, 'isian_ke' => 15, 'jenis' => 'textarea',
			'judul_isian' => 'Bagaimana produk/jasa Anda tersebut bekerja menyelesaikan masalah dan memenuhi ' .
				'keinginan pelanggan yang Anda sasar?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 3, 'isian_ke' => 16, 'jenis' => 'textarea',
			'judul_isian' => 'Menurut Anda, siapa saja yang akan menjadi kompetitor dalam menyediakan produk/jasa ' .
				'tersebut?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 3, 'isian_ke' => 17, 'jenis' => 'textarea',
			'judul_isian' => 'Apa saja keunggulan produk/jasa yang disediakan oleh kompetitor Anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 3, 'isian_ke' => 18, 'jenis' => 'textarea',
			'judul_isian' => 'Lalu, hal apa saja yang menjadi keunggulan kompetitif produk/jasa Anda ' .
				'dibandingkan dengan produk/jasa kompetitor?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 3, 'isian_ke' => 19, 'jenis' => 'textarea',
			'judul_isian' => 'Dari sisi mana saja bisnis Anda akan mendapatkan revenue dari pelanggan?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 4, 'isian_ke' => 20, 'jenis' => 'textarea',
			'judul_isian' => 'Bagaimana strategi Anda untuk membuat calon pelanggan mengetahui produk/jasa yang ' .
				'Anda sediakan?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 4, 'isian_ke' => 21, 'jenis' => 'textarea',
			'judul_isian' => 'Bagaimana strategi Anda untuk membuat calon pelanggan tertarik dan akhirnya ' .
				'memutuskan membeli produk/jasa yang Anda sediakan?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 4, 'isian_ke' => 22, 'jenis' => 'textarea',
			'judul_isian' => 'Bagaimana caranya anda merespon pelanggan yang bertanya, membeli dan komplain ' .
				'terhadap layanan anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 4, 'isian_ke' => 23, 'jenis' => 'textarea',
			'judul_isian' => 'Strategi apa yang akan Anda lakukan untuk menjadikan pelanggan Anda loyal?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 4, 'isian_ke' => 24, 'jenis' => 'radio',
			'judul_isian' => 'Dimana calon pelanggan dapat memperoleh produk/jasa Anda?',
			'radio_options' => 'Online|Online dan Offline|Offline'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 5, 'isian_ke' => 25, 'jenis' => 'textarea',
			'judul_isian' => 'Siapa saja anggota tim terbaik yang akan Anda libatkan dalam bisnis, dan apa ' .
				'keahlian masing-masing?',
			'keterangan' => 'Tuliskan nama tim, dan keahlian spesifiknya.'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 5, 'isian_ke' => 26, 'jenis' => 'textarea',
			'judul_isian' => 'Apa saja tanggung jawab masing-masing tim Anda tersebut?',
			'keterangan' => 'Tuliskan nama tim, dan tanggung jawabnya.'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 5, 'isian_ke' => 27, 'jenis' => 'textarea',
			'judul_isian' => 'Apa indikator keberhasilan dari tanggung jawab masing-masing tim Anda tersebut?',
			'keterangan' => 'Indikator kebarhasilan terukur secara Spesific, Measurable, Achievable, Realistic, ' .
				'Time-Based, contoh : Andi sebagai marketer, tanggung jawabnya adalah melalkukan proses ' .
				'marketing dengan indikator keberhasilan adalah dalam sebulan bisa menjual kepala 100 klien.'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 5, 'isian_ke' => 28, 'jenis' => 'textarea',
			'judul_isian' => 'Peralatan dan bahan utama apa saja yang Anda butuhkan untuk membuat produk/jasa ' .
				'tersebut?',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 5, 'isian_ke' => 29, 'jenis' => 'textarea',
			'judul_isian' => 'Jika Anda harus bermitra dalam menyediakan produk/jasa Anda, pihak mana yang akan ' .
				'Anda ajak kerja sama?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 5, 'isian_ke' => 30, 'jenis' => 'text',
			'judul_isian' => 'Biaya apa saja yang Anda butuhkan dalam menyediakan, menjual, dan mengantarkan ' .
				'produk/jasa kepada pelanggan?',
			'keterangan' => ''
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id, 'kelompok_isian_id' => 6, 'isian_ke' => 31, 'jenis' => 'radio',
			'judul_isian' => 'Jika terpilih sebagai penerima hibah, apa Anda sanggup memenuhi ketentuan dan ' .
				'syarat yang sudah ditetapkan?',
			'radio_options' => 'Ya|Tidak'
		]);

		// Perubahan dari 2019 ke 2020
		// Step 6-12 : dari 13-19 - Informasi Produk
		// Step 13-19 : dari 6-12 - Sasaran Pelanggan

		// Kegiatan KBMI tahun 2020
		$kegiatan_id_2020 = $this->db->get_where('kegiatan', ['program_id' => 2, 'tahun' => 2020])->row()->id;

		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 1, 'isian_ke' => 1, 'jenis' => 'textarea',
			'judul_isian' => 'Hal mulia apa yang tim Anda ingin wujudkan dalam membangun bisnis?',
			'keterangan' => 'Contoh: 1) Noble purpose-nya Steve Jobs (Apple, Inc.) adalah memberikan kontribusi ' .
				'kepada dunia dengan menciptakan alat untuk pikiran demi kemajuan umat manusia. 2) Noble ' .
				'purpose-nya Mursida Rambe (BMT Beringharjo Yogyakarta) membantu sebanyak mungkin kaum papa ' .
				'dari jeratan rentenir.',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 1, 'isian_ke' => 2, 'jenis' => 'textarea',
			'judul_isian' => 'Apa atau siapa yang menjadi pemicu hal mulia yang ingin diwujudkan tersebut?',
			'keterangan' => 'Contoh: Mursida Rambe menyaksikan seorang ibu-ibu tua dan anaknya diusir dari ' .
				'rumah gubuknya oleh rentenir karena tidak mampu membayar hutangnya.',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 1, 'isian_ke' => 3, 'jenis' => 'text',
			'judul_isian' => 'Apa jenis bisnis Anda?',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 1, 'isian_ke' => 4, 'jenis' => 'text',
			'judul_isian' => 'Goal/target omset dan net profit usaha Anda di tahun ini?',
			'keterangan' => 'Contoh: Omset 500 juta per tahun dan net profit 100 juta',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 1, 'isian_ke' => 5, 'jenis' => 'text',
			'judul_isian' => 'Realitas omset dan net profit usaha Anda di tahun ini?',
			'keterangan' => 'Contoh: Omset 100 juta per tahun dan net profit 20 juta, dan bagi yang belum ' .
				'memulai bisnis, isi ini dengan "belum memulai bisnis"',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 3, 'isian_ke' => 6, 'jenis' => 'textarea',
			'judul_isian' => 'Apa Produk/jasa Anda? Sebutkan dan Jelaskan'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 3, 'isian_ke' => 7, 'jenis' => 'textarea',
			'judul_isian' => 'Anda medapatkan ide produk/jasa anda dari mana?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 3, 'isian_ke' => 8, 'jenis' => 'textarea',
			'judul_isian' => 'Jelaskan bagaimana produk/jasa anda bisa menyelesaikan masalah dan memenuhi keinginan ' .
				'calon pelanggan anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 3, 'isian_ke' => 9, 'jenis' => 'textarea',
			'judul_isian' => 'Siapa kompetitor anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 3, 'isian_ke' => 10, 'jenis' => 'textarea',
			'judul_isian' => 'Apa keunggulan produk/jasa dari kompetitor Anda? '
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 3, 'isian_ke' => 11, 'jenis' => 'textarea',
			'judul_isian' => 'Apa keunggulan produk/jasa anda dibanding competitor?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 3, 'isian_ke' => 12, 'jenis' => 'textarea',
			'judul_isian' => 'Jelaskan bagaimana anda bisa mendapatkan keuntungan dari bisnis anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 2, 'isian_ke' => 13, 'jenis' => 'textarea',
			'judul_isian' => 'Pelanggan Spesifik mana yang akan Anda sasar? (bisa berdasarkan usia, hoby, dll)',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 2, 'isian_ke' => 14, 'jenis' => 'textarea',
			'judul_isian' => 'Area mana yang akan menjadi target ideal jangkauan bisnis Anda?',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 2, 'isian_ke' => 15, 'jenis' => 'textarea',
			'judul_isian' => 'Dalam 4 bulan pertama bisnis Anda berjalan, daerah mana yang akan menjadi target ' .
				'pasar Anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 2, 'isian_ke' => 16, 'jenis' => 'textarea',
			'judul_isian' => 'Tanyakan kepada calon pelanggan anda: Biasanya bagaimana calon pelanggan anda ' .
				'mencari produk/jasa seperti yang ingin anda tawarkan?',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 2, 'isian_ke' => 17, 'jenis' => 'textarea',
			'judul_isian' => 'Tanyakan kepada calon pelanggan anda: Apa yang membuat pelanggan anda ' .
				'kecewa/kesulitan/Masalah terhadap produk/jasa seperti yang ingin anda tawarkan dan sudah tersedia ' .
				'di pasar?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 2, 'isian_ke' => 18, 'jenis' => 'textarea',
			'judul_isian' => 'Tanyakan kepada calon pelanggan anda : Jika kekecewaan/kesulitan/masalah yang dialami ' .
				'calon pelanggan anda terhadap produk/jasa seperti yang ingin anda tawarkan dan sudah tersedia di ' .
				'pasar, anda bisa memastikan bahwa itu tidak akan terjadi jika membeli produk/jasa dari anda, apa ' .
				'yang masih diharapkan calon pelanggan anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 2, 'isian_ke' => 19, 'jenis' => 'textarea',
			'judul_isian' => 'Dari semua kekecewaan/kesulitan/masalah dan harapan calon pelanggan anda, ' .
				'produk/layanan anda bisa menyelesaikan kesulitan dan memenuhi harapan yang mana?',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 4, 'isian_ke' => 20, 'jenis' => 'textarea',
			'judul_isian' => 'Jelaskan bagaimana strategi marketing anda'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 4, 'isian_ke' => 21, 'jenis' => 'textarea',
			'judul_isian' => 'Bagaimana strategi anda agar calon pelanggan anda membeli produk/jasa anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 4, 'isian_ke' => 22, 'jenis' => 'textarea',
			'judul_isian' => 'Bagaimana caranya anda merespon pelanggan anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 4, 'isian_ke' => 23, 'jenis' => 'textarea',
			'judul_isian' => 'Strategi apa yang akan Anda lakukan untuk menjadikan pelanggan Anda loyal? Jelaskan'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 4, 'isian_ke' => 24, 'jenis' => 'textarea',
			'judul_isian' => 'Dimana calon pelanggan dapat membeli produk/jasa Anda? Sebutkan beberapa cara',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 5, 'isian_ke' => 25, 'jenis' => 'textarea',
			'judul_isian' => 'Keahlian masing-masing tim (jika terpaksa merangkap diperbolehkan)'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 5, 'isian_ke' => 26, 'jenis' => 'textarea',
			'judul_isian' => 'Apa saja tanggung jawab masing-masing tim Anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 5, 'isian_ke' => 27, 'jenis' => 'textarea',
			'judul_isian' => 'Tim anda berhasil jika ? indikator keberhasilan masing-masing',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 5, 'isian_ke' => 28, 'jenis' => 'textarea',
			'judul_isian' => 'Peralatan dan bahan yang dibutuhkan untuk membuat produk/jasa anda?',
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 5, 'isian_ke' => 29, 'jenis' => 'textarea',
			'judul_isian' => 'Jika Anda harus bermitra dalam menyediakan produk/jasa Anda, Siapa Mitra anda dan ' .
				'menyediakan/melakukan apa mitra anda?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 7, 'isian_ke' => 30, 'jenis' => 'textarea',
			'judul_isian' => 'Biaya apa saja yang Anda butuhkan dalam menyediakan, menjual, dan mengantarkan ' .
				'produk/jasa kepada pelanggan?'
		]);
		$this->db->insert('isian', [
			'kegiatan_id' => $kegiatan_id_2020, 'kelompok_isian_id' => 6, 'isian_ke' => 31, 'jenis' => 'radio',
			'judul_isian' => 'Jika terpilih sebagai penerima hibah, apa Anda sanggup memenuhi ketentuan dan ' .
				'syarat yang sudah ditetapkan?',
			'radio_options' => 'Ya|Tidak'
		]);
		echo "OK\n";

		echo "  > refactor data table isian_proposal (tahun 2020) ... ";
		$isian_proposal_set = $this->db->select('ip.*')->from('isian_proposal ip')
			->join('proposal p', 'p.id = ip.proposal_id')
			->join('kegiatan k', 'k.id = p.kegiatan_id')
			->where('k.program_id', PROGRAM_KBMI)
			->where('k.tahun', 2020)
			->get()->result();

		// Perubahan dari 2019 ke 2020
		// Step 6-12 : dari 13-19 - Informasi Produk
		// Step 13-19 : dari 6-12 - Sasaran Pelanggan

		$this->db->trans_start();

		// Pindah 6-12 ke Temporari 106-112 [Sasaran Pelanggan]
		foreach ($isian_proposal_set as $isian_proposal)
		{
			if ($isian_proposal->isian_ke == 6) { $isian_proposal->isian_ke = 106; }
			if ($isian_proposal->isian_ke == 7) { $isian_proposal->isian_ke = 107; }
			if ($isian_proposal->isian_ke == 8) { $isian_proposal->isian_ke = 108; }
			if ($isian_proposal->isian_ke == 9) { $isian_proposal->isian_ke = 109; }
			if ($isian_proposal->isian_ke == 10) { $isian_proposal->isian_ke = 110; }
			if ($isian_proposal->isian_ke == 11) { $isian_proposal->isian_ke = 111; }
			if ($isian_proposal->isian_ke == 12) { $isian_proposal->isian_ke = 112; }

			$isian_proposal->updated_at = date('Y-m-d H:i:s');
			$this->db->update('isian_proposal', $isian_proposal, ['id' => $isian_proposal->id]);
		}

		// Pindah 13-19 ke 6-12 [Informasi Produk]
		foreach ($isian_proposal_set as $isian_proposal)
		{
			if ($isian_proposal->isian_ke == 13) { $isian_proposal->isian_ke = 6; }
			if ($isian_proposal->isian_ke == 14) { $isian_proposal->isian_ke = 7; }
			if ($isian_proposal->isian_ke == 15) { $isian_proposal->isian_ke = 8; }
			if ($isian_proposal->isian_ke == 16) { $isian_proposal->isian_ke = 9; }
			if ($isian_proposal->isian_ke == 17) { $isian_proposal->isian_ke = 10; }
			if ($isian_proposal->isian_ke == 18) { $isian_proposal->isian_ke = 11; }
			if ($isian_proposal->isian_ke == 19) { $isian_proposal->isian_ke = 12; }

			$isian_proposal->updated_at = date('Y-m-d H:i:s');
			$this->db->update('isian_proposal', $isian_proposal, ['id' => $isian_proposal->id]);
		}

		// Pindah Temporari 106-112 ke 13-19 [Sasaran Pelanggan]
		foreach ($isian_proposal_set as $isian_proposal)
		{
			if ($isian_proposal->isian_ke == 106) { $isian_proposal->isian_ke = 13; }
			if ($isian_proposal->isian_ke == 107) { $isian_proposal->isian_ke = 14; }
			if ($isian_proposal->isian_ke == 108) { $isian_proposal->isian_ke = 15; }
			if ($isian_proposal->isian_ke == 109) { $isian_proposal->isian_ke = 16; }
			if ($isian_proposal->isian_ke == 110) { $isian_proposal->isian_ke = 17; }
			if ($isian_proposal->isian_ke == 111) { $isian_proposal->isian_ke = 18; }
			if ($isian_proposal->isian_ke == 112) { $isian_proposal->isian_ke = 19; }

			$isian_proposal->updated_at = date('Y-m-d H:i:s');
			$this->db->update('isian_proposal', $isian_proposal, ['id' => $isian_proposal->id]);
		}

		$this->db->trans_complete();

		echo "OK\n";
	}
	
	function down()
	{
		echo "  > drop table isian ... ";
		$this->dbforge->drop_table('isian');
		echo "OK\n";

		echo "  > drop table kelompok_isian ... ";
		$this->dbforge->drop_table('kelompok_isian');
		echo "OK\n";
	}
}
