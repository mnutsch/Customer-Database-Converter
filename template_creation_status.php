<html>
<head>
<title>Acquisition Customer File Automation</title>
</head>
<h2>Template Creation Status</h2>

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
		echo "SUCCESS! Your conversion template has been created.<br>";
	}
	else
	{
		echo "ERROR! There was a problem creating the template.<br>";
	}
}
else
{
	echo "ERROR! There was a problem creating the template.<br>";
}

?>
<a href="index.html">Click here to return to the main menu</a>

</html>