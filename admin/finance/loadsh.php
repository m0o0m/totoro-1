<?php 
define('IN_ECS', true);
require_once dirname(__FILE__).'/../../commons/init.php';
$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array(); 
	$arr['load_fkstate'] = $_REQUEST['load_fkstate'];
	$arr['client_logn'] = $_REQUEST['client_logn']; 
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
 	$where = " where isdelete = 0 and load_fkstate = 0";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	} 
	if($stardate != ''){
		$where.= " and load_date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and load_date <= '$enddate 23:59:59'";
	}
	
	$users = $db->get_page("loadsh_user_xtyh",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") {
// 	$arr = array();     
// 	$arr['load_fkstate'] = $_REQUEST['load_fkstate']; 
// 	$arr['load_shuser'] = "1";
// 	$arr['load_desc'] = $_REQUEST['load_desc']; 
// 	$arr['load_sjdz'] = $_REQUEST['load_sjdz'];  
// 	$arr['load_sxf'] = $_REQUEST['load_sxf'];
// 	try {
// 		$db->insert("player_load",$arr);
// 		$result->result="1";
// 		$result->msg="添加成功。";
		
// 	}catch (Exception $e){
// 		$result->result="0";
// 		$result->msg="添加失败。";
// 	}
// 	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();
	$arr['load_fkstate'] = $_REQUEST['load_fkstate']; 
	$arr['load_shuser'] = "1";
	$arr['load_desc'] = $_REQUEST['load_desc']; 
	$arr['load_sjdz'] = $_REQUEST['load_sjdz']; 
	$arr['load_fkdate'] =date("Y-m-d H:i:s"); 
	$id = $_REQUEST['id']; 
	try {
		$db->db->query('begin '); //开始事务
		
		$db->update("player_load",$arr,"where id=".$id); 
		if($arr['load_fkstate'] == 2){ 	
			
			
			$client_balance = mysql_query("select client_balance from player_client  where id=".$_REQUEST['client_id'] );
			$row = mysql_fetch_array($client_balance); 
			$balance = $row['client_balance'];//当前账户余额
			$freeze = $row['client_freeze'];//当前冻结余额
			
			$db->db->query("update sys_zh  set zh_balance = (zh_balance+".$arr['load_sjdz']." ) where zh_iszzh = 0");				
			$db->db->query("update player_client  set client_balance = (client_balance+".$arr['load_sjdz'].") where id=".$_REQUEST['client_id'] );
			
			//写入冲提账变表  
			$zbarr = array();
			$zbarr['client_id'] = $_REQUEST['client_id']; 
			$zbarr['client_logn'] = $_REQUEST['client_logn'];
			$zbarr['tczb_num'] = $_REQUEST['load_num'];
			$zbarr['tczb_type'] = "3";//充值
			$zbarr['tczb_amount'] = $_REQUEST['load_sjdz'];
			$zbarr['tczb_balance1'] = $balance;
			$zbarr['tczb_balance2'] = $balance+$arr['load_sjdz'];
			$zbarr['tczb_djje1'] = $freeze;
			$zbarr['tczb_djje1'] = $freeze;
			$zbarr['xtyhk_id'] = $_REQUEST['xtyhk_id'];
			$zbarr['xtyhk_num'] = $_REQUEST['xtyhk_num'];
			$zbarr['xtyhk_name'] = $_REQUEST['xtyhk_name'];
			$zbarr['czdate'] = date("Y-m-d H:i:s"); 
			$db->insert("player_tczb",$zbarr);
			$db->db->query('commit');//提交
		}
		$result->result="1";
		$result->msg="审核完毕。";
	}catch (Exception $e){
		$db->db->query('rollback'); //回滚
		$result->result="0";
		$result->msg="审核失败。";
	}
	echo json_encode($result);  
}elseif ($act == "delete") { 
	$arr = array();	
	$id = $_REQUEST['id'];
	$arr['isdelete'] = 1; 
	
	try {
		$db->update("player_load",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/finance/loadsh.html");
}

?>