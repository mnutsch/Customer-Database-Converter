<?php

function get_left_5($value)
{
	@$new_string = $value[0] . $value[1] . $value[2] . $value[3] . $value[4];
	$value = $new_string;
	return $value;
}

function make_upper_case($value)
{
	$value = strtoupper($value);
	return $value;
}

//create connection
//$con=mysqli_connect("localhost","username","password"); //without DB
$con=mysqli_connect("localhost","username","password","acquisition"); //with DB

//check connection
if(mysqli_connect_errno())
{
	echo "Failed to connect to the database!" . mysqli_connect_error();
}
else
{
	echo "Connected!";
}

//create database
/*
$sql="CREATE DATABASE acquisition";
if(mysqli_query($con,$sql))
{
	echo "Database acquisition was successfully created!";
}
else
{
	echo "Error creating database " . mysqli_error($con);
}
*/

//create Conversions table - to store template info
/*
$sql="CREATE TABLE Conversions
(
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
Conversion_Name CHAR(32),
D_Acquisition_Customer_Number CHAR(32),
D_FEI_Load_Acct CHAR(32),
D_Hide_Cust CHAR(32),
D_Customer_Alpha_Key CHAR(32),
D_Customer_Name CHAR(32),
D_Addr_1 CHAR(32),
D_Addr_2 CHAR(32),
D_Addr_3 CHAR(32),
D_City CHAR(32),
D_State CHAR(32),
D_Zip CHAR(32),
D_Country CHAR(32),
D_Credit_Manager CHAR(32),
D_Phone CHAR(32),
D_Fax CHAR(32),
D_Credit_Limit CHAR(32),
D_Salesman_Initials CHAR(32),
D_Alt_Salesman_Initials CHAR(32),
D_Credit_Code CHAR(32),
D_Credit_Rating CHAR(32),
D_Job_YN CHAR(32),
D_Ship_Via CHAR(32),
D_Ship_Instr CHAR(32),
D_Ship_Instr2 CHAR(32),
D_Ship_Instr3 CHAR(32),
D_Ship_Instr4 CHAR(32),
D_Ship_Attn CHAR(32),
D_Ship_To_Phone CHAR(32),
D_Terms CHAR(32),
D_Tax_Jur CHAR(32),
D_Exempt_Num CHAR(32),
D_Sales_Contact CHAR(32),
D_Credit_Contact CHAR(32),
D_Service_Charge CHAR(32),
D_Branch CHAR(32),
D_Price_Col CHAR(32),
D_AR_GL_Num CHAR(32),
D_Job_Name_Req CHAR(32),
D_Cust_PO_Req CHAR(32),
D_Print_LD CHAR(32),
D_Print_Price CHAR(32),
D_Alpha_Sort CHAR(32),
D_Territory CHAR(32),
D_Corp_ID CHAR(32),
D_DUNS_Num CHAR(32),
D_Dont_Forget CHAR(32),
D_Status CHAR(32),
D_Delivery_Charge CHAR(32),
D_Accept_BO CHAR(32),
D_Min_Charge_Del CHAR(32),
D_Blind_Bill CHAR(32),
D_Sort_By_Loc CHAR(32),
D_Cutoff_Days CHAR(32),
D_Num_Of_Inv CHAR(32),
D_Cust_Type CHAR(32),
D_Personal_Guaranty CHAR(32),
D_Credit_Application CHAR(32),
D_Last_Financial_Statement CHAR(32),
D_Gross_Sales CHAR(32),
D_Net_Working_Capital CHAR(32),
D_Net_Worth CHAR(32),
D_Date_In_Business CHAR(32),
D_Last_DB_Report CHAR(32),
D_DB_Rating CHAR(32),
D_Credit_Region CHAR(32),
D_Controlling_Branch CHAR(32),
D_Reserve_Customer CHAR(32),
D_Print_EDI_Orders CHAR(32),
D_Cash_Receipts_Sort CHAR(32),
D_Ship_Complete CHAR(32),
D_Print_Zero_Invoices CHAR(32),
D_Print_Neg_Invoices CHAR(32),
D_Generate_Statement CHAR(32),
D_Generate_2nd_Statement CHAR(32),
D_Generate_Neg_Statement CHAR(32),
D_Generate_0_Amount_Statement CHAR(32),
D_Generate_No_Activity_Statement CHAR(32),
D_Credit_Score CHAR(32),
D_Affect_Demand CHAR(32),
D_Incentive_Effective_Date CHAR(32),
D_Incentive_Duration CHAR(32),
D_Claimback_Customer CHAR(32),
D_Generate_Invoices CHAR(32),
D_Generate_2nd_Invoices CHAR(32),
D_Statement_Seq CHAR(32),
D_Auto_Conf CHAR(32),
D_Associated_Info CHAR(32),
D_Labels CHAR(32),
D_Customer_Supplier_Num CHAR(32),
D_Customer_Prep_Day CHAR(32),
D_Review_Freight CHAR(32),
D_Customer_Ordered_By CHAR(32),
D_Use_Freight_Tables CHAR(32),
D_Ext_Price_On_Ticket CHAR(32),
D_Master_Customer CHAR(32),
D_GSA_Pricing CHAR(32),
D_Enable_Level_3_CC_Reporting CHAR(32),
D_Audit_Required CHAR(32),
D_Verify_Checks CHAR(32),
D_Price_Roudning CHAR(32),
D_Nearest_Decimal CHAR(32),
D_Round_Minimum_Up CHAR(32),
D_Round_Contract_Price CHAR(32),
D_Show_Price CHAR(32),
D_Secondary_Salesman CHAR(32),
D_Percent_If_Secondary_Salesman CHAR(32),
M_Acquisition_Customer_Number CHAR(16),
M_FEI_Load_Acct CHAR(16),
M_Hide_Cust CHAR(16),
M_Customer_Alpha_Key CHAR(16),
M_Customer_Name CHAR(16),
M_Addr_1 CHAR(16),
M_Addr_2 CHAR(16),
M_Addr_3 CHAR(16),
M_City CHAR(16),
M_State CHAR(16),
M_Zip CHAR(16),
M_Country CHAR(16),
M_Credit_Manager CHAR(16),
M_Phone CHAR(16),
M_Fax CHAR(16),
M_Credit_Limit CHAR(16),
M_Salesman_Initials CHAR(16),
M_Alt_Salesman_Initials CHAR(16),
M_Credit_Code CHAR(16),
M_Credit_Rating CHAR(16),
M_Job_YN CHAR(16),
M_Ship_Via CHAR(16),
M_Ship_Instr CHAR(16),
M_Ship_Instr2 CHAR(16),
M_Ship_Instr3 CHAR(16),
M_Ship_Instr4 CHAR(16),
M_Ship_Attn CHAR(16),
M_Ship_To_Phone CHAR(16),
M_Terms CHAR(16),
M_Tax_Jur CHAR(16),
M_Exempt_Num CHAR(16),
M_Sales_Contact CHAR(16),
M_Credit_Contact CHAR(16),
M_Service_Charge CHAR(16),
M_Branch CHAR(16),
M_Price_Col CHAR(16),
M_AR_GL_Num CHAR(16),
M_Job_Name_Req CHAR(16),
M_Cust_PO_Req CHAR(16),
M_Print_LD CHAR(16),
M_Print_Price CHAR(16),
M_Alpha_Sort CHAR(16),
M_Territory CHAR(16),
M_Corp_ID CHAR(16),
M_DUNS_Num CHAR(16),
M_Dont_Forget CHAR(16),
M_Status CHAR(16),
M_Delivery_Charge CHAR(16),
M_Accept_BO CHAR(16),
M_Min_Charge_Del CHAR(16),
M_Blind_Bill CHAR(16),
M_Sort_By_Loc CHAR(16),
M_Cutoff_Days CHAR(16),
M_Num_Of_Inv CHAR(16),
M_Cust_Type CHAR(16),
M_Personal_Guaranty CHAR(16),
M_Credit_Application CHAR(16),
M_Last_Financial_Statement CHAR(16),
M_Gross_Sales CHAR(16),
M_Net_Working_Capital CHAR(16),
M_Net_Worth CHAR(16),
M_Date_In_Business CHAR(16),
M_Last_DB_Report CHAR(16),
M_DB_Rating CHAR(16),
M_Credit_Region CHAR(16),
M_Controlling_Branch CHAR(16),
M_Reserve_Customer CHAR(16),
M_Print_EDI_Orders CHAR(16),
M_Cash_Receipts_Sort CHAR(16),
M_Ship_Complete CHAR(16),
M_Print_Zero_Invoices CHAR(16),
M_Print_Neg_Invoices CHAR(16),
M_Generate_Statement CHAR(16),
M_Generate_2nd_Statement CHAR(16),
M_Generate_Neg_Statement CHAR(16),
M_Generate_0_Amount_Statement CHAR(16),
M_Generate_No_Activity_Statement CHAR(16),
M_Credit_Score CHAR(16),
M_Affect_Demand CHAR(16),
M_Incentive_Effective_Date CHAR(16),
M_Incentive_Duration CHAR(16),
M_Claimback_Customer CHAR(16),
M_Generate_Invoices CHAR(16),
M_Generate_2nd_Invoices CHAR(16),
M_Statement_Seq CHAR(16),
M_Auto_Conf CHAR(16),
M_Associated_Info CHAR(16),
M_Labels CHAR(16),
M_Customer_Supplier_Num CHAR(16),
M_Customer_Prep_Day CHAR(16),
M_Review_Freight CHAR(16),
M_Customer_Ordered_By CHAR(16),
M_Use_Freight_Tables CHAR(16),
M_Ext_Price_On_Ticket CHAR(16),
M_Master_Customer CHAR(16),
M_GSA_Pricing CHAR(16),
M_Enable_Level_3_CC_Reporting CHAR(16),
M_Audit_Required CHAR(16),
M_Verify_Checks CHAR(16),
M_Price_Roudning CHAR(16),
M_Nearest_Decimal CHAR(16),
M_Round_Minimum_Up CHAR(16),
M_Round_Contract_Price CHAR(16),
M_Show_Price CHAR(16),
M_Secondary_Salesman CHAR(16),
M_Percent_If_Secondary_Salesman CHAR(16)
)";
*/

