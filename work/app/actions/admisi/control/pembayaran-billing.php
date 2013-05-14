<?php
if(isset ($_POST['save'])){
    $idBilling = $_POST['idBilling'];
    $totalTagihan = $_POST['totalAll'];
    $user = User::$id_user;
    $bayar = $_POST['bayar'];
    $kembalian = isset ($_POST['kembali'])?$_POST['kembali']:0;
    $sisaTagihan = isset ($_POST['sisaTagihan'])?$_POST['sisaTagihan']:0;
    
    $sql = "insert into pembayaran(id,waktu,id_pegawai_petugas) values ('',now(),'$user')";
    $master = _insert($sql) or die(mysql_error());
    $id = _last_id();
    
    $query = "insert into pembayaran_billing (id_pembayaran,id_billing,jumlah_tagihan,jumlah_bayar,jumlah_kembalian,sisa_tagihan) values ('$id','$idBilling','$totalTagihan','$bayar','$kembalian','$sisaTagihan')";
    $detail = _insert($query) or die(mysql_error());
    
    if($detail){
        header("location: ".app_base_url('admisi/pembayaran-billing')."?msg=4");
    }
    
}
?>
