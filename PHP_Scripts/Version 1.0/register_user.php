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
		
		$query = "select * from user_details where mobile_number='$mobile_number'";
		$result = mysqli_query($this->connection, $query);
		if(mysqli_num_rows($result)>0){
		$json['Error']='User Already registered';	
		}
		else {
		$query = "insert into user_details(mobile_number,first_name,last_name,mail_id,password) values('$mobile_number','$first_name','$last_name','$mail_id','$encrypt_password')";
		$is_inserted = mysqli_query($this->connection, $query);
		//echo "Before insert check";
		if ($is_inserted==1) {
			$json['success']='Your account has been created';
		}else {
			$json['error']='Error in creating , Please try after sometime';
		}
		}
		echo json_encode($json);
		
		mysqli_close($this->connection);
		
	}
}

$user = new User();
//if (isset($_POST['mobile_number'],$_POST['first_name'],$_POST['last_name'],$_POST['mail_id'],$_POST['password'])) {
	$entityBody = file_get_contents('php://input');
	
	$array = json_decode($entityBody,true);
	
	echo $array['mobile_number'];
//	if (isset($array['mobile_number'])){
	if (isset($array['mobile_number'],$array['first_name'],$array['last_name'],$array['mail_id'],$array['password'])) {
	$mobile_number =$array['mobile_number'] ;
	$first_name = $array['first_name'];
	$last_name = $array['last_name'];
	$mail_id = $array['mail_id'];
	$password = $array['password'];
	
	/*echo "after assigning to variable";
	echo "<br>";
	echo $mobile_number;
	echo $first_name;
	echo $last_name;
	echo $mail_id;
	echo $password;*/
	
	if (!empty($mobile_number) && !empty($mail_id) && !empty($password)) {
		$encrypt_password = md5($password);
		$user->register_user($mobile_number,$first_name,$last_name,$mail_id,$encrypt_password);
	}else {
		echo json_encode("Please enter manditatory fields");
	}
} else {
	echo "Nothing happening inside..";
}


?>