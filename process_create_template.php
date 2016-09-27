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
if(isset($_POST["conversion_name"]))
{
	$conversion_name = mres($_POST["conversion_name"]);
	//echo "Conversion Name: " . $conversion_name . "<br>";
}
else
{
	$conversion_name = "";
}
/*
if(isset($_POST["Acquisition_Customer_Number"]))
{
	$Default_Acquisition_Customer_Number = mres($_POST["Acquisition_Customer_Number"]);
	echo "Default Acquisition_Customer_Number: " . $Default_Acquisition_Customer_Number . "<br>";
}
else 
{
	$Default_Acquisition_Customer_Number = "";
}

if(isset($_POST["Acquisition_Customer_Number"])) { $Default_Acquisition_Customer_Number = mres($_POST["Acquisition_Customer_Number"]); echo "Default Acquisition_Customer_Number: " . $Default_Acquisition_Customer_Number . "<br>"; } else { $Default_Acquisition_Customer_Number = ""; }
*/
if(isset($_POST["Acquisition_Customer_Number"])) { $Default_Acquisition_Customer_Number = mres($_POST["Acquisition_Customer_Number"]); } else { $Default_Acquisition_Customer_Number = ""; }
if(isset($_POST["FEI_Load_Acct"])) { $Default_FEI_Load_Acct = mres($_POST["FEI_Load_Acct"]); } else { $Default_FEI_Load_Acct = ""; }
if(isset($_POST["Hide_Cust"])) { $Default_Hide_Cust = mres($_POST["Hide_Cust"]); } else { $Default_Hide_Cust = ""; }
if(isset($_POST["Customer_Alpha_Key"])) { $Default_Customer_Alpha_Key = mres($_POST["Customer_Alpha_Key"]); } else { $Default_Customer_Alpha_Key = ""; }
if(isset($_POST["Customer_Name"])) { $Default_Customer_Name = mres($_POST["Customer_Name"]); } else { $Default_Customer_Name = ""; }
if(isset($_POST["Addr_1"])) { $Default_Addr_1 = mres($_POST["Addr_1"]); } else { $Default_Addr_1 = ""; }
if(isset($_POST["Addr_2"])) { $Default_Addr_2 = mres($_POST["Addr_2"]); } else { $Default_Addr_2 = ""; }
if(isset($_POST["Addr_3"])) { $Default_Addr_3 = mres($_POST["Addr_3"]); } else { $Default_Addr_3 = ""; }
if(isset($_POST["City"])) { $Default_City = mres($_POST["City"]); } else { $Default_City = ""; }
if(isset($_POST["State"])) { $Default_State = mres($_POST["State"]); } else { $Default_State = ""; }
if(isset($_POST["Zip"])) { $Default_Zip = mres($_POST["Zip"]); } else { $Default_Zip = ""; }
if(isset($_POST["Country"])) { $Default_Country = mres($_POST["Country"]); } else { $Default_Country = ""; }
if(isset($_POST["Credit_Manager"])) { $Default_Credit_Manager = mres($_POST["Credit_Manager"]); } else { $Default_Credit_Manager = ""; }
if(isset($_POST["Phone"])) { $Default_Phone = mres($_POST["Phone"]); } else { $Default_Phone = ""; }
if(isset($_POST["Fax"])) { $Default_Fax = mres($_POST["Fax"]); } else { $Default_Fax = ""; }
if(isset($_POST["Credit_Limit"])) { $Default_Credit_Limit = mres($_POST["Credit_Limit"]); } else { $Default_Credit_Limit = ""; }
if(isset($_POST["Salesman_Initials"])) { $Default_Salesman_Initials = mres($_POST["Salesman_Initials"]); } else { $Default_Salesman_Initials = ""; }
if(isset($_POST["Alt_Salesman_Initials"])) { $Default_Alt_Salesman_Initials = mres($_POST["Alt_Salesman_Initials"]); } else { $Default_Alt_Salesman_Initials = ""; }
if(isset($_POST["Credit_Code"])) { $Default_Credit_Code = mres($_POST["Credit_Code"]); } else { $Default_Credit_Code = ""; }
if(isset($_POST["Credit_Rating"])) { $Default_Credit_Rating = mres($_POST["Credit_Rating"]); } else { $Default_Credit_Rating = ""; }
if(isset($_POST["Job_YN"])) { $Default_Job_YN = mres($_POST["Job_YN"]); } else { $Default_Job_YN = ""; }
if(isset($_POST["Ship_Via"])) { $Default_Ship_Via = mres($_POST["Ship_Via"]); } else { $Default_Ship_Via = ""; }
if(isset($_POST["Ship_Instr"])) { $Default_Ship_Instr = mres($_POST["Ship_Instr"]); } else { $Default_Ship_Instr = ""; }
if(isset($_POST["Ship_Instr2"])) { $Default_Ship_Instr2 = mres($_POST["Ship_Instr2"]); } else { $Default_Ship_Instr2 = ""; }
if(isset($_POST["Ship_Instr3"])) { $Default_Ship_Instr3 = mres($_POST["Ship_Instr3"]); } else { $Default_Ship_Instr3 = ""; }
if(isset($_POST["Ship_Instr4"])) { $Default_Ship_Instr4 = mres($_POST["Ship_Instr4"]); } else { $Default_Ship_Instr4 = ""; }
if(isset($_POST["Ship_Attn"])) { $Default_Ship_Attn = mres($_POST["Ship_Attn"]); } else { $Default_Ship_Attn = ""; }
if(isset($_POST["Ship_To_Phone"])) { $Default_Ship_To_Phone = mres($_POST["Ship_To_Phone"]); } else { $Default_Ship_To_Phone = ""; }
if(isset($_POST["Terms"])) { $Default_Terms = mres($_POST["Terms"]); } else { $Default_Terms = ""; }
if(isset($_POST["Tax_Jur"])) { $Default_Tax_Jur = mres($_POST["Tax_Jur"]); } else { $Default_Tax_Jur = ""; }
if(isset($_POST["Exempt_Num"])) { $Default_Exempt_Num = mres($_POST["Exempt_Num"]); } else { $Default_Exempt_Num = ""; }
if(isset($_POST["Sales_Contact"])) { $Default_Sales_Contact = mres($_POST["Sales_Contact"]); } else { $Default_Sales_Contact = ""; }
if(isset($_POST["Credit_Contact"])) { $Default_Credit_Contact = mres($_POST["Credit_Contact"]); } else { $Default_Credit_Contact = ""; }
if(isset($_POST["Service_Charge"])) { $Default_Service_Charge = mres($_POST["Service_Charge"]); } else { $Default_Service_Charge = ""; }
if(isset($_POST["Branch"])) { $Default_Branch = mres($_POST["Branch"]); } else { $Default_Branch = ""; }
if(isset($_POST["Price_Col"])) { $Default_Price_Col = mres($_POST["Price_Col"]); } else { $Default_Price_Col = ""; }
if(isset($_POST["AR_GL_Num"])) { $Default_AR_GL_Num = mres($_POST["AR_GL_Num"]); } else { $Default_AR_GL_Num = ""; }
if(isset($_POST["Job_Name_Req"])) { $Default_Job_Name_Req = mres($_POST["Job_Name_Req"]); } else { $Default_Job_Name_Req = ""; }
if(isset($_POST["Cust_PO_Req"])) { $Default_Cust_PO_Req = mres($_POST["Cust_PO_Req"]); } else { $Default_Cust_PO_Req = ""; }
if(isset($_POST["Print_LD"])) { $Default_Print_LD = mres($_POST["Print_LD"]); } else { $Default_Print_LD = ""; }
if(isset($_POST["Print_Price"])) { $Default_Print_Price = mres($_POST["Print_Price"]); } else { $Default_Print_Price = ""; }
if(isset($_POST["Alpha_Sort"])) { $Default_Alpha_Sort = mres($_POST["Alpha_Sort"]); } else { $Default_Alpha_Sort = ""; }
if(isset($_POST["Territory"])) { $Default_Territory = mres($_POST["Territory"]); } else { $Default_Territory = ""; }
if(isset($_POST["Corp_ID"])) { $Default_Corp_ID = mres($_POST["Corp_ID"]); } else { $Default_Corp_ID = ""; }
if(isset($_POST["DUNS_Num"])) { $Default_DUNS_Num = mres($_POST["DUNS_Num"]); } else { $Default_DUNS_Num = ""; }
if(isset($_POST["Dont_Forget"])) { $Default_Dont_Forget = mres($_POST["Dont_Forget"]); } else { $Default_Dont_Forget = ""; }
if(isset($_POST["Status"])) { $Default_Status = mres($_POST["Status"]); } else { $Default_Status = ""; }
if(isset($_POST["Delivery_Charge"])) { $Default_Delivery_Charge = mres($_POST["Delivery_Charge"]); } else { $Default_Delivery_Charge = ""; }
if(isset($_POST["Accept_BO"])) { $Default_Accept_BO = mres($_POST["Accept_BO"]); } else { $Default_Accept_BO = ""; }
if(isset($_POST["Min_Charge_Del"])) { $Default_Min_Charge_Del = mres($_POST["Min_Charge_Del"]); } else { $Default_Min_Charge_Del = ""; }
if(isset($_POST["Blind_Bill"])) { $Default_Blind_Bill = mres($_POST["Blind_Bill"]); } else { $Default_Blind_Bill = ""; }
if(isset($_POST["Sort_By_Loc"])) { $Default_Sort_By_Loc = mres($_POST["Sort_By_Loc"]); } else { $Default_Sort_By_Loc = ""; }
if(isset($_POST["Cutoff_Days"])) { $Default_Cutoff_Days = mres($_POST["Cutoff_Days"]); } else { $Default_Cutoff_Days = ""; }
if(isset($_POST["Num_Of_Inv"])) { $Default_Num_Of_Inv = mres($_POST["Num_Of_Inv"]); } else { $Default_Num_Of_Inv = ""; }
if(isset($_POST["Cust_Type"])) { $Default_Cust_Type = mres($_POST["Cust_Type"]); } else { $Default_Cust_Type = ""; }
if(isset($_POST["Personal_Guaranty"])) { $Default_Personal_Guaranty = mres($_POST["Personal_Guaranty"]); } else { $Default_Personal_Guaranty = ""; }
if(isset($_POST["Credit_Application"])) { $Default_Credit_Application = mres($_POST["Credit_Application"]); } else { $Default_Credit_Application = ""; }
if(isset($_POST["Last_Financial_Statement"])) { $Default_Last_Financial_Statement = mres($_POST["Last_Financial_Statement"]); } else { $Default_Last_Financial_Statement = ""; }
if(isset($_POST["Gross_Sales"])) { $Default_Gross_Sales = mres($_POST["Gross_Sales"]); } else { $Default_Gross_Sales = ""; }
if(isset($_POST["Net_Working_Capital"])) { $Default_Net_Working_Capital = mres($_POST["Net_Working_Capital"]); } else { $Default_Net_Working_Capital = ""; }
if(isset($_POST["Net_Worth"])) { $Default_Net_Worth = mres($_POST["Net_Worth"]); } else { $Default_Net_Worth = ""; }
if(isset($_POST["Date_In_Business"])) { $Default_Date_In_Business = mres($_POST["Date_In_Business"]); } else { $Default_Date_In_Business = ""; }
if(isset($_POST["Last_DB_Report"])) { $Default_Last_DB_Report = mres($_POST["Last_DB_Report"]); } else { $Default_Last_DB_Report = ""; }
if(isset($_POST["DB_Rating"])) { $Default_DB_Rating = mres($_POST["DB_Rating"]); } else { $Default_DB_Rating = ""; }
if(isset($_POST["Credit_Region"])) { $Default_Credit_Region = mres($_POST["Credit_Region"]); } else { $Default_Credit_Region = ""; }
if(isset($_POST["Controlling_Branch"])) { $Default_Controlling_Branch = mres($_POST["Controlling_Branch"]); } else { $Default_Controlling_Branch = ""; }
if(isset($_POST["Reserve_Customer"])) { $Default_Reserve_Customer = mres($_POST["Reserve_Customer"]); } else { $Default_Reserve_Customer = ""; }
if(isset($_POST["Print_EDI_Orders"])) { $Default_Print_EDI_Orders = mres($_POST["Print_EDI_Orders"]); } else { $Default_Print_EDI_Orders = ""; }
if(isset($_POST["Cash_Receipts_Sort"])) { $Default_Cash_Receipts_Sort = mres($_POST["Cash_Receipts_Sort"]); } else { $Default_Cash_Receipts_Sort = ""; }
if(isset($_POST["Ship_Complete"])) { $Default_Ship_Complete = mres($_POST["Ship_Complete"]); } else { $Default_Ship_Complete = ""; }
if(isset($_POST["Print_Zero_Invoices"])) { $Default_Print_Zero_Invoices = mres($_POST["Print_Zero_Invoices"]); } else { $Default_Print_Zero_Invoices = ""; }
if(isset($_POST["Print_Neg_Invoices"])) { $Default_Print_Neg_Invoices = mres($_POST["Print_Neg_Invoices"]); } else { $Default_Print_Neg_Invoices = ""; }
if(isset($_POST["Generate_Statement"])) { $Default_Generate_Statement = mres($_POST["Generate_Statement"]); } else { $Default_Generate_Statement = ""; }
if(isset($_POST["Generate_2nd_Statement"])) { $Default_Generate_2nd_Statement = mres($_POST["Generate_2nd_Statement"]); } else { $Default_Generate_2nd_Statement = ""; }
if(isset($_POST["Generate_Neg_Statement"])) { $Default_Generate_Neg_Statement = mres($_POST["Generate_Neg_Statement"]); } else { $Default_Generate_Neg_Statement = ""; }
if(isset($_POST["Generate_0_Amount_Statement"])) { $Default_Generate_0_Amount_Statement = mres($_POST["Generate_0_Amount_Statement"]); } else { $Default_Generate_0_Amount_Statement = ""; }
if(isset($_POST["Generate_No_Activity_Statement"])) { $Default_Generate_No_Activity_Statement = mres($_POST["Generate_No_Activity_Statement"]); } else { $Default_Generate_No_Activity_Statement = ""; }
if(isset($_POST["Credit_Score"])) { $Default_Credit_Score = mres($_POST["Credit_Score"]); } else { $Default_Credit_Score = ""; }
if(isset($_POST["Affect_Demand"])) { $Default_Affect_Demand = mres($_POST["Affect_Demand"]); } else { $Default_Affect_Demand = ""; }
if(isset($_POST["Incentive_Effective_Date"])) { $Default_Incentive_Effective_Date = mres($_POST["Incentive_Effective_Date"]); } else { $Default_Incentive_Effective_Date = ""; }
if(isset($_POST["Incentive_Duration"])) { $Default_Incentive_Duration = mres($_POST["Incentive_Duration"]); } else { $Default_Incentive_Duration = ""; }
if(isset($_POST["Claimback_Customer"])) { $Default_Claimback_Customer = mres($_POST["Claimback_Customer"]); } else { $Default_Claimback_Customer = ""; }
if(isset($_POST["Generate_Invoices"])) { $Default_Generate_Invoices = mres($_POST["Generate_Invoices"]); } else { $Default_Generate_Invoices = ""; }
if(isset($_POST["Generate_2nd_Invoices"])) { $Default_Generate_2nd_Invoices = mres($_POST["Generate_2nd_Invoices"]); } else { $Default_Generate_2nd_Invoices = ""; }
if(isset($_POST["Statement_Seq"])) { $Default_Statement_Seq = mres($_POST["Statement_Seq"]); } else { $Default_Statement_Seq = ""; }
if(isset($_POST["Auto_Conf"])) { $Default_Auto_Conf = mres($_POST["Auto_Conf"]); } else { $Default_Auto_Conf = ""; }
if(isset($_POST["Associated_Info"])) { $Default_Associated_Info = mres($_POST["Associated_Info"]); } else { $Default_Associated_Info = ""; }
if(isset($_POST["Labels"])) { $Default_Labels = mres($_POST["Labels"]); } else { $Default_Labels = ""; }
if(isset($_POST["Customer_Supplier_Num"])) { $Default_Customer_Supplier_Num = mres($_POST["Customer_Supplier_Num"]); } else { $Default_Customer_Supplier_Num = ""; }
if(isset($_POST["Customer_Prep_Day"])) { $Default_Customer_Prep_Day = mres($_POST["Customer_Prep_Day"]); } else { $Default_Customer_Prep_Day = ""; }
if(isset($_POST["Review_Freight"])) { $Default_Review_Freight = mres($_POST["Review_Freight"]); } else { $Default_Review_Freight = ""; }
if(isset($_POST["Customer_Ordered_By"])) { $Default_Customer_Ordered_By = mres($_POST["Customer_Ordered_By"]); } else { $Default_Customer_Ordered_By = ""; }
if(isset($_POST["Use_Freight_Tables"])) { $Default_Use_Freight_Tables = mres($_POST["Use_Freight_Tables"]); } else { $Default_Use_Freight_Tables = ""; }
if(isset($_POST["Ext_Price_On_Ticket"])) { $Default_Ext_Price_On_Ticket = mres($_POST["Ext_Price_On_Ticket"]); } else { $Default_Ext_Price_On_Ticket = ""; }
if(isset($_POST["Master_Customer"])) { $Default_Master_Customer = mres($_POST["Master_Customer"]); } else { $Default_Master_Customer = ""; }
if(isset($_POST["GSA_Pricing"])) { $Default_GSA_Pricing = mres($_POST["GSA_Pricing"]); } else { $Default_GSA_Pricing = ""; }
if(isset($_POST["Enable_Level_3_CC_Reporting"])) { $Default_Enable_Level_3_CC_Reporting = mres($_POST["Enable_Level_3_CC_Reporting"]); } else { $Default_Enable_Level_3_CC_Reporting = ""; }
if(isset($_POST["Audit_Required"])) { $Default_Audit_Required = mres($_POST["Audit_Required"]); } else { $Default_Audit_Required = ""; }
if(isset($_POST["Verify_Checks"])) { $Default_Verify_Checks = mres($_POST["Verify_Checks"]); } else { $Default_Verify_Checks = ""; }
if(isset($_POST["Price_Roudning"])) { $Default_Price_Roudning = mres($_POST["Price_Roudning"]); } else { $Default_Price_Roudning = ""; }
if(isset($_POST["Nearest_Decimal"])) { $Default_Nearest_Decimal = mres($_POST["Nearest_Decimal"]); } else { $Default_Nearest_Decimal = ""; }
if(isset($_POST["Round_Minimum_Up"])) { $Default_Round_Minimum_Up = mres($_POST["Round_Minimum_Up"]); } else { $Default_Round_Minimum_Up = ""; }
if(isset($_POST["Round_Contract_Price"])) { $Default_Round_Contract_Price = mres($_POST["Round_Contract_Price"]); } else { $Default_Round_Contract_Price = ""; }
if(isset($_POST["Show_Price"])) { $Default_Show_Price = mres($_POST["Show_Price"]); } else { $Default_Show_Price = ""; }
if(isset($_POST["Secondary_Salesman"])) { $Default_Secondary_Salesman = mres($_POST["Secondary_Salesman"]); } else { $Default_Secondary_Salesman = ""; }
if(isset($_POST["Percent_If_Secondary_Salesman"])) { $Default_Percent_If_Secondary_Salesman = mres($_POST["Percent_If_Secondary_Salesman"]); } else { $Default_Percent_If_Secondary_Salesman = ""; }

