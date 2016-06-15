<?php
require_once 'config.php';

class DB_Connection {
	
	private $connect;
	function __construct() {
		$this->connect=mysqli_connect(hostname,username,password,db_name);
	}
	
	public function get_connection() {
		//echo "Inside connection setups";
		return $this->connect;
	}
}
?>