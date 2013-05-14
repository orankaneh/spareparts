<?php
if(isset($_POST['simpan'])){
    $nama=$_POST['nama'];
	  $idUnit=$_POST['id'];
    if(isset($_POST['id'])&& $_POST['id']!=''){
        _update("update unit set nama='$nama' where id='$_POST[id]'");
    }else{
        _insert("insert into unit (nama) values ('$nama')");
		  $idUnit = _last_id();
    }
    header('location:'.  app_base_url('admisi/unit')."?msg=1&code=".$idUnit);
}else if(isset($_GET['do']) && $_GET['do']=='delete'){
    delete_list_data($_GET['id'], 'unit', 'admisi/unit?msg=2','admisi/unit?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
?>
