<?php
$kecamatan    = ucwords($_POST['kecamatan_kec']);
$id_kabupaten = $_POST['idKabupaten_kec'];
$kode         = $_POST['kecamatan_code'];

$query = "INSERT INTO kecamatan VALUES ('', '$kecamatan','$id_kabupaten', '$kode')";
$exe   = mysql_query($query) or die($query.' <br />'.mysql_error());
$id    = _last_id();
if($exe){
    header("location: ".app_base_url('admisi/data-wilayah2')."?msg=1&code=".$id."&tab=kec");
}
?>
