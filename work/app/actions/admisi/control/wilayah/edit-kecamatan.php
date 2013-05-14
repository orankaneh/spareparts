<?php
$id_kabupaten  = $_POST['idKabupaten_kec'];
$id_kecamatan  = $_POST['idKecamatan_kec'];
$namaKecamatan = ucwords($_POST['kecamatan_kec']);
$kode          = $_POST['kecamatan_code'];

$query = "UPDATE kecamatan SET nama = '$namaKecamatan', id_kabupaten = '$id_kabupaten', kode='$kode' WHERE id = '$id_kecamatan'";
$exe = mysql_query($query) or die(mysql_error());

if($exe){
     header("location: ".app_base_url('admisi/data-wilayah2')."?msg=1&code=".$id_kecamatan."&tab=kec");
}
?>
