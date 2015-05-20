<?php 
define('IN_ECS', true);

//require_once '/totoro/commons/init.php';

require_once dirname(__FILE__).'/../../commons/init.php';
//require_once '../commons/init.php';

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}
if($act == "list"){ 
	$where = " where isdelete = 0 and id= 1";
	$users = $db->get_page("player_client",$where); 
	echo json_encode($users); 
} 
else {    
	$clientrow1 = mysql_query("select sum(client_balance) as 'client_balances',sum(client_freeze) as 'client_freezes' from player_client  where fid = 1");
	$teamye1 = mysql_fetch_array($clientrow1);
	$clientrow2 = mysql_query("select sum(client_balance) as 'client_balances',sum(client_freeze) as 'client_freezes' from player_client  where fid = 1 or id = 1 ");
	$teamye2 = mysql_fetch_array($clientrow2); 
	$smarty->assign('teamye1', $teamye1);
	$smarty->assign('teamye2', $teamye2);
	$smarty->display("admin/account/teamye.html");
}

?>