<?
include 'app/actions/admisi/pesan.php';
require 'app/lib/common/master-data.php';
require 'app/lib/common/master-inventory.php';
set_time_zone();
$id=$_GET['id'];
$retur=retur_unit_muat_data($id);
$detail=detail_retur_unit_muat_data($id);
$waktu=waktufmysql($retur['waktu']);
?>
<h2 class="judul"><a href="<?=  app_base_url('inventory/surat-retur-unit')?>">Retur Unit</a></h2><? echo isset($pesan) ? $pesan : NULL; ?>
    <div class="data-input">
        <fieldset><legend>Form Tambah Retur</legend>
            <label for="waktu">Tanggal:</label><span style="font-size: 12px;padding-top: 5px;"><?= "$waktu[tanggal] $waktu[jam]"?></span>
            <label for="waktu">Pegawai:</label><span style="font-size: 12px;padding-top: 5px;"><?= $retur['pegawai'] ?></span>
            <label for="no-surat">No Transaksi:</label><span style="font-size: 12px;padding-top: 5px;"><?= $retur['id'] ?></span>
        </fieldset>
    </div>
    <div class="data-list">
    <table id="tblPemesanan" class="tabel" style="border: 1px solid #f4f4f4; float: left">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>No. Penerimaan</th>
            <th>No. Batch</th>
            <th>Jumlah</th>
            <th style="width:120px">Kemasan</th>
            <th>Alasan</th>
        </tr>
        <?php
        $i=1;
        foreach ($detail as $barang){           
            $nama=nama_packing_barang(array($barang['generik'],$barang['barang'],$barang['kekuatan'],$barang['sediaan'],$barang['nilai_konversi'],$barang['satuan'],$barang['pabrik']));
        ?>
            <tr class="barang_tr <?=($i%2==0)?'even':'odd'?>">
                <td align="center"><?= $i++ ?></td>
                <td class="no-wrap"><?=$nama?></td>
                <td align="center"><?=$barang['id_penerimaan_unit']?></td>
                <td><?=$barang['batch']?></td>
                <td align="center"><?=$barang['jumlah_retur_penerimaan_unit']?></td>
                <td align="center"><?=$barang['satuan_terbesar']?></td>
                <td align="center"><?=$barang['alasan']?></td>
            </tr>
            <script type="text/javascript">initAutocomplete(<?= $i ?>);</script>
        <? } ?>
    </table>
    </div>