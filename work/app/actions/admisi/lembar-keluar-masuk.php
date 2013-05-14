<?php
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();

$idKunjungan = isset($_GET['id'])?$_GET['id']:NULL;

$sql="
select
ps.id as idPasien,ps.id_penduduk,p.tanggal_lahir as tanggal_lahir, pr.nama as profesiPasien, agm.nama as agamaPasien, dp.no_telp as telpPasien,
dp.id_pendidikan_terakhir,dp.id_profesi,pdd.id as id_pendidikan, pdd.nama as pendidikan,k.id,k.no_kunjungan_pasien,k.id_penduduk_penanggungjawab,date(k.waktu) as waktu,time(k.waktu) as jam,p.nama as namaPasien,p.jenis_kelamin,p.gol_darah,dp.alamat_jalan as alamatPasien, kel.nama as kelurahanPasien,
kec.nama as kecamatanPasien,kab.nama as kabupatenPasien,prov.nama as provinsiPasien,rj.no_surat_rujukan as noRujukan, ir.nama as namaRujukan, ins.nama as instalasi, ins.id, pkw.id_perkawinan, pkw.perkawinan, pJ.id, pJ.nama as penanggungJawab,
pNakes.id,pNakes.nama as nakes,dpPj.alamat_jalan as alamatPj,dpPj.no_telp as telpPj,kelPj.nama as kelurahanPj,
kecPj.nama as kecamatanPj,kabPj.nama as kabupatenPj,provPj.nama as provinsiPj,kls.nama as kelas
from kunjungan k
left join bed b on (k.id_bed=b.id)
left join instalasi ins on (b.id_instalasi=ins.id)
left join kelas kls on (b.id_kelas=kls.id)
left join pasien ps on (ps.id=k.id_pasien)
left join penduduk p on (p.id=ps.id_penduduk)
left join dinamis_penduduk dp on (dp.id_penduduk=p.id)
left join pendidikan pdd on (pdd.id=dp.id_pendidikan_terakhir)
left join profesi pr on (pr.id=dp.id_profesi)
left join agama agm on(agm.id=dp.id_agama)
left join kelurahan kel on (kel.id=dp.id_kelurahan)
left join kecamatan kec on (kec.id=kel.id_kecamatan)
left join kabupaten kab on (kab.id=kec.id_kabupaten)
left join provinsi prov on (prov.id=kab.id_provinsi)
left join penduduk pJ on (pJ.id=k.id_penduduk_penanggungjawab)
left join dinamis_penduduk dpPj on (dpPj.id_penduduk=pJ.id)
left join kelurahan kelPj on (kelPj.id=dpPj.id_kelurahan)
left join kecamatan kecPj on (kecPj.id=kelPj.id_kecamatan)
left join kabupaten kabPj on (kabPj.id=kecPj.id_kabupaten)
left join provinsi provPj on (provPj.id=kabPj.id_provinsi)

left join rujukan rj on (rj.id=k.id_rujukan)
left join penduduk pNakes on (pNakes.id=rj.id_penduduk_nakes)
left join instansi_relasi ir on (ir.id=rj.id_instansi_relasi)
left join perkawinan pkw on(dp.status_pernikahan=pkw.id_perkawinan)

where k.id='$idKunjungan'
";
$query=mysql_query($sql);
$row=mysql_fetch_array($query);
?>

