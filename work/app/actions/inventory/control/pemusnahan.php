<?php
set_time_zone();
if(isset ($_POST['save'])){
$idPacking = $_POST['idPacking'];
$jumlah = $_POST['jumlah'];
$stok = $_POST['stok'];
$idStok = $_POST['id_stok'];
$alasan = $_POST['alasan'];
$noBatch = $_POST['no_batch'];
$saksi = $_POST['idsaksi'];
$waktu = date('Y-m-d H:i:s');
$unitAsal = $_SESSION['id_unit'];
$idUser = User::$id_user;
  _insert("insert into pemusnahan values ('','$waktu','$idUser','$saksi')");
  $id = _last_id();
  foreach ($idPacking as $key => $content){
      if($idPacking[$key]==null || $idPacking[$key]=='') continue;
      
      $data = _select_unique_result("select * from stok where id='$idStok[$key]'");
      $sisa = ($data['sisa']-$jumlah[$key]);
      _insert("insert into detail_pemusnahan
              (id_pemusnahan,id_packing_barang,batch,jumlah,alasan) VALUES
              ('$id','$content','$noBatch[$key]','$jumlah[$key]','$alasan[$key]')");
      _insert("insert into stok 
              (waktu,id_packing_barang,id_unit,awal,masuk,keluar,sisa,id_jenis_transaksi,batch,ed,hpp,hna)
              values
              ('$waktu','$idPacking[$key]','$unitAsal','$data[sisa]','0','$jumlah[$key]','$sisa','6','$noBatch[$key]','$data[ed]','$data[hpp]','$data[hna]')");
  }
  header('location:'.  app_base_url('inventory/pemusnahan-info').'?msg=4&id='.$id);
}

?>
