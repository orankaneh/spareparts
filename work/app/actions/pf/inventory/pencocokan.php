<?php
require_once "app/lib/distribusi_pf.php";
$no_faktur = no_faktur();
$pencocokan = pencocokan_sp_sf();
$rak_simpan = rak_simpan();
?>
<script language="javascript">
$(document).ready(function(){
	$(".tampil").click(function(){
		$("#hidden").show('slow');
	})
        $(".sembunyi").click(function(){
            $("#hidden").hide('slow');
	})

	$("#hidden").toggle(false);
})	
</script>	
<h1>Pencocokan Faktur, SP dan PF</h1>
<div class="data-input">
<form action="<?= app_base_url('/pf/inventory/pencocokan') ?>" method="post">
  <fieldset>
    <label for="no_faktur">No. Faktur</label>
    <select name="no_faktur">
        <option value="">Pilih..</option>
        <? foreach($no_faktur as $no):?>
	  <option value="<?= $no['id']?>"><?= $no['no']?></option>
	<? endforeach?>
    </select>
    <label for="nama_unit">Tgl Penerimaan</label>
    <input type="text" id="tgl" name="tanggal" value="" disabled />
    <label for="nama_unit">No. SP</label>
    <input type="text" id="noSp" name="noSp" value="" disabled />
    <label for="nama_unit">Tanggal SP</label>
    <input type="text" id="tglSp" name="tglSp" value="" disabled />
  </fieldset>
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
		<th>No Batch</th>
		<th>Tgl Kadaluarsa</th>
		<th>Jumlah</th>
        <th>Harga</th>
        <th>Total Harga</th>
        <th>Bonus</th>
        <th>Diskon</th>
        <th>Kesesuaian dengan PF dan SP</th>
        <th>Keterangan</th>
	  </tr>
	</thead>
	<tbody>
      <? foreach ($pencocokan as $num => $row): ?>
      <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <th><?= ++$num ?></th>
        <td><?= $row['namaPF'] ?></td>
        <td><?= $row['satuan'] ?></td>
        <td><?= $row['kemasan'] ?></td>
        <td><?= $row['macamSediaan'] ?></td>
        <td><?= $row['kekuatan'] ?></td>
        <td><?= $row['noBatch'] ?></td>
        <td><?= $row['kadaluarsa'] ?></td>
        <td><?= $row['jumlah'] ?></td>
        <td><?= $row['harga'] ?></td>
	<td><?= $row['total_harga'] ?></td>
        <td><?= $row['bonus'] ?></td>
        <td><?= $row['diskon'] ?></td>
        <td>
            <input class="tampil" type="radio" name="sesuai" value="">sesuai<br />
            <input class="sembunyi" type="radio" name="sesuai" value="">tidak sesuai<br />
            <input class="tampil" type="radio" name="sesuai" value="">jumlah kurang (diterima)<br />
        </td>
        <td><?= $row['keterangan'] ?></td>
      </tr>
      <? endforeach ?>
    </tbody>
  </table>
</div>
<fieldset>
 <input type="submit" value="Simpan">
 <input type="reset" value="Batal">
</fieldset>
    <h1>Pembuatan Serah Terima</h1>
    <fieldset>
    <label for="no_faktur">No. Faktur</label>
    <input type="text" name="no_faktur" disabled>
    <label for="cek">Tgl. Pengecekan</label>
    <input type="text" name="cek" disabled>
    <label for="total_harga">Total Harga</label>
    <input type="text" name="total_harga" disabled>
    <label for="serahTerima">No. Serah Terima</label>
    <input type="text" name="serahTerima">
    </fieldset>
    <fieldset>
      <input type="submit" value="Simpan">
      <input type="reset" value="Batal">
    </fieldset>
    <div id="hidden">
    <h1>Penerimaan/Penyimpanan PF</h1>
    <fieldset>
    <label for="nm_pf">Nama PF</label>
    <input type="text" name="nm_pf" disabled>
    <label for="no_batch">No. Batch</label>
    <input type="text" name="no_batch" disabled>
    <label for="exp">Tgl. Kadaluarsa</label>
    <input type="text" name="exp" disabled>
    <label for="harga">Harga</label>
    <input type="text" name="harga" disabled>
    <label for="jumlah">Jumlah</label>
    <input type="text" name="jumlah">
    <label for="totalHarga">Total Harga</label>
    <input type="text" name="totalHarga" disabled>
    <label for="rak_simpan">Rak Penyimpanan</label>
    <select name="rak_simpan">
        <option value="">Pilih..</option>
        <? foreach($rak_simpan as $rak):?>
	  <option value="<?= $rak['id']?>"><?= $rak['rak']?></option>
	<? endforeach?>
    </select>
    </fieldset>
    <fieldset>
      <input type="submit" value="Simpan">
      <input type="reset" value="Batal">
    </fieldset>
</div>
</form>
</div>
