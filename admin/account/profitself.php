<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php'; 

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array();    
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
	
   $where = " where id= 1";
	
	if($stardate != ''){
		$where.= " and date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and date <= '$enddate 23:59:59'";
	}
	
	$users = $db->get_page("allyk",$where);  
	echo json_encode($users); 
}else {
	$smarty->display("admin/account/profitself.html");
}

?>