<?php
include_once "app/lib/common/master-data.php";
include 'app/actions/admisi/pesan.php';
set_time_zone();
$pemusnahan = pemusnahan_muat_data_by_id(get_value('id'));
$master = $pemusnahan['master'];
$waktu = waktufmysql($master['waktu']);
?>
<h2 class="judul"><a href="<?=app_base_url('inventory/pemusnahan')?>">Pemusnahan</a></h2><? echo isset($pesan) ? $pesan : NULL; ?>
<div class="data-input">
    <fieldset>
        <legend>Pemusnahan Barang</legend>
        <label for="petugas">Petugas:</label><span style="font-size: 12px;padding-top: 5px;" id="jam"><?= $master['pegawai'] ?></span>
        <label for="saksi">Saksi:</label><span style="font-size: 12px;padding-top: 5px;" id="jam"><?= $master['saksi'] ?></span>
        <label for="waktu">Tanggal:</label><span style="font-size: 12px;padding-top: 5px;"><?= $waktu['jam'] . ' ' . $waktu['tanggal'] ?></span>
    </fieldset>
</div>    
<br>
<div class="data-list">
    <table id="tblPemusnahan" width="70%" style="border: 1px solid #f4f4f4; float: left" class="tabel">
        <tr style="background: #F4F4F4;">
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Alasan</th>
            <th>No Batch</th>
        </tr>
        <?php
        $i = 1;
        foreach ($pemusnahan['detail'] as $row) {
            $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));    

            $class = ($i % 2) ? 'even' : 'odd';
            $style = "class='$class'";
        ?>
            <tr class="barang_tr <?=$class?>">
                <td align="center" class="number"><?= $i ?></td>
                <td><?= $nama ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['sisa'] ?></td>
                <td><?= $row['satuan_terkecil'] ?></td>
                <td><?= $row['alasan'] ?></td>
                <td><?= $row['batch'] ?></td>
            </tr>    
            <?php
            $i++;
        }
        ?>    
    </table>
</div>