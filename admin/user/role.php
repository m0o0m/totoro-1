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
	$arr['sys_rolename'] = $_REQUEST['sys_rolename']; 
	$where = " where isdelete = 0 ";
	
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		} 
	}
	
	$result = $db->get_page("sys_role",$where); 
	echo json_encode($result);	
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	$arr = array();
	$arr['sys_rolename'] = $_REQUEST['sys_rolename'];
	$arr['sys_role_desc'] = $_REQUEST['sys_role_desc'];
	$arr['sysuser_id'] = 1;
	$arr['czdate'] = new time(); 
	
	try {
		$db->insert("sys_role",$arr);
		$result->result="1";
		$result->msg="添加用户".$arr['role_logn']."成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加用户".$arr['role_logn']."失败。";
	}
	echo json_encode($result);	
	
}elseif ($act == "update") {
	$arr = array();
	$arr['role_logn'] = $_REQUEST['role_logn']; 
	$arr['role_name'] = $_REQUEST['role_name'];
	$arr['role_email'] = $_REQUEST['role_email'];
	$arr['role_sex'] = $_REQUEST['role_sex'];
	$arr['role_mobile'] = $_REQUEST['role_mobile'];
	$arr['role_status'] = $_REQUEST['role_status'];
	$id = $_REQUEST['id'];

	try {
		$db->update("sys_role",$arr,"where id=".$id);
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
		$db->update("sys_role",$arr,"where id=".$id);
		$result->result="1";
		$result->msg="删除成功。";
	}catch (Exception $e){
		$result->result="0";
		$result->msg="删除失败。";
	}
	 
	echo json_encode($result);	
}else {
	$smarty->display("admin/user/role.html");
}

?>