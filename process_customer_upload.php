<html>
<head>
<title>Acquisition Customer File Automation</title>
</head>
<body>
<h2>Template Creation Status</h2>
<?php

function mres($value) //this function prevents the website from getting hacked through sql injection
{
	$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
	$replace = array("\\\\", "\\0", "\\n", "\\r", "", '', "\\Z");

	return str_replace($search, $replace, $value);
}

function remove_spaces($value)
{
	$value = str_replace(" ", "", $value);
	return $value;
}

function remove_commas($value)
{
	$value = str_replace(",", "", $value);
	return $value;
}

function remove_semi_colon($value)
{
	$value = str_replace(";", "", $value);
	return $value;
}

function convert_timestamp($value)
{
	$value = str_replace(" ", "_", $value);
	$value = str_replace(":", "-", $value);
	return $value;
}

function remove_non_alpha_numeric($value)
{
	$value = preg_replace("/[^A-Za-z0-9 ]/", '', $value);
	return $value;
}

function remove_non_numeric($value)
{
	$value = preg_replace("/[^0-9 ]/", '', $value);
	return $value;
}

function make_upper_case($value)
{
	$value = strtoupper($value);
	return $value;
}

function get_left_2($value)
{
	@$new_string = $value[0] . $value[1];
	$value = $new_string;
	return $value;
}

function get_left_5($value)
{
	@$new_string = $value[0] . $value[1] . $value[2] . $value[3] . $value[4];
	$value = $new_string;
	return $value;
}

function get_left_10($value)
{
	@$new_string = $value[0] . $value[1] . $value[2] . $value[3] . $value[4] . $value[5] . $value[6] . $value[7] . $value[8] . $value[9];
	$value = $new_string;
	return $value;
}


function remove_leading_1($value)
{
	$new_string = "";
	$value_length = strlen($value);
	
	for($c=0;$c < $value_length; $c++)
	{
		if($c==0)
		{
			if($value[$c]=="1")
			{
				//do nothing
			}
			else
			{
				$new_string = $new_string . $value[$c];
			}
		}
		else
		{
			$new_string = $new_string . $value[$c];
		}
	}
	$value=$new_string;
	return $value;
}

function round_to_0($value)
{
	$string_array = explode(".", $value);
	$value = $string_array[0];
	return $value;
}

function round_to_nearest_hundred_up($value)
{
	return ceil($value / 100) * 100;
}

function add_leading_0($value)
{
	$new_string = "";
	$value_length = strlen($value);
	
	if($value_length == 1)
	{
		$new_string = "0" . $value;
	}
	
	$value = $new_string;
	return $value;
}


ini_set('max_execution_time', 6000); //keep the page from timing output_add_rewrite_var

@$today = date("Y-m-d H:i:s");
echo "The timestamp is " . $today . "<br><br>";

if(isset($_POST["conversion_id"]))
{
	$conversion_id = mres($_POST["conversion_id"]);
}
else
{
	$conversion_id = "";
}

//Define Variables
$allowedExts = array("csv", "txt");
$Text_To_Write = "";
$Text_To_Log = "";
//DEV NOTE: EDIT THIS TO check the order
$Text_To_Write = "ACQ MASTER ID (UNIQUECUSTID) [COLUMN C KNVP],";
$Text_To_Write .= "FEI LOAD ACCT # (POST LOAD CROSS REF),";
$Text_To_Write .= "ACQ CUST #,";
$Text_To_Write .= "ACQ ADDITIONAL ID NUMBER OR CROSS TO FEI ACCOUNT NUMBER,";
$Text_To_Write .= "HIDE CUST,";
$Text_To_Write .= "CUSTOMER ALPHA,";
$Text_To_Write .= "CUSTOMER NAME (BILLING ADDRESS),";
$Text_To_Write .= "ADDR 1 (JOB NAME OR ADDRESS),";
$Text_To_Write .= "ADDR 2(BILLING ADDR),";
$Text_To_Write .= "ADDR 3 (BILLING ADDR),";
$Text_To_Write .= "CITY (SHIPPING ADDR),";
$Text_To_Write .= "STATE (SHIPPING ADDR),";
$Text_To_Write .= "ZIP (SHIPPING ADDR),";
$Text_To_Write .= "COUNTRY,";
$Text_To_Write .= "CREDIT MANAGER,";
$Text_To_Write .= "PHONE,";
$Text_To_Write .= "FAX,";
$Text_To_Write .= "Credit_Limit,";
$Text_To_Write .= "Salesman_Initials,";
$Text_To_Write .= "Alt_Salesman_Initials,";
$Text_To_Write .= "Credit_Code,";
$Text_To_Write .= "Credit_Rating,";
$Text_To_Write .= "Job_YN,";
$Text_To_Write .= "Ship_Via,";
$Text_To_Write .= "Ship_Instr,";
$Text_To_Write .= "Ship_Instr2,";
$Text_To_Write .= "Ship_Instr3,";
$Text_To_Write .= "Ship_Instr4,";
$Text_To_Write .= "Ship_Attn,";
$Text_To_Write .= "Ship_To_Phone,";
$Text_To_Write .= "Terms,";
$Text_To_Write .= "Tax_Jur,";
$Text_To_Write .= "Exempt_Num,";
$Text_To_Write .= "Sales_Contact,";
$Text_To_Write .= "Credit_Contact,";
$Text_To_Write .= "Service_Charge,";
$Text_To_Write .= "Branch,";
$Text_To_Write .= "Price_Col,";
$Text_To_Write .= "AR_GL_Num,";
$Text_To_Write .= "Job_Name_Req,";
$Text_To_Write .= "Cust_PO_Req,";
$Text_To_Write .= "Print_LD,";
$Text_To_Write .= "Print_Price,";
$Text_To_Write .= "Alpha_Sort,";
$Text_To_Write .= "Territory,";
$Text_To_Write .= "Corp_ID,";
$Text_To_Write .= "DUNS_Num,";
$Text_To_Write .= "Dont_Forget,";
$Text_To_Write .= "Status,";
$Text_To_Write .= "Delivery_Charge,";
$Text_To_Write .= "Accept_BO,";
$Text_To_Write .= "Min_Charge_Del,";
$Text_To_Write .= "Blind_Bill,";
$Text_To_Write .= "Sort_By_Loc,";
$Text_To_Write .= "Cutoff_Days,";
$Text_To_Write .= "Num_Of_Inv,";
$Text_To_Write .= "Cust_Type,";
$Text_To_Write .= "Personal_Guaranty,";
$Text_To_Write .= "Credit_Application,";
$Text_To_Write .= "Last_Financial_Statement,";
$Text_To_Write .= "Gross_Sales,";
$Text_To_Write .= "Net_Working_Capital,";
$Text_To_Write .= "Net_Worth,";
$Text_To_Write .= "Date_In_Business,";
$Text_To_Write .= "Last_DB_Report,";
$Text_To_Write .= "DB_Rating,";
$Text_To_Write .= "Credit_Region,";
$Text_To_Write .= "Controlling_Branch,";
$Text_To_Write .= "Reserve_Customer,";
$Text_To_Write .= "Print_EDI_Orders,";
$Text_To_Write .= "Cash_Receipts_Sort,";
$Text_To_Write .= "Ship_Complete,";
$Text_To_Write .= "Print_Zero_Invoices,";
$Text_To_Write .= "Print_Neg_Invoices,";
$Text_To_Write .= "Generate_Statement,";
$Text_To_Write .= "Generate_2nd_Statement,";
$Text_To_Write .= "Generate_Neg_Statement,";
$Text_To_Write .= "Generate_0_Amount_Statement,";
$Text_To_Write .= "Generate_No_Activity_Statement,";
$Text_To_Write .= "Credit_Score,";
$Text_To_Write .= "Affect_Demand,";
$Text_To_Write .= "Incentive_Effective_Date,";
$Text_To_Write .= "Incentive_Duration,";
$Text_To_Write .= "Claimback_Customer,";
$Text_To_Write .= "Generate_Invoices,";
$Text_To_Write .= "Generate_2nd_Invoices,";
$Text_To_Write .= "Statement_Seq,";
$Text_To_Write .= "Auto_Conf,";
$Text_To_Write .= "Associated_Info,";
$Text_To_Write .= "Labels,";
$Text_To_Write .= "Customer_Supplier_Num,";
$Text_To_Write .= "Customer_Prep_Day,";
$Text_To_Write .= "Review_Freight,";
$Text_To_Write .= "Customer_Ordered_By,";
$Text_To_Write .= "Use_Freight_Tables,";
$Text_To_Write .= "Ext_Price_On_Ticket,";
$Text_To_Write .= "Master_Customer,";
$Text_To_Write .= "GSA_Pricing,";
$Text_To_Write .= "Enable_Level_3_CC_Reporting,";
$Text_To_Write .= "Audit_Required,";
$Text_To_Write .= "Verify_Checks,";
$Text_To_Write .= "Price_Roudning,";
$Text_To_Write .= "Nearest_Decimal,";
$Text_To_Write .= "Round_Minimum_Up,";
$Text_To_Write .= "Round_Contract_Price,";
$Text_To_Write .= "Show_Price,";

$Text_To_Write .= "Material Detail,";
$Text_To_Write .= "Fab Detail,";
$Text_To_Write .= "Material Line Item $,";
$Text_To_Write .= "Material Ext Line Item $,";
$Text_To_Write .= "Fab Line Item $,";
$Text_To_Write .= "Fab Ext Line Item $,";
$Text_To_Write .= "Material Total $ Sum Line,";
$Text_To_Write .= "Fab Total $ Sum Line,";
$Text_To_Write .= "Material Detail,";
$Text_To_Write .= "Fab Detail,";
$Text_To_Write .= "Material Line Item $,";
$Text_To_Write .= "Material Ext Line Item $,";
$Text_To_Write .= "Fab Line Item $,";
$Text_To_Write .= "Fab Ext Line Item $,";
$Text_To_Write .= "Material Total $ Sum Line,";
$Text_To_Write .= "Fab Total $ Sum Line,";

$Text_To_Write .= "Secondary_Salesman,";
$Text_To_Write .= "Percent_If_Secondary_Salesman,";

$Text_To_Write .= "Reserved for future main attributes,";
$Text_To_Write .= "Reserved for future main attributes,";
$Text_To_Write .= "Reserved for future main attributes,";
$Text_To_Write .= "Reserved for future main attributes,";
$Text_To_Write .= "Reserved for future main attributes,";
$Text_To_Write .= "Reserved for future main attributes";

$Text_To_Write .= PHP_EOL;

//Define the Target Variables From the Template
$Acquisition_Customer_Number = ""; //ACQ Master ID, Main ACQ Cust #
$FEI_Load_Acct = "";
$Hide_Cust = "";
$Customer_Alpha_Key = "";
$Customer_Name = "";
$Addr_1 = "";
$Addr_2 = "";
$Addr_3 = "";
$City = "";
$State = "";
$Zip = "";
$Country = "";
$Credit_Manager = "";
$Phone = "";
$Fax = "";
$Credit_Limit = ""; //round to 100's, no decimals or commas
$Salesman_Initials = ""; //i.e. AAA
$Alt_Salesman_Initials = ""; //i.e. AAA
$Credit_Code = ""; //i.e. X, COD, AROL
$Credit_Rating = ""; //i.e. CCC
$Job_YN = ""; //i.e. Y or N
$Ship_Via = ""; //leave blank
$Ship_Instr = ""; //leave blank
$Ship_Instr2 = ""; //leave blank
$Ship_Instr3 = ""; //leave blank
$Ship_Instr4 = ""; //leave blank
$Ship_Attn = ""; //leave blank
$Ship_To_Phone = ""; //leave blank
$Terms = ""; //i.e. COD or N10
$Tax_Jur = "";
$Exempt_Num = "";
$Sales_Contact = "";
$Credit_Contact = "";
$Service_Charge = "";
$Branch = "";
$Price_Col = "";
$AR_GL_Num = ""; //always 1300
$Job_Name_Req = ""; //Y or N
$Cust_PO_Req = ""; //Y or N
$Print_LD = ""; //Y or N
$Print_Price = ""; //Y or N
$Alpha_Sort = ""; //Customer Name with spaces and non alphanumeric characters removed
$Territory = ""; //i.e. ACQ-KARLS
$Corp_ID = "";
$DUNS_Num = ""; //always blank
$Dont_Forget = "";
$Status = ""; //A for N10 or T for COD
$Delivery_Charge = "";
$Accept_BO = "";//Y or N
$Min_Charge_Del = "";
$Blind_Bill = "";
$Sort_By_Loc = "";
$Cutoff_Days = ""; //i.e. 25
$Num_Of_Inv = ""; //COD = 0, N10 = 100
$Cust_Type = ""; //i.e. T_MISCRTL
$Personal_Guaranty = ""; //Y or N
$Credit_Application = ""; //Y or N
$Last_Financial_Statement = ""; 
$Gross_Sales = "";
$Net_Working_Capital = "";
$Net_Worth = "";
$Date_In_Business ="";
$Last_DB_Report ="";
$DB_Rating = "";
$Credit_Region = ""; //must be 2 digits
$Controlling_Branch = "";
$Reserve_Customer = ""; //Y or N
$Print_EDI_Orders = ""; //Y or N
$Cash_Receipts_Sort = ""; //always JD
$Ship_Complete = ""; //Y or N
$Print_Zero_Invoices = ""; //Y or N
$Print_Neg_Invoices = ""; //Y or N
$Generate_Statement = ""; //P, F, M, or blank
$Generate_2nd_Statement = ""; //P, F, M, or blank
$Generate_Neg_Statement = ""; //Y or N
$Generate_0_Amount_Statement = ""; //Y or N
$Generate_No_Activity_Statement = ""; //Y or N
$Credit_Score = "";
$Affect_Demand = "";
$Incentive_Effective_Date = "";
$Incentive_Duration = "";
$Claimback_Customer = ""; 
$Generate_Invoices = ""; //P, F, M, or blank
$Generate_2nd_Invoices = ""; //P, F, M, or blank
$Statement_Seq = "";
$Auto_Conf = "";
$Associated_Info = "";
$Labels = ""; //Y or N
$Customer_Supplier_Num = "";
$Customer_Prep_Day = "";
$Review_Freight = ""; //Y or N
$Customer_Ordered_By = "";
$Use_Freight_Tables = "";
$Ext_Price_On_Ticket = "";
$Master_Customer = "";
$GSA_Pricing = "";
$Enable_Level_3_CC_Reporting = ""; //Y or N
$Audit_Required = "";
$Verify_Checks = ""; //Y or N
$Price_Roudning = "";
$Nearest_Decimal = "";
$Round_Minimum_Up = "";
$Round_Contract_Price = "";
$Show_Price = ""; //Y or N
$Secondary_Salesman = ""; //3 digit initials
$Percent_If_Secondary_Salesman = "";

