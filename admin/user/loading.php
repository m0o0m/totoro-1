<?php 
define('IN_ECS', true);
require_once dirname(__FILE__).'/../../commons/init.php';
$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
// 	$arr = array(); 
// 	$arr['bns_loading_no'] = $_REQUEST['bns_loading_no'];
// 	$arr['booktype_code'] = $_REQUEST['booktype_code'];  
 	$where = " where isdelete = 0 ";
// 	foreach ($arr as $ks=>$vs){
// 		if(!empty($vs)){
// 			$where.= "and $ks = '$vs'";
// 		} 
// 	} 
	$users = $db->get_page("bns_loading",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	$arr = array();   
	$arr['client_id'] = "1";
	$arr['client_logname'] = "client_logname";
	$arr['loading_yhordernum'] = $_REQUEST['loading_yhordernum']; 
	$arr['loading_amount'] = $_REQUEST['loading_amount'];
	$arr['loading_bankid'] = $_REQUEST['loading_bankid'];
	$arr['loading_czaccount'] = $_REQUEST['loading_czaccount'];
	$arr['loading_czbankacname'] = $_REQUEST['loading_czbankacname'];
	$arr['loading_ps'] = $_REQUEST['loading_ps'];
	$arr['loading_date'] = "sysdate"; 
	
	try {
		$db->insert("bns_loading",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
// 	$arr = array();
// 	$arr['bns_loading_no'] = $_REQUEST['bns_loading_no'];
// 	$arr['bns_loading_value'] = $_REQUEST['bns_loading_value'];
// 	$arr['booktype_code'] = $_REQUEST['booktype_code'];
// 	$arr['czdate'] = "sysdate";	
	$id = $_REQUEST['id'];
	 
	try {
		$db->update("bns_loading",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="修改成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="修改失败。";
	}
	echo json_encode($result);  
}elseif ($act == "delete") { 
// 	$arr = array();	
// 	$id = $_REQUEST['id'];
// 	$arr['isdelete'] = 1; 
	
// 	try {
// 		$db->update("bns_loading",$arr,"where id=".$id);
// 		$result->result="1";
// 		$result->msg="删除成功。";
// 	}catch (Exception $e){
// 		$result->result="0";
// 		$result->msg="删除失败。";
// 	}
	 
//	echo json_encode($result);	
}else {
	$smarty->display("admin/code/loading.html");
}

?>