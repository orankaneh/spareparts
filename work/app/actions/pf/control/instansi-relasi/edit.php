<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$telpon = $_POST['telpon'];
$email = $_POST['email'];
$fax = $_POST['fax'];
$website = $_POST['website'];
$nama     = $_POST['nama'];
$alamat   = $_POST['alamat'];
$kelurahan= $_POST['id-kelurahan'];
$jenisInstansi = $_POST['relasiInstansi'];
$id       = $_POST['idInstansi'];
$sql = "update instansi_relasi set nama = '$nama', alamat = '$alamat',telp='$telpon',email='$email',fax='$fax',website='$website', id_kelurahan = '$kelurahan', id_jenis_instansi_relasi = '$jenisInstansi' where id = '$id'";
$exe = mysql_query($sql);

if ($exe) {
    header("location: ".app_base_url('pf/inventory/instansi-relasi/?code=').$id."&msg=1");
}
?>
