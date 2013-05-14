<div class="data-input">
<fieldset>
    <legend>Form Tambah Data Kabupaten</legend>
    <form id="formKab" action="<?= app_base_url('admisi/control/wilayah/add-kabupaten') ?>" method="post">
        <label for="provinsi_kab">Nama Provinsi *</label><input type="text" name="provinsi_kab" id="provinsi_kab" />
        <input type="hidden" name="idProvinsi_kab" id="idProvinsi_kab" value="" />
        <label for="kabupaten_kab">Nama Kabupaten</label>
        <input type="text" name="kabupaten_kab" id="kabupaten_kab" />
        <label for="kabupaten_code">Kode Kabupaten</label>
        <input type="text" name="kabupaten_code" id="kabupaten_code" maxlength="3" onkeyup="Angka(this)" />
        <input type="hidden" name="idKabupaten_kab" id="idKabupaten_kab" />
        <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" />
            <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/admisi/data-wilayah2/?tab=kab')?>'" />
        </fieldset>
    </form>
</fieldset>
</div>
