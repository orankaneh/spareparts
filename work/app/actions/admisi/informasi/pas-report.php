<?php
include_once "include_once.php";

if ($_GET['show']) {

	$awal = "".date2mysql($_GET[awal])." 00:00:00";
	$akhir= "".date2mysql($_GET[akhir])." 23:59:59";

    ob_start(); 
	if ($_GET[awal] > $_GET[akhir]) {
		echo json_encode(array('error' => 'Tanggal akhir harus lebih besar dari tanggal awal'));
		exit;
	} 
	include_once "return-pas.php";

?>
</div>
    <?php
    echo json_encode(array('content' => ob_get_clean()));
    exit;
}

ob_start();
?>
<div class="judul">Form Laporan Rekap Pasien</div>
<div class="dasar">
        <span class="error"></span>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" name="form">
            <div class="baris">
                <div class="selL">Awal - akhir periode</div>
                <div class="selR">
                    <input type="text" name="awal" class="formKcl" id="awal" value='<? echo date("d/m/Y");?>' />
                    &nbsp;&nbsp;&nbsp; s . d &nbsp;&nbsp;&nbsp;
                    <input type="text" name="akhir" class="formKcl" id="akhir" value='<? echo date("d/m/Y");?>' />
                </div>
            </div>

            <div class="baris">
                <div class="selL">Laporan didasarkan</div>
                <div class="selR">
                    <select name="idLap" id="idLap">
                        <option value="0">Pilih komponen</option>
                        <option value="2">Jenis Kelamin </option>
                        <option value="3">Status Perkawinan</option>
                        <option value="13">Tipe Pasien</option>
                        <option value="4">Pendidikan</option>
                        <option value="5">Pekerjaan</option>
                        <option value="6">Agama</option>
                        <option value="7">Alamat: Desa / Kelurahan</option>
                        <option value="8">Alamat: Kecamatan</option>
                        <option value="9">Alamat: Kabupaten</option>
                        <option value="10">Alamat: Propinsi</option>
                        <option value="11">Tujuan Kunjungan</option>
                        <option value="12">Cara Pembiayaan</option>
                        <option value="14">Instansi Rujukan</option>
                    </select>
                </div>
            </div>

            <div class="baris lanjutan" id="field-dinamis">
                <div class="selL">&nbsp;</div>
                <div class="selR">
                    <input type="text" disabled class="form" />
				</div>
            </div>

            <div class="baris">
                <div class="selL">&nbsp;</div>
                <div class="selR">
                    <input type="button" id="show-report" value="Display" class="tombol aksi-lanjut" />
                    <input type="button" id="exit-report" value="Keluar" class="tombol aksi-lanjut" onclick="javascript:location.href='pas-report.php'" />
                </div>
            </div>
        </form>
    </div>
    <div class='table-report-admisi'></div>
</div>

<script type="text/javascript">
(function($){

    $(document).ready(function(){
        $('.multiselect').multiselect();
        $('.lanjutan').hide();
        $('.error').hide();
        $('.table-report-admisi').hide();
        $('input.aksi-lanjut').attr('disabled', 'disabled');

        $('select[name=idLap]').change(function(){
            var tipe = $(this).val();

            $.get('pas-report-komponen.php',{idLap:tipe},function(data){
                $('#field-dinamis').html(data);
            });

            $('.lanjutan').show();
            $('input.aksi-lanjut').removeAttr('disabled');
        });


        $('#show-report').click(function(){
			
			
			
			var param = $('form').serialize()+'&show=1';
            $.getJSON('pas-report.php', param, function(data) {
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

})(jQuery);
</script>
<?php

$isi = ob_get_clean();
include_once "instansiasi.php";
?>