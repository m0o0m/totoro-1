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
 	$where = " where isdelete = 0 and load_fkstate != 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	} 
	if($stardate != ''){
		$where.= " and load_date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and load_date <= '$enddate 23:59:59'";
	} 
	$users = $db->get_page("loadsh_user_xtyh",$where); 
	echo json_encode($users);  
}else {
	$smarty->display("admin/report/loadls.html");
}

?>