/*
if(isset($_POST["mapping_Acquisition_Customer_Number"]))
{
	$Mapping_Acquisition_Customer_Number = mres($_POST["mapping_Acquisition_Customer_Number"]);
	echo "Mapping Acquisition_Customer_Number: " . $Mapping_Acquisition_Customer_Number . "<br>";
}
else
{
	$Mapping_Acquisition_Customer_Number = "";
}
*/
if(isset($_POST["mapping_Acquisition_Customer_Number"])) { $Mapping_Acquisition_Customer_Number = mres($_POST["mapping_Acquisition_Customer_Number"]); } else { $Mapping_Acquisition_Customer_Number = ""; }
if(isset($_POST["mapping_FEI_Load_Acct"])) { $Mapping_FEI_Load_Acct = mres($_POST["mapping_FEI_Load_Acct"]); } else { $Mapping_FEI_Load_Acct = ""; }
if(isset($_POST["mapping_Hide_Cust"])) { $Mapping_Hide_Cust = mres($_POST["mapping_Hide_Cust"]); } else { $Mapping_Hide_Cust = ""; }
if(isset($_POST["mapping_Customer_Alpha_Key"])) { $Mapping_Customer_Alpha_Key = mres($_POST["mapping_Customer_Alpha_Key"]); } else { $Mapping_Customer_Alpha_Key = ""; }
if(isset($_POST["mapping_Customer_Name"])) { $Mapping_Customer_Name = mres($_POST["mapping_Customer_Name"]); } else { $Mapping_Customer_Name = ""; }
if(isset($_POST["mapping_Addr_1"])) { $Mapping_Addr_1 = mres($_POST["mapping_Addr_1"]); } else { $Mapping_Addr_1 = ""; }
if(isset($_POST["mapping_Addr_2"])) { $Mapping_Addr_2 = mres($_POST["mapping_Addr_2"]); } else { $Mapping_Addr_2 = ""; }
if(isset($_POST["mapping_Addr_3"])) { $Mapping_Addr_3 = mres($_POST["mapping_Addr_3"]); } else { $Mapping_Addr_3 = ""; }
if(isset($_POST["mapping_City"])) { $Mapping_City = mres($_POST["mapping_City"]); } else { $Mapping_City = ""; }
if(isset($_POST["mapping_State"])) { $Mapping_State = mres($_POST["mapping_State"]); } else { $Mapping_State = ""; }
if(isset($_POST["mapping_Zip"])) { $Mapping_Zip = mres($_POST["mapping_Zip"]); } else { $Mapping_Zip = ""; }
if(isset($_POST["mapping_Country"])) { $Mapping_Country = mres($_POST["mapping_Country"]); } else { $Mapping_Country = ""; }
if(isset($_POST["mapping_Credit_Manager"])) { $Mapping_Credit_Manager = mres($_POST["mapping_Credit_Manager"]); } else { $Mapping_Credit_Manager = ""; }
if(isset($_POST["mapping_Phone"])) { $Mapping_Phone = mres($_POST["mapping_Phone"]); } else { $Mapping_Phone = ""; }
if(isset($_POST["mapping_Fax"])) { $Mapping_Fax = mres($_POST["mapping_Fax"]); } else { $Mapping_Fax = ""; }
if(isset($_POST["mapping_Credit_Limit"])) { $Mapping_Credit_Limit = mres($_POST["mapping_Credit_Limit"]); } else { $Mapping_Credit_Limit = ""; }
if(isset($_POST["mapping_Salesman_Initials"])) { $Mapping_Salesman_Initials = mres($_POST["mapping_Salesman_Initials"]); } else { $Mapping_Salesman_Initials = ""; }
if(isset($_POST["mapping_Alt_Salesman_Initials"])) { $Mapping_Alt_Salesman_Initials = mres($_POST["mapping_Alt_Salesman_Initials"]); } else { $Mapping_Alt_Salesman_Initials = ""; }
if(isset($_POST["mapping_Credit_Code"])) { $Mapping_Credit_Code = mres($_POST["mapping_Credit_Code"]); } else { $Mapping_Credit_Code = ""; }
if(isset($_POST["mapping_Credit_Rating"])) { $Mapping_Credit_Rating = mres($_POST["mapping_Credit_Rating"]); } else { $Mapping_Credit_Rating = ""; }
if(isset($_POST["mapping_Job_YN"])) { $Mapping_Job_YN = mres($_POST["mapping_Job_YN"]); } else { $Mapping_Job_YN = ""; }
if(isset($_POST["mapping_Ship_Via"])) { $Mapping_Ship_Via = mres($_POST["mapping_Ship_Via"]); } else { $Mapping_Ship_Via = ""; }
if(isset($_POST["mapping_Ship_Instr"])) { $Mapping_Ship_Instr = mres($_POST["mapping_Ship_Instr"]); } else { $Mapping_Ship_Instr = ""; }
if(isset($_POST["mapping_Ship_Instr2"])) { $Mapping_Ship_Instr2 = mres($_POST["mapping_Ship_Instr2"]); } else { $Mapping_Ship_Instr2 = ""; }
if(isset($_POST["mapping_Ship_Instr3"])) { $Mapping_Ship_Instr3 = mres($_POST["mapping_Ship_Instr3"]); } else { $Mapping_Ship_Instr3 = ""; }
if(isset($_POST["mapping_Ship_Instr4"])) { $Mapping_Ship_Instr4 = mres($_POST["mapping_Ship_Instr4"]); } else { $Mapping_Ship_Instr4 = ""; }
if(isset($_POST["mapping_Ship_Attn"])) { $Mapping_Ship_Attn = mres($_POST["mapping_Ship_Attn"]); } else { $Mapping_Ship_Attn = ""; }
if(isset($_POST["mapping_Ship_To_Phone"])) { $Mapping_Ship_To_Phone = mres($_POST["mapping_Ship_To_Phone"]); } else { $Mapping_Ship_To_Phone = ""; }
if(isset($_POST["mapping_Terms"])) { $Mapping_Terms = mres($_POST["mapping_Terms"]); } else { $Mapping_Terms = ""; }
if(isset($_POST["mapping_Tax_Jur"])) { $Mapping_Tax_Jur = mres($_POST["mapping_Tax_Jur"]); } else { $Mapping_Tax_Jur = ""; }
if(isset($_POST["mapping_Exempt_Num"])) { $Mapping_Exempt_Num = mres($_POST["mapping_Exempt_Num"]); } else { $Mapping_Exempt_Num = ""; }
if(isset($_POST["mapping_Sales_Contact"])) { $Mapping_Sales_Contact = mres($_POST["mapping_Sales_Contact"]); } else { $Mapping_Sales_Contact = ""; }
if(isset($_POST["mapping_Credit_Contact"])) { $Mapping_Credit_Contact = mres($_POST["mapping_Credit_Contact"]); } else { $Mapping_Credit_Contact = ""; }
if(isset($_POST["mapping_Service_Charge"])) { $Mapping_Service_Charge = mres($_POST["mapping_Service_Charge"]); } else { $Mapping_Service_Charge = ""; }
if(isset($_POST["mapping_Branch"])) { $Mapping_Branch = mres($_POST["mapping_Branch"]); } else { $Mapping_Branch = ""; }
if(isset($_POST["mapping_Price_Col"])) { $Mapping_Price_Col = mres($_POST["mapping_Price_Col"]); } else { $Mapping_Price_Col = ""; }
if(isset($_POST["mapping_AR_GL_Num"])) { $Mapping_AR_GL_Num = mres($_POST["mapping_AR_GL_Num"]); } else { $Mapping_AR_GL_Num = ""; }
if(isset($_POST["mapping_Job_Name_Req"])) { $Mapping_Job_Name_Req = mres($_POST["mapping_Job_Name_Req"]); } else { $Mapping_Job_Name_Req = ""; }
if(isset($_POST["mapping_Cust_PO_Req"])) { $Mapping_Cust_PO_Req = mres($_POST["mapping_Cust_PO_Req"]); } else { $Mapping_Cust_PO_Req = ""; }
if(isset($_POST["mapping_Print_LD"])) { $Mapping_Print_LD = mres($_POST["mapping_Print_LD"]); } else { $Mapping_Print_LD = ""; }
if(isset($_POST["mapping_Print_Price"])) { $Mapping_Print_Price = mres($_POST["mapping_Print_Price"]); } else { $Mapping_Print_Price = ""; }
if(isset($_POST["mapping_Alpha_Sort"])) { $Mapping_Alpha_Sort = mres($_POST["mapping_Alpha_Sort"]); } else { $Mapping_Alpha_Sort = ""; }
if(isset($_POST["mapping_Territory"])) { $Mapping_Territory = mres($_POST["mapping_Territory"]); } else { $Mapping_Territory = ""; }
if(isset($_POST["mapping_Corp_ID"])) { $Mapping_Corp_ID = mres($_POST["mapping_Corp_ID"]); } else { $Mapping_Corp_ID = ""; }
if(isset($_POST["mapping_DUNS_Num"])) { $Mapping_DUNS_Num = mres($_POST["mapping_DUNS_Num"]); } else { $Mapping_DUNS_Num = ""; }
if(isset($_POST["mapping_Dont_Forget"])) { $Mapping_Dont_Forget = mres($_POST["mapping_Dont_Forget"]); } else { $Mapping_Dont_Forget = ""; }
if(isset($_POST["mapping_Status"])) { $Mapping_Status = mres($_POST["mapping_Status"]); } else { $Mapping_Status = ""; }
if(isset($_POST["mapping_Delivery_Charge"])) { $Mapping_Delivery_Charge = mres($_POST["mapping_Delivery_Charge"]); } else { $Mapping_Delivery_Charge = ""; }
if(isset($_POST["mapping_Accept_BO"])) { $Mapping_Accept_BO = mres($_POST["mapping_Accept_BO"]); } else { $Mapping_Accept_BO = ""; }
if(isset($_POST["mapping_Min_Charge_Del"])) { $Mapping_Min_Charge_Del = mres($_POST["mapping_Min_Charge_Del"]); } else { $Mapping_Min_Charge_Del = ""; }
if(isset($_POST["mapping_Blind_Bill"])) { $Mapping_Blind_Bill = mres($_POST["mapping_Blind_Bill"]); } else { $Mapping_Blind_Bill = ""; }
if(isset($_POST["mapping_Sort_By_Loc"])) { $Mapping_Sort_By_Loc = mres($_POST["mapping_Sort_By_Loc"]); } else { $Mapping_Sort_By_Loc = ""; }
if(isset($_POST["mapping_Cutoff_Days"])) { $Mapping_Cutoff_Days = mres($_POST["mapping_Cutoff_Days"]); } else { $Mapping_Cutoff_Days = ""; }
if(isset($_POST["mapping_Num_Of_Inv"])) { $Mapping_Num_Of_Inv = mres($_POST["mapping_Num_Of_Inv"]); } else { $Mapping_Num_Of_Inv = ""; }
if(isset($_POST["mapping_Cust_Type"])) { $Mapping_Cust_Type = mres($_POST["mapping_Cust_Type"]); } else { $Mapping_Cust_Type = ""; }
if(isset($_POST["mapping_Personal_Guaranty"])) { $Mapping_Personal_Guaranty = mres($_POST["mapping_Personal_Guaranty"]); } else { $Mapping_Personal_Guaranty = ""; }
if(isset($_POST["mapping_Credit_Application"])) { $Mapping_Credit_Application = mres($_POST["mapping_Credit_Application"]); } else { $Mapping_Credit_Application = ""; }
if(isset($_POST["mapping_Last_Financial_Statement"])) { $Mapping_Last_Financial_Statement = mres($_POST["mapping_Last_Financial_Statement"]); } else { $Mapping_Last_Financial_Statement = ""; }
if(isset($_POST["mapping_Gross_Sales"])) { $Mapping_Gross_Sales = mres($_POST["mapping_Gross_Sales"]); } else { $Mapping_Gross_Sales = ""; }
if(isset($_POST["mapping_Net_Working_Capital"])) { $Mapping_Net_Working_Capital = mres($_POST["mapping_Net_Working_Capital"]); } else { $Mapping_Net_Working_Capital = ""; }
if(isset($_POST["mapping_Net_Worth"])) { $Mapping_Net_Worth = mres($_POST["mapping_Net_Worth"]); } else { $Mapping_Net_Worth = ""; }
if(isset($_POST["mapping_Date_In_Business"])) { $Mapping_Date_In_Business = mres($_POST["mapping_Date_In_Business"]); } else { $Mapping_Date_In_Business = ""; }
if(isset($_POST["mapping_Last_DB_Report"])) { $Mapping_Last_DB_Report = mres($_POST["mapping_Last_DB_Report"]); } else { $Mapping_Last_DB_Report = ""; }
if(isset($_POST["mapping_DB_Rating"])) { $Mapping_DB_Rating = mres($_POST["mapping_DB_Rating"]); } else { $Mapping_DB_Rating = ""; }
if(isset($_POST["mapping_Credit_Region"])) { $Mapping_Credit_Region = mres($_POST["mapping_Credit_Region"]); } else { $Mapping_Credit_Region = ""; }
if(isset($_POST["mapping_Controlling_Branch"])) { $Mapping_Controlling_Branch = mres($_POST["mapping_Controlling_Branch"]); } else { $Mapping_Controlling_Branch = ""; }
if(isset($_POST["mapping_Reserve_Customer"])) { $Mapping_Reserve_Customer = mres($_POST["mapping_Reserve_Customer"]); } else { $Mapping_Reserve_Customer = ""; }
if(isset($_POST["mapping_Print_EDI_Orders"])) { $Mapping_Print_EDI_Orders = mres($_POST["mapping_Print_EDI_Orders"]); } else { $Mapping_Print_EDI_Orders = ""; }
if(isset($_POST["mapping_Cash_Receipts_Sort"])) { $Mapping_Cash_Receipts_Sort = mres($_POST["mapping_Cash_Receipts_Sort"]); } else { $Mapping_Cash_Receipts_Sort = ""; }
if(isset($_POST["mapping_Ship_Complete"])) { $Mapping_Ship_Complete = mres($_POST["mapping_Ship_Complete"]); } else { $Mapping_Ship_Complete = ""; }
if(isset($_POST["mapping_Print_Zero_Invoices"])) { $Mapping_Print_Zero_Invoices = mres($_POST["mapping_Print_Zero_Invoices"]); } else { $Mapping_Print_Zero_Invoices = ""; }
if(isset($_POST["mapping_Print_Neg_Invoices"])) { $Mapping_Print_Neg_Invoices = mres($_POST["mapping_Print_Neg_Invoices"]); } else { $Mapping_Print_Neg_Invoices = ""; }
if(isset($_POST["mapping_Generate_Statement"])) { $Mapping_Generate_Statement = mres($_POST["mapping_Generate_Statement"]); } else { $Mapping_Generate_Statement = ""; }
if(isset($_POST["mapping_Generate_2nd_Statement"])) { $Mapping_Generate_2nd_Statement = mres($_POST["mapping_Generate_2nd_Statement"]); } else { $Mapping_Generate_2nd_Statement = ""; }
if(isset($_POST["mapping_Generate_Neg_Statement"])) { $Mapping_Generate_Neg_Statement = mres($_POST["mapping_Generate_Neg_Statement"]); } else { $Mapping_Generate_Neg_Statement = ""; }
if(isset($_POST["mapping_Generate_0_Amount_Statement"])) { $Mapping_Generate_0_Amount_Statement = mres($_POST["mapping_Generate_0_Amount_Statement"]); } else { $Mapping_Generate_0_Amount_Statement = ""; }
if(isset($_POST["mapping_Generate_No_Activity_Statement"])) { $Mapping_Generate_No_Activity_Statement = mres($_POST["mapping_Generate_No_Activity_Statement"]); } else { $Mapping_Generate_No_Activity_Statement = ""; }
if(isset($_POST["mapping_Credit_Score"])) { $Mapping_Credit_Score = mres($_POST["mapping_Credit_Score"]); } else { $Mapping_Credit_Score = ""; }
if(isset($_POST["mapping_Affect_Demand"])) { $Mapping_Affect_Demand = mres($_POST["mapping_Affect_Demand"]); } else { $Mapping_Affect_Demand = ""; }
if(isset($_POST["mapping_Incentive_Effective_Date"])) { $Mapping_Incentive_Effective_Date = mres($_POST["mapping_Incentive_Effective_Date"]); } else { $Mapping_Incentive_Effective_Date = ""; }
if(isset($_POST["mapping_Incentive_Duration"])) { $Mapping_Incentive_Duration = mres($_POST["mapping_Incentive_Duration"]); } else { $Mapping_Incentive_Duration = ""; }
if(isset($_POST["mapping_Claimback_Customer"])) { $Mapping_Claimback_Customer = mres($_POST["mapping_Claimback_Customer"]); } else { $Mapping_Claimback_Customer = ""; }
if(isset($_POST["mapping_Generate_Invoices"])) { $Mapping_Generate_Invoices = mres($_POST["mapping_Generate_Invoices"]); } else { $Mapping_Generate_Invoices = ""; }
if(isset($_POST["mapping_Generate_2nd_Invoices"])) { $Mapping_Generate_2nd_Invoices = mres($_POST["mapping_Generate_2nd_Invoices"]); } else { $Mapping_Generate_2nd_Invoices = ""; }
if(isset($_POST["mapping_Statement_Seq"])) { $Mapping_Statement_Seq = mres($_POST["mapping_Statement_Seq"]); } else { $Mapping_Statement_Seq = ""; }
if(isset($_POST["mapping_Auto_Conf"])) { $Mapping_Auto_Conf = mres($_POST["mapping_Auto_Conf"]); } else { $Mapping_Auto_Conf = ""; }
if(isset($_POST["mapping_Associated_Info"])) { $Mapping_Associated_Info = mres($_POST["mapping_Associated_Info"]); } else { $Mapping_Associated_Info = ""; }
if(isset($_POST["mapping_Labels"])) { $Mapping_Labels = mres($_POST["mapping_Labels"]); } else { $Mapping_Labels = ""; }
if(isset($_POST["mapping_Customer_Supplier_Num"])) { $Mapping_Customer_Supplier_Num = mres($_POST["mapping_Customer_Supplier_Num"]); } else { $Mapping_Customer_Supplier_Num = ""; }
if(isset($_POST["mapping_Customer_Prep_Day"])) { $Mapping_Customer_Prep_Day = mres($_POST["mapping_Customer_Prep_Day"]); } else { $Mapping_Customer_Prep_Day = ""; }
if(isset($_POST["mapping_Review_Freight"])) { $Mapping_Review_Freight = mres($_POST["mapping_Review_Freight"]); } else { $Mapping_Review_Freight = ""; }
if(isset($_POST["mapping_Customer_Ordered_By"])) { $Mapping_Customer_Ordered_By = mres($_POST["mapping_Customer_Ordered_By"]); } else { $Mapping_Customer_Ordered_By = ""; }
if(isset($_POST["mapping_Use_Freight_Tables"])) { $Mapping_Use_Freight_Tables = mres($_POST["mapping_Use_Freight_Tables"]); } else { $Mapping_Use_Freight_Tables = ""; }
if(isset($_POST["mapping_Ext_Price_On_Ticket"])) { $Mapping_Ext_Price_On_Ticket = mres($_POST["mapping_Ext_Price_On_Ticket"]); } else { $Mapping_Ext_Price_On_Ticket = ""; }
if(isset($_POST["mapping_Master_Customer"])) { $Mapping_Master_Customer = mres($_POST["mapping_Master_Customer"]); } else { $Mapping_Master_Customer = ""; }
if(isset($_POST["mapping_GSA_Pricing"])) { $Mapping_GSA_Pricing = mres($_POST["mapping_GSA_Pricing"]); } else { $Mapping_GSA_Pricing = ""; }
if(isset($_POST["mapping_Enable_Level_3_CC_Reporting"])) { $Mapping_Enable_Level_3_CC_Reporting = mres($_POST["mapping_Enable_Level_3_CC_Reporting"]); } else { $Mapping_Enable_Level_3_CC_Reporting = ""; }
if(isset($_POST["mapping_Audit_Required"])) { $Mapping_Audit_Required = mres($_POST["mapping_Audit_Required"]); } else { $Mapping_Audit_Required = ""; }
if(isset($_POST["mapping_Verify_Checks"])) { $Mapping_Verify_Checks = mres($_POST["mapping_Verify_Checks"]); } else { $Mapping_Verify_Checks = ""; }
if(isset($_POST["mapping_Price_Roudning"])) { $Mapping_Price_Roudning = mres($_POST["mapping_Price_Roudning"]); } else { $Mapping_Price_Roudning = ""; }
if(isset($_POST["mapping_Nearest_Decimal"])) { $Mapping_Nearest_Decimal = mres($_POST["mapping_Nearest_Decimal"]); } else { $Mapping_Nearest_Decimal = ""; }
if(isset($_POST["mapping_Round_Minimum_Up"])) { $Mapping_Round_Minimum_Up = mres($_POST["mapping_Round_Minimum_Up"]); } else { $Mapping_Round_Minimum_Up = ""; }
if(isset($_POST["mapping_Round_Contract_Price"])) { $Mapping_Round_Contract_Price = mres($_POST["mapping_Round_Contract_Price"]); } else { $Mapping_Round_Contract_Price = ""; }
if(isset($_POST["mapping_Show_Price"])) { $Mapping_Show_Price = mres($_POST["mapping_Show_Price"]); } else { $Mapping_Show_Price = ""; }
if(isset($_POST["mapping_Secondary_Salesman"])) { $Mapping_Secondary_Salesman = mres($_POST["mapping_Secondary_Salesman"]); } else { $Mapping_Secondary_Salesman = ""; }
if(isset($_POST["mapping_Percent_If_Secondary_Salesman"])) { $Mapping_Percent_If_Secondary_Salesman = mres($_POST["mapping_Percent_If_Secondary_Salesman"]); } else { $Mapping_Percent_If_Secondary_Salesman = ""; }


