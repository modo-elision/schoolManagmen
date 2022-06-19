<?php

//echo "INDEX";
require_once 'control/main_control.php';

$control=new Index();
if($_SESSION['User_id']==NULL)
{
	$control->redirect("http://localhost/inspection_management_system/sign-out.php");
}

$date=$_GET['date'];
$from_date=$_GET['from_date'];
$to_date=$_GET['to_date'];
$inspector=$_GET['inspector'];

$control->get_inspection_list($date,$from_date,$to_date,$inspector);
$control->inspectionlist();


