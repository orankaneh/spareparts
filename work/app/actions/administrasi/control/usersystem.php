<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/administrasi/usersystem.php';

$tab=(isset($_GET['tab']))?'tab='.$_GET['tab']:null;
$tabs=(isset($_GET['tabs']))?$_GET['tabs']:null;
set_time_zone();

if (isset($_POST['adduser'])) {
    $username = isset($_POST['username'])?$_POST['username']:NULL;
    $rolename  = isset($_POST['rolename'])?$_POST['rolename']:null;
    $idPenduduk= isset($_POST['idPenduduk'])?$_POST['idPenduduk']:null;
    $nama      = isset($_POST['nama'])?$_POST['nama']:null;
    $layout      = isset($_POST['layout'])?$_POST['layout']:null;
    $password = md5('petung//31');
    $unit = isset ($_POST['unit'])?$_POST['unit']:NULL;
	$genre = isset($_POST['genre'])?$_POST['genre']:NULL;
    $target = isset($_POST['target'])?$_POST['target']:NULL;
	$alamat = isset($_POST['alamat'])?$_POST['alamat']:NULL;
	$limit = isset($_POST['limit'])?$_POST['limit']:NULL;
	$salese = isset($_POST['salesid'])?$_POST['salesid']:NULL;
	//if (empty($idPenduduk)) {
//$sql = _insert("insert into penduduk (nama) valus('$nama')");
   // }
    
    $query = _insert("insert into users (id,username,password,last_access,member_for,id_role,status,id_unit,id_layout) values ('$idPenduduk','$username','$password','','".date('Y-m-d H-i-s')."','$rolename',1,'7','1')");
    $id = _last_id();
	
	
//    echo "insert into users (id,username,password,last_access,member_for,status) values ('$idPenduduk','$username','$username','','".date('Y-m-d H-i-s')."','$rolename',1)";
    if ($query){
			if($genre=="sales"){
				_insert("insert into sales (id,nama,target) values ('$id','$nama','$target')");
			}
		   else if($genre=="konsumen"){
				_insert("insert into konsumen (id,nama,alamat,batasan,id_sales) values ('$id','$nama','$alamat','$limit','$salese')");
			}
		//_insert("insert into log (id,tanggal,id_user,Action) values ('','".date('Y-m-d H-i-s')."','$_SESSION[id_user]','tambah account $genre Nama=$nama dan id=$id')");
         header("location: ".app_base_url('administrasi/usersystem')."?msg=1&idUser=$id&$tab");
    }
}

else if(isset($_POST['edituser'])){
    $rolename  = isset($_POST['rolename'])?$_POST['rolename']:null;
    $idPenduduk= isset($_POST['idex'])?$_POST['idex']:null;
    $nama      = isset($_POST['nama'])?$_POST['nama']:null;
    $layout      = isset($_POST['layout'])?$_POST['layout']:null;
    $genre = isset($_POST['genre'])?$_POST['genre']:NULL;
    $target = isset($_POST['target'])?$_POST['target']:NULL;
	$alamat = isset($_POST['alamat'])?$_POST['alamat']:NULL;
	$limit = isset($_POST['limit'])?$_POST['limit']:NULL;
	$old = isset($_POST['old'])?$_POST['old']:NULL;
	$salese = isset($_POST['salesid'])?$_POST['salesid']:NULL;
	
    $sql = _select_unique_result("select username from users where id='$idPenduduk'");
    $username = $sql['username'];
	
    if($genre=="sales"){
    $query = _update("update sales set target='$target' where id='$idPenduduk'");
	//_insert("insert into log (id,tanggal,id_user,Action) values ('','".date('Y-m-d H-i-s')."','$_SESSION[id_user]','Edit $genre id=$idPenduduk set target $old=>$target')");
    }
	
	
	if($genre=="konsumen"){
    $query = _update("update konsumen set batasan='$limit',alamat='$alamat',id_sales='$salese' where id='$idPenduduk'");
	//_insert("insert into log (id,tanggal,id_user,Action) values ('','".date('Y-m-d H-i-s')."','$_SESSION[id_user]','Edit $genre id=$idPenduduk set limit $old=>$limit set alamat = $alamat')");
    }
	
	if ($query){
         header("location: ".app_base_url('administrasi/usersystem')."?msg=1&idUser=$idPenduduk&$tab");
    }
}

