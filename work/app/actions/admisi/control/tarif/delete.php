<h1 class="judul">ADMINISTRASI TARIF</h1>
<?php
require_once 'app/lib/common/master-data.php';
$data=tarif_muat_data($_GET['id']);
$layanan = "";
foreach ($data['list'] as $tarif);

$layanan.= $tarif['layanan'];

if ($tarif['profesi'] == 'Tanpa Profesi')
    $layanan.= "";
else
    $layanan.=" $tarif[profesi]";

if ($tarif['spesialisasi'] == 'Tanpa Spesialisasi')
    $layanan.= "";
else
    $layanan.=" $tarif[spesialisasi]";

if ($tarif['bobot'] == 'Tanpa Bobot')
    $layanan.= "";
else
    $layanan.=" $tarif[bobot]";

if ($tarif['jenis'] == "Rawat Inap")
    $layanan.=" $tarif[instalasi]";
else if ($tarif['instalasi'] == 'Rekam Medik' || $tarif['instalasi'] == 'Semua' || $tarif['instalasi'] == 'Tanpa Instalasi')
    $layanan.= "";
else
    $layanan.=" $tarif[instalasi]";

if ($tarif['kelas'] == 'Tanpa Kelas')
    $layanan.= "";
else
    $layanan.=" $tarif[kelas]";

delete_list_data($_GET['id'], 'tarif', 'admisi/data-tarif?msg=2', 'admisi/data-tarif?msr=7', '</b>tarif <b>'.$layanan.'</b></b>');
?>
