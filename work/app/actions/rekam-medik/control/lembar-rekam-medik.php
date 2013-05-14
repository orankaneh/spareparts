<?php
require_once 'app/lib/common/functions.php';
set_time_zone();

$norm = isset ($_POST['norm'])?$_POST['norm']:NULL;
$waktu = isset ($_POST['waktu'])?$_POST['waktu']:NULL;
$waktu_simpan = explode(" ", $waktu);
$waktu_simpan = date2mysql($waktu_simpan[0])." ".$waktu_simpan[1];
$id_bed = isset ($_POST['id_bed'])?$_POST['id_bed']:NULL;
$id_dokter = isset ($_POST['id_dokter'])?$_POST['id_dokter']:NULL;
$anamnesa = isset ($_POST['anamnesa'])?$_POST['anamnesa']:NULL;
$ku = isset ($_POST['ku'])?$_POST['ku']:NULL;
$laboratorium = isset ($_POST['laboratorium'])?$_POST['laboratorium']:NULL;
$radiologi = isset ($_POST['radiologi'])?$_POST['radiologi']:NULL;
$terapi = isset ($_POST['terapi'])?$_POST['terapi']:NULL;
$alasanDatang = isset ($_POST['alasanDatang'])?$_POST['alasanDatang']:NULL;
$id_kejadian = isset ($_POST['id_kejadian'])?$_POST['id_kejadian']:NULL;
$keterangan = isset ($_POST['keterangan'])?$_POST['keterangan']:NULL;
$resusitasi = isset ($_POST['resusitasi'])?$_POST['resusitasi']:NULL;
$tindakLanjut = isset ($_POST['tindakLanjut'])?$_POST['tindakLanjut']:NULL;
$jenis = isset ($_POST['jenis'])?$_POST['jenis']:NULL;

$array = array('',$id_kejadian);
for ($i = 0; $i < count($array); $i++) {
    if (empty($array[$i]) || $array[$i]=='' || $array[$i]==null ) {
        $array[$i] = "NULL";
    }
}
$queryRm = "insert into rekam_medik (anamnesis,pemeriksaan_ku,pemeriksaan_lab,pemeriksaan_radiologi,terapi,alasan_datang,id_kejadian_sakit,keterangan,tindakan_resusitasi,tindak_lanjut) 
           values ('$anamnesa','$ku','$laboratorium','$radiologi','$terapi','$alasanDatang',{$array[1]},'$keterangan','$resusitasi','$tindakLanjut')";

_insert($queryRm);
$idRM = mysql_insert_id();

$queryPelayanan = "insert into pelayanan (id,waktu,id_pasien,id_bed,id_dokter,jenis) values ('$idRM','$waktu_simpan','$norm',$id_bed,$id_dokter,'$jenis')";
_insert($queryPelayanan);



header("location:".app_base_url('/rekam-medik/informasi/detail-info-rekam-medik/')."?msg=1&norm=$norm&namaPasien=&tglLahir=&agama=&pekerjaan=&alamat=&kelurahan=&cari=Cari&id=".$idRM."&do=detail");
?>
