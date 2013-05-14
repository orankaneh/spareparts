<?php
require_once 'app/lib/administrasi/usersystem.php';
$user = usersystem_muat_data(User::$id_user);
if (md5($_POST['passwordLama']) == $user[0]['password']){

if(md5($_POST['passwordBaru']) ==  $user[0]['password']){
    header('location:'.  app_base_url('administrasi/adm-user?msr=16'));
}
else{
    $sql=_update("update users set password='". md5($_POST['passwordBaru'])."' where id='$_POST[id]'");
    header('location:'.  app_base_url('administrasi/adm-user?msg=3'));
}
}
else{
		echo "<script type='text/javascript'>
     alert('password lama yang anda masukkan salah');
     </script>";
echo "<meta http-equiv='refresh' content='0; url=".app_base_url('administrasi/adm-user')."'>";
}
?>
