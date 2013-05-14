<div class="data-input">
    <fieldset>
        <legend>Form Tambah Data Kecamatan</legend>
        <form id="formKec" action="<?= app_base_url('admisi/control/wilayah/add-kecamatan') ?>" method="post">
            <input type="hidden" name="idKabupaten_kec" id="idKabupaten_kec" value="" />
            <label for="kabupaten_kec">Nama Kabupaten/Kota *</label><input type="text" name="kabupaten_kec" id="kabupaten_kec" />
            <label for="kecamatan_kec">Nama Kecamatan</label>
            <input type="text" name="kecamatan_kec" id="kecamatan_kec" />
            <input type="hidden" name="idKecamatan_kec" id="idKecamatan_kec" />
            <label for="kecamatan_code">Kode Kecamatan</label>
            <input type="text" name="kecamatan_code" id="kecamatan_code" maxlength="3" onkeyup="Angka(this)" />
            <fieldset class="field-group">
                <input type="submit" value="Simpan" class="tombol" />
                <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/admisi/data-wilayah2/')?>'" />
            </fieldset>
        </form>
    </fieldset>
</div>
