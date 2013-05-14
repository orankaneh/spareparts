<?php
set_time_zone();
if(isset ($_POST['save'])){
    
    $idUser = isset(User::$id_user)?User::$id_user:NULL;
    $barang = $_POST['barang'];
    $barans = $_POST['barang'];
    $no = 0;
    foreach ($barans as $rows) {
        if (!empty($rows['idpacking']) or !empty($rows['nobatch'])) {
            $no += 1;
        }
    }
    if ($no > 0) {
        $insert = _insert("insert into penerimaan_retur_unit values ('',now(),'$idUser')");
	$idPenerimaan = _last_id();
    }
    foreach($barang as $key => $row) {
        if (!empty($row['idpacking']) or !empty($row['nobatch'])) {
            $sql = _insert("insert into detail_penerimaan_retur_unit values ('','$idPenerimaan','$row[idpacking]','$row[nobatch]','$row[jumlah]','$row[alasan]')");

            $sql = "select * from stok where id_packing_barang = '$row[idpacking]' and batch = '$row[nobatch]' and id_unit='$_SESSION[id_unit]' order by id desc limit 0,1";
            $hsl = _select_unique_result($sql);

            $sisa= $hsl['sisa'] + $row['jumlah'];
            $exe = _insert("insert into stok 
                    (waktu,id_packing_barang,batch,ed,id_unit,awal,masuk,keluar,sisa,id_jenis_transaksi,hpp,hna,margin)
                    values
                    (now(),'$row[idpacking]','$row[nobatch]','$hsl[ed]','$_SESSION[id_unit]','$hsl[sisa]','$row[jumlah]','0','$sisa','12','$hsl[hpp]','$hsl[hna]','$hsl[margin]')");
        }
    }
    if ($insert) {
        header('location:'.  app_base_url('inventory/penerimaan-retur-unit').'?msg=4');
    } else {
        header('location:'.  app_base_url('inventory/penerimaan-retur-unit').'?msr=13');
    }
    
}
?>