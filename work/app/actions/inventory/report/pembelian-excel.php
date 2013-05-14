<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:NULL;
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:NULL;
$awalJatuhTempo = (isset($_GET['awalJatuhTempo'])) ? get_value('awalJatuhTempo') : NULL;
$akhirJatuhTempo = (isset($_GET['akhirJatuhTempo'])) ? get_value('akhirJatuhTempo') : NULL;
$awal = Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$akhir = Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$idSuplier = isset ($_GET['idSuplier'])?$_GET['idSuplier']:NULL;
$idPegawai = isset ($_GET['idPegawai'])?$_GET['idPegawai']:NULL;
$pembelian = pembelian_muat_data(date2mysql($startDate), date2mysql($endDate), $idSuplier, get_value('idPegawai'), date2mysql($awalJatuhTempo), date2mysql($akhirJatuhTempo), NULL, NULL);
$rs = profile_rumah_sakit_muat_data();
header_excel("info-pembelian.xls");

// header file excel


?>
<table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="9" align="center"><strong><font size="+1"><?= $rs['nama'] ?></font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="9" align="center"><strong><font size="+1">INFORMASI PEMBELIAN</font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="9" align="center"><strong><font size="+1">PERIODE: <?= indo_tgl(isset ($startDate)?$startDate:$awal)?> s . d <?= indo_tgl(isset ($endDate)?$endDate:$akhir)?></font></strong></td>
      </tr>
      <tr>
          <td colspan="9">&nbsp;</td>
      </tr>    
  </table>
<table border="1">
        <tr>
           <th style="width: 10%">Tanggal Faktur</th>
                <th style="width: 10%">No. Surat</th>
                <th>Suplier</th>
                <th style="width: 10%">Tgl. Jatuh Tempo</th>
                <th style="width: 10%">Harga</th>
                <th style="width: 10%">PPN (%)</th>
                <th style="width: 10%">Materai (Rp.)</th>
                <th style="width: 10%">Diskon (Rp.)</th>
                  <th style="width: 10%">jumlah (Rp.)</th>
        </tr>
       <?php 
           $totalBeli = 0;
            $totalMaterai = 0;
            $totalPPN = 0;
            $totalAll=0;
            $totalDiskon=0;
		  
          foreach($pembelian as $key => $row): 
		    $subDiskon = 0;
                $total = 0;
          $jumlah = _select_arr("select dpr.harga_pembelian,dpr.diskon,dpr.jumlah_pembelian,
                        pb.nilai_konversi 
                    from detail_pembelian dpr 
                        join packing_barang pb on dpr.id_packing_barang = pb.id 
                    where dpr.id_pembelian = '$row[id]'");
                foreach ($jumlah as $rows) {
                    $harga = $rows['harga_pembelian'] * $rows['jumlah_pembelian'];
                    $diskon = $harga * ($rows['diskon'] / 100);
                    $subDiskon = $subDiskon + $diskon;
                    $selisih = $harga - $diskon;
                    $total = $total + $selisih;
                    $totalAll = $totalAll + $total;
                    $totalDiskon = $totalDiskon + $diskon;
                    $ppnn=$total * ($row['ppn'] / 100);
                    $jum=$total+$ppnn+$row['materai'];
                }
				?>
            <tr class="<?= ($key%2) ? 'even':'odd' ?>">
              
                      <td align="center"><?= datefmysql($row['waktu']) ?></td>
                    <td align="center"><?= $row['no_faktur'] ?></td>
                    <td class="no-wrap"><?= $row['suplier'] ?></td>
                    <td align="center"><?= datefmysql($row['tanggal_jatuh_tempo']) ?></td>
                    <td align="right"><?= rupiah($total) ?></td>
                    <td align="right"><?= rupiah(($total * ($row['ppn'] / 100))) ?></td>
                    <td align="right"><?= rupiah($row['materai']) ?></td>
                    <td align="right"><?= rupiah($subDiskon) ?></td>
                   <td align="right"><?= rupiah($jum) ?></td>
            </tr>
            <?php
                  $totalBeli = $totalBeli + $jum;
                $totalMaterai = $totalMaterai + $row['materai'];
                $totalPPN = $totalPPN + $ppnn;
				    endforeach;
            ?>
            <tr class="odd">
                <td colspan="4">Total Pembelian</td>
                <td><?= isset($totalBeli) ? rupiah($totalBeli) : ""; ?></td>
            </tr>
            <tr class="even">
                <td colspan="4">Total Materai</td>
                <td><?= isset($totalMaterai) ? rupiah($totalMaterai) : ""; ?></td>
            </tr>
            <tr class="odd">
                <td colspan="4">Total PPN</td>
                <td><?= isset($totalPPN) ? rupiah($totalPPN) : ""; ?></td>
            </tr>
            <tr class="even">
                <td colspan="4">Total Diskon</td>
                <td><?= isset($totalDiskon) ? rupiah($totalDiskon) : ""; ?></td>
            </tr>
      </table>
<?
exit();
?>