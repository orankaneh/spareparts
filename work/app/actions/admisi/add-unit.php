<div class="data-input">
    <form action="<?= app_base_url('admisi/control/unit')?>" method="POST">
    <fieldset>
        <legend>Form Tambah Data Unit</legend>
        <label for="nama">Nama Unit</label>
        <input type="text" name="nama" id="nama">
        <fieldset class="field-group">
            <input type="submit" value="Simpan" class="tombol" name="add">
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-unit')?>'">
        </fieldset>
    </fieldset>    
    </form>    
</div>
