<?
$pendidikan_id = pendidikan_muat_data($_GET['id']);
?>
<div class="data-input">
<fieldset><legend>Form Edit Data pendidikan</legend>
    <? foreach($pendidikan_id as $row): ?>
    <form action="<?= app_base_url('/admisi/control/pendidikan') ?>" method="post">
        <input type="hidden" name="idPendidikan" value="<?= $row['id'] ?>" />
        <label for="pendidikan">Nama pendidikan</label><input type="text" name="pendidikan" id="pendidikan" value="<?= $row['nama'] ?>" onkeyup="AlpaNumerik(this)" />
         <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="edit" />&nbsp;
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-pendidikan') ?>'" />
     </fieldset>
    </form>
    <? endforeach; ?>
</fieldset>
</div>
