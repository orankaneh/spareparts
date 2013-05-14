<div class="data-input">
<fieldset><legend>Form Tambah Data Spesialisasi</legend>
    <form action="<?= app_base_url('/admisi/control/spesialisasi') ?>" method="post">
        <label for="spesialisasi">Nama spesialisasi</label><input type="text" name="spesialisasi" id="spesialisasi" />
        <label for="profesi">Nama Profesi</label>
        <input type="text" name="profesi" id="profesi"  />
        <input type="hidden" name="idProfesi" id="idProfesi" />
        <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" name="add" id="save"/>&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-spesialisasi') ?>'" />
         </fieldset>
    </form>
</fieldset>
</div>

