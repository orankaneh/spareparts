<?php
$aturan_pakai_edit = aturan_pakai_muat_list_data($_GET['id']);
$id=array_value($aturan_pakai_edit, "id");
$keterangan = array_value($aturan_pakai_edit, "nama");
?>
<div class="data-input">
<fieldset><legend>Form Edit Aturan Pakai</legend>
	<form action="<?= app_base_url('/pf/control/aturan-pakai') ?>" method="post">
            <label for="keterangan-title">Keterangan</label>
            <input type="text" id="keterangan" name="keterangan" value="<?= $keterangan ?>" />
	    <input type="hidden" id="id" name="id" value="<?= $id ?>" />
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" id="save" name="edit" />&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('pf/aturan-pakai') ?>'" />
            </fieldset>
    </form>
</fieldset>
</div>