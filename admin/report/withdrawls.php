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
 	$where = " where isdelete = 0 and Withdraw_shstate != 0 "; 
 	
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
	$smarty->display("admin/report/withdrawls.html");
}

?>