<?php 
define('IN_ECS', true);
require_once dirname(__FILE__).'/../../commons/init.php';
$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array(); 
	$arr['Withdraw_fkstate'] = $_REQUEST['Withdraw_fkstate'];
	$arr['client_logname'] = $_REQUEST['client_logname'];    
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
	 
 	$users = $db->get_page("bns_withdraw",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	$arr = array();   
	$arr['client_id'] = "1";
	$arr['client_logname'] = "client_logname";
	$arr['withdraw_yhordernum'] = $_REQUEST['withdraw_yhordernum']; 
	$arr['withdraw_amount'] = $_REQUEST['withdraw_amount'];
	$arr['withdraw_bankid'] = $_REQUEST['withdraw_bankid'];
	$arr['withdraw_czaccount'] = $_REQUEST['withdraw_czaccount'];
	$arr['withdraw_czbankacname'] = $_REQUEST['withdraw_czbankacname'];
	$arr['withdraw_ps'] = $_REQUEST['withdraw_ps'];
	$arr['withdraw_date'] = "sysdate"; 
	
	try {
		$db->insert("bns_withdraw",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "sh") {//审核
	$arr = array();
	$arr['Withdraw_sxamount'] = $_REQUEST['Withdraw_sxamount'];
	$arr['Withdraw_fkstate'] = $_REQUEST['Withdraw_fkstate']; 
	$arr['Withdraw_remarks'] = $_REQUEST['Withdraw_remarks'];  
	$arr['Withdraw_shuser'] = 0;
	$id = $_REQUEST['id'];
	 
	try {
		$db->update("bns_withdraw",$arr,"where id=".$id);
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
		$db->update("bns_withdraw",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/finance/withdraw.html");
}

?>