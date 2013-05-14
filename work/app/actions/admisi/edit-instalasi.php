<?
$instalasi_id = instalasi_muat_data($_GET['id'])
?>
<div class="data-input">
<fieldset><legend>Form Edit Data Instalasi/Ruang</legend>
    <? foreach($instalasi_id as $row): ?>
    <form action="<?= app_base_url('/admisi/control/instalasi/edit') ?>" method="post" name="dataform" onSubmit="return cekform(this)">
        <input name="idInstalasi" type="hidden" value="<?= $row['id'] ?>" />
        <label for="instalasi">Nama</label><input type="text" name="instalasi" id="instalasi" value="<?= $row['nama'] ?>"/>
        <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="save" id="save"/>&nbsp;
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-instalasi') ?>'" />
     </fieldset>
    </form>
    <? endforeach; ?>
</fieldset>
</div>