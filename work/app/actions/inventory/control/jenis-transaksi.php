<?php
if(isset ($_POST['save'])){
    $transaksi = $_POST['jenisTransaksi'];
    _insert("insert into jenis_transaksi values('','$transaksi')");
    
    header('location:'.  app_base_url('inventory/jenis-transaksi').'?msg=1');
}else if(isset ($_POST['edit'])){
    $transaksi = $_POST['jenisTransaksi'];
    $idJenisTransaksi = $_POST['idJenisTransaksi'];
    _update("update jenis_transaksi set nama='$transaksi' where id='$idJenisTransaksi'");
    
    
    header('location:'.  app_base_url('inventory/jenis-transaksi').'?msg=1');
}else if(isset ($_GET['id'])){
    $idJenisTransaksi = $_GET['id'];
    
    delete_list_data($idJenisTransaksi, 'jenis_transaksi', 'inventory/jenis-transaksi/?msg=2','inventory/jenis-transaksi/?msr=7');
}
?>
