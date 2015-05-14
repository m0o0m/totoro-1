<?php

define('IN_ECS', true);
require_once dirname(__FILE__).'/../../commons/init.php';

$act = $_REQUEST[act];
if (empty($act)) {
	$act = "";	
}


if ($act == "list") { 

	$arr = array();
	$arr['user_logn'] = $_REQUEST['user_logn'];
	$arr['user_status'] = $_REQUEST['user_status'];  
	$where = " where isdelete = 0 ";
	
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	$result = $db->get_page("sys_notice",$where); 
	echo json_encode($result);	
	
}elseif ($act == "add") {
	
}elseif ($act == "update") {
	
}elseif ($act == "delete") { 
	
}elseif ($act == "save") {	
	
	foreach($_REQUEST as $k=>$v ) {
		
	}
	$db->insert("sys_notice");
	
}else {
	$smarty->display("admin/notice/notice.html");
}











