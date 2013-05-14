<?php
require_once "app/lib/distribusi_pf.php";
$nmr_sp = no_sp();
$kode_pf = kd_pf();
$data_pf = data_distribusi_pf();
$crBayar = caraBayar();
?>
<h1 class="judul">PEMBUATAN NOTA</h1>
<div class="data-input">
<form action="<?= app_base_url('/pf/inventory/pembuatanNota') ?>" method="post">
  <fieldset>
    <label for="no_sp">No. Surat Retur</label>
	<input type="text" name="jumlah" size="35" disabled>
	<label for="tgl_surat">Tanggal Surat</label>
	<input type="text" name="jumlah" size="35" disabled>
	<label for="total">Total Harus Dibayar</label>
	<input type="text" name="total" size="35" disabled>
	<label for="noNota">No. Nota</label>
	<input type="text" name="noNota" size="35"> 
	<label for="caraBayar">Cara Bayar</label>
	<select name="caraBayar">
	  <option value="">Pilih..</option>
	  <? foreach($crBayar as $cb):?>
	  <option value="<?= $cb['id']?>"><?= $cb['nama']?></option>
	  <? endforeach?>
	</select>
	<fieldset class="input-process">
	  <input type="submit" value="Simpan" class="tombol">
	  <input type="reset" value="Batal" class="tombol">
	</fieldset>
  </fieldset>
</form>
    </div>