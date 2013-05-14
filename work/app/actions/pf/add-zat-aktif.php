<div class="data-input">
<fieldset>
<legend>Form data zat aktif</legend>    
<form action="<?= app_base_url('/pf/control/zat-aktif/zat-aktif') ?>" method="POST" onSubmit="return cekIsian(this)">
        <label for="satuan-kode">Nama Zat Aktif</label>
        <input type="text" id="satuan-kode" name="nama" />
        <fieldset class="input-process">
           <input type="submit" value="Simpan" class="tombol" name="add" id="save"/>&nbsp;
           <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('pf/zat-aktif') ?>'" />
        </fieldset>
</form>
</fieldset>
</div>