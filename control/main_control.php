<?php
require_once(dirname(__FILE__).'\controller.php');
class Index extends Controller {
    function __construct() {
		parent::__construct();
		require_once 'model/index_Model.php';
		$this->index_model=new Index_Model();
		$this->login['error']['invalid']=0;
		if(empty($_SESSION)){
			$this->clear_session();
		}
	}


	function add_inspection($value)
	{
		if($_SESSION['User_id']!=NULL){
			if($_SESSION['type']=="inspector"){
				array_pop($value);
				//$value['user_id']=$_SESSION['User_id'];
				//$value['manager_id']=$_SESSION['Manager_id'];
				$responce=$this->index_model->add_new_inspection($value);
				return true;
			}
		}
		return false;
	}
	
	
	function apply_job($job_id)
	{
		$this->apply_status=$this->index_model->get_apply_status($job_id);
		if(empty($this->apply_status))
		{
			$this->index_model->apply_job($job_id);
		}
	}
	function get_inspection($id)
	{
		if($_SESSION["User_id"]!=NULL){
			//if($_SESSION['type']=="inspector")
			{
				$this->inspection=$this->index_model->inspection_data($id);
				return $this->inspection;	
			}	
		}
		
	}

	// function list_of_inspectors()
	// {
	// 	if($_SESSION["User_id"]!=NULL)
	// 		if($_SESSION['type']=="manager"){
	// 			$this->inspector_list=$this->index_model->inspector_list();
	// 		}
	// }

	function get_inspection_list($date,$from,$to,$inspector)
	{

		$user_type=$_SESSION['type'];
		if($user_type=="admin"){
			$this->inspection_list=$this->index_model->get_all_list();
		}
		else
			if($user_type=="manager"){
				$this->inspection_list=$this->index_model->get_all_manager_list($date,$from,$to,$inspector);
		}
		else{
			$this->inspection_list=$this->index_model->get_all_user_list($date,$from,$to,$inspector);
		}
		
	}
	function report_data()
	{
		$date="ASC";
		$inspector='null';
		$user_type=$_SESSION['type'];
		if($user_type=="admin"){
			$this->inspection_list=$this->index_model->get_all_list();
		}
		else
			if($user_type=="manager"){
				$this->inspection_list=$this->index_model->get_all_manager_list_2("2022");
		}
		
	}

	function clear_session()
	{
		$_SESSION['User_id']=NULL;
		$_SESSION['type']=NULL;
	}
	function verify_email($value)
	{
		$value_login= $this->index_model->check_login_records($value);
		if(empty($value_login)){
			return "no-email";
		}
		else{
			return "email-exist";
		}
	}
	function add_user_acc($value){
		$responce=$this->verify_email($value);
		if($responce=="no-email"){

			$this->index_model->add_acc($value);
			//$this->verify_login($value);
			return "done";
		}
		return "error";
		
	}
	/*
	function upload_cv_data($value)
	{
		$this->index_model->upload_cv_data_db($value);
	}*/
	function verify_login($value)
	{
		$value_login= $this->index_model->check_login_records($value);
		if(empty($value_login)){
			$this->login['error']['invalid']=2;
		}
		else{
			if($value_login[0]['password']==md5($value['password']))
			{
				$_SESSION['User_id']=$value_login[0]['login_id'];
				$_SESSION['Manager_id']=$value_login[0]['manager_id'];
				$_SESSION['type']=$value_login[0]['type'];
				$this->login['error']['invalid']=0;
			}
			else {
				$_SESSION['User_id']=NULL;
				$_SESSION['Manager_id']=NULL;
				$_SESSION['type']=NULL;
				$this->login['error']['invalid']=1;
			}
		}
	}

	function update_login($value)
	{
		//$data
		$value_login= $this->index_model->check_login_records($value);
		print_r($value_login);
		if(!empty($value_login)){
			if($value_login[0]['type']!='admin'){
				$id['login_id']=$value_login[0]['login_id'];
			$data_update = array(
     		'password' =>md5($value['password'])
     		 );
			$this->upd_details=$this->index_model->update_password($id,$data_update);
			//$this->send_mail_password("Your Password for happytech portal has been changed.");
			}
		}
	}
	function redirect($url, $permanent = false)
	{
	    header('Location: ' . $url, true, $permanent ? 301 : 302);
	    exit();
	}

}

?>