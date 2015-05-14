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
	
	$where = " where isdelete = 0 ";
// 	foreach ($arr as $ks=>$vs){
// 		if($vs != ""){
// 			$where.= "and $ks = '$vs'";
// 		} 
// 	}
	
	if($stardate != ''){
		$where.= " and create_date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and create_date <= '$enddate 23:59:59'";
	}
	$users = $db->get_page("sys_zh",$where); 
	 
	echo json_encode($users); 
}elseif ($act == "add") {
	
} elseif ($act == "save") {
	$arr = array(); 
	
	$arr['zh_name'] = $_REQUEST['zh_name'];
	$arr['zh_desc'] = $_REQUEST['zh_desc'];
	$arr['zh_balance'] = $_REQUEST['zh_balance'];
	$arr['zh_iszzh'] = $_REQUEST['zh_iszzh']; 
	$arr['create_user'] = "1"; 
	$arr['create_date'] = date("Y-m-d H:i:s");  
	
	try {
		$db->insert("sys_zh",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();
		$arr['zh_name'] = $_REQUEST['zh_name'];
	$arr['zh_desc'] = $_REQUEST['zh_desc'];
	$arr['zh_balance'] = $_REQUEST['zh_balance'];
	$arr['zh_iszzh'] = $_REQUEST['zh_iszzh'];  
	$arr['update_user'] = "1"; 
	$id = $_REQUEST['id'];
	 
	try {
		$db->update("sys_zh",$arr,"where id=".$id);
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
		$db->update("sys_zh",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/user/syszh.html");
}

?>