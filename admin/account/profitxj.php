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
	$arr['client_logn'] = $_REQUEST['client_logn'];
	
	$where = "where 1=1 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		}
	} 
	
	if($stardate != ''){
		$where.= " and date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and date <= '$enddate 23:59:59'";
	}
	
	$users = $db->get_page("allyk",$where." and fid= 1");  
	echo json_encode($users); 
}else {
	$smarty->display("admin/account/profitxj.html");
}

?>