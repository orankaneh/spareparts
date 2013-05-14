<?
require_once 'app/lib/common/master-data.php';
?>
<div class="data-list">
    <?php
        require_once 'app/lib/common/master-data.php';
        require_once 'app/lib/common/functions.php';
        $startDate  = $_GET['startDate'];
        $endDate    = $_GET['endDate'];
        $startDateMysql = date2mysql($startDate);
        $endDateMysql = date2mysql($endDate);
    ?>
    <?php if ($_GET['kategori'] == 1) { ?>
    <center><h2>.:: PENERIMAAN JASA KESELURUHAN DOKTER TERHITUNG SEJAK TANGGAL <?= $startDate ?> HINGGA <?= $endDate ?> ::.</h2></center>
    <table style="width: 60%" class="tabel" cellspacing=0>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 30%">Nama Dokter</th>
                <th style="width: 15%">Spesialisasi</th>
                <th style="width: 15%">Jumlah Jasa</th>
                <th style="width: 10%">Aksi</th>
            </tr>
            <?php
            $jasa_dokter = jasa_dokter_muat_data($startDateMysql,$endDateMysql);
            $no=1;
            foreach ($jasa_dokter as $number_variable => $variable) {
                if(!empty ($variable['nama_nakes'])){
                ?>
                <tr class='<?php echo ($no%2)?'even':'odd'?>'>
                   <td><?php echo $no ;?></td>
                   <td><?php echo $variable['nama_nakes'] ;?></td>
                   <td><?php echo $variable['nama_spesialisasi'] ;?></td>
                   <td><?php echo rupiah($variable['on_nakes1']+$variable['on_nakes2']+$variable['on_nakes3']) ;?></td>
                   <td class='aksi'  ><a href='#' class='detail' onclick="getDetail('<?php echo app_base_url('billing/detail_jasa_dokter');?>','<?php echo $variable['id_penduduk_nakes'];?>','<?php echo $variable['nama_spesialisasi'] ;?>','<?php echo str_replace(' ','_',$variable['nama_nakes']);?>')"> detail</a></td>
                </tr>
                <?php
                }
            $no++;
            }
            ?>
    </table>
    <?php } ?>
    <?php if ($_GET['kategori'] == 2) { ?>
    <h2>.:: PENERIMAAN JASA PERAWAT UNIT <?= strtoupper($_GET['unit']) ?> TANGGAL <?= $startDate ?> HINGGA <?= $endDate ?> ::.</h2>
    <table style="width: 60%" class="tabel" cellspacing=0>
            <tr>
                <th style="width: 5%">No</th>
                
                <th style="width: 5%">No Kode Perawat</th>
                <th style="width: 25%">Nama Perawat</th>
                <th style="width: 15%">Nilai Total (Rp)</th>
                <th style="width: 10%">Aksi</th>
            </tr>
            <?php
            $jasa_perawat = jasa_perawat_muat_data($_GET['idunit'],$startDateMysql, $endDateMysql);
            foreach($jasa_perawat as $key => $row): ?>
            <tr class="<?= ($key%2)?'odd':'even' ?>">
                <td align="center"><?= ++$key ?></td>
                <td align="center"><?= $row['nip'] ?></td>
                <td><?= $row['perawat'] ?></td>
                <td align="right"><?= rupiah($row['total']) ?></td>
                <td class="aksi"><a href="" class="detail">detail</a></td>
            </tr>
            <?php endforeach; ?>
    </table>
    <?php } ?>
    <?php if ($_GET['kategori'] == 3) { ?>
    <h2>.:: PENERIMAAN JASA BIDAN <?= strtoupper($_GET['idnakes']) ?> TANGGAL <?= $startDate ?> HINGGA <?= $endDate ?> ::.</h2>
    <table class="tabel" cellspacing=0>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 10%">No. RM</th>
                <th style="width: 20%">Nama Pasien</th>
                <th style="width: 15%">Nama Asuransi</th>
                <th style="width: 20%">Pemeriksaan</th>
                <th style="width: 15%">Tindakan</th>
                <th style="width: 10%">Nilai Total (Rp)</th>
            </tr>

    <?php
    $jasa_bidan = jasa_bidan_muat_data($_GET['idnakes'],$startDate,$endDate);
        $jumlah = 0;
        $pemerik = 0;
        $tindak = 0;
        foreach ($jasa_bidan as $key => $row):
    ?>
            <tr class="<?= ($key%2)?'odd':'even' ?>">
                <td align="center"><?= ++$key ?></td>
                <td align="center"><?= $row['id_pasien'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td>Tanpa asuransi</td>
                <td align="right"><?php
                if ($row['id_kategori_tarif'] == 3) {
                    echo $pemeriksaan = rupiah($row['subtotal']);
                } else {
                    echo $pemeriksaan = 0;
                }
                ?></td>
                <td align="right">
                <?php
                if ($row['id_kategori_tarif'] == 4) {
                    echo $tindakan = rupiah(isset($row['subtotal'])?$row['subtotal']:'0');
                } else {
                    echo $tindakan = 0;
                }
                ?>
                </td>
                <td align="right"><?= rupiah($pemeriksaan + $tindakan) ?></td>
            </tr>
    <?php
        $jumlah = $jumlah + $row['subtotal'];
        $pemerik = $pemerik + $pemeriksaan;
        $tindak  = $tindak + $tindakan;
        endforeach;
    ?>
            <tr>
                <td colspan="4" align="right">Total </td> <td align="right"><?= rupiah($pemerik) ?></td>
                <td align="right"><?= rupiah($tindak) ?></td><td align="right"><?= rupiah($pemerik+$tindak) ?></td>
            </tr>
    </table>
    <p>
        <a class="excel" href="<?= app_base_url('billing/report/info-keuangan-jasabidan/?startDate='.$startDate.'&endDate='.$endDate.'&idnakes='.$_GET['idnakes'].'');?>">Cetak</a>
    </p>
    <?php } ?>
    <?php if ($_GET['kategori'] == 4) { ?>
    <h2>.:: PENERIMAAN JASA AHLI GIZI '<?= strtoupper($_GET['nakes']) ?>' TANGGAL <?= $startDate ?> HINGGA <?= $endDate ?> ::.</h2>
    <table style="width: 60%" class="tabel" cellspacing=0>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">No. RM</th>
                <th style="width: 45%">Nama Pasien</th>
                <th style="width: 15%">Nilai Total (Rp)</th>
            </tr>
    <?php
    $jasa_gizi = jasa_gizi_muat_data($_GET['idnakes'],$startDate,$endDate);
        $jumlah = 0;
        foreach ($jasa_gizi as $key => $row):
    ?>
            <tr class="<?= ($key%2)?'odd':'even' ?>">
                <td align="center"><?= ++$key ?></td>
                <td align="center"><?= $row['id_pasien'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td align="right"><?= rupiah($row['subtotal']) ?></td>
            </tr>
    <?php
        $jumlah = $jumlah + $row['subtotal'];
        endforeach;
    ?>
            <tr>
                <td colspan="3" align="right">Total </td> <td align="right"><?= rupiah($jumlah) ?></td>
            </tr>
    </table>
    <p>
        <a class="excel" href="<?= app_base_url('billing/report/info-keuangan-ahligizi/?startDate='.$startDate.'&endDate='.$endDate.'&idnakes='.$_GET['idnakes'].'');?>">Cetak</a>
    </p>
    <?php } ?>
    <?php if ($_GET['kategori'] == 5) { ?>
    <h2>.:: PENERIMAAN JASA APOTEKER <?= strtoupper($_GET['nakes'])?> TERHITUNG SEJAK TANGGAL <?= $startDate ?> HINGGA <?= $endDate ?> ::.</h2>
    <table style="width: 60%" class="tabel" cellspacing=0>
        <tr>
            <th style="width: 5%">No</th>
            <th style="width: 25%">NORM</th>
            <th style="width: 25%">Pasien</th>
            <th style="width: 15%">Konsultasi (Rp)</th>
            <th style="width: 15%">Pelayanan Resep (Rp)</th>
            <th style="width: 15%">Nilai Total (Rp)</th>
        </tr>
        <?php
            $jasa=  jasa_apoteker_muat_data($_GET['idnakes'],$startDateMysql,$endDateMysql);
            $i=1;
            $totalKonsultasi=0;
            $totalLayananResep=0;
            foreach($jasa as $row){
                ?>
                <tr class='<?=($i%2!=1)?'odd':'even'?>'>
                    <td style="width: 5%"><?=$i++?></td>
                    <td style="width: 25%"><?=$row['norm']?></td>
                    <td style="width: 25%"><?=$row['nama']?></td>
                    <td style="width: 15%" class="right"><?=rupiah($row['konsultasi'])?></td>
                    <td style="width: 15%" class="right"><?=rupiah($row['layanan_resep'])?></td>
                    <td style="width: 15%" class="right"><?=rupiah($row['layanan_resep']+$row['konsultasi'])?></td>
                </tr>
                <?
                $totalKonsultasi+=$row['konsultasi'];
                $totalLayananResep+=$row['layanan_resep'];
            }
        ?>
                <tr class='<?=($i%2!=1)?'odd':'even'?>'>
                    <td colspan="3" align="center">TOTAL</td>
                    <td style="width: 15%" class="right"><?=rupiah($totalKonsultasi)?></td>
                    <td style="width: 15%" class="right"><?=rupiah($totalLayananResep)?></td>
                    <td style="width: 15%" class="right"><?=rupiah($totalKonsultasi+$totalLayananResep)?></td>
                </tr>
    </table>
    <a class=excel class=tombol href="<?=app_base_url('billing/report/info-jasa-apoteker?').  generate_get_parameter($_GET)?>">Cetak</a>
    <?php } ?>
    <?php if ($_GET['kategori'] == 6) { ?>
    <h2>.:: PENERIMAAN JASA KESELURUHAN AMBULANCE TERHITUNG SEJAK TANGGAL <?= $startDate ?> HINGGA <?= $endDate ?> ::.</h2>
    <table style="width: 100%" class="tabel" cellspacing=0>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>No. RM</th>
            <th>Nama Pasien</th>
            <th>Layanan</th>
            <th>Frekuensi / Km</th>
            <th>Nakes 1</th>
            <th>Nakes 2</th>
            <th>Nakes 3</th>
            <th>Nilai Total (Rp)</th>
        </tr>
        <?
          $ambulance = info_keuangan_ambulance($startDate, $endDate);
          $totalAll = 0;
          foreach ($ambulance as $no => $row){
       ?>
        <tr class="<?= ($no%2)?"even":"odd";?>">
            <td align="center" style="width: 5%"><?= ++$no?></td>
            <td style="width: 8%"><?= datefmysql($row['tanggal'])?></td>
            <td style="width: 8%"><?= $row['id_pasien']?></td>
            <td><?= $row['nama']?></td>
            <td><?= $row['layanan']?></td>
            <td style="width: 8%"><?= $row['frekuensi']?></td>
            <td><?= $row['nakes1']?></td>
            <td><?= $row['nakes2']?></td>
            <td><?= $row['nakes3']?></td>
            <td align="right" style="width: 10%">
              <?
                 $subtotal = $row['frekuensi']*$row['total'];
                 echo "Rp. ".rupiah($subtotal)."";
              ?>
            </td>
        </tr>
       <? 
          $totalAll = $totalAll+$subtotal;
          }
        ?>
        <tr>
            <td colspan="9" align="right">Total</td>
            <td align="right"><?= "Rp. ".rupiah($totalAll);?></td>
        </tr>
    </table>
    <p> 
        <a class="excel" href="<?= app_base_url('billing/report/info-keuangan-ambulance/?startDate='.$startDate.'&endDate='.$endDate.'');?>">Cetak</a>
    </p>
    <?php } ?>
    <?php if ($_GET['kategori'] == 7) { ?>
    
    <table style="width: 70%" class="tabel" cellspacing=0>
        <tr>
            <th style="width: 5%">No</th>
            <th style="width: 15%">No. RM</th>
            <th style="width: 25%">Nama Pasien</th>
            <th style="width: 25%">Layanan (sewa alat)</th>
            <th style="width: 15%">Nilai Total (Rp)</th>
        </tr>
    </table>
    <?php } ?>
</div>
<?php
exit;
?>