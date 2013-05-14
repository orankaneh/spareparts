<div class="data-input">
<?php
$kelurahan_id = kelurahan_muat_data($_GET['id']);
$kecamatan_id = kecamatan_muat_data($_GET['kec']);
foreach ($kecamatan_id['list'] as $rows):
	$kecamatan = $rows['namaKecamatan'];
endforeach;
?>
<fieldset>
    <legend>Form Edit Data Kelurahan</legend>
    <form id="formKel" action="<?php echo app_base_url('admisi/control/wilayah/edit-kelurahan') ?>" method="post">
        <input type="hidden" name="idKecamatan_kel" id="idKecamatan_kel" value="<?php echo $_GET['kec'] ?>" />
        <input type="hidden" name="idKelurahan_kel" id="idKelurahan_kel" value="<?php echo $kelurahan_id['idKelurahan'] ?>" />
        <label for="kecamatan_kel">Nama Kecamatan</label><input type="text" name="kecamatan_kel" id="kecamatan_kel" value="<?php echo $kecamatan ?>" />
        <label for="kelurahan_kel">Nama Kelurahan</label><input type="text" name="kelurahan_kel" id="kelurahan_kel" value="<?php echo $kelurahan_id['namaKelurahan'] ?>" />
        <label for="kelurahan_code">Kode Kelurahan</label>
        <input type="text" name="kelurahan_code" id="kelurahan_code" maxlength="4" onkeyup="Angka(this)" value="<?php echo $kelurahan_id['kodeKelurahan'] ?>" />
        <fieldset class="field-group">
            <input type="submit" value="Simpan" class="tombol" />
            <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/admisi/data-wilayah2/?tab=kel')?>'" />
        </fieldset>
    </form>
</fieldset>
</div>
