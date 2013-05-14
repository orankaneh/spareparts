<?php
  include 'app/actions/admisi/pesan.php';
  require_once 'app/lib/common/master-data.php';
  
  $discharge= pasien_discharge_detail_muat_data($_GET['id']);
  
//  show_array($discharge);
  $b=$discharge['master'];
  $detail=$discharge['list'];
?>
<h2 class="judul"><a href="<?=  app_base_url('billing/pasien-discharge')?>">Pasien Discharge</a></h2><?= isset($pesan)?$pesan:NULL?>
    <div class="data-input">
        <fieldset>
            <legend>Pasien Discharge</legend>
            <label for="nama">Nama Pasien</label><span style="font-size: 12px;padding-top: 5px;"><?=$b['penduduk']?></span>
            <label for="alamat">Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"><?=$b['alamat']?></span>
            <label for="noRm">No. RM</label><span style="font-size: 12px;padding-top: 5px;" class="noRm"><?=$b['norm']?></span>
            <label for="billing">No. Billing</label><span style="font-size: 12px;padding-top: 5px;" class="noBilling"><?=$b['id']?></span>
            <label for="billing">Alasan</label><span style="font-size: 12px;padding-top: 5px;" class="noBilling"><?=$b['alasan_keluar']?></span>
        </fieldset>
    </div>
<div id="billing-aktif" class="data-list">
    <table id="tblBilling" class="tabel" style="border: 1px solid #f4f4f4; float: left; width: 80%">
        <tr style="background: #F4F4F4;">
            <th style="width: 2%;" align="center">No</th>
            <th style="width: 30%;"  align="center">Nama Tarif</th>
            <th style="width: 10%" align="center">Harga</th>
            <th style="width: 5%;" align="center">Frekuensi</th>
        </tr>
        <?
        $no = 1;
        $jumlah=0;
        foreach ($detail as $row) {
            $jumlah+=$row['total'];
            $bobot=($row['bobot'] == 'Tanpa Bobot')?"":$row['bobot'];
            $profesi=($row['profesi'] == 'Tanpa Profesi')?"":$row['profesi'];
            $spesialisasi=($row['spesialisasi'] == 'Tanpa Spesialisasi')?"":$row['spesialisasi'];
            $layanans=($row['jenis'] == "Rawat Inap")?"$row[layanan] $row[instalasi]":$row['layanan'];
            $kelas=($row['id_kelas']!='1')?" ".$row['kelas']:'';
            $layanan = "$layanans $bobot $profesi $spesialisasi $kelas";
        ?>
            <tr class="<?= ($no % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $no++ ?></td>
                <td><?=$layanan ?></td>
                <td align="right"><?= rupiah($row['total']) ?></td>
                <td align="center"><?= $row['frekuensi'] ?></td>
                    </tr>
<?
        }
?>
            </table>
        </div>
<?="Total : ".rupiah($jumlah)?>