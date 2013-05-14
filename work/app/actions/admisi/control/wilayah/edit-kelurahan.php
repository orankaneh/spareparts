<?php
$id_kecamatan   = $_POST['idKecamatan_kel'];
$id_kelurahan   = $_POST['idKelurahan_kel'];
$nama_kelurahan = ucwords($_POST['kelurahan_kel']);
$kode           = $_POST['kelurahan_code'];

$query = "UPDATE kelurahan SET nama = '$nama_kelurahan', id_kecamatan = '$id_kecamatan', kode = '$kode' WHERE id = '$id_kelurahan'";
$exe = mysql_query($query) or die(mysql_error());

if($exe){
    header("location: ".app_base_url('admisi/data-wilayah2')."?msg=1&code=".$id_kelurahan."&tab=kel");
}
?>
