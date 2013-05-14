<?php
if(isset($_POST["add"])){
    $nama = $_POST['nama'];
    _insert("insert into zat_aktif values ('','$nama')");
    $id = _last_id();
    header("location: ".app_base_url('pf/zat-aktif?msg=1')."&id=$id");
}else if(isset ($_POST["edit"])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];    
    _update("update zat_aktif set nama='$nama' where id='$id'");
    
    header("location: ".app_base_url('pf/zat-aktif?msg=1')."&id=$id");
}else if(isset($_GET['id'])){
    echo "<h2 class=judul>Master Zat Aktif</h2>";
    delete_list_data($_GET['id'], 'zat_aktif', 'pf/zat-aktif?msg=2','pf/zat-aktif?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
?>
