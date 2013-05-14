<?php
require_once "app/lib/common/master-data.php";
require_once "app/lib/common/functions.php";
require_once "app/actions/admisi/informasi/adm-report-func.php";
require_once "app/lib/admisi/atribut-pelaporan.php";

$reporting = reporting_data_attribute();

set_time_zone();

if (isset($_GET["show"]) && $_GET["show"]) {

	$awal = (isset($_GET['awal']) && $_GET['period']!=4)?date2mysql($_GET['awal']):null;
	$akhir= (isset($_GET['akhir'])&& $_GET['period']!=4)?date2mysql($_GET['akhir']):null;

    ob_start();
	if ($_GET["period"] == 1) {

		if (strtotime($akhir) < strtotime($awal)) {
			echo json_encode(array("error" => "Tanggal akhir harus lebih besar dari tanggal awal"));
        	exit;
		}
	}

        if ($_GET["period"] == 2) {

		if (strtotime($akhir) < strtotime($awal)) {
			echo json_encode(array("error" => "Tanggal akhir harus lebih besar dari tanggal awal"));
        	exit;
		}
	}

	if ($_GET["period"] == 3) {
		if (empty($_GET[thawal]) or empty($_GET[thakhir])) {
			echo json_encode(array("error" => "Tahun awal atau tahun akhir harus dipilih"));
        	exit;
		} else if ($_GET[thakhir] < $_GET[thawal]) {
			echo json_encode(array("error" => "Tanggal akhir harus lebih besar dari tanggal awal"));
        	exit;
		}
	}

	if ($_GET["period"] == 4) {
		if ($awal > $akhir) {
			echo json_encode(array("error" => "Tanggal akhir harus lebih besar dari tanggal awal"));
        	exit;
		}
	}
        
        $arr = array(isset($_GET['option1'])?$_GET['option1']:'',
		isset($_GET['option2'])?$_GET['option2']:'',
		isset($_GET['option3'])?$_GET['option3']:'',
		isset($_GET['option4'])?$_GET['option4']:'',
		isset($_GET['option5'])?$_GET['option5']:'',
		isset($_GET['option6'])?$_GET['option6']:'',
		isset($_GET['option7'])?$_GET['option7']:'',
		isset($_GET['option8'])?$_GET['option8']:'',
		isset($_GET['option9'])?$_GET['option9']:'',
		isset($_GET['option10'])?$_GET['option10']:'',
		isset($_GET['option11'])?$_GET['option11']:'',
		isset($_GET['option12'])?$_GET['option12']:'',
		);
        
        include_once 'return-per.php';

?>

    <?php
    echo json_encode(array("content" => ob_get_clean()));
    exit;
}

ob_start();

?>
<script type="text/javascript">
$(document).ready(function(){
    $("#tombol").click(function(){
        $(".data-input").slideToggle("fast");
    });
});
</script>

<div class="judul">Rekap Total Pasien Per Periode <span id="tombol">Show / hide</span></div>
<?
if (isset($_GET['show'])) {

    if (!admisi_check_report_params($_GET)) {
        echo json_encode(array('error' => 'Data tidak lengkap, Lengkapi kolom-kolom input yg dibutuhkan'));
        exit;
    }
    $map_kolom = admisi_get_report_columns_map();
    $report = admisi_fetch_report($_GET);
    ob_start(); ?>
	<link rel='stylesheet' href='public/scripts/sorter/style.css' />
    <div class="dasar">
        <h2 align="center">DAFTAR PASIEN BERDASARKAN <?php echo $report['title']['berdasar'] ?><br>
            PERIODE: <?php echo indoTgl($report['title']['awal']) ?> s.d <?php echo indoTgl($report['title']['akhir']) ?></h2>

       <table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style="width:100%">
		<thead>
            <tr>
                <th><h3>No</h3></th>
            <?php foreach ($report['columns'] as $var): ?>
                <th><h3><?php echo $map_kolom[$var]['label'] ?></h3></th>
            <?php endforeach ?>
            </tr>
        </thead><tbody>
        <?php foreach ($report['data'] as $no => $report_item): ?>
            <tr bgcolor="<?php echo ((++$no) % 2 == 0) ? "#F4F4F4" : "#FFFFFF"?>">
                <td align=center><?php echo $no ?></td>
				<?php foreach ($report['columns'] as $var): ?>
                    <td><?php echo $report_item[$map_kolom[$var]['alias']] ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
        </tbody>
       </table>

<?


$url = urldecode($_SERVER['REQUEST_URI']);
$replace = str_replace($_SERVER['PHP_SELF'], 'print/Adm-report/',$url);
echo "<center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./$replace','popup','width=1000,height=650,scrollbars=yes, resizable=no');\"></center>";
?>
</div>
    <?php
    echo json_encode(array('content' => ob_get_clean()));
    exit;
}
?>
<div class="data-input">

<fieldset><legend>Form pencarian pasien per-periode</legend>
<?
$array = array(array('var' => 'badeg', 'keterangan' => 'ngentut'),
               array('var' => 'pesing', 'keterangan' => 'pipis'));

foreach($array as $numb => $value) {
    //echo $array[$numb]['var'] ." ";
}
?>
<span class="error"></span>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" name="form">

<fieldset><legend>Periode</legend>
    <label for="period">Format Satuan</label>
        <select name="period" id="period">
        <option value="">Pilih periode</option>
        <option value="1">Harian</option>
        <option value="2">Mingguan</option>
        <option value="3">Bulanan</option>
            <option value="4">Tahunan</option>
    </select>

<div class="lanjutan-period" id="field-period">
</div>
</fieldset>

<fieldset><legend class="sort-by">Laporan didasarkan</legend>
<?
require_once 'app/actions/admisi/informasi/adm-report-komponen.php';
?>

</fieldset>
<div class="lanjutan" id="field-dinamis">

</div>
<fieldset class="input-process">&nbsp;

<input type="hidden" disabled class="form" />

<input type="submit" id="show-report" value="Display" class="tombol aksi-lanjut" />
<input type="button" id="exit-report" value="Batal" class="tombol aksi-lanjut" />

</fieldset>

</form>
</fieldset>
    <div class="table-report-admisi">
    </div>
</div>
<script type="text/javascript">
(function($){

    jQuery(document).ready(function(){
        $("#sorting").hide();
        $("#show-report").attr("disabled","disabled");
        $(".table-report-admisi").hide();
                
        $(".error").hide();
        $(".lanjutan").hide();
        $("select[name=period]").change(function(){
            var tipe = jQuery(this).val();

        $.get("<?= app_base_url("/admisi/informasi/per-report-period") ?>",{period:tipe},function(data){
            $("#field-period").html(data);
                $("#show-report").removeAttr("disabled","disabled");
        });

            $(".lanjutan-period").show();
        
        });


        $("select[id=idlaporan]").change(function(){
            var tipe = jQuery(this).val();

        for (i = 1; i <= 12; i++) {
            if (tipe == i) {
                $('#option'+i).show();
            }
        }

        $(".lanjutan").show();
        $("input.aksi-lanjut").removeAttr("disabled");
        });



        $("#show-report").click(function(){
			$("#master").hide();
			$("#tombol").show();

			var param = $("form").serialize()+"&show=1";
            $.getJSON("<?= app_base_url("/admisi/informasi/pivot-report") ?>", param, function(data) {
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



(function($){$(document).ready(function(){
    $('#reporting').partsSelector({enableMoveControls:false});
});})(jQuery);
</script>
