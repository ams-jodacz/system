<?php
	$servername = "localhost";
	$username = "root";
	$password = "sanbeda2015//";
	// $dbname = "san_beda";
	$dbname = "db_ams";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM stations";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	$id = $row['station_id'];
	    	$ip = $row['ip'];

	    	$station_status = false;
	    	$str = "ping -c 3 {$ip}";
			$pingresult = exec($str, $outcome, $status);
			if ($status == 0) {
				$station_status = true;
			}

			$sql = "UPDATE stations SET station_status='{$station_status}' WHERE station_id=$id";
			$conn->query($sql);
	    }
	}
	$conn->close();
?>