<?php
_insert("insert into retur_penjualan (waktu,id_pegawai) VALUES (now(),'".User::$id_user."')");
$id=_last_id();
foreach($_POST['barang'] as $b){
    if($b['iddetail']!=null){
        _update("update detail_penjualan_retur_penjualan set id_retur_penjualan='$id',jumlah_retur='$b[jumlah]',alasan='$b[alasan]'
            where id='$b[iddetail]'");
        _insert("insert into detail_retur_penjualan (id_packing_barang,jumlah,alasan) values ('$b[idpacking]','$b[jumlah]','$b[alasan]')");
        $sisa=_select_unique_result("(select sisa from stok where id_packing_barang='$barang[idpacking]' and id_unit ='1' order by waktu desc,id desc LIMIT 0,1)");
        $sisa=$sisa['sisa'];
        $stok="insert into stok
        (waktu,id_packing_barang,awal,masuk,keluar,sisa,id_unit,id_jenis_transaksi)
        VALUES
        (now(),'$barang[idpacking]','$sisa','$barang[jumlah]',0,'".($sisa+$barang['jumlah'])."','1',9 )";
        _insert($stok);
    }
}
header('location:'.  app_base_url('inventory/info-penjualan').'?msg=1');
?>
