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
	$arr['client_status'] = $_REQUEST['client_status'];
	$arr['client_logname'] = $_REQUEST['client_logname'];
	
	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	$users = $db->get_page("bns_client",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
} elseif ($act == "save") {
	$arr = array(); 
	
	$arr['client_logname'] = $_REQUEST['client_logname'];
	$arr['client_pw'] = $_REQUEST['client_pw'];
	$arr['client_nickname'] = $_REQUEST['client_nickname'];
	$arr['client_type'] = $_REQUEST['client_type']; 
	$arr['client_status'] = $_REQUEST['client_status'];
	$arr['client_freeze'] = $_REQUEST['client_freeze']; 
	$arr['sysuser_id'] = "1";
	$arr['client_mac'] = "1";
	$arr['client_ip'] = "191.23.21.1";
	$arr['czdate'] = "sysdate"; 
	
	try {
		$db->insert("bns_client",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();
	$arr['client_logname'] = $_REQUEST['client_logname'];
	$arr['client_pw'] = $_REQUEST['client_pw'];
	$arr['client_nickname'] = $_REQUEST['client_nickname'];
	$arr['client_type'] = $_REQUEST['client_type']; 
	$arr['client_status'] = $_REQUEST['client_status'];
	$arr['client_freeze'] = $_REQUEST['client_freeze']; 
	$arr['sysuser_id'] = "1";
	$arr['client_mac'] = "1";
	$arr['client_ip'] = "191.23.21.1";
	$arr['czdate'] = "sysdate"; 
	$id = $_REQUEST['id'];
	 
	try {
		$db->update("bns_client",$arr,"where id=".$id);
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
		$db->update("bns_client",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/user/client.html");
}

?>