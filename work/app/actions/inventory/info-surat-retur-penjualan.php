<?php
require 'app/lib/common/master-data.php';
require 'app/lib/common/master-inventory.php';
$list_retur = retur_penjualan_muat_data();
?>
<h2 class="judul">Retur Penjualan</h2>
<div class="data-list" style="clear: left;">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Waktu</th>
            <th>Nama Pegawai</th>
            <th>Aksi</th>
        </tr>
        <?
        foreach ($list_retur as $key => $row){
        ?>
        <tr class="<?= ($key%2) ? 'even':'odd' ?>">
            <td align="center"><?= ++$key?></td>
            <td><?= $row['waktu']?></td>
            <td><?= $row['pegawai']?></td>
            <td class="aksi">
                <a href="<?= app_base_url('inventory/info-surat-retur-penjualan')."?do=detail&id=$row[id]" ?>" class="detail">detail</a>
            </td>
        </tr>
        <?
        }
        ?>
    </table>
</div>
<br>
<?
if(isset ($_GET['do']) && $_GET['do'] == "detail"){
    $detail = detail_retur_penjualan_muat_data($_GET['id']);
?>
   <div class="data-list">
   Detail Surat Retur Penjualan: <?=$_GET['id']?>
   <table class="tabel">
        <tr>
            <th>No</th>
            <th>Nama Packing Barang</th>
            <th>jumlah</th>
            <th>Alasan</th>
            <th>Harga</th>
            <th>Sub Total</th>
        </tr>
        <?
        $total = 0;
        foreach ($detail as $key => $row){
        $harga = ($row['hna']*$row['margin']/100)+$row['hna'];
        $subtotal = $harga * $row['jumlah_retur'];
        $total += $subtotal; 
        ?>
        <tr class="<?= ($key%2) ? 'even':'odd' ?>">
            <td><?= ++$key?></td>
            <td><?= $row['barang']." ".$row['nilai_konversi']." ".$row['satuan']?></td>
            <td><?= $row['jumlah_retur']?></td>
            <td><?= $row['alasan']?></td>
            <td><?= rupiah($harga)?></td>
            <td><?= rupiah($subtotal)?></td>
        </tr>
        <?
        }
        ?>
        <tr>
                    <td colspan="5" align="center">Total</td>
                    <td><?= rupiah($total)?></td>
                </tr>
  </table>
  </div>     
<?
}
?>