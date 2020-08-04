<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_table_mahasiswa extends CI_Migration
{
	function up()
	{
		echo "  > alter table mahasiswa ... ";
		$this->dbforge->add_column('mahasiswa', [
			'is_disabilitas' => ['type' => 'boolean', 'after' => 'no_hp', 'default' => '0']
		]);
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback table mahasiswa ... ";
		$this->dbforge->drop_column('mahasiswa', 'is_disabilitas');
		echo "OK\n";
	}
}
