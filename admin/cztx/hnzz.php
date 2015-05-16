<?php 
define('IN_ECS', true);
require_once dirname(__FILE__).'/../../commons/init.php';
$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array(); 
	$arr['zclient_mz'] = $_REQUEST['zclient_mz'];
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
				//确认账号是否存在 
				$skrlogn = mysql_query("select * from  player_client where isdelete=0 and client_status = 0 and client_logn ='".$_REQUEST['dclient_logn']."'" );
				$skrrow = mysql_fetch_array($skrlogn);
				if($skrrow['id'] == '' || $skrrow['id'] == null ){
					$result->result="0";
					$result->msg="转入的账户不存在"; 
				}else{  
					$arr = array(); 
					$arr['zclient_num'] = "123456";
					$arr['zclient_id'] = "1";
					$arr['zclient_logn'] = "liaohan"; //充值编号  有系统产生 
					$arr['dclient_id'] = $skrrow['id'];  
					$arr['dclient_logn'] = $_REQUEST['dclient_logn']; 
					$arr['hnzz_amount'] = $_REQUEST['hnzz_amount']; 
					$arr['hnzz_date'] = date("Y-m-d H:i:s");; 
					$arr['hnzz_desc'] = $_REQUEST['hnzz_desc'];   
 
					$zbarr = array(); 
					$zbarr['zclient_id'] =      
					game_id              int comment '游戏id',
					client_id            int not null auto_increment comment '玩家账户id',
					client_logn          varchar(10) not null comment '账户名',
					transfer_amount      decimal not null comment '账变金额',
					transfer_balance1    decimal not null comment '账户转账前可用余额',
					transfer_balance2    decimal not null comment '账户转账后可用余额',
					transfer_freeze1     decimal not null comment '账户转账前冻结资金',
					transfer_freeze2     decimal not null comment '账户转账后冻结资金',
					transfer_desc        varchar(30) comment '备注',
					transfer_date        timestamp not null comment '账变时间',
					isdelete             int not null default 0 comment '是否删除',
					
					try {
						$db->insert("player_hnzz",$arr);
						$result->result="1";
						$result->msg="转账提交成功。"; 
					}catch (Exception $e){
						$result->result="0";
						$result->msg="转账提交失败。";
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