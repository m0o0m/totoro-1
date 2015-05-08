<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php';  
$act = $_REQUEST[act]; 
if (empty($act)) { 
	$act = "";	
}

if ($act == "list") { 
	$users = $db->get_page("sys_booktype "," where 1=1 ");  
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	
}elseif ($act == "update") {
	
}elseif ($act == "del") {
	
}else {
	try {   
		  $smarty->display("admin/code/booktype.html"); 
	} catch (Exception $e) {   
		print $e->getMessage();  
	}   
}
?>
	
	 

