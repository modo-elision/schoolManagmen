<?php
require_once 'control/main_control.php';
$control=new Index();
	$control->clear_session();
	$control->redirect("http://localhost/inspection_management_system/index.php");

?>