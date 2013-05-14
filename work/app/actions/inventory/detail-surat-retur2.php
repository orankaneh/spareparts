<h2 class="judul">Detail Surat Retur</h2>
<?php
require 'app/lib/common/master-data.php';
$list_retur = retur_muat_data($_GET['noretur']);
foreach ($list_retur as $key => $row);
?>

<div class="data-input">
    <fieldset><legend>Surat Retur</legend>
        <table>
            <tr><td>No. Surat</td><td>:</td><td><?= $row['nosurat'] ?></td></tr>
            <tr><td>Tanggal</td><td>:</td><td><?= $row['tgl'] ?></td></tr>
            <tr><td>Suplier</td><td>:</td><td><?= $row['suplier'] ?></td></tr>
            <tr><td>No Faktur</td><td>:</td><td><?= $row['nofaktur'] ?></td></tr>
        </table>
    </fieldset>

</div>
<div class="data-list">
    <table class="tabel" style="width: 60%">
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>No. Batch</th>
                <th>Jumlah Retur</th>
                <th>Jumlah Beli</th>
                <th>Alasan</th>
            </tr>
            <?
                $list=  detail_retur_muat_data( $_GET['noretur'],$_GET['idpembelian']);
                $i=0;
                foreach ($list as $d){
                    $i++;
                ?>    <tr class="<?= ($i%2) ? 'odd':'even' ?>">
                    <td align="center"><?= $i ?></td>
                    <td><?= $d['barang'] ?></td>
                    <td align="center"><?=$d['no_batch']?></td>
                    <td align="center"><?=$d['jumlah_retur']?></td>
                    <td align="center"><?=$d['jumlah_pembelian']?></td>
                    <td align="left"><?=$d['alasan']?></td>
                    </tr>
                <?
                }
                ?>
    </table>
</div>
