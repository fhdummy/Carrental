<?php
	/* Check for input parameters, otherwise terminate the script */
	if(isset($_GET['startDate']) && isset($_GET['endDate']) && isset($_GET['location']))
	{
		$startDate = $_GET['startDate'];
		$startDate = date("Y-m-d", strtotime($startDate));
		
		$endDate = $_GET['endDate'];
		$endDate = date("Y-m-d", strtotime($endDate));
		
		$location = $_GET['location'];
		
		$numberplate = $_GET['numberplate'];
	} else 
	{
		exit ("You forgot to choose either start date, end date or location");
	}

	/* Initiate database connection */
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
	
	/* Create SQL statement */
	$sql = "SELECT v.NUMBERPLATE, t.TYPE, t.MAXPERSONS
			FROM VEHICLE v
			JOIN VEHICLETYPE t ON v.VEHICLETYPE_ID = t.VEHICLETYPE_ID
			JOIN CHARGECLASS c ON t.CHARGECLASS_ID = c.CHARGECLASS_ID
			WHERE v.CURRENT_LOCATION = '" . $location . "'
			AND v.NUMBERPLATE = '" . $numberplate . "'
			AND v.VEHICLE_ID NOT 
			IN (
				SELECT v.VEHICLE_ID
				FROM VEHICLE v
				JOIN RENTALS r ON v.VEHICLE_ID = r.VEHICLE_ID
				WHERE r.STARTDATE
				BETWEEN '" . $startDate . "'
				AND '" . $endDate . "'
				OR r.PLANRETURNDATE
				BETWEEN '" . $startDate . "'
				AND '" . $endDate . "'
			)";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		
	} else
	{
		exit("There are no cars available");
	}

	// Close connection
	$conn->close();
?> 