<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
set_time_zone();

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$namaFile = "info-keuangan-jasabidan.xls";

// header file excel

header_excel($namaFile);
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="7" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="7" align="center"><strong><font size="+1">PENERIMAAN JASA BIDAN</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="7" align="center"><strong><font size="+1">PERIODE: <?= indo_tgl(isset($startDate) ? $startDate : $startDate) ?> s . d <?= indo_tgl(isset($endDate) ? $endDate : $endDate) ?></font></strong></td>
    </tr>
    <tr>
        <td colspan="7">&nbsp;</td>
    </tr>
</table>
<table border="1" class="tabel">
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
                <td align="center"><?php echo"&nbsp;$row[id_pasien]"; ?></td>
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
<?
exit();
?>