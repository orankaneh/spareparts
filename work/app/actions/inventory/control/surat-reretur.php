<?php
show_array($_POST);
    if(isset($_POST['save'])){
        $retur=_insert("INSERT INTO reretur_pembelian
            (waktu,id_pegawai)
         values
            (now(),'".User::$id_user."')");
        $id_reretur=mysql_insert_id();
        $barangs=$_POST['barang'];
        foreach($barangs as $id=>$barang){
            if($barang['idpacking']=='' || $barang['idpacking']==null)                
                continue;
            $sisa=_select_unique_result("(select sisa from stok where id_packing_barang='$barang[idpacking]' and batch='$barang[batch]' order by waktu desc,id desc LIMIT 0,1)");
            $sisa=$sisa['sisa'];
             $konversi=_select_unique_result("select nilai_konversi from packing_barang where id='$barang[idpacking]'");
            $stok="insert into stok
            (batch,ed,waktu,id_packing_barang,awal,masuk,keluar,sisa,id_unit,id_jenis_transaksi)
            VALUES
            ('$barang[batch]','".date2mysql($barang['ed'])."',now(),'$barang[idpacking]','$sisa','".$barang['jumlah']."','0','".($sisa+$barang['jumlah'])."','$_SESSION[id_unit]',4)";
            _insert($stok);
          //cek apakah sudah pernah direretur belum  
          $cek_reretur=_select_unique_result("select count(*) as jumlah 
              from detail_pembelian_retur_reretur 
              where id='$barang[iddetail]' and id_reretur_pembelian is not null");
          echo"$cek_reretur[jumlah]";
          if($cek_reretur['jumlah']==0){
               _update("UPDATE detail_pembelian_retur_reretur set
                    id_reretur_pembelian='$id_reretur', 
                     jumlah_reretur='$barang[jumlah]',
                     harga_reretur_pembelian='$barang[harga]' 
                     where id=$barang[iddetail]");
          }else{
              $detail=_select_unique_result("select id_pembelian,id_packing_barang,batch,harga_pembelian,
                diskon,jumlah_pembelian,id_retur_pembelian,jumlah_retur_pembelian,alasan,
                id_reretur_pembelian,jumlah_reretur,harga_reretur_pembelian
                from detail_pembelian_retur_reretur where id=$barang[iddetail]");
              _insert("insert into detail_pembelian_retur_reretur 
                  (id_pembelian,id_packing_barang,batch,harga_pembelian,
                diskon,jumlah_pembelian,id_retur_pembelian,jumlah_retur_pembelian,alasan,
                id_reretur_pembelian,jumlah_reretur,harga_reretur_pembelian)
                VALUES
                  ($detail[id_pembelian],$detail[id_packing_barang],'$detail[batch]',$detail[harga_pembelian],
                  $detail[diskon],$detail[jumlah_pembelian],$detail[id_retur_pembelian],$detail[jumlah_retur_pembelian],
                  '$detail[alasan]',$id_reretur,$barang[jumlah],$barang[harga])
                  ");
          }
        }
        header('location:'.  app_base_url('inventory/surat-reretur-info').'?id='.$id_reretur.'msg=1');
    }
?>

