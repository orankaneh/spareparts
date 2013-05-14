<?
require 'app/lib/common/master-data.php';
require 'app/actions/admisi/pesan.php';
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/pembelian') ?>">Pembelian</a></h2>
<?=
isset($pesan) ? $pesan : NULL;
$pembelian = pembelian_muat_data2($_GET['idPembelian']);
?>
<div  class="data-input">
    <fieldset><legend>Pembelian</legend>
        <label for="nosp">No. Pembelian: </label><span style="font-size: 12px; padding-top: 5px; "><?= $_GET['idPembelian'] ?></span>
        <label for="suplier">Suplier: </label><span style="font-size: 12px; padding-top: 5px; "><?= $pembelian['suplier'] ?></span>
        <label for="nofaktur">No. Faktur: </label><span style="font-size: 12px; padding-top: 5px; "><?= $pembelian['no_faktur'] ?></span>
        <label for="tanggal">Tanggal: </label><span style="font-size: 12px; padding-top: 5px; "><?= datefmysql($pembelian['waktu']) ?></span>
        <label for="ppn">PPN: </label><span style="font-size: 12px; padding-top: 5px; "><?= $pembelian['ppn'] . " %" ?></span>
        <label for="materai">Biaya Materai: </label><span style="font-size: 12px; padding-top: 5px; "><?= rupiah($pembelian['materai']) ?></span>
        <label for="tempo">Tanggal Jatuh Tempo: </label><span style="font-size: 12px; padding-top: 5px; "><?= datefmysql($pembelian['tanggal_jatuh_tempo']) ?></span>
    </fieldset>
</div>
<div id="tabel-barang" class="data-list">
    <?
    if (isset($_GET['idPembelian']) && $_GET['idPembelian'] != "") {
        $detail = detail_pembelian_muat_data($_GET['idPembelian']);
    ?>
        Detail Pembelian: <?= $_GET['idPembelian'] ?>
        <div class="data-list">
            <table class="tabel" style="width:80%">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>No Batch</th>
                    <th>E.D.</th>
                    <th>Jumlah</th>
                    <th>Harga (Rp)</th>
                    <th>Disc (%)</th>
					<th>Subtotal (Rp)</th>
                </tr>
            <?php
            $total=0;
            foreach ($detail as $num => $rows) {                   
                    $nama=nama_packing_barang(array($rows['generik'],$rows['nama'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan_terkecil'],$rows['pabrik']));   
               
                $class = ($num % 2) ? 'even' : 'odd';
                $style = "class='$class'";
				$subtotal = $rows['harga_pembelian']*($rows['jumlah_pembelian']-($rows['jumlah_pembelian']*$rows['diskon']/100));
				$total = $total + $subtotal;
            ?>
                <tr <?= $style ?>>
                    <td align="center"><?= ++$num ?></td>
                    <td class="no-wrap" style="width: 50%"><?=$nama?></td>
                    <td><?= $rows['batch'] ?></td>
                    <td><?= datefmysql($rows['ed']) ?></td>
                    <td style="width: 10%"><?= $rows['jumlah_pembelian'] ?></td>
                    <td class="no-wrap" align="right"><?= rupiah($rows['harga_pembelian']) ?></td>
                    <td align="center"><?= $rows['diskon'] ?></td>
					<td style="text-align: right;"><?= rupiah($subtotal);?></td>
            </tr>
            <?php
                }
            ?>
            </table>
        </div>
        <span style="position: relative;float: left; padding-top: 10px;width: 80%">
            <table style="float:right">
                <tr>
                    <td width="105px">Total</td><td>: </td><td align="right"><?=rupiah($total)?></td>
                </tr>
                <tr>
                    <td width="105px">PPN (Rp)</td><td>: </td><td align="right"><?=rupiah($pembelian['ppn']*$total/100)?></td>
                </tr>
                <tr>
                    <td width="105px">Materai (Rp.)</td><td>: </td><td align="right"><?=rupiah($pembelian['materai'])?></td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #cccccc; ">Total Bayar (Rp.)</td><td>: </td><td style="border-top: 1px solid #cccccc; " width="110px" id="bayar" align="right"><?=rupiah($total+$pembelian['ppn']*$total/100+$pembelian['materai'])?></td>
                </tr>
            </table>
        </span>    
    <?
            }
    ?>
</div>