//create table Customer_Lists - to store customer data converted
/*
$sql="CREATE TABLE Customer_Lists
(
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
Conversion_ID CHAR(16),
Date_Inserted CHAR(64),
Acquisition_Customer_Number CHAR(64),
FEI_Load_Acct CHAR(64),
Hide_Cust CHAR(64),
Customer_Alpha_Key CHAR(64),
Customer_Name CHAR(64),
Addr_1 CHAR(64),
Addr_2 CHAR(64),
Addr_3 CHAR(64),
City CHAR(64),
State CHAR(64),
Zip CHAR(64),
Country CHAR(64),
Credit_Manager CHAR(64),
Phone CHAR(64),
Fax CHAR(64),
Credit_Limit CHAR(64),
Salesman_Initials CHAR(64),
Alt_Salesman_Initials CHAR(64),
Credit_Code CHAR(64),
Credit_Rating CHAR(64),
Job_YN CHAR(64),
Ship_Via CHAR(64),
Ship_Instr CHAR(64),
Ship_Instr2 CHAR(64),
Ship_Instr3 CHAR(64),
Ship_Instr4 CHAR(64),
Ship_Attn CHAR(64),
Ship_To_Phone CHAR(64),
Terms CHAR(64),
Tax_Jur CHAR(64),
Exempt_Num CHAR(64),
Sales_Contact CHAR(64),
Credit_Contact CHAR(64),
Service_Charge CHAR(64),
Branch CHAR(64),
Price_Col CHAR(64),
AR_GL_Num CHAR(64),
Job_Name_Req CHAR(64),
Cust_PO_Req CHAR(64),
Print_LD CHAR(64),
Print_Price CHAR(64),
Alpha_Sort CHAR(64),
Territory CHAR(64),
Corp_ID CHAR(64),
DUNS_Num CHAR(64),
Dont_Forget CHAR(64),
Status CHAR(64),
Delivery_Charge CHAR(64),
Accept_BO CHAR(64),
Min_Charge_Del CHAR(64),
Blind_Bill CHAR(64),
Sort_By_Loc CHAR(64),
Cutoff_Days CHAR(64),
Num_Of_Inv CHAR(64),
Cust_Type CHAR(64),
Personal_Guaranty CHAR(64),
Credit_Application CHAR(64),
Last_Financial_Statement CHAR(64),
Gross_Sales CHAR(64),
Net_Working_Capital CHAR(64),
Net_Worth CHAR(64),
Date_In_Business CHAR(64),
Last_DB_Report CHAR(64),
DB_Rating CHAR(64),
Credit_Region CHAR(64),
Controlling_Branch CHAR(64),
Reserve_Customer CHAR(64),
Print_EDI_Orders CHAR(64),
Cash_Receipts_Sort CHAR(64),
Ship_Complete CHAR(64),
Print_Zero_Invoices CHAR(64),
Print_Neg_Invoices CHAR(64),
Generate_Statement CHAR(64),
Generate_2nd_Statement CHAR(64),
Generate_Neg_Statement CHAR(64),
Generate_0_Amount_Statement CHAR(64),
Generate_No_Activity_Statement CHAR(64),
Credit_Score CHAR(64),
Affect_Demand CHAR(64),
Incentive_Effective_Date CHAR(64),
Incentive_Duration CHAR(64),
Claimback_Customer CHAR(64),
Generate_Invoices CHAR(64),
Generate_2nd_Invoices CHAR(64),
Statement_Seq CHAR(64),
Auto_Conf CHAR(64),
Associated_Info CHAR(64),
Labels CHAR(64),
Customer_Supplier_Num CHAR(64),
Customer_Prep_Day CHAR(64),
Review_Freight CHAR(64),
Customer_Ordered_By CHAR(64),
Use_Freight_Tables CHAR(64),
Ext_Price_On_Ticket CHAR(64),
Master_Customer CHAR(64),
GSA_Pricing CHAR(64),
Enable_Level_3_CC_Reporting CHAR(64),
Audit_Required CHAR(64),
Verify_Checks CHAR(64),
Price_Roudning CHAR(64),
Nearest_Decimal CHAR(64),
Round_Minimum_Up CHAR(64),
Round_Contract_Price CHAR(64),
Show_Price CHAR(64),
Secondary_Salesman CHAR(64),
Percent_If_Secondary_Salesman CHAR(64)
)";
*/

