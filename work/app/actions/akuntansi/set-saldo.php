<?php

$sub=isset($_GET['section'])?$_GET['section']:NULL;
if (isset($sub)) {

switch ($sub) {

	// --------------------------- Cari Tanggal --------------------------- //
	
	case "settanggal":
	
	require_once 'app/lib/common/master-akuntansi.php';
	
	set_time_zone();
	$bulan=date('m');
	$tahun=date('Y');
	
	$bulanArr=array('1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember',);
	$bulanCb="<select name=bulan id=bulan class='search-input' style='margin-right: 5px; width: 140px'>";
	if(empty($_GET['bulan'])) $bulan=date('m'); else $bulan=$_GET['bulan'];
	if(empty($_GET['tahun'])) $tahun=date('Y'); else $tahun=$_GET['tahun'];
	foreach($bulanArr as $key=>$b){
	   if($key==$bulan) $selected='selected';
	   else $selected='';
	   $bulanCb.="<option value=$key $selected>$b</option>";
	} $bulanCb.="</select>"; ?>

	<?php $dataCheck=check_saldoavailable();?>
	<script type="text/javascript">
	var saldoAvailable = <?php echo $dataCheck['set']; ?>;
	var bulan_set = <?php echo $dataCheck['bulan']; ?>;
	var tahun_set = <?php echo $dataCheck['tahun']; ?>;

	if (parseInt(saldoAvailable) != 0) contentloader('<?= app_base_url('/akuntansi/set-saldo?section=setsaldo'); ?>&bulan='+bulan_set+'&tahun='+tahun_set,'#laysetup');
	function setSaldoAwal(bulan,tahun) {
		contentloader('<?= app_base_url('/akuntansi/set-saldo?section=setsaldo'); ?>&bulan='+bulan+'&tahun='+tahun,'#laysetup');
	}
	</script>

	
	<h1 class="judul">Set Saldo Awal</h1>

	<!-- notifikasi/alert --><div id="box-notif"></div><div class="clear"></div>

	<fieldset>
		<legend>Pilih Bulan & Tahun</legend>
		<form method="POST" class="search-form" style="float: none" onsubmit="setSaldoAwal($('#bulan').val(),$('#tahun').val());return false;" id="pilihbulan">
		<?= $bulanCb ?><input type="text" onkeyup="Angka(this)" name="tahun" id="tahun" maxlength="4" value="<?=$tahun?>" class="search-input" style="width: 30px !important">
		<input type="submit" value="" class="search-button">
		</form>
	</fieldset>

    <div id="content"></div>
		
	<?php
	break;
	
	// --------------------------- Set Saldo  ---------------------------- //
	
	case "setsaldo":
	require_once 'app/lib/common/master-akuntansi.php';
	
	
	$bulanArr=array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

	$bulan = (strlen($_GET['bulan'])==1)?"0".$_GET['bulan']:$_GET['bulan'];
	$tahun = $_GET['tahun'];
	$data=neracasaldo_muatdata($bulan,$tahun);
	echo "<h1 class='judul'>SALDO AWAL : $bulanArr[$bulan] $tahun</h2>";
	?>
	
	<script type="text/javascript">
	function addRekeningAutoComplete(boxid,boxresult) {
			$('#'+boxid).autocomplete("<?= app_base_url('/akuntansi/search?opsi=rekening') ?>",{
                parse: function(data){
                     var parsed = [];
                     for (var i=0; i < data.length; i++) {
                         parsed[i] = {
                             data: data[i],
                             value: data[i].nama // nama field yang dicari
                         };
                     } return parsed;
                 },formatItem: function(data,i,max){
                     var str='<div class=result>Kode: '+data.kode+' <br/><i> '+data.nama+'</i></div>';
                     return str;
                 },width: 300,dataType: 'json'
             }).result(
             function(event,data,formated){
                 $(this).attr('value',data.kode+' '+data.nama);
                 $('#'+boxresult).attr('value',data.id);
             });
		
		}
		
	
	function setSaldoAwal(bulan,tahun) {
		contentloader('<?= app_base_url('/akuntansi/set-saldo?section=setsaldo'); ?>&bulan='+bulan+'&tahun='+tahun,'#laysetup');
	}
	
	function addSaldo() {
			var rek = $('.rek').length+1;
			var str = "<div class='even t'><label class='w100px'>Rekening ke-"+rek+"</label><input type='text' name='rekening[]' id='rek"+rek+"' class='rek' style='min-width: 280px'><input class='hideauto' type='hidden' name='id_rek[]' id='id_rek"+rek+"'><span style='float: left'>Jumlah &nbsp; </span><input type='text' onkeyup='formatNumber(this)' style='min-width: 140px' id='jumlah"+rek+"' name='jumlah[]'><a href='#' class='autoadd-delete' onClick='deleteSaldo(this)'></a>";
			$("#saldobox").append(str);
			addRekeningAutoComplete('rek'+rek,'id_rek'+rek);
	}
	
	function deleteSaldo(el){
			var parent = el.parentNode;
			parent.parentNode.removeChild(parent);
			var tr=$('.t');
			var countTr=tr.length;
			for(var i=1;i<=countTr;i++){
				$('.t:eq('+i+')').removeClass('even');
				$('.t:eq('+i+')').addClass('even');
				$('.t:eq('+i+')').children('.rd').attr('id','rd'+(i+1));
				$('.t:eq('+i+')').children('.hideauto').attr('id','id_rek'+(i+1));
				$('.t:eq('+i+')').children('.w100px').html('Rekening ke-'+(i+1));
				addRekeningAutoComplete('rek'+i,'id_rek'+i);
			}
		}
	
	function simpanSaldo(formid) {
		
		var check = 0;
		var jml = $('.rek').length;
		for (i=1; i<=jml; i++) {
			if (($('#rek'+i).val()!='' && $('#jumlah'+i).val() == '') || ($('#rek'+i).val()=='' && $('#jumlah'+i).val() != '')) {
				caution('Isian belum lengkap');
				check=1;
			}
		}

		if (check == 0) {
			progressAdd(formid);
			if ($('#opsi').val() == "finish") {
				setTimeout("notif('Saldo Awal berhasil di-SET')",1200);
				$('#databox').html("<a href='<?php echo app_base_url("/akuntansi/jurnal-umum"); ?>'><input type='button' class='stylebutton' value='Input Jurnal Umum'></a><a href='<?php echo app_base_url("/akuntansi/jurnal-penyesuaian"); ?>'><input type='button' class='stylebutton space' value='Input Jurnal Penyesuaian'></a>");
			} else {
				notif('Penyimpanan Saldo Awal Berhasil');
				setTimeout("contentloader('<?= app_base_url('/akuntansi/set-saldo?section=setsaldo'); ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>','#laysetup')",2200);
			}
		}
		
	}
	
	
	function setFinishSaldo() {
		simpanSaldo($('#formsaldo'));	
	}


	function finishSaldo() {
		$('#box-notif').removeClass('alert').addClass('notif').html("<form method='post' id='formfinish' action='<?php echo app_base_url("/akuntansi/control/set-saldo"); ?>' onsubmit='$(\"#opsi\").val(\"finish\");setFinishSaldo();return false'>Dengan meng-klik tombol ini maka Saldo Awal akan disimpan secara <b>permanen</b><br> dan tidak akan muncul kembali, serta bulan sebelum bulan saldo awal tidak akan dapat diinputkan pada jurnal.<br><br><input type='hidden' name='opsi' value='finish'><input type='button' class='stylebutton' value='Batal' onclick='$(\"#opsi\").val(\"\");$(\"#box-notif\").html(\"\").hide();'><input type='submit' value='Selesai' name='simpan' class='stylebutton redbutton'></form>").show();
	}
	
	</script>
	
	<form id="formsaldo" action="<?php echo app_base_url("/akuntansi/control/set-saldo"); ?>" onsubmit="simpanSaldo($(this)); return false" method="post">
	<div id="box-notif"></div><div class="clear"></div>
	<div class="data-input" id="databox">
	<fieldset id="saldobox">
	<legend>Input Saldo Awal Per Rekening</legend><?php
	if (count($data) > 0) { 
	$i=1;
	foreach($data as $row):
	
	echo "
	<script type='text/javascript'>addRekeningAutoComplete('rek".$i."','id_rek".$i."');</script>
	<div class='even t'><label class='w100px'>Rekening ke-".$i."</label><input type='text'  value='".$row['kode']." ".$row['nama']."' name='rekening[]' id='rek".$i."' class='rek' style='min-width: 280px'><input class='hideauto' type='hidden' value='".$row['id_rekening']."' name='id_rek[]' id='id_rek".$i."'><span style='float: left'>Jumlah &nbsp; </span><input type='text' onkeyup='formatNumber(this)'  value='".rupiah($row['jumlah'])."' style='min-width: 140px' id='jumlah".$i."' name='jumlah[]'>";
	if ($i==1) {
		echo "<div class='act-suddenly' title='Tambah Rekening Lain' onclick='addSaldo()'><div class='icon button-sud-add'></div>Tambah</div></div>";
	} else {
		echo "<a href='#' class='autoadd-delete' onClick='deleteSaldo(this)'></a>";
	}
	$i+=1;
	endforeach;
	
	} else { ?>
	<script type="text/javascript">addRekeningAutoComplete('rek1','id_rek1');</script>
	<div class='even t'><label class='w100px'>Rekening ke-1</label><input type='text' name='rekening[]' id='rek1' class='rek' style='min-width: 280px'><input class='hideauto' type='hidden' name='id_rek[]' id='id_rek1'><span style='float: left'>Jumlah &nbsp; </span><input type='text' onkeyup='formatNumber(this)' style='min-width: 140px' id='jumlah1' name='jumlah[]'>
	<div class="act-suddenly" title="Tambah Rekening Lain" onclick="addSaldo()"><div class="icon button-sud-add"></div>Tambah</div></div>				
	<?php } 

	?>
	</fieldset>

	<input type="hidden" name="tanggal" value="<?php echo $tahun."-".$bulan."-01"; ?>">
	<input type="hidden" name="opsi" id="opsi"/>
	
	<input type="submit" value="Simpan" class="stylebutton"/>
	<a href="<?php echo app_base_url("/akuntansi/jurnal-umum"); ?>"><input type="button" value="Keluar" id="keluar" class="stylebutton space"/></a>
	<input type="button" value="Selesai" class="stylebutton redbutton" onclick="finishSaldo();return false"/>
	</div>
	<?php
	
	break;
	
}
exit();
}

