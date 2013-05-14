<?php
  require 'app/actions/admisi/pesan.php';
  require 'app/lib/common/master-data.php';
  
//  $idBarang=isset ($_GET['code'])?$_GET['code']:null;
  $stokAsal = isset ($_GET['id_asal'])?$_GET['id_asal']:null;
  $stokHasil = isset ($_GET['id_hasil'])?$_GET['id_hasil']:null;
  $repackage=array();
  if($stokAsal!=NULL && $stokHasil!=NULL){
    $repackage =  repackage_muat_data($stokAsal,$stokHasil);
  }
  //show_array($repackage);
  $barang1=nama_packing_barang(array($repackage[0]['generik'],$repackage[0]['barang'],$repackage[0]['kekuatan'],$repackage[0]['sediaan'],$repackage[0]['nilai_konversi'],$repackage[0]['satuan_terkecil'],$repackage[0]['pabrik']));
  $barang2=nama_packing_barang(array($repackage[1]['generik'],$repackage[1]['barang'],$repackage[1]['kekuatan'],$repackage[1]['sediaan'],$repackage[1]['nilai_konversi'],$repackage[1]['satuan_terkecil'],$repackage[1]['pabrik']));
  //show_array($repackage);
?>
<h2 class="judul">Repackage</h2><?= isset ($pesan)?$pesan:NULL?>

<div class="data-input">
    <fieldset>
        <legend>Form Repackage</legend>
            <label>Packing Barang Asal</label>
              <span style="font-size: 12px;padding-top: 5px;"><?=$barang1?></span>             
            <fieldset class="field-group">
             <label>  Harga Jual</label> <span style="font-size: 11px;padding-top: 5px" class="hnaAsal"><?=$repackage[0]['hna']?></span>
            </fieldset>
            <fieldset class="field-group">
               <label> Harga  Beli</label> <span style="font-size: 11px;padding-top: 5px" class="hppAsal"><?=$repackage[0]['hpp']?></span>
            </fieldset>  
            <fieldset class="field-group">  
              <label>Sisa Stok Barang Asal</label>
              <span style="font-size: 11px;padding-top: 5px;margin-right: 5px" id="sisaAsal"><?=$repackage[0]['sisa']?></span>
              <span style="font-size: 11px;padding-top: 5px" class="kemasanAsal"><?=$repackage[0]['satuan_terbesar']?></span>
            </fieldset>  
            <label>Packing Barang Hasil</label>
              <span style="font-size: 12px;padding-top: 5px;"><?=$barang2?></span>             
            <fieldset class="field-group">
                <label>Harga Jual</label>
                <span style="font-size: 11px;padding-top: 5px" class="hnaHasil"><?=$repackage[1]['hna']?></span>
            </fieldset>
            <fieldset class="field-group">
            <label>  Harga  Beli</label> <span style="font-size: 11px;padding-top: 5px" class="hppHasil"><?=$repackage[1]['hpp']?></span>
            </fieldset>  
            <fieldset class="field-group">
                <label>No. Batch</label>      
                <span style="font-size: 12px;padding-top: 5px;"><?=$repackage[1]['batch']?></span>             
            </fieldset>  
            <fieldset class="field-group">
              <label>Jumlah Asal*</label>
              <span style="font-size: 12px;padding-top: 5px;"><?=$repackage[0]['keluar']?>&nbsp;</span>    
              <span style="font-size: 11px;padding-top: 5px" class="kemasanAsal"><?=$repackage[0]['satuan_terbesar']?></span>
              <label>Jumlah Hasil</label>
              <span style="font-size: 11px;padding-top: 5px;margin-right: 5px" id="jumlahHasilDisplay"><?=$repackage[1]['sisa']?></span>
              <span style="font-size: 11px;padding-top: 5px" id="kemasanHasil"><?=$repackage[1]['satuan_terkecil']?></span>
            </fieldset>
    </fieldset>
</div>