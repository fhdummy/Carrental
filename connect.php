<?php

	/* Initiate database connection */
	$servername = "pwnhofer.at";
	$username = "binna";
	$password = "affe123456!";
	$dbname = "binna";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname, 8080);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	echo "Connected successfully";

	$conn->query ('SET NAMES UTF8;');
	$conn->query ('SET COLLATION_CONNECTION=utf8_general_ci;');
	
	/* change character set to utf8 */
	if (!$conn->set_charset("utf8")) {
		printf("Error loading character set utf8: %s\n", $conn->error);
	} else {
		printf("Current character set: %s\n", $conn->character_set_name());
	}
	
	/* Create SQL statement */
	/*$sql = "SELECT v.NUMBERPLATE, t.TYPE, t.MAXPERSONS, c.CHARGEPERHOUR*24*" . $diff . " AS costs
			FROM VEHICLE v
			JOIN VEHICLETYPE t ON v.VEHICLETYPE_ID = t.VEHICLETYPE_ID
			JOIN CHARGECLASS c ON t.CHARGECLASS_ID = c.CHARGECLASS_ID
			WHERE v.CURRENT_LOCATION = '" . $location . "'
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
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-bordered'<tr><th>Type</th><th>Maximum Persons</th><th>Numberplate</th><th>Costs</th><th>Wahl</th></tr>";
		echo "<div class='radio'";
		echo "<label>";
		
		// output data of each row
		$count = 0;
		
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>".$row["TYPE"]."</td><td>".$row["MAXPERSONS"]."</td><td>".$row["NUMBERPLATE"]."</td><td>".$row["costs"]."</td><td><div id='radioDiv'><input type='radio' name='optionsRadios' id='optionsRadios".$count."' value='".$row["NUMBERPLATE"]."'";
			if($count==0) echo "checked = 'checked'";
			echo "></div></td></tr>";
			$count++;
		}
		echo "</label>";
		echo "</div>";
		echo "</table>";
		echo "</div>";
	} else
	{
		exit("There are no cars available");
	}*/

	// Close connection
	$conn->close();
?> 