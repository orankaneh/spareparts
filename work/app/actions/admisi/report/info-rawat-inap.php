<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$idInstalasi = isset ($_GET['instalasi'])?$_GET['instalasi']:"";
$idKelas = isset ($_GET['kelas'])?$_GET['kelas']:"";
?>
<html>
  <head>
     <title>Laporan Pembelian</title> 
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">     
     <style type="text/css">
         table,th,td {
             border:1px solid black;
         }
     </style>
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
  </head>  
  <body>
    <?require_once 'app/actions/admisi/lembar-header.php';?> 
  <center><b>INFORMASI RAWAT INAP <BR /> PERIODE: <?= indo_tgl(isset ($startDate)?$startDate:$startDate)?> s . d <?= indo_tgl(isset ($endDate)?$endDate:$endDate)?></b></center>
  <div class="data-list">
      <table class="tabel" cellspacing="0">
       <tr>
            <th width="1%">NO</th>
             <th>WAKTU</th>
            <th>NAMA LENGKAP PASIEN</th>
            <th>NO. RM</th>
            <th>KELURAHAN</th>
             <th>NAMA LENGKAP DOKTER</th>
            <th>BED</th>
        </tr>
        <?
          $no = 1;
          $info = rawat_inap_muat_data($startDate,$endDate,$idInstalasi,$idKelas);
          foreach($info as $row){
          if($row['tanggal'] == ""){
            echo "";
          }else{    
        ?>
          <tr class="<?= ($no%2)?"even":"odd"?>">
              <td align="center"><?= $no++?></td>
               <td align='center'><?=datetime($row['tanggal'])?></td>
              <td class="no-wrap"><?= $row['pasien']?></td>
              <td><?= $row['norm']?></td>              
              <td class="no-wrap"><?= $row['kelurahan'].', '.$row['kecamatan'].', '.$row['kabupaten']?></td>
                 <td><?= $row['nama_dokter']?></td>
              <td><?=$row['bed'].', '.$row['kelas'].', '.$row['instalasi']?></td>              
          </tr>
    
        <?
          }
          }
        ?>
    </table>
   </div>
  <center>
    <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
  </center>
  </body>
</html>
<?
exit();
?>