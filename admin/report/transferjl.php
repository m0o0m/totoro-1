<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php'; 

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array();   
	$arr['client_logn'] = $_REQUEST['client_logn']; 
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
	$je1 = $_REQUEST['transfer_je1'];
	$je2 = $_REQUEST['transfer_je2'];
	$arr['transfer_type']  = $_REQUEST['transfer_type'];
	
 	$where = " where isdelete = 0 "; 
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	if($je1 != ''){
		$where.= " and transfer_je >= $je1";
	}
	if($je2 != ''){
		$where.= " and transfer_je <= $je2";
	}
	
	if($stardate != ''){
		$where.= " and transfer_date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and transfer_date <= '$enddate 23:59:59'";
	} 
	$users = $db->get_page("allzb",$where);  
	echo json_encode($users); 
}else {
	$smarty->display("admin/report/transferjl.html");
}

?>