<?php
require_once 'control/main_control.php';

$control=new Index();

$id=$_GET['inspection_id'];
$value=$control->get_inspection($id);
//echo "<pre>";print_r($value);
if(($_SESSION['User_id']==NULL)||(($_SESSION['type']=='inspector')&&($_SESSION['User_id']!=$value[0]['inspector_id'])))
{
	$control->redirect("http://localhost/inspection_management_system/inspection_list.php?from_date=2022-03-01&to_date=2022-04-05&date=ASC&submit=btnsubmit");
}
$control->view_inspection_page();

?>