<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$provinsi = ucwords($_POST['provinsi_prov']);
$code     = $_POST['provinsi_code'];
$sql      = "INSERT INTO provinsi VALUES ('','$provinsi', '$code')";

$exe = mysql_query($sql) or die(mysql_error());
  $id = _last_id();
if ($exe) {
    header("location: ".app_base_url('admisi/data-wilayah2')."?msg=1&code=".$id."&tab=prov");
}
?>