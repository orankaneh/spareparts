<?
set_time_zone() ;
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
    if(isset($_POST['save'])){
        $waktu = isset ($_POST['waktu'])?$_POST['waktu']:NULL;
		 $jenis = isset ($_POST['jenis'])?$_POST['jenis']:NULL;
		 if ($jenis != 'Uang'){
		 $jenis='Barang';
		 }
        $waktu_simpan = explode(" ", $waktu);
        $waktu_simpan = date2mysql($waktu_simpan[0])." ".$waktu_simpan[1];
    
         $retur=_insert("INSERT INTO reretur_pembelian
             (waktu,no_surat,id_pegawai)
          values
             ('$waktu_simpan','$_POST[no_surat]','".User::$id_user."')");
         $id_reretur=mysql_insert_id();
      $barangs=$_POST['barang'];
        foreach($barangs as $id=>$barang){  
            $barang['harga']=currencyToNumber($barang['harga']);
            if($barang['idpacking']=='' || $barang['idpacking']==null)                
                continue;
             $sisa=_select_unique_result("(select sisa from stok where id_packing_barang='$barang[idpacking]' and batch='$barang[batch]' order by waktu desc,id desc LIMIT 0,1)");
             $sisa=$sisa['sisa'];
             $hpp_hna=_select_unique_result("(select hpp,hna from stok where id_packing_barang='$barang[idpacking]' and batch='$barang[batchFaktur]' order by waktu desc,id desc LIMIT 0,1)");
             $hpp = $hpp_hna['hpp'];
             $hna = $hpp_hna['hna'];
              $konversi=_select_unique_result("select nilai_konversi from packing_barang where id='$barang[idpacking]'");
			 if($jenis=='Uang'){
            $stok="insert into stok
  (id_transaksi,batch,ed,waktu,id_packing_barang,awal,masuk,keluar,sisa,id_unit,id_jenis_transaksi,hpp,hna)
            VALUES

            ('$id_reretur','$barang[batch]','".date3mysql($barang['ed'])."',now(),'$barang[idpacking]','$sisa','0','0','".($sisa+0)."','$_SESSION[id_unit]',4,$hpp,$hna)";


           
			}
			else{
			     $stok="insert into stok
      (id_transaksi,batch,ed,waktu,id_packing_barang,awal,masuk,keluar,sisa,id_unit,id_jenis_transaksi,hpp,hna)
            VALUES
            ('$id_reretur','$barang[batch]','".date2mysql2($barang['ed'])."',now(),'$barang[idpacking]','$sisa','".$barang['jumlah']."','0','".($sisa+$barang['jumlah'])."','$_SESSION[id_unit]',4,$hpp,$hna)";
		}
			 _insert($stok);
			
         //  cek apakah sudah pernah direretur belum  
          $cek_reretur=_select_unique_result("select count(*) as jumlah 
              from detail_retur_reretur 
              where id='$barang[iddetail]' and id_reretur is not null");
          echo"$cek_reretur[jumlah]";
          if($cek_reretur['jumlah']==0){
               _update("UPDATE detail_retur_reretur set
                    id_reretur='$id_reretur', 
                     batch_reretur='$barang[batch]',  
                     jumlah_reretur='$barang[jumlah]',
                     bentuk='$jenis' 
                     where id=$barang[iddetail]");
          }else{
              $detail=_select_unique_result("select id_packing,no_faktur,batch_retur,id_retur,jumlah_retur,alasan,
                id_reretur,jumlah_reretur,bentuk
                from detail_retur_reretur where id=$barang[iddetail]");
              _insert("insert into detail_retur_reretur 
                  (id_packing,no_faktur,batch_retur,id_retur,jumlah_retur,alasan,
                id_reretur,batch_reretur,jumlah_reretur,bentuk)
                VALUES
                  ('$detail[id_packing]','$detail[no_faktur]','$detail[batch_retur]','$detail[id_retur]','$detail[jumlah_retur]',
                  '$detail[alasan]','$id_reretur','$barang[batch]','$barang[jumlah]','$jenis')
                  ");
          }
        }
        header('location:'.  app_base_url('inventory/surat-reretur-pembelian-info').'?id='.$id_reretur.'&msg=1');
    }
?>

