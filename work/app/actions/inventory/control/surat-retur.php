<?php
    if(isset($_POST['save'])){
        $waktu = isset ($_POST['waktu'])?$_POST['waktu']:NULL;
        $waktu_simpan = explode(" ", $waktu);
        $waktu_simpan = date2mysql($waktu_simpan[0])." ".$waktu_simpan[1];
        
        $unitAsal = $_SESSION['id_unit'];
        $retur=_insert("INSERT INTO retur_pembelian
            (waktu,id_pegawai,id_instansi_relasi_suplier)
         values
            ('$waktu_simpan','".User::$id_user."','$_POST[idsuplier]')");
        $id_retur=mysql_insert_id();
        $barangs=$_POST['barang'];
        $no = 0;
        foreach($barangs as $id=>$barang){
            if($barang['idpacking']!=''){
                $sisa=_select_unique_result("(select * from stok
                        where id_packing_barang='$barang[idpacking]' 
                        and batch='$barang[noBatch]' and id_unit='$unitAsal' order by waktu desc,id desc LIMIT 0,1)");
                 $ed=(isset($sisa['ed'])?$sisa['ed']:null);
                 $hpp=(isset($sisa['hpp'])?$sisa['hpp']:null);
                 $hna=(isset($sisa['hna'])?$sisa['hna']:null);
                 echo "ed=$ed";
                if(count($sisa)>0){
                    $sisa=$sisa['sisa'];
                }else{
                    $sisa=0;
                }
                $stok="insert into stok
                (batch,waktu,id_packing_barang,awal,masuk,keluar,sisa,id_unit,id_jenis_transaksi,ed,hpp,hna)
                VALUES
                ('$barang[noBatch]',now(),'$barang[idpacking]','$sisa','0','".$barang['jumlah']."','".($sisa-($barang['jumlah']))."','$unitAsal',3,'$ed',$hpp,$hna)";
                _insert($stok);
                _insert("insert into detail_retur_reretur 
                    (id_retur,id_packing,no_faktur,batch_retur,jumlah_retur,alasan)
                    VALUES
                    ($id_retur,'$barang[idpacking]','$barang[faktur]','$barang[noBatch]',$barang[jumlah],'$barang[alasan]')");
               $no += 1;
            }
        }
        if ($no > 0) {
            header('location:'.  app_base_url('inventory/surat-retur-pembelian-info').'?msg=4&id='.$id_retur);
        } else {
            header('location:'.  app_base_url('inventory/surat-retur-pembelian').'?msr=13');
        }
    }
?>
