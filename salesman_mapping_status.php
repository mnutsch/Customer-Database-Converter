<html>
<head>
<title>Acquisition Customer File Automation</title>
</head>
<h2>Salesman Mapping Status</h2>

<?php

function mres($value)
{
	$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
	$replace = array("\\\\", "\\0", "\\n", "\\r", "", '', "\\Z");

	return str_replace($search, $replace, $value);
}


//get values from GET
if(isset($_GET["status"]))
{
	$status = mres($_GET["status"]);
	if($status == "success")
	{
		echo "SUCCESS! The salesman initials were mapped successfully.<br><br>";
	}
	else
	{
		echo "ERROR! There was a problem mapping the salesman initials.<br><br>";
	}
}
else
{
	echo "ERROR! There was a problem mapping the salesman initials.<br><br>";
}

?>
<a href="index.html">Click here to return to the main menu</a>

</html>