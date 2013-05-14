<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
set_time_zone();
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$penyakit= isset($_GET['penyakit']) ? $_GET['penyakit'] : NULL;
$idPenyakit= isset($_GET['idPenyakit']) ? $_GET['idPenyakit'] : NULL;
?>
<html>
    <head>
        <title>Laporan 10 Besar Penyakit</title>
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>" />
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>" />
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.css')?>" />
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
        <center>
            <h1>LAPORAN 10 BESAR PENYAKIT</h1>
            <h2>Periode <?= $startDate." s.d ".  $endDate?></h2>
        </center>
        <img src="<?= app_base_url('assets/images/10-besar-penyakit.png');?>" />
          <div class="data-list">
          <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel">
             <tr>
                   <th>No</th>
                   <th>Nama Penyakit</th>
                   <th>Kode</th>
                   <th>Jumlah Kasus</th>
             </tr>
        <?php
        $num = 1;
        $top10penyakit = top10_muat_data($startDate,$endDate,$idPenyakit);
        foreach($top10penyakit as $rows): ?>

                  <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                    <td align="center"><?= $num++ ?></td>
                    <td><?= $rows['penyakit']?></td>
                    <td><?= $rows['kode_icd_10']?></td>
                    <td><?= $rows['jumlah']?></td>
                </tr>
               <?php
                endforeach; 

               ?>
            </table>
        </div>
         <center>
           <p><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'></span></p>
         </center> 
    </body>
 <?exit;?>
 