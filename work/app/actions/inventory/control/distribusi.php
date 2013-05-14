<?php
set_time_zone();
if(isset ($_POST['save'])){
    $idPacking = $_POST['idPacking'];
    $jumlah = $_POST['jumlah'];
    $idUser = User::$id_user;
    $idUnit = $_POST['unit'];
    $id_stok = $_POST['id_stok'];
    $unitAsal = $_SESSION['id_unit'];
    $batch = $_POST['batch'];
	if(empty($_POST['jumlah'][0])or empty( $_POST['idPacking'][0])){
	 }else{
    $insert = _insert("insert into distribusi values ('',now(),'$idUnit','$idUser')");
      $insert = TRUE;       
	}
    if($insert){
      $idDistribusi = _last_id();
	//echo count($idPacking);
	foreach ($idPacking as $key => $content){
          if($content!=null && $content!=''){
            $jumlahs = $jumlah[$key];  
            $sql = "select * from stok where id='$id_stok[$key]'";
            $data = _select_unique_result($sql);
			
            $sisa = ($data['sisa']-$jumlahs);

            $sql1 = "insert into detail_distribusi_penerimaan_unit values ('','$idDistribusi','$content','$batch[$key]','$jumlah[$key]',NULL,'')";
			_insert($sql1);
            $sql2 = "insert into stok
                (waktu,id_packing_barang,batch,id_unit,awal,masuk,keluar,sisa,id_jenis_transaksi,ed,hpp,hna)
                values
                (now(),'$idPacking[$key]','$batch[$key]','$unitAsal','$data[sisa]','0','$jumlahs','$sisa','5','$data[ed]','$data[hpp]','$data[hna]')";
			_insert($sql2);
          }
      }
      header('location:'.  app_base_url('inventory/distribusi-info').'?msg=4&id='.$idDistribusi.'');
    }
    else{
        header('location:'.  app_base_url('inventory/distribusi').'?msr=3');
    }
}
?>

