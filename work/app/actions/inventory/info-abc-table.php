<?php
require_once 'app/lib/common/master-data.php';
$id_sub_kategori = (isset($_GET['sub_kategori'])) ? $_GET['sub_kategori'] : null;
$startDate = (isset($_GET['startDate'])) ? $_GET['startDate'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['endDate'])) ? $_GET['endDate'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$penjualan = penjualan_laporan_abc_muat_data($startDate, $endDate);
?>
<div class="data-list">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel">

        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Jual</th>
            <th>Total Harga</th>
            <th>%</th>
            <th>% Kumulatif</th>
            <th>Gol. Obat</th>
        </tr>
<?php
        $kumulatif = 0;
        if ($penjualan['total'] != null) {
        $laporan_abc = laporan_abc_muat_data($id_sub_kategori, $startDate, $endDate);
        foreach ($laporan_abc['list'] as $num => $row):
            $kumulatif = $kumulatif + ($row['persentase'] * 100);
            if ($kumulatif <= 80)
                $gol = "A";
            else if ($kumulatif > 80 and $kumulatif <= 95)
                $gol = "B";
            else
                $gol = "C";
        ?>
            <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
                <td align=center><?= ++$num ?></td>
                <td class="no-wrap"><?= $row['nama'] ?></td>
                <td class="no-wrap" align="center"><?= $row['jumlah_penjualan'] ?></td>
                <td class="no-wrap" align="right"><?= rupiah($row['harga_jual']) ?></td>
                <td align=right><?= rupiah($row['total_harga']) ?></td>
                <td align=center><?= $row['persentase'] * 100; ?></td>
                <td align=center><?= $kumulatif ?></td>
                <td align=center><?= $gol; ?></td>
            </tr>
        <?php endforeach;
        } ?>
    </table>

</div>
<?php exit ?>