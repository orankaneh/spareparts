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
$select = _select_arr("select * from instansi_relasi where nama='$nama'");
        $count = count($select);
        if($count > 0){
            header('location:'.  app_base_url('pf/inventory/instansi-relasi').'?msr=12');
        }else{
$sql = "insert into instansi_relasi values ('','$nama','$alamat','$telpon','$email','$fax','$website','$kelurahan','$jenisInstansi')";
$exe = mysql_query($sql);
  $code = _last_id();
if ($exe) {
    header("location: ".app_base_url('pf/inventory/instansi-relasi/?code=').$code."&msg=1");
}
}
?>
