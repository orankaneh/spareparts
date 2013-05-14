<div class="data-input">
<fieldset>
    <legend>Form Tambah Data Provinsi</legend>
    <form id="formProv" action="<?= app_base_url('admisi/control/wilayah/add-provinsi') ?>" method="post">
        <label for="provinsi_prov">Nama Provinsi</label><input type="text" name="provinsi_prov" id="provinsi_prov" />
        <label for="provinsi_code">Kode Provinsi</label><input type="text" name="provinsi_code" id="provinsi_code" maxlength="3" onkeyup="Angka(this)" />
        <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" />
            <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/admisi/data-wilayah2/?tab=prov')?>'">
        </fieldset>
    </form>
</fieldset>
</div>