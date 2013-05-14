<?php
  require 'app/actions/admisi/pesan.php';
  require 'app/lib/common/master-data.php';
  
//  $idBarang=isset ($_GET['code'])?$_GET['code']:null;
  $stokAsal = isset ($_GET['id_asal'])?$_GET['id_asal']:null;
  $stokHasil = isset ($_GET['id_hasil'])?$_GET['id_hasil']:null;
  $repackage=array();
  if($stokAsal!=NULL && $stokHasil!=NULL){
    $repackage =  pecah_stok_muat_data($stokAsal,$stokHasil);
//	show_array($repackage);
  }
  //show_array($repackage);
  $barang1=nama_packing_barang(array($repackage['sunit']['generik'],$repackage['sunit']['barang'],$repackage['sunit']['kekuatan'],$repackage['sunit']['sediaan'],$repackage['sunit']['nilai_konversi'],$repackage['sunit']['satuan_terkecil'],$repackage['sunit']['pabrik']));
  $barang2=nama_packing_barang(array($repackage['stok']['generik'],$repackage['stok']['barang'],$repackage['stok']['kekuatan'],$repackage['stok']['sediaan'],$repackage['stok']['nilai_konversi'],$repackage['stok']['satuan_terkecil'],$repackage['stok']['pabrik']));
  //show_array($repackage);
?>
<h2 class="judul">Pecah Stok</h2><?= isset ($pesan)?$pesan:NULL?>

<div class="data-input">
    <fieldset>
        <legend>Form Repackage</legend>
            <label>Packing Barang Asal</label>
              <span style="font-size: 12px;padding-top: 5px;"><?=$barang1?></span>             
            <fieldset class="field-group">
             <label>  Harga Jual</label> <span style="font-size: 11px;padding-top: 5px" class="hnaAsal"><?=$repackage['sunit']['hna']?></span>
            </fieldset>
            <fieldset class="field-group">
               <label> Harga  Beli</label> <span style="font-size: 11px;padding-top: 5px" class="hppAsal"><?=$repackage['sunit']['hpp']?></span>
            </fieldset>  
            <fieldset class="field-group">  
              <label>Sisa Stok Barang Asal</label>
              <span style="font-size: 11px;padding-top: 5px;margin-right: 5px" id="sisaAsal"><?=$repackage['sunit']['sisa']?></span>
              <span style="font-size: 11px;padding-top: 5px" class="kemasanAsal"><?=$repackage['sunit']['satuan_terbesar']?></span>
            </fieldset>  
            <label>Packing Barang Hasil</label>
              <span style="font-size: 12px;padding-top: 5px;"><?=$barang2?></span>             
            <fieldset class="field-group">
                <label>Harga Jual</label>
                <span style="font-size: 11px;padding-top: 5px" class="hnaHasil"><?=$repackage['stok']['hna']?></span>
            </fieldset>
            <fieldset class="field-group">
            <label>  Harga  Beli</label> <span style="font-size: 11px;padding-top: 5px" class="hppHasil"><?=$repackage['stok']['hpp']?></span>
            </fieldset>  
            <fieldset class="field-group">
                <label>No. Batch</label>      
                <span style="font-size: 12px;padding-top: 5px;"><?=$repackage['stok']['batch']?></span>             
            </fieldset>  
            <fieldset class="field-group">
              <label>Jumlah Asal*</label>
              <span style="font-size: 12px;padding-top: 5px;"><?=$repackage['stok']['awal']?>&nbsp;</span>    
              <span style="font-size: 11px;padding-top: 5px" class="kemasanAsal"><?=$repackage['stok']['satuan_terbesar']?></span>
                <label>Jumlah Masuk</label>
              <span style="font-size: 11px;padding-top: 5px;margin-right: 5px" id="jumlahHasilDisplay"><?=$repackage['stok']['masuk']?></span>
              <span style="font-size: 11px;padding-top: 5px" id="kemasanHasil"><?=$repackage['stok']['satuan_terbesar']?></span>
              <label>Jumlah Hasil</label>
              <span style="font-size: 11px;padding-top: 5px;margin-right: 5px" id="jumlahHasilDisplay"><?=$repackage['stok']['sisa']?></span>
              <span style="font-size: 11px;padding-top: 5px" id="kemasanHasil"><?=$repackage['stok']['satuan_terbesar']?></span>
            </fieldset>
    </fieldset>
</div>