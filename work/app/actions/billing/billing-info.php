<?php
  include 'app/actions/admisi/pesan.php';
  require_once 'app/lib/common/master-data.php';
  $billing=  billing_detail_muat_data($_GET['id']);
//  show_array($billing);
  $b=$billing['master'];
  $detail=$billing['list'];
?>
<h2 class="judul"><a href="<?=  app_base_url('billing/billing')?>">Billing</a></h2><?= isset($pesan)?$pesan:NULL?>
<div style="margin: 5px 0px;">
    <span class="cetak" id="nota">Cetak Kitir</span>
</div>
    <div class="data-input">
        <fieldset>
            <legend>Form Billing</legend>
            <label for="nama">Nama Pasien</label><span style="font-size: 12px;padding-top: 5px;"><?=$b['penduduk']?></span>
            <label for="alamat">Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"><?=$b['alamat']?></span>
            <label for="noRm">No. RM</label><span style="font-size: 12px;padding-top: 5px;" class="noRm"><?=$b['norm']?></span>
            <label for="billing">No. Billing</label><span style="font-size: 12px;padding-top: 5px;" class="noBilling"><?=$b['id']?></span>
        </fieldset>
    </div>
<div id="billing-aktif" class="data-list">
    <table id="tblBilling" class="tabel" style="border: 1px solid #f4f4f4; float: left; width: 80%">
        <tr style="background: #F4F4F4;">
            <th style="width: 5%;" align="center">No</th>
            <th style="width: 30%;"  align="center">Nama Tarif</th>
            <th style="width: 10%" align="center">Harga</th>
            <th style="width: 5%;" align="center">Frekuensi</th>
            <th style="width: 15%" align="left">Nakes 1</th>
            <th style="width: 15%" align="left">Nakes 2</th>
            <th style="width: 15%" align="left">Nakes 3</th>
        </tr>
        <?
        $no = 1;
        $jumlah=0;
        foreach ($detail as $row) {
            $jumlah+=($row['total']*$row['frekuensi']);
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
                <td class="no-wrap" align="<?= ($row['nakes1'] == null || $row['nakes1'] ? 'center' : 'left') ?>"><?= ($row['nakes1'] != null && $row['nakes1'] != '') ? $row['nakes1'] : '-' ?></td>
                <td class="no-wrap" align="<?= ($row['nakes2'] == null || $row['nakes2'] ? 'center' : 'left') ?>"><?= ($row['nakes2'] != null && $row['nakes2'] != '') ? $row['nakes2'] : '-' ?></td>
                <td class="no-wrap" align="<?= ($row['nakes3'] == null || $row['nakes3'] ? 'center' : 'left') ?>"><?= ($row['nakes3'] != null && $row['nakes3'] != '') ? $row['nakes3'] : '-' ?></td>
                    </tr>
<?
        }
?>
 <tr style="border: none;">
 <td colspan="2" align="right" style="border: none;"><?="Total : "?></td>
 <td colspan="1"  align="right" style="border: none;"><?=rupiah($jumlah)?></td>
 </tr>
            </table>
        </div>
<script type="text/javascript">
	$(function(){
		$("#nota").click(function(){
			var win = window.open('print/nota-billing?id=<?=$_GET['id']?>&cara=<?=$_GET['cara']?>&idKunjungan=<?=$_GET['idKunjungan']?>', 'MyWindow', 'width=600px, height=500px, scrollbars=1');
		})
	})
</script>