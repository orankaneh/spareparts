<?
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
$sql = mysql_query("select p.id as id_pas, pd.*, dp.id , dp.*,ag.nama as agama,dp.status_pernikahan as perkawinan,pdd.nama as pendidikan,prf.nama as profesi,pkj.nama as pekerjaan,pd.posisi_di_keluarga as posisi from penduduk pd
                    left join pasien p on (pd.id = p.id_penduduk)
                    left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
                    left join agama ag on (dp.id_agama=ag.id)
                    left join pendidikan pdd on dp.id_pendidikan_terakhir = pdd.id
                    left join pekerjaan pkj on dp.id_pekerjaan = pkj.id
                    left join profesi prf on dp.id_profesi = prf.id
                    where pd.id = '$_GET[id]' and dp.akhir = 1 group by p.id order by pd.id desc");
$row = mysql_fetch_array($sql);
$almt= mysql_query("select ku.id as id_kel, ku.nama as nama_kel, kc.nama as nama_kec, k.nama as nama_kab, p.nama as nama_pro from provinsi p, kabupaten k, kecamatan kc, kelurahan ku where p.id = k.id_provinsi and k.id = kc.id_kabupaten and kc.id = ku.id_kecamatan and ku.id = '$row[id_kelurahan]'");
$rowQ= mysql_fetch_array($almt);
//$perkawinan = perkawinan_muat_data();
$pendidikan = pendidikan_muat_data();
$agama = agama_muat_data();
$pekerjaan=  pekerjaan_muat_data();
$profesi=  profesi_muat_data();
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#body-1').hide();
	jQuery('#body-2').hide();
        $('#add_form').hide();
});
$(function() {
        $('#kelurahan, #idkelurahan').autocomplete("<?= app_base_url('/admisi/search?opsi=kelurahan') ?>",
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
                $(this).attr('value',data.nama_kel);
                $('#idKel').attr('value',data.id_kel);
                $('#idKelurahan').attr('value',data.id_kel);
            }
        );
});
</script>
<style type="text/css">
	legend {
		font-size:8px;
		font-weight:bold;
		text-transform:uppercase;
		background:#f1f1f1;
		border-top:1px dotted #333;
		border-left:1px dotted #333;
		border-right:1px dotted #333;
		padding:3px;
		background:#ddd;
	}
	fieldset {
		background:#f4f4f4;
	}
	.noborder {
		border:none;
		background:none;
	}
	input[type=button] {
		font-size:11px;
	}
</style>
<div class='judul'><a href='penduduk'>Master Data Penduduk</a>  &raquo; Detail penduduk</div>
<div class='data-input'>
<fieldset style="border:1px dotted #333;">
<legend>Detail Data Penduduk</legend>
<table>
  <tr>
    <td width="150px">- No. Identitas</td><td><?= $row['no_identitas']?></td>  
  </tr>    
  <tr>
    <td width="150px">- Nama Pasien</td><td><?= $row['nama']?></td>  
  </tr>    
  <tr>
    <td width="150px">- Jenis Kelamin</td><td><?= $row['jenis_kelamin']?></td>  
  </tr>    
  <tr>
    <td width="150px">- Tanggal Lahir</td>
    <td>
    <?= $row['tanggal_lahir']?>
    </td>  
  </tr>  
  <tr>
      <td width="150px">- Agama</td><td><?= $row['agama']?></td>
  </tr>
  <tr>
    <td width="150px">- No. Kartu Keluarga</td><td><?= $row['no_kartu_keluarga']!='NULL'?$row['no_kartu_keluarga']:" -"?></td>  
  </tr>  
  <tr>
      <td width="150px">- Status Perkawinan</td><td><?= $row['perkawinan']?></td> 
  </tr>
  <tr>
      <td>- Posisi di Keluarga</td>
      <td><?= $row['posisi']?></td>
  </tr>
    <tr>
        <td>- Pendidikan Terakhir</td>
        <td><?= $row['pendidikan']?></td>
    </tr>
    <tr>
        <td>- Profesi</td>
        <td><?= isset ($row['profesi'])?$row['profesi']:" -"?></td>
    </tr>
    <tr>
        <td>- Pekerjaan</td>
        <td><?= isset ($row['pekerjaan'])?$row['pekerjaan']:" -"?></td>
    </tr>
  <tr>
    <td width="150px">- SIP</td><td><?= $row['sip']!='NULL'?$row['sip']:" -"?></td>  
  </tr>    
  <tr>
    <td width="150px">- Alamat Jalan</td><td><?= $row['alamat_jalan']?></td>  
  </tr>    
  <tr>
    <td width="150px"></td><td><?= $rowQ['nama_kel']?>,<?= $rowQ['nama_kec']?>,<?= $rowQ['nama_kab']?>,<?= $rowQ['nama_pro']?></td>  
  </tr>    
  <tr>
    <td width="150px">- No. Telepon</td><td><?= $row['no_telp']!='NULL'?$row['no_telp']:" -"?></td>  
  </tr>    
  <tr>
    <td width="150px">- Golongan Darah</td><td><?= $row['gol_darah']?></td>
  </tr>  
