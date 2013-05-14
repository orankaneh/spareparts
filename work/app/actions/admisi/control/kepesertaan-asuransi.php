<?php
if(isset ($_POST['save'])){  
  $idKunjungan = $_POST['idKunjungan'];
  $idProdukAsuransi = $_POST['idProdukAsuransi'];
  $noPolis = $_POST['noPolis'];
      foreach ($idProdukAsuransi as $key => $row){
          $sql = "insert into asuransi_kepesertaan_kunjungan (id,id_kunjungan,id_asuransi_produk,no_polis) values ('','$idKunjungan','$row','$noPolis[$key]')";
          $insert = _insert($sql);
      }
      header("location: ".app_base_url('admisi/kepesertaan-asuransi-info/')."?msg=1&idKunjungan=$idKunjungan");
}  
?>
