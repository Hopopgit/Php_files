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
		
		public function get_to_routes($stop_location) {
			
			$query = "select dest.stop_location , dest.route_id from h_route_timings dest 
join h_route_timings source on dest.route_id = source.route_id and source.stop_location='$stop_location' and source.d_active='1'
where dest.d_active='1' and dest.stop_location <> source.stop_location";
			
			$result = mysqli_query($this->connection, $query);	
			
			if (mysqli_num_rows($result)>0) {
					
				$response["To_Routes"]=array();
					
				while ($row=mysqli_fetch_array($result)) {
			
					$to_route = array();
					$to_route["stop_location"]=$row["stop_location"];
					array_push($response["To_Routes"], $to_route);
				}
					
				$response["success"]=1;
				http_response_code(200);  //status for header
				//header('success','true','200');
				echo json_encode($response);
				mysqli_close($this->connection);
		}
		
		else {
			http_response_code(204);
			echo json_encode("Something went wrong..Result has nothing");
			mysqli_close($this->connection);
		}
	}
}
		
		$Route = new Route_search();
		
		if(isset($_POST['stop_location'])){
			
			$stop_location = $_POST['stop_location'];
			
			if(!empty($stop_location)){
				
				$Route->get_to_routes($stop_location);
			}
		}else {
			http_response_code(203); 
			echo json_encode("Select stop location please");
		}
	
?>