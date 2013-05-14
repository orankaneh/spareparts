<?php
include_once 'app/actions/admisi/pesan.php';
?>

<h2 class="judul">Retur Pembelian</h2><?= isset($pesan) ? $pesan : NULL ?>
<?php
require 'app/lib/common/master-data.php';
$list_retur = retur_muat_data();
?>
<div class="data-list" style="clear: left;">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>No. Surat</th>
            <th>Tanggal</th>
            <th>Suplier</th>
            <th>No. Faktur</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 0;
        foreach ($list_retur as $key => $row):

            if ($row['status'] == 0)
                $status = "<img src='../assets/images/icons/accept.png'>"; else
                $status = "-";
        ?>
            <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$no ?></td>
                <td align="center"><?= $row['nosurat'] ?></td>
                <td align="center"><?= $row['tgl'] ?></td>
                <td class="no-wrap"><?= $row['suplier'] ?></td>
                <td><?= $row['nofaktur'] ?></td>
                <td align="center"><?= $status ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('inventory/detail-surat-retur?noretur=' . $row['nosurat'] . '&idpembelian=' . $row['idpembelian']) ?>" class="detail"> detail</a>
                    <a href="<?= app_base_url('inventory/pengembalian-retur-barang?noretur=' . $row['nosurat']) ?>" class="detail"> pengembalian barang</a>
                    <a href="<?= app_base_url('inventory/pengembalian-retur-uang') ?>" class="detail"> pengembalian uang</a>
                </td>
            </tr>
<?php endforeach; ?>
    </table>
</div>