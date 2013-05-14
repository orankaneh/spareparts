<?php
set_time_zone();
$data = administrasi_apoteker_muat_data($_GET['id'], NULL);
foreach ($data as $row);        
?>
<script type="text/javascript">
  function cekForm(){
      if($('#nilai').val() == ""){
          alert('Nilai administrasi biaya apoteker tidak boleh kosong');
          $('#nilai').focus();
          return false;
      }
  }
</script>
<div class="data-input">
    <fieldset>
        <legend>Form Edit Administrasi Biaya Apoteker</legend>
        <form action="<?= app_base_url('inventory/control/administrasi-apoteker')?>" method="POST" onsubmit="return cekForm()">
        <input type="hidden" name="id" value="<?= $row['id']?>">  
        <label for="nilai">Nilai (Rp.)</label><input type="text" name="nilai" value="<?= $row['nilai']?>" id="nilai" onKeyup="formatNumber(this)">
        <fieldset class="input-process">
        <input type="submit" name="edit" value="Simpan" class="tombol">
        <input type="button" value="Batal" onClick="javascript:location.href='<?= app_base_url('inventory/administrasi-apoteker')?>'" class="tombol">
        </fieldset>
    </form>    
    </fieldset>    
</div>  
