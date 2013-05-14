<?php
if(isset($_POST['simpan'])){
    $nama=$_POST['nama'];
    $keterangan=$_POST['keterangan'];
    if(isset($_POST['id'])&& $_POST['id']!=''){
	$id=$_POST['id'];
        _update("update farmakologi set nama='$nama', keterangan='$keterangan' where id='$_POST[id]'");
    }	
	else{
	      
        _insert("insert into farmakologi (nama,keterangan) values ('$nama','$keterangan')");
     $id= _last_id();

	}
	  header("location: ".app_base_url('pf/kamus-obat/farmakologi/')."?msg=1&tab=tab1&code=".$id);
}else if(isset($_GET['do']) && $_GET['do']=='delete'){
$sql = "select count(*) as jumlah from sub_farmakologi where id_farmakologi = '$_GET[id]'";
	$jml = _select_unique_result($sql);
if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('pf/kamus-obat/farmakologi/').'?msr=14');
	} else {
    delete_list_data($_GET['id'], 'farmakologi', 'pf/kamus-obat/farmakologi/?msg=2','pf/kamus-obat/farmakologi/?msr=7',NULL,NULL,"tab1",generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
}
?>
