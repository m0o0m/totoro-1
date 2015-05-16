<?php 
define('IN_ECS', true);
require_once dirname(__FILE__).'/../../commons/init.php';
$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array(); 
	$arr['Withdraw_shstate'] = $_REQUEST['Withdraw_shstate'];
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
 	$where = " where isdelete = 0 ";
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
	
	$users = $db->get_page("player_withdraw",$where); 
	echo json_encode($users); 
	
}elseif ($act == "save") { 
		$client_txpw = $_REQUEST['Withdraw_pw'];
		
		$txpw= mysql_query("select client_txpw from  player_client where id = 1" );
		$row = mysql_fetch_array($txpw);  
		
		if($row[0] == '' || $row[0] == null){ //资金密码不存在 
			$result->result="0";
			$result->msg="尚未设置资金密码，不能提现。";
		}else{ 
			if($client_txpw != $row[0]){
				$result->result="0";
				$result->msg="资金密码不正确。";
			}else{
				$arr = array();
				$arr['client_id'] = "1";
				$arr['client_logn'] = "liaohan";
				$arr['withdraw_num'] = "123456"; //充值编号  有系统产生
				$arr['Withdraw_amount'] = $_REQUEST['Withdraw_amount'];
				$arr['Withdraw_date'] = date("Y-m-d H:i:s");
			
				$txpw= mysql_query("select * from  player_client where id = ".$arr['client_id'] );
				$row = mysql_fetch_array($txpw);
				$arr['Withdraw_freeze'] = $row["client_freeze"];//提现前冻结金额
				$arr['Withdraw_balance'] = $row["client_balance"];//提现前冻结金额
				
				$arr['yhk_id'] = $_REQUEST['yhk_id'];
				$rs = mysql_query("select yhk_num,yhk_name,yhk_adress from player_yhk where id = ".$_REQUEST['yhk_id']);
				while($row = mysql_fetch_array($rs))
				{
					$arr['yhk_num'] = $row['yhk_num'];
					$arr['yhk_name'] = $row['yhk_name'];
					$arr['yhk_adress'] = $row['yhk_adress'];
				}
				
				try {
					$db->db->query('begin '); //开始事务
					
					$db->insert("player_withdraw",$arr);
					$db->db->query("update player_client set client_balance= (client_balance - ".$arr['Withdraw_amount']."),
							client_freeze = (client_freeze + ".$arr['Withdraw_amount'].")
							where id=".$arr['client_id']); 

					$result->result="1";
					$result->msg="提现申请成功。";
					$db->db->query('commit');//提交
				}catch (Exception $e){
				   $db->db->query('rollback'); //回滚
				   $result->result="0";
				   $result->msg="提现申请失败。";
				}
			}
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
	$smarty->display("admin/cztx/withdraw.html");
}

?>