</table>  
<input type="button" class="tombol" value="Edit" onClick=location.href="<?= app_base_url('admisi/penduduk?do=edit&id='.$_GET['id'].'') ?>" />
</fieldset>
</div>    

<div id='subjudul-7' style="cursor:pointer">
<div class='subjudul'>Rekap data dinamis penduduk</div>
</div>
<div id='body-1'>
<div class="data-list">
<a href="#" class="add"><div class="icon button-add"></div>tambah</a>
<?php
	$idPenduduk = $_GET['id'];
?>
<div class="data-input">
<fieldset id="add_form">
	<legend>Tambah Dinamis Penduduk </legend>
	<form action="<?= app_base_url('admisi/control/detail_pend') ?>" method="post" onSubmit="return cekdata(this)">
	<table width="100%" style="border:none;">
	<tr><td valign=top>
	<label for="kelurahan">Kelurahan</label><input type="text" name="kelurahan" id="kelurahan" /><input type="hidden" name="idKel" id="idKel" />
	<label for="alamat">Alamat</label><input type="text" name="alamat" id="alamat" />
	<label for="telp">No Telp</label><input type="text" name="telp" id="telp" maxlength="15"/>
        <label for="pernikahan">Statur Perkawinan</label>
		<select name="idPkw" id="idPkw" <?= $input ?>>
            <option value="">Pilih status</option>
            <?php foreach($perkawinan as $row): ?>
			<option value="<?= $row['id_perkawinan'] ?>"><?= $row['perkawinan'] ?></option>
            <?php endforeach; ?>
		</select>
	<label for="pendidikan">Pendidikan Terakhir</label>
        <select name="pendidikan" id="pendidikan" <?= $input ?>>
            <option value="">Pilih pendidikan</option>
            <?php foreach($pendidikan as $row): ?>
			<option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
            <?php endforeach; ?>
        </select>
	</td><td valign=top>
	<label for="agama">Agama</label>
        <select name="agama" id="agama" <?= $input ?>>
            <?php foreach($agama['list'] as $row): ?>
            <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
            <?php endforeach; ?>
        </select>
            <label for="idProfesi">Profesi</label>
            <select name="idProfesi" id="idProfesi">
                <option value="">Pilih profesi</option>
        <? foreach ($profesi as $rows): ?>
                    <option value="<?= $rows['id'] ?>"><?= $rows['nama'] ?></option>
        <? endforeach; ?>
                </select>
            <label for="idPekerjaan">Pekerjaan</label>
            <select name="idPekerjaan" id="idPekerjaan">
                <option value="">Pilih pekerjaan</option>
        <? foreach ($pekerjaan['list'] as $rows): ?>
                    <option value="<?= $rows['id'] ?>"><?= $rows['nama'] ?></option>
        <? endforeach; ?>
                </select>
	<input type="hidden" name="id_penduduk" value="<?= $idPenduduk ?>" />
	<fieldset class="input-process">
	<input type="submit" value="Simpan" class="tombol" name="add" /> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('/admisi/detail-pend')."?id=".$_GET['id']."" ?>'"/>
	</fieldset>
	</td></tr>
	</table>
	</form>
