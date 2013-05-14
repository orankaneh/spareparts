<?php
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';

set_time_zone();
$idKunjungan=(isset($_GET['idKunjungan']))?$_GET['idKunjungan']:null;
$tanggal = date("d-m-Y");

$sql="
select
ps.id as idPasien,ps.id_penduduk,p.tanggal_lahir as tanggal_lahir, pr.nama as profesiPasien, agm.nama as agamaPasien, dp.no_telp as telpPasien,
k.id,p.nama as namaPasien,dp.alamat_jalan as alamatPasien, kel.nama as kelurahanPasien,
pPj.nama as namaPj,dpPj.alamat_jalan as alamatPj, kelPj.nama as kelurahanPj,dpPj.no_telp as telpPj,
rj.no_surat_rujukan as noRujukan, ir.nama as namaRujukan,tj.nama as instalasi_tujuan
from kunjungan k
left join penduduk pd2 on (k.id_penduduk_dpjp=pd2.id)
left join bed b on (k.id_bed=b.id)
left join instalasi tj on (b.id_instalasi=tj.id)
left join kelas kls on (b.id_kelas=kls.id)
left join pasien ps on (ps.id=k.id_pasien)
left join penduduk p on (p.id=ps.id_penduduk)
left join dinamis_penduduk dp on (dp.id_penduduk=p.id)
left join profesi pr on (pr.id=dp.id_profesi)
left join agama agm on(agm.id=dp.id_agama)
left join kelurahan kel on (kel.id=dp.id_kelurahan)

left join penduduk pPj on (pPj.id=k.id_penduduk_penanggungjawab)
left join dinamis_penduduk dpPj on (dpPj.id_penduduk=pPj.id)
left join kelurahan kelPj on (kelPj.id=dpPj.id_kelurahan)

left join rujukan rj on (rj.id=k.id_rujukan)
left join instansi_relasi ir on (ir.id=rj.id_instansi_relasi)
where k.id='$idKunjungan'
";

$query=mysql_query($sql);
$row=mysql_fetch_array($query);

echo "
<html>
<head>
  <title>Preview</title>
  <link rel='stylesheet' type='text/css' href='".app_base_url('/assets/css/base.css')."'>
</head>
<body>";
require_once 'app/actions/admisi/lembar-header.php';

echo "<table class=head-laporan><tr><td rowspan=2 align=center width=200px id=sekat>LEMBAR $row[instalasi_tujuan]</td>
        <td width=200px> &nbsp;&nbsp;&nbsp;&nbsp;No. RM : $row[idPasien]</td></tr>
        <tr><td width=200px>&nbsp;&nbsp;&nbsp;&nbsp;Tanggal : $tanggal</td></tr>";
echo "</table>";
echo "
    <table class=contain>
        <tr>
		  <td width=150px>Nama Pasien</td>
		  <td>:</td>
		  <td>$row[namaPasien]</td>
		</tr>
        <tr>
		  <td width=150px>Umur/Tgl. Lahir</td>
		  <td>:</td>
		  <td>";
                 if(createUmur($row['tanggal_lahir']) < 1){
                   echo "  thn / ".$row['tanggal_lahir']."</td>";} 
                 else {    
                   echo "".createUmur($row['tanggal_lahir'])." thn / ".datefmysql($row['tanggal_lahir'])."</td>";}
echo "
	</tr>
        <tr>
		  <td width=150px>Agama</td>
		  <td>:</td>
		  <td>$row[agamaPasien]</td>
		</tr>
        <tr>
		  <td width=150px>Pekerjaan</td>
		  <td>:</td>
		  <td>$row[profesiPasien]</td>
		</tr>
		<tr>
		  <td width=150px>Alamat Pasien</td>
		  <td>:</td>
		  <td>$row[alamatPasien] $row[kelurahanPasien]</td>
		</tr>
		<tr>
		  <td width=150px>Nomor Telepon</td>
		  <td>:</td>
		  <td>$row[telpPasien]</td>
		</tr>
		<tr>
		  <td width=150px colspan='3'>Dalam keadaan penting harap hubungi,</td>
		</tr>
		<tr>
		  <td width=150px colspan='2' align='right'>Nama :</td>
		  <td>$row[namaPj]</td>
		</tr>
		<tr>
		  <td width=150px colspan='2' align='right'>Alamat :</td>
		  <td>$row[alamatPj] $row[kelurahanPj]</td>
		</tr>
		<tr>
		  <td width=150px colspan='2' align='right'>Nomor Telepon :</td>
		  <td>$row[telpPj]</td>
		</tr>
		<tr>
		  <td colspan='3' align='right'>&nbsp</td>
		</tr>
	</table>
";
echo "
    <table class='contain2' border=0 cellpadding=0 cellspacing=0>
	  <tr>
	    <td width='150px' colspan='2'>
		  Dirawat di Kelas
		</td>
		<td>.................................</td>
	  </tr>
	  <tr>
	    <td width='150px' colspan='2'>
		  Pindah ruang
		</td>
		<td>.................................</td>
	  </tr>
	  <tr>
	    <td width='150px' colspan='2'>
		  Tanggal
		</td>
		<td>.................................</td>
	  </tr>
	  <tr>
	    <td width='150px' colspan='2'>
		  Bagian Penyakit
		</td>
		<td>.................................</td>
	  </tr>
	  <tr>
		  <td width=150px colspan='2'>Dirawat oleh</td>
		  <td>
		    1. </br>
			2. </br>
			3. </br>
		  </td>
	  </tr>
	  <tr>
		  <td width=150px colspan='2'>Diagnosis</td>
		  <td>
		    1. </br>
			2. </br>
			3. </br>
		  </td>
	  </tr>
	  <tr>
	    <td width='150px' colspan='2'>
		  ICD-X
		</td>
		<td>.................................</td>
	  </tr>
	  <tr>
		  <td width=150px colspan='2'>Nama dan tanggal operasi</td>
		  <td align = center>
		    Jam </br>
		    Jam </br>
		  </td>
	  </tr>
	  <tr>
	    <td width='150px' colspan='2'>
		  Masuk tanggal
		</td>
		<td>.................................</td>
	  </tr>
	  <tr>
	    <td width='150px' colspan='2'>
		  Keluar tanggal
		</td>
		<td>.................................</td>
	  </tr>
	  <tr>
	    <td width='150px' valign='top'>
		  Keadaan keluar
		</td>
		<td colspan='2'>
		  <input type='checkbox'> Sembuh </br>
		  <input type='checkbox'> Belum sembuh </br>
          <input type='checkbox'> Dirujuk </br>
		  <input type='checkbox'> Pulang paksa </br>
		  <input type='checkbox'> Lari </br>
		  <input type='checkbox'> Meninggal </br>
		</td>
	  </tr>
	  <tr>
	    <td width='150px' valign='top'>
		  Biaya ditanggung
		</td>
		<td colspan='2'>
		  <input type='checkbox'> Sendiri </br>
		  <input type='checkbox'> Instansi </br>
          <input type='checkbox'> Asuransi </br>
		  <input type='checkbox'> DSM </br>
		</td>
	  </tr>
	</table>
        <center>
          <p><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'></span></p>
        </center>
</body>
</html>";?>

<script language='JavaScript'>
  	function cetak() {  		
  		SCETAK.innerHTML = '';
		window.print();
		if (confirm('Apakah menu print ini akan ditutup?')) {
			window.close();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
  	}
  
</script>
<?
exit;
?>