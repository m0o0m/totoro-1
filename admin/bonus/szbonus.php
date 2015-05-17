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
	$arr['client_logn'] = $_REQUEST['client_logn'];
	$arr['szbonus_zq'] = $_REQUEST['szbonus_zq'];
	$arr['szbonus_bl'] = $_REQUEST['szbonus_bl'];  
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate']; 
	
 	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	if($stardate != ''){
		$where.= " and szbonus_qssj >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and szbonus_qssj <= '$enddate 23:59:59'";
	} 
	
	$users = $db->get_page("player_szbonus",$where);  
	echo json_encode($users); 
} elseif ($act == "save") {
	$arr = array();  
	//  $arr['client_id'] = $_REQUEST['client_id']; 
	// 	$arr['client_logn'] = $_REQUEST['client_logn'];  
	// 	$arr['szbonus_bl'] = $_REQUEST['szbonus_bl']; 
	// 	$arr['szbonus_zq'] = $_REQUEST['szbonus_zq']; 
	// 	$arr['szbonus_qssj'] = $_REQUEST['szbonus_qssj']; 
	//$arr['create_date'] = date("Y-m-d H:i:s");   
// 	try {
// 		$db->insert("player_szbonus",$arr);
// 		$result->result="1";
// 		$result->msg="添加成功。";
		
// 	}catch (Exception $e){
// 		$result->result="0";
// 		$result->msg="添加失败。";
// 	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();  
	$arr['szbonus_bl'] = $_REQUEST['szbonus_bl']; 
	$arr['szbonus_zq'] = $_REQUEST['szbonus_zq']; 
	$arr['szbonus_qssj'] = $_REQUEST['szbonus_qssj']; 
	$arr['szbonus_ffsj'] = $_REQUEST['szbonus_ffsj']; 
	$arr['szbonus_isyx'] = $_REQUEST['szbonus_isyx']; 
	$arr['update_user'] = "1";   
	$arr['update_date'] = date("Y-m-d H:i:s"); 
	$id = $_REQUEST['id']; 
	
	try {
		$db->update("player_szbonus",$arr,"where id=".$id);
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
		$db->update("player_szbonus",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/bonus/szbonus.html");
}

?>