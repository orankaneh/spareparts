<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'app/lib/common/functions.php';
$idAsurance = isset($_POST['id_asuransi']) ? $_POST['id_asuransi']:NULL;
$asurance   = isset($_POST['jenisAsuransi']) ? $_POST['jenisAsuransi']:NULL;
$idDelete   = isset($_GET['id']) ? $_GET['id']:NULL;

if (isset($_POST['add'])) {
    $sql = _insert("insert into jenis_asuransi values('','$asurance')");
    if ($sql) {
        header("location:".app_base_url('admisi/data-asuransi')."?msg=1");
    }
}
else if (isset($_POST['edit'])) {
    $sql = _update("update jenis_asuransi set jenis_asuransi = '$asurance' where id_jenis_asuransi = '$idAsurance'");
    if ($sql) {
        header("location:".app_base_url('admisi/data-asuransi')."?msg=1");
    }
}
else if (!empty($idDelete)) {
?>
    <h1 class="judul">Master Data Asuransi</h1>
<?
    delete_list_data($idDelete, 'jenis_asuransi', 'admisi/data-asuransi?msg=2',null);
}
?>
