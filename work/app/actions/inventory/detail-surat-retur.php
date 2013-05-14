<h2 class="judul">Detail Retur Pembelian</h2>
<?php
require 'app/lib/common/master-data.php';
$list_retur = retur_muat_data($_GET['noretur']);
foreach ($list_retur as $key => $row);
?>

<div class="data-input">
    <fieldset><legend>Surat Retur Pembelian</legend>
        <table>
            <tr><td>No. Surat</td><td>:</td><td><?= $row['nosurat'] ?></td></tr>
            <tr><td>Tanggal</td><td>:</td><td><?= $row['tgl'] ?></td></tr>
            <tr><td>Suplier</td><td>:</td><td><?= $row['suplier'] ?></td></tr>
        </table>
    </fieldset>
    
</div>
<div class="data-list">
<?
    $retur=  retur_group_by_pembelian_muat_data($_GET['noretur']);
    foreach($retur as $d){
        ?>
            No Faktur: <?=$d['no_faktur']?>
            <table class="tabel" style="width: 60%">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Batch</th>
                <th>Jumlah Retur</th>
                <th>Jumlah Reretur</th>
                <th>Jumlah Pembelian</th>
                <th>Alasan</th>
            </tr>
        <?
            $list=  detail_retur_muat_data( $_GET['noretur'],$d['idpembelian']);
                $i=0;
                foreach ($list as $d){
                    $i++;
                ?>    <tr class="<?= ($i%2) ? 'odd':'even' ?>">
                    <td align="center"><?= $i ?></td>
                    <td class="no-wrap"><?= $d['barang'] ?></td>
                    <td align="center"><?=$d['batch']?></td>
                    <td align="center"><?=$d['jumlah_retur']?></td>
                    <td align="center"><?=$d['jumlah_reretur']?></td>
                    <td align="center"><?=$d['jumlah_pembelian']?></td>
                    <td align="left"><?=$d['alasan']?></td>
                    </tr>
                <?
                }
                ?>
              </table><br>
              <?
    }
?>

    
    
</div>
<input type="button" value="Kembali" onClick="javascript:location.href='<?= app_base_url('inventory/info-surat-retur')?>'" class="tombol">
