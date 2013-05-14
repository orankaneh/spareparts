<?php
if (isset($_POST['repackage'])) {
    $id_packing = $_POST['id_packing_tambah'];
    $jumlah = $_POST['jumlah'];
    _insert("insert into produksi values ('',now(),'$_SESSION[id_user]','$id_packing','$jumlah')");
    $id_produksi = _last_id();
    $id_packing_kurang = $_POST['id_packing_kurang'];
    $jumlah_kurang = $_POST['jumlah_kurang'];
    $harga_baru = array_sum($_POST['hiddenharga']);
    foreach ($id_packing_kurang as $key => $value){
     if($value != ""){   
        _insert("insert into detail_produksi values ('','$id_produksi','$value','$jumlah_kurang[$key]')");
        $sqlA = "select * from stok_unit where id_packing_barang = '$id_packing_kurang' order by id desc limit 1";
        $rowA = _select_unique_result($sqlA);
        $sisa = $rowA['sisa'] - $jumlah_kurang[$key];
        _insert("insert into stok_unit values ('',now(),'$value','$_SESSION[id_unit]','$rowA[sisa]',0,'$jumlah_kurang[$key]','$sisa',13,'$harga_baru','$harga_baru','$rowA[margin]]')");
     }   
    }
     header('location:'.  app_base_url('inventory/produksi-info?msg=1')."&idProduksi=$id_produksi");
}
?>
