<?
require_once 'app/lib/erpiegrid/src/ErpieGrid/Autoloader.php';
require_once "app/lib/common/functions.php";
header_excel("flat-report.xls");
$conf = include APP_APP_PATH . '/config/dbGrid.php';
set_time_zone();
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));


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
        dp.status_pernikahan as stskw,
        pdd.nama as pdd,
        pr.nama as profesi,
        a.nama as agama,
        dp.alamat_jalan as almtJln,
        pnj.nama as pngJwb,
        tj.nama as tujuan,
        ins.nama as rujukan,
        pdu.nama as nakes,
        if(kj.  no_kunjungan_pasien='1',1,null) as pasien_baru
    FROM penduduk pd
    JOIN pasien p ON ( p.id_penduduk = pd.id )
    LEFT JOIN dinamis_penduduk dp ON ( dp.id_penduduk = pd.id )
    LEFT JOIN pendidikan pdd ON ( pdd.id = dp.id_pendidikan_terakhir )
    LEFT JOIN agama a ON ( a.id = dp.id_agama )
    LEFT JOIN profesi pr ON ( pr.id = dp.id_profesi )
    LEFT JOIN kunjungan kj on (p.id = kj.id_pasien)
    LEFT JOIN penduduk pnj on (kj.id_penduduk_penanggungjawab = pnj.id)
    LEFT JOIN layanan tj on (tj.id=kj.id_layanan)
    LEFT JOIN rujukan rj on (rj.id=kj.id_rujukan)
    LEFT JOIN instansi_relasi ins on (ins.id=rj.id_instansi_relasi)
    LEFT JOIN penduduk pdu on (pdu.id=rj.id_penduduk_nakes)
    WHERE date(kj.waktu)>='".date2mysql($startDate)."' and date(kj.waktu)<='".date2mysql($endDate)."'
";
//echo $sql;

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
            'tujuan' => array(
                'column'=>'tujuan',
                'label'=>'Tujuan',
                'shownByDefault' => true,
                'filter' => new ErpieGrid_Filter_PDOEnum($GLOBALS['pdo'], 'SELECT nama, nama FROM instalasi order by nama')),
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
                'filter' => new ErpieGrid_Filter_PDOEnum($GLOBALS['pdo'], 'SELECT status_pernikahan,status_pernikahan FROM dinamis_penduduk ')),
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
            'nik' => array(
                'label'=>'nik',
                'column'=>'nik',
                'shownByDefault' => false,
                'filter' => new ErpieGrid_Filter_Text()),
            'nakes' => array(
                'column'=>'nakes',
                'label'=>'nakes',
                'shownByDefault' => true,
                'filter' => new ErpieGrid_Filter_Text()),
            'rujukan'=>array(
                'label'=>'Rujukan',
                'column'=>'rujukan',
                'shownByDefault'=>false,
                'filter' => new ErpieGrid_Filter_Text())
        ));

$gridData = $erpieGrid->acquire($_GET);
require_once 'app/actions/admisi/lembar-header.php';
$content=$tableTitle="<center><h1>Daftar Pasien</h1><br>Periode ".  indo_tgl($startDate)." s.d ".  indo_tgl($endDate)."</center>";
$content.=app_core_render(APP_APP_PATH.'/views/gridKunjungan/table-excel.php', array('gridData' => $gridData));
echo app_core_render(APP_APP_PATH.'/views/report.php',array(
            'content'=>$content,
            'title'=>'LAPORAN',
            'excel'=>true
        ));