<html>
<head>
<title>Acquisition Customer File Automation</title>
</head>
<h2>Mapping Salesman</h2>

<?php
ini_set('max_execution_time', 6000); //keep the page from timing output_add_rewrite_var

@$today = date("Y-m-d H:i:s");
echo "The timestamp is " . $today . "<br><br>";

//Define Variables
$allowedExts = array("csv", "txt"); //extension types that we are allowed to upload
$old_labels_array = array(); //an array to hold the old column headers

//HANDLE UPLOAD OF FILE

//If a file was posted
if(isset($_FILES["file"]["name"]))
{
	//if the file name already exists then delete it
	if(file_exists($_FILES["file"]["name"]))
	{
		unlink($_FILES["file"]["name"]);
	}
	
	//get the extension of the file
	$extension = end(explode(".", $_FILES["file"]["name"]));
	
	//if the file size and type is allowedExts
	if(($_FILES["file"]["size"] < 40000000) && in_array($extension, $allowedExts))
	{
		if($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}
		else //if there is not an error
		{
			echo "File Information:<br>";
			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			echo "Type: " . $_FILES["file"]["type"] . "<br>";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . "kB<br>";
			echo "Temp File: " . $_FILES["file"]["tmp_name"] . "<br>";
			
			if(file_exists($_FILES["file"]["name"]))
			{
				echo $_FILES["file"]["name"] . " already exists."; //this should never echo
			}
			else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],
				$_FILES["file"]["name"]);
				echo "Stored in: " . $_FILES["file"]["name"];
			}
			
			echo "<br>";
			echo "<br>";
			echo "The following are the formatted items from the new file:<br><br>";
			//echo "<div style='max-width:800px; max-height:300px; overflow-y:auto; overflow-x:auto;'>";
			
			if(($handle = fopen($_FILES["file"]["name"], "r"))!== FALSE)
			{
				//echo "opened the file<br>";
				
				$file_row_counter = 0;
				
				while(($data = fgetcsv($handle,1000,","))!==FALSE)
				{
					if($file_row_counter == 0)
					{
						for ($c=0; $c < sizeof($data); $c++)
						{
							//insert labels into an array
							$old_labels_array[$c] = $data[$c];
							
							//echo for debug
							//echo $c . ". " . $data[$c] . "<br>";
						}
						
					}
					$file_row_counter = $file_row_counter + 1;
				}
				
				fclose($handle);

				//form
				echo "<form action='process_map_salesman.php' method='post'>";
				
				echo "<h4>Conversion</h4>";
				$con=mysqli_connect("localhost","username,"password","acquisition"); //with DB

				//check connection
				if(mysqli_connect_errno())
				{
					echo "ERROR: Failed to connect to the database!" . mysqli_connect_error();
				}
				else
				{
					//echo "Connected!";
					echo "<label for='conversion_id'>Select The Conversion Template:</label><br><select name='conversion_id'>"; 
					
					$result = mysqli_query($con, "SELECT * FROM conversions");
					
					while($row = mysqli_fetch_array($result))
					{
						echo "<option value='" . $row['PID'] . "'>" . $row['Conversion_Name'] . "</option>";
					}
					
					echo "</select><br><br>";

					
					
				}

				mysqli_close($con);

								
				echo "<hr>";
				//value mapping
				echo "<h4>Field Mapping</h4>";
				echo "<ol>";
				
				echo "<li><label for='mapping_Old_Salesman'>Old Salesman Text:</label><br><select name='mapping_Old_Salesman'>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_New_Salesman'>New Salesman Initials:</label><br><select name='mapping_New_Salesman'>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				
				echo "</ol>";
				
				echo "<input type='hidden' name='file_name' value='" . $_FILES["file"]["name"] . "'>";
				
				echo "<br>";
				echo "<input type='submit' value='Submit'>";
				echo "</form>";

				}//if the file opened
			
		}
	}
	else
	{
		echo "The file was not an allowed extension!<br>";
	}
}
else
{
	echo "You must upload a file!<br>";
}
?>

</html>