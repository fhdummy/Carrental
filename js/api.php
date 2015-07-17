<?php
	$servername = "pwnhofer.at";
	$username = "binna";
	$password = "affe123456!";
	$dbname = "binna";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	//echo "Connected successfully";

	$conn->query ('SET NAMES UTF8;');
	$conn->query ('SET COLLATION_CONNECTION=utf8_general_ci;');
	
	/* change character set to utf8 */
	if (!$conn->set_charset("utf8")) {
		//printf("Error loading character set utf8: %s\n", $conn->error);
	} else {
		//printf("Current character set: %s\n", $conn->character_set_name());
	}
	
	$sql = "SELECT DESCRIPTION FROM LOCATIONS";
	
	$result = $conn->query($sql);
	$data = array();
	
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc()) 
		{
			$data[] = $row;
		}
	}
	
	echo json_encode($data);
?>