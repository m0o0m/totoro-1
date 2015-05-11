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
	$arr['sys_booktype_name'] = $_REQUEST['sys_booktype_name'];
	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if(!empty($vs)){
			$where.= "and $ks = $vs";
		} 
	}
	
	$users = $db->get_page("sys_booktype",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	$arr = array();
	$arr['sys_booktype_code'] = $_REQUEST['sys_booktype_code'];
	$arr['sys_booktype_name'] = $_REQUEST['sys_booktype_name'];
	$arr['sys_booktype_desc'] = $_REQUEST['sys_booktype_desc'];
	$arr['czdate'] = "sysdate";
	
	try {
		$db->insert("sys_booktype",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();
	$arr['sys_booktype_code'] = $_REQUEST['sys_booktype_code'];
	$arr['sys_booktype_name'] = $_REQUEST['sys_booktype_name'];
	$arr['sys_booktype_desc'] = $_REQUEST['sys_booktype_desc'];
	$arr['czdate'] = "sysdate";
	$id = $_REQUEST['id'];
	
	try {
		$db->update("sys_booktype",$arr,"where id=".$id);
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
		$db->update("sys_booktype",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/code/booktype.html");
}

?>