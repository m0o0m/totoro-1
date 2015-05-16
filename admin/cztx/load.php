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
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
 	$where = " where isdelete = 0 ";
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
	
	$users = $db->get_page("player_load",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") { 
		$client_txpw = $_REQUEST['load_pw'];
		
		$client_balance = mysql_query("select client_txpw from  player_client where id = 1" );
		$row = mysql_fetch_array($client_balance);   
		if($row[0] == '' || $row[0] == null){ //资金密码不存在 
			$result->result="0";
			$result->msg="尚未设置资金密码，不能充值。";
		}else{ 
			if($client_txpw != $row[0]){
				$result->result="0";
				$result->msg="资金密码不正确。";
			}else{
				$arr = array();
				$arr['client_id'] = "1";
				$arr['client_logn'] = "liaohan";
				$arr['load_num'] = "123456"; //充值编号  有系统产生
				$arr['load_amount'] = $_REQUEST['load_amount'];
				$arr['load_sxf'] = "10.00";
				$arr['load_date'] = date("Y-m-d H:i:s");
				$arr['yhk_id'] = "2";
				$arr['yhk_num'] = "1312313123124324";
				$arr['yhk_name'] = "李傲寒";
				$arr['load_ps'] = "充值附言";
				$arr['xtyhk_id'] = $_REQUEST['xtyhk_id'];
				$rs = mysql_query("select xtyhk_num,xtyhk_name from sys_xtyhk where id = ".$_REQUEST['xtyhk_id']);
				while($row = mysql_fetch_array($rs))
				{
					$arr['xtyhk_num'] = $row['xtyhk_num'];
					$arr['xtyhk_name'] = $row['xtyhk_name'];
				}
				try {
					$db->insert("player_load",$arr);
					$result->result="1";
					$result->msg="充值提交成功。";
			
				}catch (Exception $e){
					$result->result="0";
					$result->msg="充值提交失败。";
				}
			}
		} 

    	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();
	//$arr['load_state'] = $_REQUEST['load_state']; 
	$id = $_REQUEST['id'];
	 
	try {
		$db->update("player_load",$arr,"where id=".$id);
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
		$db->update("player_load",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/cztx/load.html");
}

?>