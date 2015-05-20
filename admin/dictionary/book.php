<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php'; 

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") {
 
	$arr = array(); 
	$arr['book_no'] = $_REQUEST['book_no'];
	$arr['booktype_code'] = $_REQUEST['booktype_code'];
	
	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	$users = $db->get_page("sys_book",$where); 
	echo json_encode($users); 
}elseif ($act == "add") {
	
}elseif ($act == "comboxlist") { 
	$sql=" SELECT id 'id',booktype_name 'text',booktype_desc 'desc'
			 from sys_booktype where isdelete = 0 ";
	$rs = mysql_query($sql);
	
	//$items = array();
	$items = array(0=> array("id"=>"","text"=>"请选择","selected"=>true,"desc"=>""));
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}  
	echo json_encode($items); 
}elseif ($act == "booklist") {  
	$bcode = $_REQUEST['bcode'];
	$sql=" SELECT b.book_no 'id',b.book_value 'text',b.book_no 'desc'
	from sys_booktype a,sys_book b where b.booktype_id = a.id 
    and a.isdelete = 0 and b.isdelete = 0 and booktype_code= '$bcode'";
	$rs = mysql_query($sql);
	
	//$items = array();
	$items = array(0=> array("id"=>"","text"=>"请选择","selected"=>true,"desc"=>""));
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}  
	echo json_encode($items); 
}
elseif ($act == "save") {
	$arr = array();
	$arr['book_no'] = $_REQUEST['book_no'];
	$arr['book_value'] = $_REQUEST['book_value'];
	$arr['booktype_id'] = $_REQUEST['booktype_id'];
	$arr['create_user'] = "1";
	$arr['create_date'] = date("Y-m-d H:i:s"); 
	try {
		$db->insert("sys_book",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array(); 
	$arr['book_no'] = $_REQUEST['book_no'];
	$arr['book_value'] = $_REQUEST['book_value'];
	$arr['booktype_id'] = $_REQUEST['booktype_id'];
	$arr['update_user'] = "1"; 
	$id = $_REQUEST['id'];
	 
	try {
		$db->update("sys_book",$arr,"where id=".$id);
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
		$db->update("sys_book",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/dictionary/book.html");
}

?>