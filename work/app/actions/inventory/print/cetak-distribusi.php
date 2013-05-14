<html>
    <head>
        <title>Cetak Distribusi</title>
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css') ?>" media="all" />
        <style type="text/css">
            *{
                font-size:12px;
            }
            div{
                font-family: arial;

            }
            table.bordertabel{
                margin-top: 10px;
                border-top: 1px solid #000000;
                border-left: 1px solid #000000;
            }



            .bordertabel td,.bordertabel th{
                padding: 2px;       
                border-bottom: 1px solid #000000;
                border-right: 1px solid #000000;
            }

             .bordertabel td.noborder{
                border-right: 0;
            }
        </style>
    </head> 
    <body>
<?php
require_once 'app/config/db.php';
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';

$id = isset ($_GET['id'])?$_GET['id']:NULL;
$distribusi = distribusi_muat_data_by_id($id);
//show_array($distribusi);
foreach ($distribusi['master'] as $master);
?>
<? require_once 'app/actions/admisi/lembar-header.php'; ?>
<div class="body-nota">
    <table width="100%">
        <tr>
            <td width="30%">No. Distribusi: <?= $_GET['id']?></td>
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
</div>
<div class="body-nota">
    <table width="100%" class="bordertabel">
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
            $nama = "$detail[barang]";
            if ($detail['generik'] == 'Generik') {
                $nama.= ( $detail['kekuatan'] != 0) ? " $detail[kekuatan], $detail[sediaan]" : " $detail[sediaan]";
            }
            if ($detail['generik'] == 'Non Generik') {
                $nama.= $detail['kekuatan'];
            }
            $nama.=" @$detail[nilai_konversi] $detail[satuan]";
            $nama.= ( $detail['generik'] == 'Generik') ? ' ' . $detail['pabrik'] : ''; 
        ?>
          <tr class="<?= ($no%2) ? 'odd':'even' ?>">
              <td align="center"><?= $no?></td>
              <td style="width: 40%"><?=$nama;?></td>
              <td><?= $detail['batch'];?></td>
              <td style="width: 10%" align="center"><?= rupiah($detail['jumlah_distribusi'])?></td>
              <td style="width: 20%"><?= $detail['satuan']?></td>
          </tr>
        <?
        $no++;
        }
        ?>
    </table>
</div>
<p><span id="SCETAK"><input type="button" class="tombol" value="Cetak" onClick="cetak()"/></span></p>
<script type="text/javascript">
	function cetak() {
		SCETAK.innerHTML = '';
		window.print();
		if (confirm('Apakah menu print ini akan ditutup?')) {
			window.close();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
	}
</script>
</body>
</html>
<?
  exit();
?>
