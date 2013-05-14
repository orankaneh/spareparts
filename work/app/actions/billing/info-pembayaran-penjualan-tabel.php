<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
set_time_zone();
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
?>
<table class="tabel" style="width: 80%;">
    <tr>
        <th style="width: 5%">No</th>
        <th style="width: 10%">Waktu</th>
        <th style="width: 20%">Petugas</th>
        <th style="width: 20%">Pembeli</th>
        <th style="width: 10%">Jumlah Bayar (Rp)</th>
        <th style="width: 10%">Sisa</th>
        <th style="width: 10%">Aksi</th>
    </tr>
    <?php
    $info = info_pembayaran_penjualan_muat_data($_GET['idpetugas'], $_GET['idpembeli'], $startDate, $endDate);
    foreach ($info as $key => $row):
    ?>
    <tr class="<?= ($key%2)?'odd':'even' ?>">
        <td align="center"><?= $row['id'] ?></td>
        <td align="center"><?= datetime($row['waktu']) ?></td>
        <td><?= $row['petugas'] ?></td>
        <td><?= $row['pembeli'] ?></td>
        <td align="right"><?= rupiah($row['jumlah_bayar']) ?></td>
        <td align="right"><?= rupiah($row['sisa']) ?></td>
        <td align="center"><span class="cetak" onClick="cetak(<?= $row['id'] ?>)">Cetak</span> </td>
    </tr>
    <?php endforeach; ?>
</table>
<script type="text/javascript">
    function cetak(id) {
        var win = window.open('report/info-pembayaran-penjualan?id='+id, 'MyWindow', 'width=800px,height=600px,scrollbars=1');
    }
</script>
<?php
exit;
?>