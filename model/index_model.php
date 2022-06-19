<?php
require_once(dirname(__FILE__).'\db.php');
class Index_Model extends dbconn
{
	public function __construct()
	{
		parent::__construct();
	}
	public function get_all_login_records()
	{
		return $this->Select('login','*',"","","","","");
	}
	public function check_login_records($data)
	{
		$where['email_id']=$data['email'];
		return $this->Select('login','*',$where,"","","","");
	}
	public function get_inspector_list(){
		$where['type']='inspector';
		return $this->Select('login','login_id,full_name',$where,"","","","");
	}

	public function inspection_data($id)
	{
		$where['inspection_id']=$id;
		$value=['primary','working','quality','site','environmental','protection','tool','miscellaneous','number'];
    	$ids=$this->Select('inspections',"*",$where,"","","","");
    	foreach ($value as $table){
			$table_where=[];
			$table_where[$table.'_id']=$ids[0][$table.'_id'];
			
			
			$responce=$this->Select($table.'_table',"*",$table_where,"","","","");
			$values[$table]=$responce[0];
		}
		$valuess=array_merge($ids, $values);
		return($valuess);
	}

	public function inspection($id)
	{
		$value=$this->inspection_data($id);
		if($_SESSION['type']=="inspector"){
			//$where['user_id']=$_SESSION['User_id'];
			//return $this->Select('inspection',"*",$where,"","","","");
		}
		else
		if($_SESSION['type']=="manager"){
			return $this->Select('inspection',"*",$where,"","","","");
		}
		else
		if($_SESSION['type']=="admin"){
			return $this->Select('inspection',"*",$where,"","","","");
		}
	}
	public function get_all_list()
	{
		return $this->Select('inspection',"*","","","","","");
	}
	public function get_all_manager_list($date,$from,$to,$inspector)
	{
		$to=$to." 23:59:59";
		$from=$from." 00:00:00";
		
		//$query=SELECT * FROM `inspection` INNER JOIN `login` WHERE inspection.user_id=login.login_id;
		//$where['manager_id']=$_SESSION['User_id'];
		$query=" SELECT * FROM inspections INNER JOIN primary_table  WHERE  inspections.manager_id='$_SESSION[User_id]' AND inspections.submited_date < '$to' AND inspections.submited_date > '$from' AND primary_table.primary_id=inspections.primary_id order by inspections.submited_date $date ";
		return $this->Execute($query); 
		//return $this->Select('inspection',"*",$where,"created_on",$date,"","");
	}

	public function get_all_manager_list_2($year)
	{
		$months = array(
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
);
		foreach ($months as $key=>$month){
			$date='-0'.($key+1).'-';
			$query=" SELECT inspections.inspector_id,number_table.* FROM inspections INNER JOIN number_table WHERE inspections.number_id=number_table.number_id AND inspections.submited_date LIKE '%$date%'";
		 $responce=$this->Execute($query);
		 if(!empty($responce))
		 $value[$month]=$responce;
		 else
		 	$value[$month]="0";
		}
		//print_r($value);
		return $value;
	}
	public function get_all_user_list($date,$from,$to,$inspector)
	{
		//$where['user_id']=$_SESSION['User_id'];
		$query=" SELECT * FROM inspections INNER JOIN primary_table  WHERE  inspections.inspector_id='$_SESSION[User_id]' AND inspections.submited_date < '$to' AND inspections.submited_date > '$from' AND primary_table.primary_id=inspections.primary_id order by inspections.submited_date $date ";
		return $this->Execute($query); 
		//return $this->Select('inspection',"*",$where,"created_on",$date,"","");
	}


	public function add_new_inspection($data)
	{
		/*$data["created_on"]=date("Y-m-d H:i:s");
		$data["last_edited"]=date("Y-m-d H:i:s");		
		return $this->Insert('inspection',$data);*/
		foreach($data as $key => $eachtable){
			$id[$key]=$this->Insert($key."_table",$eachtable);
		}
		$inspection["submited_date"]=date("Y-m-d H:i:s");
		$inspection["inspector_id"]=$_SESSION['User_id'];
		$inspection['manager_id']=$_SESSION['Manager_id'];
		$inspection['active']='1';
		foreach ($id as $key=>$value){
			$inspection[$key."_id"]=$value;
		}
		//$inspection["last_edited"]=date("Y-m-d H:i:s");
		$this->Insert("inspections",$inspection);
		//print_r($id);
		/*foreach($data as $key => $eachtable){
			//print_r($eachtable);
			$query="";
			$query="CREATE TABLE ".$key."_table  ( ";
			$query=$query.$key."_id INT NOT NULL AUTO_INCREMENT, ";
			foreach ($eachtable as $keyof => $value){
				$query=$query.$keyof." VARCHAR(100) , ";
			}
			$query=$query." PRIMARY KEY ( ".$key."_id ));";
    		//echo $query;
			$this->Execute($query);
		}*/
	}
	public function add_acc($value)
	{
		print_r($value);
		$data['email_id']=$value['email'];
		$data['password']=md5($value['password']);
		$data['full_name']=$value['full_name'];
		$data['manager_id']='2';
		$data['type']="inspector";
		$data['verify_flag']='1';
		$data['created_on']=date("Y-m-d H:i:s");;
		$data['last_login']=date("Y-m-d H:i:s");;
		

		$this->Insert("login",$data);
	}
	function update_password($id,$data)
	{
		$this->Update("login",$data,$id);
	}
	
}





