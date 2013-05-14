<style>
body {margin: 0 60px ; padding-top: 30px; font-family: "Consolas","Fixedsys",arial !important;}
td { font-size: 12px !important}
.tabel-judul {border-top: 1px dotted #666; border-bottom: 1px dotted #666; width: 700px; margin: 20px 0}
.head-cetak-instansi {font-size: 22px; font-family: "Arial Narrow",tahoma; font-weight: 800}
</style>
<div style="width: 700px">
<?php
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
$idKunjungan=(isset($_GET['idKunjungan']))?$_GET['idKunjungan']:null;

$sql="
select
ps.id as idPasien,ps.id_penduduk,p.tanggal_lahir as tanggal_lahir, pr.nama as pekerjaanPasien, agm.nama as agamaPasien, dp.no_telp as telpPasien,
k.id,p.nama as namaPasien,dp.alamat_jalan as alamatPasien, kel.nama as kelurahanPasien, kec.nama as kecamatanpasien,kab.nama as kabpasien,prov.nama as provpasien,
pPj.nama as namaPj,dpPj.alamat_jalan as alamatPj, kelPj.nama as kelurahanPj,kecPj.nama as kecpj,kabPj.nama as kabpj,provPj.nama as provpj,dpPj.no_telp as telpPj,
rj.no_surat_rujukan as noRujukan, ir.nama as namaRujukan,DATE(k.waktu) as tanggal_kunjungan,TIME(k.waktu) as jam_kunjungan
from kunjungan k
left join pasien ps on (ps.id=k.id_pasien)
left join penduduk p on (p.id=ps.id_penduduk)
left join dinamis_penduduk dp on (dp.id_penduduk=p.id)
left join pekerjaan pr on (pr.id=dp.id_pekerjaan)
left join agama agm on(agm.id=dp.id_agama)
left join kelurahan kel on (kel.id=dp.id_kelurahan)
left join kecamatan kec on (kec.id=kel.id_kecamatan)
left join kabupaten kab on (kab.id=kec.id_kabupaten)
left join provinsi prov on (prov.id=kab.id_provinsi)
left join penduduk pPj on (pPj.id=k.id_penduduk_penanggungjawab)
left join dinamis_penduduk dpPj on (dpPj.id_penduduk=pPj.id)
left join kelurahan kelPj on (kelPj.id=dpPj.id_kelurahan)
left join kecamatan kecPj on (kecPj.id=kelPj.id_kecamatan)
left join kabupaten kabPj on (kabPj.id=kecPj.id_kabupaten)
left join provinsi provPj on (provPj.id=kabPj.id_provinsi)
left join rujukan rj on (rj.id=k.id_rujukan)
left join instansi_relasi ir on (ir.id=rj.id_instansi_relasi)

where k.id='$idKunjungan'
";

$query=mysql_query($sql);
$row=mysql_fetch_array($query);
$telp = $row['telpPasien']=='NULL'?'':$row['telpPasien'];
$html="";
if ($telp !=""){
$html="<td width=200px>Nomor Telepon</td>
		  <td> :</td>
		  <td>$telp</td>";
		  }

echo "
<html>
<head>
  <title>Lembar Poliklinik</title>
  <link rel='stylesheet' type='text/css' href='".app_base_url('/assets/css/base.css')."'>
</head>
<body onunload=\"show_form2();\"><center>";
require_once 'app/actions/admisi/lembar-header.php'; ?>
</center>

<table class='tabel-judul' style='width:700px'>
    <tr>
		<td align=center width=200px rowspan=2>LEMBAR POLIKLINIK</td>
        <td width=200px>No. RM : <?php echo $row['idPasien']; ?></td>
	</tr>
    <tr>
		<td width=200px>Tanggal : <?php echo datefmysql($row['tanggal_kunjungan'])." ".$row['jam_kunjungan']; ?></td>
	</tr>
<?php
		echo "</table>";
echo "
    <table style='width:700px'> 
        <tr>
		  <td width=200px>Nama Pasien</td>
		  <td align='right'>:</td>
		  <td>$row[namaPasien]</td>
		</tr>
        <tr>
		  <td width=200px>Umur/Tgl. Lahir</td>
		  <td align='right'>:</td>
		  <td>";
                   echo "".hitungUmur2($row['tanggal_lahir'])." thn / ".datefmysql($row['tanggal_lahir'])."</td>";
echo "
	</tr>
        <tr>
		  <td width=200px>Agama</td>
		  <td align='right'>:</td>
		  <td>$row[agamaPasien]</td>
		</tr>
        <tr>
		  <td width=200px>Pekerjaan</td>
		  <td align='right'>:</td>
		  <td>$row[pekerjaanPasien]</td>
		</tr>
		<tr>
		  <td width=200px>Alamat Pasien</td>
		  <td align='right'>:</td>
		  <td>$row[alamatPasien] $row[kelurahanPasien],$row[kecamatanpasien],$row[kabpasien],$row[provpasien]</td>
		</tr>
		<tr>
		  $html
		</tr>
		<tr>
		  <td width=200px colspan='3'>Dalam keadaan penting harap hubungi,</td>
		</tr>
		<tr>
		  <td width=200px colspan='2' align='right'>Nama :</td>
		  <td>$row[namaPj]</td>
		</tr>
		<tr>
		  <td width=200px colspan='2' align='right'>Alamat :</td>
		  <td>$row[alamatPj] $row[kelurahanPj],$row[kecpj],$row[kabpj],$row[provpj]</td>
		</tr>
		<tr>
		  <td width=200px colspan='2' align='right'>Nomor Telepon :</td>
		  <td>$row[telpPj]</td>
		</tr>
		<tr>
		  <td colspan='3' align='right'>&nbsp</td>
		</tr>";?>
                <!--<tr>
                   <td align=right valign=top width=200px><span style='font-size: 11px'>Keterangan:</span></td>
                   <td colspan=2 align=justify><span style='font-size: 11px'>Lembar ini digunakan secara bersama oleh unit-unit yang dikunjungi berururutan dari
                   atas ke bawah, kecuali unit kebidanan. Penyakit kandungan tersedia form tersendiri. Bubuhi cap gambar sesuai dengan
                   unit perawatannya.</span>
                   </td>
                </tr>-->
	<? echo "</table>
";
?>
<table class="contain2"  border="0" cellpadding="0" cellspacing="0" style="width:700px; text-align: left !important">
    <tr align="center">
        <td width="10%">Tanggal &amp; Jam</td><td>Anamnesis &amp; pemeriksaan</td><td>Diagnosis &amp; Therapi</td><td>ICD</td><td width="15%">Dokter</td>
    </tr>
    <tr>
        <td height="680">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
    </tr>
</table>
<?
echo"        <center>
          <p><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'></span></p>
        </center>
</body>
</html>";?>

<script language='JavaScript'>
  	function cetak() {  		
  		SCETAK.innerHTML = '';
		window.print();
		if (confirm('Apakah menu print ini akan ditutup?')) {
                    show_form2();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
  	}
        function show_form2(){
            window.open('lembar-poliklinik-belakang?idKunjungan=<?=$idKunjungan?>','mywindow','location=1,status=1,scrollbars=1,width=800px');
        }
</script>
<?
exit;
?>
</div>