<style>
body {margin: 0 60px ; padding-top: 30px; font-family: "Consolas","Fixedsys",arial !important;}
td { font-size: 12px !important}
.tabel-judul {border-top: 1px dotted #666; border-bottom: 1px dotted #666; width: 700px; margin: 20px 0}
.head-cetak-instansi {font-size: 22px; font-family: "Arial Narrow",tahoma; font-weight: 800}
</style>
<?php
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
$idKunjungan=(isset($_GET['idKunjungan']))?$_GET['idKunjungan']:null;
$tanggal = date("d-m-Y");

$sql="
select
ps.id as idPasien,ps.id_penduduk,p.tanggal_lahir as tanggal_lahir, pr.nama as profesiPasien, pj.nama as pekerjaanPasien, agm.nama as agamaPasien, dp.no_telp as telpPasien,
k.id,p.nama as namaPasien,dp.alamat_jalan as alamatPasien, kel.nama as kelurahanPasien, kec.nama as kecamatanPasien, kb.nama as kabupatenPasien,
pPj.nama as namaPj,dpPj.alamat_jalan as alamatPj, kelPj.nama as kelurahanPj,dpPj.no_telp as telpPj,
rj.no_surat_rujukan as noRujukan, ir.nama as namaRujukan,
DATE(k.waktu) as tanggal_kunjungan,TIME(k.waktu) as jam_kunjungan
from kunjungan k

left join pasien ps on (ps.id=k.id_pasien)
left join penduduk p on (p.id=ps.id_penduduk)
left join dinamis_penduduk dp on (dp.id_penduduk=p.id)
left join profesi pr on (pr.id=dp.id_profesi)
left join pekerjaan pj on (pj.id = dp.id_pekerjaan)
left join agama agm on(agm.id=dp.id_agama)
left join kelurahan kel on (kel.id=dp.id_kelurahan)
left join penduduk pPj on (pPj.id=k.id_penduduk_penanggungjawab)
left join dinamis_penduduk dpPj on (dpPj.id_penduduk=pPj.id)
left join kelurahan kelPj on (kelPj.id=dpPj.id_kelurahan)
left join kecamatan kec on (kec.id=kel.id_kecamatan)
left join kabupaten kb on (kb.id=kec.id_kabupaten)

left join rujukan rj on (rj.id=k.id_rujukan)
left join instansi_relasi ir on (ir.id=rj.id_instansi_relasi)

where k.id='$idKunjungan'
";

$query=mysql_query($sql) or die (mysql_error());
$row=mysql_fetch_array($query);
$telepon = ($row['telpPasien'] != 'NULL')?$row['telpPasien']:'-';
echo "
<html>
<head >
  <title>Lembar UGD 1</title>
  <link rel='stylesheet' type='text/css' href='".app_base_url('/assets/css/base.css')."'>
  <style type='text/css'>
	.head-cetak {
	text-align:center;
	}
  </style>
</head>
<body onunload=\"show_form2();\">";
require_once 'app/actions/admisi/lembar-header.php';
echo "<table class=head-laporan style='width:600px'><tr><td rowspan=2 align=center width=200px id=sekat>LEMBAR GAWAT DARURAT</td>
        <td width=200px> &nbsp;&nbsp;&nbsp;&nbsp;No. RM : $row[idPasien]</td></tr>
        <tr><td width=200px>&nbsp;&nbsp;&nbsp;&nbsp;Tanggal : ".datefmysql($row['tanggal_kunjungan'])." $row[jam_kunjungan]</td></tr>";
echo "</table>";
echo "
    <table class=contain cellpadding=0 cellspacing=1 style='width:600px'>
        <tr>
		  <td width=200px>Nama Pasien</td>
		  <td>:</td>
		  <td>$row[namaPasien]</td>
		</tr>
        <tr>
		  <td width=200px>Umur/Tgl. Lahir</td>
		  <td>:</td>
		  <td>";
		  //format umur  … tahun, … bulan, … hari
                 if(hitungUmur2($row['tanggal_lahir']) < 1){
                   echo "   / ".$row['tanggal_lahir']."</td>";}
                 else {
                   echo "".hitungUmur2($row['tanggal_lahir'])."  / ".datefmysql($row['tanggal_lahir'])."</td>";}
echo "
	</tr>
        <tr>
		  <td width=200px>Agama</td>
		  <td>:</td>
		  <td>$row[agamaPasien]</td>
		</tr>
        <tr>
		  <td width=200px>Pekerjaan</td>
		  <td>:</td>
		  <td>$row[pekerjaanPasien]</td>
		</tr>
		<tr>
		  <td width=200px valign='top'>Alamat Pasien</td>
		  <td valign='top'>:</td>
		  <td>$row[alamatPasien] $row[kelurahanPasien]<br>$row[kecamatanPasien] $row[kabupatenPasien]</td>
		</tr>
                <tr>
		  <td width=200px>No. Telepon</td>
                   <td>:</td>
		  <td>$telepon</td>
		</tr>   
		<tr>
		  <td width=200px>Nama PJ</td>
                   <td>:</td>
		  <td>$row[namaPj]</td>
		</tr>
		<tr>
		  <td width=200px>Alamat PJ</td>
                   <td>:</td>
		  <td>$row[alamatPj] $row[kelurahanPj]</td>
		</tr>
	           ";?>
        	<tr>
		  <td align=justify colspan=3>Rujukan &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;<?=$row['noRujukan']?>
                    <br><input type="checkbox" <?=(isset($row['noRujukan']))?'checked=checked':null;?>> Ya, Puskesmas/Doktor/Bidan/RS Lain: &nbsp;<?=$row['namaRujukan']?>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" <?=(empty($row['noRujukan']))?'checked=checked':null;?>> Tidak<br>
                    Alasan Datang :<input type="checkbox" > Penyakit <input type="checkbox" > Kecelakaan Kerja <input type="checkbox" > Trauma/Ruda Paksa, Keterangan Kejadian:<br>
                    Tiba Pukul ....................Tanggal Kejadian ............... Pukul ..................
                    <br>Tempat Kejadian ......................................................................
                    <br>Alasan Cidera ......................................................................
                  </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <fieldset style="height: 100;width: 97%">Riwayat Penyakit:

                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <fieldset style="width: 97%">Jenis Kasus:<br>
                            <input type="checkbox" > Bedah <input type="checkbox" > Non Bedah <input type="checkbox" > Anaka
                            <input type="checkbox" > Psikiatrik <input type="checkbox" > Trauma <input type="checkbox" > Lainnya
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <fieldset style="width: 97%">
                            <ul type="A">
                                <li>ANAMNESA
                                    <br><br><br><br><br/><br/>
                                </li>
                                <li>PEMERIKSAAN
                                    <br>
                                    KU &nbsp;&nbsp;:
                                    Tensi: .......... mmHg&nbsp;&nbsp;&nbsp;Nadi : ................./mmt&nbsp;&nbsp;&nbsp;Suhu : ......C&nbsp;&nbsp;&nbsp;<br>BB : ..... kg
                                </li>
                            </ul>
                            <br/>
                            <center><img width="30%" src="<?= app_base_url('assets/images/anatomy2.jpg')?>" /></center>
                        </fieldset>
                    </td>
                </tr>
                     <?

echo"</table>
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
                    show_form2();
                        //window.close();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
  	}
        function show_form2(){
            window.open('lembar-ugd-belakang?idKunjungan=<?=$idKunjungan?>','mywindow','location=1,status=1,scrollbars=1,width=800px');
        }
        
</script>
<?
exit;
?>