<?php
    if(isset($_POST['save'])){
        $_POST['materai']=str_ireplace(".", "", $_POST['materai']);
        $nosp=$_POST['nosp'];
        $pembelianInsert=_insert("
        INSERT INTO pembelian
        (id_pegawai,waktu,id_instansi_suplier,ppn,materai,tanggal_jatuh_tempo,no_faktur)
        VALUES
        ('". User::$id_user."','".date2mysql($_POST['tanggal'])."','$_POST[idsuplier]','$_POST[ppn]','$_POST[materai]',
                '".date2mysql($_POST['tempo'])."','$_POST[nofaktur]')
        ");
        $id_pembelian=mysql_insert_id();
        $barangs=$_POST['barang'];
        $unitAsal = $_SESSION['id_unit'];
        //cek apakah sudah pernah dilakukan pembelian atau belum
        $jumlah_pembelian=_select_unique_result("select count(*) as jumlah from detail_pemesanan_faktur d where d.id_pemesanan='$nosp' and d.id_pembelian is not null");
        $sudahDilakukanPembelian=($jumlah_pembelian['jumlah']!=0);
        if($sudahDilakukanPembelian){
            $detail_pemesanan=_select_arr("select jumlah_pesan,id_pemesanan,id_packing_barang,lead_time 
                from detail_pemesanan_faktur 
                where id_pemesanan='$nosp' 
                group by id_pemesanan,id_packing_barang");
            foreach($detail_pemesanan as $detail){
                _insert("insert into detail_pemesanan_faktur(id_pemesanan,id_packing_barang,lead_time,id_pembelian,jumlah_pembelian,jumlah_pesan) values 
                    ('$detail[id_pemesanan]','$detail[id_packing_barang]','$detail[lead_time]','$id_pembelian','0','$detail[jumlah_pesan]')");
            }
        }
        foreach($barangs as $id=>$barang){
            $barang['harga']=  currencyToNumber($barang['harga']);
            $konversi=_select_unique_result("select nilai_konversi from packing_barang where id='$barang[idbarang]'");
                        $base_hna=$barang['harga'];
			$hna_ppn= ($_POST['ppn']/100)*$base_hna;
			$hna = $base_hna+$hna_ppn;
         //   $barang['diskon'] = isset($barang['bonus'])?'':$barang['diskon'];
                        $base_hpp 	= (($barang['harga']*$barang['jumlah']) - (($barang['harga']*$barang['jumlah']) * ($barang['diskon']/100))) / ($barang['jumlah']);
			$hpp_ppn	= ($_POST['ppn']/100)*$base_hpp;
			$hpp 		= $base_hpp+$hpp_ppn;
			
            $jumlah = $barang['jumlah'];
            
            $sisa=_select_unique_result("(select sisa from stok where id_packing_barang='$barang[idbarang]' and batch='$barang[no_batch]' and id_unit ='$unitAsal' order by waktu desc,id desc LIMIT 0,1)");
            $sisa=$sisa['sisa'];
          
            $stok="insert into stok
            (id_transaksi,waktu,id_packing_barang,batch,ed,awal,masuk,keluar,sisa,id_unit,id_jenis_transaksi,hpp,hna)
            VALUES
            ('$id_pembelian',now(),'$barang[idbarang]','$barang[no_batch]','".date2mysql($barang['ed'])."','$sisa','".$jumlah."',0,'".($sisa+$jumlah)."','$unitAsal',2,'$hpp','$hna')";
            _insert($stok);
            _insert("INSERT INTO detail_pembelian
            (batch,id_pembelian,id_packing_barang,harga_pembelian,diskon,jumlah_pembelian)
            VALUES
            ('$barang[no_batch]','$id_pembelian','$barang[idbarang]','$barang[harga]','$barang[diskon]','$barang[jumlah]')");
           $id=_select_unique_result("select max(id) as id from detail_pemesanan_faktur detail where detail.id_pemesanan='$nosp' and detail.id_packing_barang='$barang[idbarang]'"); 
           if(isset($barang['iddetail'])){
               $update="update detail_pemesanan_faktur
                set
                   id_pembelian='$id_pembelian',
                   jumlah_pembelian='$barang[jumlah]',
                   batch='$barang[no_batch]',
                   diskon='$barang[diskon]',
                   lead_time='".  selisih_hari($_POST['tanggalPemesanan'],date2mysql($_POST['tanggal']))."'
                WHERE id='$id[id]'";
               _update($update);
           }else{
               //memungkinkan user memasukkan barang, namun lebih dari satu no batch,
               //maka user akan menambah baris baru pada stok
               $detail=_select_unique_result("select id_pembelian,jumlah_pembelian from detail_pemesanan_faktur where id=$barang[iddetail_baru]");
               if($detail['id_pembelian']==$id_pembelian){
                   //jumlah barang lama ditambah jumlah barang baru
                   $update="update detail_pemesanan_faktur
                        set
                           id_pembelian='$id_pembelian',
                           jumlah_pembelian='".($barang['jumlah']+$detail['jumlah_pembelian'])."',
                           batch='$barang[no_batch]',
                           diskon='$barang[diskon]',
                           lead_time='".  selisih_hari($_POST['tanggalPemesanan'],date2mysql($_POST['tanggal']))."'
                        WHERE id='$id[id]'";
                       _update($update);
               }else{
                   $update="update detail_pemesanan_faktur
                    set
                       id_pembelian='$id_pembelian',
                       jumlah_pembelian='$barang[jumlah]',
                       batch='$barang[no_batch]',
                       diskon='$barang[diskon]',
                       lead_time='".  selisih_hari($_POST['tanggalPemesanan'],date2mysql($_POST['tanggal']))."'
                    WHERE id='$id[id]'";
                   _update($update);
               }
           }
        }         
         header('location:'.  app_base_url('inventory/pembelian-info?msg=4')."&idPembelian=$id_pembelian");		 
    }
?>
