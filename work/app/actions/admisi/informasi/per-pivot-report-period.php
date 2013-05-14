<script language="javascript">
	$(function() {
		$('#awal').datepicker({
				changeMonth: true,
				changeYear: true,
                                dateFormat: 'dd/mm/yy'
			});
		});

		$(function() {
			jQuery('#akhir').datepicker({
				changeMonth: true,
				changeYear: true,
                                dateFormat: 'dd/mm/yy'
			});
		});
	</script>
<?
require_once "app/lib/common/functions.php";

set_time_zone();
if ($_GET['period'] == 1 || $_GET['period'] == 2) { ?>
    <fieldset class="field-group">
        <legend>Awal - akhir period</legend>
            <input type="text" name="awal" class="tanggal" id="awal" value='<? echo date("d/m/Y");?>' />
            <label class="inline-title">s . d</label>
            <input type="text" name="akhir" class="tanggal" id="akhir" value='<? echo date("d/m/Y");?>' />
    </fieldset>
<?php 
exit();
}?>
<?
if($_GET['period'] == 3){?>
    <script language="javascript">
		function isFourDigitthawal(thawal) {
		if (thawal.length != 4) {
		alert ("Sorry, the thawal must be four-digits in length.");
		document.form.thawal.select();
		document.form.thawal.focus();
		} else { return true; }
		}
		function selectDate() {
		var thawal  = document.form.thawal.value;
		if (isFourDigitthawal(thawal)) {
		var day   = 0;
		var bln1 = document.form.bln1.selectedIndex;

			}
	}

	function setPreviousthawal() {
		var thawal  = document.form.thawal.value;
		if (isFourDigitthawal(thawal)) {
		var day   = 0;
		var bln1 = document.form.bln1.selectedIndex;
		thawal--;
		document.form.thawal.value = thawal;

		   }
	}
	function setPreviousbln1() {
		var thawal  = document.form.thawal.value;
		if (isFourDigitthawal(thawal)) {
		var day   = 0;
		var bln1 = document.form.bln1.selectedIndex;
		if (bln1 == 0) {
		bln1 = 11;
		if (thawal > 1000) {
		thawal--;
		document.form.thawal.value = thawal;
		}
		} else { bln1--; }
		document.form.bln1.selectedIndex = bln1;

		}
	}
	function setNextbln1() {
		var thawal  = document.form.thawal.value;
		if (isFourDigitthawal(thawal)) {
			var day   = 0;
			var bln1 = document.form.bln1.selectedIndex;
			if (bln1 == 11) {
				bln1 = 0;
				thawal++;
				document.form.thawal.value = thawal;
			} else { bln1++; }
			document.form.bln1.selectedIndex = bln1;
		}
	}
	function setNextthawal() {
		var thawal = document.form.thawal.value;
		if (isFourDigitthawal(thawal)) {
			var day = 0;
			var bln1 = document.form.bln1.selectedIndex;
			thawal++;
			document.form.thawal.value = thawal;

		}
	}

	function getDaysInbln1(bln1,thawal)  {
		var days;
		if (bln1==1 || bln1==3 || bln1==5 || bln1==7 || bln1==8 || bln1==10 || bln1==12)  days=31;
		else if (bln1==4 || bln1==6 || bln1==9 || bln1==11) days=30;
		else if (bln1==2)  {
		if (isLeapthawal(thawal)) { days=29; }
		else { days=28; }
		}
		return (days);
	}
	function isFourDigitthakhir(thakhir) {
		if (thakhir.length != 4) {
		alert ("Sorry, the thakhir must be four-digits in length.");
		document.form.thakhir.select();
		document.form.thakhir.focus();
		} else { return true; }
		}
		function selectDate() {
		var thakhir  = document.form.thakhir.value;
		if (isFourDigitthakhir(thakhir)) {
		var day   = 0;
		var bln2 = document.form.bln2.selectedIndex;

			}
	}

	function setPreviousthakhir() {
		var thakhir  = document.form.thakhir.value;
		if (isFourDigitthakhir(thakhir)) {
		var day   = 0;
		var bln2 = document.form.bln2.selectedIndex;
		thakhir--;
		document.form.thakhir.value = thakhir;

		   }
	}
	function setPreviousbln2() {
		var thakhir  = document.form.thakhir.value;
		if (isFourDigitthakhir(thakhir)) {
		var day   = 0;
		var bln2 = document.form.bln2.selectedIndex;
		if (bln2 == 0) {
		bln2 = 11;
		if (thakhir > 1000) {
		thakhir--;
		document.form.thakhir.value = thakhir;
		}
		} else { bln2--; }
		document.form.bln2.selectedIndex = bln2;

		}
	}
	function setNextbln2() {
		var thakhir  = document.form.thakhir.value;
		if (isFourDigitthakhir(thakhir)) {
			var day   = 0;
			var bln2 = document.form.bln2.selectedIndex;
			if (bln2 == 11) {
				bln2 = 0;
				thakhir++;
				document.form.thakhir.value = thakhir;
			} else { bln2++; }
			document.form.bln2.selectedIndex = bln2;
		}
	}
	function setNextthakhir() {
		var thakhir = document.form.thakhir.value;
		if (isFourDigitthakhir(thakhir)) {
			var day = 0;
			var bln2 = document.form.bln2.selectedIndex;
			thakhir++;
			document.form.thakhir.value = thakhir;

		}
	}

	function getDaysInbln2(bln2,thakhir)  {
		var days;
		if (bln2==1 || bln2==3 || bln2==5 || bln2==7 || bln2==8 || bln2==10 || bln2==12)  days=31;
		else if (bln2==4 || bln2==6 || bln2==9 || bln2==11) days=30;
		else if (bln2==2)  {
		if (isLeapthakhir(thakhir)) { days=29; }
		else { days=28; }
		}
		return (days);
	}
		</script>
        <fielset class="field-group"><label>Bulanan</label>
        <div class="monthly-selector">
            <input type=button class="prev-year-button" name="previousthawal" VALUE="" onClick="setPreviousthawal()">
            <input type=button class="prev-month-button" name="previousthawal" VALUE="" onClick="setPreviousbln1()">
        	 <select name="bln1" onChange="selectDate()" class="month">
                    <option value="Januari">January</option>
                    <option value="Februari">February</option>
                    <option value="Maret">March</option>
                    <option value="April">April</option>
                    <option value="Mei">May</option>
                    <option value="Juni">June</option>
                    <option value="Juli">July</option>

                    <option value="Agustus">August</option>
                    <option value="September">September</option>
                    <option value="Oktober">October</option>
                    <option value="November">November</option>
                    <option value="Desember">December</option>
            </select>
            <input name="thawal" type=TEXT SIZE=4 MAXLENGTH=4 value="<? echo date("Y"); ?>" class="year">
            <input type=button class="next-month-button" name="previousthawal" VALUE="" onClick="setNextbln1()">
            <input type=button class="next-year-button" name="previousthawal" VALUE="" onClick="setNextthawal()">
    <span class="none">s . d</span>
    <input type=button name="previousthakhir" class="prev-year-button" VALUE="" onClick="setPreviousthakhir()">
		<input type=button name="previousthakhir" class="prev-month-button" VALUE="" onClick="setPreviousbln2()">
	<select name="bln2" onChange="selectDate()" class="month">
		<option value="Januari">January</option>
		<option value="Februari">February</option>
		<option value="Maret">March</option>
		<option value="April">April</option>
		<option value="Mei">May</option>
		<option value="Juni">June</option>
		<option value="Juli">July</option>

		<option value="Agustus">August</option>
		<option value="September">September</option>
		<option value="Oktober">October</option>
		<option value="November">November</option>
		<option value="Desember">December</option>
	</select>
	<input name="thakhir" type=TEXT SIZE=4 MAXLENGTH=4 value="<? echo date("Y"); ?>" class="year">

		<input type=button name="previousthakhir" class="next-month-button" VALUE="" onClick="setNextbln2()">
		<input type=button name="previousthakhir" class="next-year-button" VALUE="" onClick="setNextthakhir()">
		 </div>
	<?
        exit();
}
if ($_GET['period'] == 4) { ?>
  <script language="JavaScript">

		function isFourDigitYear(awal) {
			if (awal.length != 4) {
				alert ("Data yang dimasukkan harus integer 4 digit !");
				document.form.awal.select();
				document.form.awal.focus();
			} else {
				return true;
			}
		}

		function setPreviousYear() {
			var awal  = document.form.awal.value;
			var akhir = document.form.akhir.value;
			if (isFourDigitYear(awal)) {
				var day   = 0;
				//var month = document.form.month.selectedIndex;
				awal--;
				if (akhir < awal) {
						document.form.akhir.value = awal;
				}
				document.form.awal.value = awal;

			}
		}

		function setNextYear() {
			var awal = document.form.awal.value;
			var akhir= document.form.akhir.value;
			if (isFourDigitYear(awal)) {
				var day = 0;
				//var month = document.form.month.selectedIndex;
				awal++;
				if (akhir < awal) {
						document.form.akhir.value = awal;
				}
				document.form.awal.value = awal;
			}
		}

		function isFourDigitYear(akhir) {
			if (akhir.length != 4) {
				alert ("Data yang dimasukkan harus integer 4 digit !");
				document.form.akhir.select();
				document.form.akhir.focus();
			} else {
				return true;
			}
		}

		function setPreviousakhir() {
			var akhir  = document.form.akhir.value;
			var awal   = document.form.awal.value;

			if (isFourDigitYear(akhir)) {
				var day   = 0;
				//var month = document.form.month.selectedIndex;
				akhir--;
				if (akhir < awal) {
					document.form.awal.value = akhir;
				}
				document.form.akhir.value = akhir;
			}
		}

		function setNextakhir() {
			var akhir = document.form.akhir.value;
			var awal  = document.form.awal.value;
			if (isFourDigitYear(akhir)) {
				var day = 0;
				//var month = document.form.month.selectedIndex;
				akhir++;
				if (akhir < awal) {
						document.form.awal.value = akhir;
				}
			document.form.akhir.value = akhir;
		   }
		}

		</script>
	    <fieldset class="field-group" style="white-space:normal">
            <label for="awal">Awal - akhir periode</label>
            <div class="monthly-selector">

            <input type="button" name="previousYear" value="" class="prev-year-button" onClick="setPreviousYear()">
			<input name="awal" type=text size=4 maxlength=4 class="year" onkeyup="Angka(this)" value="<? echo date("Y");?>">
			<input type="button" name="previousYear" value="" class="next-year-button"  onClick="setNextYear()">

            <span class="none">s . d </span>
            <input type="button" name="previousakhir" value="" class="prev-year-button" onClick="setPreviousakhir()">
			<input name="akhir" type=text size=4 maxlength=4 class="year" onkeyup="Angka(this)" value="<? echo date("Y");?>">
			<input type="button" name="previousakhir" value="" class="next-year-button" onClick="setNextakhir()">

			</div>
            </fieldset>
	<?php exit(); }
	 else {
		exit();
}
?>