//create table Common Names - to store a list of common first names
/*
$sql="CREATE TABLE Common_Names
(
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
Name CHAR(64)
)";
*/

//create table Tax_Jur - to store a list zip codes and maching tax jurisdication codes
/*
$sql="CREATE TABLE Tax_Jur
(
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
Zip_Code CHAR(32),
Tax_Jur CHAR(32)
)";
*/

//delete previous conversion customer list
/*
$conversion_id = 3;
$sql = "DELETE FROM customer_lists WHERE Conversion_ID = '" . $conversion_id . "'";
*/

//find out if a customer is in the customer list\
/*
$customer_number = "1";
$result = mysqli_query($con, "SELECT * FROM customer_lists WHERE Acquisition_Customer_Number = '" . $customer_number . "'");
	
while($row = mysqli_fetch_array($result))
{
	if($row['Acquisition_Customer_Number'] == $customer_number)
	{
		echo "This customer is already present in the customer list!";
	}
	else
	{
		echo "Add this customer to this database";
	}
}
*/

//find out if the first word of a string is a name
/*
$Customer_Name = "ferguson enterprises inc";
$arr = explode(" ",trim($Customer_Name));
$first_word_of_name = strtolower($arr[0]);
$name_in_list = 0;
$result = mysqli_query($con, "SELECT * FROM common_names WHERE Name = '" . $first_word_of_name . "'");
	
while($row = mysqli_fetch_array($result))
{
	if($row['Name'] == $first_word_of_name)
	{
		$name_in_list = 1;
	}
}

if($name_in_list == 1)
{
	echo "This word is a name";
	$array_length = sizeof($arr);
	$array_length = $array_length - 1;
	echo "The word length is " . $array_length . "<br>";
	$new_alpha = "";
	if($array_length > 0)
	{
		$new_alpha .= $arr[1] . $arr[0];
		
		if($array_length > 1)
		{
			$array_counter = 2;
			while($array_counter < ($array_length + 1))
			{
				$new_alpha .= $arr[$array_counter];
				$array_counter = $array_counter + 1;
			}
		}
	}
	else
	{
		$new_alpha .= $arr[0];
	}
	
	
}
else
{
	echo "This word is not a name";
	$new_alpha = $Customer_Name;
}
echo "the customer name was " . $Customer_Name . "<br>";
echo "the new alpha is " . $new_alpha . "<br>";
*/	

