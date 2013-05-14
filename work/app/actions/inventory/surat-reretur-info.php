<h2 class="judul"><a href="<?=app_base_url('inventory/surat-reretur')?>">Reretur Pembelian</a></h2><?= tampilkan_pesan(); ?>
<?php
require 'app/lib/common/master-data.php';
$reretur = reretur_muat_data($_GET['id']);
$detail_reretur=  detail_reretur_muat_data($_GET['id']);
?>
<div class="data-input">
    <fieldset><legend>Form Tambah Retur Pembelian</legend>
        <label for="pegawai">Pegawai:</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?></span>
        <label for="pegawai">No. Transaksi:</label><span style="font-size: 12px; padding-top: 5px; "><?= $reretur[0]['id'] ?></span>
        <label for="pegawai">No. Surat:</label><span style="font-size: 12px; padding-top: 5px; "><? $reretur[0]['no_surat'] ?></span>
    </fieldset>
</div>
<table id="tblPemesanan" class="tabel">
    <tr>
        <th style="width: 2%">No</th>
        <th style="width: 40%">Nama Barang</th>
        <th style="width: 10%">No Retur</th>
        <th style="width: 5%">Jumlah</th>
        <th style="width: 5%">Harga</th>
        <th style="width: 10%">Kemasan</th>
    </tr>
    <?php 
    $i=1;
    foreach ($detail_reretur as $rows) {
                $nama = "$rows[barang]";
                if (($rows['generik'] == 'Generik') || ($rows['generik'] == 'Non Generik')) {
                    $nama.= ( $rows['kekuatan'] != 0) ? " $rows[kekuatan], $rows[sediaan]" : " $rows[sediaan]";
                }
                $nama .=" @$rows[nilai_konversi] $rows[satuan_terkecil]";
                $nama.= ( $rows['generik'] == 'Generik') ? ' ' . $rows['pabrik'] : '';
                $class = ($i % 2) ? 'even' : 'odd';
                $style = "class='$class'";
        ?>
        <tr class="barang_tr <?= ($i % 2) ? 'even' : 'odd' ?>">
            <td align="center"><?= $i++ ?></td>
            <td align="center"><?=$nama?></td>
            <td align="center"><?=$rows['id_retur_pembelian']?></td>
            <td align="center"><?=$rows['jumlah_reretur']?></td>
            <td align="center"><?=$rows['harga_reretur_pembelian']?></td>
            <td align="center"><?=$rows['satuan_terbesar']?></td>
        </tr>
        <script type="text/javascript">initAutocomplete(<?= $i ?>);</script>
    <? } ?>
</table>