<?php
$id_kecamatan = $_POST['idKecamatan_kel'];
$kelurahan    = ucwords($_POST['kelurahan_kel']);
$kode         = $_POST['kelurahan_code'];

$query = "INSERT INTO kelurahan(nama,id_kecamatan,kode) VALUES ('$kelurahan','$id_kecamatan','$kode')";

$exe = mysql_query($query) or die(mysql_error());
$id = _last_id();
if($exe){
    header("location: ".app_base_url('admisi/data-wilayah2')."?msg=1&code=".$id."&tab=kel");
}
?>
