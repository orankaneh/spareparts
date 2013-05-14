<?php
if(isset ($_POST['save']) || isset ($_POST['savenew'])){
    $idpemesanan = $_POST['idpemesanan'];
    $idpegawai = $_POST['idpegawai'];
    $waktu = $_POST['waktu'];
    $barang = $_POST['barang'];
    $nobatch = $_POST['nobatch'];
    $kadaluarsa = $_POST['kadaluarsa'];
    $jumlahsp = $_POST['jumlahsp'];
    $jumlahTerima = $_POST['jumlahterima'];
    
    _insert("insert into penerimaan(waktu,id_pemesanan,id_unit,id_pegawai)values('".date2mysql($waktu)."','$idpemesanan',1,'$idpegawai')");
    _update("update pemesanan set status = 1 where id = '$idpemesanan'");
//    echo "insert into penerimaan(waktu,id_pemesanan,id_unit,id_pegawai)values('".date2mysql($waktu)."','$idpemesanan',1,'$idpegawai') <br />";
   
    $idpenerimaan = mysql_insert_id();
    foreach ($barang as $key => $value) {
        if($value != NULL){
        _insert("insert into penerimaan_detail(id_penerimaan,id_barang,no_batch,tanggal_kadaluarsa,jumlah)values('$idpenerimaan','$value','$nobatch[$key]','".date2mysql($kadaluarsa[$key])."','$jumlahTerima[$key]')");
//        echo "insert into penerimaan_detail(id_penerimaan,id_barang,no_batch,tanggal_kadaluarsa,jumlah)values('$idpenerimaan','$value','$nobatch[$key]',".date2mysql($kadaluarsa[$key]).",'$jumlah[$key]') <br />";
    }
    }
    if(isset($_POST['savenew'])){
            header("location:".app_base_url('inventory/penerimaan?msg=1'));
    }else{
            header("location:".app_base_url('inventory/info-penerimaan'));
    }
}
?>
