<?php
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
		
	if(isset($_GET['id']))
	{
		if($_GET['id'] == "getName")
		{
			if(isset($_GET['name'])) $name = $_GET['name'];
			
			$sql = "SELECT DATE_FORMAT(r.STARTDATE, '%d.%m.%Y') AS 'STARTDATE', DATE_FORMAT(r.PLANRETURNDATE, '%d.%m.%Y') AS 'PLANRETURNDATE', l.DESCRIPTION, v.NUMBERPLATE, v2.TYPE, r.RENTAL_ID FROM CUSTOMERS c
					LEFT OUTER JOIN RENTALS r USING (CUSTOMER_ID)
					LEFT OUTER JOIN LOCATIONS l ON l.LOCATION_ID = r.LOC_LOCATION_ID
					LEFT OUTER JOIN VEHICLE v USING (VEHICLE_ID)
					LEFT OUTER JOIN VEHICLETYPE v2 USING (VEHICLETYPE_ID)
					WHERE c.NAME = '" . $name . "' AND r.RETURNDATE IS NULL
					";
					
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				echo "<div class='table-responsive'>";
				echo "<table class='table table-striped table-bordered'>
					  <tr>
						  <td>Name</td>
						  <td>Startdate</td>
						  <td>Planned Returndate</td>
						  <td>Car</td>
						  <td>Numberplate</td>
						  <td>Start place</td>
						  <td>Choice</td>
					  </tr>";
				echo "<div class='radio'>";
				echo "<label>";
				
				// output data of each row
				$count = 0;
				
				while($row = $result->fetch_assoc()) {
					echo "<tr>
					<td>".$name."</td>
					<td>".$row["STARTDATE"]."</td>
					<td>".$row["PLANRETURNDATE"]."</td>
					<td>".$row["TYPE"]."</td>
					<td>".$row["NUMBERPLATE"]."</td>
					<td>".$row["DESCRIPTION"]."</td>
					<td>
						<div id='radioDiv'><input type='radio' name='optionsRadios' id='optionsRadios".$count."' value='".$row["RENTAL_ID"]."'";
						if($count==0) echo "checked = 'checked'";
						echo "></div>
					</td>
					</tr>";
					$count++;
				}
				echo "</label>";
				echo "</div>";
				echo "</table>";
				echo "</div>";
			} else
			{
				exit("There are no rentals available.");
			}
		}
		
		if($_GET['id'] == "getParameters")
		{	
			if(isset($_GET['rentalId'])) $rentalId = $_GET['rentalId'];
			
			$sql = "SELECT DATE_FORMAT(r.STARTDATE, '%d.%m.%Y') AS 'STARTDATE', DATE_FORMAT(r.PLANRETURNDATE, '%d.%m.%Y') AS 'PLANRETURNDATE', l.DESCRIPTION, v.NUMBERPLATE, v2.TYPE, r.RENTAL_ID, r.STARTKM, c2.CHARGEPERHOUR, c2.CHARGEPERKM, c2.FINEPERHOUR FROM CUSTOMERS c
					LEFT OUTER JOIN RENTALS r USING (CUSTOMER_ID)
					LEFT OUTER JOIN LOCATIONS l ON l.LOCATION_ID = r.LOC_LOCATION_ID
					LEFT OUTER JOIN VEHICLE v USING (VEHICLE_ID)
					LEFT OUTER JOIN VEHICLETYPE v2 USING (VEHICLETYPE_ID)
					LEFT OUTER JOIN CHARGECLASS c2 ON c2.CHARGECLASS_ID = v2.CHARGECLASS_ID
					WHERE r.RENTAL_ID = '". $rentalId . "'
					";
					
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) 
			{						
				while($row = $result->fetch_assoc()) 
				{
					$startdate = $row["STARTDATE"];
					$planreturndate = $row["PLANRETURNDATE"];
					$description = $row["DESCRIPTION"];
					$numberplate = $row["NUMBERPLATE"];
					$type = $row["TYPE"];
					$startkm = $row["STARTKM"];
					$chargeperhour = $row["CHARGEPERHOUR"];
					$chargeperkm = $row["CHARGEPERKM"];
					$fineperhour = $row["FINEPERHOUR"];
				}
			}
			
			$currentDate = date('Y-m-d');
			
			/* Calculations */
			if(strtotime($currentDate) >= strtotime($startdate))
			{
				$diffNormal = floor(abs(strtotime($currentDate) - strtotime($startdate))/(24*60*60))+1;
			} else
			{
				$diffNormal = "FALSE NORMAL";
			}
			if(strtotime($currentDate) >= strtotime($planreturndate))
			{
				$diffFine = floor(abs(strtotime($currentDate) - strtotime($planreturndate))/(24*60*60))+1;
			} else
			{
				$diffFine = 0;
			}
			//echo $chargeperhour;
			
			echo json_encode(array($startdate, $planreturndate, $description, $numberplate, $type, $startkm, $chargeperhour, $chargeperkm, $fineperhour, $diffNormal, $diffFine, $currentDate));
		}
		
		if($_GET['id'] == "returnCar")
		{	
			if(isset($_GET['rentalId']) && isset($_GET['returnDate']) && isset($_GET['endKm']) && isset($_GET['costPre']) && isset($_GET['costKm']) && isset($_GET['location']))
			{
				$rentalId = $_GET['rentalId'];
				$returnDate = date("Y-m-d", strtotime($_GET['returnDate']));
				$endKm = $_GET['endKm'];
				$costPre = $_GET['costPre'];
				$costKm = $_GET['costKm'];
				$location = $_GET['location'];
			} else
			{
				exit ("A problem occurred.");
			}
			
			$sql = "UPDATE RENTALS
					SET COSTPRE = '" . $costPre . "',
					COSTKM = '" . $costKm . "',
					RETURNDATE = '" . $returnDate . "',
					ENDKM = '" . $endKm . "',
					LOCATION_ID = (SELECT LOCATION_ID FROM LOCATIONS WHERE DESCRIPTION = '" . $location . "') 
					WHERE RENTAL_ID = '" . $rentalId . "'
					";
					
			$result = $conn->query($sql);
			
			if($result === FALSE)
			{
				exit("Error at updating RENTALS");
			} else
			{
				$sql = "UPDATE VEHICLE 
						SET CURRENT_LOCATION = (SELECT LOCATION_ID FROM LOCATIONS WHERE DESCRIPTION = '" . $location . "')
						WHERE VEHICLE_ID = (SELECT VEHICLE_ID FROM RENTALS WHERE RENTAL_ID = '" . $rentalId . "')
						";
						
				$result = $conn->query($sql);
						
				if($result === FALSE)
				{
					exit("Error at updating VEHICLE");
				} else
				{
					exit("Successful");
				}
			}
		}
	}
	
	else
	{
		/* Check for input parameters, otherwise terminate the script */
		if(isset($_GET['startDate']) && isset($_GET['endDate']) && isset($_GET['location']))
		{
			$startDate = $_GET['startDate'];
			$startDate = date("Y-m-d", strtotime($startDate));
			
			$endDate = $_GET['endDate'];
			$endDate = date("Y-m-d", strtotime($endDate));
			
			$location = $_GET['location'];
		} else 
		{
			exit ("You forgot to choose either start date, end date or location");
		}
		
		/* Calculations */
		$diff = floor(abs(strtotime($endDate) - strtotime($startDate))/(24*60*60))+1;
		
		/* Create SQL statement */
		$sql = "SELECT v.NUMBERPLATE, t.TYPE, t.MAXPERSONS, c.CHARGEPERHOUR*24*" . $diff . " AS costs
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
				echo "<tr><td>".$row["TYPE"]."</td><td>".$row["MAXPERSONS"]."</td><td>".$row["NUMBERPLATE"]."</td><td>".$row["costs"]." €</td><td><div id='radioDiv'><input type='radio' name='optionsRadios' id='optionsRadios".$count."' value='".$row["NUMBERPLATE"]."'";
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
		}
	}
	
	// Close connection
	$conn->close();
?> 