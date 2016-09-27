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
}

if(isset($_POST["mapping_Old_Type"])) { $Mapping_Old_Type = mres($_POST["mapping_Old_Type"]); } else { $Mapping_Old_Type = ""; }
if(isset($_POST["mapping_New_Type"])) { $Mapping_New_Type = mres($_POST["mapping_New_Type"]); } else { $Mapping_New_Type = ""; }

if(isset($_POST["file_name"]))
{
	$file_name = mres($_POST["file_name"]);
	//echo "File Name: " . $file_name . "<br>";
}

//delete the existing mapping
$sql = "DELETE FROM cust_type_mapping WHERE Acquisition_ID = '" . $conversion_id . "'";

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
				$sql="INSERT INTO cust_type_mapping
				(
				Acquisition_ID,
				Old_Type,
				New_Type
				)
				VALUES
				(
				'$conversion_id',
				'$data[$Mapping_Old_Type]',
				'$data[$Mapping_New_Type]'
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
header("Location: customer_type_mapping_status.php?status=" . $status);

?>