</fieldset>
</div>    
    
<table cellpadding='0' cellspacing='0' border='0' id='tabel' class='tabel'>
			<tr>
			<th><h3>No</h3></th>
			<th><h3>Tanggal</h3></th>
			<th><h3>Agama</h3></th>
			<th><h3>Alamat Jalan</h3></th>
			<th><h3>No. Telp</h3></th>
			<th><h3>Kelurahan</h3></th>
			<th><h3>Kecamatan</h3></th>
			<th><h3>Kabupaten/Kota</h3></th>
                        <th><h3>Provinsi</h3></th>
			<th><h3>Pendidikan Terakhir</h3></th>
			<th><h3>Profesi</h3></th>
			<th><h3>Aksi</h3></th>
			</tr>
		<tbody>
                <?    
		$sql = mysql_query("select dp.*,dp.tanggal as tanggal, pd.nama as pendidikan, pr.nama as profesi, a.nama as agama from dinamis_penduduk dp
		left join agama a on (a.id = dp.id_agama) 
		left join pendidikan pd on (pd.id = dp.id_pendidikan_terakhir)
		left join profesi pr on (pr.id = dp.id_profesi)
		where dp.id_penduduk = $_GET[id] order by dp.id");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
                        $telp = $row['no_telp']=="NULL"?"":$row['no_telp'];
			$almt= mysql_query("select ku.id as id_kel, ku.nama as nama_kel, kc.nama as nama_kec, k.nama as nama_kab, p.nama as nama_pro from provinsi p, 
			kabupaten k, kecamatan kc, kelurahan ku where p.id = k.id_provinsi and k.id = kc.id_kabupaten and kc.id = ku.id_kecamatan and 
			ku.id = '$row[id_kelurahan]'");
			
			$rowQ= mysql_fetch_array($almt);
			?>
			<tr>
				<td align='center'><?= $no?></td>
                                <td align='center'><?= datefmysql($row['tanggal'])?></td>
                                <td class="no-wrap"><?= $row['agama'] ?></td>
				<td class="no-wrap"><?= $row['alamat_jalan']?></td>
                                <td><?= $telp ?></td>
				<td class="no-wrap"><?= $rowQ['nama_kel']?></td>
				<td class="no-wrap"><?= $rowQ['nama_kec']?></td>
				<td class="no-wrap"><?= $rowQ['nama_kab']?></td>
				<td class="no-wrap"><?= $rowQ['nama_pro']?></td>
                                <td><?= $row['pendidikan']?></td>
				<td class="no-wrap"><?= $row['profesi'] ?></td>
                                <td class="aksi">
					<a href="<?= app_base_url('admisi/detail-pend?do=edit&id='.$_GET['id'].'') ?>" class="edit"><small>edit</small></a>
					<?php 
					if ($row['akhir'] == 0) { ?>
						<a href="<?= app_base_url('admisi/control/detail_pend?do=delete&id='.$_GET['id'].'') ?>" class="delete"><small>delete</small></a>
				<?php } ?>
				</td>
			</tr>
                <?        
		$no += 1;
		}?>
            
		</tbody>
  </table>
</div>
</div>
<?php
if (isset($_GET['do'])) {
$sql = mysql_query("select k.nama as kelurahan, dp.*, pd.nama as pendidikan,pr.id as id_profesi,pkj.id as id_pekerjaan, pr.nama as profesi, a.nama as agama from dinamis_penduduk dp
		left join agama a on (a.id = dp.id_agama) 
		left join pendidikan pd on (pd.id = dp.id_pendidikan_terakhir)
		left join profesi pr on (pr.id = dp.id_profesi)
                left join pekerjaan pkj on dp.id_pekerjaan = pkj.id
		left join kelurahan k on (k.id = dp.id_kelurahan)
		where dp.id_penduduk = '$_GET[id]' and akhir=1");
$row = mysql_fetch_array($sql);
$telp = $row['no_telp']=="NULL"?"":$row['no_telp'];
?>
<div class="data-input">
<fieldset id="add_form">
	<legend>Edit Dinamis Penduduk </legend>
	<form action="<?= app_base_url('admisi/control/detail_pend') ?>" method="post" onSubmit="return cekdata(this)">
	<table width="100%" style="border:none;">
	<tr><td valign=top>
	<label for="kelurahan">Kelurahan</label><input type="text" name="kelurahan" id="idkelurahan" value="<?= $row['kelurahan'] ?>" /><input type="hidden" name="idKel" id="idKelurahan" value="<?= $row['id_kelurahan'] ?>" />
	<label for="alamat">Alamat</label><input type="text" name="alamat" id="alamat" value="<?= $row['alamat_jalan'] ?>" />
	<label for="telp">No Telp</label><input type="text" name="telp" id="telp" value="<?= $telp ?>" maxlength="15"/>
	<label for="pernikahan">Status Perkawinan</label>
		<select name="idPkw" id="idPkw" <?= $input ?>>
            <option value="">Pilih status</option>
            <?php foreach($perkawinan as $rows): ?>
			<option value="<?= $rows['id_perkawinan'] ?>" <?php if ($rows['id_perkawinan'] == $row['status_pernikahan']) echo "selected"; ?>><?= $rows['perkawinan'] ?></option>
            <?php endforeach; ?>
		</select>
	<label for="pendidikan">Pendidikan Terakhir</label>
        <select name="pendidikan" id="pendidikan" <?= $input ?>>
            <option value="">Pilih pendidikan</option>
            <?php foreach($pendidikan as $rows): ?>
			<option value="<?= $rows['id'] ?>" <?php if ($rows['id'] == $row['id_pendidikan_terakhir']) echo "selected"; ?>><?= $rows['nama'] ?></option>
            <?php endforeach; ?>
        </select>
        </td><td valign=top>
	<label for="agama">Agama</label>
        <select name="agama" id="agama" <?= $input ?>>
            <?php foreach($agama['list'] as $rows): ?>
            <option value="<?= $rows['id'] ?>"<?php if ($rows['id'] == $row['id_agama']) echo "selected"; ?>><?= $rows['nama'] ?></option>
            <?php endforeach; ?>
        </select>
        <label for="idProfesi">Profesi</label>
            <select name="idProfesi" id="idProfesi">
                <option value="">Pilih profesi</option>
        <? foreach ($profesi as $rows): ?>
                    <option value="<?= $rows['id'] ?>" <?php if ($rows['id'] == $row['id_profesi']) echo "selected"; ?>><?= $rows['nama'] ?></option>
        <? endforeach; ?>
                </select>
        <label for="namaPkj">Pekerjaan</label>
        <select name="pekerjaan" id="pekerjaan" <?= $input ?>>
            <option value="">Pilih pekerjaan</option>
            <?php foreach($pekerjaan['list'] as $rows): ?>
		<option value="<?= $rows['id'] ?>" <?php if ($rows['id'] == $row['id_pekerjaan']) echo "selected"; ?>><?= $rows['nama'] ?></option>
            <?php endforeach; ?>
        </select>
	<input type="hidden" name="id_penduduk" value="<?= $_GET['id'] ?>" />
	<fieldset class="input-process">
	<input type="submit" value="Simpan" class="tombol" name="edit" /> 
	<input type="button" value="Batal" class="tombol" onClick=location.href="<?= app_base_url('admisi/detail-pend?id='.$_GET['id'].'') ?>" />
	</fieldset>
	</td></tr>
	</table>
	</form>
</fieldset>
</div>
<?php
}
?>
<script type='text/javascript'>
    $('.add').click(function () {
	$('#add_form').slideToggle('fast');
    });    
    jQuery('#subjudul-7').click(function () {
            jQuery('#body-1').slideToggle('fast');
    });
    jQuery('#subjudul-8').click(function () {
            jQuery('#body-2').slideToggle('fast');
    });
</script>