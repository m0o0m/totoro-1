<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php';  
$act = $_REQUEST[act]; 
if (empty($act)) { 
	$act = "";	
}

if ($act == "list") {   
	$lxname = isset($_POST['lxname']) ? mysql_real_escape_string($_POST['lxname']) : '';
	$lxcode = isset($_POST['lxcode']) ? mysql_real_escape_string($_POST['lxcode']) : ''; 
	$where = "lxcode like '$lxcode%' and lxname like '$lxname%'";
	
	$users = $db->get_page("sys_booktype "," where  "+$where);  
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	$arr = array();
	$arr['booktype_name'] = $_REQUEST['booktype_name'];
	$arr['booktype_code'] = $_REQUEST['booktype_code'];
	$arr['booktype_desc'] = $_REQUEST['booktype_desc'];
	$id = $_REQUEST['id'];
	
	if(empty($id)){
		try {
			$db->insert("sys_booktype",$arr);
			$result->result="1";
			$result->msg="添加数据类型“".$arr['booktype_name']."”成功。";
		}catch (Exception $e){
			$result->result="0";
			$result->msg="添加数据类型“".$arr['booktype_name']."”失败。";
		} 
	}else{		
		$db->update("sys_booktype",$arr,"where id=".$id);	
		$result->result="1";
		$result->msg="修改数据类型“".$arr['booktype_name']."”成功。";
	}  
	
	echo json_encode($result);
}elseif ($act == "update") {
	
	$arr = array();
	$arr['booktype_name'] = $_REQUEST['booktype_name'];
	$arr['booktype_code'] = $_REQUEST['booktype_code'];
	$arr['booktype_desc'] = $_REQUEST['booktype_desc']; 
	$id = $_REQUEST['id'];
	$db->update("sys_booktype",$arr,"where id=".$id);
	$result->result="1";
	$result->msg="修改数据类型“".$arr['booktype_name']."”成功。";
	echo json_encode($result);
	
}elseif ($act == "delete") {
	$id = $_REQUEST['id'];
	try {
		$db->delete("sys_booktype","where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg= $e;
	}
	echo json_encode($result);
}else {
	try {   
		  $smarty->display("admin/code/booktype.html"); 
	} catch (Exception $e) {   
		print $e->getMessage();  
	}   
}
?>
	
	 

