<?php
require_once 'connection.php';
header('Content-Type:application/json');

class user {
	
	private $db;
	private $connection;
	
	function __construct() {
		$this->db = new DB_Connection();
		$this->connection = $this->db->get_connection();
	}
	
	public function register_user($mobile_number,$first_name,$last_name,$mail_id,$encrypt_password) {
		$query = "insert into user_details(mobile_number,first_name,last_name,mail_id,password) values('$mobile_number','$first_name','$last_name','$mail_id','$encrypt_password')";
		$is_inserted = mysqli_query($this->connection, $query);
		
		if ($is_inserted==1) {
			$json['success']='Your account has been created';
		}else {
			$json['error']='Error in creating , Please try after sometime';
		}
		echo json_encode($json);
		mysqli_close($this->connection);
		
	}
}

$user = new User();
if (isset($_POST['mobile_number'],$_POST['first_name'],$_POST['last_name'],$_POST['mail_id'],$_POST['password'])) {
	$mobile_number =$_POST['mobile_number'] ;
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$mail_id = $_POST['mail_id'];
	$password = $_POST['password'];
	
	if (!empty($mobile_number) && !empty($mail_id) && !empty($password)) {
		$encrypt_password = md5($password);
		$user->register_user($mobile_number,$first_name,$last_name,$mail_id,$encrypt_password);
	}else {
		echo json_encode("Please enter manditatory fields");
	}
}


?>