//look up tax code from database
/*
$default_tax_code = "WYE";
$zip_code = "54321";
$five_digit_zip = get_left_5($zip_code);
$result = mysqli_query($con, "SELECT * FROM tax_jur WHERE Zip_Code = '" . $five_digit_zip . "'");
$zip_present = 0;
$new_tax_code = "";
while($row = mysqli_fetch_array($result))
{
	if($row['Zip_Code'] == $five_digit_zip)
	{
		echo "This zip code is in the database";
		$zip_present = 1;
		$new_tax_code = $row['Tax_Jur'];
	}
	else
	{
		echo "This zip code is NOT in the database";
		$zip_present = 0;
	}
}
if($zip_present == 1)
{
	$tax_jur = $new_tax_code;
}
else
{
	$tax_jur = $default_tax_code;
}
echo "the new tax jur is " . $tax_jur . "<br>";
*/

/*
//create table Salesman - to store a list salesman initial mapping
$sql="CREATE TABLE Salesman_Mapping
(
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
Acquisition_ID Char(32),
Old_Salesman CHAR(32),
New_Salesman CHAR(32)
)";
*/

/*
//create table customer type - to store a list customer type mapping
$sql="CREATE TABLE Cust_Type_Mapping
(
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
Acquisition_ID Char(32),
Old_Type CHAR(32),
New_Type CHAR(32)
)";
*/

