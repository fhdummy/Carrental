<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Form</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">
	<script type="text/javascript" src="js/moment.js"></script>

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		var rentalId = "";
		var startdate = "";
		var planreturndate = "";
		var startplace = "";
		var numberplate = "";
		var type = "";
		var startkm = "";
		var chargeperhour = "";
		var chargeperkm = "";
		var fineperhour = "";
		var differenceNormal = "";
		var differenceFine = "";
		var chargehour = "";
		var chargekm = "";
		var finehour = "";
		var time = "";
		
		var queryString = new Array();
		var dataToSend = [];
		
		$( document ).ready(function() {
			console.log( "Ready!" );

			if (queryString.length == 0) {
				if (window.location.search.split('?').length > 1) {
					var params = window.location.search.split('?')[1].split('&');
					for (var i = 0; i < params.length; i++) {
						var key = params[i].split('=')[0];
						var value = decodeURIComponent(params[i].split('=')[1]);
						queryString[key] = value;
					}
				}
			}
			if (queryString["rentalid"] != null) 
			{
				rentalId = queryString["rentalid"];
				
				dataToSend = 
				{
					id: "getParameters",
					rentalId: rentalId
				}

				$.ajax( 
				{                                      
					url: 'api.php', dataType: 'json', data: dataToSend, success: function(data)
					{
						startdate = data[0];
						planreturndate = data[1];
						startplace = data[2];
						numberplate = data[3];
						type = data[4];
						startkm = data[5];
						chargeperhour = data[6];
						chargeperkm = data[7];
						fineperhour = data[8];
						differenceNormal = data[9];
						differenceFine = data[10];
						
						$("#jqStartdate").html(startdate);
						$("#jqPlannedReturndate").html(planreturndate);
						$("#jqStartPlace").html(startplace);
						$("#jqNumberplate").html(numberplate);
						$("#jqType").html(type);
						$("#jqStartKm").html(startkm);
						$("#jqChargeperhour").html(chargeperhour+" €");
						$("#jqChargeperkm").html(chargeperkm+" €");
						$("#jqFineperhour").html(fineperhour+" €");
						
						console.log(differenceNormal);
						console.log("Fine: "+differenceFine);
						
						chargehour = chargeperhour * differenceNormal * 24;
						finehour = fineperhour * differenceFine * 24;
						
						$("#jqChargehour").html(chargehour+" €");
						$("#jqFinehour").html(finehour+" €");
						
						if(differenceNormal == "FALSE NORMAL") 
						{
							console.log("False successful");
							$("#secondbox").hide();
							$("#mainbox").html("Returndate is earlier than startdate. Check the values again.");
						}
					},
					error: function(data, status)
					{
					console.log(data);
					console.log(status);
					}	
				});		
				
				time = moment().format('DD.MM.YYYY');
				$("#jqReturndate").html(time);
				
			}
			else
			{
				$("#mainbox").html("Oops an Error occured, return to previous page.");
			}			
		});
	</script>

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.html">Business Casual</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="cars.php">Rent</a>
                    </li>
					<li>
                        <a href="return.php">Return</a>
                    </li>
                    <li>
                        <a href="about.html">About</a>
                    </li>	
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">
	
		<div class="row">
			<div class="box" id="mainbox">
				<div class="col-lg-4 col-lg-offset-3">
					<h5>Already known:</h5>
					<b>Startdate: </b><span id="jqStartdate"></span><br>
					<b>Planned Returndate: </b><span id="jqPlannedReturndate"></span><br>
					<b>Start place: </b><span id="jqStartPlace"></span><br>
					<b>Type: </b><span id="jqType"></span><br>
					<b>Numberplate: </b><span id="jqNumberplate"></span><br>
					<b>Start Kilometer: </b><span id="jqStartKm"></span><br><br>
				</div>
				<div class="col-lg-4">
					<h5>Generated:</h5>
					<b>Returndate (Today): </b><span id="jqReturndate"></span><br>
					<b>End Kilometer: </b><span id="jqEndKm"></span><br><br>
				</div>
				<div class="col-lg-4 col-lg-offset-3">
					<h5>Charges:</h5>
					<b>Charge per hour: </b><span id="jqChargeperhour"></span><br>
					<b>Charge per kilometer: </b><span id="jqChargeperkm"></span><br>
					<b>Fine per hour: </b><span id="jqFineperhour"></span><br>
				</div>
				<div class="col-lg-4">
					<h5>Total costs:</h5>
					<b>Total hour charge: </b><span id="jqChargehour"></span><br>
					<b>Total kilometer charge: </b><span id="jqChargekilometer">Enter end kilometer</span><br>
					<b>Total hour fine: </b><span id="jqFinehour"></span><br>
					<hr>
					<b>Total charge: </b><span id="jqTotalcharge"></span><br>
				</div>
			</div>
			
			<div class="box" id="secondbox">
				<div class="col-lg-6 col-lg-offset-3">
					<form id="form1" class="form-horizontal">
						<div class="form-group">
						<label for="inputKm1" class="col-lg-2 control-label">End Km</label>
							<div class="col-lg-4">
								<input type="name" class="form-control" id="inputKm1" placeholder="End Kilometer">
							</div>
							
							<label for="inputSelect1" class="col-lg-2 control-label">Location</label>
							<div class="col-lg-4">
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
									$conn->set_charset("utf8");
			
									$sql = "SELECT DESCRIPTION, LOCATION_ID FROM LOCATIONS";
									$result = $conn->query($sql);
									
									if ($result->num_rows > 0) 
									{
										echo "<select id='inputSelect1' class='form-control'>\n";
																
										// output data of each row
										$count = 0;
										
										while($row = $result->fetch_assoc()) 
										{
											echo "<option value='".$row["LOCATION_ID"]."'>".$row["DESCRIPTION"]."</option>\n";
											$count++;
										}
										echo "</select>\n";
									} 
									
									$conn->close();
								?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-3">
								<button id="generateCost" class="btn btn-default">Generate costs</button>
							</div>
							<div class="col-lg-offset-2 col-lg-3">
								<button id="return" type="submit" class="btn btn-default">Return car</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		

    <!-- /.container -->
	</div>
	
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Car Rental 2015</p>
                </div>
            </div>
        </div>
    </footer>

	<script type="text/javascript">
		$("#inputKm1").on("input", function() {
			console.log($("#inputKm1").val());
			$("#jqEndKm").html($("#inputKm1").val());
			
			chargekm = ($("#inputKm1").val() - startkm) * chargeperkm;
			if(chargekm < 0)
			{
				chargekm = "";
				$("#jqChargekilometer").html("End kilometer is smaller than start kilometer");
			}
			else
			{
				$("#jqChargekilometer").html(chargekm+"€");
			}
		});
		
		$("#generateCost").click( function(event) {
			event.preventDefault();
			console.log("generate pressed");
			if(chargehour == 0 || chargekm == 0 || finehour == 0)
			{
				alert("A part of the charges is empty. Try again.");
			} else
			{
				$("#jqTotalcharge").html(chargehour + chargekm + finehour + " €");
			}
		});
		
		$("#return").click( function(event) {
			event.preventDefault();
			console.log("return clicked");
			if($("#jqTotalcharge").is(':empty')) 
			{
				alert("Something went wrong. Try again.");
			} else
			{
				dataToSend = 
				{
					id: "returnCar",
					rentalId: rentalId,
					returnDate: time,
					endKm: $("#inputKm1").val(),
					costPre: chargehour,
					costKm: chargekm,
					location: $("#inputSelect1 option:selected").text()
				}
				
				$.ajax( 
				{                                      
					url: 'api.php', data: dataToSend, success: function(data)
					{
						if(data === 'Error at updating RENTALS')
						{
							$("#mainbox").html(data);
							$("#secondbox").hide();
							console.log("Error at updating RENTALS.");
						} else if(data === 'Error at updating VEHICLE')
						{
							$("#mainbox").html(data);
							$("#secondbox").hide();
							console.log("Error at updating VEHICLE.");
						} else
						{
							$("#mainbox").html("<h2>The return was successfull.</h2><br>");
							$("#mainbox").append("Back to <a href='cars.php'>car selection</a>");
							$("#secondbox").hide();
						}
					},
					error: function(data, status)
					{
					console.log(data);
					console.log(status);
					}	
				});		
			}
		});
	</script>
	
</body>

</html>
