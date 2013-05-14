<? include 'app/actions/admisi/pesan.php'; ?>
<h2 class="judul"><a href="<?= app_base_url('inventory/surat-retur-pembelian') ?>">Retur Pembelian</a></h2>
<?php echo isset($pesan)?$pesan:NULL;?>
<?php
require 'app/lib/common/master-data.php';
$list_retur = retur_muat_data($_GET['id']);
foreach ($list_retur as $key => $row)
    ;
?>

<div class="data-input">
    <fieldset><legend>Surat Retur Pembelian</legend>
        <table>
            <tr><td>No. Surat</td><td>:</td><td><?= $row['nosurat'] ?></td></tr>
            <tr><td>Tanggal</td><td>:</td><td><?= ($row['waktu']) ?></td></tr>
            <tr><td>Suplier</td><td>:</td><td><?= $row['suplier'] ?></td></tr>
        </table>
    </fieldset>

</div>
<div class="data-list">
    <table class="tabel" style="width: 60%">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Batch</th>
            <th>No Faktur</th>
            <th>Jumlah Retur</th>
            <th>Jumlah Reretur</th>
            <th>Alasan</th>
        </tr>
        <?
        $list = detail_retur_muat_data($_GET['id']);
        $i = 0;
        foreach ($list as $row) {
           
            $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));  
            
            $i++;
            ?>    <tr class="<?= ($i % 2) ? 'odd' : 'even' ?>">
                <td align="center"><?= $i ?></td>
                <td class="no-wrap"><?= $nama ?></td>
                <td align="center"><?= $row['batch_retur'] ?></td>
                <td align="center"><?= $row['no_faktur'] ?></td>
                <td align="center"><?= $row['jumlah_retur'] ?></td>
                <td align="center"><?= $row['jumlah_reretur'] ?></td>
                <td align="left"><?= $row['alasan'] ?></td>
            </tr>
            <?
        }
        ?>
    </table><br>
</div>