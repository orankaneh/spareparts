<?php
include_once "app/lib/common/master-data.php";
if (isset($_POST['simpan'])) {
    $idStok = $_POST['idStok'];
    $idPacking = $_POST['idPacking'];
//    $data=packing_barang_muat_data($idPacking);
    $masuk = $_POST['jumlah'];
    $unit = $_SESSION['id_unit'];
    $hpp = str_ireplace(".", "", $_POST['hpp']);
    $hna = str_ireplace(".", "", $_POST['hna']);
    $batch = (isset($_POST['batch']))?$_POST['batch']:null;
    $gudang = (isset($_GET['gudang']))?$_GET['gudang']:null;
    $ed = (isset($_POST['ed']))?date2mysql($_POST['ed']):null;
    if ($gudang == 1) {
        if($idStok!='' || $idStok!=null){
             $sql = "update stok set id_packing_barang='$idPacking',batch='$batch',hpp='$hpp',hna='$hna',sisa='$masuk' where id='$idStok' ";
        }else{
            $sql = "insert into stok (waktu,id_packing_barang,batch,ed,id_unit,awal,masuk,sisa,id_jenis_transaksi,hpp,hna) 
            values (now(),'$idPacking','$batch','$ed','$unit','0','0','$masuk',11,'$hpp','$hna')";
        }
        $insert = _insert($sql);
        if ($insert) {
           header('location:' . app_base_url('inventory/stok-opname-gudang') . '?msg=1');
        }
    } else {
        if($idStok!='' || $idStok!=null){
             $sql = "update stok_unit set id_packing_barang='$idPacking',batch='$batch',hpp='$hpp',hna='$hna',masuk='$masuk' where id='$idStok' ";
        }else{
            $sql = "insert into stok_unit (waktu,id_packing_barang,id_unit,awal,masuk,sisa,id_jenis_transaksi,hpp,hna,batch) 
            values (now(),'$idPacking','$unit',0,'0','$masuk',11,'$hpp','$hna','$batch')";
        }
        $insert = _insert($sql);
        if ($insert) {
            header('location:' . app_base_url('inventory/stok-opname') . '?msg=1');
        }
    }
} else if (isset($_GET['do']) && $_GET['do'] == "delete") {
    $stok = stock_opname_muat_data($_GET['id']);
    foreach ($stok as $data);
    $barang = $data['barang'];
    $batch = $data['batch'];
    delete_list_data($_GET['id'], 'stok', 'inventory/stok-opname/?msg=2', 'inventory/stok-opname/?msr=7', 'stok ' . $barang . ' no. batch ' . $batch);
}
?>
