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
	$arr['role_name'] = $_REQUEST['role_name']; 
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
	$arr['role_name'] = $_REQUEST['role_name'];
	$arr['role_desc'] = $_REQUEST['role_desc'];
	$arr['sysuser_id'] = 1;
	$arr['czdate'] = 'now()';  
	
	try {
		$db->insert("sys_role",$arr);
		$result->result="1";
		$result->msg="添加权限用户组成功。";
		
	}catch (Exception $e){
		$result->result="0";
		$result->msg="添加权限用户组失败。";
	}
	echo json_encode($result);	
	
}elseif ($act == "update") {
	$arr = array();
	$arr['role_name'] = $_REQUEST['role_name'];
	$arr['role_desc'] = $_REQUEST['role_desc'];
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