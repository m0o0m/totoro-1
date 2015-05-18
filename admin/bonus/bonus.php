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
}elseif ($act == "countbonus") { 
	$arr = array();
	$zqarr = array();
	$date = date("Y-m-d H:i:s");
	$sql = " select * from player_bonuszq where '$date' > bonuszq_jssj";  
	
	$db->db->query('begin '); //开始事务 
	try {
	    	$zq = mysql_query($sql);//找出周期表数据（符合时间要求，今天必须大于周期结束时间）
			while($row = mysql_fetch_array($zq))//按周期循环，找出按此周期分红的客户以及其盈亏
			{		
				$wjsql = "select a.*,b.bonusbl_bl from player_client a LEFT JOIN player_bonusbl b on a.bonuszq_id = b.bonuszq_id 
		 		where a.isdelete=0 and  a.client_status = 0 and  b.isdelete = 0 and  b.bonusbl_zjxx <=  
						10000 and  10000 <b.bonusbl_zjsx and a.bonuszq_id =".$row["id"];
				$wjresult = mysql_query($wjsql); 
				
				while($wjrow = mysql_fetch_array($wjresult))
				{
					//根据金额限度，找出该周期的对应分红比例，计算金额分红金额，写入分红表。  
					$arr['client_id'] = $wjrow["id"];
					$arr['client_logn'] = $wjrow["client_logn"];
					$arr['bonus_bl'] = $wjrow["bonusbl_bl"];
					$arr['bonus_zq'] = $row["bonuszq_zq"];
					$arr['bonus_kssj'] = $row["bonuszq_kssj"];
					$arr['bonus_jssj'] = $row["bonuszq_jssj"];
					$arr['bonus_yk'] = 10000;
					$arr['bonus_je'] = 10000*$arr['bonus_bl']/100; 
				    $db->insert("player_bonus",$arr);   
				}
				$zqarr['bonuszq_kssj'] = $row['bonuszq_jssj'];
				$zqarr['bonuszq_jssj'] =  date('Y-m-d',strtotime ("+".$row['bonuszq_zq']." day", strtotime($row['bonuszq_jssj']))) ;
				$db->update("player_bonuszq",$zqarr,"where id=".$row["id"]);
			}
			$result->result="1";
			$result->msg="成功";
			$db->db->query('commit');//提交
	}catch (Exception $e){
		$db->db->query('rollback'); //回滚
		$result->result="0";
		$result->msg="失败";
	} 
    echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array();   
	$arr['bonus_state'] = $_REQUEST['bonus_state'];
	$arr['bonus_user'] = "1"; 
	$arr['bonus_desc'] = $_REQUEST['bonus_desc'];  
	$bonus_je = $_REQUEST['bonus_je'];
	$arr['bonus_date'] = date("Y-m-d H:i:s"); 
	$id = $_REQUEST['id']; 
	
	$player_bonus = mysql_query("select * from player_bonus  where id=".$id);
	$bonusrow = mysql_fetch_array($player_bonus);
	if($bonusrow['bonus_state'] == 0){
		
		if($arr['bonus_state'] == 1){
			try {
				$db->db->query('begin '); //开始事务
				$db->update("player_bonus",$arr,"where id=".$id);
				$db->db->query("update player_client  set client_balance = (client_balance + $bonus_je) where id=".$bonusrow['client_id'] );
		
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
		
	}else{
		$result->result="0";
		$result->msg="已经被审核";
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