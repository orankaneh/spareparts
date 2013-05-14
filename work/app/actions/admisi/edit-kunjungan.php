<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

$kunjungan_by_id = kunjungan_muat_data($_GET['id']);
$perkawinan = perkawinan_muat_data();
$perkawinan = perkawinan_muat_data();
$pekerjaan = profesi_muat_data();
$agama = agama_muat_data();
$input=null;
?>
<script type="text/javascript">
    function checkdata(data) {
        if (data.nama.value == "") {
            alert('Nama tidak boleh kosong');
            data.nama.focus();
            return false;
        }
    }
</script>
<script type="text/javascript">
$(function() {
        $('#kelurahan').autocomplete("<?= app_base_url('/admisi/search?opsi=kelurahan') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama_kel // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result><b style="text-transform:capitalize">'+data.nama_kel+'</b> <i>Kec: '+data.nama_kec+'<br/> Kab: '+data.nama_kab+' Prov: '+data.nama_pro+'</i></div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#kelurahan').attr('value',data.nama_kel);
                $('#idKel').attr('value',data.id_kel);
            }
        );
});
</script>

<h2 class="judul">Edit Data Kunjungan</h2>
<div class="data-input">
<fieldset><legend>Form Edit Data Kunjungan</legend>
<?php foreach($kunjungan_by_id as $row); ?>
<form action="<?= app_base_url('admisi/control/kunjungan/edit') ?>" method="post" name="form" onsubmit="return checkdata(this)">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
        <input type="hidden" name="id_penduduk" value="<?= $row['id_penduduk'] ?>" />
    	<label for="noRekamMedik">No Rekam Medik </label> <input name="noRekamMedik" id="noRekamMedik" disabled type=text value="<?= $row['no_rm'] ?>">
        <label for="nama">Nama Lengkap </label> <input type=text name="nama" id="nama" value="<?= $row['nama'] ?>">
        <label for="alamatJln">Alamat Jalan / RT / RW</label>
        <input type="text" name="alamatJln" id="alamatJln" value="<?= $row['alamat_jalan']?>">
        <label for="kelurahan">Desa / Kelurahan</label>
        <input type="text" name="kelurahan" id="kelurahan" value="<?= $row['nama_kelurahan'] ?>">
		<input type="hidden" name="idKel" id="idKel" value="<?= $row['id_kelurahan']?>">
        <fieldset class="field-group">
                <legend>Jenis Kelamin </legend>&nbsp;
                <label for="laki-laki" class="field-option">
                    <input type="radio" name="jeKel" id="laki-laki" value="L" <?php if ($row['jenis_kelamin'] == 'L') echo"checked"; ?>> Laki-laki</label>
                <label for="perempuan" class="field-option">
                    <input type="radio" name="jeKel" id="perempuan" value="P" <?php if ($row['jenis_kelamin'] == 'P') echo"checked"; ?>> Perempuan</label>
        </fieldset>
        <label for="idPerkawinan">Perkawinan</label>
        <select name="idPerkawinan" id="idPerkawinan">
            <option value="">Pilih Status Perkawinan</option>
            <? foreach($perkawinan as $rows): ?>
            <option value="<?= $rows['id_perkawinan'] ?>" <? if ($rows['id_perkawinan'] == $row['id_perkawinan']) echo "selected"; ?> ><?= $rows['perkawinan'] ?></option>
            <? endforeach; ?>
        </select>
        
        <fieldset class="field-group">
        <label for="tglLahir">Tanggal lahir</label>
        <input type="text" id="tglLahir" name="tglLahir" value="<?= datefmysql($row['tanggal_lahir']) ?>"/>
        <label for="umur-tahun" class="inline-title">Umur</label>
        <input type="text" id="umur-tahun"  value="" class="umur2" onKeyup="Angka(this)" />
        <span>Thn</span>
        <input type="text" id="umur-bulan"  value="" class="umur2" onKeyup="Angka(this)" />
        <span>Bln</span>
        <input type="text" id="umur-hari" value="" class="umur2" onKeyup="Angka(this)" />
        <span>Hr</span>
    </fieldset>
        <label for="namaPkj">Pekerjaan</label>
        <select name="pekerjaan" id="pekerjaan" <?= $input ?>>
            <option value="">Pilih pekerjaan</option>
            <?php foreach($pekerjaan as $rows): ?>
			<option value="<?= $rows['id'] ?>" <? if ($rows['id'] == $row['id_profesi']) echo "selected"; ?>><?= $rows['nama'] ?></option>
            <?php endforeach; ?>
        </select>


    <label for="idAgama">Agama</label>
        <select name="agama" id="agama" <?= $input ?>>
            <option value="">Pilih agama</option>
            <?php foreach($agama['list'] as $rows): ?>
            <option value="<?= $rows['id'] ?>" <? if ($rows['id'] == $row['id_agama']) echo "selected"; ?>><?= $rows['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    <fieldset class="input-process">
        <input type="submit" value="Simpan" class="tombol" name="save" />
        <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('admisi/informasi/data-kunjungan') ?>'" />
        </fieldset>
</form>

</fieldset>
</div>