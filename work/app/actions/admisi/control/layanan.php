<?php
require_once 'app/lib/common/master-data.php';
if(isset ($_POST['add'])){
$nama=$_POST['nama'];
    $sql = "insert into layanan (nama,id_instalasi,id_spesialisasi,bobot,jenis,id_kategori_tarif) values ('$_POST[nama]','$_POST[idInstalasi]','$_POST[idSpesialisasi]','$_POST[kategori]','$_POST[jenis]','$_POST[idk_tarif]')";
    $insert = _insert($sql);
    $id=_last_id();
    if($insert){
        header("location: ".app_base_url('admisi/data-layanan')."?msg=1&code=".$id);
    }
}else if(isset ($_POST['edit'])){
    $sql = "update layanan set nama='$_POST[nama]',id_instalasi='$_POST[idInstalasi]',id_spesialisasi='$_POST[idSpesialisasi]',bobot='$_POST[kategori]',jenis='$_POST[jenis]',id_kategori_tarif='$_POST[idk_tarif]' where id='$_POST[idLayanan]'";
    $update = _update($sql);
    if($update){
        header("location: ".app_base_url('admisi/data-layanan')."?msg=1&code=".$_POST['idLayanan']);
    }
}else if(isset ($_GET['id'])){
    ?>
  <h2 class="judul">Master Data Layanan</h2>
<?
//  delete_list_data($_GET['id'], 'layanan', 'admisi/data-layanan?msg=2','admisi/data-layanan?msr=7');
$row = layanan_muat_data($_GET['id']);
if ($row[0]['bobot'] == 'Tanpa Bobot') $bobot = "";
else $bobot = $row[0]['bobot'];

if ($row[0]['profesi'] == 'Tanpa Profesi') $profesi = "";
else $profesi = $row[0]['profesi'];

$spesialisasi = "";
if ($row[0]['spesialisasi'] == 'Tanpa Spesialisasi') $spesialiasi= "";
else $spesialisasi = $row[0]['spesialisasi'];

if ($row[0]['instalasi'] == 'Tanpa Instalasi') $instalasi= "";
else if ($row[0]['instalasi'] == 'Semua') $instalasi = "";
else $instalasi = $row[0]['instalasi'];


$layanans = "".$row[0]['nama']." $profesi $spesialisasi $bobot $instalasi";
	$table=array('tarif','kunjungan');
	foreach($table as $row){
	$sql = "select count(*) as jumlah from $row where id_layanan = '$_GET[id]'";
	$jml = _select_unique_result($sql);
	if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('admisi/data-layanan').'?msr=14'."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	} 
   }
delete_list_data2($layanans, 'admisi/data-layanan/?msg=2', 'admisi/data-layanan?msr=7', array(0=>"delete from layanan where id='$_GET[id]'",1=>"delete from tarif where id_layanan='$_GET[id]'"),generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
?>
