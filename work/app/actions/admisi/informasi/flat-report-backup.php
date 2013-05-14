<?php
require_once "app/lib/common/master-data.php";
require_once "app/lib/common/functions.php";
require_once "app/actions/admisi/informasi/adm-report-func.php";
require_once "app/lib/admisi/atribut-pelaporan.php";

$reporting = reporting_data_attribute();
set_time_zone(); // mendefiniskan default time zone
?>
<script type="text/javascript">
$(document).ready(function(){
    $("#tombol").click(function(){
            $("fieldset").slideToggle("fast");
    });
});
</script>
<div class="judul">Laporan admision <span id="tombol">Show / hide</span></div>
<fieldset><legend>Form pelaporan admisi</legend>
<div class="data-input">
        <span class="error"></span>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="get" name="form">
            <fieldset class="field-group">
                <legend>Awal - akhir periode</legend>
                &nbsp;<input type="text" id="awal" name="awal" value="<?= date("d/m/Y") ?>" class="tanggal" />
            
            <label for="akhir" class="inline-title">&nbsp; &nbsp; &nbsp; s . d &nbsp; &nbsp; &nbsp;</label>
            <input type="text" id="akhir" name="akhir" value="<?= date("d/m/Y") ?>" class="tanggal" />

        </fieldset>
        <label for="idlaporan">Laporan didasarkan</label>
                    <select name="idlaporan" id="idlaporan">
                        <option value="0">Pilih komponen</option>
                        <option value="1">No. Rekam Medik</option>
                        <option value="2">Nama </option>
                        <option value="3">Tipe Pasien</option>
                        <option value="4">Jenis Kelamin</option>
                        <option value="5">Status Perkawinan</option>
                        <option value="6">Pendidikan</option>
                        <option value="7">Pekerjaan</option>
                        <option value="8">Agama</option>
                        <option value="9">Alamat: Desa / Kelurahan</option>
                        <option value="10">Cara Pendaftaran</option>
                        <option value="11">Tujuan Kunjungan</option>
                        <option value="12">Cara Pembiayaan</option>
                    </select>

            <div class="lanjutan" id="field-dinamis">
              	
            </div>
			<label for="reporting" class="field-title">Atribut yang dilaporkan</label>
            <select id="reporting" name="reporting[]" multiple="multiple" class="field-title">
                <? foreach ($reporting as $report): ?>
                <option value="<?= $report['value'] ?>"><?= $report['nama'] ?></option>
                <? endforeach ?>
            </select>

			<fieldset class="input-process">
                    <input type="button" id="show-report" value="Display" class="tombol aksi-lanjut" />
                    <input type="button" id="exit-report" value="Batal" class="tombol aksi-lanjut" />
			</fieldset>
        	</form>
    	</div> 	  
	</div>
</fieldset>
<div class="table-report-admisi">

<? 

if (isset($_GET["show"]) && $_GET["show"]) {
	
    if (!admisi_check_report_params($_GET)) {
        echo json_encode(array("error" => "Data tidak lengkap, Lengkapi kolom-kolom input yg dibutuhkan"));
        exit;
    }
    $map_kolom = admisi_get_report_columns_map();
    $report = admisi_fetch_report($_GET);
   
     ?>
    <div class="data-list">
        <h2 align="center">DAFTAR PASIEN BERDASARKAN <?php echo $report["title"]["berdasar"] ?><br>
            PERIODE: <?= indo_tgl($report['title']['awal']) ?> s.d <?= indo_tgl($report['title']['akhir']) ?></h2>
            
       <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel">
		
            <tr>
                <th><h3>No</h3></th>
            <?php foreach ($report["columns"] as $var): ?>
                <th><h3><?php echo $map_kolom[$var]["label"] ?></h3></th>
            <?php endforeach ?>
            </tr>
        
        <?php foreach ($report["data"] as $no => $report_item): ?>
            <tr bgcolor="<?php echo ((++$no) % 2 == 0) ? "#F4F4F4" : "#FFFFFF"?>">
                <td align=center><?php echo $no ?></td>
				<?php foreach ($report["columns"] as $var): ?>
                    <td><?php echo $report_item[$map_kolom[$var]["alias"]] ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
        
        </table>
        </div>

<? 


$url = urldecode($_SERVER["REQUEST_URI"]);
$replace = str_replace($_SERVER["PHP_SELF"], "print/Adm-report/",$url);
?>


</div>
    <?php
   
    exit;
}

?>

<script type="text/javascript">
(function($){

    $(document).ready(function(){
		$(".table-report-admisi").hide();
		$(".error").hide();
		$(".lanjutan").hide();
		$("select[id=idlaporan]").change(function(){
            var tipe = $(this).val();

            $.get("<?= app_base_url('/admisi/informasi/adm-report-komponen') ?>",{idlaporan:tipe},function(data){
                $("#field-dinamis").html(data);
            });

            $(".lanjutan").show();
            $("input.aksi-lanjut").removeAttr("disabled");
			return false;
        });
		
		
		
        $("#show-report").click(function(){
			$("#master").hide();
			$("#tombol").show();
            var param = $("form").serialize()+"&show=1";

            $.getJSON("<?= app_base_url('/admisi/informasi/flat-report') ?>", param, function(data) {
                var errHolder = $(".error"),
                    cntHolder = $(".table-report-admisi");

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
<script type="text/javascript">
(function($){$(document).ready(function(){
    $('#reporting').partsSelector({enableMoveControls:false});
});})($);
</script>