//insert values into database
$sql="INSERT INTO Conversions
(
Conversion_Name,
D_Acquisition_Customer_Number,
D_FEI_Load_Acct,
D_Hide_Cust,
D_Customer_Alpha_Key,
D_Customer_Name,
D_Addr_1,
D_Addr_2,
D_Addr_3,
D_City,
D_State,
D_Zip,
D_Country,
D_Credit_Manager,
D_Phone,
D_Fax,
D_Credit_Limit,
D_Salesman_Initials,
D_Alt_Salesman_Initials,
D_Credit_Code,
D_Credit_Rating,
D_Job_YN,
D_Ship_Via,
D_Ship_Instr,
D_Ship_Instr2,
D_Ship_Instr3,
D_Ship_Instr4,
D_Ship_Attn,
D_Ship_To_Phone,
D_Terms,
D_Tax_Jur,
D_Exempt_Num,
D_Sales_Contact,
D_Credit_Contact,
D_Service_Charge,
D_Branch,
D_Price_Col,
D_AR_GL_Num,
D_Job_Name_Req,
D_Cust_PO_Req,
D_Print_LD,
D_Print_Price,
D_Alpha_Sort,
D_Territory,
D_Corp_ID,
D_DUNS_Num,
D_Dont_Forget,
D_Status,
D_Delivery_Charge,
D_Accept_BO,
D_Min_Charge_Del,
D_Blind_Bill,
D_Sort_By_Loc,
D_Cutoff_Days,
D_Num_Of_Inv,
D_Cust_Type,
D_Personal_Guaranty,
D_Credit_Application,
D_Last_Financial_Statement,
D_Gross_Sales,
D_Net_Working_Capital,
D_Net_Worth,
D_Date_In_Business,
D_Last_DB_Report,
D_DB_Rating,
D_Credit_Region,
D_Controlling_Branch,
D_Reserve_Customer,
D_Print_EDI_Orders,
D_Cash_Receipts_Sort,
D_Ship_Complete,
D_Print_Zero_Invoices,
D_Print_Neg_Invoices,
D_Generate_Statement,
D_Generate_2nd_Statement,
D_Generate_Neg_Statement,
D_Generate_0_Amount_Statement,
D_Generate_No_Activity_Statement,
D_Credit_Score,
D_Affect_Demand,
D_Incentive_Effective_Date,
D_Incentive_Duration,
D_Claimback_Customer,
D_Generate_Invoices,
D_Generate_2nd_Invoices,
D_Statement_Seq,
D_Auto_Conf,
D_Associated_Info,
D_Labels,
D_Customer_Supplier_Num,
D_Customer_Prep_Day,
D_Review_Freight,
D_Customer_Ordered_By,
D_Use_Freight_Tables,
D_Ext_Price_On_Ticket,
D_Master_Customer,
D_GSA_Pricing,
D_Enable_Level_3_CC_Reporting,
D_Audit_Required,
D_Verify_Checks,
D_Price_Roudning,
D_Nearest_Decimal,
D_Round_Minimum_Up,
D_Round_Contract_Price,
D_Show_Price,
D_Secondary_Salesman,
D_Percent_If_Secondary_Salesman,
M_Acquisition_Customer_Number,
M_FEI_Load_Acct,
M_Hide_Cust,
M_Customer_Alpha_Key,
M_Customer_Name,
M_Addr_1,
M_Addr_2,
M_Addr_3,
M_City,
M_State,
M_Zip,
M_Country,
M_Credit_Manager,
M_Phone,
M_Fax,
M_Credit_Limit,
M_Salesman_Initials,
M_Alt_Salesman_Initials,
M_Credit_Code,
M_Credit_Rating,
M_Job_YN,
M_Ship_Via,
M_Ship_Instr,
M_Ship_Instr2,
M_Ship_Instr3,
M_Ship_Instr4,
M_Ship_Attn,
M_Ship_To_Phone,
M_Terms,
M_Tax_Jur,
M_Exempt_Num,
M_Sales_Contact,
M_Credit_Contact,
M_Service_Charge,
M_Branch,
M_Price_Col,
M_AR_GL_Num,
M_Job_Name_Req,
M_Cust_PO_Req,
M_Print_LD,
M_Print_Price,
M_Alpha_Sort,
M_Territory,
M_Corp_ID,
M_DUNS_Num,
M_Dont_Forget,
M_Status,
M_Delivery_Charge,
M_Accept_BO,
M_Min_Charge_Del,
M_Blind_Bill,
M_Sort_By_Loc,
M_Cutoff_Days,
M_Num_Of_Inv,
M_Cust_Type,
M_Personal_Guaranty,
M_Credit_Application,
M_Last_Financial_Statement,
M_Gross_Sales,
M_Net_Working_Capital,
M_Net_Worth,
M_Date_In_Business,
M_Last_DB_Report,
M_DB_Rating,
M_Credit_Region,
M_Controlling_Branch,
M_Reserve_Customer,
M_Print_EDI_Orders,
M_Cash_Receipts_Sort,
M_Ship_Complete,
M_Print_Zero_Invoices,
M_Print_Neg_Invoices,
M_Generate_Statement,
M_Generate_2nd_Statement,
M_Generate_Neg_Statement,
M_Generate_0_Amount_Statement,
M_Generate_No_Activity_Statement,
M_Credit_Score,
M_Affect_Demand,
M_Incentive_Effective_Date,
M_Incentive_Duration,
M_Claimback_Customer,
M_Generate_Invoices,
M_Generate_2nd_Invoices,
M_Statement_Seq,
M_Auto_Conf,
M_Associated_Info,
M_Labels,
M_Customer_Supplier_Num,
M_Customer_Prep_Day,
M_Review_Freight,
M_Customer_Ordered_By,
M_Use_Freight_Tables,
M_Ext_Price_On_Ticket,
M_Master_Customer,
M_GSA_Pricing,
M_Enable_Level_3_CC_Reporting,
M_Audit_Required,
M_Verify_Checks,
M_Price_Roudning,
M_Nearest_Decimal,
M_Round_Minimum_Up,
M_Round_Contract_Price,
M_Show_Price,
M_Secondary_Salesman,
M_Percent_If_Secondary_Salesman
)
VALUES
(
'$conversion_name',
'$Default_Acquisition_Customer_Number',
'$Default_FEI_Load_Acct',
'$Default_Hide_Cust',
'$Default_Customer_Alpha_Key',
'$Default_Customer_Name',
'$Default_Addr_1',
'$Default_Addr_2',
'$Default_Addr_3',
'$Default_City',
'$Default_State',
'$Default_Zip',
'$Default_Country',
'$Default_Credit_Manager',
'$Default_Phone',
'$Default_Fax',
'$Default_Credit_Limit',
'$Default_Salesman_Initials',
'$Default_Alt_Salesman_Initials',
'$Default_Credit_Code',
'$Default_Credit_Rating',
'$Default_Job_YN',
'$Default_Ship_Via',
'$Default_Ship_Instr',
'$Default_Ship_Instr2',
'$Default_Ship_Instr3',
'$Default_Ship_Instr4',
'$Default_Ship_Attn',
'$Default_Ship_To_Phone',
'$Default_Terms',
'$Default_Tax_Jur',
'$Default_Exempt_Num',
'$Default_Sales_Contact',
'$Default_Credit_Contact',
'$Default_Service_Charge',
'$Default_Branch',
'$Default_Price_Col',
'$Default_AR_GL_Num',
'$Default_Job_Name_Req',
'$Default_Cust_PO_Req',
'$Default_Print_LD',
'$Default_Print_Price',
'$Default_Alpha_Sort',
'$Default_Territory',
'$Default_Corp_ID',
'$Default_DUNS_Num',
'$Default_Dont_Forget',
'$Default_Status',
'$Default_Delivery_Charge',
'$Default_Accept_BO',
'$Default_Min_Charge_Del',
'$Default_Blind_Bill',
'$Default_Sort_By_Loc',
'$Default_Cutoff_Days',
'$Default_Num_Of_Inv',
'$Default_Cust_Type',
'$Default_Personal_Guaranty',
'$Default_Credit_Application',
'$Default_Last_Financial_Statement',
'$Default_Gross_Sales',
'$Default_Net_Working_Capital',
'$Default_Net_Worth',
'$Default_Date_In_Business',
'$Default_Last_DB_Report',
'$Default_DB_Rating',
'$Default_Credit_Region',
'$Default_Controlling_Branch',
'$Default_Reserve_Customer',
'$Default_Print_EDI_Orders',
'$Default_Cash_Receipts_Sort',
'$Default_Ship_Complete',
'$Default_Print_Zero_Invoices',
'$Default_Print_Neg_Invoices',
'$Default_Generate_Statement',
'$Default_Generate_2nd_Statement',
'$Default_Generate_Neg_Statement',
'$Default_Generate_0_Amount_Statement',
'$Default_Generate_No_Activity_Statement',
'$Default_Credit_Score',
'$Default_Affect_Demand',
'$Default_Incentive_Effective_Date',
'$Default_Incentive_Duration',
'$Default_Claimback_Customer',
'$Default_Generate_Invoices',
'$Default_Generate_2nd_Invoices',
'$Default_Statement_Seq',
'$Default_Auto_Conf',
'$Default_Associated_Info',
'$Default_Labels',
'$Default_Customer_Supplier_Num',
'$Default_Customer_Prep_Day',
'$Default_Review_Freight',
'$Default_Customer_Ordered_By',
'$Default_Use_Freight_Tables',
'$Default_Ext_Price_On_Ticket',
'$Default_Master_Customer',
'$Default_GSA_Pricing',
'$Default_Enable_Level_3_CC_Reporting',
'$Default_Audit_Required',
'$Default_Verify_Checks',
'$Default_Price_Roudning',
'$Default_Nearest_Decimal',
'$Default_Round_Minimum_Up',
'$Default_Round_Contract_Price',
'$Default_Show_Price',
'$Default_Secondary_Salesman',
'$Default_Percent_If_Secondary_Salesman',
'$Mapping_Acquisition_Customer_Number',
'$Mapping_FEI_Load_Acct',
'$Mapping_Hide_Cust',
'$Mapping_Customer_Alpha_Key',
'$Mapping_Customer_Name',
'$Mapping_Addr_1',
'$Mapping_Addr_2',
'$Mapping_Addr_3',
'$Mapping_City',
'$Mapping_State',
'$Mapping_Zip',
'$Mapping_Country',
'$Mapping_Credit_Manager',
'$Mapping_Phone',
'$Mapping_Fax',
'$Mapping_Credit_Limit',
'$Mapping_Salesman_Initials',
'$Mapping_Alt_Salesman_Initials',
'$Mapping_Credit_Code',
'$Mapping_Credit_Rating',
'$Mapping_Job_YN',
'$Mapping_Ship_Via',
'$Mapping_Ship_Instr',
'$Mapping_Ship_Instr2',
'$Mapping_Ship_Instr3',
'$Mapping_Ship_Instr4',
'$Mapping_Ship_Attn',
'$Mapping_Ship_To_Phone',
'$Mapping_Terms',
'$Mapping_Tax_Jur',
'$Mapping_Exempt_Num',
'$Mapping_Sales_Contact',
'$Mapping_Credit_Contact',
'$Mapping_Service_Charge',
'$Mapping_Branch',
'$Mapping_Price_Col',
'$Mapping_AR_GL_Num',
'$Mapping_Job_Name_Req',
'$Mapping_Cust_PO_Req',
'$Mapping_Print_LD',
'$Mapping_Print_Price',
'$Mapping_Alpha_Sort',
'$Mapping_Territory',
'$Mapping_Corp_ID',
'$Mapping_DUNS_Num',
'$Mapping_Dont_Forget',
'$Mapping_Status',
'$Mapping_Delivery_Charge',
'$Mapping_Accept_BO',
'$Mapping_Min_Charge_Del',
'$Mapping_Blind_Bill',
'$Mapping_Sort_By_Loc',
'$Mapping_Cutoff_Days',
'$Mapping_Num_Of_Inv',
'$Mapping_Cust_Type',
'$Mapping_Personal_Guaranty',
'$Mapping_Credit_Application',
'$Mapping_Last_Financial_Statement',
'$Mapping_Gross_Sales',
'$Mapping_Net_Working_Capital',
'$Mapping_Net_Worth',
'$Mapping_Date_In_Business',
'$Mapping_Last_DB_Report',
'$Mapping_DB_Rating',
'$Mapping_Credit_Region',
'$Mapping_Controlling_Branch',
'$Mapping_Reserve_Customer',
'$Mapping_Print_EDI_Orders',
'$Mapping_Cash_Receipts_Sort',
'$Mapping_Ship_Complete',
'$Mapping_Print_Zero_Invoices',
'$Mapping_Print_Neg_Invoices',
'$Mapping_Generate_Statement',
'$Mapping_Generate_2nd_Statement',
'$Mapping_Generate_Neg_Statement',
'$Mapping_Generate_0_Amount_Statement',
'$Mapping_Generate_No_Activity_Statement',
'$Mapping_Credit_Score',
'$Mapping_Affect_Demand',
'$Mapping_Incentive_Effective_Date',
'$Mapping_Incentive_Duration',
'$Mapping_Claimback_Customer',
'$Mapping_Generate_Invoices',
'$Mapping_Generate_2nd_Invoices',
'$Mapping_Statement_Seq',
'$Mapping_Auto_Conf',
'$Mapping_Associated_Info',
'$Mapping_Labels',
'$Mapping_Customer_Supplier_Num',
'$Mapping_Customer_Prep_Day',
'$Mapping_Review_Freight',
'$Mapping_Customer_Ordered_By',
'$Mapping_Use_Freight_Tables',
'$Mapping_Ext_Price_On_Ticket',
'$Mapping_Master_Customer',
'$Mapping_GSA_Pricing',
'$Mapping_Enable_Level_3_CC_Reporting',
'$Mapping_Audit_Required',
'$Mapping_Verify_Checks',
'$Mapping_Price_Roudning',
'$Mapping_Nearest_Decimal',
'$Mapping_Round_Minimum_Up',
'$Mapping_Round_Contract_Price',
'$Mapping_Show_Price',
'$Mapping_Secondary_Salesman',
'$Mapping_Percent_If_Secondary_Salesman'
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

//disconnect from database
mysqli_close($con);

//header to success page
header("Location: template_creation_status.php?status=" . $status);

?>