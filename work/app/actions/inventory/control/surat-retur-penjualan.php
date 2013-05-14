<?php
//print_r($_POST);

if (isset ($_POST['save'])){
    $pembeli = $_POST['pembeli'];
    $unitAsal = $_SESSION['id_unit'];
    $total=$_POST['total'];
    $retur = _insert("insert into retur_penjualan (id,waktu,id_pegawai,total_nilai_retur) values ('',now(),'".User::$id_user."',$total)");
    $idRetur = mysql_insert_id();
    $idPacking = $_POST['barang'];
    
    foreach ($idPacking as $key => $row){
        if(($row['idpacking']!='')&&($row['batch']!='')){
                $st_unit=_select_unique_result("(select sisa,hna,hpp,margin from stok_unit where id_packing_barang='$row[idpacking]' and batch ='$row[batch]' and id_unit='$unitAsal' order by waktu desc,id desc LIMIT 0,1)");
                if(count($st_unit)>0){
                    $sisa=$st_unit['sisa'];
                }else
                    $sisa=0;

           $stok = "insert into stok_unit
                (waktu,id_packing_barang,batch,awal,masuk,keluar,sisa,id_unit,id_jenis_transaksi,hpp,hna,margin)
                VALUES
                (now(),'$row[idpacking]','$row[batch]','$sisa','$row[jumlah]','0','".($sisa+$row['jumlah'])."','$unitAsal',9,'".$st_unit['hpp']."','".$st_unit['hna']."','".$st_unit['margin']."')";
                _insert($stok);   
          $update = "update detail_penjualan_retur_penjualan set id_retur_penjualan='$idRetur',jumlah_retur='$row[jumlah]',alasan='$row[alasan]' where id='$row[iddetail]'";      
          $succes = _update($update);
          $total_tagihan_penjualan=_select_unique_result('select total_tagihan from penjualan where id='.$row['noNota']);
          $total_tagihan_akhir=$total_tagihan_penjualan['total_tagihan']-currencyToNumber($row['subtotal']);
          _update("update penjualan set total_tagihan=$total_tagihan_akhir where id=".$row['noNota']);
        }        
    }
    if($succes){
    echo "<script> win = window.open('../print/surat-retur-penjualan?id=$idRetur&pembeli=$pembeli', 'MyWindow', 'width=500px, height=500px, scrollbars=1');</script>";
    echo "<script>window.location='../surat-retur-penjualan-info?id=$idRetur&msg=4'</script>";
    }
}
?>
