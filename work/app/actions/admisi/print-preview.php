<?php
require_once 'app/lib/common/functions.php';
$konek = mysql_connect('localhost', 'root', ''); 
$db = mysql_select_db('db_rumahsakit');
$id_pasien = $_GET['idp'];
$id_pjw = $_GET['idPjw'];
$instalasi = $_GET['tujuan'];
$tanggal = date("d-m-Y");

$query = mysql_query("select ps.id as id_pasien, p.id, p.nama as nama_pas,ag.nama as nama_agama, p.jenis_kelamin, p.tanggal_lahir, p.gol_darah, dp.*, kl.nama as nama_kel, pr.id as id_pro, pr.nama as nama_pro, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, dp.id_agama from penduduk p
	left join pasien ps on (p.id = ps.id_penduduk) 
	left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
	left join kelurahan kl on(dp.id_kelurahan = kl.id)
	left join profesi pr on(pr.id = dp.id_profesi)
        left join agama ag on(ag.id = dp.id_agama)    
	where ps.id = '$id_pasien'");
$row = mysql_fetch_array($query);

$query2 = mysql_query("select p.nama as nm_penduduk,dp.alamat_jalan,dp.no_telp,kl.nama as nm_kel from penduduk p
                      left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
                      left join kelurahan kl on(dp.id_kelurahan = kl.id)
                      where p.id = '$id_pjw'
                      ");
$row2 = mysql_fetch_array($query2);
$query3 = mysql_query("select * from instalasi where id = $instalasi");
$row3 = mysql_fetch_array($query3);

echo "
<html>
<head>
  <title></title>
  <link rel='stylesheet' type='text/css' href='".app_base_url('/assets/css/style2.css')."'>  
</head>
<body onLoad='window.print()' onFocus='window.close()'>
<br/><center>RSU PKU MUHAMMADIYAH TEMANGGUNG</center>";
echo "<table class=head-laporan><tr><td rowspan=2 align=center width=200px id=sekat>LEMBAR ".strtoupper($row3[nama])."</td>
        <td width=200px> &nbsp;&nbsp;&nbsp;&nbsp;No. RM : $row[id_pasien]</td></tr>
        <tr><td width=200px>&nbsp;&nbsp;&nbsp;&nbsp;Tanggal : $tanggal</td></tr>";
echo "</table>";
echo "
    <table class=contain>
        <tr>
		  <td width=150px>Nama Pasien</td>
		  <td>:</td>
		  <td>$row[nama_pas]</td>
		</tr>
        <tr>
		  <td width=150px>Umur/Tgl. Lahir</td>
		  <td>:</td>
		  <td>".createUmur($row[tanggal_lahir])."</td>
		</tr>
        <tr>
		  <td width=150px>Agama</td>
		  <td>:</td>
		  <td>$row[nama_agama]</td>
		</tr>
        <tr>
		  <td width=150px>Pekerjaan</td>
		  <td>:</td>
		  <td>$row[nama_pro]</td>
		</tr>
		<tr>
		  <td width=150px>Alamat Pasien</td>
		  <td>:</td>
		  <td>$row[alamat_jalan] $row[nama_kel]</td>
		</tr>
		<tr>
		  <td width=150px>Nomor Telepon</td>
		  <td>:</td>
		  <td>$row[no_telp]</td>
		</tr>
		<tr>
		  <td width=150px colspan='3'>Dalam keadaan penting harap hubungi,</td>
		</tr>
		<tr>
		  <td width=150px colspan='2' align='right'>Nama :</td>
		  <td>$row2[nm_penduduk]</td>
		</tr>
		<tr>
		  <td width=150px colspan='2' align='right'>Alamat :</td>
		  <td>$row2[alamat_jalan] $row2[nm_kel]</td>
		</tr>
		<tr>
		  <td width=150px colspan='2' align='right'>Nomor Telepon :</td>
		  <td>$row2[no_telp]</td>
		</tr>
		<tr>
		  <td colspan='3' align='right'>&nbsp</td>
		</tr>
	</table>
";
echo "
    <table class='contain2'>
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
		  <td>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jam </br>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jam </br>
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
</body>
</html>
";
exit;
?>
