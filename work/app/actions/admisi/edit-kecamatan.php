<div class="data-input">
<?php
$kecamatan_id = kecamatan_muat_data($_GET['id']);
$kabupaten_id = kabupaten_muat_data($_GET['kab']);
foreach ($kabupaten_id['list'] as $rows):
	$kabupaten = $rows['namaKabupaten'];
endforeach;?>
<fieldset>
    <legend>Form Edit Data Kecamatan</legend>
    <form id="formKec" action="<?php echo app_base_url('admisi/control/wilayah/edit-kecamatan') ?>" method="post">
        <input type="hidden" name="idKabupaten_kec" id="idKabupaten_kec" value="<?php echo $_GET['kab'] ?>" />
        <input type="hidden" name="idKecamatan_kec" id="idKecamatan_kec" value="<?php echo $_GET['id'] ?>" />
        <label for="kabupaten_kec">Nama Kabupaten/Kota</label><input type="text" name="kabupaten_kec" id="kabupaten_kec" value="<?php echo $kabupaten ?>" />
        <label for="kecamatan_kec">Nama Kecamatan</label><input type="text" name="kecamatan_kec" id="kecamatan_kec" value="<?php echo $kecamatan_id['namaKecamatan'] ?>" />
        <label for="kecamatan_code">Kode Kecamatan</label>
        <input type="text" name="kecamatan_code" id="kecamatan_code" maxlength="3" onkeyup="Angka(this)" value="<?php echo $kecamatan_id['kodeKecamatan'] ?>" />
        <fieldset class="field-group">
            <input type="submit" value="Simpan" class="tombol" />
            <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/admisi/data-wilayah2/?tab=kec')?>'" />
        </fieldset>
    </form>
</fieldset>
</div>
