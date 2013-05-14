<?php
$row = satuan_muat_data($_GET['id'],null,null,null);
?>
<div class="data-input">
    <form action="<?= app_base_url('/pf/control/satuan/satuan') ?>" method="post">
        <fieldset>
            <legend>Form Edit Data Satuan</legend>
            <input type="hidden" name="id" value="<?= $row['id'] ?>" />
            <label for="satuan-title">Nama Satuan</label>
            <input type="text" id="satuan-title" name="title" value="<?= $row['nama'] ?>" />
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" name="edit" id="save"/>&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('pf/satuan') ?>'" />
            </fieldset>
        </fieldset>
    </form>
</div>

