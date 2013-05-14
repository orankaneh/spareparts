<?
require 'app/lib/common/master-inventory.php';
require 'app/actions/admisi/pesan.php';
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/pemakaian') ?>">Pemakaian</a></h2>
<?php
  echo "$pesan";
  $pemakaian = pemakaian_muat_data($_GET['id']);
//  show_array($pemakaian['detail']);
  foreach ($pemakaian['master'] as $row);
?>
<div class="data-input">
    <fieldset>
        <legend>Pemakaian</legend>
        <label for="petugas">Petugas</label><span style="font-size: 12px;padding-top: 5px;"><?= $row['penduduk'] ?></span>
        <label for="unit">Unit</label><input type="text" style="border: none;" readonly="readonly" value="<?= $row['unit']?>"/>
        <label for="waktu">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= datetime($row['waktu']) ?></span>
    </fieldset>
</div>
<div class="data-list">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Nama Packing Barang</th>
            <th>No. Batch</th>
            <th>Jumlah</th>
        </tr>
        <?php
        $no = 1;
        foreach ($pemakaian['detail'] as $rows){
        $nama=nama_packing_barang(array($rows['generik'],$rows['barang'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan_terkecil'],$rows['pabrik']));
        ?>
        <tr class="<?php echo ($no%2)?"even":"odd";?>">
            <td><?php echo $no++;?></td>
            <td><?php echo $nama?></td>
            <td><?php echo $rows['batch']?></td>
            <td><?php echo $rows['jumlah']?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>