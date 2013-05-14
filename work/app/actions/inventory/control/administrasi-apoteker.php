<?php
if(isset ($_POST['edit'])){
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $nilai = strtoint($_POST['nilai']);
    
    _update("update biaya_apoteker set nilai='$nilai' where id='$id'");
    header('location:'.  app_base_url('inventory/administrasi-apoteker').'?msg=1');
}
?>
