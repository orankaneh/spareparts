<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$barang = (isset($_GET['barang'])) ? $_GET['barang'] : null;
$idPacking = (isset($_GET['idPacking'])) ? $_GET['idPacking'] : null;
$pabrik = (isset($_GET['pabrik'])) ? $_GET['pabrik'] : null;
$idPabrik = (isset($_GET['idPabrik'])) ? $_GET['idPabrik'] : null;
$subKategori = (isset($_GET['subKategori'])) ? $_GET['subKategori'] : null;
$idSubKategori = (isset($_GET['idSubKategori'])) ? $_GET['idSubKategori'] : null;
$stok = stok_barang_gudang_muat_data($idPacking, $idPabrik, $idSubKategori);
 $cp=profile_rumah_sakit_muat_data();
$namaFile = "stok-barang-gudang.xls";

header_excel($namaFile);
?>
<table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="9" align="center"><strong><font size="+1"><?=$cp['nama']?></font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="9" align="center"><strong><font size="+1">INFORMASI STOK BARANG GUDANG</font></strong></td>
      </tr>
     
      <tr>
          <td colspan="9">&nbsp;</td>
      </tr>    
</table>
 <table class="tabel">
                <tr>
                    <th>Nama Packing Barang</th>
                    <th>No. Batch</th>
                    <th>E.D</th>
                    <th>Jumlah Sisa</th>
                    <th>ROP</th>
                    <th>Kemasan</th>
                       <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Nilai</th>
                </tr>
                <?php
                $nilaiAll = 0;
                $nilai = 0;
                foreach ($stok as $key => $rows):
                    if ($rows['sisa'] == 0) {
                        echo "";
                    } else {
                            $nama=nama_packing_barang(array($rows['generik'],$rows['nama_barang'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan'],$rows['pabrik']));
                        $kadaluarsa = selisih_hari($rows['ed'], date("Y-m-d"));
//                        if ($kadaluarsa >= 180) {
//                            
//                        } else {
                            $selisihHari = selisih_hari(date("Y-m-d"), $rows['ed']);
                            if ($selisihHari <= 180 && $rows['batch'] != '') {
                                $style = 'class=warning';
                            } else {
                                $style = (($key % 2) ? 'class="odd"' : 'class="even"');
                            }
                            ?>
                            <tr <?= $style ?>>
                                <td style="width: 100%"><?=$nama?></td>
                                <td align="left"><?= $rows['batch'] ?></td>
                                <td><?= datefmysql($rows['ed']) ?></td>
                                <td><?= $rows['sisa'] ?></td>
                                <td align="center" class="no-wrap"><?= hitung_rop($rows['id_packing_barang']) ?></td>
                                <td><?= $rows['kemasan'] ?></td>
                                <td align="right"><?= rupiah($rows['13']) ?></td>
                                <td align="right"><?= rupiah($rows['hpp']) ?></td>
                                <td align="right">
                                   <?
                                     $nilai = $rows['sisa'] * $rows['hna'];
                                     echo rupiah($nilai);
                                   ?>
                                </td>
                                   <? $nilaiAll = $nilaiAll + $nilai ?>
                            </tr>
                            <?php //}
                        } endforeach; ?>
            </table>
<?
exit();
?>