<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_table_isian extends CI_Migration
{
	function up()
	{
		echo "  > alter table isian ... ";
		$this->dbforge->add_column('isian', [
			'bentuk_pendidikan_id' => ['type' => 'int', 'null' => FALSE, 'after' => 'kegiatan_id'],
			'CONSTRAINT isian_bentuk_pendidikan_fk FOREIGN KEY (bentuk_pendidikan_id) REFERENCES bentuk_pendidikan (id)',
			'is_disabilitas' => ['type' => 'boolean', 'null' => FALSE, 'after' => 'bentuk_pendidikan_id', 'default' => '0'],
			'is_uploadable' => ['type' => 'boolean', 'default' => '0', 'after' => 'radio_options'],
			'allowed_types' => ['type' => 'text', 'after' => 'is_uploadable', 'default' => 'pdf'],
			'max_size' => ['type' => 'int', 'after' => 'allowed_types', 'comment' => 'in megabytes'],
			'CONSTRAINT isian_kegiatan_bpendidikan_isian_ke_unique UNIQUE (kegiatan_id, bentuk_pendidikan_id, isian_ke)'
		]);
		$this->dbforge->modify_column('isian', [
			'jenis' => [
				'type' => 'varchar',
				'constraint' => '10',
				'null' => FALSE,
				'comment' => 'richtext|textarea|text|radio'
			]
		]);
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback table isian ... ";
		$this->db->query("alter table isian drop index isian_kegiatan_bpendidikan_isian_ke_unique");
		$this->db->query("alter table isian drop foreign key isian_bentuk_pendidikan_fk");
		$this->dbforge->drop_column('isian', 'bentuk_pendidikan_id');
		$this->dbforge->drop_column('isian', 'is_disabilitas');
		$this->dbforge->drop_column('isian', 'is_uploadable');
		$this->dbforge->drop_column('isian', 'allowed_types');
		$this->dbforge->drop_column('isian', 'max_size');
		echo "OK\n";
	}
}
