<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_table_kegiatan_add_jadwal_laporan_akhir extends CI_Migration
{
	function up()
	{
		echo "  > alter table kegiatan ... ";
		$this->dbforge->add_column('kegiatan', [
			'tgl_awal_laporan_akhir DATETIME AFTER tgl_akhir_upload_kemajuan',
			'tgl_akhir_laporan_akhir DATETIME AFTER tgl_awal_laporan_akhir',
		]);
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback table kegiatan ... ";
		$this->dbforge->drop_column('kegiatan', 'tgl_awal_laporan_akhir');
		$this->dbforge->drop_column('kegiatan', 'tgl_akhir_laporan_akhir');
		echo "OK\n";
	}
}
