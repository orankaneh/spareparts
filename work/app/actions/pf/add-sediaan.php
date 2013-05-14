<div class="data-input">
    <fieldset><legend>Form Tambah Data Sediaan</legend>
    <form action="<?= app_base_url('/pf/control/sediaan/sediaan') ?>" method="post">
            <label for="sediaan">Macam Sediaan</label>
            <input type="text" id="satuan-title" name="sediaan"  value="" />
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" name="add" id="save"/>&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('pf/sediaan') ?>'" />
            </fieldset>
    </form>
    </fieldset>
</div>
