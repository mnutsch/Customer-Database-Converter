<html>
<head>
<title>Acquisition Customer File Automation</title>
</head>
<body>
<h2>Download Customer File</h2>
<?php

function mres($value) //this function prevents the website from getting hacked through sql injection
{
	$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
	$replace = array("\\\\", "\\0", "\\n", "\\r", "", '', "\\Z");

	return str_replace($search, $replace, $value);
}

function convert_timestamp($value)
{
	$value = str_replace(" ", "_", $value);
	$value = str_replace(":", "-", $value);
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

//header row
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
	
		//get the conversion template settings info from the database
		$result = mysqli_query($con, "SELECT * FROM customer_lists WHERE Conversion_ID = '" . $conversion_id . "'");
	
		while($row = mysqli_fetch_array($result))
		{
			//add the results to the text to write
			$Text_To_Write .= '"' . $row['Acquisition_Customer_Number'] . '",';
			$Text_To_Write .= '"' . $row['FEI_Load_Acct'] . '",';
			$Text_To_Write .= '"' . $row['Acquisition_Customer_Number'] . '",';
			$Text_To_Write .= ',';
			$Text_To_Write .= '"' . $row['Hide_Cust'] . '",';
			$Text_To_Write .= '"' . $row['Customer_Alpha_Key'] . '",';
			$Text_To_Write .= '"' . $row['Customer_Name'] . '",';
			$Text_To_Write .= '"' . $row['Addr_1'] . '",';
			$Text_To_Write .= '"' . $row['Addr_2'] . '",';
			$Text_To_Write .= '"' . $row['Addr_3'] . '",';
			$Text_To_Write .= '"' . $row['City'] . '",';
			$Text_To_Write .= '"' . $row['State'] . '",';
			$Text_To_Write .= '"' . $row['Zip'] . '",';
			$Text_To_Write .= '"' . $row['Country'] . '",';
			$Text_To_Write .= '"' . $row['Credit_Manager'] . '",';
			$Text_To_Write .= '"' . $row['Phone'] . '",';
			$Text_To_Write .= '"' . $row['Fax'] . '",';
			$Text_To_Write .= '"' . $row['Credit_Limit'] . '",';
			$Text_To_Write .= '"' . $row['Salesman_Initials'] . '",';
			$Text_To_Write .= '"' . $row['Alt_Salesman_Initials'] . '",';
			$Text_To_Write .= '"' . $row['Credit_Code'] . '",';
			$Text_To_Write .= '"' . $row['Credit_Rating'] . '",';
			$Text_To_Write .= '"' . $row['Job_YN'] . '",';
			$Text_To_Write .= '"' . $row['Ship_Via'] . '",';
			$Text_To_Write .= '"' . $row['Ship_Instr'] . '",';
			$Text_To_Write .= '"' . $row['Ship_Instr2'] . '",';
			$Text_To_Write .= '"' . $row['Ship_Instr3'] . '",';
			$Text_To_Write .= '"' . $row['Ship_Instr4'] . '",';
			$Text_To_Write .= '"' . $row['Ship_Attn'] . '",';
			$Text_To_Write .= '"' . $row['Ship_To_Phone'] . '",';
			$Text_To_Write .= '"' . $row['Terms'] . '",';
			$Text_To_Write .= '"' . $row['Tax_Jur'] . '",';
			$Text_To_Write .= '"' . $row['Exempt_Num'] . '",';
			$Text_To_Write .= '"' . $row['Sales_Contact'] . '",';
			$Text_To_Write .= '"' . $row['Credit_Contact'] . '",';
			$Text_To_Write .= '"' . $row['Service_Charge'] . '",';
			$Text_To_Write .= '"' . $row['Branch'] . '",';
			$Text_To_Write .= '"' . $row['Price_Col'] . '",';
			$Text_To_Write .= '"' . $row['AR_GL_Num'] . '",';
			$Text_To_Write .= '"' . $row['Job_Name_Req'] . '",';
			$Text_To_Write .= '"' . $row['Cust_PO_Req'] . '",';
			$Text_To_Write .= '"' . $row['Print_LD'] . '",';
			$Text_To_Write .= '"' . $row['Print_Price'] . '",';
			$Text_To_Write .= '"' . $row['Alpha_Sort'] . '",';
			$Text_To_Write .= '"' . $row['Territory'] . '",';
			$Text_To_Write .= '"' . $row['Corp_ID'] . '",';
			$Text_To_Write .= '"' . $row['DUNS_Num'] . '",';
			$Text_To_Write .= '"' . $row['Dont_Forget'] . '",';
			$Text_To_Write .= '"' . $row['Status'] . '",';
			$Text_To_Write .= '"' . $row['Delivery_Charge'] . '",';
			$Text_To_Write .= '"' . $row['Accept_BO'] . '",';
			$Text_To_Write .= '"' . $row['Min_Charge_Del'] . '",';
			$Text_To_Write .= '"' . $row['Blind_Bill'] . '",';
			$Text_To_Write .= '"' . $row['Sort_By_Loc'] . '",';
			$Text_To_Write .= '"' . $row['Cutoff_Days'] . '",';
			$Text_To_Write .= '"' . $row['Num_Of_Inv'] . '",';
			$Text_To_Write .= '"' . $row['Cust_Type'] . '",';
			$Text_To_Write .= '"' . $row['Personal_Guaranty'] . '",';
			$Text_To_Write .= '"' . $row['Credit_Application'] . '",';
			$Text_To_Write .= '"' . $row['Last_Financial_Statement'] . '",';
			$Text_To_Write .= '"' . $row['Gross_Sales'] . '",';
			$Text_To_Write .= '"' . $row['Net_Working_Capital'] . '",';
			$Text_To_Write .= '"' . $row['Net_Worth'] . '",';
			$Text_To_Write .= '"' . $row['Date_In_Business'] . '",';
			$Text_To_Write .= '"' . $row['Last_DB_Report'] . '",';
			$Text_To_Write .= '"' . $row['DB_Rating'] . '",';
			$Text_To_Write .= '"' . $row['Credit_Region'] . '",';
			$Text_To_Write .= '"' . $row['Controlling_Branch'] . '",';
			$Text_To_Write .= '"' . $row['Reserve_Customer'] . '",';
			$Text_To_Write .= '"' . $row['Print_EDI_Orders'] . '",';
			$Text_To_Write .= '"' . $row['Cash_Receipts_Sort'] . '",';
			$Text_To_Write .= '"' . $row['Ship_Complete'] . '",';
			$Text_To_Write .= '"' . $row['Print_Zero_Invoices'] . '",';
			$Text_To_Write .= '"' . $row['Print_Neg_Invoices'] . '",';
			$Text_To_Write .= '"' . $row['Generate_Statement'] . '",';
			$Text_To_Write .= '"' . $row['Generate_2nd_Statement'] . '",';
			$Text_To_Write .= '"' . $row['Generate_Neg_Statement'] . '",';
			$Text_To_Write .= '"' . $row['Generate_0_Amount_Statement'] . '",';
			$Text_To_Write .= '"' . $row['Generate_No_Activity_Statement'] . '",';
			$Text_To_Write .= '"' . $row['Credit_Score'] . '",';
			$Text_To_Write .= '"' . $row['Affect_Demand'] . '",';
			$Text_To_Write .= '"' . $row['Incentive_Effective_Date'] . '",';
			$Text_To_Write .= '"' . $row['Incentive_Duration'] . '",';
			$Text_To_Write .= '"' . $row['Claimback_Customer'] . '",';
			$Text_To_Write .= '"' . $row['Generate_Invoices'] . '",';
			$Text_To_Write .= '"' . $row['Generate_2nd_Invoices'] . '",';
			$Text_To_Write .= '"' . $row['Statement_Seq'] . '",';
			$Text_To_Write .= '"' . $row['Auto_Conf'] . '",';
			$Text_To_Write .= '"' . $row['Associated_Info'] . '",';
			$Text_To_Write .= '"' . $row['Labels'] . '",';
			$Text_To_Write .= '"' . $row['Customer_Supplier_Num'] . '",';
			$Text_To_Write .= '"' . $row['Customer_Prep_Day'] . '",';
			$Text_To_Write .= '"' . $row['Review_Freight'] . '",';
			$Text_To_Write .= '"' . $row['Customer_Ordered_By'] . '",';
			$Text_To_Write .= '"' . $row['Use_Freight_Tables'] . '",';
			$Text_To_Write .= '"' . $row['Ext_Price_On_Ticket'] . '",';
			$Text_To_Write .= '"' . $row['Master_Customer'] . '",';
			$Text_To_Write .= '"' . $row['GSA_Pricing'] . '",';
			$Text_To_Write .= '"' . $row['Enable_Level_3_CC_Reporting'] . '",';
			$Text_To_Write .= '"' . $row['Audit_Required'] . '",';
			$Text_To_Write .= '"' . $row['Verify_Checks'] . '",';
			$Text_To_Write .= '"' . $row['Price_Roudning'] . '",';
			$Text_To_Write .= '"' . $row['Nearest_Decimal'] . '",';
			$Text_To_Write .= '"' . $row['Round_Minimum_Up'] . '",';
			$Text_To_Write .= '"' . $row['Round_Contract_Price'] . '",';
			$Text_To_Write .= '"' . $row['Show_Price'] . '",';
			
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
			
			$Text_To_Write .= '"' . $row['Secondary_Salesman'] . '",';
			$Text_To_Write .= '"' . $row['Percent_If_Secondary_Salesman'] . '",';
			$Text_To_Write .= PHP_EOL;
			
		}
		
		//close the database
		mysqli_close($con);
		
		//write text to file - add a unique ID at end
		$random_id = md5($today);
			
		$new_filename = "customer_report_" . convert_timestamp($today) . ".csv";
			
		$handle = fopen (($new_filename), "w");
		fwrite($handle, $Text_To_Write);
		fclose ($handle);
			
		//display a link to download the new file
		echo "<br>";
		echo "<a href='" . $new_filename . "?id=" . $random_id . "'>Click here to download your new file!</a><br>";
		
	}//if connected
}//if id sent
else
{
	echo "ERROR: no conversion ID was received.";
}

?>
<br>
<a href="index.html">Click here to return to the main menu</a>
</body>
</html>