<?php
require_once "app/lib/common/functions.php";


set_time_zone();
if (isset($_GET['show'])) {
    if (isset($_GET['awal'])) {
        $awal = date2mysql($_GET['awal']);
	$akhir= date2mysql($_GET['akhir']);
    }
    ob_start(); 
	if ($_GET['period'] == 1) {
		
		if (strtotime($akhir) < strtotime($awal)) {
			echo json_encode(array('error' => 'Tanggal akhir harus lebih besar dari tanggal awal'));
        	exit;
		}
	}
	
	if ($_GET['period'] == 3) {
		if (empty($_GET['thawal']) or empty($_GET['thakhir'])) {
			echo json_encode(array('error' => 'Tahun awal atau tahun akhir harus dipilih'));
        	exit;
		} else if ($_GET['thakhir'] < $_GET['thawal']) {
			echo json_encode(array('error' => 'Tanggal akhir harus lebih besar dari tanggal awal'));
        	exit;
		}
	}
	
	if ($_GET['period'] == 4) {
		if ($awal > $akhir) {
			echo json_encode(array('error' => 'Tanggal akhir harus lebih besar dari tanggal awal'));
        	exit;
		}
	}
	if($_GET['idLap']==15){
            require_once  "app/actions/admisi/informasi/per-pivot-return.php";
            require_once  "app/actions/admisi/informasi/per-pivot-return-asuransi.php";
        }else
            require_once  "app/actions/admisi/informasi/per-pivot-return.php";

?>
<!--</div>-->
    <?php
    echo json_encode(array('content' => ob_get_clean()));
    exit;
}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#tombol').click(function(){
		$('#master').slideToggle('fast');
	});
});
</script>

<div class="judul">Rekap Total Pasien Per Periode </div>
<fieldset><legend>Form pencarian </legend>
    <div class="data-input">
            <span class="error"></span>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" name="form">
               <label for="period">Periode</label>
                <select name="period" id="period">
                        <option value="0">Pilih periode</option>
                        <option value="1">Harian</option>
                        <option value="2">Mingguan</option>
                        <option value="3">Bulanan</option>
                        <option value="4">Tahunan</option></select>

               <div class="baris lanjutan-period" id="field-period"> </div>

               <label for="laporan">Laporan didasarkan</label>
                        <select name="idLap" id="idLap">
                            <option value="0">Pilih komponen</option>
                            <option value="2">Jenis Kelamin </option>
                            <option value="13">Tipe Pasien </option>
                            <option value="3">Status Perkawinan</option>
                            <option value="4">Pendidikan</option>
                            <option value="5">Pekerjaan</option>
                              <option value="16">Profesi</option>
                            <option value="6">Agama</option>
                            <option value="7">Alamat: Desa / Kelurahan</option>
                            <option value="8">Alamat: Kecamatan</option>
                            <option value="9">Alamat: Kabupaten</option>
                            <option value="10">Alamat: Propinsi</option>
                            <option value="11">Layanan</option> 
                            <option value="12">Cara Pembiayaan</option>
                            <option value="14">Asal Rujukan</option>
                            <option value="15">Asuransi Produk</option>
                        </select>

                <div class="baris lanjutan" id="field-dinamis">

                </div>
                <fieldset class="input-process">
                        <input type="button" id="show-report" value="Display" class="tombol aksi-lanjut" />
                        <input type="button" id="exit-report" value="Batal" class="tombol aksi-lanjut" onclick="javascript:location.href='<?= app_base_url('admisi/informasi/per-pivot-report') ?>'"/>
                </fieldset>
          </form>

    </div>
    </fieldset>
<div class='table-report-admisi'></div>
<!--</div>-->

<script type="text/javascript">
(function($){

    $(document).ready(function(){
        
        $('.lanjutan').hide();
        $('.error').hide();
        $('.table-report-admisi').hide();
        $('input.aksi-lanjut').attr('disabled', 'disabled');

        $('select[name=period]').change(function(){
            var tipe = $(this).val();
            $.get('<?=app_base_url('/admisi/informasi/per-pivot-report-period') ?>',{period:tipe},function(data){
                $('#field-period').html(data);
            });

            $('.lanjutan-period').show();
            
        });


        $('select[name=idLap]').change(function(){
            var tipe = $(this).val();

            $.get('<?=app_base_url('/admisi/informasi/per-pivot-report-komponen') ?>',{idLap:tipe},function(data){
                $('#field-dinamis').html(data);
            });

            $('.lanjutan').show();
            $('input.aksi-lanjut').removeAttr('disabled');
        });


        $('#show-report').click(function(){
			$('#master').show();
			$('#tombol').show();
			
			var param = $('form').serialize()+'&show=1';
            $.getJSON('<?=app_base_url('/admisi/informasi/per-pivot-report') ?>', param, function(data) {
                var errHolder = $('.error'),
                    cntHolder = $('.table-report-admisi');

                errHolder.hide();
                cntHolder.hide();

                if (data.error) errHolder.html(data.error).show();
                if (data.content) cntHolder.html(data.content).show();
				/*var selected = $("#idLap option:selected");
				var berdasar = "";
				if (berdasar.val() != 0) {
					var berdasar = + selected.val();
				}
				$(".berdasar").html(berdasar);*/
            });
			
            return false;
        });
    });

})($);
</script>