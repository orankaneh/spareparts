<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

if (isset($_POST['save'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
	$sub_diskripsi = $_POST['subDeskripsi'];
    if ($_POST['id'] == '') {
        $exe = _insert("insert INTO icd_10 VALUES ('','$kode','$nama', '$sub_diskripsi')");
    } else {
        $exe = _update("update icd_10 set kode = '$kode', nama = '$nama', sub_diskripsi = '$sub_diskripsi' where id = '$_POST[id]'");
    }
    if ($exe) {
        header("location:".app_base_url('rekam-medik/icd_10')."?msg=1");
    } else {
        header("location:".app_base_url('rekam-medik/icd_10')."?msr=8");
    }
}

if (isset($_POST['hapus'])) {
    $exe = _delete("delete from icd_10 where id = '$_POST[idformhapus]'");
    if ($exe) {
        header("location:".app_base_url('rekam-medik/icd_10')."?msg=2");
    } else {
        header("location:".app_base_url('rekam-medik/icd_10')."?msr=14");
    }

}

?>
