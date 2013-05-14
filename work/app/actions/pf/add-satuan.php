
<div class="data-input">
    <fieldset><legend>Form Tambah Data Satuan</legend>
    <form action="<?= app_base_url('/pf/control/satuan/satuan') ?>" method="post" onSubmit="return checkdata(this)">
            <label for="satuan-title">Nama Satuan</label>
            <input type="text" id="satuan-title" name="title" value="" onblur="cekSatuan()" />
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" name="add" id="save"/>&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('pf/satuan') ?>'" />
            </fieldset>
    </form>
    </fieldset>
</div>