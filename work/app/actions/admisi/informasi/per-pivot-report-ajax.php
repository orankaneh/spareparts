<?php
include_once "include_once.php";

$isi.="
<script type='text/javascript'>
    jQuery(document).ready(function() {
        jQuery('#divPeriodeBln').hide(100);
        jQuery('#divPeriodeTgl').hide(100);
        jQuery('#divPeriodeThn').hide(100);
        jQuery('#divPeriodeMinggu').hide(100);
		jQuery('#range').hide(100);
		jQuery('#ranger').hide(100);
    } );

    function opsi(value) {
        if(value=='Harian'){
            jQuery('#divPeriodeTgl').show(100);
            jQuery('#divPeriodeBln').hide(100);
            jQuery('#divPeriodeThn').hide(100);
            jQuery('#divPeriodeMinggu').hide(100);
			jQuery('#range').show(100);
			jQuery('#ranger').show(100);
        }else if(value=='Mingguan'){
            jQuery('#divPeriodeBln').hide(100);
            jQuery('#divPeriodeTgl').hide(100);
            jQuery('#divPeriodeThn').hide(100);
            jQuery('#divPeriodeMinggu').show(100);
			jQuery('#range').show(100);
			jQuery('#ranger').show(100);
        }else if(value=='Bulanan'){
            jQuery('#divPeriodeTgl').hide(100);
            jQuery('#divPeriodeBln').show(100);
            jQuery('#divPeriodeThn').hide(100);
            jQuery('#divPeriodeMinggu').hide(100);
			jQuery('#range').show(100);
			jQuery('#ranger').show(100);
        }else if(value=='Tahunan'){
            jQuery('#divPeriodeBln').hide(100);
            jQuery('#divPeriodeTgl').hide(100);
            jQuery('#divPeriodeThn').show(100);
            jQuery('#divPeriodeMinggu').hide(100);
			jQuery('#range').show(100);
			jQuery('#ranger').show(100);
        }
		else {
			jQuery('#divPeriodeBln').hide(100);
            jQuery('#divPeriodeTgl').hide(100);
            jQuery('#divPeriodeThn').hide(100);
            jQuery('#divPeriodeMinggu').hide(100);
			jQuery('#range').hide(100);
			jQuery('#ranger').hide(100);
		}

    }
