<?php

function mres($value)
{
	$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
	$replace = array("\\\\", "\\0", "\\n", "\\r", "", '', "\\Z");

	return str_replace($search, $replace, $value);
}

$status = "success";

//connect to database
$con=mysqli_connect("localhost","username,"password","acquisition"); //with DB

//check connection
if(mysqli_connect_errno())
{
	//echo "Failed to connect to the database!" . mysqli_connect_error() . "<br>";
	$status = "failure";
}
else
{
	//echo "Connected to the database!<br>";
}


//get values from POST
if(isset($_POST["conversion_id"]))
{
	$conversion_id = mres($_POST["conversion_id"]);
	//echo "Conversion Id: " . $conversion_id . "<br>";
}
else
{
	$conversion_id = "";
	$status = "failure";
}

if(isset($_POST["mapping_Old_Salesman"])) { $Mapping_Old_Salesman = mres($_POST["mapping_Old_Salesman"]); } else { $Mapping_Old_Salesman = ""; }
if(isset($_POST["mapping_New_Salesman"])) { $Mapping_New_Salesman = mres($_POST["mapping_New_Salesman"]); } else { $Mapping_New_Salesman = ""; }

if(isset($_POST["file_name"]))
{
	$file_name = mres($_POST["file_name"]);
	//echo "File Name: " . $file_name . "<br>";
}

//delete the existing mapping
$sql = "DELETE FROM salesman_mapping WHERE Acquisition_ID = '" . $conversion_id . "'";

//execute query
if(mysqli_query($con,$sql))
{
	//echo "SQL executed successfully!";
}
else
{
	//echo "Error executing SQL.";
}

//read file and insert into database
if(($handle = fopen($file_name, "r"))!== FALSE)
{
	//echo "opened the file<br>";
			
	$file_row_counter = 0;
				
	while(($data = fgetcsv($handle,1000,","))!==FALSE)
	{
		if($file_row_counter == 0) //skip the first row
		{
			//do nothing
		}
		else
		{
			for ($c=0; $c < sizeof($data); $c++)
			{
				//insert values into database
				$sql="INSERT INTO salesman_mapping
				(
				Acquisition_ID,
				Old_Salesman,
				New_Salesman
				)
				VALUES
				(
				'$conversion_id',
				'$data[$Mapping_Old_Salesman]',
				'$data[$Mapping_New_Salesman]'
				)";
				
				//execute query
				if(mysqli_query($con,$sql))
				{
					//echo "SQL command was successful!";
				}
				else
				{
					//echo "Error with SQL command: " . mysqli_error($con);
					$status = "failure";
				}
				
			}//while reading columns
		}//if not the first line
		$file_row_counter = $file_row_counter + 1;
	}//while reading rows
	
}
	
fclose($handle);

//disconnect from database
mysqli_close($con);

//header to success page
header("Location: salesman_mapping_status.php?status=" . $status);

?>