<?php
require_once "app/lib/distribusi_pf.php";
$nm_pbf = nmPBF();

$nama_units = nama_unit();
$data_pf = data_distribusi_pf();
$bulan_sp = bln_sp();
$nmr_sp = no_sp();
$nama_pf = namaPf();
?>
<script type="text/javascript"> 
      $(document).ready(function(){
        $("#tgl_terima").datepicker()				
      });
</script>
<script language="javascript"> 
function isFourDigitYear(year) {
if (year.length != 4) {
alert ("Sorry, the year must be four-digits in length.");
document.calControl.year.select();
document.calControl.year.focus();
} else { return true; }
}

function setPreviousYear() {
var year  = document.calControl.year.value;
if (isFourDigitYear(year)) {
var day   = 0;
//var month = document.calControl.month.selectedIndex;
year--;
document.calControl.year.value = year;
displayCalendar(year);
   }
}

function setNextYear() {
   var year = document.calControl.year.value;
   if (isFourDigitYear(year)) {
	var day = 0;
	//var month = document.calControl.month.selectedIndex;
	year++;
	document.calControl.year.value = year;
	displayCalendar(year);
   }
}
</script>
<h1 class="judul">Faktur Reretur</h1>
<div class="data-input">
    <form name="calControl" action="<?= app_base_url('/pf/inventory/fakturReretur') ?>" method="post">
  <fieldset>
    <legend>Faktur Reretur</legend>
    <label for="no_faktur">No. faktur</label>
	<input type="text" name="no_faktur" id="no_faktur" value="" />
	<label for="tgl_terima">Tgl. Penerimaan Faktur</label>
	<input type="text" id="tgl_terima">
  </fieldset>
  <fieldset>
    <legend>Surat Permintaan Retur</legend>
	<label for="bln">Bulan Pembuatan SP</label>
	<select name="namaPF">
      <option value="">Pilih..</option>
      <? foreach($bulan_sp as $bln):?>
      <option value="<?= $bln['id']?>"><?= $bln['nama']?></option>
      <? endforeach?>
    </select>
	<? date_default_timezone_set('Asia/krasnoyarsk')?>
	<fieldset class="field-group">
	<label for="thn">Tahun Pembuatan SP</label>
	<table>
	  <tr>
      <td><input type= "button" name="previousYear" value="<<" onClick="setPreviousYear()"></td>
      <td><input name="year" type="text" size="4" maxlength= "4" value="<? echo date("Y");?>"></td>
      <td><input type= "button" name="previousYear" value=">>" onClick="setNextYear()"></td>
	  </tr>
	</table>
	</fieldset>
	<label for="no_sp">Nomor SP</label>
	<select name="no_sp">
      <option value="">Pilih..</option>
      <? foreach($nmr_sp as $no):?>
      <option value="<?= $no['id']?>"><?= $no['no']?></option>
      <? endforeach?>
    </select>
  </fieldset>
  <fieldset>
    <legend>PBF</legend>
    <label for="nm_pbf">Nama PBF</label>
	<input type="text" name="nm_pbf" id="nm_pbf" value="" disabled />
	<fieldset class="input-process">
	<input type="button" value="Isi PF" class="tombol">
	<input type="submit" value="Simpan" class="tombol">
	<input type="button" value="Batal" class="tombol">
	</fieldset>
  </fieldset>
</form>
	</div>
<div class="data-list">
  <table class="tabel">
    <caption>Faktur Reretur</caption>
    
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
	  </tr>
	
      <? foreach ($data_pf as $num => $row): ?>
      <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <td><?= ++$num ?></td>
        <td><?= $row['namaPF'] ?></td>
        <td><?= $row['satuan'] ?></td>
        <td><?= $row['kemasan'] ?></td>
        <td><?= $row['macamSediaan'] ?></td>
        <td><?= $row['kekuatan'] ?></td>
        <td>&nbsp;&nbsp; </td>
        <td>&nbsp;&nbsp; </td>
		<td>&nbsp;&nbsp; </td>
      </tr>
      <? endforeach ?>
   
  </table>
</div>

