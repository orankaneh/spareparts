<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/administrasi/usersystem.php';
if(isset ($_POST['tab']) && $_POST['tab']!=""){
    $tab = "&tab=$_POST[tab]";
}else $tab = "";

switch($_GET['opsi']) {

// --------------------------- Add Module ------------------------ //

case "addmodule":

	$module = $_POST['module'];
	$parent = isset($_POST['parent'])?$_POST['parent']:NULL;
	if($parent != NULL) $query = _insert("insert into module values ('','$module','$parent')");
	else $query = _insert("insert into module (id,module) values ('','$module')"); 

	if($query) echo 1;
	else echo 404;

break;

// -------------------------- Edit Module ------------------------ //

case "editmodule":
    $id_module = $_POST['idModule'];
    $module = $_POST['module'];
    $parent = isset ($_POST['parent'])?$_POST['parent']:NULL;
    
    $edit = _update("update module set module='$module',id_parent_modul='$parent' where id='$id_module'");
    if($edit){
      header("location: ".app_base_url('administrasi/usersystem')."?msg=1&$tab");
    }


break;

// ------------------------- Add Privilege ---------------------- //

case "addprivilege":
    $module = $_POST['module'];
    $privilege = $_POST['privilege'];
    $url = $_POST['url'];
    $icon = $_POST['icon'];
	$icon_extra = $_POST['icon_extra'];
    $query = _insert("insert into privileges (icon,icon_extra,id_module,status_module,nama,url) 
			values ('".$_POST['icon']."','".$_POST['icon_extra']."','".$module."',1,'".$privilege."','".$url."')");
    if($query) echo 1;
	else echo 404;
break;

// ------------------------- Edit Privilege -------------------- //

case "editprivilege":
    $idPrivilege = $_POST['idPrivilege'];
    $privilege = $_POST['privilege'];
    $module = $_POST['module'];
    $url = $_POST['url'];
    
    $edit = _update("update privileges set id_module='$module',nama='$privilege',url='$url' where id='$idPrivilege'");
    
    if($edit){
        header("location: ".app_base_url('administrasi/usersystem')."?msg=1&$tab");
    }
break;

// ------------------------- Hapus Privilege --------------------- //

case "hapusprivilege":
	$exe=_delete("delete from privileges where id='".$_POST['id']."'");
	if ($exe) echo 1;
	else echo 404;
break;

// ------------------------- Add Role ---------------------------- //

case "addrole":

    $namarole = isset($_POST['namarole'])?$_POST['namarole']:null;
    $kategori = isset ($_POST['kategori'])?$_POST['kategori']:null;
    
    $sql = _insert("insert into role values ('','$namarole','1','1')");
    //exit;
    if ($sql) echo 1;
	else echo 404;

break;

}
exit();

