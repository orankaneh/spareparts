<?php
require_once 'app/lib/common/functions.php';
if(isset ($_POST['add'])){
    $exe = _insert("insert into spesialisasi values('','$_POST[spesialisasi]','$_POST[idProfesi]')");
$id = _last_id();
    if($exe){
        header("location: ".app_base_url('admisi/data-spesialisasi')."?msg=1&code=".$id);
    }
}else if(isset ($_POST['edit'])){
$id=$_POST[idSpesialisasi];
    $exe = _update("update spesialisasi set nama='$_POST[spesialisasi]',id_profesi='$_POST[idProfesi]' where id='$_POST[idSpesialisasi]'");
    if($exe){
        header("location: ".app_base_url('admisi/data-spesialisasi')."?msg=1&code=".$id);
    }
}else if(isset ($_GET['id'])){
?>
    <h1 class="judul">Master Data Spesialisasi Profesi</h1>
<?
    //delete_list_data($_GET['id'], 'spesialisasi', 'admisi/data-spesialisasi?msg=2',null);
    $spesialiasi= _select_unique_result('select s.nama as spesialisasi,p.nama as profesi from spesialisasi s left join profesi p on s.id_profesi=p.id WHERE s.id='.$_GET['id']);    
    $dataname=$spesialiasi['profesi'].' '.$spesialiasi['spesialisasi'];
    delete_list_data2($dataname, 'admisi/data-spesialisasi?msg=2', '',array(0=>'DELETE FROM spesialisasi WHERE id='.$_GET['id']),generate_get_parameter($_GET, null, array('msr','msg','do','id')));
 }
?>
