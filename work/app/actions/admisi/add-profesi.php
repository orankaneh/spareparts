
<div class="data-input">
<fieldset><legend>Form Tambah Data Profesi</legend>
    <form action="<?= app_base_url('/admisi/control/profesi') ?>" method="post">
        <label for="profesi">Nama Profesi</label><input type="text" name="profesi" id="profesi"/>
        <label>Jenis Profesi</label>
        <select name="jenis" id="jenis">
            <option value="">Pilih jenis profesi</option>
            <option value="Nakes">Nakes</option>
            <option value="Bukan">Bukan Nakes</option>
        </select>
         <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="add" id="save"/>&nbsp;
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-profesi') ?>'" />
     </fieldset>
    </form>
</fieldset>
</div>
