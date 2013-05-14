<?php
$idUnit = $_SESSION['id_unit'];
_insert("insert into retur_unit (waktu,id_pegawai) values (now(),'$_SESSION[id_user]')");
$id=_last_id();

show_array($_POST['barang']);
foreach($_POST['barang'] as $b){
        if(isset($b['idpacking']) && $b['idpacking']!=''){
        $hasil=_update("update detail_penerimaan_unit_retur_unit
            set id_retur_unit='$id',jumlah_retur_penerimaan_unit='$b[jumlah]',alasan='$b[alasan]'
            where id='$b[id_detail]'");

        $query = "select sisa,hpp,hna,margin from stok_unit where id_packing_barang = '$b[idpacking]' and id_unit = '$idUnit' order by waktu desc limit 0,1";
        $result=_select_unique_result($query);
        $sisaAwal=$result['sisa'];
        $stok="insert into stok_unit 
        (waktu,id_packing_barang,id_unit,awal,masuk,keluar,sisa,id_jenis_transaksi,hpp,hna,margin)
values  (now(),'$b[idpacking]','$idUnit','$sisaAwal','0','$b[jumlah]','".($sisaAwal-$b['jumlah'])."',12,'$result[hpp]','$result[hna]','$result[margin]')";
        $insertStok = _insert($stok);
        
        if(!$hasil){
            header('location:'.  app_base_url('inventory/surat-retur-unit?msr=3'));
        }
    }
}

header('location:'.  app_base_url('inventory/surat-retur-unit-info?msg=4')."&id=$id");
?>
