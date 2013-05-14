<h2 class="judul">Aturan Keuangan</h2>
<script type="text/javascript">
    $(function() {
         $('#waktu').timepicker({
           timeFormat: 'hh:mm:ss',
           showSecond: true
        });
    });

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
			 $('#'+boxresult).attr('value',data.id+"-"+data.id_kategori);
		 });
	
	}
	
	function simpanTutupKas(formid) {
		if ( $('#waktu').val() == "" ) {
			caution('Waktu Tidak Boleh Kosong');
		} else {
			progressAdd(formid);
		}
	}
	
	function simpanAutoJurnal(formid) {
			progressAdd(formid);
	}
	
	
</script>
<?php
require_once 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-akuntansi.php'; 
$data_waktu = setting_waktu_muat_data();
$waktu = isset($data_waktu)?$data_waktu["waktu"]:"";

$datarekening = _select_unique_result("select * from rekening_auto");
$rek_kas = _select_unique_result("select * from rekening where id = '".$datarekening['kas']."'");
$rek_pendapatan = _select_unique_result("select * from rekening where id = '".$datarekening['pendapatan']."'");
$rek_piutang = _select_unique_result("select * from rekening where id = '".$datarekening['piutang']."'");



?>

<div id="box-notif"></div>

<form action="<?= app_base_url('akuntansi/control/aturan-keuangan?opsi=tutupkas') ?>" method="post" onsubmit="simpanTutupKas($(this));return false;">
    <div class="data-input">
        <fieldset><legend>Aturan Waktu Tutup Kas</legend>
            <label for="waktu">Waktu Tutup Kas</label><input type="text" name="waktu" id="waktu" class="timepicker" Autocomplete="off" readonly="readonly" value="<?php echo $waktu;?>"/>
			<label></label><input type="submit" value="Simpan" name="save" class="stylebutton"/> 
			</span>
        </fieldset>
    </div>
</form>


<form action="<?= app_base_url('akuntansi/control/aturan-keuangan?opsi=autojurnal') ?>" method="post" onsubmit="simpanAutoJurnal($(this));return false;">
    <div class="data-input">
        <fieldset><legend>Aturan Pos AutoJurnal</legend>
            <label for="rek_kas">Rekening Kas</label>
					<input type='text' name='rekening_kas' id='rekening_kas' style='min-width: 350px' value='<?php echo $rek_kas['kode']." ".$rek_kas['nama']; ?>'>
					<input class='hideauto' type='hidden' name='id_rek_kas' id='id_rek_kas' value='<?php echo $rek_kas['id']; ?>'>
			<label for="rek_kas">Rekening Pendapatan</label>
					<input type='text' name='rekening_pendapatan' id='rekening_pendapatan' style='min-width: 350px' value='<?php echo $rek_pendapatan['kode']." ".$rek_pendapatan['nama']; ?>'>
					<input class='hideauto' type='hidden' name='id_rek_pendapatan' id='id_rek_pendapatan' value='<?php echo $rek_pendapatan['id']; ?>'>
			<label for="rek_kas">Rekening Piutang</label>
					<input type='text' name='rekening_piutang' id='rekening_piutang' style='min-width: 350px' value='<?php echo $rek_piutang['kode']." ".$rek_piutang['nama']; ?>'>
					<input class='hideauto' type='hidden' name='id_rek_piutang' id='id_rek_piutang' value='<?php echo $rek_piutang['id']; ?>'>
			<script>
			addRekeningAutoComplete('rekening_kas','id_rek_kas');
			addRekeningAutoComplete('rekening_pendapatan','id_rek_pendapatan');
			addRekeningAutoComplete('rekening_piutang','id_rek_piutang');
			</script>
			<label></label><input type="submit" value="Simpan" name="save" class="stylebutton"/> 
			</span>
        </fieldset>
    </div>
</form>