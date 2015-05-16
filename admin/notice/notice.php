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
	$arr = array();
	$arr['title'] = $_REQUEST['title'];
	$arr['content'] = $_REQUEST['content'];
	$arr['state'] = $_REQUEST['state'];
	$arr['start_date'] = $_REQUEST['start_date'];
	$arr['end_date'] = $_REQUEST['end_date'];
	$arr['update_user'] = "1";
	$id = $_REQUEST['id'];
	
	try {
		$db->update("sys_notice",$arr,"where id=".$id);
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
		$db->update("sys_notice",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);
}elseif ($act == "save") {	
	$arr = array();
	$arr['title'] = $_REQUEST['title'];
	$arr['content'] = $_REQUEST['content'];
	$arr['state'] = $_REQUEST['state'];
	$arr['start_date'] = $_REQUEST['start_date'];
	$arr['end_date'] = $_REQUEST['end_date'];
	$arr['create_user'] = "1";
	$arr['create_date'] =   date("Y-m-d H:i:s");
	
	try {
		$db->insert("sys_notice",$arr);
		$result->result="1";
		$result->msg="添加成功。";
	
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result); 
}else {
	$smarty->display("admin/notice/notice.html");
}











