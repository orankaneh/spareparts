<?php
require 'app/lib/common/master-data.php';
require 'app/actions/admisi/pesan.php';
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/distribusi') ?>">Distribusi</a></h2>
<?
echo "".isset($pesan) ? $pesan : NULL."";
$distribusi = distribusi_muat_data_by_id($_GET['id']);
foreach ($distribusi['master'] as $master);
?>
<div class="data-input">
<fieldset>
    <legend>Data Distribusi</legend>
<table width="40%">
    <tr>
        <td width="30%">No. : <?= $_GET['id']?></td>
    </tr>
    <tr>
        <td width="30%">Unit Tujuan: <?= $master['unit']?></td>
    </tr>
    <tr>
        <td>Nama Pegawai: <?= $master['pegawai']?></td>
    </tr>
    <tr>
        <td>Waktu: <?= datetime($master['waktu'])?></td>
    </tr>
</table>
</fieldset>    
</div>    
<div class="data-list">
    <fieldset>
    <table class="tabel" style="width:60%">
        <tr>
            <th>No</th>
            <th>Nama Packing Barang</th>
            <th>No. Batch</th>
            <th>Jumlah</th>
            <th>Kemasan</th>
        </tr>
        <?
        $no = 1;
        foreach ($distribusi['detail'] as $detail){
            $nama=nama_packing_barang(array($detail['generik'],$detail['barang'],$detail['kekuatan'],$detail['sediaan'],$detail['nilai_konversi'],$detail['satuan'],$detail['pabrik']));  
        ?>
          <tr class="<?= ($no%2) ? 'odd':'even' ?>">
              <td align="center"><?= $no?></td>
              <td style="width: 40%"><?= $nama?></td>
              <td><?= $detail['batch'];?></td>
              <td style="width: 10%" align="right"><?= rupiah($detail['jumlah_distribusi'])?></td>
              <td style="width: 20%"><?= $detail['satuan']?></td>
          </tr>
        <?
        $no++;
        }
        ?>
    </table>
    </fieldset>    
</div>
<span id="cetak-kartu" class="cetak">Cetak Surat Distribusi</span>    
<script type="text/javascript">
    $(document).ready(function(){
        $('#cetak-kartu').click(function(){
            window.open('<?= app_base_url("inventory/print/cetak-distribusi/?id=$_GET[id]")?>', 'mywindow', 'location=1,status=1,scrollbars=1,width=800px');
        })
    })
</script>
