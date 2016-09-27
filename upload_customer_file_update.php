<html>
<head>
<title>Acquisition Customer File Automation</title>
</head>
<h2>Load a Customer File Refresh</h2>

<form action="process_customer_upload_update.php" method="post" enctype="multipart/form-data">
Please select your Customer data file to upload.<br> 
<b>It must be in CSV format.</b><br>
<br>
<input type="file" name="file" id="file"><br>
<br>

<?php
$con=mysqli_connect("localhost","username,"password","acquisition"); //with DB

//check connection
if(mysqli_connect_errno())
{
	echo "ERROR: Failed to connect to the database!" . mysqli_connect_error();
}
else
{
	//echo "Connected!";
	echo "<label for='conversion_id'>Conversion Template:</label><br><select name='conversion_id'>"; 
	
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

</form>
<br>
<a href="index.html">Click here to return to the main menu</a>
</body>
</html>