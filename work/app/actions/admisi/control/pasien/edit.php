<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'app/lib/common/functions.php';
$no_rm      = $_POST['noRekamMedik'];
$nama       = $_POST['nama'];
$alamat     = strip_tags($_POST['almt']);
$kelurahan  = $_POST['idKelurahan'];
$kelamin    = $_POST['jeKel'];
$tglLahir   = date2mysql($_POST['tglLahir']);
$umur       = $_POST['umur'];
$golDarah   = $_POST['gol_darah'];
$profesi    = $_POST['idPekerjaan'];
$idPro		= $_POST['idPekerjaan2'];
$agama      = $_POST['idAgama'];
$perkawinan = $_POST['idPerkawinan'];
$penduduk   = $_POST['idPenduduk'];

// penanggulangi gagal update jika reference kolom induk tidak diisi atau NULL value
$arr = array('index_',$kelurahan,$profesi,$agama,$perkawinan, $idPro);
$i=1;
$arr_length = count($arr);
while ($i < ($arr_length)) {
        $arr[$i]=trim($arr[$i]);
        if ($arr[$i] == ''){
                $arr[$i] = "NULL";
        }
++$i;
}

if (null == $umur && $tglLahir != NULL) {
    $tglLahir = $tglLahir; 
} else if($tglLahir == NULL && $umur != NULL){ 
    $tglLahir = tglLahir($umur); 
} else if($tglLahir != NULL && $umur != NULL){
    $tglLahir = $tglLahir;
}else $tglLahir = $tglLahir;

$sql = "update penduduk set nama = '$nama', jenis_kelamin = '$kelamin', gol_darah = '$golDarah', tanggal_lahir = '$tglLahir' where id = '$penduduk'";

mysql_query($sql) or die (mysql_error());
// cek apa data penduduk sudah ada di tabel dinamis penduduk
$count= mysql_num_rows(mysql_query("select id from dinamis_penduduk where id_penduduk = '$penduduk'"));

if ($count == 0) {
   $exe = mysql_query("insert into dinamis_penduduk (tanggal, id_penduduk, alamat_jalan, id_kelurahan, status_pernikahan, id_profesi, id_pekerjaan, id_agama) values (now(),'$penduduk','$alamat',{$arr[1]},{$arr[4]},{$arr[2]},{$arr[5]},{$arr[3]})")or die (mysql_error());
} else {
   $exe= mysql_query("update dinamis_penduduk set alamat_jalan = '$alamat', id_kelurahan = {$arr[1]}, status_pernikahan = '{$arr[4]}', id_profesi = {$arr[2]}, id_pekerjaan = {$arr[5]}, id_agama = {$arr[3]} where id_penduduk = '$penduduk' and akhir = '1'")or die (mysql_error());
}
_delete("delete from kunjungan where id_pasien=$no_rm");
_insert("insert into kunjungan 
            (id_pasien,no_antrian,waktu,no_kunjungan_pasien,rencana_cara_bayar,id_layanan,id_penduduk_dpjp,id_penduduk_penanggungjawab,id_penduduk_pengantar,id_rujukan,id_bed) 
            VALUES 
            ($no_rm,0,now(),$_POST[no_kunjungan],'Bayar Sendiri',NULL,NULL,NULL,NULL,NULL,NULL)");
if ($exe) {
   header("location:".app_base_url('/admisi/opname-pasien')."?msg=1");
}else{
//    header("location:".app_base_url('/admisi/opname-pasien')."?msr=8");
}
