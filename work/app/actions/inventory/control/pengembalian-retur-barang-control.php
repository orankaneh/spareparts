<?php
    if(isset($_POST['save'])){
        $retur=_insert("insert into reretur_pembelian (no_surat,waktu,id_pegawai) values
            ('$_POST[nosurat]','".date2mysql($_POST['tanggal'])."','".User::$id_user."')");
        $id_reretur=mysql_insert_id();
        $barangs=$_POST['barang'];
        foreach($barangs as $id=>$barang){
            $sisa=_select_unique_result("(select sisa from stok where id_packing_barang='$barang[idpacking]' and batch='$barang[nobatch]' order by waktu desc,id desc LIMIT 0,1)");
            $sisa=$sisa['sisa'];
             $konversi=_select_unique_result("select nilai_konversi from packing_barang where id='$barang[idpacking]'");
            $stok="insert into stok
            (batch,ed,waktu,id_packing_barang,awal,masuk,keluar,sisa,id_unit,id_jenis_transaksi)
            VALUES
            ('$barang[nobatch]','".date2mysql($barang['tgl'])."',now(),'$barang[idpacking]','$sisa','".$barang['jumlah']."','0','".($sisa+($barang['jumlah']))."','$_SESSION[id_unit]',4)";
            _insert($stok);

           _update("UPDATE detail_pembelian_retur_reretur set
                id_reretur_pembelian='$id_reretur', jumlah_reretur='$barang[jumlah]',harga_reretur_pembelian='".strtoint($barang[harga])."' where id=$barang[iddetail]");
        }
        header('location:'.  app_base_url('inventory/surat-retur')).'?msg=1';
    }
?>
