<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "app/lib/common/functions.php";
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
require_once 'app/config/db.php';
$obat = isset($_GET['obat']) ? $_GET['obat'] : NULL;
$packing = isset($_GET['idPacking']) ? $_GET['idPacking'] : NULL;
$perundangan = isset($_GET['perundangan']) ? $_GET['perundangan'] : NULL;
$generik = isset($_GET['generik']) ? $_GET['generik'] : NULL;
$formularium =  isset($_GET['formularium']) ? $_GET['formularium'] : NULL;
$indikasi = isset($_GET['indikasi']) ? $_GET['indikasi'] : NULL;
$ven = isset($_GET['ven']) ? $_GET['ven'] : NULL;
$idSubSubFarmakologi=isset($_GET['idSubSubFarmakologi']) ? $_GET['idSubSubFarmakologi'] : NULL;
$idZatAktif=isset($_GET['$idZatAktif']) ? $_GET['$idZatAktif'] : NULL;
   $stokObat = stok_obat_muat_data3($packing, $perundangan, $generik, $formularium, $indikasi, $ven, $idSubSubFarmakologi,$idZatAktif);
?>
<html>
    <title>Laporan Stok Obat Gudang</title>
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.css') ?>">
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
        <? require_once 'app/actions/admisi/lembar-header.php'; ?>
          <center>INFORMASI STOK OBAT GUDANG</center><div class="data-list">
        <table class="tabel">
            <tr>

                <th style="width: 30%">Nama Obat</th>
                <th>No. Batch</th>
                <th>E.D</th>
                <th>Stok Sisa</th>
                <th style="width: 10%">Kemasan</th>
                <th>HPP (Rp.)</th>
                <th>ROP</th>
                <th>Nilai (Rp.)</th>
            </tr>
            <?php
                $totalAset = 0;
                $no = 1;
             
                foreach ($stokObat as $row) {
                    if ($row['sisa'] == 0) {
                        echo "";
                    } else {
                   
//                            if ($row['pabrik'] == 'None' || $row['pabrik'] == 'NULL') {
//                                $pabrik = "";
//                            }else{
//                                $pabrik = $row['pabrik'];
//                                $style = ($no % 2) ? 'class="odd"' : 'class="even"';
//                            }
                        $kadaluarsa = selisih_hari($row['ed'], date("Y-m-d"));
                        if ($kadaluarsa < 180){
                            if ($row['pabrik'] == 'None' || $row['pabrik'] == 'NULL') {
                                $pabrik = "";
                            }else
                                $pabrik = $row['pabrik'];
                            $selisihHari = selisih_hari(date("Y-m-d"), $row['ed']);
                            if ($selisihHari <= 0) {
                                $style = 'style="background-color: #DE5252; color: white;"';
                            } else if ($selisihHari > 0 && $selisihHari <= 180) {
                                $style = 'style="background-color: #FAF0AC; color: black;"';
                            } else {
                                $style = ($no % 2) ? 'class="odd"' : 'class="even"';
                            }
            ?>
                            <tr <?= $style ?>>

                                <td class="no-wrap"><?= "$row[barang] $row[kekuatan], $row[sediaan] @$row[nilai_konversi] $row[satuan_terkecil] $pabrik" ?></td>
                                <td><?= $row['batch'] ?></td>
                                <td align="center"><?= datefmysql($row['ed']) ?></td>
                                <td align="right"><?= $row['sisa'] ?></td>
                        <td align="right"><?= $row['satuan_terbesar'] ?></td>
                        <td align="right"><?= rupiah($row['hpp']) ?></td>
                        <td align="right"><?= hitung_rop($row['id_packing_barang']) ?></td>
                        <td align="right">
                    <?php
                            $nilai = $row['sisa'] * $row['hpp'];
                            echo (rupiah($nilai));
                            $totalAset += $nilai;
                    ?>
                                </td>
                            </tr>
<?php
                            $no++;
                        }
                        }
			}
?>
<tr><td colspan="7">
 Total Nilai Obat : 
 </td>
 <td colspan="1">
  <? echo "Rp. " . rupiah($totalAset) . ",00"; ?>
 </td>
 </tr>
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