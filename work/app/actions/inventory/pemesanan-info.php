<?php
require 'app/lib/common/master-data.php';
require 'app/actions/admisi/pesan.php';
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/pemesanan') ?>">Pemesanan</a></h2>
<?
$bulan = date('m');
$tahun = date('Y');
echo "".isset($pesan) ? $pesan : NULL."";
$pemesanan = pemesanan_muat_data($_GET['id']);
foreach ($pemesanan as $row);
?>
<div class="data-input">
    <fieldset>
        <legend>Pemesanan</legend>
        <label>No. Surat: </label><span style="font-size: 12px; padding-top: 5px; "><?= $_GET['id']."/".$bulan."/".$tahun ?></span>
        <label>Tanggal: </label><span style="font-size: 12px; padding-top: 5px; "><?= datetime($row['waktu']) ?></span>
        <label>Suplier: </label><span style="font-size: 12px; padding-top: 5px; "><?= $row['instansi'] ?></span>
        <label>Jenis SP: </label><span style="font-size: 12px; padding-top: 5px; "><?= $row['jenis_sp'] ?></span>
    </fieldset>
</div>
<div id="tabel-barang" class="data-list">
    <fieldset>
   <legend>Detail Pemesanan: <?= $_GET['id']?></legend>
   <div class="data-list">
    <table id="tblPemesanan" class="tabel" width="35%" style="border: 1px solid #f4f4f4; float: left; width: 60%">
    <tr style="background: #F4F4F4;">
        <th style="width:5%">No</th>
        <th style="width: 40%">Nama Packing Barang</th>
        <th style="width:13%">Jumlah</th>
        <th>Kemasan</th>
    </tr>
    <?
        $i = 1;
        $pemesanan= sp_muat_data_by_id(get_value('id'));
        foreach ($pemesanan['barang'] as $barang) {
             
            $nama=nama_packing_barang(array($barang['generik'],$barang['nama_barang'],$barang['kekuatan'],$barang['sediaan'],$barang['nilai_konversi'],$barang['satuan_terkecil'],$barang['pabrik']));        
                    
            $sisa = isset ($barang['sisa'])?$barang['sisa']:0;
    ?>
         <tr class="barang_tr <?= ($i%2) ? 'odd':'even' ?>">
            <td align="center"><?= $i?></td>
            <td class="no-wrap"><?=$nama?></td>
            <td align="right"><?= $barang['jumlah_pesan']?></td>
            <td><?=$barang['satuan_terbesar']?></td>
        </tr>
    <?
        $i++;
        }
    ?>    
    </table>
    </div>   
    </fieldset>   
</div>
<div class="perpage" style="float:right">
<span class="cetak" >Cetak</span>
<a href="<?= app_base_url('inventory/report/pemesanan-info-excel/?id='.$_GET['id'].'')?>" class="excel">Cetak Excel</a>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".cetak").click(function(){
            var win = window.open('print/pemesanan?id=<?php echo $_GET['id'] ?>&jenis=<?php echo $row['jenis_sp'] ?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>