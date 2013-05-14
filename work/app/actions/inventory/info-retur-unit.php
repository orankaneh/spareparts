<?php
require 'app/lib/common/master-data.php';
require 'app/lib/common/master-inventory.php';
include 'app/actions/admisi/pesan.php';
$list_retur = retur_unit_muat_data();
?>
<h2 class="judul">Retur Unit</h2><? echo isset($pesan) ? $pesan : NULL; ?>
<div class="data-list" style="clear: left;">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Waktu</th>
            <th>Nama Pegawai</th>
            <th>Aksi</th>
        </tr>
        <?
        foreach ($list_retur as $key => $row) {
        ?>
            <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$key ?></td>
                <td><?= $row['waktu'] ?></td>
                <td><?= $row['pegawai'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('inventory/surat-retur-unit') . "?do=detail&id=$row[id]" ?>" class="detail">detail</a>
                </td>
            </tr>
        <?
        }
        ?>
    </table>
</div>
<br>
<?
        if (isset($_GET['do']) && $_GET['do'] == "detail") {
            $detail = detail_retur_unit_muat_data($_GET['id']);
?>
            <div class="data-list">
                Detail Surat Retur Unit: <?= $_GET['id'] ?>
                <table class="tabel">
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>No. Distribusi</th>
                        <th>jumlah</th>
                        <th>Alasan</th>

                    </tr>
        <?
            $total = 0;
            foreach ($detail as $key => $row) {
        ?>
                <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                    <td><?= ++$key ?></td>
                    <td><?= $row['barang'] . " " . $row['nilai_konversi'] . " " . $row['satuan'] ?></td>
                    <td>no distribusi </td>
                    <td><?= $row['jumlah_retur_penerimaan_unit'] ?></td>
                    <td><?= $row['alasan'] ?></td>
                </tr>
        <?
            }
        ?>
        </table>
    </div>
<?
        }
?>
