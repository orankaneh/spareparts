<?php
if(isset($_POST['simpan'])){
    $nama=$_POST['nama'];
    $keterangan=$_POST['keterangan'];
    $farmakologi=$_POST['sub-farmakologi'];
	$idne=$_POST['id'];
    if(isset($_POST['id'])&& $_POST['id']!=''){
        _update("update sub_sub_farmakologi set nama='$nama', keterangan='$keterangan', id_sub_farmakologi='$farmakologi' where id='$_POST[id]'");
    }else{
        _insert("insert into sub_sub_farmakologi (nama,keterangan,id_sub_farmakologi) values ('$nama','$keterangan','$farmakologi')");
		$idne = _last_id();
    }
    header('location:'.  app_base_url('pf/kamus-obat/farmakologi/?msg=1')."&tab=tab3&code=".$idne);
}else if(isset($_GET['do']) && $_GET['do']=='delete'){
$sql = "select count(*) as jumlah from obat where 	id_sub_sub_farmakologi = '$_GET[id]'";
	$jml = _select_unique_result($sql);
if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('pf/kamus-obat/farmakologi/').'?msr=14&tab=tab3');
	} else {
    delete_list_data($_GET['id'], 'sub_sub_farmakologi', 'pf/kamus-obat/farmakologi/?msg=2','pf/kamus-obat/farmakologi/?msr=7',NULL,NULL,"tab3",generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	}
}
?>
