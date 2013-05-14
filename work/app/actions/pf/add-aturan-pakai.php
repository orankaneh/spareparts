<div class="data-input">
<fieldset><legend>Form Edit Aturan Pakai</legend>
	<form action="<?= app_base_url('/pf/control/aturan-pakai') ?>" method="post">
            <label for="keterangan-title">Keterangan</label>
            <input type="text" id="keterangan" name="keterangan" value="" />
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" id="save" name="add" />&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('pf/aturan-pakai') ?>'" />
            </fieldset>
    </form>
</fieldset>
</div>
