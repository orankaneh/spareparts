<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
set_time_zone();

$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$idPegawai = isset($_GET['idPegawai']) ? $_GET['idPegawai'] : NULL;
$pegawai = isset($_GET['pegawai']) && ($idPegawai != null) ? $_GET['pegawai'] : NULL;
$idUnit = get_value('unit');
$distribusi = distribusi_muat_data($startDate, $endDate, $idPegawai, $idUnit);
$namaFile = "distribusi-report.xls";
 $cp=profile_rumah_sakit_muat_data();
// header file excel

header_excel($namaFile);
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="9" align="center"><strong><font size="+1"><?=$cp['nama']?></font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="9" align="center"><strong><font size="+1">INFORMASI PEMBELIAN</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="9" align="center"><strong><font size="+1">PERIODE: <?= indo_tgl(isset($startDate) ? $startDate : $awal) ?> s . d <?= indo_tgl(isset($endDate) ? $endDate : $akhir) ?></font></strong></td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
</table>
<table class="tabel">
    <tr>
        <th>No</th>
        <th>No. Distribusi</th>
        <th>Tanggal</th>
        <th>Unit Tujuan</th>
        <th>Pegawai</th>
    </tr>
<?php foreach ($distribusi as $key => $row) {
?>
    <tr class="<?= ($key % 2) ? 'odd' : 'even' ?>">
        <td align="center"><?= ++$key ?></td>
        <td><?= $row['id_distribusi'] ?></td>
        <td><?= datefmysql($row['tanggal']) ?></td>
        <td class="no-wrap"><?= $row['unit_tujuan'] ?></td>
        <td><?= $row['nama_pegawai'] ?></td>
    </tr>
<?php } ?>
</table>
<?exit;?>