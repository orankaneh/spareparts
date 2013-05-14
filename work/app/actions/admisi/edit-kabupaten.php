<div class="data-input">
<?php
$kabupaten_id = kabupaten_muat_data($_GET['id']);
$provinsi_id = propinsi_muat_data($_GET['prov']);
foreach ($provinsi_id['list'] as $rows):
	$provinsi = $rows['nama'];
endforeach;?>
<fieldset>
    <legend>Form Edit Data Kabupaten/Kota</legend>
    <form id="formKab" action="<?php echo app_base_url('admisi/control/wilayah/edit-kabupaten') ?>" method="post">
        <input type="hidden" name="idprovinsi_kab" id="idProvinsi_kab" value="<?php echo $_GET['prov'] ?>" />
        <input type="hidden" name="idkabupaten_kab" id="idKabupaten_kab" value="<?php echo $kabupaten_id['idKabupaten'] ?>" />
        <label for="provinsi_kab">Nama Provinsi</label><input type="text" name="provinsi_kab" id="provinsi_kab" value="<?php echo $provinsi ?>" />
        <label for="kabupaten_kab">Nama Kabupaten/Kota</label><input type="text" name="kabupaten_kab" id="kabupaten_kab" value="<?php echo $kabupaten_id['namaKabupaten'] ?>" />
        <label for="kabupaten_code">Kode Kabupaten</label>
        <input type="text" name="kabupaten_code" id="kabupaten_code" maxlength="3" onkeyup="Angka(this)" value="<?php echo $kabupaten_id['kodeKabupaten'] ?>" />
        <fieldset class="field-group">
            <input type="submit" value="Simpan" class="tombol" />
            <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/admisi/data-wilayah2/?tab=kab')?>'" />
        </fieldset>
    </form>
</fieldset>
</div>
