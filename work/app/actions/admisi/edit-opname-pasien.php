<?
  $row= pasien_opname_muat_data($_GET['id'],NULL,NULL,NULL);
  $pekerjaan = pekerjaan_muat_data();
  $agama = agama_muat_data();
  $pendidikan = pendidikan_muat_data();
?>        
<script type="text/javascript">
	function cekform(form) {
		if (form.noRekamMedik.value == "") {
			alert("No rekam medik tidak boleh kosong !");
			form.noRekamMedik.focus();
			return false;
		}
		if (form.nama.value == "") {
			alert("Nama pasien tidak boleh kosong !");
			form.nama.focus();
			return false;
		}
		if (form.almt.value == "") {
			alert("Alamat jalan tidak boleh kosong !");
			form.almt.focus();
			return false;
		}
		if (form.no_kunjungan.value == "") {
			alert("no kunjungan tidak boleh kosong !");
			form.no_kunjungan.focus();
			return false;
		}
		if (form.idKelurahan.value == "") {
			alert("Nama kelurahan tidak boleh kosong !");
			form.idKelurahan.focus();
			return false;
		}
	}
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
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#kelurahan').attr('value',data.nama_kel);
                $('#idKelurahan').attr('value',data.id_kel);
            }
        );
});
</script>
<div class="data-input">
<fieldset><legend>Form Edit Opname Pasien</legend>
<form action="<?= app_base_url('/admisi/control/pasien/edit') ?>" method="post" name="form" onsubmit="return cekform(this)">
        <input type="hidden" name="idPasien" value="<?= $row['id_pas'] ?>" />
        <input type="hidden" name="idPenduduk" value="<?= $row['id_penduduk'] ?>" />
	<table width="100%"><tr><td valign="top">
                    <label for="noRekamMedik">No Rekam Medik </label> <input type="text" disabled value="<?= $row['id_pas'] ?>"><input name="noRekamMedik" id="noRekamMedik" type="hidden" value="<?= $row['id_pas'] ?>">
        <label for="nama">Nama Lengkap </label> <input type=text name="nama" id="nama" value="<?= $row['nama_pas'] ?>"><span class='bintang'>*</span>
        <label for="almt">Alamat Jalan / RT / RW </label> <input type="text" name="almt" id="almt" value="<?= $row['alamat_jalan'] ?>">
        <label for="kelurahan">Desa / Kelurahan </label>
        	<input type="text" name="kelurahan" id="kelurahan" value="<?= $row['nama_kelurahan'] ?>">
            <input type="hidden" name="idKelurahan" id="idKelurahan" value="<?= $row['id_kelurahan'] ?>">
       	<fieldset class="field-group">
                    <legend>Jenis Kelamin </legend>&nbsp;
                    <label for="laki-laki" class="field-option">
                    	<input type="radio" name="jeKel" id="laki-laki" value="L" <?php if ($row['jenis_kelamin'] == 'L') echo"checked"; ?>> Laki-laki</label>
                    <label for="perempuan" class="field-option">
                    	<input type="radio" name="jeKel" id="perempuan" value="P" <?php if ($row['jenis_kelamin'] == 'P') echo"checked"; ?>> Perempuan</label>
        </fieldset>
            <fieldset class="field-group">
                <legend>Tanggal Lahir</legend>
                <input type="text" name="tglLahir" id="tglLahir" class="tanggal" value="<?= datefmysql($row['tanggal_lahir']) ?>">
				<label for="umur-tahun" class="inline-title">Umur:</label>
				<input type="text" name='umur' id="umur-tahun"  value="" class="umur2" onKeyup="Angka(this)" />
				<span>Thn</span>
				<input type="text" id="umur-bulan"  value="" class="umur2" onKeyup="Angka(this)" />
				<span>Bln</span>
				<input type="text" id="umur-hari" value="" class="umur2" onKeyup="Angka(this)" />
				<span>Hr</span>
                <script type="text/javascript">hitungUmur();</script>
            </fieldset>
            <label for="gol_darah">Golongan Darah</label>
        <select name="gol_darah" id="gol_darah">
                <option value="">Pilih golongan darah</option>
                <option value="A" <? if ($row['gol_darah'] == 'A') { echo "selected"; } ?> >A</option>
                <option value="B" <? if ($row['gol_darah'] == 'B') { echo "selected"; } ?> >B</option>
                <option value="AB" <? if ($row['gol_darah'] == 'AB') { echo "selected"; } ?> >AB</option>
                <option value="O" <? if ($row['gol_darah'] == 'O') { echo "selected"; } ?> >O</option>
        </select>
    </td><td valign="top">
        <label for="idPerkawinan">Status Perkawinan</label>
        <select name="idPerkawinan" id="idPerkawinan">
            <option value="">Pilih status</option>
            <option value="Lajang" <?php echo ($row['status_pernikahan']=='Lajang')? 'selected=':''?> >Lajang</option>
            <option value="Menikah" <?php echo ($row['status_pernikahan']=='Menikah')? 'selected=':''?>>Menikah</option>
            <option value="Janda" <?php echo ($row['status_pernikahan']=='Janda')? 'selected=':''?>>Janda</option>
        </select>
        <label for="pendidikan">Pendidikan Terakhir</label>
        <select name="pendidikan" id="pendidikan">
            <option value="">Pilih pendidikan</option>
            <?php foreach($pendidikan as $rows): ?>
			<option value="<?= $rows['id'] ?>" <?if($rows['id'] == $row['id_pendidikan_terakhir']) echo "selected";?>><?= $rows['nama'] ?></option>
            <?php endforeach; ?>
        </select>
        <label for="idPekerjaan">Profesi </label>
        <select name="idPekerjaan" id="idPekerjaan">
            <option value="">Pilih profesi</option>
            <? foreach($profesi as $rows): ?>
            <option value="<?= $rows['id'] ?>" <? if (isset($row['id_profesi']) && $rows['id'] == $row['id_profesi']) echo "selected"; ?> ><?= $rows['nama'] ?></option>
            <? endforeach; ?>
        </select>
		<label for="idPekerjaan">Pekerjaan</label>
		<select name="idPekerjaan2" id="idPekerjaan">
			<option value="">Pilih pekerjaan</option>
	<? foreach ($pekerjaan['list'] as $rows): ?>
				<option value="<?= $rows['id'] ?>" <? if (isset($row['id_pekerjaan']) && $rows['id'] == $row['id_pekerjaan']) echo "selected"; ?> ><?= $rows['nama'] ?></option>
	<? endforeach; ?>
			</select>
        
        <label for="idAgama">Agama</label>    
        <select name="idAgama" id="idAgama">
            <? foreach($agama['list'] as $rows): ?>
            <option value="<?= $rows['id'] ?>" <? if ($rows['id'] == $row['id_agama']) echo "selected"; ?> ><?= $rows['nama'] ?></option>
            <? endforeach; ?>
        </select>
        <label>No. Kunjungan</label><input type="text" name="no_kunjungan" id="no_kunjungan"  value="<?=$row['no_kunjungan']?>"/><span class='bintang'>*</span>
    <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="save" />&nbsp;                    
            <input type="button" value="Batal" class="tombol" onClick=javascript:location.href="<?= app_base_url('/admisi/opname-pasien/') ?>" />
     </fieldset>   
    
    </td></tr></table>
    
</form>

</fieldset>
</div>