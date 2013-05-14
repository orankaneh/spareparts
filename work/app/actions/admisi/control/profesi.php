<?php
require_once 'app/lib/common/functions.php';
$idDelete	= isset($_GET['id']) ? $_GET['id'] : NULL;
$id		= isset($_POST['idProfesi']) ? $_POST['idProfesi'] : null;

if(isset ($_POST['add']))
{
	$nama	= $_POST['profesi'];
        $jenis = $_POST['jenis'];
    $exe	= _insert("insert into profesi (nama,jenis) values ('$_POST[profesi]','$jenis')");
	$id		= _last_id();
    if ($exe)
		header("location: ".app_base_url('admisi/data-profesi')."?msg=1&code=".$id);
} else if(isset ($_POST['edit']))
{
$id=$_POST['idProfesi'];
	$exe = _update("update profesi set nama='$_POST[profesi]',jenis='$_POST[jenis]' where id='$_POST[idProfesi]'");
    if ($exe)
		header("location: ".app_base_url('admisi/data-profesi')."?msg=1&code=".$id);
} else if(isset ($_GET['id']))
{
?>
    <h1 class="judul">Master Data Profesi</h1>
<?php
$sql = "select count(*) as jumlah from dinamis_penduduk where id_profesi= '$idDelete'";
	$jml = _select_unique_result($sql);
	if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('admisi/data-profesi').'?msr=14');
	} else {
	delete_list_data($idDelete, 'profesi', 'admisi/data-profesi?msg=2','admisi/data-profesi?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	}
}
?>