/*
//delete previous salesman mapping
$conversion_id = 3;
$sql = "DELETE FROM salesman_mapping WHERE Acquisition_ID = '" . $conversion_id . "'";
*/

/*
//create table customer type - to store zip codes
$sql="CREATE TABLE Zip_Codes
(
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
Zip_Code Char(32),
Latitude CHAR(32),
Longitude CHAR(32),
City CHAR(32),
State CHAR(32),
Zip CHAR(32),
Class CHAR(32)
)";
*/

/*
//execute query
if(mysqli_query($con,$sql))
{
	echo "SQL executed successfully!";
}
else
{
	echo "Error executing SQL.";
}
*/

/*
$word_array = explode(" ", "test");
//var_dump($word_array);
	
$array_length = count($word_array);

echo "The array length is " . $array_length;
*/

echo "<br>";

//validate the zip code
$default_zip = "98404";
$zip_code = "79424";

$number = $zip_code;
echo $number . "<br>";
$number = ltrim($number, '0');
echo $number . "<br>";

$zip_array = array();
$zip_array_count = 0;
$city = "LubbockC";
$city_upper = make_upper_case($city);
$state = "TX";					
$state_upper = make_upper_case($state);
$result = mysqli_query($con, "SELECT * FROM zip_codes WHERE City = '" . $city_upper . "' AND State = '" . $state_upper . "'");
$city_present = 0;
$new_type = "";
while($row = mysqli_fetch_array($result))
{
	//echo $row['Zip_Code'] . "<br>";
	$zip_array[$zip_array_count] = $row['Zip_Code'];
	$zip_array_count = $zip_array_count + 1;
}

if(sizeof($zip_array)>0)
{
	if (in_array($number, $zip_array))
	{
		echo "Zip is correct as is leaving as is<br>";
		//the zip is correct leave it as is
		$new_zip = $zip_code;
	}
	else
	{
		echo "City exists, but zip is wrong. Changing<br>";
		$new_zip = $zip_array[0];
		//use the first zip code found
	}
}
else
{
	if($zip_code == "")
	{
		echo "zip was blank and city doesn't exist. using the default zip<br>";
		$new_zip = $default_zip;
	}
	else
	{
		echo "city doesn't exist. leaving as it is<br>";
		$new_zip = $zip_code;
	}
	
}
echo "<br>";
echo $new_zip;

mysqli_close($con);
?>