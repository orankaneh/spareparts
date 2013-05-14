<?php
require_once "app/lib/distribusi_pf.php";
$nama_units = nama_unit();
$data_pf = data_distribusi_pf();
?>
<h1 class="judul">SURAT PERMINTAAN DISTRIBUSI PF</h1>
<div class="data-input">
<form action="<?= app_base_url('/pf/inventory/permintaan_distribusi_pf') ?>" method="post">
  <fieldset>
    <legend>Surat Pemesanan</legend>
    <label for="no_sp">No. SP</label>
	<input type="text" name="no_sp" id="no_sp" value="" />
	<label for="nama_unit">Nama Unit</label>
	<select name="nama_unit">
	  <option value="">Pilih..</option>
	  <? foreach($nama_units as $nu):?>
	  <option value="<?= $nu['id']?>"><?= $nu['nama']?></option>
	  <? endforeach?>
	</select>
	<fieldset class="input-process">
	  <input type="submit" value="Simpan" class="tombol">
	  <input type="reset" value="Batal" class="tombol">
	</fieldset>
  </fieldset>
</form>
</div>
<div class="data-list">
  <table class="tabel">
    <caption>Data Permintaan Distribusi PF</caption>
    
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
	
      <? foreach ($data_pf as $num => $row): ?>
      <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <td align="center"><?= ++$num ?></td>
        <td><?= $row['namaPF'] ?></td>
        <td><?= $row['satuan'] ?></td>
        <td><?= $row['kemasan'] ?></td>
        <td><?= $row['macamSediaan'] ?></td>
        <td><?= $row['kekuatan'] ?></td>
        <td><?= $row['jumlah'] ?></td>
        <td><?= $row['leadTime'] ?></td>
        <td class="aksi">
          <a href="<?= app_base_url('/pf/inventory/distribusi_pf/?do=edit&id='.$row['id']) ?>" class="edit"><small>edit</small></a>
          <a href="<?= app_base_url('/pf/inventory/distribusi_pf?do=delete&id='.$row['id']) ?>" class="delete">Hapus</a>
        </td>
      </tr>
      <? endforeach ?>
    
  </table>
</div>

