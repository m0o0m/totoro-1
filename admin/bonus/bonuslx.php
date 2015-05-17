<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php'; 

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array();   
	$arr['bonuslx_zq'] = $_REQUEST['bonuslx_zq'];
	$arr['bonuslx_bl'] = $_REQUEST['bonuslx_bl'];   
 	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	  
	$users = $db->get_page("player_bonuslx",$where);  
	echo json_encode($users); 
} elseif ($act == "save") {
	$arr = array(); 
	$arr['bonuslx_name'] = $_REQUEST['bonuslx_name']; 
	$arr['bonuslx_bl'] = $_REQUEST['bonuslx_bl']; 
	$arr['bonuslx_zq'] = $_REQUEST['bonuslx_zq'];  
	$arr['bonuslx_ffsj'] = $_REQUEST['bonuslx_ffsj'];
	$arr['create_user'] = 1;
	$arr['create_date'] = date("Y-m-d H:i:s");   
	try {
		$db->insert("player_bonuslx",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "lxlist") {
	$arr = array();  
	$sql=" SELECT id 'id',bonuslx_name 'text',create_date 'desc'
	from player_bonuslx where isdelete = 0";
	$rs = mysql_query($sql);
	$items = array(); 
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	echo json_encode($items);
}
elseif ($act == "update") {
	$arr = array();   
	$arr['bonuslx_name'] = $_REQUEST['bonuslx_name'];
	$arr['bonuslx_bl'] = $_REQUEST['bonuslx_bl']; 
	$arr['bonuslx_zq'] = $_REQUEST['bonuslx_zq'];   
	$arr['bonuslx_ffsj'] = $_REQUEST['bonuslx_ffsj'];
	$arr['update_user'] = 1;   
	$id = $_REQUEST['id']; 
	
	try {
		$db->update("player_bonuslx",$arr,"where id=".$id);
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
		$db->update("player_bonuslx",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/bonus/bonuslx.html");
}

?>