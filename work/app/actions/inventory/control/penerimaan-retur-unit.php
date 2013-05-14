<?php
set_time_zone();
if(isset ($_POST['save'])){
    $idPacking = $_POST['idPacking'];
    $jumlah = $_POST['jumlah'];
    $idUser = User::$id_user;
    $idUnit = $_POST['unit'];
    $unitAsal = $_SESSION['id_unit'];
$alasan=$_POST['alasan'];
    $insert = _insert("insert into penerimaan_unit values ('',now(),'$idUnit')");
  
    if($insert){
      $idPenerimaan = _last_id();
      foreach ($idPacking as $key => $content){

        _insert("insert into detail_penerimaan_unit_retur_unit values ('','$idPenerimaan',$idPacking[$key],'$jumlah[$key]','','$alasan[$key]')");
      }

      header('location:'.  app_base_url('inventory/penerimaan-retur-unit').'?msg=4');
    }
    else{ 
        header('location:'.  app_base_url('inventory/penerimaan-retur-unit').'?msr=3');
    } 
}
?>
