<?php 
define('IN_ECS', true);
require_once dirname(__FILE__).'/../../commons/init.php';
$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array(); 
	$arr['withdraw_shstate'] = $_REQUEST['withdraw_shstate'];
	$arr['client_logn'] = $_REQUEST['client_logn'];    
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
 	$where = " where isdelete = 0 and Withdraw_shstate = 0"; 
 	
	foreach ($arr as $ks=>$vs){
		if($vs != ""){			
				$where.= "and $ks = '$vs'";
		} 
	} 

	if($stardate != ''){
		$where.= " and Withdraw_date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and Withdraw_date <= '$enddate 23:59:59'";
	}
	 
 	$users = $db->get_page("withdraw_user_yhk",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") {
// 	$arr = array();   
// 	$arr['client_id'] = "1";
// 	$arr['client_logname'] = "client_logname";
// 	$arr['withdrawsh_yhordernum'] = $_REQUEST['withdrawsh_yhordernum']; 
// 	$arr['withdrawsh_amount'] = $_REQUEST['withdrawsh_amount'];
// 	$arr['withdrawsh_bankid'] = $_REQUEST['withdrawsh_bankid'];
// 	$arr['withdrawsh_czaccount'] = $_REQUEST['withdrawsh_czaccount'];
// 	$arr['withdrawsh_czbankacname'] = $_REQUEST['withdrawsh_czbankacname'];
// 	$arr['withdrawsh_ps'] = $_REQUEST['withdrawsh_ps'];
// 	$arr['withdrawsh_date'] = "sysdate"; 
	
// 	try {
// 		$db->insert("player_withdraw",$arr);
// 		$result->result="1";
// 		$result->msg="添加成功。";
		
// 	}catch (Exception $e){
// 		$result->result="0";
// 		$result->msg="添加失败。";
// 	}
// 	echo json_encode($result);	
}elseif ($act == "update") {//审核
	$arr = array();   
	$arr['Withdraw_sxf'] = $_REQUEST['Withdraw_sxf']; 
	$arr['Withdraw_desc'] = $_REQUEST['Withdraw_desc'];  
	$arr['Withdraw_shstate'] = $_REQUEST['Withdraw_shstate'];  
	$arr['Withdraw_shdate'] = date("Y-m-d H:i:s");  
	$arr['withdraw_shuser'] = 1;
	$id = $_REQUEST['id'];
	 
	try {
		$db->db->query('begin '); //开始事务 
		
		$amountrow = mysql_query("select Withdraw_amount from player_withdraw  where id=".$id);
		$amount  = mysql_fetch_array($amountrow);//提现金额 
		$db->update("player_withdraw",$arr,"where id=".$id);		
		
		if($arr['Withdraw_shstate'] == 2){  
			
			$client_balance = mysql_query("select client_balance,client_freeze from player_client  where id=".$_REQUEST['client_id'] );
			$row = mysql_fetch_array($client_balance);
			$balance = $row['client_balance'];//当前账户余额
			$freeze = $row['client_freeze'];//当前账户冻结资金
			
			$db->db->query("update sys_zh  set zh_balance = (zh_balance-".$amount['Withdraw_amount']." ) where zh_iszzh = 0");
			
			//更改账户金额
			$db->db->query("update player_client  set client_freeze = (client_freeze - ".$amount['Withdraw_amount'].") where id=".$_REQUEST['client_id'] );
				
			//写入冲提账变表
			$zbarr = array();
			$zbarr['client_id'] = $_REQUEST['client_id'];
			$zbarr['client_logn'] = $_REQUEST['client_logn'];
			$zbarr['tczb_num'] = $_REQUEST['Withdraw_num'];
			$zbarr['tczb_type'] = "1";
			$zbarr['tczb_amount'] = $amount['Withdraw_amount'];
			$zbarr['tczb_balance1'] = $_REQUEST['Withdraw_balance'];
			$zbarr['tczb_balance2'] = $balance;
			$zbarr['yhk_id'] = $_REQUEST['yhk_id'];
			$zbarr['yhk_num'] = $_REQUEST['yhk_num'];
			$zbarr['yhk_name'] = $_REQUEST['yhk_name'];
			$zbarr['czdate'] = date("Y-m-d H:i:s");
			$db->insert("player_tczb",$zbarr);
			$db->db->query('commit');//提交
		}  
		$result->result="1";
		$result->msg="审核处理完成。";
	}catch (Exception $e){
		$db->db->query('rollback'); //回滚
		$result->result="0";
		$result->msg="审核处理失败。";
	}
	echo json_encode($result);  
}elseif ($act == "delete") { 
	$arr = array();	
	$id = $_REQUEST['id'];
	$arr['isdelete'] = 1; 
	
	try {
		$db->update("player_withdraw",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/finance/withdrawsh.html");
}

?>