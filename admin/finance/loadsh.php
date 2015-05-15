<?php 
define('IN_ECS', true);
require_once dirname(__FILE__).'/../../commons/init.php';
$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array(); 
	$arr['load_fkstate'] = $_REQUEST['load_fkstate'];
	$arr['client_logn'] = $_REQUEST['client_logn']; 
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
 	$where = " where isdelete = 0 ";
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
	
	$users = $db->get_page("player_load",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	$arr = array();     
	$arr['load_fkstate'] = $_REQUEST['load_fkstate']; 
	$arr['load_shuser'] = "1";
	$arr['load_desc'] = $_REQUEST['load_desc']; 
	$arr['load_sjdz'] = $_REQUEST['load_sjdz'];  
	$arr['load_sxf'] = $_REQUEST['load_sxf'];
	try {
		$db->insert("player_load",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();
	$arr['load_fkstate'] = $_REQUEST['load_fkstate']; 
	$arr['load_shuser'] = "1";
	$arr['load_desc'] = $_REQUEST['load_desc']; 
	$arr['load_sjdz'] = $_REQUEST['load_sjdz'];
	$id = $_REQUEST['id'];
	 
	try {
		$db->update("player_load",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="修改成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="修改失败。";
	}
	echo json_encode($result);  
}elseif ($act == "delete") { 
	$arr = array();	
	$id = $_REQUEST['id'];
	$arr['isdelete'] = 1; 
	
	try {
		$db->update("player_load",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/finance/loadsh.html");
}

?>