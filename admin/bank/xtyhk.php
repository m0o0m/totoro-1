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
	$arr['xtyhk_status'] = $_REQUEST['xtyhk_status'];
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
	$arr['xtyhk_type'] = $_REQUEST['xtyhk_type'];
	
 	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	if($stardate != ''){
		$where.= " and create_date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and create_date <= '$enddate 23:59:59'";
	} 
	
	$users = $db->get_page("xtyh_book",$where); 
	 
	echo json_encode($users); 
}elseif ($act == "comboxlist") {
	$arr = array();
	$arr['xtyhk_status'] = $_REQUEST['xtyhk_status']; 
	$arr['xtyhk_type'] = $_REQUEST['xtyhk_type']; 
	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		}
	}     
	 
	$sql=" SELECT id 'id',xtyhk_mc 'text',xtyhk_num 'desc'
	from sys_xtyhk ".$where;
	$rs = mysql_query($sql);
	$items = array();
	//$items = array(0=> array("id"=>"","text"=>"请选择","selected"=>true,"desc"=>""));
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}  
	echo json_encode($items);
} elseif ($act == "save") {
	$arr = array();  
	$arr['bank_type'] = $_REQUEST['bank_type'];
	$arr['xtyhk_mc'] = $_REQUEST['xtyhk_mc'];
	$arr['xtyhk_num'] = $_REQUEST['xtyhk_num'];
	$arr['xtyhk_name'] = $_REQUEST['xtyhk_name'];
	$arr['xtyhk_adress'] = $_REQUEST['xtyhk_adress']; 
	$arr['xtyhk_status'] = $_REQUEST['xtyhk_status'];  
	$arr['xtyhk_type'] = $_REQUEST['xtyhk_type'];  
	$arr['create_date'] = date("Y-m-d H:i:s");  
	
	try {
		$db->insert("sys_xtyhk",$arr);
		$result->result="1";
		$result->msg="添加成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加失败。";
	}
	echo json_encode($result);	
}elseif ($act == "update") {
	$arr = array(); 
	$arr['bank_type'] = $_REQUEST['bank_type'];
	$arr['xtyhk_mc'] = $_REQUEST['xtyhk_mc'];
	$arr['xtyhk_num'] = $_REQUEST['xtyhk_num'];
	$arr['xtyhk_name'] = $_REQUEST['xtyhk_name'];
	$arr['xtyhk_adress'] = $_REQUEST['xtyhk_adress']; 
	$arr['xtyhk_type'] = $_REQUEST['xtyhk_type'];
	$arr['xtyhk_status'] = $_REQUEST['xtyhk_status'];  
	$id = $_REQUEST['id']; 
	try {
		$db->update("sys_xtyhk",$arr,"where id=".$id);
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
		$db->update("sys_xtyhk",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/bank/xtyhk.html");
}

?>