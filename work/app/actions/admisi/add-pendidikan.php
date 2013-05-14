<div class="data-input">
<fieldset><legend>Form Tambah Data pendidikan</legend>

    <form action="<?= app_base_url('/admisi/control/pendidikan') ?>" method="post" onSubmit="return cekform(this)">
        <label for="pendidikan">Nama pendidikan</label><input type="text" name="pendidikan" id="pendidikan" onkeyup="AlpaNumerik(this)" />
         <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="add" />&nbsp;
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-pendidikan') ?>'" />
     </fieldset>
    </form>
</fieldset>
</div>
