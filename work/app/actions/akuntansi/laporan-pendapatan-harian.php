<?php set_time_zone(); ?>


<script type="text/javascript">
    $(function() {
        $('#waktu').datepicker({
           dateFormat: 'yy-mm-dd',
           changeMonth: true,
           changeYear: true
        });
		$("#display").click(function(){
			var tanggal = $('#waktu').val();
			$("#content").html("");
			contentloader('<?php echo app_base_url('akuntansi/report/laporan-harian?') ?>tanggal='+tanggal,'#content');
		});
		$("#reset").click(function(){
			var tanggal = $('#waktu').val();
            $('#content').html("");
            $('#waktu').val("<?php echo date("Y-m-d");?>");
		});
	});
</script>
<h2 class="judul">Laporan Pendapatan Harian</h2>
<form action="" id="form" method="post" >
    <div class="data-input">
        <fieldset><legend>Tampil Laporan Pendapatan Harian</legend>
            <label for="waktu">Cari Berdasar Tanggal </label>
			<input type="text" name="waktu" id="waktu" value="<?php echo date("Y-m-d");?>" class="timepicker" Autocomplete="off" readonly="readonly" />
			<label></label>
			<input type="button" value="Display" name="display" class="stylebutton" id="display"/> 
			<input type="button" value="Reset" class="stylebutton space" id="reset"/>
        </fieldset>
    </div>
</form>
<div id="content"></div>