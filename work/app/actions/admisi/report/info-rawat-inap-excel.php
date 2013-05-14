<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
set_time_zone();

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$idInstalasi = isset ($_GET['instalasi'])?$_GET['instalasi']:"";
$idKelas = isset ($_GET['kelas'])?$_GET['kelas']:"";

$namaFile = "info-rawat-inap-report.xls";

// header file excel

header_excel($namaFile);
?>
<table border="0">
 <?php
    echo lembar_header_excel(7);
?>
    <tr bgcolor="#cccccc">
        <td colspan="7" align="center"><strong><font size="+1">INFORMASI RAWAT INAP</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="7" align="center"><strong><font size="+1">PERIODE: <?= indo_tgl(isset($startDate) ? $startDate : $startDate) ?> s . d <?= indo_tgl(isset($endDate) ? $endDate : $endDate) ?></font></strong></td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
</table>
<table border="1" class="tabel">
<tr>
             <th>No</th>
             <th>Tanggal</th>
            <th>Nama Pasien</th>
            <th>No. RM</th>
            <th>Alamat</th>
            <th>Kelurahan</th>
             <th>Nama Dokter</th>
            <th>Instalasi</th>
            <th>Kelas</th>
</tr>
<?
  $no = 1;
  $info = rawat_inap_muat_data($startDate,$endDate,$idInstalasi,$idKelas);
 // show_array($info);
  foreach($info as $row){
   if($row['tanggal'] == ""){
            echo "";
          }else{    
?>
   <tr class="<?= ($no%2)?"even":"odd"?>">
              <td align="center"><?= $no++?></td>
                <td align='center'><?= deletetime($row['tanggal'])?></td>
              <td class="no-wrap"><?= $row['pasien']?></td>
              <td><?= $row['norm']?></td>
              <td class="no-wrap"><?= $row['alamat_jalan']?></td>
              <td><?= $row['kelurahan']?></td>
                 <td><?= $row['nama_dokter']?></td>
              <td><?= $row['instalasi']?></td>
                  <td><?= $row['kelas']?></td>
  </tr>
<?
  }
  }
?>
</table>
<?
exit();
?>