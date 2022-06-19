<?php
require_once 'control/main_control.php';
$control=new Index();

if($_POST){
	$action=$_POST['Submit']; 
	$data=$_POST;
	if ($action=='Submit')
	{	
		/*echo "<pre>";
        print_r($_POST);
		echo "</pre>";
        $count=0;
        foreach ($data as $a){
            $count=$count+1;
        }
        echo $count;*/
        $control->add_inspection($data);
        $control->redirect("http://localhost/inspection_management_system/inspection_list.php?from_date=2022-03-01&to_date=2022-04-05&date=ASC&submit=btnsubmit");	
	}	
	
}
$control->inspection();

?>


<?php

/*

10Array
(
    [primary] => 7
    [working] => 6
    [quality] => 6
    [site] => 6
    [environmental] => 6
    [protection] => 6
    [tool] => 6
    [miscellaneous] => 6
    [number] => 6
)



    




*/


    ?>