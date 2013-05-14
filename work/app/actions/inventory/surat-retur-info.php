<h2 class="judul"><a href="<?=  app_base_url('inventory/surat-retur')?>">Retur Pembelian</a></h2>
<?php
require 'app/lib/common/master-data.php';
$list_retur = retur_muat_data($_GET['id']);
foreach ($list_retur as $key => $row);
?>

<div class="data-input">
    <fieldset><legend>Surat Retur Pembelian</legend>
        <table>
            <tr><td>No. Surat:</td><td><?= $row['nosurat'] ?></td></tr>
            <tr><td>Tanggal:</td><td><?= $row['tgl'] ?></td></tr>
            <tr><td>Suplier:</td><td><?= $row['suplier'] ?></td></tr>
        </table>
    </fieldset>

</div>
<div class="data-list">
<?
    $retur=  retur_group_by_pembelian_muat_data($_GET['id']);
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
            $list=  detail_retur_muat_data($_GET['id'],$d['idpembelian']);
                $i=0;
                foreach ($list as $rows){
				
                    $i++;
                ?>    <tr class="<?= ($i%2) ? 'odd':'even' ?>">
                    <td align="center"><?= $i ?></td>
                    <td class="no-wrap"><?= $rows['barang'] ?></td>
                    <td align="center"><?=$rows['batch']?></td>
                    <td align="center"><?=$rows['jumlah_retur']?></td>
                    <td align="center"><?=$rows['jumlah_reretur']?></td>
                    <td align="center"><?=$rows['jumlah_pembelian']?></td>
                    <td align="left"><?=$rows['alasan']?></td>
                    </tr>
                <?
                }
                ?>
              </table><br>
  <? } ?>
</div>