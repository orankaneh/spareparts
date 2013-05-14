<?php
require_once "app/lib/distribusi_pf.php";
$nmr_sp = no_sp();
$kode_pf = kd_pf();
$data_pf = data_distribusi_pf();
?>
<h1>INPUT DAN EDIT DATA DETIL PEMESANAN PF</h1>
<div class="data-input">
<form action="<?= app_base_url('/pf/inventory/permintaan_distribusi_pf') ?>" method="post">
  <fieldset>
    <legend>Input Data</legend>
    <label for="no_sp">No. SP</label>
	<select name="no_sp">
	  <option value="">Pilih..</option>
	  <? foreach($nmr_sp as $nsp):?>
	  <option value="<?= $nsp['id']?>"><?= $nsp['no']?></option>
	  <? endforeach?>
	</select>
	<label for="kode_pf">Kode PF</label>
	<select name="kode_pf">
	  <option value="">Pilih..</option>
	  <? foreach($kode_pf as $kd):?>
	  <option value="<?= $kd['id']?>"><?= $kd['kode']?></option>
	  <? endforeach?>
	</select>
	<label for="jumlah">Jumlah</label>
	<input type="text" name="jumlah" size="35">
	<label for="leadTime">Lead Time</label>
	<input type="text" name="leadTime" size="35"> 
	<fieldset>
	  <input type="submit" value="Tambah">
	  <input type="reset" value="Keluar">
	</fieldset>
  </fieldset>
</form>
</div>
<div class="data-list">
  <table>
    <caption>Data Permintaan Distribusi PF</caption>
    <thead>
	  <tr>
	    <th>No</th>
		<th>Nama PF</th>
		<th>Satuan</th>
		<th>Kemasan</th>
		<th>Macam Sediaan</th>
		<th>Kekuatan</th>
		<th>Jumlah</th>
		<th>Lead Time</th>
		<th>Aksi</th>
	  </tr>
	</thead>
	<tbody>
      <? foreach ($data_pf as $num => $row): ?>
      <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <th><?= ++$num ?></th>
        <td><?= $row['namaPF'] ?></td>
        <td><?= $row['satuan'] ?></td>
        <td><?= $row['kemasan'] ?></td>
        <td><?= $row['macamSediaan'] ?></td>
        <td><?= $row['kekuatan'] ?></td>
        <td><?= $row['jumlah'] ?></td>
        <td><?= $row['leadTime'] ?></td>
        <td class="aksi">
          <a href="<?= app_base_url('/pf/inventory/distribusi_pf/?do=edit&id='.$row['id']) ?>" class="edit"><small>edit</small></a>
        </td>
      </tr>
      <? endforeach ?>
    </tbody>
  </table>
</div>