else if (isset($_POST['editpermission'])) {
    $dataList = isset($_POST['data'])?$_POST['data']:NULL;
    _delete("TRUNCATE TABLE role_permission");
    echo"<pre>";
    print_r($dataList);
    echo"</pre>";
    foreach($dataList as $data=>$user){
            if(isset($user['permision'])){
                foreach($user['permision'] as $per){
                    _insert("insert into role_permission (id_role,id_privileges) value ($user[id],$per)");
                    echo "insert into role_permission (id_role,id_privileges) value ($user[id],$per)";
                }
            }
    }
    header('location:'.  app_base_url('/administrasi/usersystem').'?msg=1&'.$tab);
}

else if(isset($_POST['editrole'])){
    $edit=_update("update role set nama_role='$_POST[nama_role]' where id_role='$_POST[id]'");
    if($edit)
        header("location: ".app_base_url('administrasi/usersystem')."?msg=1&idRole=$_POST[id]&$tab");
}

else if(isset($_POST['editRolePrivilage'])){
    $id=$_POST['id'];
    $dataList = isset($_POST['data'])?$_POST['data']:NULL;
    _delete("delete from role_permission where id_role='$id'");
    
    foreach($dataList as $data=>$user){
            if(isset($user['permision'])){
                foreach($user['permision'] as $per){
                    _insert("insert into role_permission (id_role,id_privileges) value ($user[id],$per)");
                }
            }

    }
    
    header("location: ".app_base_url('administrasi/usersystem')."?msg=1&$tab");
}


else if(isset ($_GET['do']) && $_GET['do'] == "activation"){
    $active = $_GET['value'];
    $id = $_GET['id'];
    
    $edit = _update("update users set status='$active' where id='$id'") or die (mysql_error());
    if($edit){
         header("location: ".app_base_url('administrasi/usersystem')."?msg=1&$tab");
    }        
}

else if(isset ($_GET['do']) && $_GET['do'] == "reset_user"){
    $id = $_GET['id'];
    $password = md5('petung//31');
    
    $edit = _update("update users set password = '$password' where id='$id'");
    if($edit){
        header("location: ".app_base_url('administrasi/usersystem')."?msg=1&$tab");
    }
}
else if(isset ($_GET['do']) && $_GET['do'] == "delete_role"){
?>
  <h2 class="judul">Administrasi User System</h2>
<?
$sqlhapus = "select * from users where id_role = '$_GET[id]'";
if (_num_rows($sqlhapus) == 0) {
  delete_list_data($_GET['id'], 'role', 'administrasi/usersystem?msg=2','administrasi/usersystem?msr=7',NULL,NULL,"$tabs");
  }
  else{
   header("location:" . app_base_url('administrasi/usersystem?msr=7').'&tab='.$tabs);
  }
  }else if(isset ($_GET['do']) && $_GET['do'] == "delete_privilege"){
?>
  <h2 class="judul">Administrasi User System</h2>
<?
  $privilege = privilege_muat_data($_GET['id']);
  delete_list_data($_GET['id'], 'privileges', 'administrasi/usersystem?msg=1','administrasi/usersystem?msr=7','privilege '.$privilege[0]['nama'],NULL,"$tabs");

}else if(isset ($_GET['do']) && $_GET['do'] == "delete_module"){
?>
  <h2 class="judul">Administrasi User System</h2>
<?

  delete_list_data($_GET['id'], 'module', 'administrasi/usersystem?msg=1','administrasi/usersystem?msr=7',NULL,NULL,"$tabs");
}else if(isset ($_GET['do']) && $_GET['do'] == 'delete_user'){
?>
  <h2 class="judul">Administrasi User System</h2>
<?  
 delete_list_data($_GET['id'], 'users', 'administrasi/usersystem?msg=1','administrasi/usersystem?msr=7',NULL,NULL,"$tabs"); 
}
?>
