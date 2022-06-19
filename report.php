<?php

require_once 'control/main_control.php';

$control=new Index();
if($_SESSION['User_id']==NULL)
{
	$control->redirect("http://localhost/inspection_management_system/sign-out.php");
}
$control->report_data();
$control->report_view();

?>