<?
require 'app/lib/common/master-data.php';
require 'app/actions/admisi/pesan.php';
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/produksi') ?>">Produksi</a></h2>
<?=
isset($pesan) ? $pesan : NULL;
$produksi = produksi_muat_data($_GET['idProduksi']);
?>
<div  class="data-input">
    <fieldset>
        <legend>Produksi</legend>
        <label for="nopr">No. Produksi: </label><span style="font-size: 12px; padding-top: 5px; "><?= $_GET['idProduksi'] ?></span>
        <label for="hssil">Nama Barang Hasil: </label><span style="font-size: 12px; padding-top: 5px; "><?= $produksi['barang']." ".$produksi['power'] ." @ ".$produksi['nilai']." ".$produksi['satuan1']?></span>
         <label for="Jumlah">Jumlah: </label><span style="font-size: 12px; padding-top: 5px; "><?= $produksi['jumlah'] ?></span>
        <label for="Petugas">Petugas: </label><span style="font-size: 12px; padding-top: 5px; "><?= $produksi['pegawai'] ?></span>
    </fieldset>
</div>
<div id="tabel-barang" class="data-list">
    <?
    if (isset($_GET['idProduksi']) && $_GET['idProduksi'] != "") {
        $detail = detail_produksi_muat_data($_GET['idProduksi']);
    ?>
        Detail produksi: <?= $_GET['idProduksi'] ?>
        <div class="data-list">
            <table class="tabel">
                <tr>
                    <th>No</th>
                    <th>Nama Barang Input</th>
                    <th>Jumlah</th>
                </tr>
            <?php
            $total=0;
            foreach ($detail as $num => $rows) {
               $nama=nama_packing_barang(array($rows['generik'],$rows['baranginput'],$rows['power'],$rows['sediaan'],$rows['nilai'],$rows['satuan'],$rows['pabrik'])); 
                $class = ($num % 2) ? 'even' : 'odd';
                $style = "class='$class'";
			//	$subtotal = $rows['harga_produksi']*($rows['jumlah_produksi']-($rows['jumlah_produksi']*$rows['diskon']/100));
				//$total = $total + $subtotal;
            ?>
                <tr <?= $style ?>>
                    <td align="center"><?= ++$num ?></td>
                    <td class="no-wrap" style="width: 50%"><?=$nama?></td>
                    <td style="width: 10%"><?= $rows['jumlah_produksi'] ?></td>
            </tr>
            <?php
                }
            ?>
            </table>
        </div>
  <!--  <span style="position: relative;float: right; padding-top: 10px;width: 23%">
            <table style="float:right">
                <tr>
                    <td width="105px">Total</td><td>: </td><td align="right"><?=rupiah($total)?></td>
                </tr>
                <tr>
                    <td width="105px">PPN (Rp)</td><td>: </td><td align="right"><?=rupiah($produksi['ppn']*$total/100)?></td>
                </tr>
                <tr>
                    <td width="105px">Materai (Rp.)</td><td>: </td><td align="right"><?=rupiah($produksi['materai'])?></td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #cccccc; ">Total Bayar (Rp.)</td><td>: </td><td style="border-top: 1px solid #cccccc; " width="110px" id="bayar" align="right"><?=rupiah($total+$produksi['ppn']*$total/100+$produksi['materai'])?></td>
                </tr>
            </table>
        </span>    
        -->
    <?
            }
    ?>
</div>
