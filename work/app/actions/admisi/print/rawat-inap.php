<style>
body {margin: 0 70px; font-family: "Consolas","Fixedsys",arial !important;}
td { font-size: 12px !important}
.tabel-judul {border-top: 1px dotted #666; border-bottom: 1px dotted #666; width: 700px; margin: 20px 0}
.head-cetak-instansi {font-size: 22px; font-family: "Arial Narrow",tahoma; font-weight: 800}
</style>

<?php
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
$tanggal = date("d-m-Y");
$jam = date("H:i");
$query = mysql_query("select ps.id as id_pasien, p.id, p.nama as nama_pas,ag.nama as nama_agama, p.jenis_kelamin, p.tanggal_lahir, p.gol_darah, dp.*, kl.nama as nama_kel, kc.nama as nama_kec, kb.nama as nama_kab, pr.id as id_pro, pr.nama as nama_pro, pj.nama as nama_pekerjaan, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, kls.nama as class, dp.id_agama, k.*,ins.id as id_instalasi_tujuan,ins.nama as instalasi from penduduk p
	left join pasien ps on (p.id = ps.id_penduduk) 
	left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
	left join kelurahan kl on(dp.id_kelurahan = kl.id)
	left join kecamatan kc on(kl.id_kecamatan = kc.id)
	left join kabupaten kb on(kc.id_kabupaten = kb.id)
	left join profesi pr on(pr.id = dp.id_profesi)
	left join pekerjaan pj on (pj.id = dp.id_pekerjaan)
	left join kunjungan k on (k.id_pasien = ps.id)
        left join agama ag on(ag.id = dp.id_agama)  
        left join bed bd on k.id_bed = bd.id
        left join instalasi ins on bd.id_instalasi = ins.id
		 left join kelas kls on (bd.id_kelas = kls.id)
	where k.id = '$_GET[idKunjungan]'");
$row = mysql_fetch_array($query);
$penanggung_jawab = isset($row['id_penduduk_penanggungjawab'])?$row['id_penduduk_penanggungjawab']:NULL;
$dokter = isset($row['id_penduduk_dpjp'])?$row['id_penduduk_dpjp']:NULL;
$tgl_lahir = isset($row['tanggal_lahir'])?$row['tanggal_lahir']:NULL;
$query4 = mysql_query("select p.nama as nm_dokter from penduduk p
                      left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
                      where p.id = '$dokter'");
$row4 = mysql_fetch_array($query4);
$query3 = mysql_query("select * from instalasi where id = '$row[id_instalasi_tujuan]'");
$row3 = mysql_fetch_array($query3);
$instalasi = isset($row3['nama'])?$row3['nama']:NULL;
$query2 = mysql_query("select p.nama as nm_penduduk,dp.alamat_jalan,dp.no_telp,kl.nama as nm_kel from penduduk p
                      left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
                      left join kelurahan kl on(dp.id_kelurahan = kl.id)
                      where p.id = '$penanggung_jawab'");
$row2 = mysql_fetch_array($query2);
$telp = $row['no_telp'];
if (($telp =="") OR ($telp =="NULL")){
$telp='';
}
else{
$telp=$row['no_telp'];
		}
		
 
		?>
<html>
<head>
  <title></title>
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
		
  <link rel='stylesheet' type='text/css' href="<?=app_base_url('/assets/css/base.css');?>">  
</head>
<body>
<div style="width: 700px"><?php require_once 'app/actions/admisi/lembar-header.php'; ?>

<table class="tabel-judul"><tr><td rowspan=2 align=center width=200px>LEMBAR RAWAT INAP</td>
        <td width=200px> No. RM : <?=$row['id_pasien']?></td></tr>
        <tr><td width=200px>Tanggal : <?=$tanggal?><br>Waktu Kunjungan : <?=$jam;?></td></tr>
</table>

    <table cellpadding="4">
        <tr>
		  <td width=250px>Nama Pasien</td>
		  <td>:</td>
		  <td><?=$row['nama_pas'];?></td>
		</tr>
        <tr>
		  <td width=250px>Umur/Tgl. Lahir</td>
		  <td>:</td>
		  <td>  <? echo "".hitungUmur2($row['tanggal_lahir'])." thn / ".datefmysql($row['tanggal_lahir'])."</td>";?></td>
		</tr>
        <tr>
		  <td width=250px>Agama</td>
		  <td>:</td>
		  <td><?=$row['nama_agama']?></td>
		</tr>
        <tr>
		  <td width=250px>Pekerjaan</td>
		  <td>:</td>
		  <td><?=$row['nama_pekerjaan']?></td>
		</tr>
		<tr>
		  <td width=250px>Alamat Pasien</td>
		  <td>:</td>
		  <td><?=$row['alamat_jalan']." ".$row['nama_kel'].', '.$row['nama_kec'].', '.$row['nama_kab'] ?></td>
		</tr>
		<tr>
		  <td width=250px>Nomor Telepon</td>
		  <td>:</td>
		  <td><?=$telp;?></td>
		</tr>
		
		<tr>
		  <td width=250px colspan='3'>Dalam keadaan penting harap hubungi,</td>
		</tr>
		<tr>
		  <td width=250px colspan='2' align='right'>Nama :</td>
		  <td><?=$row2['nm_penduduk']?></td>
		</tr>
		<tr>
		  <td width=250px colspan='2' align='right'>Alamat :</td>
		  <td><?=$row2['alamat_jalan']." ".$row2['nm_kel']?></td>
		</tr>
		<tr>
		  <td width=250px colspan='2' align='right'>Nomor Telepon :</td>
		  <td><?=$row2['no_telp']?></td>
		</tr>
		<tr>
		  <td colspan='3' align='right'>&nbsp</td>
		</tr>
	</table>

    <table width=700 cellpadding="4" style="border-top: 1px dotted #666">
	  <tr>
		<td colspan=3 height=20px>&nbsp</td>
	  </tr>
	  <tr>
	    <td width='150px' colspan='2'>
		  Dirawat di Kelas
		</td>
		<td><?php echo $row['class'].' '.$row['instalasi']; ?></td>
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
		    1. <?php echo $row4['nm_dokter'];?><br /><br />
			2. <br /></br>
			3. <br />
		  </td>
	  </tr>
	  <tr>
		  <td width=150px colspan='2'>Diagnosis</td>
		  <td>
		    1. <br /><br />
			2. <br /><br />
			3. <br />
		  </td>
	  </tr>
	  <tr>
	    <td width='150px' colspan='2'>
		  ICD-X
		</td>
		<td>.................................</td>
	  </tr>
	  <tr>
		  <td width=150px colspan='2' vAlign=top>Nama dan tanggal operasi</td>
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
		  <input type='checkbox'>  Sembuh </br>
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
	<center><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'/></span></center>
	</div>
</body>
</html>
<?

exit;
?>
