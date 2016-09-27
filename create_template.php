<html>
<head>
<title>Acquisition Customer File Automation</title>
</head>
<h2>Create Template</h2>

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
				echo "<form action='process_create_template.php' method='post'>";
				
				//name of conversion
				echo "<h4>Basic Details</h4>";
				echo "<ol>";
				echo "<li><label for='conversion_name'>Name of Conversion:</label><br><input type='text' name='conversion_name' id='conversion_name' value='" . $today . "'></li><br>";
				echo "</ol>";
				echo "<hr>";
				//default values
				echo "<h4>Default Values</h4>";
				echo "<ol>";
				//echo "<li><label for='Acquisition_Customer_Number'>Acquisition_Customer_Number:</label><br><input type='text' name='Acquisition_Customer_Number' id= 'Acquisition_Customer_Number'></li><br>";
				//echo "<li><label for='FEI_Load_Acct'>FEI_Load_Acct:</label><br><input type='text' name='FEI_Load_Acct' id= 'FEI_Load_Acct'></li><br>";
				//echo "<li><label for='Customer_Alpha_Key'>Customer_Alpha_Key:</label><br><input type='text' name='Customer_Alpha_Key' id= 'Customer_Alpha_Key'></li><br>";
				echo "<li><label for='Customer_Name'>Customer_Name:</label><br><input type='text' name='Customer_Name' id= 'Customer_Name'></li><br>";
				//echo "<li><label for='Hide_Cust'>Hide_Cust:</label><br><input type='text' name='Hide_Cust' id= 'Hide_Cust'></li><br>";
				echo "<li><label for='Addr_1'>Addr_1:</label><br><input type='text' name='Addr_1' id= 'Addr_1'></li><br>";
				//echo "<li><label for='Addr_2'>Addr_2:</label><br><input type='text' name='Addr_2' id= 'Addr_2'></li><br>";
				//echo "<li><label for='Addr_3'>Addr_3:</label><br><input type='text' name='Addr_3' id= 'Addr_3'></li><br>";
				echo "<li><label for='City'>City:</label><br><input type='text' name='City' id= 'City'></li><br>";
				echo "<li><label for='State'>State:</label><br><input type='text' name='State' id= 'State'></li><br>";
				echo "<li><label for='Zip'>Zip:</label><br><input type='text' name='Zip' id= 'Zip'></li><br>";
				echo "<li><label for='Country'>Country:</label><br><input type='text' value='US' name='Country' id= 'Country'></li><br>";
				echo "<li><label for='Credit_Manager'>Credit_Manager:</label><br><input type='text' name='Credit_Manager' id= 'Credit_Manager'></li><br>";
				echo "<li><label for='Phone'>Phone:</label><br><input type='text' name='Phone' id= 'Phone'></li><br>";
				echo "<li><label for='Fax'>Fax:</label><br><input type='text' name='Fax' id= 'Fax'></li><br>";
				echo "<li><label for='Credit_Limit'>Credit_Limit:</label><br><input type='text' value='0' name='Credit_Limit' id= 'Credit_Limit'></li><br>";
				echo "<li><label for='Salesman_Initials'>Salesman_Initials:</label><br><input type='text' name='Salesman_Initials' id= 'Salesman_Initials'></li><br>";
				echo "<li><label for='Alt_Salesman_Initials'>Alt_Salesman_Initials:</label><br><input type='text' name='Alt_Salesman_Initials' id= 'Alt_Salesman_Initials'></li><br>";
				//echo "<li><label for='Credit_Code'>Credit_Code:</label><br><input type='text' name='Credit_Code' id= 'Credit_Code'></li><br>";
				echo "<li><label for='Credit_Rating'>Credit_Rating:</label><br><input type='text' value='CCC' name='Credit_Rating' id= 'Credit_Rating'></li><br>";
				echo "<li><label for='Job_YN'>Job_YN:</label><br><input type='text' name='Job_YN' value='N' id= 'Job_YN'></li><br>";
				//echo "<li><label for='Ship_Via'>Ship_Via:</label><br><input type='text' name='Ship_Via' id= 'Ship_Via'></li><br>";
				//echo "<li><label for='Ship_Instr'>Ship_Instr:</label><br><input type='text' name='Ship_Instr' id= 'Ship_Instr'></li><br>";
				//echo "<li><label for='Ship_Instr2'>Ship_Instr2:</label><br><input type='text' name='Ship_Instr2' id= 'Ship_Instr2'></li><br>";
				//echo "<li><label for='Ship_Instr3'>Ship_Instr3:</label><br><input type='text' name='Ship_Instr3' id= 'Ship_Instr3'></li><br>";
				//echo "<li><label for='Ship_Instr4'>Ship_Instr4:</label><br><input type='text' name='Ship_Instr4' id= 'Ship_Instr4'></li><br>";
				//echo "<li><label for='Ship_Attn'>Ship_Attn:</label><br><input type='text' name='Ship_Attn' id= 'Ship_Attn'></li><br>";
				//echo "<li><label for='Ship_To_Phone'>Ship_To_Phone:</label><br><input type='text' name='Ship_To_Phone' id= 'Ship_To_Phone'></li><br>";
				echo "<li><label for='Terms'>Terms:</label><br><input type='text' value='COD' name='Terms' id= 'Terms'></li><br>";
				echo "<li><label for='Tax_Jur'>Tax_Jur:</label><br><input type='text' name='Tax_Jur' id= 'Tax_Jur'></li><br>";
				echo "<li><label for='Exempt_Num'>Exempt_Num:</label><br><input type='text' name='Exempt_Num' id= 'Exempt_Num'></li><br>";
				echo "<li><label for='Sales_Contact'>Sales_Contact:</label><br><input type='text' name='Sales_Contact' id= 'Sales_Contact'></li><br>";
				echo "<li><label for='Credit_Contact'>Credit_Contact:</label><br><input type='text' name='Credit_Contact' id= 'Credit_Contact'></li><br>";
				//echo "<li><label for='Service_Charge'>Service_Charge:</label><br><input type='text' value='0' name='Service_Charge' id= 'Service_Charge'></li><br>";
				echo "<li><label for='Branch'>Branch:</label><br><input type='text' name='Branch' id= 'Branch'></li><br>";
				echo "<li><label for='Price_Col'>Price_Col:</label><br><input type='text' name='Price_Col' id= 'Price_Col'></li><br>";
				echo "<li><label for='AR_GL_Num'>AR_GL_Num:</label><br><input type='text' name='AR_GL_Num' value='1300' id= 'AR_GL_Num'></li><br>";
				echo "<li><label for='Job_Name_Req'>Job_Name_Req:</label><br><input type='text' value='Y' name='Job_Name_Req' id= 'Job_Name_Req'></li><br>";
				echo "<li><label for='Cust_PO_Req'>Cust_PO_Req:</label><br><input type='text' value='N' name='Cust_PO_Req' id= 'Cust_PO_Req'></li><br>";
				echo "<li><label for='Print_LD'>Print_LD:</label><br><input type='text' name='Print_LD' id= 'Print_LD'></li><br>";
				echo "<li><label for='Print_Price'>Print_Price:</label><br><input type='text' name='Print_Price' id= 'Print_Price'></li><br>";
				echo "<li><label for='Alpha_Sort'>Alpha_Sort:</label><br><input type='text' name='Alpha_Sort' id= 'Alpha_Sort'></li><br>";
				//echo "<li><label for='Territory'>Territory:</label><br><input type='text' name='Territory' id= 'Territory'></li><br>";
				//echo "<li><label for='Corp_ID'>Corp_ID:</label><br><input type='text' name='Corp_ID' id= 'Corp_ID'></li><br>";
				//echo "<li><label for='DUNS_Num'>DUNS_Num:</label><br><input type='text' name='DUNS_Num' id= 'DUNS_Num'></li><br>";
				echo "<li><label for='Dont_Forget'>Dont_Forget:</label><br><input type='text' name='Dont_Forget' id= 'Dont_Forget'></li><br>";
				//echo "<li><label for='Status'>Status:</label><br><input type='text' name='Status' id= 'Status'></li><br>";
				echo "<li><label for='Delivery_Charge'>Delivery_Charge:</label><br><input type='text' value='N' name='Delivery_Charge' id= 'Delivery_Charge'></li><br>";
				echo "<li><label for='Accept_BO'>Accept_BO:</label><br><input type='text' value='Y' name='Accept_BO' id= 'Accept_BO'></li><br>";
				echo "<li><label for='Min_Charge_Del'>Min_Charge_Del:</label><br><input type='text' name='Min_Charge_Del' id= 'Min_Charge_Del'></li><br>";
				echo "<li><label for='Blind_Bill'>Blind_Bill:</label><br><input type='text' name='Blind_Bill' id= 'Blind_Bill'></li><br>";
				echo "<li><label for='Sort_By_Loc'>Sort_By_Loc:</label><br><input type='text' value='N' name='Sort_By_Loc' id= 'Sort_By_Loc'></li><br>";
				echo "<li><label for='Cutoff_Days'>Cutoff_Days:</label><br><input type='text' name='Cutoff_Days' id= 'Cutoff_Days'></li><br>";
				//echo "<li><label for='Num_Of_Inv'>Num_Of_Inv:</label><br><input type='text' value='1' name='Num_Of_Inv' id= 'Num_Of_Inv'></li><br>";
				echo "<li><label for='Cust_Type'>Cust_Type:</label><br><input type='text' value='E_ENDUSER' name='Cust_Type' id= 'Cust_Type'></li><br>";
				echo "<li><label for='Personal_Guaranty'>Personal_Guaranty:</label><br><input type='text' value='N' name='Personal_Guaranty' id= 'Personal_Guaranty'></li><br>";
				echo "<li><label for='Credit_Application'>Credit_Application:</label><br><input type='text' value='N' name='Credit_Application' id= 'Credit_Application'></li><br>";
				//echo "<li><label for='Last_Financial_Statement'>Last_Financial_Statement:</label><br><input type='text' name='Last_Financial_Statement' id= 'Lase_Financial_Statement'></li><br>";
				//echo "<li><label for='Gross_Sales'>Gross_Sales:</label><br><input type='text' name='Gross_Sales' id= 'Gross_Sales'></li><br>";
				//echo "<li><label for='Net_Working_Capital'>Net_Working_Capital:</label><br><input type='text' name='Net_Working_Capital' id= 'Net_Working_Capital'></li><br>";
				//echo "<li><label for='Net_Worth'>Net_Worth:</label><br><input type='text' name='Net_Worth' id= 'Net_Worth'></li><br>";
				echo "<li><label for='Date_In_Business'>Date_In_Business:</label><br><input type='text' name='Date_In_Business' id= 'Date_In_Business'></li><br>";
				//echo "<li><label for='Last_DB_Report'>Last_DB_Report:</label><br><input type='text' name='Last_DB_Report' id= 'Last_DB_Report'></li><br>";
				//echo "<li><label for='DB_Rating'>DB_Rating:</label><br><input type='text' name='DB_Rating' id= 'DB_Rating'></li><br>";
				echo "<li><label for='Credit_Region'>Credit_Region:</label><br><input type='text' name='Credit_Region' id= 'Credit_Region'></li><br>";
				echo "<li><label for='Controlling_Branch'>Controlling_Branch:</label><br><input type='text' name='Controlling_Branch' id= 'Controlling_Branch'></li><br>";
				echo "<li><label for='Reserve_Customer'>Reserve_Customer:</label><br><input type='text' value='N' name='Reserve_Customer' id= 'Reserve_Customer'></li><br>";
				echo "<li><label for='Print_EDI_Orders'>Print_EDI_Orders:</label><br><input type='text' name='Print_EDI_Orders' id= 'Print_EDI_Orders'></li><br>";
				echo "<li><label for='Cash_Receipts_Sort'>Cash_Receipts_Sort:</label><br><input type='text' name='Cash_Receipts_Sort' value='JD' id= 'Cash_Receipts_Sort'></li><br>";
				echo "<li><label for='Ship_Complete'>Ship_Complete:</label><br><input type='text' name='Ship_Complete' value='N' id= 'Ship_Complete'></li><br>";
				echo "<li><label for='Print_Zero_Invoices'>Print_Zero_Invoices:</label><br><input type='text' name='Print_Zero_Invoices' value='N' id= 'Print_Zero_Invoices'></li><br>";
				echo "<li><label for='Print_Neg_Invoices'>Print_Neg_Invoices:</label><br><input type='text' name='Print_Neg_Invoices' value='Y' id= 'Print_Neg_Invoices'></li><br>";
				echo "<li><label for='Generate_Statement'>Generate_Statement:</label><br><input type='text' name='Generate_Statement' value='P' id= 'Generate_Statement'></li><br>";
				//echo "<li><label for='Generate_2nd_Statement'>Generate_2nd_Statement:</label><br><input type='text' name='Generate_2nd_Statement' id= 'Generate_2nd_Statement'></li><br>";
				echo "<li><label for='Generate_Neg_Statement'>Generate_Neg_Statement:</label><br><input type='text' name='Generate_Neg_Statement' value='Y' id= 'Generate_Neg_Statement'></li><br>";
				echo "<li><label for='Generate_0_Amount_Statement'>Generate_0_Amount_Statement:</label><br><input type='text' name='Generate_0_Amount_Statement' value='N' id= 'Generate_0_Amount_Statement'></li><br>";
				echo "<li><label for='Generate_No_Activity_Statement'>Generate_No_Activity_Statement:</label><br><input type='text' name='Generate_No_Activity_Statement' value='Y' id= 'Generate_No_Activity_Statement'></li><br>";
				//echo "<li><label for='Credit_Score'>Credit_Score:</label><br><input type='text' name='Credit_Score' id= 'Credit_Score'></li><br>";
				echo "<li><label for='Affect_Demand'>Affect_Demand:</label><br><input type='text' value='Y' name='Affect_Demand' id= 'Affect_Demand'></li><br>";
				//echo "<li><label for='Incentive_Effective_Date'>Incentive_Effective_Date:</label><br><input type='text' name='Incentive_Effective_Date' id= 'Incentive_Effective_Date'></li><br>";
				//echo "<li><label for='Incentive_Duration'>Incentive_Duration:</label><br><input type='text' name='Incentive_Duration' id= 'Incentive_Duration'></li><br>";
				//echo "<li><label for='Claimback_Customer'>Claimback_Customer:</label><br><input type='text' name='Claimback_Customer' id= 'Claimback_Customer'></li><br>";
				echo "<li><label for='Generate_Invoices'>Generate_Invoices:</label><br><input type='text' value='P' name='Generate_Invoices' id= 'Generate_Invoices'></li><br>";
				//echo "<li><label for='Generate_2nd_Invoices'>Generate_2nd_Invoices:</label><br><input type='text' name='Generate_2nd_Invoices' id= 'Generate_2nd_Invoices'></li><br>";
				//echo "<li><label for='Statement_Seq'>Statement_Seq:</label><br><input type='text' name='Statement_Seq' id= 'Statement_Seq'></li><br>";
				echo "<li><label for='Auto_Conf'>Auto_Conf:</label><br><input type='text' name='Auto_Conf' value='N' id= 'Auto_Conf'></li><br>";
				//echo "<li><label for='Associated_Info'>Associated_Info:</label><br><input type='text' name='Associated_Info' id= 'Associated_Info'></li><br>";
				echo "<li><label for='Labels'>Labels:</label><br><input type='text' name='Labels' value='N' id='Labels'></li><br>";
				//echo "<li><label for='Customer_Supplier_Num'>Customer_Supplier_Num:</label><br><input type='text' name='Customer_Supplier_Num' id= 'Customer_Supplier_Num'></li><br>";
				//echo "<li><label for='Customer_Prep_Day'>Customer_Prep_Day:</label><br><input type='text' name='Customer_Prep_Day' id= 'Customer_Prep_Day'></li><br>";
				echo "<li><label for='Review_Freight'>Review_Freight:</label><br><input type='text' value='Y' name='Review_Freight' id= 'Review_Freight'></li><br>";
				echo "<li><label for='Customer_Ordered_By'>Customer_Ordered_By:</label><br><input type='text' value='Y' name='Customer_Ordered_By' id= 'Customer_Ordered_By'></li><br>";
				echo "<li><label for='Use_Freight_Tables'>Use_Freight_Tables:</label><br><input type='text' value='Y' name='Use_Freight_Tables' id= 'Use_Freight_Tables'></li><br>";
				echo "<li><label for='Ext_Price_On_Ticket'>Ext_Price_On_Ticket:</label><br><input type='text' value='Y' name='Ext_Price_On_Ticket' id= 'Ext_Price_On_Ticket'></li><br>";
				//echo "<li><label for='Master_Customer'>Master_Customer:</label><br><input type='text' name='Master_Customer' id= 'Master_Customer'></li><br>";
				echo "<li><label for='GSA_Pricing'>GSA_Pricing:</label><br><input type='text' name='GSA_Pricing' value='N' id= 'GSA_Pricing'></li><br>";
				echo "<li><label for='Enable_Level_3_CC_Reporting'>Enable_Level_3_CC_Reporting:</label><br><input type='text' name='Enable_Level_3_CC_Reporting' value='N' id= 'Enable_Level_3_CC_Reporting'></li><br>";
				echo "<li><label for='Audit_Required'>Audit_Required:</label><br><input type='text' name='Audit_Required' value='N' id= 'Audit_Required'></li><br>";
				//echo "<li><label for='Verify_Checks'>Verify_Checks:</label><br><input type='text' name='Verify_Checks' value='Y' id= 'Verify_Checks'></li><br>";
				echo "<li><label for='Price_Roudning'>Price_Rounding:</label><br><input type='text' name='Price_Roudning' id= 'Price_Roudning'></li><br>";
				echo "<li><label for='Nearest_Decimal'>Nearest_Decimal:</label><br><input type='text' name='Nearest_Decimal' id= 'Nearest_Decimal'></li><br>";
				echo "<li><label for='Round_Minimum_Up'>Round_Minimum_Up:</label><br><input type='text' name='Round_Minimum_Up' id= 'Round_Minimum_Up'></li><br>";
				echo "<li><label for='Round_Contract_Price'>Round_Contract_Price:</label><br><input type='text' name='Round_Contract_Price' id= 'Round_Contract_Price'></li><br>";
				echo "<li><label for='Show_Price'>Show_Price:</label><br><input type='text' value='' name='Show_Price' id= 'Show_Price'></li><br>";
				echo "<li><label for='Secondary_Salesman'>Secondary_Salesman:</label><br><input type='text' name='Secondary_Salesman' id= 'Secondary_Salesman'></li><br>";
				echo "<li><label for='Percent_If_Secondary_Salesman'>Percent_If_Secondary_Salesman:</label><br><input type='text' name='Percent_If_Secondary_Salesman' id= 'Percent_If_Secondary_Salesman'></li><br>";
				echo "</ol>";
				
				echo "<hr>";
				//value mapping
				echo "<h4>Field Mapping</h4>";
				echo "<ol>";
				
				echo "<li><label for='mapping_Acquisition_Customer_Number'>Acquisition_Customer_Number:</label><br><select name='mapping_Acquisition_Customer_Number'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_FEI_Load_Acct'>FEI_Load_Acct:</label><br><select name='mapping_FEI_Load_Acct'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Hide_Cust'>Hide_Cust:</label><br><select name='mapping_Hide_Cust'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Customer_Alpha_Key'>Customer_Alpha_Key:</label><br><select name='mapping_Customer_Alpha_Key'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Customer_Name'>Customer_Name:</label><br><select name='mapping_Customer_Name'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Addr_1'>Addr_1:</label><br><select name='mapping_Addr_1'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Addr_2'>Addr_2:</label><br><select name='mapping_Addr_2'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Addr_3'>Addr_3:</label><br><select name='mapping_Addr_3'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_City'>City:</label><br><select name='mapping_City'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_State'>State:</label><br><select name='mapping_State'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Zip'>Zip:</label><br><select name='mapping_Zip'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Country'>Country:</label><br><select name='mapping_Country'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Credit_Manager'>Credit_Manager:</label><br><select name='mapping_Credit_Manager'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Phone'>Phone:</label><br><select name='mapping_Phone'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Fax'>Fax:</label><br><select name='mapping_Fax'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Credit_Limit'>Credit_Limit:</label><br><select name='mapping_Credit_Limit'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Salesman_Initials'>Salesman_Initials:</label><br><select name='mapping_Salesman_Initials'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Alt_Salesman_Initials'>Alt_Salesman_Initials:</label><br><select name='mapping_Alt_Salesman_Initials'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Credit_Code'>Credit_Code:</label><br><select name='mapping_Credit_Code'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Credit_Rating'>Credit_Rating:</label><br><select name='mapping_Credit_Rating'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Job_YN'>Job_YN:</label><br><select name='mapping_Job_YN'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Ship_Via'>Ship_Via:</label><br><select name='mapping_Ship_Via'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Ship_Instr'>Ship_Instr:</label><br><select name='mapping_Ship_Instr'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Ship_Instr2'>Ship_Instr2:</label><br><select name='mapping_Ship_Instr2'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Ship_Instr3'>Ship_Instr3:</label><br><select name='mapping_Ship_Instr3'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Ship_Instr4'>Ship_Instr4:</label><br><select name='mapping_Ship_Instr4'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Ship_Attn'>Ship_Attn:</label><br><select name='mapping_Ship_Attn'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Ship_To_Phone'>Ship_To_Phone:</label><br><select name='mapping_Ship_To_Phone'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Terms'>Terms:</label><br><select name='mapping_Terms'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Tax_Jur'>Tax_Jur:</label><br><select name='mapping_Tax_Jur'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Exempt_Num'>Exempt_Num:</label><br><select name='mapping_Exempt_Num'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Sales_Contact'>Sales_Contact:</label><br><select name='mapping_Sales_Contact'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Credit_Contact'>Credit_Contact:</label><br><select name='mapping_Credit_Contact'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Service_Charge'>Service_Charge:</label><br><select name='mapping_Service_Charge'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Branch'>Branch:</label><br><select name='mapping_Branch'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Price_Col'>Price_Col:</label><br><select name='mapping_Price_Col'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_AR_GL_Num'>AR_GL_Num:</label><br><select name='mapping_AR_GL_Num'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Job_Name_Req'>Job_Name_Req:</label><br><select name='mapping_Job_Name_Req'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Cust_PO_Req'>Cust_PO_Req:</label><br><select name='mapping_Cust_PO_Req'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Print_LD'>Print_LD:</label><br><select name='mapping_Print_LD'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Print_Price'>Print_Price:</label><br><select name='mapping_Print_Price'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Alpha_Sort'>Alpha_Sort:</label><br><select name='mapping_Alpha_Sort'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Territory'>Territory:</label><br><select name='mapping_Territory'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Corp_ID'>Corp_ID:</label><br><select name='mapping_Corp_ID'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_DUNS_Num'>DUNS_Num:</label><br><select name='mapping_DUNS_Num'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Dont_Forget'>Dont_Forget:</label><br><select name='mapping_Dont_Forget'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Status'>Status:</label><br><select name='mapping_Status'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Delivery_Charge'>Delivery_Charge:</label><br><select name='mapping_Delivery_Charge'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Accept_BO'>Accept_BO:</label><br><select name='mapping_Accept_BO'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Min_Charge_Del'>Min_Charge_Del:</label><br><select name='mapping_Min_Charge_Del'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Blind_Bill'>Blind_Bill:</label><br><select name='mapping_Blind_Bill'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Sort_By_Loc'>Sort_By_Loc:</label><br><select name='mapping_Sort_By_Loc'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Cutoff_Days'>Cutoff_Days:</label><br><select name='mapping_Cutoff_Days'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Num_Of_Inv'>Num_Of_Inv:</label><br><select name='mapping_Num_Of_Inv'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Cust_Type'>Cust_Type:</label><br><select name='mapping_Cust_Type'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Personal_Guaranty'>Personal_Guaranty:</label><br><select name='mapping_Personal_Guaranty'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Credit_Application'>Credit_Application:</label><br><select name='mapping_Credit_Application'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Last_Financial_Statement'>Last_Financial_Statement:</label><br><select name='mapping_Last_Financial_Statement'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Gross_Sales'>Gross_Sales:</label><br><select name='mapping_Gross_Sales'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Net_Working_Capital'>Net_Working_Capital:</label><br><select name='mapping_Net_Working_Capital'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Net_Worth'>Net_Worth:</label><br><select name='mapping_Net_Worth'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Date_In_Business'>Date_In_Business:</label><br><select name='mapping_Date_In_Business'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Last_DB_Report'>Last_DB_Report:</label><br><select name='mapping_Last_DB_Report'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_DB_Rating'>DB_Rating:</label><br><select name='mapping_DB_Rating'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Credit_Region'>Credit_Region:</label><br><select name='mapping_Credit_Region'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Controlling_Branch'>Controlling_Branch:</label><br><select name='mapping_Controlling_Branch'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Reserve_Customer'>Reserve_Customer:</label><br><select name='mapping_Reserve_Customer'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Print_EDI_Orders'>Print_EDI_Orders:</label><br><select name='mapping_Print_EDI_Orders'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Cash_Receipts_Sort'>Cash_Receipts_Sort:</label><br><select name='mapping_Cash_Receipts_Sort'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Ship_Complete'>Ship_Complete:</label><br><select name='mapping_Ship_Complete'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Print_Zero_Invoices'>Print_Zero_Invoices:</label><br><select name='mapping_Print_Zero_Invoices'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Print_Neg_Invoices'>Print_Neg_Invoices:</label><br><select name='mapping_Print_Neg_Invoices'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Generate_Statement'>Generate_Statement:</label><br><select name='mapping_Generate_Statement'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Generate_2nd_Statement'>Generate_2nd_Statement:</label><br><select name='mapping_Generate_2nd_Statement'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Generate_Neg_Statement'>Generate_Neg_Statement:</label><br><select name='mapping_Generate_Neg_Statement'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Generate_0_Amount_Statement'>Generate_0_Amount_Statement:</label><br><select name='mapping_Generate_0_Amount_Statement'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Generate_No_Activity_Statement'>Generate_No_Activity_Statement:</label><br><select name='mapping_Generate_No_Activity_Statement'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Credit_Score'>Credit_Score:</label><br><select name='mapping_Credit_Score'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Affect_Demand'>Affect_Demand:</label><br><select name='mapping_Affect_Demand'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Incentive_Effective_Date'>Incentive_Effective_Date:</label><br><select name='mapping_Incentive_Effective_Date'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Incentive_Duration'>Incentive_Duration:</label><br><select name='mapping_Incentive_Duration'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Claimback_Customer'>Claimback_Customer:</label><br><select name='mapping_Claimback_Customer'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Generate_Invoices'>Generate_Invoices:</label><br><select name='mapping_Generate_Invoices'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Generate_2nd_Invoices'>Generate_2nd_Invoices:</label><br><select name='mapping_Generate_2nd_Invoices'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Statement_Seq'>Statement_Seq:</label><br><select name='mapping_Statement_Seq'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Auto_Conf'>Auto_Conf:</label><br><select name='mapping_Auto_Conf'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Associated_Info'>Associated_Info:</label><br><select name='mapping_Associated_Info'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Labels'>Labels:</label><br><select name='mapping_Labels'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Customer_Supplier_Num'>Customer_Supplier_Num:</label><br><select name='mapping_Customer_Supplier_Num'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Customer_Prep_Day'>Customer_Prep_Day:</label><br><select name='mapping_Customer_Prep_Day'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Review_Freight'>Review_Freight:</label><br><select name='mapping_Review_Freight'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Customer_Ordered_By'>Customer_Ordered_By:</label><br><select name='mapping_Customer_Ordered_By'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Use_Freight_Tables'>Use_Freight_Tables:</label><br><select name='mapping_Use_Freight_Tables'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Ext_Price_On_Ticket'>Ext_Price_On_Ticket:</label><br><select name='mapping_Ext_Price_On_Ticket'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Master_Customer'>Master_Customer:</label><br><select name='mapping_Master_Customer'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_GSA_Pricing'>GSA_Pricing:</label><br><select name='mapping_GSA_Pricing'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Enable_Level_3_CC_Reporting'>Enable_Level_3_CC_Reporting:</label><br><select name='mapping_Enable_Level_3_CC_Reporting'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Audit_Required'>Audit_Required:</label><br><select name='mapping_Audit_Required'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Verify_Checks'>Verify_Checks:</label><br><select name='mapping_Verify_Checks'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Price_Roudning'>Price_Roudning:</label><br><select name='mapping_Price_Roudning'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Nearest_Decimal'>Nearest_Decimal:</label><br><select name='mapping_Nearest_Decimal'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Round_Minimum_Up'>Round_Minimum_Up:</label><br><select name='mapping_Round_Minimum_Up'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Round_Contract_Price'>Round_Contract_Price:</label><br><select name='mapping_Round_Contract_Price'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Show_Price'>Show_Price:</label><br><select name='mapping_Show_Price'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Secondary_Salesman'>Secondary_Salesman:</label><br><select name='mapping_Secondary_Salesman'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";
				echo "<li><label for='mapping_Percent_If_Secondary_Salesman'>Percent_If_Secondary_Salesman:</label><br><select name='mapping_Percent_If_Secondary_Salesman'>"; echo "<option value=''>(blank)</option>"; for ($c=0; $c < sizeof($old_labels_array); $c++) { echo "<option value='" . $c . "'>" . $old_labels_array[$c] . "</option>"; } echo "</select></li><br>";

				
				echo "</ol>";
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