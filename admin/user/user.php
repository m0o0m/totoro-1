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
	$arr['user_logn'] = $_REQUEST['user_logn'];
	$arr['user_status'] = $_REQUEST['user_status'];  
	$where = " where isdelete = 0 ";
	
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	$result = $db->get_page("sys_user",$where); 
	echo json_encode($result);	
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	$arr = array();
	$arr['user_logn'] = $_REQUEST['user_logn'];
	$arr['user_pw'] = $_REQUEST['user_pw'];
	$arr['user_name'] = $_REQUEST['user_name'];
	$arr['user_email'] = $_REQUEST['user_email'];
	$arr['user_sex'] = $_REQUEST['user_sex'];
	$arr['user_mobile'] = $_REQUEST['user_mobile'];
	$arr['user_status'] = $_REQUEST['user_status'];
	$arr['user_QQnum'] = $_REQUEST['user_QQnum'];
	$arr['user_ip'] = $_REQUEST['user_ip']; 
	$arr['user_createdate'] = date("Y-m-d H:i:s"); 
	
	try {
		$db->insert("sys_user",$arr);
		$result->result="1";
		$result->msg="添加用户".$arr['user_logn']."成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加用户".$arr['user_logn']."失败。";
	}
	echo json_encode($result);	
	
}elseif ($act == "update") {
	$arr = array();
	$arr['user_logn'] = $_REQUEST['user_logn']; 
	$arr['user_name'] = $_REQUEST['user_name'];
	$arr['user_email'] = $_REQUEST['user_email'];
	$arr['user_sex'] = $_REQUEST['user_sex'];
	$arr['user_mobile'] = $_REQUEST['user_mobile'];
	$arr['user_status'] = $_REQUEST['user_status'];
	$arr['user_QQnum'] = $_REQUEST['user_QQnum'];
	$arr['user_ip'] = $_REQUEST['user_ip']; 
	$id = $_REQUEST['id'];

	try {
		$db->update("sys_user",$arr,"where id=".$id);
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
		$db->update("sys_user",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/user/list.html");
}

?>