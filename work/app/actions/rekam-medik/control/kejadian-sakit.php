<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

if(isset ($_POST['submit'])){
    $nama = $_POST['nama'];
    $waktu_kejadian = datetime2mysql($_POST['waktu_kejadian']);
    $waktu_tiba = datetime2mysql($_POST['waktu_tiba']);
    $alamat = $_POST['alamat'];
    $id_kelurahan = $_POST['id_kelurahan'];
    $penyebab_cedera = $_POST['penyebab_cedera'];
    
    if($_POST['id'] == ""){
       $query = "insert into kejadian_sakit (nama,waktu_tiba,waktu_kejadian,alamat_jalan,id_kelurahan,penyebab_cedera)
                 values('$nama','$waktu_tiba','$waktu_kejadian','$alamat','$id_kelurahan','$penyebab_cedera')";  
       $exe = _insert($query);
    }else{
       $query = "update kejadian_sakit set nama='$nama',waktu_tiba='$waktu_tiba',waktu_kejadian='$waktu_kejadian',alamat_jalan='$alamat',id_kelurahan='$id_kelurahan',penyebab_cedera='$penyebab_cedera' where id='$_POST[id]'";
       $exe = _update($query); 
    }
    
    if($exe){
        header("location:".app_base_url('rekam-medik/kejadian-sakit')."?msg=1");
    }else{
        header("location:".app_base_url('rekam-medik/kejadian-sakit')."?msr=8");
    }
}
if(isset ($_POST['hapus'])){
    $exe = _delete("delete from kejadian_sakit where id = '$_POST[idformhapus]'");
    if ($exe) {
        header("location:".app_base_url('rekam-medik/kejadian-sakit')."?msg=2");
    } else {
        header("location:".app_base_url('rekam-medik/kejadian-sakit')."?msr=14");
    }
}
?>