//Set default values for fields - DEV NOTE: change this to read from the database once 
if($conversion_id != "")
{
	$con=mysqli_connect("localhost","username,"password","acquisition"); //with DB

	//check connection
	if(mysqli_connect_errno())
	{
		echo "ERROR: Failed to connect to the database!" . mysqli_connect_error();
	}
	else
	{
		//echo "Connected!";

		//delete this conversion's items in the customer_lists table
		$sql = "DELETE FROM customer_lists WHERE Conversion_ID = '" . $conversion_id . "'";
		
		//execute query
		if(mysqli_query($con,$sql))
		{
			echo "Deleted any old data for this conversion!<br>";
		}
		else
		{
			echo "Error: Couldn't deleted old data for this conversion.<br>";
		}
	
		//get the conversion template settings info from the database
		$result = mysqli_query($con, "SELECT * FROM conversions");
	
		while($row = mysqli_fetch_array($result))
		{
			if($row['PID'] == $conversion_id)
			{
				echo "The Conversion Template was found in the DB<br>";
				
				$Default_Acquisition_Customer_Number = $row['D_Acquisition_Customer_Number'];
				$Default_FEI_Load_Acct = $row['D_FEI_Load_Acct'];
				$Default_Hide_Cust = $row['D_Hide_Cust'];
				$Default_Customer_Alpha_Key = $row['D_Customer_Alpha_Key'];
				$Default_Customer_Name = $row['D_Customer_Name'];
				$Default_Addr_1 = $row['D_Addr_1'];
				$Default_Addr_2 = $row['D_Addr_2'];
				$Default_Addr_3 = $row['D_Addr_3'];
				$Default_City = $row['D_City'];
				$Default_State = $row['D_State'];
				$Default_Zip = $row['D_Zip'];
				$Default_Country = $row['D_Country'];
				$Default_Credit_Manager = $row['D_Credit_Manager'];
				$Default_Phone = $row['D_Phone'];
				$Default_Fax = $row['D_Fax'];
				$Default_Credit_Limit = $row['D_Credit_Limit'];
				$Default_Salesman_Initials = $row['D_Salesman_Initials'];
				$Default_Alt_Salesman_Initials = $row['D_Alt_Salesman_Initials'];
				$Default_Credit_Code = $row['D_Credit_Code'];
				$Default_Credit_Rating = $row['D_Credit_Rating'];
				$Default_Job_YN = $row['D_Job_YN'];
				$Default_Ship_Via = $row['D_Ship_Via'];
				$Default_Ship_Instr = $row['D_Ship_Instr'];
				$Default_Ship_Instr2 = $row['D_Ship_Instr2'];
				$Default_Ship_Instr3 = $row['D_Ship_Instr3'];
				$Default_Ship_Instr4 = $row['D_Ship_Instr4'];
				$Default_Ship_Attn = $row['D_Ship_Attn'];
				$Default_Ship_To_Phone = $row['D_Ship_To_Phone'];
				$Default_Terms = $row['D_Terms'];
				$Default_Tax_Jur = $row['D_Tax_Jur'];
				$Default_Exempt_Num = $row['D_Exempt_Num'];
				$Default_Sales_Contact = $row['D_Sales_Contact'];
				$Default_Credit_Contact = $row['D_Credit_Contact'];
				$Default_Service_Charge = $row['D_Service_Charge'];
				$Default_Branch = $row['D_Branch'];
				$Default_Price_Col = $row['D_Price_Col'];
				$Default_AR_GL_Num = $row['D_AR_GL_Num'];
				$Default_Job_Name_Req = $row['D_Job_Name_Req'];
				$Default_Cust_PO_Req = $row['D_Cust_PO_Req'];
				$Default_Print_LD = $row['D_Print_LD'];
				$Default_Print_Price = $row['D_Print_Price'];
				$Default_Alpha_Sort = $row['D_Alpha_Sort'];
				$Default_Territory = $row['D_Territory'];
				$Default_Corp_ID = $row['D_Corp_ID'];
				$Default_DUNS_Num = $row['D_DUNS_Num'];
				$Default_Dont_Forget = $row['D_Dont_Forget'];
				$Default_Status = $row['D_Status'];
				$Default_Delivery_Charge = $row['D_Delivery_Charge'];
				$Default_Accept_BO = $row['D_Accept_BO'];
				$Default_Min_Charge_Del = $row['D_Min_Charge_Del'];
				$Default_Blind_Bill = $row['D_Blind_Bill'];
				$Default_Sort_By_Loc = $row['D_Sort_By_Loc'];
				$Default_Cutoff_Days = $row['D_Cutoff_Days'];
				$Default_Num_Of_Inv = $row['D_Num_Of_Inv'];
				$Default_Cust_Type = $row['D_Cust_Type'];
				$Default_Personal_Guaranty = $row['D_Personal_Guaranty'];
				$Default_Credit_Application = $row['D_Credit_Application'];
				$Default_Last_Financial_Statement = $row['D_Last_Financial_Statement'];
				$Default_Gross_Sales = $row['D_Gross_Sales'];
				$Default_Net_Working_Capital = $row['D_Net_Working_Capital'];
				$Default_Net_Worth = $row['D_Net_Worth'];
				$Default_Date_In_Business = $row['D_Date_In_Business'];
				$Default_Last_DB_Report = $row['D_Last_DB_Report'];
				$Default_DB_Rating = $row['D_DB_Rating'];
				$Default_Credit_Region = $row['D_Credit_Region'];
				$Default_Controlling_Branch = $row['D_Controlling_Branch'];
				$Default_Reserve_Customer = $row['D_Reserve_Customer'];
				$Default_Print_EDI_Orders = $row['D_Print_EDI_Orders'];
				$Default_Cash_Receipts_Sort = $row['D_Cash_Receipts_Sort'];
				$Default_Ship_Complete = $row['D_Ship_Complete'];
				$Default_Print_Zero_Invoices = $row['D_Print_Zero_Invoices'];
				$Default_Print_Neg_Invoices = $row['D_Print_Neg_Invoices'];
				$Default_Generate_Statement = $row['D_Generate_Statement'];
				$Default_Generate_2nd_Statement = $row['D_Generate_2nd_Statement'];
				$Default_Generate_Neg_Statement = $row['D_Generate_Neg_Statement'];
				$Default_Generate_0_Amount_Statement = $row['D_Generate_0_Amount_Statement'];
				$Default_Generate_No_Activity_Statement = $row['D_Generate_No_Activity_Statement'];
				$Default_Credit_Score = $row['D_Credit_Score'];
				$Default_Affect_Demand = $row['D_Affect_Demand'];
				$Default_Incentive_Effective_Date = $row['D_Incentive_Effective_Date'];
				$Default_Incentive_Duration = $row['D_Incentive_Duration'];
				$Default_Claimback_Customer = $row['D_Claimback_Customer'];
				$Default_Generate_Invoices = $row['D_Generate_Invoices'];
				$Default_Generate_2nd_Invoices = $row['D_Generate_2nd_Invoices'];
				$Default_Statement_Seq = $row['D_Statement_Seq'];
				$Default_Auto_Conf = $row['D_Auto_Conf'];
				$Default_Associated_Info = $row['D_Associated_Info'];
				$Default_Labels = $row['D_Labels'];
				$Default_Customer_Supplier_Num = $row['D_Customer_Supplier_Num'];
				$Default_Customer_Prep_Day = $row['D_Customer_Prep_Day'];
				$Default_Review_Freight = $row['D_Review_Freight'];
				$Default_Customer_Ordered_By = $row['D_Customer_Ordered_By'];
				$Default_Use_Freight_Tables = $row['D_Use_Freight_Tables'];
				$Default_Ext_Price_On_Ticket = $row['D_Ext_Price_On_Ticket'];
				$Default_Master_Customer = $row['D_Master_Customer'];
				$Default_GSA_Pricing = $row['D_GSA_Pricing'];
				$Default_Enable_Level_3_CC_Reporting = $row['D_Enable_Level_3_CC_Reporting'];
				$Default_Audit_Required = $row['D_Audit_Required'];
				$Default_Verify_Checks = $row['D_Verify_Checks'];
				$Default_Price_Roudning = $row['D_Price_Roudning'];
				$Default_Nearest_Decimal = $row['D_Nearest_Decimal'];
				$Default_Round_Minimum_Up = $row['D_Round_Minimum_Up'];
				$Default_Round_Contract_Price = $row['D_Round_Contract_Price'];
				$Default_Show_Price = $row['D_Show_Price'];
				$Default_Secondary_Salesman = $row['D_Secondary_Salesman'];
				$Default_Percent_If_Secondary_Salesman = $row['D_Percent_If_Secondary_Salesman'];

				$Mapping_Acquisition_Customer_Number = $row['M_Acquisition_Customer_Number'];
				$Mapping_FEI_Load_Acct = $row['M_FEI_Load_Acct'];
				$Mapping_Hide_Cust = $row['M_Hide_Cust'];
				$Mapping_Customer_Alpha_Key = $row['M_Customer_Alpha_Key'];
				$Mapping_Customer_Name = $row['M_Customer_Name'];
				$Mapping_Addr_1 = $row['M_Addr_1'];
				$Mapping_Addr_2 = $row['M_Addr_2'];
				$Mapping_Addr_3 = $row['M_Addr_3'];
				$Mapping_City = $row['M_City'];
				$Mapping_State = $row['M_State'];
				$Mapping_Zip = $row['M_Zip'];
				$Mapping_Country = $row['M_Country'];
				$Mapping_Credit_Manager = $row['M_Credit_Manager'];
				$Mapping_Phone = $row['M_Phone'];
				$Mapping_Fax = $row['M_Fax'];
				$Mapping_Credit_Limit = $row['M_Credit_Limit'];
				$Mapping_Salesman_Initials = $row['M_Salesman_Initials'];
				$Mapping_Alt_Salesman_Initials = $row['M_Alt_Salesman_Initials'];
				$Mapping_Credit_Code = $row['M_Credit_Code'];
				$Mapping_Credit_Rating = $row['M_Credit_Rating'];
				$Mapping_Job_YN = $row['M_Job_YN'];
				$Mapping_Ship_Via = $row['M_Ship_Via'];
				$Mapping_Ship_Instr = $row['M_Ship_Instr'];
				$Mapping_Ship_Instr2 = $row['M_Ship_Instr2'];
				$Mapping_Ship_Instr3 = $row['M_Ship_Instr3'];
				$Mapping_Ship_Instr4 = $row['M_Ship_Instr4'];
				$Mapping_Ship_Attn = $row['M_Ship_Attn'];
				$Mapping_Ship_To_Phone = $row['M_Ship_To_Phone'];
				$Mapping_Terms = $row['M_Terms'];
				$Mapping_Tax_Jur = $row['M_Tax_Jur'];
				$Mapping_Exempt_Num = $row['M_Exempt_Num'];
				$Mapping_Sales_Contact = $row['M_Sales_Contact'];
				$Mapping_Credit_Contact = $row['M_Credit_Contact'];
				$Mapping_Service_Charge = $row['M_Service_Charge'];
				$Mapping_Branch = $row['M_Branch'];
				$Mapping_Price_Col = $row['M_Price_Col'];
				$Mapping_AR_GL_Num = $row['M_AR_GL_Num'];
				$Mapping_Job_Name_Req = $row['M_Job_Name_Req'];
				$Mapping_Cust_PO_Req = $row['M_Cust_PO_Req'];
				$Mapping_Print_LD = $row['M_Print_LD'];
				$Mapping_Print_Price = $row['M_Print_Price'];
				$Mapping_Alpha_Sort = $row['M_Alpha_Sort'];
				$Mapping_Territory = $row['M_Territory'];
				$Mapping_Corp_ID = $row['M_Corp_ID'];
				$Mapping_DUNS_Num = $row['M_DUNS_Num'];
				$Mapping_Dont_Forget = $row['M_Dont_Forget'];
				$Mapping_Status = $row['M_Status'];
				$Mapping_Delivery_Charge = $row['M_Delivery_Charge'];
				$Mapping_Accept_BO = $row['M_Accept_BO'];
				$Mapping_Min_Charge_Del = $row['M_Min_Charge_Del'];
				$Mapping_Blind_Bill = $row['M_Blind_Bill'];
				$Mapping_Sort_By_Loc = $row['M_Sort_By_Loc'];
				$Mapping_Cutoff_Days = $row['M_Cutoff_Days'];
				$Mapping_Num_Of_Inv = $row['M_Num_Of_Inv'];
				$Mapping_Cust_Type = $row['M_Cust_Type'];
				$Mapping_Personal_Guaranty = $row['M_Personal_Guaranty'];
				$Mapping_Credit_Application = $row['M_Credit_Application'];
				$Mapping_Last_Financial_Statement = $row['M_Last_Financial_Statement'];
				$Mapping_Gross_Sales = $row['M_Gross_Sales'];
				$Mapping_Net_Working_Capital = $row['M_Net_Working_Capital'];
				$Mapping_Net_Worth = $row['M_Net_Worth'];
				$Mapping_Date_In_Business = $row['M_Date_In_Business'];
				$Mapping_Last_DB_Report = $row['M_Last_DB_Report'];
				$Mapping_DB_Rating = $row['M_DB_Rating'];
				$Mapping_Credit_Region = $row['M_Credit_Region'];
				$Mapping_Controlling_Branch = $row['M_Controlling_Branch'];
				$Mapping_Reserve_Customer = $row['M_Reserve_Customer'];
				$Mapping_Print_EDI_Orders = $row['M_Print_EDI_Orders'];
				$Mapping_Cash_Receipts_Sort = $row['M_Cash_Receipts_Sort'];
				$Mapping_Ship_Complete = $row['M_Ship_Complete'];
				$Mapping_Print_Zero_Invoices = $row['M_Print_Zero_Invoices'];
				$Mapping_Print_Neg_Invoices = $row['M_Print_Neg_Invoices'];
				$Mapping_Generate_Statement = $row['M_Generate_Statement'];
				$Mapping_Generate_2nd_Statement = $row['M_Generate_2nd_Statement'];
				$Mapping_Generate_Neg_Statement = $row['M_Generate_Neg_Statement'];
				$Mapping_Generate_0_Amount_Statement = $row['M_Generate_0_Amount_Statement'];
				$Mapping_Generate_No_Activity_Statement = $row['M_Generate_No_Activity_Statement'];
				$Mapping_Credit_Score = $row['M_Credit_Score'];
				$Mapping_Affect_Demand = $row['M_Affect_Demand'];
				$Mapping_Incentive_Effective_Date = $row['M_Incentive_Effective_Date'];
				$Mapping_Incentive_Duration = $row['M_Incentive_Duration'];
				$Mapping_Claimback_Customer = $row['M_Claimback_Customer'];
				$Mapping_Generate_Invoices = $row['M_Generate_Invoices'];
				$Mapping_Generate_2nd_Invoices = $row['M_Generate_2nd_Invoices'];
				$Mapping_Statement_Seq = $row['M_Statement_Seq'];
				$Mapping_Auto_Conf = $row['M_Auto_Conf'];
				$Mapping_Associated_Info = $row['M_Associated_Info'];
				$Mapping_Labels = $row['M_Labels'];
				$Mapping_Customer_Supplier_Num = $row['M_Customer_Supplier_Num'];
				$Mapping_Customer_Prep_Day = $row['M_Customer_Prep_Day'];
				$Mapping_Review_Freight = $row['M_Review_Freight'];
				$Mapping_Customer_Ordered_By = $row['M_Customer_Ordered_By'];
				$Mapping_Use_Freight_Tables = $row['M_Use_Freight_Tables'];
				$Mapping_Ext_Price_On_Ticket = $row['M_Ext_Price_On_Ticket'];
				$Mapping_Master_Customer = $row['M_Master_Customer'];
				$Mapping_GSA_Pricing = $row['M_GSA_Pricing'];
				$Mapping_Enable_Level_3_CC_Reporting = $row['M_Enable_Level_3_CC_Reporting'];
				$Mapping_Audit_Required = $row['M_Audit_Required'];
				$Mapping_Verify_Checks = $row['M_Verify_Checks'];
				$Mapping_Price_Roudning = $row['M_Price_Roudning'];
				$Mapping_Nearest_Decimal = $row['M_Nearest_Decimal'];
				$Mapping_Round_Minimum_Up = $row['M_Round_Minimum_Up'];
				$Mapping_Round_Contract_Price = $row['M_Round_Contract_Price'];
				$Mapping_Show_Price = $row['M_Show_Price'];
				$Mapping_Secondary_Salesman = $row['M_Secondary_Salesman'];
				$Mapping_Percent_If_Secondary_Salesman = $row['M_Percent_If_Secondary_Salesman'];

			}
		}
	}
	mysqli_close($con);
}

/*
$Default_Acquisition_Customer_Number = ""; //ACQ Master ID, Main ACQ Cust #
$Default_FEI_Load_Acct = "";
$Default_Hide_Cust = "";
$Default_Customer_Alpha_Key = "";
$Default_Customer_Name = "";
$Default_Addr_1 = "";
$Default_Addr_2 = "";
$Default_Addr_3 = "";
$Default_City = "CASPER";//change this
$Default_State = "WY";//change this
$Default_Zip = "82601";
$Default_Country = "US";
$Default_Credit_Manager = "123456"; //123456
$Default_Phone = ""; //numbers only. no dashes, parentheses, or letters
$Default_Fax = ""; //numbers only. no dashes, parentheses, or letters
$Default_Credit_Limit = "0"; //round to 100's, no decimals or commas
$Default_Salesman_Initials = "123"; //i.e. AAA
$Default_Alt_Salesman_Initials = ""; //i.e. AAA
$Default_Credit_Code = ""; //i.e. X, COD, AROL
$Default_Credit_Rating = "CCC"; //i.e. CCC
$Default_Job_YN = "N"; //i.e. Y or N
$Default_Ship_Via = ""; //leave blank
$Default_Ship_Instr = ""; //leave blank
$Default_Ship_Instr2 = ""; //leave blank
$Default_Ship_Instr3 = ""; //leave blank
$Default_Ship_Instr4 = ""; //leave blank
$Default_Ship_Attn = ""; //leave blank
$Default_Ship_To_Phone = ""; //leave blank
$Default_Terms = ""; //i.e. COD or N10
$Default_Tax_Jur = "WY2NAT";
$Default_Exempt_Num = "";
$Default_Sales_Contact = "";
$Default_Credit_Contact = "";
$Default_Service_Charge = "1.5";
$Default_Branch = "1234";
$Default_Price_Col = "020";
$Default_AR_GL_Num = "1300"; //always 1300
$Default_Job_Name_Req = "N"; //Y or N
$Default_Cust_PO_Req = "N"; //Y or N
$Default_Print_LD = ""; //Y or N
$Default_Print_Price = "Y"; //Y or N
$Default_Alpha_Sort = ""; //Customer Name with spaces and non alphanumeric characters removed
$Default_Territory = ""; //i.e. ACQ-KARLS
$Default_Corp_ID = "";
$Default_DUNS_Num = ""; //always blank
$Default_Dont_Forget = "";
$Default_Status = ""; //A for N10 or T for COD
$Default_Delivery_Charge = "";
$Default_Accept_BO = "";//Y or N
$Default_Min_Charge_Del = "";
$Default_Blind_Bill = "";
$Default_Sort_By_Loc = "";
$Default_Cutoff_Days = ""; //i.e. 25
$Default_Num_Of_Inv = ""; //COD = 0, N10 = 100
$Default_Cust_Type = ""; //i.e. T_MISCRTL
$Default_Personal_Guaranty = ""; //Y or N
$Default_Credit_Application = ""; //Y or N
$Default_Lase_Financial_Statement = ""; 
$Default_Gross_Sales = "";
$Default_Net_Working_Capital = "";
$Default_Net_Worth = "";
$Default_Date_In_Business ="";
$Default_Last_DB_Report ="";
$Default_DB_Rating = "";
$Default_Credit_Region = "1"; //must be 2 digits
$Default_Controlling_Branch = "";
$Default_Reserve_Customer = ""; //Y or N
$Default_Print_EDI_Orders = ""; //Y or N
$Default_Cash_Receipts_Sort = ""; //always JD
$Default_Ship_Complete = ""; //Y or N
$Default_Print_Zero_Invoices = ""; //Y or N
$Default_Print_Neg_Invoices = ""; //Y or N
$Default_Generate_Statement = ""; //P, F, M, or blank
$Default_Generate_2nd_Statement = ""; //P, F, M, or blank
$Default_Generate_Neg_Statement = ""; //Y or N
$Default_Generate_0_Amount_Statement = ""; //Y or N
$Default_Generate_No_Activity_Statement = ""; //Y or N
$Default_Credit_Score = "";
$Default_Affect_Demand = "";
$Default_Incentive_Effective_Date = "";
$Default_Incentive_Duration = "";
$Default_Claimback_Customer = ""; 
$Default_Generate_Invoices = ""; //P, F, M, or blank
$Default_Generate_2nd_Invoices = ""; //P, F, M, or blank
$Default_Statement_Seq = "";
$Default_Auto_Conf = "";
$Default_Associated_Info = "";
$Default_Labels = ""; //Y or N
$Default_Customer_Supplier_Num = "";
$Default_Customer_Prep_Day = "";
$Default_Review_Freight = ""; //Y or N
$Default_Customer_Ordered_By = "";
$Default_Use_Freight_Tables = "";
$Default_Ext_Price_On_Ticket = "";
$Default_Master_Customer = "";
$Default_GSA_Pricing = "";
$Default_Enable_Level_3_CC_Reporting = ""; //Y or N
$Default_Audit_Required = "";
$Default_Verify_Checks = ""; //Y or N
$Default_Price_Roudning = "";
$Default_Nearest_Decimal = "";
$Default_Round_Minimum_Up = "";
$Default_Round_Contract_Price = "";
$Default_Show_Price = ""; //Y or N
$Default_Secondary_Salesman = ""; //3 digit initials
$Default_Percent_If_Secondary_Salesman = "";
*/

//Map the fields to certain columns in the data file - DEV_NOTE: later get this dynamically from a template
/*
$Mapping_Acquisition_Customer_Number = "0"; //ACQ Master ID, Main ACQ Cust # - DEV NOTE: remove spaces
$Mapping_FEI_Load_Acct = "";
$Mapping_Hide_Cust = ""; //DEV NOTE: later look and hide duplicates with the same phone #
$Mapping_Customer_Alpha_Key = 2; //DEV NOTE: remove non alphanumeric characters and make uppercase
$Mapping_Customer_Name = 2; //DEV NOTE: Make uppercase
$Mapping_Addr_1 = 4; //DEV NOTE: Make uppercase
$Mapping_Addr_2 = "";
$Mapping_Addr_3 = "";
$Mapping_City = 5; //DEV NOTE: Make uppercase
$Mapping_State = 6; //DEV NOTE: Make uppercase
$Mapping_Zip = 7; //DEV NOTE: Make uppercase
$Mapping_Country = ""; //DEV NOTE: figure out dynamically
$Mapping_Credit_Manager = ""; 
$Mapping_Phone = 8;  //DEV NOTE: remove leading 1, remove all non numeric characters, limit to 10 characters
$Mapping_Fax = 9; //DEV NOTE: remove leading 1, remove all non numeric characters, limit to 10 characters
$Mapping_Credit_Limit = 18; //round to 100's, no decimals or commas
$Mapping_Salesman_Initials = ""; //DEV NOTE: later map these from a file
$Mapping_Alt_Salesman_Initials = ""; //DEV NOTE: later map these from a file
$Mapping_Credit_Code = ""; //i.e. X, COD, AROL
$Mapping_Credit_Rating = ""; //i.e. CCC
$Mapping_Job_YN = ""; //i.e. Y or N
$Mapping_Ship_Via = ""; //leave blank
$Mapping_Ship_Instr = ""; //leave blank
$Mapping_Ship_Instr2 = ""; //leave blank
$Mapping_Ship_Instr3 = ""; //leave blank
$Mapping_Ship_Instr4 = ""; //leave blank
$Mapping_Ship_Attn = ""; //leave blank
$Mapping_Ship_To_Phone = ""; //leave blank
$Mapping_Terms = ""; //i.e. COD or N10
$Mapping_Tax_Jur = ""; //allocate automatically, set to state initials + "E" if Exempt Num is populated
$Mapping_Exempt_Num = 14;
$Mapping_Sales_Contact = "";
$Mapping_Credit_Contact = "";
$Mapping_Service_Charge = "";
$Mapping_Branch = "";
$Mapping_Price_Col = "";
$Mapping_AR_GL_Num = ""; //always 1300
$Mapping_Job_Name_Req = ""; //Y or N
$Mapping_Cust_PO_Req = ""; //Y or N
$Mapping_Print_LD = ""; //Y or N
$Mapping_Print_Price = ""; //Y or N
$Mapping_Alpha_Sort = ""; //Customer Name with spaces and non alphanumeric characters removed
$Mapping_Territory = ""; //i.e. ACQ-KARLS
$Mapping_Corp_ID = "";
$Mapping_DUNS_Num = ""; //always blank
$Mapping_Dont_Forget = "";
$Mapping_Status = ""; //A for N10 or T for COD
$Mapping_Delivery_Charge = "";
$Mapping_Accept_BO = "";//Y or N
$Mapping_Min_Charge_Del = "";
$Mapping_Blind_Bill = "";
$Mapping_Sort_By_Loc = "";
$Mapping_Cutoff_Days = ""; //i.e. 25
$Mapping_Num_Of_Inv = 28; //COD = 0, N10 = 100
$Mapping_Cust_Type = ""; //i.e. T_MISCRTL
$Mapping_Personal_Guaranty = ""; //Y or N
$Mapping_Credit_Application = ""; //Y or N
$Mapping_Lase_Financial_Statement = ""; 
$Mapping_Gross_Sales = "";
$Mapping_Net_Working_Capital = "";
$Mapping_Net_Worth = "";
$Mapping_Date_In_Business ="";
$Mapping_Last_DB_Report ="";
$Mapping_DB_Rating = "";
$Mapping_Credit_Region = ""; //must be 2 digits
$Mapping_Controlling_Branch = "";
$Mapping_Reserve_Customer = ""; //Y or N
$Mapping_Print_EDI_Orders = ""; //Y or N
$Mapping_Cash_Receipts_Sort = ""; //always JD
$Mapping_Ship_Complete = ""; //Y or N
$Mapping_Print_Zero_Invoices = ""; //Y or N
$Mapping_Print_Neg_Invoices = ""; //Y or N
$Mapping_Generate_Statement = ""; //P, F, M, or blank
$Mapping_Generate_2nd_Statement = ""; //P, F, M, or blank
$Mapping_Generate_Neg_Statement = ""; //Y or N
$Mapping_Generate_0_Amount_Statement = ""; //Y or N
$Mapping_Generate_No_Activity_Statement = ""; //Y or N
$Mapping_Credit_Score = "";
$Mapping_Affect_Demand = "";
$Mapping_Incentive_Effective_Date = "";
$Mapping_Incentive_Duration = "";
$Mapping_Claimback_Customer = ""; 
$Mapping_Generate_Invoices = ""; //P, F, M, or blank
$Mapping_Generate_2nd_Invoices = ""; //P, F, M, or blank
$Mapping_Statement_Seq = "";
$Mapping_Auto_Conf = "";
$Mapping_Associated_Info = "";
$Mapping_Labels = ""; //Y or N
$Mapping_Customer_Supplier_Num = "";
$Mapping_Customer_Prep_Day = "";
$Mapping_Review_Freight = ""; //Y or N
$Mapping_Customer_Ordered_By = "";
$Mapping_Use_Freight_Tables = "";
$Mapping_Ext_Price_On_Ticket = "";
$Mapping_Master_Customer = "";
$Mapping_GSA_Pricing = "";
$Mapping_Enable_Level_3_CC_Reporting = ""; //Y or N
$Mapping_Audit_Required = "";
$Mapping_Verify_Checks = ""; //Y or N
$Mapping_Price_Roudning = "";
$Mapping_Nearest_Decimal = "";
$Mapping_Round_Minimum_Up = "";
$Mapping_Round_Contract_Price = "";
$Mapping_Show_Price = ""; //Y or N
$Mapping_Secondary_Salesman = ""; //3 digit initials
$Mapping_Percent_If_Secondary_Salesman = "";
*/

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
				
				//connect to database
				$con=mysqli_connect("localhost","username,"password","acquisition"); //with DB
						
				//check connection
				if(mysqli_connect_errno())
				{
					echo "ERROR: Failed to connect to the database!" . mysqli_connect_error();
				}
				else
				{
					$file_row_counter = 0;
			
					while(($data = fgetcsv($handle,1000,","))!==FALSE)
					{
					
						if($file_row_counter != 0)
						{
						
							//echo "starting a new row<br>";
							//set fields to defaults
							$Acquisition_Customer_Number = $Default_Acquisition_Customer_Number; //ACQ Master ID, Main ACQ Cust #
							$FEI_Load_Acct = $Default_FEI_Load_Acct;
							$Hide_Cust = $Default_Hide_Cust;
							$Customer_Alpha_Key = $Default_Customer_Alpha_Key;
							$Customer_Name = $Default_Customer_Name;
							$Addr_1 = $Default_Addr_1;
							$Addr_2 = $Default_Addr_2;
							$Addr_3 = $Default_Addr_3;
							$City = $Default_City;
							$State = $Default_State;
							$Zip = $Default_Zip;
							$Country = $Default_Country;
							$Credit_Manager = $Default_Credit_Manager; //123456
							$Phone = $Default_Phone; //numbers only. no dashes, parentheses, or letters
							$Fax = $Default_Fax; //numbers only. no dashes, parentheses, or letters
							$Credit_Limit = $Default_Credit_Limit; //round to 100's, no decimals or commas
							$Salesman_Initials = $Default_Salesman_Initials; //i.e. AAA
							$Alt_Salesman_Initials = $Default_Alt_Salesman_Initials; //i.e. AAA
							$Credit_Code = $Default_Credit_Code; //i.e. X, COD, AROL
							$Credit_Rating = $Default_Credit_Rating; //i.e. CCC
							$Job_YN = $Default_Job_YN; //i.e. Y or N
							$Ship_Via = $Default_Ship_Via; //leave blank
							$Ship_Instr = $Default_Ship_Instr; //leave blank
							$Ship_Instr2 = $Default_Ship_Instr2; //leave blank
							$Ship_Instr3 = $Default_Ship_Instr3; //leave blank
							$Ship_Instr4 = $Default_Ship_Instr4; //leave blank
							$Ship_Attn = $Default_Ship_Attn; //leave blank
							$Ship_To_Phone = $Default_Ship_To_Phone; //leave blank
							$Terms = $Default_Terms; //i.e. COD or N10
							$Tax_Jur = $Default_Tax_Jur;
							$Exempt_Num = $Default_Exempt_Num;
							$Sales_Contact = $Default_Sales_Contact;
							$Credit_Contact = $Default_Credit_Contact;
							$Service_Charge = $Default_Service_Charge;
							$Branch = $Default_Branch;
							$Price_Col = $Default_Price_Col;
							$AR_GL_Num = $Default_AR_GL_Num; //always 1300
							$Job_Name_Req = $Default_Job_Name_Req; //Y or N
							$Cust_PO_Req = $Default_Cust_PO_Req; //Y or N
							$Print_LD = $Default_Print_LD; //Y or N
							$Print_Price = $Default_Print_Price; //Y or N
							$Alpha_Sort = $Default_Alpha_Sort; //Customer Name with spaces and non alphanumeric characters removed
							$Territory = $Default_Territory; //i.e. ACQ-KARLS
							$Corp_ID = $Default_Corp_ID;
							$DUNS_Num = $Default_DUNS_Num; //always blank
							$Dont_Forget = $Default_Dont_Forget;
							$Status = $Default_Status; //A for N10 or T for COD
							$Delivery_Charge = $Default_Delivery_Charge;
							$Accept_BO = $Default_Accept_BO;//Y or N
							$Min_Charge_Del = $Default_Min_Charge_Del;
							$Blind_Bill = $Default_Blind_Bill;
							$Sort_By_Loc = $Default_Sort_By_Loc;
							$Cutoff_Days = $Default_Cutoff_Days; //i.e. 25
							$Num_Of_Inv = $Default_Num_Of_Inv; //COD = 0, N10 = 100
							$Cust_Type = $Default_Cust_Type; //i.e. T_MISCRTL
							$Personal_Guaranty = $Default_Personal_Guaranty; //Y or N
							$Credit_Application = $Default_Credit_Application; //Y or N
							$Last_Financial_Statement = $Default_Last_Financial_Statement; 
							$Gross_Sales = $Default_Gross_Sales;
							$Net_Working_Capital = $Default_Net_Working_Capital;
							$Net_Worth = $Default_Net_Worth;
							$Date_In_Business = $Default_Date_In_Business;
							$Last_DB_Report = $Default_Last_DB_Report;
							$DB_Rating = $Default_DB_Rating;
							$Credit_Region = $Default_Credit_Region; //must be 2 digits
							$Controlling_Branch = $Default_Controlling_Branch;
							$Reserve_Customer = $Default_Reserve_Customer; //Y or N
							$Print_EDI_Orders = $Default_Print_EDI_Orders; //Y or N
							$Cash_Receipts_Sort = $Default_Cash_Receipts_Sort; //always JD
							$Ship_Complete = $Default_Ship_Complete; //Y or N
							$Print_Zero_Invoices = $Default_Print_Zero_Invoices; //Y or N
							$Print_Neg_Invoices = $Default_Print_Neg_Invoices; //Y or N
							$Generate_Statement = $Default_Generate_Statement; //P, F, M, or blank
							$Generate_2nd_Statement = $Default_Generate_2nd_Statement; //P, F, M, or blank
							$Generate_Neg_Statement = $Default_Generate_Neg_Statement; //Y or N
							$Generate_0_Amount_Statement = $Default_Generate_0_Amount_Statement; //Y or N
							$Generate_No_Activity_Statement = $Default_Generate_No_Activity_Statement; //Y or N
							$Credit_Score = $Default_Credit_Score;
							$Affect_Demand = $Default_Affect_Demand;
							$Incentive_Effective_Date = $Default_Incentive_Effective_Date;
							$Incentive_Duration = $Default_Incentive_Duration;
							$Claimback_Customer = $Default_Claimback_Customer; 
							$Generate_Invoices = $Default_Generate_Invoices; //P, F, M, or blank
							$Generate_2nd_Invoices = $Default_Generate_2nd_Invoices; //P, F, M, or blank
							$Statement_Seq = $Default_Statement_Seq;
							$Auto_Conf = $Default_Auto_Conf;
							$Associated_Info = $Default_Associated_Info;
							$Labels = $Default_Labels; //Y or N
							$Customer_Supplier_Num = $Default_Customer_Supplier_Num;
							$Customer_Prep_Day = $Default_Customer_Prep_Day;
							$Review_Freight = $Default_Review_Freight; //Y or N
							$Customer_Ordered_By = $Default_Customer_Ordered_By;
							$Use_Freight_Tables = $Default_Use_Freight_Tables;
							$Ext_Price_On_Ticket = $Default_Ext_Price_On_Ticket;
							$Master_Customer = $Default_Master_Customer;
							$GSA_Pricing = $Default_GSA_Pricing;
							$Enable_Level_3_CC_Reporting = $Default_Enable_Level_3_CC_Reporting; //Y or N
							$Audit_Required = $Default_Audit_Required;
							$Verify_Checks = $Default_Verify_Checks; //Y or N
							$Price_Roudning = $Default_Price_Roudning;
							$Nearest_Decimal = $Default_Nearest_Decimal;
							$Round_Minimum_Up = $Default_Round_Minimum_Up;
							$Round_Contract_Price = $Default_Round_Contract_Price;
							$Show_Price = $Default_Show_Price; //Y or N
							$Secondary_Salesman = $Default_Secondary_Salesman; //3 digit initials
							$Percent_If_Secondary_Salesman = $Default_Percent_If_Secondary_Salesman;
							//assign values if mapping exists
							if($Mapping_Acquisition_Customer_Number<>"") { if($data[$Mapping_Acquisition_Customer_Number]<>"") { $Acquisition_Customer_Number = $data[$Mapping_Acquisition_Customer_Number]; } }
							if($Mapping_FEI_Load_Acct<>"") { if($data[$Mapping_FEI_Load_Acct]<>"") { $FEI_Load_Acct = $data[$Mapping_FEI_Load_Acct]; } }
							if($Mapping_Hide_Cust<>"") { if($data[$Mapping_Hide_Cust]<>"") { $Hide_Cust = $data[$Mapping_Hide_Cust]; } }
							if($Mapping_Customer_Alpha_Key<>"") { if($data[$Mapping_Customer_Alpha_Key]<>"") { $Customer_Alpha_Key = $data[$Mapping_Customer_Alpha_Key]; } }
							if($Mapping_Customer_Name<>"") { if($data[$Mapping_Customer_Name]<>"") { $Customer_Name = $data[$Mapping_Customer_Name]; } }
							if($Mapping_Addr_1<>"") { if($data[$Mapping_Addr_1]<>"") { $Addr_1 = $data[$Mapping_Addr_1]; } }
							if($Mapping_Addr_2<>"") { if($data[$Mapping_Addr_2]<>"") { $Addr_2 = $data[$Mapping_Addr_2]; } }
							if($Mapping_Addr_3<>"") { if($data[$Mapping_Addr_3]<>"") { $Addr_3 = $data[$Mapping_Addr_3]; } }
							if($Mapping_City<>"") { if($data[$Mapping_City]<>"") { $City = $data[$Mapping_City]; } }
							if($Mapping_State<>"") { if($data[$Mapping_State]<>"") { $State = $data[$Mapping_State]; } }
							if($Mapping_Zip<>"") { if($data[$Mapping_Zip]<>"") { $Zip = $data[$Mapping_Zip]; } }
							if($Mapping_Country<>"") { if($data[$Mapping_Country]<>"") { $Country = $data[$Mapping_Country]; } }
							if($Mapping_Credit_Manager<>"") { if($data[$Mapping_Credit_Manager]<>"") { $Credit_Manager = $data[$Mapping_Credit_Manager]; } }
							if($Mapping_Phone<>"") { if($data[$Mapping_Phone]<>"") { $Phone = $data[$Mapping_Phone]; } }
							if($Mapping_Fax<>"") { if($data[$Mapping_Fax]<>"") { $Fax = $data[$Mapping_Fax]; } }
							if($Mapping_Credit_Limit<>"") { if($data[$Mapping_Credit_Limit]<>"") { $Credit_Limit = $data[$Mapping_Credit_Limit]; } }
							if($Mapping_Salesman_Initials<>"") { if($data[$Mapping_Salesman_Initials]<>"") { $Salesman_Initials = $data[$Mapping_Salesman_Initials]; } }
							if($Mapping_Alt_Salesman_Initials<>"") { if($data[$Mapping_Alt_Salesman_Initials]<>"") { $Alt_Salesman_Initials = $data[$Mapping_Alt_Salesman_Initials]; } }
							if($Mapping_Credit_Code<>"") { if($data[$Mapping_Credit_Code]<>"") { $Credit_Code = $data[$Mapping_Credit_Code]; } }
							if($Mapping_Credit_Rating<>"") { if($data[$Mapping_Credit_Rating]<>"") { $Credit_Rating = $data[$Mapping_Credit_Rating]; } }
							if($Mapping_Job_YN<>"") { if($data[$Mapping_Job_YN]<>"") { $Job_YN = $data[$Mapping_Job_YN]; } }
							if($Mapping_Ship_Via<>"") { if($data[$Mapping_Ship_Via]<>"") { $Ship_Via = $data[$Mapping_Ship_Via]; } }
							if($Mapping_Ship_Instr<>"") { if($data[$Mapping_Ship_Instr]<>"") { $Ship_Instr = $data[$Mapping_Ship_Instr]; } }
							if($Mapping_Ship_Instr2<>"") { if($data[$Mapping_Ship_Instr2]<>"") { $Ship_Instr2 = $data[$Mapping_Ship_Instr2]; } }
							if($Mapping_Ship_Instr3<>"") { if($data[$Mapping_Ship_Instr3]<>"") { $Ship_Instr3 = $data[$Mapping_Ship_Instr3]; } }
							if($Mapping_Ship_Instr4<>"") { if($data[$Mapping_Ship_Instr4]<>"") { $Ship_Instr4 = $data[$Mapping_Ship_Instr4]; } }
							if($Mapping_Ship_Attn<>"") { if($data[$Mapping_Ship_Attn]<>"") { $Ship_Attn = $data[$Mapping_Ship_Attn]; } }
							if($Mapping_Ship_To_Phone<>"") { if($data[$Mapping_Ship_To_Phone]<>"") { $Ship_To_Phone = $data[$Mapping_Ship_To_Phone]; } }
							if($Mapping_Terms<>"") { if($data[$Mapping_Terms]<>"") { $Terms = $data[$Mapping_Terms]; } }
							if($Mapping_Tax_Jur<>"") { if($data[$Mapping_Tax_Jur]<>"") { $Tax_Jur = $data[$Mapping_Tax_Jur]; } }
							if($Mapping_Exempt_Num<>"") { if($data[$Mapping_Exempt_Num]<>"") { $Exempt_Num = $data[$Mapping_Exempt_Num]; } }
							if($Mapping_Sales_Contact<>"") { if($data[$Mapping_Sales_Contact]<>"") { $Sales_Contact = $data[$Mapping_Sales_Contact]; } }
							if($Mapping_Credit_Contact<>"") { if($data[$Mapping_Credit_Contact]<>"") { $Credit_Contact = $data[$Mapping_Credit_Contact]; } }
							if($Mapping_Service_Charge<>"") { if($data[$Mapping_Service_Charge]<>"") { $Service_Charge = $data[$Mapping_Service_Charge]; } }
							if($Mapping_Branch<>"") { if($data[$Mapping_Branch]<>"") { $Branch = $data[$Mapping_Branch]; } }
							if($Mapping_Price_Col<>"") { if($data[$Mapping_Price_Col]<>"") { $Price_Col = $data[$Mapping_Price_Col]; } }
							if($Mapping_AR_GL_Num<>"") { if($data[$Mapping_AR_GL_Num]<>"") { $AR_GL_Num = $data[$Mapping_AR_GL_Num]; } }
							if($Mapping_Job_Name_Req<>"") { if($data[$Mapping_Job_Name_Req]<>"") { $Job_Name_Req = $data[$Mapping_Job_Name_Req]; } }
							if($Mapping_Cust_PO_Req<>"") { if($data[$Mapping_Cust_PO_Req]<>"") { $Cust_PO_Req = $data[$Mapping_Cust_PO_Req]; } }
							if($Mapping_Print_LD<>"") { if($data[$Mapping_Print_LD]<>"") { $Print_LD = $data[$Mapping_Print_LD]; } }
							if($Mapping_Print_Price<>"") { if($data[$Mapping_Print_Price]<>"") { $Print_Price = $data[$Mapping_Print_Price]; } }
							if($Mapping_Alpha_Sort<>"") { if($data[$Mapping_Alpha_Sort]<>"") { $Alpha_Sort = $data[$Mapping_Alpha_Sort]; } }
							if($Mapping_Territory<>"") { if($data[$Mapping_Territory]<>"") { $Territory = $data[$Mapping_Territory]; } }
							if($Mapping_Corp_ID<>"") { if($data[$Mapping_Corp_ID]<>"") { $Corp_ID = $data[$Mapping_Corp_ID]; } }
							if($Mapping_DUNS_Num<>"") { if($data[$Mapping_DUNS_Num]<>"") { $DUNS_Num = $data[$Mapping_DUNS_Num]; } }
							if($Mapping_Dont_Forget<>"") { if($data[$Mapping_Dont_Forget]<>"") { $Dont_Forget = $data[$Mapping_Dont_Forget]; } }
							if($Mapping_Status<>"") { if($data[$Mapping_Status]<>"") { $Status = $data[$Mapping_Status]; } }
							if($Mapping_Delivery_Charge<>"") { if($data[$Mapping_Delivery_Charge]<>"") { $Delivery_Charge = $data[$Mapping_Delivery_Charge]; } }
							if($Mapping_Accept_BO<>"") { if($data[$Mapping_Accept_BO]<>"") { $Accept_BO = $data[$Mapping_Accept_BO]; } }
							if($Mapping_Min_Charge_Del<>"") { if($data[$Mapping_Min_Charge_Del]<>"") { $Min_Charge_Del = $data[$Mapping_Min_Charge_Del]; } }
							if($Mapping_Blind_Bill<>"") { if($data[$Mapping_Blind_Bill]<>"") { $Blind_Bill = $data[$Mapping_Blind_Bill]; } }
							if($Mapping_Sort_By_Loc<>"") { if($data[$Mapping_Sort_By_Loc]<>"") { $Sort_By_Loc = $data[$Mapping_Sort_By_Loc]; } }
							if($Mapping_Cutoff_Days<>"") { if($data[$Mapping_Cutoff_Days]<>"") { $Cutoff_Days = $data[$Mapping_Cutoff_Days]; } }
							if($Mapping_Num_Of_Inv<>"") { if($data[$Mapping_Num_Of_Inv]<>"") { $Num_Of_Inv = $data[$Mapping_Num_Of_Inv]; } }
							if($Mapping_Cust_Type<>"") { if($data[$Mapping_Cust_Type]<>"") { $Cust_Type = $data[$Mapping_Cust_Type]; } }
							if($Mapping_Personal_Guaranty<>"") { if($data[$Mapping_Personal_Guaranty]<>"") { $Personal_Guaranty = $data[$Mapping_Personal_Guaranty]; } }
							if($Mapping_Credit_Application<>"") { if($data[$Mapping_Credit_Application]<>"") { $Credit_Application = $data[$Mapping_Credit_Application]; } }
							if($Mapping_Last_Financial_Statement<>"") { if($data[$Mapping_Last_Financial_Statement]<>"") { $Last_Financial_Statement = $data[$Mapping_Last_Financial_Statement]; } }
							if($Mapping_Gross_Sales<>"") { if($data[$Mapping_Gross_Sales]<>"") { $Gross_Sales = $data[$Mapping_Gross_Sales]; } }
							if($Mapping_Net_Working_Capital<>"") { if($data[$Mapping_Net_Working_Capital]<>"") { $Net_Working_Capital = $data[$Mapping_Net_Working_Capital]; } }
							if($Mapping_Net_Worth<>"") { if($data[$Mapping_Net_Worth]<>"") { $Net_Worth = $data[$Mapping_Net_Worth]; } }
							if($Mapping_Date_In_Business<>"") { if($data[$Mapping_Date_In_Business]<>"") { $Date_In_Business = $data[$Mapping_Date_In_Business]; } }
							if($Mapping_Last_DB_Report<>"") { if($data[$Mapping_Last_DB_Report]<>"") { $Last_DB_Report = $data[$Mapping_Last_DB_Report]; } }
							if($Mapping_DB_Rating<>"") { if($data[$Mapping_DB_Rating]<>"") { $DB_Rating = $data[$Mapping_DB_Rating]; } }
							if($Mapping_Credit_Region<>"") { if($data[$Mapping_Credit_Region]<>"") { $Credit_Region = $data[$Mapping_Credit_Region]; } }
							if($Mapping_Controlling_Branch<>"") { if($data[$Mapping_Controlling_Branch]<>"") { $Controlling_Branch = $data[$Mapping_Controlling_Branch]; } }
							if($Mapping_Reserve_Customer<>"") { if($data[$Mapping_Reserve_Customer]<>"") { $Reserve_Customer = $data[$Mapping_Reserve_Customer]; } }
							if($Mapping_Print_EDI_Orders<>"") { if($data[$Mapping_Print_EDI_Orders]<>"") { $Print_EDI_Orders = $data[$Mapping_Print_EDI_Orders]; } }
							if($Mapping_Cash_Receipts_Sort<>"") { if($data[$Mapping_Cash_Receipts_Sort]<>"") { $Cash_Receipts_Sort = $data[$Mapping_Cash_Receipts_Sort]; } }
							if($Mapping_Ship_Complete<>"") { if($data[$Mapping_Ship_Complete]<>"") { $Ship_Complete = $data[$Mapping_Ship_Complete]; } }
							if($Mapping_Print_Zero_Invoices<>"") { if($data[$Mapping_Print_Zero_Invoices]<>"") { $Print_Zero_Invoices = $data[$Mapping_Print_Zero_Invoices]; } }
							if($Mapping_Print_Neg_Invoices<>"") { if($data[$Mapping_Print_Neg_Invoices]<>"") { $Print_Neg_Invoices = $data[$Mapping_Print_Neg_Invoices]; } }
							if($Mapping_Generate_Statement<>"") { if($data[$Mapping_Generate_Statement]<>"") { $Generate_Statement = $data[$Mapping_Generate_Statement]; } }
							if($Mapping_Generate_2nd_Statement<>"") { if($data[$Mapping_Generate_2nd_Statement]<>"") { $Generate_2nd_Statement = $data[$Mapping_Generate_2nd_Statement]; } }
							if($Mapping_Generate_Neg_Statement<>"") { if($data[$Mapping_Generate_Neg_Statement]<>"") { $Generate_Neg_Statement = $data[$Mapping_Generate_Neg_Statement]; } }
							if($Mapping_Generate_0_Amount_Statement<>"") { if($data[$Mapping_Generate_0_Amount_Statement]<>"") { $Generate_0_Amount_Statement = $data[$Mapping_Generate_0_Amount_Statement]; } }
							if($Mapping_Generate_No_Activity_Statement<>"") { if($data[$Mapping_Generate_No_Activity_Statement]<>"") { $Generate_No_Activity_Statement = $data[$Mapping_Generate_No_Activity_Statement]; } }
							if($Mapping_Credit_Score<>"") { if($data[$Mapping_Credit_Score]<>"") { $Credit_Score = $data[$Mapping_Credit_Score]; } }
							if($Mapping_Affect_Demand<>"") { if($data[$Mapping_Affect_Demand]<>"") { $Affect_Demand = $data[$Mapping_Affect_Demand]; } }
							if($Mapping_Incentive_Effective_Date<>"") { if($data[$Mapping_Incentive_Effective_Date]<>"") { $Incentive_Effective_Date = $data[$Mapping_Incentive_Effective_Date]; } }
							if($Mapping_Incentive_Duration<>"") { if($data[$Mapping_Incentive_Duration]<>"") { $Incentive_Duration = $data[$Mapping_Incentive_Duration]; } }
							if($Mapping_Claimback_Customer<>"") { if($data[$Mapping_Claimback_Customer]<>"") { $Claimback_Customer = $data[$Mapping_Claimback_Customer]; } }
							if($Mapping_Generate_Invoices<>"") { if($data[$Mapping_Generate_Invoices]<>"") { $Generate_Invoices = $data[$Mapping_Generate_Invoices]; } }
							if($Mapping_Generate_2nd_Invoices<>"") { if($data[$Mapping_Generate_2nd_Invoices]<>"") { $Generate_2nd_Invoices = $data[$Mapping_Generate_2nd_Invoices]; } }
							if($Mapping_Statement_Seq<>"") { if($data[$Mapping_Statement_Seq]<>"") { $Statement_Seq = $data[$Mapping_Statement_Seq]; } }
							if($Mapping_Auto_Conf<>"") { if($data[$Mapping_Auto_Conf]<>"") { $Auto_Conf = $data[$Mapping_Auto_Conf]; } }
							if($Mapping_Associated_Info<>"") { if($data[$Mapping_Associated_Info]<>"") { $Associated_Info = $data[$Mapping_Associated_Info]; } }
							if($Mapping_Labels<>"") { if($data[$Mapping_Labels]<>"") { $Labels = $data[$Mapping_Labels]; } }
							if($Mapping_Customer_Supplier_Num<>"") { if($data[$Mapping_Customer_Supplier_Num]<>"") { $Customer_Supplier_Num = $data[$Mapping_Customer_Supplier_Num]; } }
							if($Mapping_Customer_Prep_Day<>"") { if($data[$Mapping_Customer_Prep_Day]<>"") { $Customer_Prep_Day = $data[$Mapping_Customer_Prep_Day]; } }
							if($Mapping_Review_Freight<>"") { if($data[$Mapping_Review_Freight]<>"") { $Review_Freight = $data[$Mapping_Review_Freight]; } }
							if($Mapping_Customer_Ordered_By<>"") { if($data[$Mapping_Customer_Ordered_By]<>"") { $Customer_Ordered_By = $data[$Mapping_Customer_Ordered_By]; } }
							if($Mapping_Use_Freight_Tables<>"") { if($data[$Mapping_Use_Freight_Tables]<>"") { $Use_Freight_Tables = $data[$Mapping_Use_Freight_Tables]; } }
							if($Mapping_Ext_Price_On_Ticket<>"") { if($data[$Mapping_Ext_Price_On_Ticket]<>"") { $Ext_Price_On_Ticket = $data[$Mapping_Ext_Price_On_Ticket]; } }
							if($Mapping_Master_Customer<>"") { if($data[$Mapping_Master_Customer]<>"") { $Master_Customer = $data[$Mapping_Master_Customer]; } }
							if($Mapping_GSA_Pricing<>"") { if($data[$Mapping_GSA_Pricing]<>"") { $GSA_Pricing = $data[$Mapping_GSA_Pricing]; } }
							if($Mapping_Enable_Level_3_CC_Reporting<>"") { if($data[$Mapping_Enable_Level_3_CC_Reporting]<>"") { $Enable_Level_3_CC_Reporting = $data[$Mapping_Enable_Level_3_CC_Reporting]; } }
							if($Mapping_Audit_Required<>"") { if($data[$Mapping_Audit_Required]<>"") { $Audit_Required = $data[$Mapping_Audit_Required]; } }
							if($Mapping_Verify_Checks<>"") { if($data[$Mapping_Verify_Checks]<>"") { $Verify_Checks = $data[$Mapping_Verify_Checks]; } }
							if($Mapping_Price_Roudning<>"") { if($data[$Mapping_Price_Roudning]<>"") { $Price_Roudning = $data[$Mapping_Price_Roudning]; } }
							if($Mapping_Nearest_Decimal<>"") { if($data[$Mapping_Nearest_Decimal]<>"") { $Nearest_Decimal = $data[$Mapping_Nearest_Decimal]; } }
							if($Mapping_Round_Minimum_Up<>"") { if($data[$Mapping_Round_Minimum_Up]<>"") { $Round_Minimum_Up = $data[$Mapping_Round_Minimum_Up]; } }
							if($Mapping_Round_Contract_Price<>"") { if($data[$Mapping_Round_Contract_Price]<>"") { $Round_Contract_Price = $data[$Mapping_Round_Contract_Price]; } }
							if($Mapping_Show_Price<>"") { if($data[$Mapping_Show_Price]<>"") { $Show_Price = $data[$Mapping_Show_Price]; } }
							if($Mapping_Secondary_Salesman<>"") { if($data[$Mapping_Secondary_Salesman]<>"") { $Secondary_Salesman = $data[$Mapping_Secondary_Salesman]; } }
							if($Mapping_Percent_If_Secondary_Salesman<>"") { if($data[$Mapping_Percent_If_Secondary_Salesman]<>"") { $Percent_If_Secondary_Salesman = $data[$Mapping_Percent_If_Secondary_Salesman]; } }
								
							//format fields
							$Acquisition_Customer_Number = remove_spaces($Acquisition_Customer_Number);
							$Acquisition_Customer_Number = remove_commas($Acquisition_Customer_Number);
							
							//$Hide_Cust //DEV NOTE: later look and hide duplicates with the same phone #
							
							$Customer_Name = make_upper_case($Customer_Name);
							$Customer_Name = remove_commas($Customer_Name);
							
							//if the first word of the customer name is a name then swap the first two words in the alpha
							$arr = explode(" ",trim($Customer_Name));
							$first_word_of_name = strtolower($arr[0]);
							$name_in_list = 0;
							$result = mysqli_query($con, "SELECT * FROM common_names WHERE Name = '" . $first_word_of_name . "'");
							while(@$row = mysqli_fetch_array($result))
							{
								if($row['Name'] == $first_word_of_name)
								{
									$name_in_list = 1;
								}
							}
							if($name_in_list == 1)
							{
								//echo "This word is a name";
								$array_length = sizeof($arr);
								$array_length = $array_length - 1;
								//echo "The word length is " . $array_length . "<br>";
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
								//echo "This word is not a name";
								$new_alpha = $Customer_Name;
							}
							//echo "the customer name was " . $Customer_Name . "<br>";
							//echo "the new alpha is " . $new_alpha . "<br>";
							$Customer_Alpha_Key = remove_non_alpha_numeric($new_alpha);
							$Customer_Alpha_Key = remove_spaces($Customer_Alpha_Key);
							$Customer_Alpha_Key = make_upper_case($Customer_Alpha_Key);
							$Customer_Alpha_Key = get_left_10($Customer_Alpha_Key);
							
							$Addr_1 = make_upper_case($Addr_1);
							$Addr_2 = make_upper_case($Addr_2);
							$Addr_3 = make_upper_case($Addr_3);
								
							$Addr_1 = remove_commas($Addr_1);
							$Addr_2 = remove_commas($Addr_2);
							$Addr_3 = remove_commas($Addr_3);
							
							$Addr_1 = remove_semi_colon($Addr_1);
							$Addr_2 = remove_semi_colon($Addr_2);
							$Addr_3 = remove_semi_colon($Addr_3);

							$City = make_upper_case($City);
							$State = make_upper_case($State);
							$Zip = remove_non_numeric($Zip);
							$Zip = get_left_5($Zip);
								
							//validate the zip code
							$default_zip = $Default_Zip;
							$zip_code = $Zip;
							$number = $zip_code;
							//echo $number . "<br>";
							$number = ltrim($number, '0');
							//echo $number . "<br>";
							$zip_array = array();
							foreach($zip_array as $key=>$value) 
							{
								unset($zip_array[$key]);
							}
							$zip_array_count = 0;
							$city_upper = make_upper_case($City);			
							$state_upper = make_upper_case($State);
							$result = mysqli_query($con, "SELECT * FROM zip_codes WHERE City = '" . $city_upper . "' AND State = '" . $state_upper . "'");
							$city_present = 0;
							$new_type = "";
							
							if($result === FALSE)
							{
								//ERROR city or state not found 
								$new_zip = $zip_code;
								$Text_To_Log .= "City or state note found in DB. The city and state are " . $City . ", " . $State . ". The old zip code was " . $Zip . ". The new zip code is " . $new_zip . ".";
								$Text_To_Log .= PHP_EOL;
							}
							else 
							{
								while($row = mysqli_fetch_array($result))
								{
									//echo $row['Zip_Code'] . "<br>";
									$zip_array[$zip_array_count] = $row['Zip_Code'];
									$zip_array_count = $zip_array_count + 1;
								}
							}
							
							if(sizeof($zip_array)>0)
							{
								if (in_array($number, $zip_array))
								{
									//echo "Zip is correct as is leaving as is<br>";
									//the zip is correct leave it as is
									$new_zip = $zip_code;
								}
								else
								{
									//echo "City exists, but zip is wrong. Changing<br>";
									$new_zip = $zip_array[0];
									//use the first zip code found
									$Text_To_Log .= "Corrected a zip code. The city and state are " . $City . ", " . $State . ". The old zip code was " . $Zip . ". The new zip code is " . $new_zip . ".";
									$Text_To_Log .= PHP_EOL;
								}
							}
							else
							{
								if($zip_code == "")
								{
									//echo "zip was blank and city doesn't exist. using the default zip<br>";
									$new_zip = $default_zip;
									$Text_To_Log .= "Corrected a zip code. The city and state are " . $City . ", " . $State . ". The old zip code was " . $Zip . ". The new zip code is " . $new_zip . ".";
									$Text_To_Log .= PHP_EOL;
								}
								else
								{
									//echo "city doesn't exist. leaving as it is<br>";
									$new_zip = $zip_code;
								}
								
							}
							//echo "<br>";
							//echo $new_zip;
							$Zip = $new_zip;
								
							//$Country //DEV NOTE: figure out dynamically
								
							$Phone = remove_non_numeric($Phone);
							$Phone = remove_leading_1($Phone);
							$Phone = remove_spaces($Phone);
							$Phone = get_left_10($Phone);
							if(strlen($Phone)<>10)
							{
								$Phone = "";
							}
								
							$Fax = remove_non_numeric($Fax);
							$Fax = remove_leading_1($Fax);
							$Fax = remove_spaces($Fax);
							$Fax = get_left_10($Fax);
							if(strlen($Fax)<>10)
							{
								$Fax = "";
							}

								
							//$Credit_Limit //round to 100's, no decimals or commas
							$Credit_Limit = round_to_0($Credit_Limit);
							$Credit_Limit = remove_non_numeric($Credit_Limit);
							$Credit_Limit = round_to_nearest_hundred_up($Credit_Limit);
							
							if($Credit_Limit == 0)
							{
								$Credit_Code = "COD";
							}
							else
							{
								$Credit_Code = "";
							}
								
							if($Credit_Limit == 0)
							{
								$Terms = "COD";
							}
							else
							{
								$Terms = "N10";
							}
								
							if($Exempt_Num != "")
							{
								$Tax_Jur = $State . "E";
							}
							else
							{
								//automatically validate tax code from tax_jur database table.
								$zip_code = $Zip;
								$five_digit_zip = get_left_5($zip_code);
								$result = mysqli_query($con, "SELECT * FROM tax_jur WHERE Zip_Code = '" . $five_digit_zip . "'");
								$zip_present = 0;
								$new_tax_code = "";
								while($row = mysqli_fetch_array($result))
								{
									if($row['Zip_Code'] == $five_digit_zip)
									{
										//echo "This zip code is in the database";
										$zip_present = 1;
										$new_tax_code = $row['Tax_Jur'];
									}
								}
								if($zip_present == 1)
								{
									$Tax_Jur = $new_tax_code;
									//zip code is in the database
								}
								else
								{
									$Tax_Jur = $Default_Tax_Jur;
									//zip code is not in the database
								}
								//echo "the new tax jur is " . $tax_jur . "<br>";
							}
							
							//automatically convert the salesman initials from the database table.
							$initials = $Salesman_Initials;						
							$result = mysqli_query($con, "SELECT * FROM salesman_mapping WHERE Old_Salesman = '" . $initials . "' AND Acquisition_ID = '" . $conversion_id . "'");
							$initials_present = 0;
							$new_intials = "";
							while($row = mysqli_fetch_array($result))
							{
								if($row['Old_Salesman'] == $initials)
								{
									$initials_present = 1;
									$new_initials = $row['New_Salesman'];
								}
							}
							if($initials_present == 1)
							{
								$Salesman_Initials = $new_initials;
								//salesman is in the database
							}
							else
							{
								$Salesman_Initials = $Default_Salesman_Initials;
								//salesman is not in the database
							}
							
							//automatically convert the customer type from the database table.
							$old_type = $Cust_Type;						
							$result = mysqli_query($con, "SELECT * FROM cust_type_mapping WHERE Old_Type = '" . $old_type . "' AND Acquisition_ID = '" . $conversion_id . "'");
							$type_present = 0;
							$new_type = "";
							while($row = mysqli_fetch_array($result))
							{
								if($row['Old_Type'] == $initials)
								{
									$type_present = 1;
									$new_type = $row['New_Type'];
								}
							}
							if($type_present == 1)
							{
								$Cust_Type = $new_type;
								//type is in the database
							}
							else
							{
								$Cust_Type = $Default_Cust_Type;
								//type is not in the database
							}
							
								
							if($Credit_Limit == 0)
							{
								$Alpha_Sort = "ZZZZZZZ";
							}
							else
							{
								$Alpha_Sort = $Customer_Alpha_Key;
							}
								
							if($Credit_Limit == 0)
							{
								$Status = "T";
							}
							else
							{
								$Status = "A";
							}
							
							if($Num_Of_Inv=="") 
							{ 
								if($Credit_Limit == 0)
								{
									$Num_Of_Inv = "0";
								}
								else
								{
									$Num_Of_Inv = "1";
								}
							}
							
							if($Credit_Limit == 0)
							{
								$Service_Charge = "0";
								$Verify_Checks = "Y";
							}
							else
							{
								$Service_Charge = "1.5";
								$Verify_Checks = "N";
							}
							
							$Credit_Region = remove_non_numeric($Credit_Region);
							$Credit_Region = get_left_2($Credit_Region);
							$Credit_Region = add_leading_0($Credit_Region);
							
							//sanitize the variables to prevent hacking
							$Acquisition_Customer_Number = mres($Acquisition_Customer_Number);
							$FEI_Load_Acct = mres($FEI_Load_Acct);
							$Hide_Cust = mres($Hide_Cust);
							$Customer_Alpha_Key = mres($Customer_Alpha_Key);
							$Customer_Name = mres($Customer_Name);
							$Addr_1 = mres($Addr_1);
							$Addr_2 = mres($Addr_2);
							$Addr_3 = mres($Addr_3);
							$City = mres($City);
							$State = mres($State);
							$Zip = mres($Zip);
							$Country = mres($Country);
							$Credit_Manager = mres($Credit_Manager);
							$Phone = mres($Phone);
							$Fax = mres($Fax);
							$Credit_Limit = mres($Credit_Limit);
							$Salesman_Initials = mres($Salesman_Initials);
							$Alt_Salesman_Initials = mres($Alt_Salesman_Initials);
							$Credit_Code = mres($Credit_Code);
							$Credit_Rating = mres($Credit_Rating);
							$Job_YN = mres($Job_YN);
							$Ship_Via = mres($Ship_Via);
							$Ship_Instr = mres($Ship_Instr);
							$Ship_Instr2 = mres($Ship_Instr2);
							$Ship_Instr3 = mres($Ship_Instr3);
							$Ship_Instr4 = mres($Ship_Instr4);
							$Ship_Attn = mres($Ship_Attn);
							$Ship_To_Phone = mres($Ship_To_Phone);
							$Terms = mres($Terms);
							$Tax_Jur = mres($Tax_Jur);
							$Exempt_Num = mres($Exempt_Num);
							$Sales_Contact = mres($Sales_Contact);
							$Credit_Contact = mres($Credit_Contact);
							$Service_Charge = mres($Service_Charge);
							$Branch = mres($Branch);
							$Price_Col = mres($Price_Col);
							$AR_GL_Num = mres($AR_GL_Num);
							$Job_Name_Req = mres($Job_Name_Req);
							$Cust_PO_Req = mres($Cust_PO_Req);
							$Print_LD = mres($Print_LD);
							$Print_Price = mres($Print_Price);
							$Alpha_Sort = mres($Alpha_Sort);
							$Territory = mres($Territory);
							$Corp_ID = mres($Corp_ID);
							$DUNS_Num = mres($DUNS_Num);
							$Dont_Forget = mres($Dont_Forget);
							$Status = mres($Status);
							$Delivery_Charge = mres($Delivery_Charge);
							$Accept_BO = mres($Accept_BO);
							$Min_Charge_Del = mres($Min_Charge_Del);
							$Blind_Bill = mres($Blind_Bill);
							$Sort_By_Loc = mres($Sort_By_Loc);
							$Cutoff_Days = mres($Cutoff_Days);
							$Num_Of_Inv = mres($Num_Of_Inv);
							$Cust_Type = mres($Cust_Type);
							$Personal_Guaranty = mres($Personal_Guaranty);
							$Credit_Application = mres($Credit_Application);
							$Last_Financial_Statement = mres($Last_Financial_Statement);
							$Gross_Sales = mres($Gross_Sales);
							$Net_Working_Capital = mres($Net_Working_Capital);
							$Net_Worth = mres($Net_Worth);
							$Date_In_Business = mres($Date_In_Business);
							$Last_DB_Report = mres($Last_DB_Report);
							$DB_Rating = mres($DB_Rating);
							$Credit_Region = mres($Credit_Region);
							$Controlling_Branch = mres($Controlling_Branch);
							$Reserve_Customer = mres($Reserve_Customer);
							$Print_EDI_Orders = mres($Print_EDI_Orders);
							$Cash_Receipts_Sort = mres($Cash_Receipts_Sort);
							$Ship_Complete = mres($Ship_Complete);
							$Print_Zero_Invoices = mres($Print_Zero_Invoices);
							$Print_Neg_Invoices = mres($Print_Neg_Invoices);
							$Generate_Statement = mres($Generate_Statement);
							$Generate_2nd_Statement = mres($Generate_2nd_Statement);
							$Generate_Neg_Statement = mres($Generate_Neg_Statement);
							$Generate_0_Amount_Statement = mres($Generate_0_Amount_Statement);
							$Generate_No_Activity_Statement = mres($Generate_No_Activity_Statement);
							$Credit_Score = mres($Credit_Score);
							$Affect_Demand = mres($Affect_Demand);
							$Incentive_Effective_Date = mres($Incentive_Effective_Date);
							$Incentive_Duration = mres($Incentive_Duration);
							$Claimback_Customer = mres($Claimback_Customer);
							$Generate_Invoices = mres($Generate_Invoices);
							$Generate_2nd_Invoices = mres($Generate_2nd_Invoices);
							$Statement_Seq = mres($Statement_Seq);
							$Auto_Conf = mres($Auto_Conf);
							$Associated_Info = mres($Associated_Info);
							$Labels = mres($Labels);
							$Customer_Supplier_Num = mres($Customer_Supplier_Num);
							$Customer_Prep_Day = mres($Customer_Prep_Day);
							$Review_Freight = mres($Review_Freight);
							$Customer_Ordered_By = mres($Customer_Ordered_By);
							$Use_Freight_Tables = mres($Use_Freight_Tables);
							$Ext_Price_On_Ticket = mres($Ext_Price_On_Ticket);
							$Master_Customer = mres($Master_Customer);
							$GSA_Pricing = mres($GSA_Pricing);
							$Enable_Level_3_CC_Reporting = mres($Enable_Level_3_CC_Reporting);
							$Audit_Required = mres($Audit_Required);
							$Verify_Checks = mres($Verify_Checks);
							$Price_Roudning = mres($Price_Roudning);
							$Nearest_Decimal = mres($Nearest_Decimal);
							$Round_Minimum_Up = mres($Round_Minimum_Up);
							$Round_Contract_Price = mres($Round_Contract_Price);
							$Show_Price = mres($Show_Price);
							$Secondary_Salesman = mres($Secondary_Salesman);
							$Percent_If_Secondary_Salesman = mres($Percent_If_Secondary_Salesman);

							
							//check to make sure that this customer is not already in the database
							$customer_already_present = 0;
							$result = mysqli_query($con, "SELECT * FROM customer_lists WHERE Acquisition_Customer_Number = '" . $Acquisition_Customer_Number . "'");
								
							while($row = mysqli_fetch_array($result))
							{
								if($row['Acquisition_Customer_Number'] == $Acquisition_Customer_Number)
								{
									//echo "This customer is already present in the customer list!";
									$customer_already_present = 1;
								}
							}	
							
							if($customer_already_present == 0) //if the customer isn't in the database then insert it
							{
								//echo "Add this customer to this database";
							
								//insert the data into the customer_lists table of the database
								//insert values into database
								$sql="INSERT INTO customer_lists
								(
								Conversion_ID,
								Date_Inserted,
								Acquisition_Customer_Number,
								FEI_Load_Acct,
								Hide_Cust,
								Customer_Alpha_Key,
								Customer_Name,
								Addr_1,
								Addr_2,
								Addr_3,
								City,
								State,
								Zip,
								Country,
								Credit_Manager,
								Phone,
								Fax,
								Credit_Limit,
								Salesman_Initials,
								Alt_Salesman_Initials,
								Credit_Code,
								Credit_Rating,
								Job_YN,
								Ship_Via,
								Ship_Instr,
								Ship_Instr2,
								Ship_Instr3,
								Ship_Instr4,
								Ship_Attn,
								Ship_To_Phone,
								Terms,
								Tax_Jur,
								Exempt_Num,
								Sales_Contact,
								Credit_Contact,
								Service_Charge,
								Branch,
								Price_Col,
								AR_GL_Num,
								Job_Name_Req,
								Cust_PO_Req,
								Print_LD,
								Print_Price,
								Alpha_Sort,
								Territory,
								Corp_ID,
								DUNS_Num,
								Dont_Forget,
								Status,
								Delivery_Charge,
								Accept_BO,
								Min_Charge_Del,
								Blind_Bill,
								Sort_By_Loc,
								Cutoff_Days,
								Num_Of_Inv,
								Cust_Type,
								Personal_Guaranty,
								Credit_Application,
								Last_Financial_Statement,
								Gross_Sales,
								Net_Working_Capital,
								Net_Worth,
								Date_In_Business,
								Last_DB_Report,
								DB_Rating,
								Credit_Region,
								Controlling_Branch,
								Reserve_Customer,
								Print_EDI_Orders,
								Cash_Receipts_Sort,
								Ship_Complete,
								Print_Zero_Invoices,
								Print_Neg_Invoices,
								Generate_Statement,
								Generate_2nd_Statement,
								Generate_Neg_Statement,
								Generate_0_Amount_Statement,
								Generate_No_Activity_Statement,
								Credit_Score,
								Affect_Demand,
								Incentive_Effective_Date,
								Incentive_Duration,
								Claimback_Customer,
								Generate_Invoices,
								Generate_2nd_Invoices,
								Statement_Seq,
								Auto_Conf,
								Associated_Info,
								Labels,
								Customer_Supplier_Num,
								Customer_Prep_Day,
								Review_Freight,
								Customer_Ordered_By,
								Use_Freight_Tables,
								Ext_Price_On_Ticket,
								Master_Customer,
								GSA_Pricing,
								Enable_Level_3_CC_Reporting,
								Audit_Required,
								Verify_Checks,
								Price_Roudning,
								Nearest_Decimal,
								Round_Minimum_Up,
								Round_Contract_Price,
								Show_Price,
								Secondary_Salesman,
								Percent_If_Secondary_Salesman
								)
								VALUES
								(
								'$conversion_id',
								'$today',
								'$Acquisition_Customer_Number',
								'$FEI_Load_Acct',
								'$Hide_Cust',
								'$Customer_Alpha_Key',
								'$Customer_Name',
								'$Addr_1',
								'$Addr_2',
								'$Addr_3',
								'$City',
								'$State',
								'$Zip',
								'$Country',
								'$Credit_Manager',
								'$Phone',
								'$Fax',
								'$Credit_Limit',
								'$Salesman_Initials',
								'$Alt_Salesman_Initials',
								'$Credit_Code',
								'$Credit_Rating',
								'$Job_YN',
								'$Ship_Via',
								'$Ship_Instr',
								'$Ship_Instr2',
								'$Ship_Instr3',
								'$Ship_Instr4',
								'$Ship_Attn',
								'$Ship_To_Phone',
								'$Terms',
								'$Tax_Jur',
								'$Exempt_Num',
								'$Sales_Contact',
								'$Credit_Contact',
								'$Service_Charge',
								'$Branch',
								'$Price_Col',
								'$AR_GL_Num',
								'$Job_Name_Req',
								'$Cust_PO_Req',
								'$Print_LD',
								'$Print_Price',
								'$Alpha_Sort',
								'$Territory',
								'$Corp_ID',
								'$DUNS_Num',
								'$Dont_Forget',
								'$Status',
								'$Delivery_Charge',
								'$Accept_BO',
								'$Min_Charge_Del',
								'$Blind_Bill',
								'$Sort_By_Loc',
								'$Cutoff_Days',
								'$Num_Of_Inv',
								'$Cust_Type',
								'$Personal_Guaranty',
								'$Credit_Application',
								'$Last_Financial_Statement',
								'$Gross_Sales',
								'$Net_Working_Capital',
								'$Net_Worth',
								'$Date_In_Business',
								'$Last_DB_Report',
								'$DB_Rating',
								'$Credit_Region',
								'$Controlling_Branch',
								'$Reserve_Customer',
								'$Print_EDI_Orders',
								'$Cash_Receipts_Sort',
								'$Ship_Complete',
								'$Print_Zero_Invoices',
								'$Print_Neg_Invoices',
								'$Generate_Statement',
								'$Generate_2nd_Statement',
								'$Generate_Neg_Statement',
								'$Generate_0_Amount_Statement',
								'$Generate_No_Activity_Statement',
								'$Credit_Score',
								'$Affect_Demand',
								'$Incentive_Effective_Date',
								'$Incentive_Duration',
								'$Claimback_Customer',
								'$Generate_Invoices',
								'$Generate_2nd_Invoices',
								'$Statement_Seq',
								'$Auto_Conf',
								'$Associated_Info',
								'$Labels',
								'$Customer_Supplier_Num',
								'$Customer_Prep_Day',
								'$Review_Freight',
								'$Customer_Ordered_By',
								'$Use_Freight_Tables',
								'$Ext_Price_On_Ticket',
								'$Master_Customer',
								'$GSA_Pricing',
								'$Enable_Level_3_CC_Reporting',
								'$Audit_Required',
								'$Verify_Checks',
								'$Price_Roudning',
								'$Nearest_Decimal',
								'$Round_Minimum_Up',
								'$Round_Contract_Price',
								'$Show_Price',
								'$Secondary_Salesman',
								'$Percent_If_Secondary_Salesman'
								)";
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
								
								//save text to Text_To_Write
								
								//DEV NOTE: DOUBLE CHECK THIS ORDER
								$Text_To_Write .= '"' . $Acquisition_Customer_Number . '",';
								$Text_To_Write .= '"' . $FEI_Load_Acct . '",';
								$Text_To_Write .= '"' . $Acquisition_Customer_Number . '",';
								$Text_To_Write .= ",";//Acq ID Number
								$Text_To_Write .= '"' . $Hide_Cust . '",';
								$Text_To_Write .= '"' . $Customer_Alpha_Key . '",';
								$Text_To_Write .= '"' . $Customer_Name . '",';
								$Text_To_Write .= '"' . $Addr_1 . '",';
								$Text_To_Write .= '"' . $Addr_2 . '",';
								$Text_To_Write .= '"' . $Addr_3 . '",';
								$Text_To_Write .= '"' . $City . '",';
								$Text_To_Write .= '"' . $State . '",';
								$Text_To_Write .= '"' . $Zip . '",';
								$Text_To_Write .= '"' . $Country . '",';
								$Text_To_Write .= '"' . $Credit_Manager . '",';
								$Text_To_Write .= '"' . $Phone . '",';
								$Text_To_Write .= '"' . $Fax . '",';
								$Text_To_Write .= '"' . $Credit_Limit . '",';
								$Text_To_Write .= '"' . $Salesman_Initials . '",';
								$Text_To_Write .= '"' . $Alt_Salesman_Initials . '",';
								$Text_To_Write .= '"' . $Credit_Code . '",';
								$Text_To_Write .= '"' . $Credit_Rating . '",';
								$Text_To_Write .= '"' . $Job_YN . '",';
								$Text_To_Write .= '"' . $Ship_Via . '",';
								$Text_To_Write .= '"' . $Ship_Instr . '",';
								$Text_To_Write .= '"' . $Ship_Instr2 . '",';
								$Text_To_Write .= '"' . $Ship_Instr3 . '",';
								$Text_To_Write .= '"' . $Ship_Instr4 . '",';
								$Text_To_Write .= '"' . $Ship_Attn . '",';
								$Text_To_Write .= '"' . $Ship_To_Phone . '",';
								$Text_To_Write .= '"' . $Terms . '",';
								$Text_To_Write .= '"' . $Tax_Jur . '",';
								$Text_To_Write .= '"' . $Exempt_Num . '",';
								$Text_To_Write .= '"' . $Sales_Contact . '",';
								$Text_To_Write .= '"' . $Credit_Contact . '",';
								$Text_To_Write .= '"' . $Service_Charge . '",';
								$Text_To_Write .= '"' . $Branch . '",';
								$Text_To_Write .= '"' . $Price_Col . '",';
								$Text_To_Write .= '"' . $AR_GL_Num . '",';
								$Text_To_Write .= '"' . $Job_Name_Req . '",';
								$Text_To_Write .= '"' . $Cust_PO_Req . '",';
								$Text_To_Write .= '"' . $Print_LD . '",';
								$Text_To_Write .= '"' . $Print_Price . '",';
								$Text_To_Write .= '"' . $Alpha_Sort . '",';
								$Text_To_Write .= '"' . $Territory . '",';
								$Text_To_Write .= '"' . $Corp_ID . '",';
								$Text_To_Write .= '"' . $DUNS_Num . '",';
								$Text_To_Write .= '"' . $Dont_Forget . '",';
								$Text_To_Write .= '"' . $Status . '",';
								$Text_To_Write .= '"' . $Delivery_Charge . '",';
								$Text_To_Write .= '"' . $Accept_BO . '",';
								$Text_To_Write .= '"' . $Min_Charge_Del . '",';
								$Text_To_Write .= '"' . $Blind_Bill . '",';
								$Text_To_Write .= '"' . $Sort_By_Loc . '",';
								$Text_To_Write .= '"' . $Cutoff_Days . '",';
								$Text_To_Write .= '"' . $Num_Of_Inv . '",';
								$Text_To_Write .= '"' . $Cust_Type . '",';
								$Text_To_Write .= '"' . $Personal_Guaranty . '",';
								$Text_To_Write .= '"' . $Credit_Application . '",';
								$Text_To_Write .= '"' . $Last_Financial_Statement . '",';
								$Text_To_Write .= '"' . $Gross_Sales . '",';
								$Text_To_Write .= '"' . $Net_Working_Capital . '",';
								$Text_To_Write .= '"' . $Net_Worth . '",';
								$Text_To_Write .= '"' . $Date_In_Business . '",';
								$Text_To_Write .= '"' . $Last_DB_Report . '",';
								$Text_To_Write .= '"' . $DB_Rating . '",';
								$Text_To_Write .= '"' . $Credit_Region . '",';
								$Text_To_Write .= '"' . $Controlling_Branch . '",';
								$Text_To_Write .= '"' . $Reserve_Customer . '",';
								$Text_To_Write .= '"' . $Print_EDI_Orders . '",';
								$Text_To_Write .= '"' . $Cash_Receipts_Sort . '",';
								$Text_To_Write .= '"' . $Ship_Complete . '",';
								$Text_To_Write .= '"' . $Print_Zero_Invoices . '",';
								$Text_To_Write .= '"' . $Print_Neg_Invoices . '",';
								$Text_To_Write .= '"' . $Generate_Statement . '",';
								$Text_To_Write .= '"' . $Generate_2nd_Statement . '",';
								$Text_To_Write .= '"' . $Generate_Neg_Statement . '",';
								$Text_To_Write .= '"' . $Generate_0_Amount_Statement . '",';
								$Text_To_Write .= '"' . $Generate_No_Activity_Statement . '",';
								$Text_To_Write .= '"' . $Credit_Score . '",';
								$Text_To_Write .= '"' . $Affect_Demand . '",';
								$Text_To_Write .= '"' . $Incentive_Effective_Date . '",';
								$Text_To_Write .= '"' . $Incentive_Duration . '",';
								$Text_To_Write .= '"' . $Claimback_Customer . '",';
								$Text_To_Write .= '"' . $Generate_Invoices . '",';
								$Text_To_Write .= '"' . $Generate_2nd_Invoices . '",';
								$Text_To_Write .= '"' . $Statement_Seq . '",';
								$Text_To_Write .= '"' . $Auto_Conf . '",';
								$Text_To_Write .= '"' . $Associated_Info . '",';
								$Text_To_Write .= '"' . $Labels . '",';
								$Text_To_Write .= '"' . $Customer_Supplier_Num . '",';
								$Text_To_Write .= '"' . $Customer_Prep_Day . '",';
								$Text_To_Write .= '"' . $Review_Freight . '",';
								$Text_To_Write .= '"' . $Customer_Ordered_By . '",';
								$Text_To_Write .= '"' . $Use_Freight_Tables . '",';
								$Text_To_Write .= '"' . $Ext_Price_On_Ticket . '",';
								$Text_To_Write .= '"' . $Master_Customer . '",';
								$Text_To_Write .= '"' . $GSA_Pricing . '",';
								$Text_To_Write .= '"' . $Enable_Level_3_CC_Reporting . '",';
								$Text_To_Write .= '"' . $Audit_Required . '",';
								$Text_To_Write .= '"' . $Verify_Checks . '",';
								$Text_To_Write .= '"' . $Price_Roudning . '",';
								$Text_To_Write .= '"' . $Nearest_Decimal . '",';
								$Text_To_Write .= '"' . $Round_Minimum_Up . '",';
								$Text_To_Write .= '"' . $Round_Contract_Price . '",';
								$Text_To_Write .= '"' . $Show_Price . '",';
									
								$Text_To_Write .= ","; //field 91...
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ","; //field 92...
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								$Text_To_Write .= ",";
								
								$Text_To_Write .= '"' . $Secondary_Salesman . '",';
								$Text_To_Write .= '"' . $Percent_If_Secondary_Salesman . '",';
								$Text_To_Write .= PHP_EOL;
							
							}//if customer is not already in the DB
						
						}//if not header row
						
						$file_row_counter = $file_row_counter + 1;
							
					}//while reading the file
					fclose($handle);
						
				}//if connected to the database
					
				
			}//if the file opened
			
			//echo $Text_To_Write;
			//echo "</div>";
			
			//write text to file - add a unique ID at end
			$random_id = md5($today);
			
			$new_filename = "customer_report_" . convert_timestamp($today) . ".csv";
			$handle = fopen (($new_filename), "w");
			fwrite($handle, $Text_To_Write);
			fclose ($handle);
			
			$new_filename_log = "conversion_log_" . convert_timestamp($today) . ".txt";
			$handle = fopen (($new_filename_log), "w");
			fwrite($handle, $Text_To_Log);
			fclose ($handle);
			
			//display a link to download the new file
			echo "<br>";
			echo "<a href='" . $new_filename . "?id=" . $random_id . "'>Click here to download your new file!</a><br>";
			
			//display a link to download the new log
			echo "<a href='" . $new_filename_log . "?id=" . $random_id . "' target='_blank'>Click here to download a log of important changes.</a><br>";
			
		}//if there is not a file error
		
	}//if size and extension are allowed
	
}//if a file was submitted
else
{
	echo "ERROR: No file was received!";
}
?>
<br>
<a href="index.html">Click here to return to the main menu</a>
</body>
</html>