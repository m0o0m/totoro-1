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
	//where username='admin'
	$users = $db->get_page("xy_sys_user","");
	echo json_encode($users);
	//print($users);
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	
}elseif ($act == "update") {
	
}elseif ($act == "del") {
	
}else {
	


	$smarty->display("admin/user/list.html");



}

?>