<?php
if(isset ($_POST['add'])){
    $sediaan = $_POST['sediaan'];
    $keterangan = $_POST['keterangan'];
    
    _insert("insert into sediaan values ('','$sediaan')");
	$id = _last_id();
     header("location: ".app_base_url('pf/sediaan')."?msg=1&code=$id");
}else if(isset ($_POST['edit'])){
    $id = $_POST['idSediaan'];
    $sediaan = $_POST['sediaan'];
    $keterangan = $_POST['keterangan'];
    
    _update("update sediaan set nama='$sediaan' where id='$id'");
    header("location: ".app_base_url('pf/sediaan')."?msg=1&code=$id&id=$id");
}else if(isset ($_GET['id'])){
    delete_list_data($_GET['id'], 'sediaan','pf/sediaan?msg=2','pf/sediaan?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
?>
