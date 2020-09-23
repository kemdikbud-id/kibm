<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_table_isian_proposal_2 extends CI_Migration
{
	function up()
	{
		echo "  > alter table isian_proposal ... ";
		$this->dbforge->modify_column('isian_proposal', [
			'isian' => ['name' => 'isian', 'type' => 'longtext', 'null' => TRUE]
		]);
		echo "OK\n";
	}
	
	function down()
	{
		echo "  > rollback table isian_proposal ... ";
		$this->dbforge->modify_column('isian_proposal', [
			'isian' => ['name' => 'isian', 'type' => 'text', 'null' => TRUE]
		]);
		echo "OK\n";
	}
}
