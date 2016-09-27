<html>
<head>
<title>Acquisition Customer File Automation</title>
</head>
<h2>Customer Type Mapping Status</h2>

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
		echo "SUCCESS! The customer types were mapped successfully.<br><br>";
	}
	else
	{
		echo "ERROR! There was a problem mapping the customer types.<br><br>";
	}
}
else
{
	echo "ERROR! There was a problem mapping the customer types.<br><br>";
}

?>
<a href="index.html">Click here to return to the main menu</a>

</html>