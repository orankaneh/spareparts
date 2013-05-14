<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
$row = tarif_muat_data($_GET['id']);
foreach($row['list'] as $num => $tarif);
?>
<style type="text/css">
fieldset{
    background:#f4f4f4;
    border:1px dotted #333;
}
legend{
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
</style>
<div class='judul'><a href='<?= app_base_url('admisi/data-tarif')?>'>Administrasi Tarif</a>  &raquo; Detail tarif</div>
<fieldset>
  <legend>Data Tarif</legend>
  <table width="100%">
      <tr>
          <td width="15%">Kode Tarif</td><td><?= $_GET['id']?></td>
      </tr>
      <tr>
          <td width="15%">Layanan</td><td><?= $tarif['layanan']?></td>
      </tr>
      <tr>
          <td width="15%">Kelas</td><td><?= $tarif['kelas']?></td>
      </tr>
      <tr>
          <td width="15%">Jasa Sarana</td><td><?= rupiah($tarif['jasa_sarana'])?></td>
      </tr>
      <tr>
          <td width="15%">B.H.P</td><td><?= rupiah($tarif['bhp'])?></td>
      </tr>
      <tr>
          <td width="15%">Total Utama</td><td><?= rupiah($tarif['total_utama'])?></td>
      </tr>
      <tr>
          <td width="15%">- Nakes Utama (%)</td><td><?= $tarif['persen_nakes_utama']?></td>
      </tr>
      <tr>
          <td width="15%">- R.S Utama (%)</td><td><?= $tarif['persen_rs_utama']?></td>
      </tr>
      <tr>
          <td width="15%">Total Pendamping</td><td><?= rupiah($tarif['total_pendamping'])?></td>
      </tr>
      <tr>
          <td width="15%">- Nakes Pendamping (%)</td><td><?= $tarif['persen_nakes_pendamping']?></td>
      </tr>
      <tr>
          <td width="15%">- R.S Pendamping (%)</td><td><?= $tarif['persen_rs_pendamping']?></td>
      </tr>
      <tr>
          <td width="15%">Total Pendukung</td><td><?= rupiah($tarif['total_pendukung'])?></td>
      </tr>
      <tr>
          <td width="15%">- Nakes Pendukung (%)</td><td><?= $tarif['persen_nakes_pendukung']?></td>
      </tr>
      <tr>
          <td width="15%">- R.S Pendukung (%)</td><td><?= $tarif['persen_rs_pendukung']?></td>
      </tr>
      <tr>
          <td width="15%">Profit (%)</td><td><?= $tarif['persen_profit']?></td>
      </tr>
      <tr>
          <td width="15%">Total Tarif</td><td><?= rupiah($tarif['total'])?></td>
      </tr>
  </table>
  <p><input type="button" value="Kembali" class="tombol" onClick=location.href="<?= app_base_url('admisi/data-tarif') ?>" /></p>
</fieldset>  