<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php';  
$act = $_REQUEST[act]; 
if (empty($act)) { 
	$act = "";	
}

if ($act == "list") { 
	$users = $db->get_page("sys_book a,sys_booktype b"," where a.booktype_code = b.booktype_code ");  
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	
}elseif ($act == "update") {
	
}elseif ($act == "del") {
	
}else {
	try {   
		  $smarty->display("admin/code/book.html"); 
	} catch (Exception $e) {   
		print $e->getMessage();  
	}   
}
?>
	
	 