<html>
  <head>
     <title>Ringkasan Masuk-Keluar Rumah Sakit</title> 
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
  </head>  
  <body>
    <center><?require_once 'app/actions/admisi/lembar-header.php';?></center>  
    <table class=head-laporan>
        <tr>
          <td align=center width=200px id=sekat>RINGKASAN MASUK-KELUAR RUMAH SAKIT</td>
          <td width=200px> &nbsp;&nbsp;&nbsp;&nbsp;No. RM : <?= $row['idPasien'];?></td>
        </tr>
    </table> 
    <table class="contain2" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="150px">Nama Pasien</td><td colspan="3"><?= $row['namaPasien'];?></td>  
        </tr>
        <tr>
          <td width="150px">Tanggal Lahir/Umur</td>
          <td>
              <?
                 if(createUmur($row['tanggal_lahir']) < 1){
                   echo "  thn / ".$row['tanggal_lahir']."</td>";} 
                 else {    
                   echo "".createUmur($row['tanggal_lahir'])." thn / ".datefmysql($row['tanggal_lahir'])."</td>";}
              ?>
          </td>
          <td width=150px>Jenis Kelamin</td><td><?= $row['jenis_kelamin'];?></td>  
        </tr>  
        <tr>
            <td width="150px">Agama</td><td><?= $row['agamaPasien'];?></td><td width=150px>Pendidikan</td><td><?= $row['pendidikan'];?></td>  
        </tr>    
        <tr>
          <td width="150px">Pekerjaan</td><td><?= $row['profesiPasien'];?></td><td width=150px>Status Perkawinan</td><td><?= $row['perkawinan'];?></td>  
        </tr>  
        <tr>
          <td width="150px">No. Telepon</td><td><?= $row['telpPasien'];?></td><td width=150px>Gol. Darah</td><td><?= $row['gol_darah'];?></td>  
        </tr> 
        <tr>
          <td width="150px">Alamat Pasien</td>
          <td colspan="3">
            <? 
              echo "$row[alamatPasien] Kelurahan: $row[kelurahanPasien] Kecamatan: $row[kecamatanPasien] <br /><br />Kabupaten: $row[kabupatenPasien] Provinsi: $row[provinsiPasien]";
            ?>
          </td>  
        </tr>
         <tr>
          <td width="150px">Nama PJ/KK</td><td colspan="3"><?= $row["penanggungJawab"];?></td>  
        </tr>
         <tr>
          <td width="150px">Alamat PJ/KK</td>
          <td colspan="3">
            <? 
              if($row["kelurahanPj"] == NULL){
                  $kelurahanPj = " - ";
              }else{
                  $kelurahanPj = "$row[kelurahanPj]";
              }
              if($row["kecamatanPj"] == NULL){
                  $kecamatanPj = " - ";
              }else{
                  $kecamatanPj = "$row[kecamatanPj]";
              }
              if($row["kabupatenPj"] == NULL){
                  $kabupatenPj = " - ";
              }else{
                  $kabupatenPj = "$row[kabupatenPj]";
              }
              if($row["provinsiPj"] == NULL){
                  $provinsiPj = " - ";
              }else{
                  $provinsiPj = "$row[provinsiPj]";
              }
              echo "$row[alamatPj] Kelurahan: $kelurahanPj Kecamatan: $kecamatanPj <br /><br />Kabupaten: $kabupatenPj Provinsi: $provinsiPj";
            ?>
          </td>  
        </tr>
         <tr>
          <td width="150px">No. Telepon PJ/KK</td><td colspan="3"><?= $row["telpPj"];?></td>  
        </tr>
        <tr>
          <td colspan="2">Cara Masuk RS : </td><td colspan="2">Nama Inst. Perujuk : <?= $row["namaRujukan"]?></td>  
        </tr>
        <tr>
          <td colspan="2">Cara Pembayaran : </td><td colspan="2">Nama Asuransi : </td>  
        </tr>
        <tr>
          <td width="150px">Dirawat yg ke : <?= $row["no_kunjungan_pasien"]?></td><td colspan="2">Tgl. Masuk : <?= datefmysql($row['waktu']) ?></td><td>Jam : <?= $row['jam']?></td>  
        </tr>
        <tr>
          <td width="150px">Ruang : </td><td colspan="2">Kelas : </td><td>Jenis Layanan : <?= $row["instalasi"]?></td>  
        </tr>
        <tr>
          <td width="150px">Nama Perawat PJ Unit Pengirim<br /><br /><br /></td><td colspan="2">Nama Perawat PJ Ruang<br /><br /><br /></td><td>Nama Dokter Yang Merawat<br /><br /><br /></td>  
        </tr>
        <tr>
          <td width="150px">Tgl. Keluar RS : </td><td colspan="2">Keadaan Keluar RS : </td><td>Cara Keluar RS : </td>  
        </tr>
        <tr>
          <td colspan="3">Diagnosis Utama : </td><td>Kode ICD-10 : </td>  
        </tr>
        <tr>
          <td colspan="3">
            Diagnosis Komplikasi / Komorbiditi : 
            <ol>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ol>    
          </td>
          <td>
            Kode ICD-10 : 
            <ol>
             <li></li>
             <li></li>
             <li></li>
             <li></li>
             <li></li>
            </ol>
          </td>  
        </tr>
        <tr>
          <td colspan="3">Penyebab Cedera/ Keracunan / Morfologi Neoplasma : <br /><br /><br /></td><td>Kode ICD-10 : <br /><br /><br /></td>  
        </tr>
        <tr>
          <td width="150px">
            Operasi/Tindakan :
            <ol>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ol>    
          </td>
          <td colspan="2">
            Tanggal Operasi/Tind :
            <ol>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ol>
          </td>
          <td>
            Kode ICD-9CM :
            <ol>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ol>
          </td>  
        </tr>
        <tr>
          <td colspan="2">Infeksi Nosokomial : </td><td colspan="2">Penyebab Infeksi Nosokomial : </td>  
        </tr>
        <tr>
          <td colspan="4">Imunisasi yang Pernah Didapat : 1.</td>  
        </tr> 
        <tr>
          <td width="150px">2. </td><td colspan="2">3. </td><td>4. </td>  
        </tr>
        <tr>
          <td width="150px">5. </td><td colspan="2">6. </td><td>7. </td>  
        </tr>
        <tr>
          <td colspan="3">Penyebab Kematian : </td><td>Kode ICD-10 : </td>  
        </tr>
        <tr>
          <td colspan="3">Dokter Yang Memulangkan :  <br /><br /><br /><br /><br /></td><td align="center">Tanda Tangan  <br /><br /><br /><br /><br /></td>  
        </tr>
    </table> 
    <center>
      <p><span id="SCETAK"><input type="button" class="tombol" value="Cetak" onClick="cetak()" /></span></p>
    </center>  
  </body>    
</html>  
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
