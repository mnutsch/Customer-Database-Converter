<html>
<head>
<title>Acquisition Customer File Automation</title>
</head>
<body>
<h2>Download Customer File</h2>


<form action="process_download_customer_file.php" method="post" enctype="multipart/form-data">

<?php
$con=mysqli_connect("localhost","username","password","acquisition"); //with DB

//check connection
if(mysqli_connect_errno())
{
	echo "ERROR: Failed to connect to the database!" . mysqli_connect_error();
}
else
{
	//echo "Connected!";
	echo "<label for='conversion_id'>Conversion Name:</label><br><select name='conversion_id'>"; 
	
	$result = mysqli_query($con, "SELECT * FROM conversions");
	
	while($row = mysqli_fetch_array($result))
	{
		echo "<option value='" . $row['PID'] . "'>" . $row['Conversion_Name'] . "</option>";
	}
	
	echo "</select><br><br>";

	
	
}

mysqli_close($con);

?>

<input type="submit" value="Submit">

<br>
<br>
<a href="index.html">Click here to return to the main menu</a>
</body>
</html>