<?php 
define('IN_ECS', true);

//require_once '/totoro/commons/init.php';

require_once dirname(__FILE__).'/../../commons/init.php';
//require_once '../commons/init.php';

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array(); 
	$arr['client_status'] = $_REQUEST['client_status'];
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
		$where.= " and client_ctime >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and client_ctime <= '$enddate 23:59:59'";
	}
	$users = $db->get_page("player_client",$where); 
	 
	echo json_encode($users); 
}elseif ($act == "save") {
	$arr = array();  
	$fharr = array();
	  
	$arr['client_logn'] = $_REQUEST['client_logn'];
	$arr['client_pw'] = $_REQUEST['client_pw'];
	$arr['client_nickn'] = $_REQUEST['client_nickn'];
	$arr['client_type'] = $_REQUEST['client_type']; 
	$arr['client_status'] = $_REQUEST['client_status'];  
	$arr['client_register'] = $_REQUEST['client_register'];
	$arr['client_freeze'] = $_REQUEST['client_freeze'];
	$arr['bonuszq_id'] = $_REQUEST['bonuszq_id']; 
	$arr['create_user'] = "1"; 
	$arr['client_ctime'] = date("Y-m-d H:i:s");  
	if($arr['client_type'] == 1){
		$arr['fid'] = "1";
		$arr['flogn'] = "liaohan";
	} 
	
	try { 
		$db->insert("player_client",$arr);  
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){ 
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();
	$arr['client_logn'] = $_REQUEST['client_logn']; 
	$arr['client_nickn'] = $_REQUEST['client_nickn'];
	$arr['client_type'] = $_REQUEST['client_type']; 
	$arr['client_status'] = $_REQUEST['client_status'];  
	$arr['client_register'] = $_REQUEST['client_register'];
	$arr['client_freeze'] = $_REQUEST['client_freeze'];  
	$arr['bonuszq_id'] = $_REQUEST['bonuszq_id'];
	$arr['update_user'] = "1"; 
	$id = $_REQUEST['id'];
	 
	try { 
		
		$db->update("player_client",$arr,"where id=".$id);  
		$result->result="1";
		$result->msg="修改成功。";
	}catch (Exception $e){
		$db->db->query('rollback'); //回滚
		$result->result="0";
		$result->msg="修改失败。";
	}
	echo json_encode($result);  
}elseif ($act == "delete") { 
	$arr = array();	
	$id = $_REQUEST['id'];
	$arr['isdelete'] = 1; 
	
	try {
		$db->update("player_client",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}elseif ($act == "updatepw") {
	$arr = array();
	$oldpw = $_REQUEST['oldpw'];
	$newpw1 = $_REQUEST['newpw1'];
	$newpw2 = $_REQUEST['newpw2']; 
	$id = $_REQUEST['id'];
	if( $oldpw == $newpw1){
		$result->result="0";
		$result->msg="修改失败，新旧密码不能一致";
    }else{
    	try { 
	    	$arr['client_pw'] = $newpw1;
	    	$db->update("player_client",$arr,"where client_pw = '".$oldpw."' and id=".$id);
	    	$result->result="1";
	    	$result->msg="修改密码成功。"; 
    	}catch (Exception $e){
    		$result->result="0";
    		$result->msg="修改密码错误。";
    	} 
    } 
    echo json_encode($result);
} elseif ($act == "updatezjpw") {
	$arr = array();
	$oldpw = $_REQUEST['oldzjpw'];
	$arr['client_txpw'] = $_REQUEST['newzjpw1']; 
	$id = $_REQUEST['id']; 
	
	$client_txpw = mysql_query("select client_txpw from player_client  where id=".$id);
	$row = mysql_fetch_array($client_txpw);
	$txpw = $row['client_txpw']; //从数据库中取出当前取现密码
	
	if($txpw == '' || $txpw == null){//如果不存在取现密码则直接存入
		try { 
			$db->update("player_client",$arr,"where id=".$id);
			$result->result="1";
			$result->msg="修改密码成功。";
			
		}catch (Exception $e){
			$result->result="0";
			$result->msg="修改密码错误。";
		}
	}else{ 
		if($oldpw != $txpw){
			$result->result="0";
			$result->msg="旧密码不正确";  
		}else{
			if( $txpw == $arr['client_txpw']){
				$result->result="0";
				$result->msg="修改失败，新旧密码不能一致";
			}else{ 
				try {
					$db->update("player_client",$arr,"where id=".$id);
					$result->result="1";
					$result->msg="修改密码成功。";
						
				}catch (Exception $e){
					$result->result="0";
					$result->msg="修改密码错误。";
				}
			} 
		} 
		
	} 
   echo json_encode($result);
} 
else {
	$smarty->display("admin/account/client.html");
}

?>