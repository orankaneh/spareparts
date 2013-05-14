<?php
set_time_zone();
?>
<div class="data-input">
    <fieldset>
        <legend>Form Tambah Administrasi Biaya Apoteker</legend>
        <form action="<?= app_base_url('inventory/control/administrasi-apoteker')?>" method="POST">
        
        <label for="nilai">Nilai</label><input type="text" name="nilai" onkeyup="Angka()">
        <fieldset class="input-process">

        <input type="submit" name="add" value="Simpan" class="tombol">
        <input type="button" value="Batal" onClick="javascript:location.href='<?= app_base_url('inventory/administrasi-apoteker')?>'" class="tombol">
        </fieldset>
    </form>    
    </fieldset>    
</div>    
