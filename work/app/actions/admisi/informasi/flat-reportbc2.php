<?php
require_once 'app/lib/common/functions.php';
set_time_zone();
require_once 'app/lib/erpiegrid/src/ErpieGrid/Autoloader.php';
$PAGE_TITLE = '<h2 class=judul>Laporan Kunjungan Rawat Jalan Flat</h2>';
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));

$tableTitle="<h2 class=table-title>Daftar Pasien<br>Periode ".  indo_tgl($startDate)." s.d ".  indo_tgl($endDate) . "</h2>.";
$optionVal='
<div class=data-input>
<fieldset><legend>Filter options</legend>
    <fieldset class=field-group>
        <legend>Awal - Akhir</legend>
        <input type="text" class="tanggal" name="startDate" value='.$startDate.'> <span style="font-size:11px;padding-top:5px;margin-right:5px"> s / d</span> <input type="text" name="endDate" class="tanggal" value='.$endDate.'>
    </fieldset>
';

$conf = include APP_APP_PATH . '/config/dbGrid.php';
$dsn = sprintf('mysql:host=%s;dbname=%s', $conf['host'], $conf['dbname']);
try {
    $GLOBALS['pdo'] = new PDO($dsn, $conf['username'], $conf['password']);
    $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

ErpieGrid_Autoloader::register();


$sql= "
     SELECT
        p.id as noRm,
        pd.nama as nama,
        pd.tanggal_lahir as tglLahir,
        pd.jenis_kelamin as jeKel,
        kw.perkawinan as stskw,
        pdd.nama as pdd,
        pr.nama as profesi,
        a.nama as agama,
        dp.alamat_jalan as almtJln,
        pnj.nama as pngJwb,
        tj.nama as layanan,
        ins.nama as rujukan,
        pdu.nama as nakes,
        sp.nama as spesialisasi,
        inst.nama as instalasi,
        pr2.nama as profSpes,
        tj.bobot,
        tj.jenis,
        if(kj.no_kunjungan_pasien='1',1,null) as pasien_baru
    FROM penduduk pd
    JOIN pasien p ON ( p.id_penduduk = pd.id )
    LEFT JOIN dinamis_penduduk dp ON ( dp.id_penduduk = pd.id )
    LEFT JOIN perkawinan kw ON ( dp.status_pernikahan = kw.id_perkawinan )
    LEFT JOIN pendidikan pdd ON ( pdd.id = dp.id_pendidikan_terakhir )
    LEFT JOIN agama a ON ( a.id = dp.id_agama )
    LEFT JOIN profesi pr ON ( pr.id = dp.id_profesi )
    LEFT JOIN kunjungan kj on (p.id = kj.id_pasien)
    LEFT JOIN penduduk pnj on (kj.id_penduduk_penanggungjawab = pnj.id)
    LEFT JOIN layanan tj on (tj.id=kj.id_layanan)
    LEFT JOIN rujukan rj on (rj.id=kj.id_rujukan)
    LEFT JOIN instansi_relasi ins on (ins.id=rj.id_instansi_relasi)
    LEFT JOIN penduduk pdu on (pdu.id=kj.id_penduduk_dpjp)
    LEFT JOIN bed on bed.id=kj.id_bed
    LEFT JOIN kelas on kelas.id=bed.id_kelas
    LEFT JOIN spesialisasi sp on sp.id=tj.id_spesialisasi
    LEFT JOIN instalasi inst on inst.id=tj.id_instalasi
    LEFT JOIN profesi pr2 on pr2.id=sp.id_profesi
    WHERE bed.id_kelas = 1 and dp.akhir = 1 and date(kj.waktu)>='".date2mysql($startDate)."' and  date(kj.waktu)<='".date2mysql($endDate)."'
";

$baseURL = app_base_url().'/admisi/informasi/flat-report';
$erpieGrid = new ErpieGrid_Facade(new ErpieGrid_Adapter_PDO($GLOBALS['pdo']));

$erpieGrid->setBaseURL($baseURL)
        ->bind($sql, array(
            'id' => array(
                'column' => 'noRm',
                'label' => 'ID RM',
                'asIdentifier' => true,
                'shownByDefault' => true),
            'nama' => array(
                'column'=>'nama',
                'shownByDefault' => true,
                'filter' => new ErpieGrid_Filter_Text()),
            'tipe' => array(
                'column'=>'pasien_baru',
                'label'=>'Tipe Pasien',//null untuk pasien lama, not null untuk pasien baru
                'filter' => new ErpieGrid_Filter_EnumNull(array('1'=>'baru',null=>'lama'))),
            'profSpes'=>array(
                'label'=>'ProfesiSpesialisasi',
                'column'=>'profSpes',
                'shownByDefault'=>true,
                'filter' => new ErpieGrid_Filter_Text()),
            'spesialisasi'=>array(
                'label'=>'Spesialisasi',
                'column'=>'spesialisasi',
                'shownByDefault'=>true,
                'filter' => new ErpieGrid_Filter_Text()),
            'bobot'=>array(
                'label'=>'Bobot',
                'column'=>'bobot',
                'shownByDefault'=>true,
                'filter' => new ErpieGrid_Filter_Text()),
            'instalasi'=>array(
                'label'=>'Instalasi',
                'column'=>'instalasi',
                'shownByDefault'=>true,
                'filter' => new ErpieGrid_Filter_Text()),
            'layanan' => array(
                'column'=>'layanan',
                'label'=>'Layanan yang dituju',
                'shownByDefault' => true,
                //'filter' => new ErpieGrid_Filter_PDOEnum($GLOBALS['pdo'],"select l.id,concat_ws(' ',l.nama,sp.nama,p.nama) as nama from layanan l left join spesialisasi sp on (l.id_spesialisasi=sp.id) left join profesi p on (sp.id_profesi=p.id) " )),
                'filter' => new ErpieGrid_Filter_Text()),
            'tglLahir' => array(
                'label'=>'Tanggal Lahir',
                'column'=>'tglLahir',
                'shownByDefault' => false,
                'filter' => new ErpieGrid_Filter_DateTime()),
            'jenisKel' => array(
                'label'=>'Jenis Kelamin',
                'column'=>'jeKel',
                'shownByDefault' => false,
                'filter' => new ErpieGrid_Filter_Enum(array('L'=>'L','P'=>'P'))),
            'statusKawin' => array(
                'column'=>'stskw',
                'label'=>'Status Kawin',
                'shownByDefault' => false,
                'filter' => new ErpieGrid_Filter_PDOEnum($GLOBALS['pdo'], 'SELECT perkawinan, perkawinan FROM perkawinan ')),
            'pdd' => array(
                'column'=>'pdd',
                'label'=>'Pendidikan',
                'shownByDefault' => false,
                'filter' => new ErpieGrid_Filter_PDOEnum($GLOBALS['pdo'], 'SELECT nama, nama FROM pendidikan')),
            'profesi' => array(
                'column'=>'profesi',
                'label'=>'Profesi',
                'shownByDefault' => false,
                'filter' => new ErpieGrid_Filter_PDOEnum($GLOBALS['pdo'], 'SELECT nama, nama FROM profesi order by nama')),
            'agama' => array(
                'column'=>'agama',
                'label'=>'Agama',
                'shownByDefault' => false,
                'filter' => new ErpieGrid_Filter_PDOEnum($GLOBALS['pdo'], 'SELECT nama, nama FROM agama order by nama')),
            'alamat' => array(
                'column'=>'almtJln',
                'shownByDefault' => true,
                'filter' => new ErpieGrid_Filter_Text()),
            'pngJwb' => array(
                'label'=>'Penanggung Jawab',
                'column'=>'pngJwb',
                'shownByDefault' => true,
                'filter' => new ErpieGrid_Filter_Text()),
            'nakes' => array(
                'column'=>'nakes',
                'label'=>'Nakes',
                'shownByDefault' => true,
                'filter' => new ErpieGrid_Filter_Text()),
            'rujukan'=>array(
                'label'=>'Rujukan',
                'column'=>'rujukan',
                'shownByDefault'=>false,
                'filter' => new ErpieGrid_Filter_Text())
        ));

$gridData = $erpieGrid->acquire($_GET);

echo app_core_render(APP_APP_PATH.'/views/gridKunjungan/master.php', array(
    'pageTitle' => $PAGE_TITLE,
    'baseURL' => $baseURL,
    'gridData' => $gridData,
    'tableTitle'=>$tableTitle,
    'optionVal'=>$optionVal
    ));

$page=$_SERVER['PHP_SELF'];
//potong index.php (ada 9 karakter)
$page=substr($page, 0,  strlen($page)-9);
$uri=$_SERVER['REQUEST_URI'];
//potong string admisi/informasi/flat-report-fix?
$uri=substr($uri, strlen($page)+29);

 if(isset ($_GET['Apply'])){ ?>
<span class="cetak" <?="onclick=window.open('$page"."admisi/informasi/flat-report-rep?$uri','popup','width=1000','height=650')"?>>Cetak</span>
<a class="excel" href="<?=app_base_url("admisi/informasi/excel/flat-report-rep?$uri")?>">Cetak</a>
<? } ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.tanggal').datepicker({dateFormat:'dd/mm/yy'});
        //$('#layanan_option').children().eq(1).attr("name","");
        //$('#layanan_option').children().last().css("display","none");
        $('#layanan_option').children().eq(2).autocomplete("<?= app_base_url('/admisi/search?opsi=layanan_rawat_jalan') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result>'+data.nama;
                        str+=(data.profesi=='Tanpa Profesi'||data.profesi=='Semua')?' ':' '+data.profesi;
                        str+=(data.spesialisasi=='Tanpa Spesialisasi'||data.spesialisasi=='Semua')?' ':' '+data.spesialisasi;
                        str+=(data.bobot=='General'||data.bobot=='Tanpa Bobot'||data.bobot=='Semua')?' ':' '+data.bobot;
                        str+=(data.instalasi=='Tanpa Instalasi'||data.instalasi=='Semua')?' ':' '+data.instalasi;
                        //str+=(data.kelas=='Tanpa Kelas'||data.kelas=='Semua')?' ':' '+data.kelas;
                        str+='</div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                var str=data.nama;
                str+=(data.profesi=='Tanpa Profesi'||data.profesi=='Semua')?' ':' '+data.profesi;
                str+=(data.spesialisasi=='Tanpa Spesialisasi'||data.spesialisasi=='Semua')?' ':' '+data.spesialisasi;
                str+=(data.bobot=='General'||data.bobot=='Tanpa Bobot'||data.bobot=='Semua')?' ':' '+data.bobot;
                str+=(data.instalasi=='Tanpa Instalasi'||data.instalasi=='Semua')?' ':' '+data.instalasi;
                $('#layanan_option').children().eq(2).attr('value',str);
                $('#layanan_option').children().eq(1).attr('value',data.nama);
                //$('#layanan_option').children().last().attr('value',data.id);
            }
        );
        
        $('#filterOptionComp').change(function(){
            $('#layanan_option').children().eq(1).css("display","none");    
            $('#layanan_option').children().eq(2).css("display","block");
        });
        $('#layanan_option').children().eq(1).css("display","none");
        
        /*$("form input[type=submit]").click(function(event){
            event.preventDefault();
            $(".selected-parts").append('<option selected="selected" value="spesialisasi"> spesialisasi </option>');
            $(".selected-parts").append('<option selected="selected" value="instalasi"> instalasi </option>');
            $(".selected-parts").append('<option selected="selected" value="bobot"> bobot </option>');
            $(".selected-parts").append('<option selected="selected" value="jenis"> jenis </option>');
            $("form input[type=submit]").unbind('click').click();
        })*/
        var i;
        for(i=1;i<5;i++){
            $("#filterOptionComp").children().eq(3).remove();
            $(".selected-parts").children().eq(3).remove();
        }
    })
</script>