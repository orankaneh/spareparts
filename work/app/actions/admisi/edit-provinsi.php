<div class="data-input">
<?php
$propinsi_id = propinsi_muat_data($_GET['id']);
?>
<fieldset>
    <legend>Form Edit Data Provinsi</legend>
    <form id="formProv" action="<?= app_base_url('admisi/control/wilayah/edit-provinsi') ?>" method="post" >
        <input type="hidden" name="idProvinsi_prov" id="idProvinsi_prov" value="<?= $propinsi_id['id'] ?>" />
        <label for="provinsi_prov">Nama Provinsi</label><input type="text" name="provinsi_prov" id="provinsi_prov" value="<?= $propinsi_id['nama'] ?>" />
        <label for="provinsi_code">Kode Provinsi</label><input type="text" name="provinsi_code" id="provinsi_code" maxlength="3" onkeyup="Angka(this)" value="<?= $propinsi_id['kode']?>" />
        <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="edit"/>
            <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/admisi/data-wilayah2/?tab=prov')?>'">
        </fieldset>
    </form>
</fieldset>
</div>