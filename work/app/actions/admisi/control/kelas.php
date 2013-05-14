<?php
if(isset($_POST['simpan'])){
    $nama=$_POST['nama'];
	$id=$_POST['id'];
    if(isset($_POST['id'])&& $_POST['id']!=''){
        _update("update kelas set nama='$_POST[nama]', margin='$_POST[margin]' where id='$_POST[id]'");

    }else{
        _insert("insert into kelas (nama,margin) VALUES ('$_POST[nama]','$_POST[margin]')");
		  $id = _last_id();
    }
    header('location:'.  app_base_url('admisi/kelas/')."?msg=1&code=".$id);
}else if(isset($_GET['do']) && $_GET['do']=='delete'){
    require_once 'app/lib/common/master-data.php';
    $instalasi=kelas_muat_data($_GET['id']);  
	$table=array('bed','tarif');
	foreach($table as $row){
	$sql = "select count(*) as jumlah from $row where id_kelas = '$_GET[id]'";
	$jml = _select_unique_result($sql);
	if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('admisi/kelas/').'?msr=14'."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	} 
   }
    delete_list_data2($instalasi['nama'], 'admisi/kelas/?msg=2', 'admisi/kelas/?msr=7',array(1=>"delete from kelas where id='$_GET[id]'"),generate_get_parameter($_GET, null, array('msr','msg','do','id')));

}
?>