</script>


    <form id='myForm' method='get' action='$PHP_SELF'>
        <fieldset class='dasar-laporan'><legend>Laporan Total Pendapatan per Periode</legend>
		<div class='baris'>
		<div class='selL'>Periode</div>
		<div class='selR'>
			<select name='period' onchange='opsi(this.value)'>
				<option value=''>Pilih periode</option>
				<option value='Harian'>Harian</option>
				<option value='Mingguan'>Mingguan</option>
				<option value='Bulanan'>Bulanan</option>
				<option value='Tahunan'>Tahunan</option>
			</select>
		</div>
		</div>
		<div class='baris' id='range'>
		<div class='selL'>Awal-Akhir Periode</div>
		<div class='selR'>
			<div id='divPeriodeTgl'>
				<input type='text' id='awal' style='width: 105px' name='tgl1' value=''  class='formKcl' id='awal' >
				&nbsp;s / d &nbsp;
				<input type='text' id='akhir' style='width: 105px' name='tgl2' value=''  class='formKcl' id='akhir' >
			</div>
			<div id='divPeriodeMinggu'>
				<input type='text' id='awal' style='width: 105px' name='tgl3' value=''  class='formKcl' id='awal' >
				&nbsp;s / d &nbsp;
				<input type='text' id='akhir' style='width: 105px' name='tgl4' value=''  class='formKcl' id='akhir' >
			</div>
			<div id='divPeriodeBln'>
				<select id='bln1' name='bln1' style='width: 90px'>
					<option value=''>Pilih bulan</option>
					<option value='01'>Januari</option><option value='02'>Febuari</option>
					<option value='03'>Maret</option><option value='04'>April</option>
					<option value='05'>Mei</option><option value='06'>Juni</option>
					<option value='07'>Juli</option><option value='08'>Agustus</option>
					<option value='09'>September</option><option value='10'>Oktober</option>
					<option value='11'>November</option><option value='12'>Desember</option>
				</select>
				&nbsp;&nbsp;<label>Thn &nbsp;&nbsp;</label>
				<select id='thn1' name='thn1' class=form style='width: 90px; margin-bottom:2px;'>
					<option value=''>Pilih tahun</option>";
					for ($i = 2008; $i <= date('Y'); $i++) {
					$isi.="<option value='$i'>$i</option>";
					}
					$isi.="
				</select>
				s / d <br>
				<select name='bln2' id='bln2' style='width: 90px'><option value=''>Pilih bulan</option>
					<option value='01'>Januari</option><option value='02'>Febuari</option>
					<option value='03'>Maret</option><option value='04'>April</option>
					<option value='05'>Mei</option><option value='06'>Juni</option>
					<option value='07'>Juli</option><option value='08'>Agustus</option>
					<option value='09'>September</option><option value='10'>Oktober</option>
					<option value='11'>November</option><option value='12'>Desember</option>
				</select>
				&nbsp;&nbsp;<label>Thn &nbsp;&nbsp;</label>
				<select id='thn2' name='thn2' class=form style='width: 90px'>
					<option value=''>Pilih tahun</option>";

					for ($i = 2008; $i <= date('Y'); $i++) {
					$isi.="<option value='$i'>$i</option>";
					}
					$isi.="
				</select>
			</div>
			<div id='divPeriodeThn'>
				<select id='thn3' name='thn3' style='width: 112px; margin-bottom:2px;'>
					<option value=''>Pilih tahun</option>";
					for ($i = 2008; $i <= date('Y'); $i++) {
					$isi .="<option value='$i'>$i</option>";
					}
					$isi .= "
				</select>
				 s . d 
				<select id='thn4' name='thn4' style='width:112px; margin-bottom:2px;'>
					<option value=''>Pilih tahun</option>";

					for ($i = 2008; $i <= date("Y"); $i++) {
					$isi.="<option value='$i'>$i</option>";
					}
					$isi.="
				</select>
			</div>
		</div>
		</div>
		
		<div class='baris' id='ranger'>
			<div class='selL'>Laporan didasarkan</div>
			<div class='selR'><select name='idLap' onChange=submit(form)>
			<option value=''"; if ($_GET['idLap'] == '') $isi.="selected"; $isi.=">Pilih komponen</option>
			<option value='5'"; if ($_GET['idLap'] == 5) $isi.="selected"; $isi.=">Jenis Kelamin</option>
			<option value='6'"; if ($_GET['idLap'] == 6) $isi.="selected"; $isi.=">Status Perkawinan</option>
			<option value='7'"; if ($_GET['idLap'] == 7) $isi.="selected"; $isi.=">Pendidikan</option>
			<option value='8'"; if ($_GET['idLap'] == 8) $isi.="selected"; $isi.=">Pekerjaan</option>
			<option value='9'"; if ($_GET['idLap'] == 9) $isi.="selected"; $isi.=">Agama</option>
			<option value='11'"; if ($_GET['idLap'] == 11) $isi.="selected"; $isi.=">Alamat: Desa / Kelurahan</option>
			<option value='12'"; if ($_GET['idLap'] == 12) $isi.="selected"; $isi.=">Alamat: Kecamatan</option>
			<option value='13'"; if ($_GET['idLap'] == 13) $isi.="selected"; $isi.=">Alamat: Kabupaten</option>
			<option value='14'"; if ($_GET['idLap'] == 14) $isi.="selected"; $isi.=">Alamat: Propinsi</option>
			<option value='16'"; if ($_GET['idLap'] == 16) $isi.="selected"; $isi.=">Tujuan Kunjungan</option>
			<option value='17'"; if ($_GET['idLap'] == 17) $isi.="selected"; $isi.=">Cara Pembiayaan</option>
			<option value='21'"; if ($_GET['idLap'] == 21) $isi.="selected"; $isi.=">NIK (pasien)</option>
			<option value='22'"; if ($_GET['idLap'] == 22) $isi.="selected"; $isi.=">NIK (operator)</option>
			</select></div>
		</div>
		
		<div class='baris'>
            <div class='selL'>&nbsp;</div>
            <div class='selR'><input type='submit' value='submit' class=tombol /> <input type='button' value='Batal' class=tombol onClick=javascript:location.href='$PHP_SELF?awal=$_GET[awal]&akhir=$_GET[akhir]' /></div>
        </div>
        </fieldset>

</form>";
$isi.="</div>";
$isi.="<div id='loading' style='display:none;'><img src='loading.gif' alt='loading...' /></div>
<div id='result' style='display:none;'></div>";
include_once "instansiasi.php";
?>