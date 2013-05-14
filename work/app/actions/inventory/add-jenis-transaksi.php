<form action="<?= app_base_url('inventory/control/jenis-transaksi')?>" method="POST">
<div class="data-input">
    <fieldset>
        <legend>Form Tambah Data Jenis Transaksi</legend>
        <label for="jenisTransaksi">Jenis Transaksi</label><input type="text" name="jenisTransaksi" id="jenisTransaksi">
        <fieldset class="field-group">
            <input type="submit" class="tombol" name="save" value="simpan">
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/jenis-transaksi') ?>'" />
        </fieldset>    
    </fieldset>    
</div>    
</form>    
