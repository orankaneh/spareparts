<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$provinsi   = ucwords($_POST['provinsi_prov']);
$code       = $_POST['provinsi_code'];
$idProvinsi = $_POST['idProvinsi_prov'];

$sql = "UPDATE provinsi SET nama = '$provinsi', kode = '$code' WHERE id = '$idProvinsi'";
$exe = mysql_query($sql) or die(mysql_error());

if ($exe) {
    header("location: ".app_base_url('admisi/data-wilayah2')."?msg=1&code=".$idProvinsi."&tab=prov");
}