<?php 
define('IN_ECS', true);

//require_once '/totoro/commons/init.php';

require_once dirname(__FILE__).'/../../commons/init.php';
//require_once '../commons/init.php';

$act = $_REQUEST[act];

if (empty($act)) {
//	echo "aaaaaaaaa";
	$act = "";	
}

if ($act == "list") {
	//username='admin'
	$users = $db->get_page("xy_sys_user","where 1=1 ");
	
	$result->rows = $users;
	//print_r($users);
	$result->total = 28;
	echo json_encode($users);
	//print($users);
}elseif ($act == "add") {
	
}elseif ($act == "save") {
	
}elseif ($act == "update") {
	
}elseif ($act == "del") {
	
}else {
	try {   
//		echo "bbbbb";
		
		//$smarty->assign("users",$users);
		$smarty->display("admin/user/list.html");
//		echo "cccc";
	} catch (Exception $e) {   
		print $e->getMessage();   
	 
	}   
	?>
	
	
	<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>用户管理</title>

	<link rel="stylesheet" type="text/css" href="/totoro/themes/default/js/plugins/default.css" />
	<link rel="stylesheet" type="text/css" href="/totoro/themes/default/js/plugins/ui/themes/icon.css"/>
	<link rel="stylesheet" type="text/css" href="/totoro/themes/default/js/plugins/ui/themes/default/easyui.css">
	
	<script type="text/javascript" src="/totoro/themes/default/js/plugins/jquery.min.js"></script>
	<script type="text/javascript" src="/totoro/themes/default/js/plugins/ui/jquery.easyui.min.js"></script>
	
	<script type="text/javascript">
		$(function(){
			alert(1);
			$("#user_list").datagrid({
				title:"人员列表",
				url:"/totoro/admin/user/user.php?act=list"
			}); 
		});
	</script>
</head>
<body>
	
	<div >
		<table id="user_list" class="easyui-datagrid" >
			<thead>
				<tr>
					<th data-options="field:'username',width:80">username</th>
					<th data-options="field:'password',width:100">password</th>
				</tr>
			</thead>
		</table>
	</div>
	
	
</body>
</html>
	<?php
	
	
	//$smarty->display("admin/index.html");
}
//$smarty->display("admin/user/list.html");
//$smarty->display("admin/index.html");
?>

