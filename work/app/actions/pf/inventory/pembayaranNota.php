<?php
require_once "app/lib/distribusi_pf.php";
$nmr_sp = no_sp();
$kode_pf = kd_pf();
$data_pf = data_distribusi_pf();
$crBayar = caraBayar();
?>
<h1 class="judul">PEMBAYARAN NOTA PF RERETUR</h1>
<div class="data-input">
<form action="<?= app_base_url('/pf/inventory/pembayaranNota') ?>" method="post">
  <fieldset>
    <label for="no_sr">No. Surat Retur</label>
	<select name="no_sr">
	  <option value="">Pilih..</option>
	  <? foreach($nmr_sp as $nmr):?>
      <option value="<?= $nmr['id']?>"><?= $nmr['no']?></option>
      <? endforeach?>
	</select>
	<label for="tgl_surat">Tanggal Surat</label>
	<input type="text" name="jumlah" size="35" disabled>
	<label for="total">Total Harus Dibayar</label>
	<input type="text" name="total" size="35" disabled>
	<label for="caraBayar">Cara Bayar</label>
	<input type="text" name="crBayar" size="35" disabled> 
	<label for="jmlBayar">Jumlah Dibayar</label>
	<input type="text" name="jmlBayar" size="35"> 
	<label for="tglBayar">Tanggal Dibayar</label>
	<input type="text" name="tglBayar" size="35" disabled> 
        <fieldset class="input-process">
	  <input type="submit" value="Simpan" class="tombol">
	  <input type="reset" value="Batal" class="tombol">
	</fieldset>
  </fieldset>
</form>
    </div>