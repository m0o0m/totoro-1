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
	$arr['yhk_status'] = $_REQUEST['yhk_status'];
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
	
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
	
	$users = $db->get_page("yhk_book",$where); 
	 
	echo json_encode($users); 
}elseif ($act == "comboxlist") {
	$arr = array();
	$arr['yhk_status'] = $_REQUEST['yhk_status'];  
	$arr['clien_id'] = $_REQUEST['clien_id']; 
	$where = " where isdelete = 0 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		}
	}     
	 
	$sql=" SELECT id 'id',yhk_mc 'text',yhk_num 'desc'
	from player_yhk ".$where;
	$rs = mysql_query($sql);
	$items = array(); 
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}  
	echo json_encode($items);
}elseif ($act == "save") {
	$arr = array(); 
	$arr['clien_id'] = "1"; 
	$arr['bank_type'] = $_REQUEST['bank_type'];
	$arr['yhk_mc'] = $_REQUEST['yhk_mc'];
	$arr['yhk_num'] = $_REQUEST['yhk_num'];
	$arr['yhk_name'] = $_REQUEST['yhk_name'];
	$arr['yhk_adress'] = $_REQUEST['yhk_adress']; 
	$arr['yhk_status'] = $_REQUEST['yhk_status'];  
	$arr['create_date'] = date("Y-m-d H:i:s");  
	
	try {
		$db->insert("player_yhk",$arr);
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
	$arr['yhk_mc'] = $_REQUEST['yhk_mc'];
	$arr['yhk_num'] = $_REQUEST['yhk_num'];
	$arr['yhk_name'] = $_REQUEST['yhk_name'];
	$arr['yhk_adress'] = $_REQUEST['yhk_adress']; 
	$arr['yhk_status'] = $_REQUEST['yhk_status'];  
	$id = $_REQUEST['id'];
	 
	try {
		$db->update("player_yhk",$arr,"where id=".$id);
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
		$db->update("player_yhk",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/bank/yhk.html");
}

?>