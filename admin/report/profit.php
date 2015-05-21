<?php 
define('IN_ECS', true); 
require_once dirname(__FILE__).'/../../commons/init.php'; 

$act = $_REQUEST[act];

if (empty($act)) {
	$act = "";	
}

if ($act == "list") { 
	$arr = array();    
	$stardate = $_REQUEST['stardate'];
	$enddate = $_REQUEST['enddate'];
	$arr['client_logn'] = $_REQUEST['client_logn'];
	
	$where = "where 1=1 ";
	foreach ($arr as $ks=>$vs){
		if($vs != ""){
			$where.= "and $ks = '$vs'";
		}
	} 
	
	if($stardate != ''){
		$where.= " and date >= '$stardate 00:00:00'";
	}
	if($enddate != ''){
		$where.= " and date <= '$enddate 23:59:59'";
	}
	
	$pageno=1;
	$pagesize=12;
	$offset = $pagesize * ($pageno - 1);
	
	$sql =
	"select id,client_logn,fid,sum(cz)as 'cz',sum(tx) as 'tx',sum(czsxf) as'czsxf',sum(txsxf) as 'txsxf',
	sum(fh) as 'fh',sum(yh) as 'yh',sum(zc) as 'zc',sum(zr) as 'zr',max(client_balance) as 'balance',
	(sum(tx)+ max(client_balance)) - sum(cz) as 'yk' from clientyk $where  GROUP BY id,client_logn,fid";
	 
	$query =  $db->db->query($sql." limit $offset,$pagesize");
	
	$datas = array();
	$row = $db->db->fetch_array($query);
	while($row)
	{
		$datas[] = $row;
		$row = $db->db->fetch_array($query);
	}
	$result = array();
	
	$result['rows'] = $datas; 
	$query = $db->db->query($sql);
	//得到总数
	$sumnum = $db->db->num_rows($query);
	$result['total'] = $sumnum;
	//得到总页数
	$result['pagenum'] = $sumnum%$pagesize==0 ? $sumnum/$pagesize : (int)($sumnum/$pagesize)+1;
	
	
	echo json_encode($result); 
}else {
	$smarty->display("admin/report/profit.html");
}

?>