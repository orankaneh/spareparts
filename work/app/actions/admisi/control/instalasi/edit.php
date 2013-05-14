<?php
$idInstalasi = $_POST['idInstalasi'];
$nama = $_POST['instalasi'];
$select = _select_arr("select * from instalasi where nama='$instalasi'");
$count = count($select);
if ($count > 0) {
    header('location:' . app_base_url('admisi/data-instalasi') . '?msr=12');
} else {
    $sql = "update instalasi set nama = '$nama' where id = '$idInstalasi'";
    $exe = mysql_query($sql);

    if ($exe) {
        header("location:" . app_base_url('/admisi/data-instalasi') . "?msg=1&code=$idInstalasi");
    }
}