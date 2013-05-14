<?php
$zatAktif_id = zat_aktif_muat_data($_GET['id']);
$nama = array_value($zatAktif_id, 'nama');
?>
<div class="data-input">
        <fieldset>
            <legend>Form data zat aktif</legend>
            <form action="<?= app_base_url('pf/control/zat-aktif/zat-aktif') ?>" method="post" onSubmit="return cekIsian(this)">
                <label for="satuan-kode">Nama Zat Aktif</label>
                <input type="text" id="satuan-kode" name="nama" value="<?= $nama ?>" />
                   <input type="hidden" id="id" name="id" value="<?= $_GET['id'] ?>" />
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" name="edit" id="save"/>&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('pf/zat-aktif') ?>'" />
            </fieldset>
        </form>
    </fieldset>
</div>