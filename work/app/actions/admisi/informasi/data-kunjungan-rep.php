<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

set_time_zone();
include_css();

$sort=(isset($_GET['sort']))?$_GET['sort']:null;
$by=(isset($_GET['by']))?$_GET['by']:'asc';
$category = (isset($_GET['kategori']))?$_GET['kategori']:NULL;
$key = (isset($_GET['key']))?$_GET['key']:NULL;

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));

//membuat link sorting
if($sort=='no_rm' && $by=='asc')
    $no_rm=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=no_rm&by=desc');
else
    $no_rm=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=no_rm&by=asc');

if($sort=='waktu' && $by=='desc')
    $waktu=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=waktu&by=asc');
else
    $waktu=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=waktu&by=desc');

if($sort=='nama' && $by=='asc')
    $nama=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=nama&by=desc');
else
    $nama=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=nama&by=asc');

$startDate=date2mysql($startDate);
$endDate=date2mysql($endDate);

if($sort==null)
    $kunjungan = kunjungan_rj_muat_data(null,$startDate,$endDate,$category,$key);
else
    $kunjungan = kunjungan_rj_muat_data(null,$startDate,$endDate,$category,$key,$sort,$by);


?>
<center>
    <h1>LAPORAN KUNJUNGAN PASIEN</h1>
    <h2>Periode <?= indo_tgl(datefmysql($startDate))." s.d ".  indo_tgl(datefmysql($endDate))?></h2>
</center>
<div class="data-list">
<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel">
		
    <tr>
        <th><a href="<?= $waktu?>" class="sorting">Tanggal</a></th>
        <th>Layanan</th>
        <th>Nakes</th>
        <th><a href="<?=$no_rm?>" class="sorting">No. RM</a></th>
        <th><a href="<?=$nama?>" class="sorting">Nama</a></th>
        <th>Sex</th>
        <th>Umur (Thn)</th>
        <th>Pernikahan</th>
        <th>No. Kunjungan</th>
    
    </tr>
    <?php foreach($kunjungan as $num => $row):
        if($row['tanggal'] == ""){
            echo "";
        }else{
        if ($row['bobot'] == 'Tanpa Bobot') $bobot = "";
                else $bobot = $row['bobot'];

        if ($row['profesi'] == 'Tanpa Profesi') $profesi = "";
        else $profesi = $row['profesi'];

        $spesialisasi = "";
        if ($row['spesialisasi'] == 'Tanpa Spesialisasi') $spesialiasi= "";
        else $spesialisasi = $row['spesialisasi'];

        if ($row['instalasi'] == 'Tanpa Instalasi') $instalasi= "";
        else if ($row['instalasi'] == 'Semua') $instalasi = "";
        else $instalasi = $row['instalasi'];


        $layanan = "".$row['layanan']." $profesi $spesialisasi $bobot $instalasi";
                
	if($row['aidi'] == 4)
        $preview	= 'lembar-ugd-depan';
    else
		$preview	= 'lembar-poliklinik';
		?>
    <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <td align="center" style="width:10%"><?= datefmysql($row['waktu'])." ".$row['jam'] ?></td>
     
	<td align="center"><?= $layanan ?></td>
       <td align="center"><?= $row['dokter'] ?></td>
        <td align="center"><a href="<?= app_base_url('admisi/detail-kunjungan')?>?id=<?= $row['id_kunjungan']?>" class=link title="Detail"><?= $row['no_rm'] ?></a></td>
        <td class="no-wrap" style="width:20%"><a href="<?= app_base_url('admisi/detail-kunjungan')?>?id=<?= $row['id_kunjungan']?>" class=link title="Detail"><?= $row['nama'] ?></a></td>
        <td align="center"><?= $row['jenis_kelamin'] ?></td>
        <td align="center" style="width:5%"><?= hitungUmur2($row['tanggal_lahir']) ?></td>
        <td class="no-wrap" style="width:5%"><?= $row['perkawinan'] ?></td>
        <td align="center" style="width:8%"><?= $row['no_kunjungan_pasien'] ?></td>
    </tr>
    <?php } endforeach; ?>
            
</table>
</div>
<?exit;?>