<?php
$idProvinsi = $_POST['idProvinsi_kab'];
$kabupaten  = ucwords($_POST['kabupaten_kab']);
$kode       = $_POST['kabupaten_code'];

$sql = "INSERT INTO kabupaten VALUES ('','$kabupaten', '$idProvinsi', '$kode')";

$exe = mysql_query($sql) or die(mysql_error());
  $id = _last_id();
if ($exe) {
    header("location: ".app_base_url('admisi/data-wilayah2')."?msg=1&code=".$id."&tab=kab");
}