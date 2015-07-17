<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title></title>
	</head>
	<body>

<?php
$db = @new mysqli('db4free.net:3306', 'graka', 'affe123456!', 'carrental1993');
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT DRIVERLICENSE_ID, LICENSE, DESCRIPTION FROM DRIVERLICENSE';

$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo 'Die Ergebnistabelle besitzt '.$result->num_rows." Datensätze<br />\n";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "DRIVERLICENSE_ID: " . $row["DRIVERLICENSE_ID"]. " - LICENSE: " . $row["LICENSE"]. " " . $row["DESCRIPTION"]. "<br>";
    }
} else {
    echo "0 results";
}

$result->close();
unset($result); // und referenz zum objekt löschen, brauchen wir ja nicht mehr...
?>


	</body>
</html>