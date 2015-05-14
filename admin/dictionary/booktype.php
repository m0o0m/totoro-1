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
	$arr['booktype_name'] = $_REQUEST['booktype_name'];
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
	$arr['booktype_code'] = $_REQUEST['booktype_code'];
	$arr['booktype_name'] = $_REQUEST['booktype_name'];
	$arr['booktype_desc'] = $_REQUEST['booktype_desc'];
	$arr['create_user'] = "1";
	$arr['create_date'] = date("Y-m-d H:i:s");
	
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
	$arr['booktype_code'] = $_REQUEST['booktype_code'];
	$arr['booktype_name'] = $_REQUEST['booktype_name'];
	$arr['booktype_desc'] = $_REQUEST['booktype_desc'];
	$arr['update_user'] = "1";
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
	$smarty->display("admin/dictionary/booktype.html");
}

?>