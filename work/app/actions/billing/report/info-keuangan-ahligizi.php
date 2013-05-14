<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
set_time_zone();

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$namaFile = "info-keuangan-ahligizi.xls";

// header file excel

header_excel($namaFile);
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="4" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="4" align="center"><strong><font size="+1">PENERIMAAN JASA AHLI GIZI</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="4" align="center"><strong><font size="+1">PERIODE: <?= indo_tgl(isset($startDate) ? $startDate : $startDate) ?> s . d <?= indo_tgl(isset($endDate) ? $endDate : $endDate) ?></font></strong></td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
</table>
<table class="tabel" border="1" cellspacing=0>
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
            <tr class="<?= ($key%2)?'even':'odd' ?>">
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
<?php
exit;
?>