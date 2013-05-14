<?php
if(isset($_POST["add"])){
    $title = $_POST['title'];
    
    _insert("insert into satuan values ('','$title')");
    $id = _last_id();
    header("location: ".app_base_url('pf/satuan?msg=1')."&code=$id");
}else if(isset ($_POST["edit"])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    
    _update("update satuan set nama='$title' where id='$id'");
    
    header("location: ".app_base_url('pf/satuan?msg=1')."&code=$id&id=$id");
}else if(isset($_GET['id'])){
    delete_list_data($_GET['id'], 'satuan', 'pf/satuan?msg=2','pf/satuan?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
?>
