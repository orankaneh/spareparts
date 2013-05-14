<?php
$transaksi = jenis_transaksi_muat_data($_GET['id']);
foreach ($transaksi as $row);
?>
<form action="<?= app_base_url('inventory/control/jenis-transaksi')?>" method="POST">
<div class="data-input">
    <fieldset>
        <legend>Form Tambah Data Jenis Transaksi</legend>
        <label for="jenisTransaksi">Jenis Transaksi</label>
        <input type="text" name="jenisTransaksi" id="jenisTransaksi" value="<?= $row['nama']?>">
        <input type="hidden" name="idJenisTransaksi" value="<?= $row['id']?>">
        <fieldset class="field-group">
            <input type="submit" class="tombol" name="edit" value="simpan">
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/jenis-transaksi') ?>'" />
        </fieldset>    
    </fieldset>    
</div>    
</form> 