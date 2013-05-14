<?php
require_once "app/lib/common/functions.php";

set_time_zone();
if (isset($_GET['show'])) {
	$awal = (isset($_GET['awal']) && $_GET['period']!=4)?date2mysql($_GET['awal']):null;
	$akhir= (isset($_GET['akhir']) && $_GET['period']!=4)?date2mysql($_GET['akhir']):null;
        $button="";
	if ($_GET['period'] == 1) {
                $button="<span class=cetak class=tombol onclick=\"window.open('pivot-income-report?period=$_GET[period]&awal=$_GET[awal]&akhir=$_GET[akhir]','popup','width=1000,height=650,scrollbars=yes, resizable=no');\">Cetak</span>";
                $button.="<a class=excel class=tombol href=".app_base_url("admisi/informasi/excel/pivot-income-report?period=$_GET[period]&awal=$_GET[awal]&akhir=$_GET[akhir]").">Cetak</a>";
		if (strtotime($akhir) < strtotime($awal)) {
			echo json_encode(array('error' => 'Tanggal akhir harus lebih besar dari tanggal awal'));
        	exit;
		}
	}
        if($_GET['period']==2){
            $button="<span class=cetak class=tombol onclick=\"window.open('pivot-income-report?period=$_GET[period]&awal=$_GET[awal]&akhir=$_GET[akhir]','popup','width=1000,height=650,scrollbars=yes, resizable=no');\">Cetak</span>";
            $button.="<a class=excel class=tombol href=".app_base_url("admisi/informasi/excel/pivot-income-report?period=$_GET[period]&awal=$_GET[awal]&akhir=$_GET[akhir]").">Cetak</a>";
        }
	if ($_GET['period'] == 3) {
		if (empty($_GET['thawal']) or empty($_GET['thakhir'])) {
			echo json_encode(array('error' => 'Tahun awal atau tahun akhir harus dipilih'));
        	exit;
		} else if ($_GET['thakhir'] < $_GET['thawal']) {
			echo json_encode(array('error' => 'Tanggal akhir harus lebih besar dari tanggal awal'));
        	exit;
		}
                $button="<span class=cetak onclick=\"window.open('pivot-income-report?period=$_GET[period]&bln1=$_GET[bln1]&thawal=$_GET[thawal]&bln2=$_GET[bln2]&thakhir=$_GET[thakhir]','popup','width=1000,height=650,scrollbars=yes, resizable=no');\">Cetak</span>";
                $button.="<a class=excel class=tombol href=".app_base_url("admisi/informasi/excel/pivot-income-report?period=$_GET[period]&bln1=$_GET[bln1]&thawal=$_GET[thawal]&bln2=$_GET[bln2]&thakhir=$_GET[thakhir]").">Cetak</a>";
	}

	if ($_GET['period'] == 4) {
		if ($_GET['awal'] > $_GET['akhir']) {
			echo json_encode(array('error' => 'Tanggal akhir harus lebih besar dari tanggal awal'));
        	exit;
		}
                $button="<span class=cetak onclick=\"window.open('pivot-income-report?period=$_GET[period]&awal=$_GET[awal]&akhir=$_GET[akhir]','popup','width=1000,height=650,scrollbars=yes, resizable=no');\">Cetak</span>";
                $button.="<a class=excel class=tombol href=".app_base_url("admisi/informasi/excel/pivot-income-report?period=$_GET[period]&awal=$_GET[awal]&akhir=$_GET[akhir]").">Cetak</a>";
	}
       include_once "pivot-income-table.php";
       $content=getPivotIncomeTable($awal, $akhir,$_GET['period'])."<br>".$button;
    echo json_encode(array('content' => $content));
    exit;
}else{
?>
        <div class="judul">Rekap Total Pendapatan Per Periode</div>
        
            <div class="data-input" id="master">
                <fieldset><legend>Rekap Pendapatan Periode</legend>
                <span class="error"></span>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" name="form">
                    <label for="period">Periode</label>
                    <select name="period" id="period">
                    <option value="0">Pilih periode</option>
                    <option value="1">Harian</option>
                    <option value="2">Mingguan</option>
                    <option value="3">Bulanan</option>
                    <option value="4">Tahunan</option></select>
                    
                    <div class="baris lanjutan-period" id="field-period">

                    </div>
                    <fieldset class="input-process">
                    <input type="button" id="show-report" value="Display" class="tombol aksi-lanjut" />
                    <input type="button" id="exit-report" value="Batal" class="tombol aksi-lanjut" onclick="javascript:location.href='<?= app_base_url('admisi/informasi/pivot-income') ?>'"/>
                    </fieldset>
                </form>
                </fieldset>
            </div>
            <div class='table-report-admisi'></div>
       

        <script type="text/javascript">
        (function($){

            $(document).ready(function(){

                $('.lanjutan').hide();
                $('.error').hide();
                $('.table-report-admisi').hide();
                $('input.aksi-lanjut').attr('disabled', 'disabled');

                $('select[name=period]').change(function(){
                    var tipe = $(this).val();

                    $.get('<?= app_base_url('/admisi/informasi/per-report-period') ?>',{period:tipe},function(data){
                        $('#field-period').html(data);
                    });

                    $('.lanjutan-period').show();
                                if ($(this).val() != 0) {
                                        $('input.aksi-lanjut').removeAttr('disabled');
                                } else {
                                        $('input.aksi-lanjut').attr('disabled', 'disabled');
                                }

                });

                $('#show-report').click(function(){
                                var param = $('form').serialize()+'&show=1';
                    $.getJSON('<?= app_base_url('/admisi/informasi/pivot-income') ?>', param, function(data) {
                            var errHolder = $('.error'),
                            cntHolder = $('.table-report-admisi');
                            
                        errHolder.hide();
                        cntHolder.hide();

                        if (data.error) errHolder.html(data.error).show();
                        if (data.content) cntHolder.html(data.content).show();
                    });

                    return false;
                });
            });

        })($);
        </script>
        <?php
}
?>
