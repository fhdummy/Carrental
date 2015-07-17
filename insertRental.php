<?php
	/* Check for input parameters, otherwise terminate the script */
	if(isset($_GET['startDate']) && isset($_GET['endDate']) && isset($_GET['locationString']) && isset($_GET['name']) && isset($_GET['numberplate']) && isset($_GET['mileage']))
	{
		$startDate = $_GET['startDate'];
		$startDate = date("Y-m-d", strtotime($startDate));
		
		$endDate = $_GET['endDate'];
		$endDate = date("Y-m-d", strtotime($endDate));
		
		$locationString = $_GET['locationString'];
		$numberplate = $_GET['numberplate'];
		$name = $_GET['name'];
		$mileage = $_GET['mileage'];
	} else 
	{
		exit ("Not all parameters were transmitted.");
	}
	
	/* Calculations */
	$diff = floor(abs(strtotime($endDate) - strtotime($startDate))/(24*60*60))+1;

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

	/* Adds a new customer into the table CUSTOMER */
	$sql = "SELECT NAME, CUSTOMER_ID FROM CUSTOMERS
			WHERE NAME = '" . $name . "'";
			
	$result = $conn->query($sql);
	
	if ($result->num_rows == 0)
	{
		$sql = "INSERT INTO CUSTOMERS (CUSTOMER_ID, NAME)
				SELECT c.customer_id+1, '". $name ."'
				FROM CUSTOMERS c
				LEFT JOIN CUSTOMERS c1 ON c1.customer_id = c.customer_id +1
				WHERE c1.customer_id IS NULL;";
				
		$result = $conn->query($sql);
		
		if($result === FALSE)
		{
			exit("Error at creating new CUSTOMER");
		} else
		{
				$sql = "SELECT CUSTOMER_ID FROM CUSTOMERS
						WHERE NAME = '" . $name . "'";
				
				$result = $conn->query($sql);
				
				if($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
					{
						$customerId = $row['CUSTOMER_ID'];
					}
				} else
				{
					exit("Error at getting CUSTOMER_ID");
				}
		}
	} else
	{
		while($row = $result->fetch_assoc())
		{
			$customerId = $row['CUSTOMER_ID'];
		}
	}
			
	/* Get all necessary informations */
	
	// Get the VEHICLE_ID
	$sql = "SELECT VEHICLE_ID FROM VEHICLE
			WHERE NUMBERPLATE = '" . $numberplate . "'";
			
	$result = $conn->query($sql);
	
	if ($result->num_rows == 1)
	{
		while($row = $result->fetch_assoc())
		{
			$vehicleId = $row['VEHICLE_ID'];
			echo "Vehicle-Id:".$row['VEHICLE_ID']."\n";
		}
	} else
	{
		exit("Error at getting VEHICLE_ID");
	}
	
	// Get the CUSTOMER_ID
	/*$sql = "SELECT c.CUSTOMER_ID
			FROM CUSTOMERS c
			LEFT JOIN CUSTOMERS c1 ON c1.customer_id = c.customer_id +1
			WHERE c1.customer_id IS NULL AND c.name = '" .$name."'";
			
	$result = $conn->query($sql);
	
	if ($result->num_rows == 1)
	{
		while($row = $result->fetch_assoc())
		{
			$customerId = $row['CUSTOMER_ID'];
			echo "Customer-Id: ".$row['CUSTOMER_ID']."\n";
		}
	} else
	{
		exit("Error at getting CUSTOMER_ID");
	}*/	
	
	// Get the LOCATION_ID
	$sql = "SELECT LOCATION_ID FROM LOCATIONS
			WHERE DESCRIPTION = '" . $locationString . "'";
			
	$result = $conn->query($sql);
	
	if ($result->num_rows == 1)
	{
		while($row = $result->fetch_assoc())
		{
			$locationId = $row['LOCATION_ID'];
			echo "Location-Id: ".$row['LOCATION_ID']."\n";
		}
	} else
	{
		exit("Error at getting LOC_LOCATION_ID");
	}	
	
	/* Create a new entry in the table RENTALS */
	$sql = "INSERT INTO RENTALS (RENTAL_ID, CUSTOMER_ID, VEHICLE_ID, LOC_LOCATION_ID,STARTDATE,PLANRETURNDATE,STARTKM)
	SELECT r.RENTAL_ID+1, '" .$customerId. "','" .$vehicleId. "','" .$locationId. "','" .$startDate. "','" .$endDate. "','" .$mileage. "'" . "
	FROM RENTALS r
	LEFT JOIN RENTALS r1 ON r1.RENTAL_ID = r.RENTAL_ID +1
	WHERE r1.RENTAL_ID IS NULL;";
	
	$result = $conn->query($sql);
	
	echo "Affected: ".$conn->affected_rows;
	if($result === FALSE)
	{
		exit("Error at creating new RENTALS");
	} 

	// Close connection
	$conn->close();
?> 