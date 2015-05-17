<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php'; 

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array();   
	$arr['client_logn'] = $_REQUEST['client_logn']; 
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
	
 	$where = " where isdelete = 0 "; 
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	if($stardate != ''){
		$where.= " and bonus_kssj >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and bonus_kssj <= '$enddate 23:59:59'";
	}
	
	$users = $db->get_page("player_bonus",$where);  
	echo json_encode($users); 
}elseif ($act == "sqbonus") {
	$arr = array();   
	$szbonus = mysql_query("select * from player_szbonus where client_logn='".$_REQUEST['client_logn']."'");
	$szbonusrow = mysql_fetch_array($szbonus); 
	if($szbonusrow["id"] != ""){ 
		$arr['blid'] = $szbonusrow["id"];
		$arr['client_id'] = $szbonusrow["client_id"];
		$arr['client_logn'] = $szbonusrow["client_logn"];
		$arr['bonus_bl'] = $szbonusrow["szbonus_bl"];
		$arr['bonus_zq'] = $szbonusrow["szbonus_zq"];
		$arr['bonus_kssj'] = date("Y-m-d H:i:s");
		$arr['bonus_jssj'] = date("Y-m-d H:i:s");
		$arr['bonus_yk'] = $_REQUEST['bonus_yk'];
		$arr['bonus_je'] = $_REQUEST["bonus_yk"]*$arr['bonus_bl']/100; 
		
		try {
			$db->insert("player_bonus",$arr);
			$result->result="1";
			$result->msg="申请成功。";
		
		}catch (Exception $e){
			$result->result="0";
			$result->msg="申请失败。";
		}
	}else{
		$result->result="0";
		$result->msg="申请失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();   
	$client_id = $_REQUEST['client_id'];
	$arr['bonus_state'] = $_REQUEST['bonus_state'];
	$arr['bonus_user'] = "1"; 
	$arr['bonus_desc'] = $_REQUEST['bonus_desc'];  
	$bonus_je = $_REQUEST['bonus_je'];
	$arr['bonus_date'] = date("Y-m-d H:i:s"); 
	$id = $_REQUEST['id']; 
	if($arr['bonus_state'] == 1){
		try {  
				$db->db->query('begin '); //开始事务 
				$db->update("player_bonus",$arr,"where id=".$id);
				$db->db->query("update player_client  set client_balance = (client_balance + $bonus_je) where id=".$client_id );
				
				$db->db->query('commit');//提交
				$result->result="1";
				$result->msg="审核成功。"; 
			
		}catch (Exception $e){ 
			$db->db->query('rollback'); //回滚
			$result->result="0";
			$result->msg="审核失败。";
		}
	}else{
		$result->result="1";
		$result->msg="审核完毕。";
	}
	echo json_encode($result);  

}elseif ($act == "delete") { 
	$arr = array();	
	$id = $_REQUEST['id'];
	$arr['isdelete'] = 1; 
	
	try {
		$db->update("player_bonus",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/bonus/bonus.html");
}

?>