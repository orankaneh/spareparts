<?php
$idUser = User::$id_user;
$saksi = $_POST['idSaksi'];
$unitAsal = $_SESSION['id_unit'];
$idPemusnahan = $_POST['idPemusnahan'];
//$updatePemusnahan = _update("update pemusnahan set waktu=now(), id_pegawai='$idUser',id_penduduk_saksi='$saksi' where id='$idPemusnahan'");

foreach($_POST['barang'] as $barang){
    if(isset($barang['iddetail'])){
//        $updateDetail = _update("update detail_pemusnahan set id_packing_barang='$barang[idbarang]',no_batch='$barang[nobatch]',jumlah='$barang[jumlah]',alasan='$barang[alasan]' where id_detail_pemusnahan='$barang[iddetail]'");
        $query = _select_unique_result("select * from stok where id_packing_barang = '$barang[idbarang]' and id_unit = '$unitAsal' and waktu = (select max(waktu) from stok where id_packing_barang = '$barang[idbarang]' and id_unit = '$unitAsal')");
        $query2 = _select_unique_result("select id_packing_barang,jumlah from detail_pemusnahan where id_detail_pemusnahan='$barang[iddetail]'");
        
        if($barang['idbarang'] == $query2['id_packing_barang']){
            if($query2['jumlah']>$barang['jumlah']){
                $selisih = $query2['jumlah'] - $barang['jumlah'];
                $stok = _select_unique_result("select keluar,sisa from stok where id_packing_barang='$barang[idbarang]' and id_unit='$unitAsal' order by DATE(waktu) desc limit 0,1");
                $sisa = $stok['sisa'];
                
                
            }else if($query2['jumlah']<$barang['jumlah']){
                
            }
        }else{
            
        }
        echo "$query2[jumlah], $barang[jumlah], $barang[idbarang], $query2[id_packing_barang]";
        
//         _insert("insert into stok values ('','$waktu','$idPacking[$key]','1','$data[sisa]','0','$jumlah[$key]','$sisa','6')");
    }else{
        
    }
//    header('location:'.  app_base_url('/inventory/pemusnahan-edit?id=2'));
}
?>
