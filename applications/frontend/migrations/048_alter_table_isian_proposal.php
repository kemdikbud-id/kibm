<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_table_isian_proposal extends CI_Migration
{
	function up()
	{
		echo "  > alter table isian_proposal ... ";
		$this->dbforge->modify_column('isian_proposal', [
			'isian_ke' => ['name' => 'isian_id', 'type' => 'int', 'null' => FALSE]
		]);
		$this->dbforge->add_column('isian_proposal', [
			'CONSTRAINT isian_proposal_isian_fk FOREIGN KEY (isian_id) REFERENCES isian (id)',
			'nama_file' => ['type' => 'varchar', 'constraint' => 250, 'null' => TRUE, 'after' => 'isian'],
			'nama_asli' => ['type' => 'varchar', 'constraint' => 250, 'null' => TRUE, 'after' => 'nama_file'],
		]);
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback table isian_proposal ... ";
		$this->db->query("alter table isian_proposal drop foreign key isian_proposal_isian_fk");
		$this->dbforge->modify_column('isian_proposal', [
			'isian_id' => ['name' => 'isian_ke', 'type' => 'int', 'null' => TRUE]
		]);
		$this->dbforge->drop_column('isian_proposal', 'nama_file');
		$this->dbforge->drop_column('isian_proposal', 'nama_asli');
		echo "OK\n";
	}
}
