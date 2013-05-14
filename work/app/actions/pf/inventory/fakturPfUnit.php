<?php
require_once "app/lib/distribusi_pf.php";
$nama_units = nama_unit();
$data_pf = data_distribusi_pf();
$bulan_sp = bln_sp();
$nmr_sp = no_sp();
$nama_pf = namaPf();
?>
<link type="text/css" href="jsUI/themes/base/ui.all.css" rel="stylesheet" />   
<script type="text/javascript" src="jsUI/jquery-1.3.2.js"></script>
<script type="text/javascript" src="jsUI/ui/ui.core.js"></script>
<script type="text/javascript" src="jsUI/ui/ui.datepicker.js"></script>   
<script type="text/javascript"> 
      $(document).ready(function(){
        $("#tanggal").datepicker()				
      });
</script>
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
<script type="text/javascript"> 
      $(document).ready(function(){
        $("#tgl_terima").datepicker();
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
<h1>Faktur PF-UNIT</h1>
<div class="data-input">
<form name="calControl" action="<?= app_base_url('/pf/inventory/fakturPfUnit') ?>" method="post">
  <fieldset>
    <legend>Faktur</legend>
    <label for="no_sp">No. Faktur Unit</label>
	<input type="text" name="no_sp" id="no_sp" value="" />
	<label for="nama_unit">Tgl Penerimaan Faktur</label>
	<input type="text" id="tanggal" name="tanggal" value="" />
  </fieldset>
  <fieldset>
    <legend>SP</legend>
    <label for="bln_sp">Bulan Pembuatan SP</label>
	<select name="bln_sp">
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
      <td><input type="button" name="previousYear" value="<<"    onClick="setPreviousYear()"></td>
      <td><input name="year" type="text" size= 4 maxlength= 4 value="<? echo date("Y");?>"></td>
      <td><input type="button" name="previousYear" value=">>"    onClick="setNextYear()"></td>
	  </tr>
	</table>
	</fieldset>
	<label for="bln_sp">Nomor SP</label>
	<select name="no_sp">
	  <option value="">Pilih..</option>
	  <? foreach($nmr_sp as $nsp):?>
	  <option value="<?= $nsp['id']?>"><?= $nsp['no']?></option>
	  <? endforeach?>
	</select>
	<fieldset class="input-process">
	<input id="tampil" type="button" value="Isi Detil PF">
	</fieldset>
	<fieldset class="input-process">
	  <input type="submit" value="Simpan" class="tombol">
	  <input type="reset" value="Batal" class="tombol">
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
            <fieldset>
              <input type="submit" value="Simpan">
	      <input type="reset" value="Batal">
            </fieldset>
          </fieldset>    
	</div>	
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
		<th>No Batch</th>
		<th>Tgl Kadaluarsa</th>
		<th>Jumlah</th>
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
		<td><?= $row['leadTime'] ?></td>
      </tr>
      <? endforeach ?>

  </table>
</div>

