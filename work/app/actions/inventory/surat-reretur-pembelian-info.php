<h2 class="judul"><a href="<?= app_base_url('inventory/surat-reretur-pembelian') ?>">Pengembalian Retur Pembelian</a></h2>
<?

require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php'; 
echo isset($pesan)?$pesan:NULL;
$reretur = reretur_muat_data($_GET['id']);
?>
<div class="data-input">
    <fieldset><legend>Form Tambah Pengembalian Retur Pembelian</legend>
        <label>Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $reretur['pegawai'] ?></span>
        <label>No. Transaksi</label><span style="font-size: 12px;padding-top: 5px;"><?= $reretur['id'] ?></span>
        <label>No. Surat Reretur</label><span style="font-size: 12px;padding-top: 5px;"><?= $reretur['no_surat'] ?></span>
        <label>Suplier</label><span style="font-size: 12px;padding-top: 5px;" id="suplier"><?=$reretur['suplier']?></span>
    </fieldset>
</div>
<?
$detail = detail_reretur_muat_data($_GET['id']);
?>
<div class="data-list">
    <table class="tabel" id="tblPembelian" cellspacing="0" cellpadding="0" style="width: 100%;">
        <tr>
            <th style="width: 2%">No</th>
            <th style="width: 40%">Nama Barang</th>
            <th style="width: 10%">No Faktur</th>
            <th style="width: 10%">No Batch</th>
            <th style="width: 5%">Jumlah Retur</th>
            <th style="width: 5%">Jumlah Reretur</th>
            <th style="width: 5%">Bentuk</th>
            <th style="width: 10%">Kemasan</th>
        </tr>
        <?
        $i = 1;
        foreach ($detail as $row) {
            $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));
            ?>
            <tr class="<?php echo ($i%2)?'even':'odd';?>">
                <td><?= $i++ ?></td>
                <td><?= $nama ?></td>
                <td align="center"><?=$row['no_faktur']?></td>
                <td align="center"><?=$row['batch_reretur']?></td>
                <td><?=$row['jumlah_retur']?></td>
                <td><?=  ($row['jumlah_reretur'])?></td>
                <td align="right"><?=$row['bentuk']?></td>
                <td align="center"><?=$row['satuan_terbesar']?></td>
            </tr>
            <?
        }
        ?>
    </table>

</div>