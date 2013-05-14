<?php
if(isset ($_POST['save'])){
    $idBilling = $_POST['idBilling'];
    $totalTagihan = str_ireplace(".", "", $_POST['totalAll']);
    $user = User::$id_user;
    $bayar = str_ireplace(".", "", $_POST['bayar']);
    $kembalian = isset ($_POST['kembali'])?$_POST['kembali']:0;
    $sisaTagihan = isset ($_POST['sisaTagihan'])?$_POST['sisaTagihan']:0;
    
    $sql = "insert into pembayaran_billing(id,waktu,id_pegawai_petugas) values ('',now(),'$user')";
    $master = _insert($sql) or die(mysql_error());
    $id = _last_id();
    
    $query = "insert into detail_pembayaran_billing (id_pembayaran_billing,id_billing,jumlah_tagihan,jumlah_bayar,jumlah_kembalian,sisa_tagihan)
    values ('$id','$idBilling','$totalTagihan','$bayar','$kembalian','$sisaTagihan')";
   $update = _insert($query) or die(mysql_error());
    if($sisaTagihan == 0){
       $update =  _update("update billing set status_pembayaran = '1' where id = '$idBilling'");
    }
    if($update){
	$sembunyi=base64_encode(base64_encode($totalTagihan));
        header("location: ".app_base_url('billing/pembayaran-billing-info')."?msg=4&id=$_POST[idBilling]&bayar=$bayar&jumlah=$sembunyi");
    }
}
?>
