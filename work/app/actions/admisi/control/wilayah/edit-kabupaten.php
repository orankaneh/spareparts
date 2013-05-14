<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$idProvinsi = $_POST['idprovinsi_kab'];
$idKabupaten= $_POST['idkabupaten_kab'];
$kodeKabupaten = $_POST['kabupaten_code'];
$kabupaten  = ucwords($_POST['kabupaten_kab']);

$sql = "UPDATE kabupaten SET nama = '$kabupaten',id_provinsi = '$idProvinsi', kode = '$kodeKabupaten' WHERE id = '$idKabupaten'";
$exe = _update($sql);

if ($exe) {
    header("location: ".app_base_url('admisi/data-wilayah2')."?msg=1&code=".$idKabupaten."&tab=kab");
}
?>