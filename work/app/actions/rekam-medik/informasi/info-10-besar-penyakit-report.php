<?php
    require_once "app/lib/common/functions.php";
    require_once 'app/lib/common/master-data.php';
    $startDate = (isset($_GET['awal'])) ? $_GET['awal'] : date('d/m/Y');
    $endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : date('d/m/Y');
    $penyakit= isset($_GET['penyakit']) ? $_GET['penyakit'] : NULL;
    $idPenyakit= isset($_GET['idPenyakit']) ? $_GET['idPenyakit'] : NULL;
    $jumlah = isset ($_GET['jumlah_baris'])?$_GET['jumlah_baris']:10;
    $jenis = isset ($_GET['jenis'])?$_GET['jenis']:"";
    
    $content="";
    $content.= "<div class='data-list'>
    <center>LAPORAN 10 BESAR PENYAKIT <br>
    PERIODE: ".indo_tgl($_GET['awal'])." s. d ".indo_tgl($_GET['akhir'])."</center>
    <table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel'>
    <tr>
            <th><h3>No</h3></th>
            <th><h3>Nama Penyakit</h3></th>
            <th><h3>Kode</h3></th>
            <th><h3>Jumlah Kasus</h3></th>
    </tr><tbody>";
      $no = 1;
      $top10penyakit = top10_muat_data($startDate,$endDate,$idPenyakit,$jumlah,$jenis);
      foreach($top10penyakit as $rows):
         $content.= "<tr class='";
         if ($no % 2 == 0) $content.= "odd"; else $content.= "even";
         $content.= "'>
             <td align=center>$no</td>
             <td>$rows[penyakit]</td>
             <td>$rows[kode_icd_10]</td>
             <td>$rows[jumlah]</td>
         </tr>";
         $no++;
      endforeach; 
      $content.= "</tbody>";
      $content.="</table>";
      
      header_excel("top10-penyakit.xls");
      echo app_core_render(APP_APP_PATH.'/views/report.php',array(
            'content'=>$content,
            'title'=>'Laporan 10 Besar Penyakit',
            'excel'=>true
      ));
      exit;
?>
