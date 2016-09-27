<?php


function mres($value) //this function prevents the website from getting hacked through sql injection
{
	$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
	$replace = array("\\\\", "\\0", "\\n", "\\r", "", '', "\\Z");

	return str_replace($search, $replace, $value);
}

$error = 0;

$con=mysqli_connect("localhost","username","password","sentence_recognition_api"); //with DB

//check connection
if(mysqli_connect_errno())
{
	echo "Failed to connect to the database!" . mysqli_connect_error();
	$error = 1;
}
else
{
	echo "Connected!<br>";
}


if(isset($_POST['name']))
{
	echo "the name is " . mres($_POST['name']) . "<br><br>";
	$name = mres($_POST['name']);
	
	$new_key = md5(mres($_POST['name']));
	echo "the key is " . $new_key . "<br><br>";
}
else
{
	echo "name was not set" . "<br><br>";
	$error = 1;
}

if(isset($_POST['email_address']))
{
	echo "the email is " . mres($_POST['email_address']) . "<br><br>";
	$email_address = mres($_POST['email_address']);
}
else
{
	echo "email was not set" . "<br><br>";
	$error = 1;
}

if(isset($_POST['usage']))
{
	echo "the usage is " . mres($_POST['usage']) . "<br><br>";
	$usage = mres($_POST['usage']);
}
else
{
	echo "usage was not set" . "<br><br>";
	$error = 1;
}

if($error == 0)
{
	echo "There are no errors<br><br>";
	echo "test";
	//insert into the database
	$sql="INSERT INTO api_keys (api_key, daily_limit, name, email, usage, Times_Called_Today, Times_Called_Ever, unsubscribe) VALUES ('$new_key', '999999', '$name', '$email_address', '$usage', '0', '0', 'N')";					

	echo "The sql string is " . $sql . "<br>";
/*
	//execute query
	if(mysqli_query($con,$sql))
	{
		//echo "SQL command was successful!";
	}
	else
	{
		echo "Error with SQL command: " . mysqli_error($con);
		//$status = "failure";
	}
									
	//$result = mysql_query($sql,$con);
	echo "ID of last inserted record is: " . mysql_insert_id();
	
	*/
	//disconnect from database
	mysqli_close($con);
		
		//e-mail confirmation - add data and dynamic link
		
		require_once('class.phpmailer.php');

		$to = 'mattnutsch@gmail.com'; //for debug
		//$to = $_POST['contactemailaddress']; //for live use
		$from = 'mattnutsch@gmail.com';
		$from_name = 'mattnutsch@gmail.com';
		$subject = 'SentenceRecognition.com API Key';
		$body = 'name: ' . $name . '<br>key: ' . $new_key . '<br>email: ' . $email_address . '<br>usage: ' . $usage;


			$mail = new PHPMailer();  // create a new object


			$mail->IsSMTP(); // enable SMTP
			//$mail->Host = 'mail.vitruvo.net';
			$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
			$mail->SMTPAuth = true;  // authentication enabled
			$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 465;
			$mail->Username = 'mnwebsitemailer@gmail.com';  
			$mail->Password = 'jurassic23!';      
			$mail->From = 'mnwebsitemailer@gmail.com';
			$mail->FromName = 'contact@SentenceRecognition.com';    
			$mail->AddReplyTo($from, $from_name);
			$mail->Subject = $subject;
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			$mail->Body = $body;
			$mail->AddAddress($to);

			if(!$mail->Send())
			{
			   //echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
			else
			{
			   //echo 'Message has been sent';
			}
		
	

	
}
//header('Location: http://www.mattnutsch.com/development/collection');
//exit;

?>
