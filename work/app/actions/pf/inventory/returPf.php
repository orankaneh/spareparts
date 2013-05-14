<?php
require_once "app/lib/distribusi_pf.php";
$nm_pbf = nmPBF();
$nama_pf = namaPf();
$data_pf = data_distribusi_pf();
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tampil').click(function(){
          $("#hidden").slideToggle("fast");  
        }
    );
	$("#hidden").toggle(false);
    }
)
</script>  
<h1 class="judul">Retur PF</h1>
<div class="data-input">
<form action="<?= app_base_url('/pf/inventory/returPf') ?>" method="post">
  <fieldset>
    <legend>Faktur</legend>
    <label for="no_sr">No. Surat Retur</label>
	<input type="text" name="no_sr" id="no_sr" value="" />
	<label for="nama_unit">Nama PBF</label>
	<select name="nm_pbf">
	  <option value="">Pilih..</option>
	  <? foreach($nm_pbf as $nm):?>
	  <option value="<?= $nm['id']?>"><?= $nm['nama']?></option>
	  <? endforeach?>
	</select>
  </fieldset>
  <fieldset>
    <input type="button" id="tampil" value="Isi Detil Retur PF">
	<input type="button" value="Keluar">
  </fieldset>
        <div id='hidden'>
	  <fieldset>
            <legend>Detil PF</legend>
            <label for="namaPf">Nama PF</label>
            <select name="namaPF">
                <option value="">Pilih..</option>
                <? foreach($nama_pf as $nm):?>
                <option value="<?= $nm['id']?>"><?= $nm['nama']?></option>
                <? endforeach?>
            </select>
            <label for="noBatch">No Batch</label>
            <input type="text" name="noBatch" disabled>
            <label for="exp">Tgl. Kadaluarsa</label>
            <input type="text" name="exp" disabled>
			<label for="jumlah">Jumlah</label>
            <input type="text" name="exp">
			<fieldset class="field-group">
			  <label for="alasan">Alasan</label>
			  <input type="radio" name="alasan" value="" checked>Rusak
              <input type="radio" name="alasan" value="">Kadaluarsa
              <input type="radio" name="alasan" value="">Ditarik
			</fieldset>
			<fieldset class="field-group">
			  <label for="kembali">Cara Pengembalian</label>
			  <input type="radio" name="kembali" value="" checked>Barang (PF)
              <input type="radio" name="kembali" value="">Uang
            </fieldset>
			<fieldset>
              <input type="submit" value="Simpan">
	          <input type="button" value="Keluar">
            </fieldset>
      </fieldset>
</div>
</form>
</div>
<div class="data-list">
  <table>
    <caption>Data Retur PF</caption>
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
		<th>Alasan Retur</th>
		<th>Cara Pengembalian</th>
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
		<td><?= $row['leadTime'] ?></td>
		<td><?= $row['alasanRetur'] ?></td>
		<td><?= $row['caraKembali'] ?></td>
      </tr>
      <? endforeach ?>
    </tbody>
  </table>
</div>


