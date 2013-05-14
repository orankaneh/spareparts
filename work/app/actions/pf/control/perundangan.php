<?php
if(isset($_POST['simpan'])){
    $nama=$_POST['nama'];
    $keterangan=$_POST['keterangan'];
	$id=$_POST['id'];
    if(isset($_POST['id'])&& $_POST['id']!=''){
        _update("update perundangan set nama='$nama' where id='$_POST[id]'");
    }else{
        _insert("insert into perundangan (nama) values ('$nama')");
		  $id = _last_id();
    }
	header("location: ".app_base_url('pf/perundangan')."?msg=1&code=".$id);
}else if(isset($_GET['do']) && $_GET['do']=='delete'){
    //if($_GET['confirm'])
    //_delete("delete from farmakologi where id='$_GET[id]'");
    delete_list_data($_GET['id'], 'perundangan', 'pf/perundangan/?msg=2','pf/perundangan/?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
?>
