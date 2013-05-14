<h2 class="judul">Setting Waktu Tutup Kas</h2>
<script type="text/javascript">
    $(function() {
         $('#waktu').timepicker({
           timeFormat: 'hh:mm:ss',
           showSecond: true
        });
    });
	function cekForm(){
		var waktu = $('#waktu').val();
		if( waktu=="" || waktu==NULL ){
			caution("Waktu Tidak Boleh Kosong");
		}
		return false;
	}
</script>
<?php
require_once 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-akuntansi.php'; 
$data_waktu = setting_waktu_muat_data();
$waktu = isset($data_waktu)?$data_waktu["waktu"]:"";
echo isset($pesan) ? $pesan : NULL 
?>
<form action="<?= app_base_url('akuntansi/control/waktu-tutup-kas') ?>" id="form" method="post" onSubmit="return cekForm()">
    <div class="data-input">
        <fieldset><legend>Form Setting Waktu Tutup Kas</legend>
            <label for="waktu">Waktu Tutup Kas</label><input type="text" name="waktu" id="waktu" class="timepicker" Autocomplete="off" readonly="readonly" value="<?php echo $waktu;?>"/>
			<label></label>
				<input type="submit" value="Simpan" name="save" class="stylebutton"/> 
				<input type="button" value="Batal" class="stylebutton space"onClick="javascript:location.href='<?= app_base_url('akuntansi/waktu-tutup-kas') ?>'"/>
        </fieldset>
    </div>
</form>