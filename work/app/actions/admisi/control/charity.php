<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'app/lib/common/functions.php';
$idCharity = isset($_POST['id_charity']) ? $_POST['id_charity']:NULL;
$charity   = isset($_POST['jenisCharity']) ? $_POST['jenisCharity']:NULL;
$idDelete   = isset($_GET['id']) ? $_GET['id']:NULL;

if (isset($_POST['add'])) {
    $sql = _insert("insert into jenis_charity values('','$charity')");
    if ($sql) {
        header("location:".app_base_url('admisi/data-charity')."?msg=1");
    }
}
else if (isset($_POST['edit'])) {
    $sql = _update("update jenis_charity set jenis_charity = '$charity' where id_jenis_charity = '$idCharity'");
    if ($sql) {
        header("location:".app_base_url('admisi/data-charity')."?msg=1");
    }
}
else if (!empty($idDelete)) {
?>
    <h1 class="judul">Master Data Charity</h1>
<?
    delete_list_data($idDelete, 'jenis_charity', 'admisi/data-charity?msg=2',null);
}
?>
