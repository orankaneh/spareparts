<?php
require 'app/lib/common/master-data.php';
require 'app/actions/admisi/pesan.php';
?>
<h2 class="judul"><a href="<?= app_base_url('admisi/kepesertaan-asuransi') ?>">Kepesertaan Asuransi</a></h2>
<?
echo "".isset($pesan) ? $pesan : NULL."";
$kunjungan = detail_kunjungan_muat_data($_GET['idKunjungan']);
foreach ($kunjungan as $rows);
$kepesertaanAsuransi = kepesertaan_asuransi($_GET['idKunjungan']);
?>
<style type="text/css">
       legend {
		font-size:8px;
		font-weight:bold;
		text-transform:uppercase;
		background:#f1f1f1;
		border-top:1px dotted #333;
		border-left:1px dotted #333;
		border-right:1px dotted #333;
		padding:3px;
		background:#ddd;
	}
	fieldset {
		background:#f4f4f4;
		border:1px dotted #333;
	}
	.noborder {
		border:none;
		background:none;
	}
</style>
<div class="data-input">
    <fieldset>
        <legend>Data Pasien</legend>
        <table width="40%">
            <tr>
                <td style="width: 40%">Nama Pasien</td><td>: <?= $rows['namaPasien']?></td>
            </tr>
            <tr>
                <td>Alamat</td><td>: <?= $rows['alamatPasien']?></td>
            </tr>
            <tr>
                <td>Kelurahan</td><td>: <?= $rows['kelurahanPasien']?></td>
            </tr>
        </table>
        <fieldset>
            <legend style="font-size: 8px">Kepesertaan Asuransi</legend>
            <table width="40%">
                <?php
                  foreach ($kepesertaanAsuransi as $row){
                ?>
                  <tr>
                      <td style="width: 40%">Nama Produk Asuransi</td><td>: <?= $row['nama_asuransi']?></td>
                      <td>No. Polis</td><td>: <?= $row['no_polis']?></td>
                  </tr>
                <?php
                  }
                ?>
            </table>
        </fieldset>
    </fieldset>
</div>