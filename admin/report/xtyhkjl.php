<?php 
define('IN_ECS', true);

//require_once '/totoro/commons/init.php';

require_once dirname(__FILE__).'/../../commons/init.php';
//require_once '../commons/init.php';

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array();  
	$arr['xtyhk_mc'] = $_REQUEST['xtyhk_mc'];
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];   
	$arr['bank_type'] = $_REQUEST['bank_type'];
	
 	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	if($stardate != ''){
		$where.= " and czdate >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and czdate <= '$enddate 23:59:59'";
	} 
	
	$users = $db->get_page("xtyhk_tczb",$where);  
	echo json_encode($users); 
}else {
	$smarty->display("admin/report/xtyhkjl.html");
}

?>