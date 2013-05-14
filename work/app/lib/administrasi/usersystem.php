<?php

require_once "app/lib/common/functions.php";

function role_muat_data($id=NULL,$sort = NULL,$sortBy = NULL) {
	if($_SESSION['id_role']!='1'){
	$id='24';
	}
    if($id != NULL){
        $action = "where id_role = $id";
    }else $action = "";
    if(isset ($sort)){
        if($sort == 1){
            $order = "order by nama_role $sortBy";
        }
    }else $order = "order by nama_role asc";
    $result = array();
    $sql = "select * from role  $action $order";
    $exe = mysql_query($sql);
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}

function usersystem_muat_data($id=NULL,$sort=NULL, $page=NULL, $dataPerPage = NULL, $key = NULL) {
    if($sort!=NULL){
        $action2 = "order by p.nama asc";
    }else $action2 = "";
    
    if($id != NULL){
        $action = "where u.id = $id";
    }else $action = "";
    
    if($key != NULL){
        $action3 = "where p.nama like '%$key%'";
    }else $action3 = "";
    
    if (!empty($page)) {
    $noPage = $page;
    } else {
        $noPage = 1;
    }
  
    $dataPerPage = $dataPerPage;
    $offset = ($noPage - 1) * $dataPerPage;
    $batas = "";
    if ($dataPerPage != null) {
        $batas = "limit $offset, $dataPerPage";
    }
	
    $result = array();
    
        $sql = "select u.*,r.nama_role,s.nama as salesname,k.nama as konsumenname,s.target as target,k.batasan as maximalhutang,k.alamat,k.id_sales
        from users u 
		left join role r on(u.id_role=r.id_role)
		left join sales s on(s.id=u.id)
        left join konsumen k on(k.id=u.id)
		$action $action3 $action2 $batas";
    $result= _select_arr($sql);
    if($page!=NULL || $dataPerPage != null){
        $result['list']=_select_arr($sql);
        $sqli = "select u.*,r.nama_role,s.nama,k.nama
        from users u 
		left join role r on(u.id_role=r.id_role)
		left join sales s on(s.id=u.id)
        left join konsumen k on(k.id=u.id)
        $action $action3 $action2";
        $result['paging'] = paging($sqli, $dataPerPage);
        $result['offset'] = $offset;
        return $result;
    }else{
        return $result;
    }
	
}



function konsumen_muat_data($id=NULL,$sort=NULL, $page=NULL, $dataPerPage = NULL, $key = NULL) {
    if($sort!=NULL){
        $action2 = "order by p.nama asc";
    }else $action2 = "";
    
    if($id != NULL){
        $action = "where k.id_sales = $id";
    }else $action = "";
    
    if($key != NULL){
        $action3 = "where p.nama like '%$key%'";
    }else $action3 = "";
    
    if (!empty($page)) {
    $noPage = $page;
    } else {
        $noPage = 1;
    }
  
    $dataPerPage = $dataPerPage;
    $offset = ($noPage - 1) * $dataPerPage;
    $batas = "";
    if ($dataPerPage != null) {
        $batas = "limit $offset, $dataPerPage";
    }
	
    $result = array();
    
        $sql = "select u.*,r.nama_role,s.nama as salesname,k.nama as konsumenname,s.target as target,k.batasan as maximalhutang,k.alamat,k.id_sales
        from users u 
		left join role r on(u.id_role=r.id_role)
		left join sales s on(s.id=u.id)
        left join konsumen k on(k.id=u.id)
		$action $action3 $action2 $batas";
    $result= _select_arr($sql);
    if($page!=NULL || $dataPerPage != null){
        $result['list']=_select_arr($sql);
        $sqli = "select u.*,r.nama_role,s.nama,k.nama
        from users u 
		left join role r on(u.id_role=r.id_role)
		left join sales s on(s.id=u.id)
        left join konsumen k on(k.id=u.id)
        $action $action3 $action2";
        $result['paging'] = paging($sqli, $dataPerPage);
        $result['offset'] = $offset;
        return $result;
    }else{
        return $result;
    }
	
}



function salese_muat_data($id){
$sql=_select_unique_result("select * from sales where id ='$id'");
return $sql;
}
function module_muat_data($id = NULL) {
    if($id != NULL){
        $action = "where id = $id";
    }else $action = "";
    $result = array();
    $sql = "select * from module $action";
    $exe = mysql_query($sql);
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}

function permission_muat_data($module = null) {
    $require_once = null;
    if ($module != null) {
        $require_once = "where id_module = '$module'";
    }
    $result = array();
    $sql = "SELECT * FROM privileges $require_once";
    $exe = mysql_query($sql);
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}
function privilege_muat_data($id = null) {
    $require_once = null;
    if ($id != null) {
        $require_once = "where id = '$id'";
    }
    $result = array();
    $sql = "SELECT * FROM privileges $require_once";
    $exe = mysql_query($sql);
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}
?>
