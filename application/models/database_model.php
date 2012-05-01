<?php

class Database_model extends CI_Model
{
	function insert( $table, $values)
	{
		$this->db->insert($table, $values);
	}
}
