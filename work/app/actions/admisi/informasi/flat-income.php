<?
require_once "app/lib/common/functions.php";

set_time_zone(); // mendefiniskan waktu default server

?>

<?
if (isset($_GET['show'])) {
    require_once 'app/actions/admisi/informasi/flat-income-table.php';
        $dateAwal=(isset($_GET['awal']))?$_GET['awal']:date('d/m/y');
	$dateAkhir=(isset($_GET['akhir']))?$_GET['akhir']:date('d/m/y');
	$awal = date2mysql($dateAwal);
	$akhir= date2mysql($dateAkhir);
        $content=getFlatIncomeTable($awal,$akhir);
        $content.="
	<br><span onclick=window.open('".app_base_url("admisi/informasi/flat-income-report?awal=$_GET[awal]&akhir=$_GET[akhir]")."','popup','width=1000','height=650') class=cetak>Cetak</span>
        <a href='".app_base_url("admisi/informasi/excel/flat-income-report?awal=$_GET[awal]&akhir=$_GET[akhir]")."' class=excel>Cetak Excel</a></span>
	</div>
	</div>";
    echo json_encode(array('content' => $content));
    exit;
}else{
    ob_start();
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
                jQuery('#tombol').click(function(){
                        jQuery('#master').slideToggle('fast');
                });
        });
    </script>
    <h1 class="judul">Rekap Total Pendapatan Kunjungan</h1>
    <fieldset><legend>Form pencarian </legend>

            <div class="data-input pendaftaran">

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" name="form">

            <fieldset class="field-group">
                <legend for="awal">Awal - akhir periode</legend>
                <input type="text" id="awal" name="awal" value="<?= date("d/m/Y") ?>" class="tanggal" />

                <label for="akhir" class="inline-title"> s . d</label>
                <input type="text" id="akhir" name="akhir" value="<?= date("d/m/Y") ?>" class="tanggal" />

            </fieldset>

                <div class="baris lanjutan" id="field-dinamis">

                </div>

                &nbsp;
         <fieldset class="input-process">
            <input type="button" id="show-report" value="Display" class="tombol aksi-lanjut" />
            <input type="button" id="exit-report" value="Batal" class="tombol aksi-lanjut" onclick="javascript:location.href='<?= app_base_url('admisi/informasi/flat-income') ?>'" />
         </fieldset>
            </form>
            </div>
    </fieldset>
    <div class='table-report-admisi'></div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.lanjutan').hide();
            $('.error').hide();
            $('.table-report-admisi').hide();

            $("#show-report").click(function(){
			jQuery("#master").hide();
			jQuery("#tombol").show();
                        var param = $("form").serialize()+"&show=1";

                        $.getJSON("<?= app_base_url('/admisi/informasi/flat-income') ?>",param, function(data) {
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
    </script>
<?}?>