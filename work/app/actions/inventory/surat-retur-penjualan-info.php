<h2 class="judul"><a href="<?=app_base_url('inventory/surat-retur-penjualan')?>">Retur Penjualan</a></h2><?= isset ($pesan)?$pesan:NULL?>
<div style="margin: 5px 0px;">
    <span class="cetak" id="kitir">Kitir</span>
</div>
<?
require 'app/lib/common/master-data.php';
require 'app/lib/common/master-inventory.php';
$retur = retur_penjualan_muat_data($_GET['id']);
$retur=$retur[0];
$detail = detail_retur_penjualan_muat_data($_GET['id']);
?>
<div class="data-input">
    <fieldset><legend>Form Tambah Retur Penjualan</legend>
        <label for="pegawai">Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $retur['pegawai']?></span>
        <label for="no-surat">No. Surat</label><span style="font-size: 12px;padding-top: 5px;"><?= $retur['id']?></span>
        <label for="pembeli">Pembeli</label><span style="font-size: 12px;padding-top: 5px;"><?= $retur['pembeli']?></span>
    </fieldset>
</div>    
<div class="data-list">
<table id="tblPemesanan" width="100%" class="tabel" style="border: 1px solid #f4f4f4; float: left">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th style="width: 25%">Nama Packing Barang</th>
        <th>No. Nota</th>
        <th>Jumlah</th>
        <th>Alasan</th>
        <th>Harga</th>
        <th>Sub Total</th>
    </tr>
     <?php 
     $i=1;
     $jumlah=0;
     foreach ($detail as $d) { 
         $jumlah+=(($d['hna']*$d['margin']/100)+$d['hna'])*$d['jumlah_retur'];                             
            $nama=nama_packing_barang(array($d['generik'],$d['barang'],$d['kekuatan'],$d['sediaan'],$d['nilai_konversi'],$d['satuan'],$d['pabrik']));
         ?>
    <tr class="barang_tr <?=($i%2==1)?'odd':'even'?>">
        <td align="center"><?= $i?></td>
        <td align="left"><?=$nama?></td>
        <td align="center"><?=$d['no_nota']?></td>
        <td align="center"><?=$d['jumlah_retur']?></td>
        <td align="center"><?=$d['alasan']?></td>
        <td align="right"><?=rupiah(($d['hna']*$d['margin']/100)+$d['hna'])?></td>
        <td align="right"><?=rupiah((($d['hna']*$d['margin']/100)+$d['hna'])*$d['jumlah_retur'])?></td>
    </tr>
    <?}?>
</table>    
</div>
<span style="position: relative;float: left;clear: left;padding-top: 10px;left: 900px">
    <table width="100%">
        <tr>
            <td>Total</td><td>:</td><td align="right"><?=rupiah($jumlah)?></td>
        </tr>
    </table>
</span>    
<script type="text/javascript">
	$(function(){
		$("#kitir").click(function(){
			var win = window.open('print/kitir-retur-penjualan?id=<?=$_GET['id']?>', 'MyWindow', 'width=600px, height=500px, scrollbars=1');
		})
	})
</script>
