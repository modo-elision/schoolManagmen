<?php

require_once 'control/main_control.php';
$control=new Index();
$error=NULL;
if($_SESSION['User_id']!=NULL)
{
	$control->redirect("http://localhost/inspection_management_system/index.php");
}
if($_POST){
	$action=$_POST['submit']; 
		if ($action=='Signup')
		{
			//echo'$action';
			if((!empty($_POST['password']))&(!empty($_POST['email']))&(!empty($_POST['name'])))
			if($_POST['password']==$_POST['c_password']){
				$data = array(
				'id' =>null,
				'email' =>$_POST['email'],
				'full_name' =>$_POST['name'],
				'password' => $_POST['password']
				);
				$responce=$control->add_user_acc($data);
				if($responce=="done"){
					$control->redirect("http://localhost/inspection_management_system/index.php");
				}
				else{
					$error="2";
				}
			}
			else{
				$error="1";
			}
	}
}

$control->signup();

?>