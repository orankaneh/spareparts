<?
set_time_zone();
?>

<?php
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
        require_once  "app/actions/rekam-medik/informasi/info-10-besar-penyakit-return.php";
?>
<?php
echo json_encode(array('content' => ob_get_clean()));
exit();
}
?>
<h2 class="judul"><a href="<?= app_base_url('rekam-medik/info-10-besar-penyakit') ?>">Informasi 10 Besar Penyakit</a></h2>
<div class="data-input">
    <span class="error"></span>
    <fieldset><legend>Parameter Pencarian</legend>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
          <label for="period">Periode</label>
            <select name="period" id="period">
                    <option value="0">Pilih periode</option>
                    <option value="1">Harian</option>
                    <option value="2">Mingguan</option>
                    <option value="3">Bulanan</option>
                    <option value="4">Tahunan</option>
            </select>
          <div class="baris lanjutan-period" id="field-period"> </div>  
          <label for="barang">Jumlah Baris</label>
          <input type="text" name="jumlah_baris"  id="jumlah_baris" value="10"/>
          <label for="jenis">Jenis Pelayanan</label>
          <select name="jenis" id="jenis">
            <option value="">Pilih jenis pelayanan</option>
            <option value="Rawat Jalan">Rawat Jalan</option>
            <option value="Rawat Inap">Rawat Inap</option>
           </select>
          <fieldset class="input-process">
              <input type="button" id="show-report" value="Display" class="tombol aksi-lanjut" />
              <input type="button" id="exit-report" value="Batal" class="tombol aksi-lanjut" onclick="javascript:location.href='<?= app_base_url('rekam-medik/info-10-besar-penyakit') ?>'"/>
          </fieldset>
        </form>
    </fieldset>
</div>
<div class='table-report-10-besar-penyakit'></div>

<script type="text/javascript">
(function($){    
  $(document).ready(function(){
        $('.error').hide();
        $('.table-report-10-besar-penyakit').hide();
        $('input.aksi-lanjut').attr('disabled', 'disabled');
        
        $('select[name=period]').change(function(){
            var tipe = $(this).val();
            
            $.get('<?=app_base_url('/admisi/informasi/per-report-period') ?>',{period:tipe},function(data){
                $('#field-period').html(data);
            });

            $('.lanjutan-period').show();
            $('input.aksi-lanjut').removeAttr('disabled');
        });
        
        $('#show-report').click(function(){
                $('#tombol').show();
	        var param = $('form').serialize()+'&show=1';
                $.getJSON('<?=app_base_url('/rekam-medik/info-10-besar-penyakit') ?>', param, function(data) {
                var errHolder = $('.error'),
                    cntHolder = $('.table-report-10-besar-penyakit');

                errHolder.hide();
                cntHolder.hide();

                if (data.error) errHolder.html(data.error).show();
                if (data.content){
                  cntHolder.html(data.content).show();
                } 
            });
			
            return false;
        });
  })
})($);  
</script>
 