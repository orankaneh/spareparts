<?php
$penduduk_edit = penduduk_muat_data($_GET['id'],NULL,NULL,NULL, NULL, NULL);

//$posisi = posisi_keluarga_muat_data();
$pendidikan = pendidikan_muat_data();
$profesi = profesi_muat_data();
$agama = agama_muat_data();
//$perkawinan = perkawinan_muat_data();
$pekerjaan=  pekerjaan_muat_data();
?>
<script type="text/javascript">
    function cekform(form) {
        if (form.nama.value == "") {
            alert("Nama penduduk tidak boleh kosong !");
            form.nama.focus();
            return false;
        }
        if(form.kelurahan.value == ""){
            alert("Nama kelurahan tidak boleh kosong");
            form.kelurahan.focus();
            return false;
        }
        if(form.almt.value == ""){
            alert("Nama alamat tidak boleh kosong");
            form.almt.focus();
            return false;
        }
        var umur = $('#umur-tahun').val();
		if(umur < 0){
            alert("Umur tidak boleh negatif");
            form.tglLahir.focus();
            return false;
        }
    }
$(function() {
        $('#nama').focus();
    
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
                $('#kelurahan').attr('value',data.nama_kel+" Kec: "+data.nama_kec);
                $('#idKelurahan').attr('value',data.id_kel);
            }
        );
});
</script>
<div class="data-input">
	
	<fieldset>
	<legend>Form Edit Penduduk</legend>
        <form action="<?= app_base_url('/admisi/control/penduduk/edit') ?>" method="post" name="form" onSubmit="return cekform(this)">
            <input type="hidden" name="idPenduduk" value="<?= $penduduk_edit['id'] ?>">
		<table width=100%><tr><td valign="top">
            
                <label for="no_identitas">No Identitas </label> <input name="no_identitas" id="no_identitas" type=text onkeyup="Angka(this)" value="<?= $penduduk_edit['no_identitas'] ?>">
                
                <label for="nama">Nama Lengkap </label> <input type=text name="nama" id="nama" value="<?= $penduduk_edit['nama']; ?>"><span class="bintang">*</span>
           		<label for="almt">Alamat Jalan </label> <input type="text" name="almt" id="almt" value="<?= $penduduk_edit['alamat_jalan'] ?>"><span class="bintang">*</span>
               	<label for="kelurahan">Kelurahan / Desa </label><input type="text" name="kelurahan" id="kelurahan" value="<?= $penduduk_edit['nama_kel'] ?>"><span class="bintang">*</span>
                <input type="hidden" name="idKelurahan" id="idKelurahan" value="<?= $penduduk_edit['id_kelurahan'] ?>">
                <fieldset class="field-group">
                    <legend>Jenis Kelamin </legend>&nbsp;
                    <label for="laki-laki" class="field-option">
                    	<input type="radio" name="jeKel" id="laki-laki" value="L" <?php if ($penduduk_edit['jenis_kelamin'] == 'L') echo"checked"; ?>> Laki-laki</label>
                    <label for="perempuan" class="field-option">
                    	<input type="radio" name="jeKel" id="perempuan" value="P" <?php if ($penduduk_edit['jenis_kelamin'] == 'P') echo"checked"; ?>> Perempuan</label>
                </fieldset>
                <fieldset class="field-group">
                  <label for="tglLahir">Tanggal Lahir</label>
                  <input type="text" name="tglLahir" id="tglLahir" class="tanggal" value="<?= datefmysql($penduduk_edit['tanggal_lahir']) ?>">
                  <label for="umur-tahun" class="inline-title">Umur</label>
                <input type="text" id="umur-tahun"  value="" class="umur2" onKeyup="Angka(this)" />
                <span>Thn</span>
                <input type="text" id="umur-bulan"  value="" class="umur2" onKeyup="Angka(this)" />
                <span>Bln</span>
                <input type="text" id="umur-hari" value="" class="umur2" onKeyup="Angka(this)" />
                <span>Hr</span>
                <script type="text/javascript">hitungUmur();</script>
                </fieldset>
                <label for="no_kk">Nomor Kartu Keluarga </label> <input type="text" name="no_kk" id="no_kk" onkeyup="Angka(this)" value="<?= $penduduk_edit['no_kartu_keluarga']!='NULL'?$penduduk_edit['no_kartu_keluarga']:'' ?>">
		<label for="posisi">Posisi di Keluarga </label> <select name="posisi" id="posisi">
        <?php
        if ($penduduk_edit['posisi'] == 'Ayah')
        {
            $dropdown = '<option value="">Pilih posisi</option>
                         <option value="Ayah" selected="selected">Ayah</option>
                         <option value="Ibu">Ibu</option>
                         <option value="Anak">Anak</option>';
        } else if ($penduduk_edit['posisi'] == 'Ibu')
        {
            $dropdown = '<option value="">Pilih posisi</option>
                         <option value="Ayah">Ayah</option>
                         <option value="Ibu" selected="selected">Ibu</option>
                         <option value="Anak">Anak</option>';
        } else if ($penduduk_edit['posisi'] == 'Anak')
        {
            $dropdown = '<option value="">Pilih posisi</option>
                         <option value="Ayah">Ayah</option>
                         <option value="Ibu">Ibu</option>
                         <option value="Anak" selected="selected">Anak</option>';
        } else
        {
            $dropdown = '<option value="" selected="selected">Pilih posisi</option>
                         <option value="Ayah">Ayah</option>
                         <option value="Ibu">Ibu</option>
                         <option value="Anak">Anak</option>';
        }
        echo $dropdown;
        ?>
                </select>    
                </td><td valign="top">
				<label for="sip">Nomor SIP </label> <input type="text" name="sip" id="sip" value="<?= $penduduk_edit['sip']!='NULL'?$penduduk_edit['sip']:'' ?>">
				<label for="no_telp">No. Telepon </label><input type="text" name="no_telp" id="no_telp" value="<?= $penduduk_edit['no_telp']!='NULL'?$penduduk_edit['no_telp']:'' ?>" onkeyup="Angka(this)" />
				<label for="idPdd">Pendidikan Terakhir </label>
                    <select name="idPendidikan" id="idPendidikan">
                    <option value="">Pilih pendidikan</option>       
                    <? foreach($pendidikan as $rows): ?>
                        <option value="<?= $rows['id'] ?>" <? if ($rows['id'] == $penduduk_edit['id_pendidikan_terakhir']) echo "selected"; ?>><?= $rows['nama'] ?></option> 
                    <? endforeach; ?>   
                </select>
				<label for="idPkj">Profesi</label>
                    <select name="idProfesi" id="idProfesi">
                        <option value="">Pilih profesi</option>
                        <? foreach($profesi as $rows): ?>
                        <option value="<?= $rows['id'] ?>" <? if ($rows['id'] == $penduduk_edit['id_profesi']) echo "selected"; ?>><?= $rows['nama'] ?></option> 
                        <? endforeach; ?>   
                    </select>
				<label for="idPekerjaan">Pekerjaan</label>
                                <select name="idPekerjaan" id="idPekerjaan">
                                    <option value="">Pilih pekerjaan</option>
                            <? foreach ($pekerjaan['list'] as $rows): ?>
                                        <option value="<?= $rows['id'] ?>" <? if ($rows['id'] == $penduduk_edit['id_pekerjaan']) echo "selected"; ?>><?= $rows['nama'] ?></option>
                            <? endforeach; ?>
                                    </select>
				<label for="idAgama">Agama </label>
                	<select name="idAgama" id="idAgama">
                        <? foreach($agama['list'] as $rows): ?>
                        <option value="<?= $rows['id'] ?>" <? if ($rows['id'] == $penduduk_edit['id_agama']) echo "selected"; ?>><?= $rows['nama'] ?></option> 
                        <? endforeach; ?>   
                        </select>
                <label for="idPerkawinan">Perkawinan </label>
                	<select name="idPerkawinan" id="idPerkawinan">
        <?php
        if ($penduduk_edit['status_pernikahan'] == 'Lajang')
        {
            $dropdown = '<option value="">Pilih posisi</option>
                         <option value="Lajang" selected="selected">Lajang</option>
                         <option value="Menikah">Menikah</option>
                         <option value="Janda">Janda</option>';
        } else if ($penduduk_edit['status_pernikahan'] == 'Menikah')
        {
            $dropdown = '<option value="">Pilih posisi</option>
                         <option value="Lajang">Lajang</option>
                         <option value="Menikah" selected="selected">Menikah</option>
                         <option value="Janda">Janda</option>';
        } else if ($penduduk_edit['status_pernikahan'] == 'Janda')
        {
            $dropdown = '<option value="">Pilih posisi</option>
                         <option value="Lajang">Lajang</option>
                         <option value="Menikah">Menikah</option>
                         <option value="Janda" selected="selected">Janda</option>';
        } else
        {
            $dropdown = '<option value="" selected="selected">Pilih posisi</option>
                         <option value="Lajang">Lajang</option>
                         <option value="Menikah">Menikah</option>
                         <option value="Janda">Janda</option>';
        }
        echo $dropdown;
        ?>             
                    </select>
                <fieldset class="input-process">
	            <input type="submit" value="Simpan" class="tombol" name="save" />&nbsp;                    
                    <input type="button" value="Batal" class="tombol" onClick=javascript:location.href="<?= app_base_url('/admisi/penduduk') ?>" />
                </fieldset>
			</td></tr></table>
		</form>
</fieldset>

<fieldset id="perhatian">
        <legend>Perhatian</legend>
         <ul>
            <li style="list-style-type:lower-roman">Jika tanggal lahir penduduk tidak diketahui dan hanya diketahui umurnya, maka isikan kolom "Umur" dan kosongi kolom "Tanggal Lahir", jika keduanya terisi maka yang akan tersimpan adalah kolom "Tanggal Lahir".
       </li>
    </fieldset>
</div>
