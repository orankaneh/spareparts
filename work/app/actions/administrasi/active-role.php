<?php
$role=  role_muat_data($_GET['id']);
$role=$role[0];
if($role['status']==0)
    $status=1;
else
    $status=0;
$update=_update("update role set status='$status' where id_role='$_GET[id]'");
header("location: ".app_base_url('administrasi/usersystem')."?msg=1&tab=role");
?>
