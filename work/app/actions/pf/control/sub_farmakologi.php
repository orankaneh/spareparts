<?php
if(isset($_POST['simpan'])){
 
    $nama=$_POST['nama'];
    $keterangan=$_POST['keterangan'];
    $farmakologi=$_POST['farmakologi'];
    if(isset($_POST['id'])&& $_POST['id']!=''){
        _update("update sub_farmakologi set nama='$nama', keterangan='$keterangan', id_farmakologi='$farmakologi' where id='$_POST[id]'");
		header('location:'.  app_base_url('pf/kamus-obat/farmakologi/?msg=1')."&tab=tab2&id_sub=".$_POST['id']);
    }else{
        _insert("insert into sub_farmakologi (nama,keterangan,id_farmakologi) values ('$nama','$keterangan','$farmakologi')");
			$farmakologi = _last_id();
		 header('location:'.  app_base_url('pf/kamus-obat/farmakologi/?msg=1')."&tab=tab2&id_sub=".$farmakologi);
    }
}else if(isset($_GET['do']) && $_GET['do']=='delete'){
$sql = "select count(*) as jumlah from sub_sub_farmakologi where id_sub_farmakologi = '$_GET[id_gol]'";
	$jml = _select_unique_result($sql);
if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('pf/kamus-obat/farmakologi/').'?msr=14&tab=tab2');
	} else {
    delete_list_data($_GET['id_gol'], 'sub_farmakologi', 'pf/kamus-obat/farmakologi/?msg=2','pf/kamus-obat/farmakologi/?msr=7',NULL,NULL,"tab2",generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	} 
}
?>
