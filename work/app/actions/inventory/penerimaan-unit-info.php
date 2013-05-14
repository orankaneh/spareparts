<?php
require 'app/lib/common/master-inventory.php';
require 'app/actions/admisi/pesan.php';
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/penerimaan-unit') ?>">Penerimaan Unit</a></h2>
<?
echo "".isset($pesan) ? $pesan : NULL."";
$penerimaan = penerimaan_unit_muat_data_by_id($_GET['id']);
//show_array($penerimaan['master']);
foreach ($penerimaan['master'] as $master);
?>
<div class="data-input">
    <fieldset>
        <legend>Data Penerimaan Unit</legend>
        <table width="40%">
            <tr>
                <td width="30%">No. Penerimaan Unit:</td>
                <td><?= $master['id']?></td>
            </tr>
            <tr>
                <td width="30%">Nama Pegawai:</td>
                <td><?= $master['pegawai']?></td>
            </tr>
            <tr>
                <td width="30%">No. Distribusi:</td>
                <td><?= $master['id_distribusi']?></td>
            </tr>
            <tr>
                <td width="30%">Waktu:</td>
                <td><?= datetime($master['waktu'])?></td>
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
        foreach ($penerimaan['detail'] as $detail){
            $nama=nama_packing_barang(array($detail['generik'],$detail['barang'],$detail['kekuatan'],$detail['sediaan'],$detail['nilai_konversi'],$detail['satuan'],$detail['pabrik']));  
        ?>
          <tr class="<?= ($no%2) ? 'odd':'even' ?>">
              <td align="center"><?= $no?></td>
              <td style="width: 40%"><?= $nama?></td>
              <td><?= $detail['batch'];?></td>
              <td style="width: 10%" align="center"><?= $detail['jumlah_penerimaan_unit']?></td>
              <td style="width: 20%"><?= $detail['kemasan']?></td>
          </tr>
        <?
        $no++;
        }
        ?>
    </table>
    </fieldset>    
</div>