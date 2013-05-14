<?php
if(isset ($_POST['save'])){
    $stokAsal = $_POST['stokAsal'];
    $jumlah_yang_akan_di_pecah = $_POST['jumlah_yang_akan_di_pecah'];
    $hnaHasil = $_POST['hnaAsal'];
    $hppHasil = $_POST['hppAsal'];
    $batchHasil = $_POST['batchHasil'];
    $idPackingHasil = $_POST['idPackingHasil'];
    $unit = $_SESSION['id_unit'];
    $jenisTransaksi = 15;
    $dataAwal = _select_unique_result("select id_packing_barang,sisa,hpp,hna,margin from stok_unit where id_packing_barang = '$idPackingHasil' and waktu = (select max(su.waktu) from stok_unit su where su.id_packing_barang='$idPackingHasil')");
    $sisaAwal = $dataAwal['sisa']-$jumlah_yang_akan_di_pecah;
    $ed = $_POST['edHasil'];
    $queryAwal = "insert into stok_unit (waktu,id_packing_barang,batch,id_unit,awal,keluar,sisa,id_jenis_transaksi,hpp,hna,margin) 
                   values (now(),'$dataAwal[id_packing_barang]','$batchHasil','$unit','$dataAwal[sisa]','$jumlah_yang_akan_di_pecah','$sisaAwal','$jenisTransaksi','$dataAwal[hpp]','$dataAwal[hna]','$dataAwal[margin]')";
    
    $dataHasil = _select_unique_result("select sisa,ed,lead_time from stok where id_packing_barang='$idPackingHasil' and batch='$batchHasil' and waktu = (select max(su.waktu) from stok su where su.id_packing_barang='$idPackingHasil' and batch='$batchHasil' and su.id_unit='$unit') order by id limit 0,1");
 
    if(count($dataHasil) > 0){
        $jumlahStok = $jumlah_yang_akan_di_pecah + $dataHasil['sisa'];
        $queryHasil = "insert into stok (waktu,id_packing_barang,batch,ed,id_unit,awal,masuk,sisa,id_jenis_transaksi,hpp,hna,margin,lead_time) 
                   values (now(),'$idPackingHasil','$batchHasil','$ed','$unit','$dataHasil[sisa]','$jumlah_yang_akan_di_pecah','$jumlahStok','$jenisTransaksi','$hppHasil','$hnaHasil','$dataAwal[margin]','$dataHasil[lead_time]')";
    }else{
        $queryHasil = "insert into stok (waktu,id_packing_barang,batch,ed,id_unit,awal,masuk,sisa,id_jenis_transaksi,hpp,hna,margin,lead_time) 
                   values (now(),'$idPackingHasil','$batchHasil','$ed','$unit','0','$jumlah_yang_akan_di_pecah','$jumlahStok','$jenisTransaksi','$hppHasil','$hnaHasil','$dataAwal[margin]','$dataAwal[lead_time]')";
    }
    
    $inserAwal = _insert($queryAwal);
	$id_stok_awal = _last_id();
    $insertHasil = _insert($queryHasil);
    $id_stok_hasil = _last_id();
    
    header('location:'.  app_base_url('inventory/pecah-info').'?id_hasil='.$id_stok_hasil.'&id_asal='.$id_stok_awal.'&msg=4');
}
?>
