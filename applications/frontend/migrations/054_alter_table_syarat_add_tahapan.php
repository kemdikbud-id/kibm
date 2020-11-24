<?php

/**
 * Class Migration_Alter_table_syarat_add_tahapan
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_table_syarat_add_tahapan extends CI_Migration
{
	public function up()
	{
		echo "  > alter table syarat ... ";
		$this->dbforge->add_column('syarat', [
			'tahapan_id INT AFTER kegiatan_id',
			'FOREIGN KEY fk_syarat_tahapan (tahapan_id) REFERENCES tahapan (id)'
		]);
		echo "OK\n";

		// Update existing syarat
		echo "  > update existing syarat ... ";
		$this->db->update('syarat', ['tahapan_id' => 1]);
		$this->dbforge->modify_column('syarat', 'tahapan_id INT NOT NULL');
		echo "OK\n";
	}

	public function down()
	{
		echo "  > rollback table syarat ... ";
		$this->db->query('ALTER TABLE syarat DROP FOREIGN KEY fk_syarat_tahapan');
		$this->dbforge->drop_column('syarat', 'tahapan_id');
		echo "OK\n";
	}
}
