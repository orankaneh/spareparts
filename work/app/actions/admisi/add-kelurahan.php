<div class="data-input">
    <fieldset>
        <legend>Form Tambah Data Kelurahan</legend>
        <form id="formKel" action="<?= app_base_url('admisi/control/wilayah/add-kelurahan') ?>" method="post">
            <input type="hidden" name="idKecamatan_kel" id="idKecamatan_kel" value="" />
            <label for="kecamatan_kel">Nama Kecamatan *</label><input type="text" name="kecamatan_kel" id="kecamatan_kel" />
            <label for="kelurahan_kel">Nama Kelurahan</label>
            <input type="text" name="kelurahan_kel" id="kelurahan_kel" />
            <input type="hidden" name="idKelurahan_kel" id="idKelurahan_kel" />
            <label for="kelurahan_code">Kode Kelurahan</label>
            <input type="text" name="kelurahan_code" id="kelurahan_code" maxlength="4" onkeyup="Angka(this)" />
            <fieldset class="field-group">
                <input type="submit" value="Simpan" class="tombol" />
                <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/admisi/data-wilayah2/')?>'" />
            </fieldset>
        </form>
    </fieldset>
</div>
