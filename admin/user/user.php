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
<<<<<<< HEAD
	
	$arr = array();
	$arr['username'] = $_REQUEST['username'];
	
	$where = " 1=1 ";
	foreach ($arr as $value){
		//$where.= 
	}
	
	$users = $db->get_page("xy_sys_user",$where);
=======
	//where username='admin'
	$users = $db->get_page("sys_user","");
>>>>>>> 0cf1331a2e9fc50ce088904993d42b035a47c7ff
	echo json_encode($users);
	//print($users);
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	$arr = array();
	$arr['username'] = $_REQUEST['username'];
	$arr['password'] = $_REQUEST['password'];
	$arr['email'] = $_REQUEST['email'];
	
	try {
		$db->insert("xy_sys_user",$arr);
		$result->result="1";
		$result->msg="添加用户".$arr['username']."成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加用户".$arr['username']."失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();
	$arr['username'] = $_REQUEST['username'];
	$arr['password'] = $_REQUEST['password'];
	$arr['email'] = $_REQUEST['email'];
	$id = $_REQUEST['id'];
	$db->update("xy_sys_user",$arr,"where id=".$id);
}elseif ($act == "delete") {
	
	$id = $_REQUEST['id'];
	try {
		//$db->delete("xy_sys_user","where id=".$id);
		$result->result="1";
		$result->msg="删除用户".$arr['username']."成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除用户".$arr['username']."失败。";
	}
	echo json_encode($result);	
}else {
	$smarty->display("admin/user/list.html");
}

?>