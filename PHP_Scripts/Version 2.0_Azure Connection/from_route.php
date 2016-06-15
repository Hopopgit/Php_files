<?php

require_once 'connection.php';
header('Content-Type:application/json');

class Route_search {
	
	private $db;
	private $connection;
	
	function __construct() {
 		
		$this->db= new DB_Connection();
		$this->connection = $this->db->get_connection();
		
	}
	
	public function get_all_routes() {
		$query="select distinct id, route_id, stop_location from h_route_timings" or die(mysql_error());
		$result = mysqli_query($this->connection, $query);
		
		if (mysqli_num_rows($result)>0) {
			
			$response["From_Routes"]=array();
			
			while ($row=mysqli_fetch_array($result)) {
				
				$from_route = array();
				$from_route["stop_id"]=$row["id"];
				$from_route["route_id"]=$row["route_id"];
				$from_route["stop_location"]=$row["stop_location"];
				array_push($response["From_Routes"], $from_route);
			}
			
			$response["success"]=1;
			http_response_code(200);  //status for header
			//header('success','true','200');
			echo json_encode($response);
			mysqli_close($this->connection);
		}
		else {
			echo json_encode("Something went wrong..Connection Lost!!!!");
			mysqli_close($this->connection);
		}
	}
}

$Route = new Route_search();

$Route->get_all_routes();

?>
