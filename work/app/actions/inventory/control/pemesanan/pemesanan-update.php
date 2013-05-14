<?php
/* 
 * update pemesanan
 * update detail pemesanan
 * insert detail pemesanan
 */
$updatePemesanan=  _update("update pemesanan set waktu='".date2mysql($_POST['tanggal'])."',id_instansi_relasi_suplier='$_POST[idsuplier]',jenis_sp='$_POST[jenis]',id_pegawai='". User::$id_user."' where id='$_POST[nosurat]'");

foreach($_POST['barang'] as $barang)
	{
    if(isset($barang['iddetail'])){
        $updateDetail=_update("update detail_pemesanan_faktur set id_packing_barang='$barang[idbarang]',jumlah_pesan='$barang[jumlah]' where id='$barang[iddetail]'");
    }else{
        $insertDetail=_insert("insert into
        detail_pemesanan_faktur (id_pemesanan,id_packing_barang,jumlah_pesan)
        values ('$_POST[nosurat]','$barang[idbarang]',$barang[jumlah])");
	}
}
header('location:'.  app_base_url('/inventory/info-pemesanan'));
?>
