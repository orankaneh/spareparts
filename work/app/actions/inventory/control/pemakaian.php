<?php
set_time_zone();
if(isset ($_POST['save'])){
    $waktu = date('Y-m-d H:i:s');
    $unit = $_POST['idUnit'];
    $idPacking = $_POST['idPacking'];
    $jumlah = $_POST['jumlah'];
    $idStok = $_POST['id_stok'];
    $waktu = date('Y-m-d H:i:s');
    $batch = $_POST['batch'];
    $idUser = User::$id_user;
    
   _insert("insert into pemakaian (waktu,id_pegawai,id_unit) values ('$waktu','$idUser','$unit')");
    $id = _last_id();
    foreach ($idPacking as $key => $content){
         
        if(isset ($content) && $content != ""){
      $detail = _insert("insert into detail_pemakaian (id_pemakaian,id_packing_barang,batch,jumlah) values ('$id','$content','$batch[$key]','$jumlah[$key]')");
	   $sql_ed = _select_unique_result("select ed from stok where id_packing_barang='$content' and batch='$batch[$key]' ");
        if($unit == 1 || $unit == 2 || $unit == 20){
          $stok = "stok";  
          $batchs = ",batch";
          $batchIsi = ",'$batch[$key]'";
          $ed_value = ",'$sql_ed[ed]'";
          $ed_kolom = ",ed";
        }else{
          $stok = "stok_unit";
          $batchs = ",batch";
          $batchIsi = ",'$batch[$key]'";
          $ed_value = "";
          $ed_kolom = "";
        }
        $data = _select_unique_result("select sisa,hpp,hna from $stok where id = '$idStok[$key]'");
        $sisa = $data['sisa'] - $jumlah[$key];
        $hpp = $data['hpp'];
        $hna = $data['hna'];
		$stokInsert = _insert("insert into $stok (waktu,id_packing_barang$batchs,id_unit,awal,keluar,sisa,hpp,hna,id_jenis_transaksi$ed_kolom) values ('$waktu','$content'$batchIsi,'$unit','$data[sisa]','$jumlah[$key]','$sisa','$hpp','$hna',14$ed_value)");
        }
    }
    if($stokInsert){
        header('location:'.  app_base_url('inventory/pemakaian-info').'?msg=4&id='.$id);
    }
}
?>
