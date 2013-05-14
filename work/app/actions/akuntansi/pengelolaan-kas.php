

<?php set_time_zone(); ?>
<script type="text/javascript">
    $(function() {
        $('#waktu').datepicker({
           dateFormat: 'dd/mm/yy',
           changeMonth: true,
           changeYear: true
        });
		$("#display").click(function(){
			var tanggal = $('#waktu').val();
			$("#content").html("");
			contentloader('<?= app_base_url('akuntansi/control/pengelolaan-kas?') ?>tanggal='+tanggal,'#content');
		});
		$("#reset").click(function(){
			var tanggal = $('#waktu').val();
            $('#content').html("");
            $('#waktu').val("<?php echo date("Y-m-d");?>");
		});
		
		$('#old_button').click(function(){
			$('#old_date').show();
			$(this).hide();
		
		});
	});
	
	contentloader('<?= app_base_url('akuntansi/control/pengelolaan-kas?') ?>tanggal=<?php echo date("d/m/Y");?>','#content');
	
</script>
<h2 class="judul">Laporan Pengelolaan Kas</h2>

<input type="button" class="stylebutton" value="Generate Hari Kemarin" id="old_button">
<div id="old_date" style="display: none">
	<form action="" id="form" method="post" >
    <div class="data-input">
        <fieldset><legend>Tampil Laporan Pendapatan Harian</legend>
            <label for="waktu">Cari Berdasar Tanggal </label>
			<input type="text" name="waktu" id="waktu" value="<?php echo date("d/m/Y");?>" class="timepicker" Autocomplete="off" readonly="readonly" />
			<label></label>
			<input type="button" value="Display" name="display" class="stylebutton" id="display"/> 
			<input type="button" value="Reset" class="stylebutton space"/>
        </fieldset>
    </div>
	</form>
</div>



<div id="content"></div>