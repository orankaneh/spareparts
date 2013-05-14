<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
set_time_zone();

  $idInstalasi = isset ($_GET['idinstalasi'])?$_GET['idinstalasi']:"";
  $idKelas = isset ($_GET['idkelas'])?$_GET['idkelas']:"";
 $info = infobed_rawat_inap_muat_data($page = 1, $dataPerPage = 1000, $idInstalasi,$idKelas);

$namaFile = "info-ketersediaan-bed.xls";

// header file excel

header_excel($namaFile);
?>
<table border="0">
 <?php
    echo lembar_header_excel(4);
?>
    <tr bgcolor="#cccccc">
        <td colspan="4" align="center"><strong><font size="+1">Informasi Ketersediaan Bed Rawat Inap</font></strong></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
</table>
<table border="1" class="tabel">
<tr>
            
            <th>No.bed</th>
             <th>instalasi/Ruang</th>
            <th>Kelas</th>
            <th>Status</th>
    
</tr>
<?
  $no = 1;
 
  foreach($info['list'] as $row){
 
?>
   <tr class="<?= ($no%2)?"even":"odd"?>">
             
              <td><?= $row['nama']?></td>
              <td><?= $row['instalasi']?></td>
               <td><?= $row['class']?></td>
              <td><?= $row['status']?></td>
          </tr>
<?

  }
?>
</table>
<?
exit();
?>