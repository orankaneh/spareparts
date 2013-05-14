<?php
if(isset($_POST['simpan'])){
    $nama=$_POST['nama'];
	 $id=$_POST['id'];
    if(isset($_POST['id'])&& $_POST['id']!=''){
        _update("update jenis_instansi_relasi set nama='$nama' where id='$_POST[id]'");
    }else{
        _insert("insert into jenis_instansi_relasi (nama) values ('$nama')");
		  $id = _last_id();
    }
    header('location:'.  app_base_url('admisi/jenis-instansi-relasi?msg=1')."&code=".$id);
}else if(isset($_GET['do']) && $_GET['do']=='delete'){
  $sql = "select count(*) as jumlah from instansi_relasi where id_jenis_instansi_relasi = '$_GET[id]'";
	$jml = _select_unique_result($sql);
	if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('admisi/jenis-instansi-relasi').'?msr=14'."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	} else {
    delete_list_data($_GET['id'], 'jenis_instansi_relasi', 'admisi/jenis-instansi-relasi?msg=2','admisi/jenis-instansi-relasi?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	}
}
?>
