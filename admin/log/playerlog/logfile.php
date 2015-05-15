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
		$where.= " and logfile_logdate >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and logfile_logdate <= '$enddate 23:59:59'";
	}
	 
	$users = $db->get_page("player_logfile ",$where); 
	echo json_encode($users); 
	
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	 
}elseif ($act == "update") {
	  
}elseif ($act == "delete") { 
	$arr = array();
	$id = $_REQUEST['id'];
	$arr['isdelete'] = 1;
	
	try {
		$db->update("player_logfile",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	echo json_encode($result);
}else {
	$smarty->display("admin/log/playerlog/logfile.html");
}

?>