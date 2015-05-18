<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php'; 

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array();    
	$arr['bonusbl_bl'] = $_REQUEST['bonusbl_bl'];   
 	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	} 
	$users = $db->get_page("bl_zq",$where);  //视图
	echo json_encode($users); 
} elseif ($act == "save") {
	$arr = array(); 
	$arr['bonuszq_id'] = $_REQUEST['bonuszq_id'];
	$arr['bonusbl_name'] = $_REQUEST['bonusbl_name']; 
	$arr['bonusbl_bl'] = $_REQUEST['bonusbl_bl'];  
	$arr['bonusbl_zjsx'] = $_REQUEST['bonusbl_zjsx']; 
	$arr['bonusbl_zjxx'] = $_REQUEST['bonusbl_zjxx'];
	$arr['create_user'] = 1;
	$arr['create_date'] = date("Y-m-d H:i:s");   
	try {
		$db->insert("player_bonusbl",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
} 
elseif ($act == "update") {
	$arr = array();    
	$arr['bonuszq_id'] = $_REQUEST['bonuszq_id'];
	$arr['bonusbl_name'] = $_REQUEST['bonusbl_name']; 
	$arr['bonusbl_bl'] = $_REQUEST['bonusbl_bl'];  
	$arr['bonusbl_zjsx'] = $_REQUEST['bonusbl_zjsx']; 
	$arr['bonusbl_zjxx'] = $_REQUEST['bonusbl_zjxx'];
	$arr['update_user'] = 1;   
	$id = $_REQUEST['id']; 
	
	try {
		$db->update("player_bonusbl",$arr,"where id=".$id);
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
		$db->update("player_bonusbl",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/bonus/bonusbl.html");
}

?>