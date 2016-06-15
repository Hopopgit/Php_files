<?php
require_once 'connection.php';
header('Content-Type:application/json');

class User {
	
	private $db;
	private $connection;
	function __construct() {
		$this->db = new DB_Connection();
		$this->connection = $this->db->get_connection();
	}
	
	public function user_validation($mobile_number,$password) {
		$query ="select * from user_details where mobile_number='$mobile_number' and password='$password'";
		$result=mysqli_query($this->connection, $query);
		if (mysqli_num_rows($result)>0) {
			$json['success']='welcome back';
			echo json_encode($json);
			mysqli_close($this->connection);
		}else {
			echo json_encode("Details Mismatch");
			mysqli_close($this->connection);
		}
	}
}

$User = new User();

$entityBody = file_get_contents('php://input');
	
$array = json_decode($entityBody,true);

if (isset($array['mobile_number'],$array['password'])) {
	$mobile_number = $array['mobile_number'];
	$password = $array['password'];
	
	if (!empty($mobile_number) && !empty($password)) {
		$encrypt_password=md5($password);
		$User->user_validation($mobile_number,$password);
	}else {
		echo json_encode("Enter full details please");
	}
}
?>