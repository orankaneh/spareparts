<?
require_once 'app/lib/administrasi/usersystem.php';
$id = isset ($_GET['role'])?$_GET['role']:NULL;
$role=role_muat_data($id);
$rolee=$role[0]['nama_role'];

if($rolee!=''){
	
					if(strtolower($rolee)=="sales"){
						$result=array('role'=>'sales');
					}
					else if(strtolower($rolee)=="konsumen"){
						$result=array('role'=>'konsumen');
					}
					else{
						$result=array('role'=>'ngadimin');
					}
    
	die(json_encode($result));
}
?>