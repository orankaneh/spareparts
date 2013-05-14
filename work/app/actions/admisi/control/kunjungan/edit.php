<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'app/lib/common/functions.php';

$admisionId = $_POST['id'];
$residentId = $_POST['id_penduduk'];
$name       = $_POST['nama'];
$address    = $_POST['alamatJln'];
$village    = $_POST['idKel'];
$sex        = $_POST['jeKel'];
$marriage   = $_POST['idPerkawinan'];
$dateOfBirth= $_POST['tglLahir'];
$age        = $_POST['umur'];
$job        = $_POST['pekerjaan'];
$religion   = $_POST['agama'];

$array = array('',$admisionId, $name, $address, $village, $sex, $marriage, $job, $religion);

    for ($i = 1; $i <= count($array) - 1; $i++) {
        if (empty($array[$i])) {
            header("location:".app_base_url('admisi/edit-kunjungan?id='.$admisionId.'')."&msr=3");
        }
    }

    if (!empty($age)) {
        $dateOfBirth = tglLahir($age);
    } else {
        $dateOfBirth = date2mysql($dateOfBirth);
    }

    
    $a = _update("update penduduk set nama = '$array[2]', jenis_kelamin = '$array[5]', tanggal_lahir = '$dateOfBirth' where id = '$residentId'");
    $b = _update("update dinamis_penduduk set alamat_jalan = '$address', id_kelurahan = '$village', status_pernikahan = '$marriage', id_profesi = '$job', id_agama = '$religion' where id_penduduk = '$residentId'");
    if ($a && $b) {
        header("location:".app_base_url('admisi/informasi/data-kunjungan')."?msg=1");
    }
?>
