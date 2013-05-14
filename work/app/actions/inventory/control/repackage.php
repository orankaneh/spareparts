<?php
if(isset ($_POST['save'])){
    $stokAsal = $_POST['stokAsal'];
    $jumlahAsal = $_POST['jumlahAsal'];
    $jumlahHasil = $_POST['jumlahHasil'];
    $hnaHasil = $_POST['hnaHasil'];
    $hppHasil = $_POST['hppHasil'];
    $batchHasil = $_POST['batchHasil'];
    $idPackingHasil = $_POST['idPackingHasil'];
    $unit = $_SESSION['id_unit'];
    $jenisTransaksi = 13;
    $dataAwal = _select_unique_result("select id_packing_barang,batch,ed,sisa,hpp,hna,margin,lead_time from stok where id = '$stokAsal'");
    $sisaAwal = $dataAwal['sisa']-$jumlahAsal;
    
    $queryAwal = "insert into stok (waktu,id_packing_barang,batch,ed,id_unit,awal,keluar,sisa,id_jenis_transaksi,hpp,hna,margin,lead_time) 
                   values (now(),'$dataAwal[id_packing_barang]','$dataAwal[batch]','$dataAwal[ed]','$unit','$dataAwal[sisa]','$jumlahAsal','$sisaAwal','$jenisTransaksi','$dataAwal[hpp]','$dataAwal[hna]','$dataAwal[margin]','$dataAwal[lead_time]')";
    
    $dataHasil = _select_unique_result("select sisa from stok where batch='$batchHasil' and id_packing_barang='$idPackingHasil' order by id DESC limit 0,1");
    echo "$dataHasil[sisa] <br />";
    if(count($dataHasil) > 0){
        $jumlahStok = $jumlahHasil + $dataHasil['sisa'];
        $queryHasil = "insert into stok (waktu,id_packing_barang,batch,ed,id_unit,awal,masuk,sisa,id_jenis_transaksi,hpp,hna,margin,lead_time) 
                   values (now(),'$idPackingHasil','$batchHasil','$dataAwal[ed]','$unit','$dataHasil[sisa]','$jumlahHasil','$jumlahStok','$jenisTransaksi','$hppHasil','$hnaHasil','$dataAwal[margin]','$dataAwal[lead_time]')";
    }else{
        $queryHasil = "insert into stok (waktu,id_packing_barang,batch,ed,id_unit,awal,masuk,sisa,id_jenis_transaksi,hpp,hna,margin,lead_time) 
                   values (now(),'$idPackingHasil','$batchHasil','$dataAwal[ed]','$unit','0','$jumlahHasil','$jumlahHasil','$jenisTransaksi','$hppHasil','$hnaHasil','$dataAwal[margin]','$dataAwal[lead_time]')";
    }
    
    $inserAwal = _insert($queryAwal);
	$id_stok_awal = _last_id();
    $insertHasil = _insert($queryHasil);
    $id_stok_hasil = _last_id();
    
    header('location:'.  app_base_url('inventory/repackage-info').'?id_hasil='.$id_stok_hasil.'&id_asal='.$id_stok_awal.'&msg=4');
}
?>
