<?php
$value = sediaan_muat_data2($_GET['id']);
?>
<div class="data-input">
    <fieldset><legend>Form Edit Data Sediaan</legend>
    <form action="<?= app_base_url('/pf/control/sediaan/sediaan') ?>" method="post">
            <label for="sediaan">Macam Sediaan</label>
            <? foreach ($value as $row){?>
            <input type="text" id="satuan-title" name="sediaan" value="<?= $row['nama']?>" />
            <? } ?>
            <input type="hidden" id="satuan-title" name="idSediaan" value="<?= $_GET['id']?>" />
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" name="edit" id="save"/>&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('pf/sediaan') ?>'" />
            </fieldset>
    </form>
    </fieldset>
</div>
