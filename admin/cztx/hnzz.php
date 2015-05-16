<?php 
define('IN_ECS', true);
require_once dirname(__FILE__).'/../../commons/init.php';
$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array(); 
	$arr['zclient_logn'] = $_REQUEST['zclient_logn'];
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
 	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	} 
	if($stardate != ''){
		$where.= " and hnzz_date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and hnzz_date <= '$enddate 23:59:59'";
	}
	
	$users = $db->get_page("player_hnzz",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") { 
		$client_txpw = $_REQUEST['load_pw'];
		
		$client_balance = mysql_query("select client_txpw from  player_client where id = 1" );
		$row = mysql_fetch_array($client_balance);   
		if($row[0] == '' || $row[0] == null){ //资金密码不存在 
			$result->result="0";
			$result->msg="尚未设置资金密码，不能转账。";
		}else{ 
			if($client_txpw != $row[0]){
				$result->result="0";
				$result->msg="资金密码不正确，请重新操作";
			}else{
				
				$skrlogn = mysql_query("select * from  player_client where isdelete=0 and client_status = 0 and client_logn ='".$_REQUEST['dclient_logn']."'" );
				$zzrlogn = mysql_query("select * from  player_client where isdelete=0 and client_status = 0 and id = 1" );
				$skrrow = mysql_fetch_array($skrlogn);
				$zzrow = mysql_fetch_array($zzrlogn);
				
				if($zzrow['client_balance'] < $_REQUEST['hnzz_amount']){
					$result->result="0";
					$result->msg="账户余额不足";
				}else{
					//确认账号是否存在
					if($skrrow['id'] == '' || $skrrow['id'] == null ){
						$result->result="0";
						$result->msg="转入的账户不存在";
					}else{
						$zzr_balance = $zzrow['client_balance'];//转账人余额
						$zzr_freeze = $zzrow['client_freeze'];//转账人冻结金额
						$skr_balance = $skrrow['client_balance'];//收款人余额
						$skr_freeze = $skrrow['client_freeze'];//收款人冻结金额
							
						$arr = array();
						$arr['zclient_num'] = "123456";
						$arr['zclient_id'] = "1";
						$arr['zclient_logn'] = "liaohan"; //充值编号  有系统产生
						$arr['dclient_id'] = $skrrow['id'];
						$arr['dclient_logn'] = $_REQUEST['dclient_logn'];
						$arr['hnzz_amount'] = $_REQUEST['hnzz_amount'];
						$arr['hnzz_date'] = date("Y-m-d H:i:s");
						$arr['hnzz_desc'] = $_REQUEST['hnzz_desc'];
					
						$zbarr = array();
						$zbarr['transfer_type'] = 1;//户内转账人转账
						$zbarr['client_id'] = "1";
						$zbarr['client_logn'] = "liaohan";
						$zbarr['transfer_amount'] = -$_REQUEST['hnzz_amount'];
						$zbarr['transfer_balance1'] = $zzr_balance;
						$zbarr['transfer_balance2'] = $zzr_balance - $_REQUEST['hnzz_amount'];
						$zbarr['transfer_freeze1'] = $zzr_freeze;
						$zbarr['transfer_freeze2'] = $zzr_freeze;
						$zbarr['transfer_date'] = date("Y-m-d H:i:s");
							
						$sarr = array();
						$sarr['transfer_type'] = 1;//户内收款人转账
						$sarr['client_id'] = $skrrow['id'];
						$sarr['client_logn'] = $skrrow['client_logn'];
						$sarr['transfer_amount'] = $_REQUEST['hnzz_amount'];
						$sarr['transfer_balance1'] = $skr_balance;
						$sarr['transfer_balance2'] = $skr_balance + $_REQUEST['hnzz_amount'];
						$sarr['transfer_freeze1'] = $skr_freeze;
						$sarr['transfer_freeze2'] = $skr_freeze;
						$sarr['transfer_date'] = date("Y-m-d H:i:s");
							
						try {
							$db->db->query('begin '); //开始事务
					
							$db->db->query("update player_client  set client_balance = (client_balance+".$_REQUEST['hnzz_amount']." ) where id =".$skrrow['id']);
							$db->db->query("update player_client  set client_balance = (client_balance-".$_REQUEST['hnzz_amount'].") where id=".$zzrow['id']);
							$db->insert("player_hnzz",$arr);
							$db->insert("player_transfer",$zbarr);
							$db->insert("player_transfer",$sarr);
							$result->result="1";
							$result->msg="转账提交成功。";
					
							$db->db->query('commit');//提交
						}catch (Exception $e){
							$db->db->query('rollback'); //回滚
					
							$result->result="0";
							$result->msg="转账提交失败。";
						}
					}
				} 
 			}
		} 

    	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();
	//$arr['load_state'] = $_REQUEST['load_state']; 
	$id = $_REQUEST['id'];
	 
	try {
		$db->update("player_hnzz",$arr,"where id=".$id);
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
		$db->update("player_hnzz",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/cztx/hnzz.html");
}

?>