<?php 
define('IN_ECS', true);

//require_once '/totoro/commons/init.php';

require_once dirname(__FILE__).'/../../../commons/init.php';
//require_once '../commons/init.php';

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	
	$arr = array(); 
	$arr['logfile_logn'] = $_REQUEST['logfile_logn']; 
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
	
	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if(!empty($vs)){
			$where.= "and $ks = $vs";
		} 
	}
	if($stardate != ''){
		$where.= " and logfile_logdate >= '$stardate'";
	}
	if($enddate != ''){
		$where.= " and logfile_logdate <= '$enddate'";
	}
	$users = $db->get_page("sys_logfile ",$where); 
	echo json_encode($users); 
	
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	 
}elseif ($act == "update") {
	  
}elseif ($act == "delete") { 
	 
}else {
	$smarty->display("admin/log/syslog/syslog.html");
}

?>