<?php
$bed = isset ($_POST['bed'])?$_POST['bed']:NULL;
$idBed = isset ($_POST['idBed'])?$_POST['idBed']:NULL;
$kelas = isset ($_POST['kelas'])?$_POST['kelas']:NULL;
$jenis = isset ($_POST['jenis'])?$_POST['jenis']:NULL;
$instalasi=isset ($_POST['instalasi'])?$_POST['instalasi']:NULL;
if(isset ($_POST['add'])){
    $sql = "insert into bed (nama,id_kelas,id_instalasi,status,jenis) values('$bed','$kelas','$instalasi','Kosong','$jenis')";
    $exe = _insert($sql);
    $id=_last_id();
    if($exe){
        header("location: ".app_base_url('admisi/data-bed')."?msg=1&code=$id");
    }
}else if(isset ($_POST['edit'])){
    $sql = "update bed set nama='$bed',id_kelas='$kelas',id_instalasi='$instalasi',jenis='$jenis' where id='$idBed'";
    $exe = _update($sql);
    if($exe){
        header("location: ".app_base_url('admisi/data-bed')."?msg=1&code=$idBed");
    }
}else if(isset ($_GET['id'])){
?>
  <h2 class="judul">Administrasi Kamar/Bed/Klinik</h2>
<?
    require_once 'app/lib/common/master-data.php';
  //delete_list_data($_GET['id'], 'bed', 'admisi/data-bed?msg=2',null);
  $bed=bed_muat_data_by_id($_GET['id']);
  $dataname=$bed['instalasi'].' '.$bed['kelas'].' '.$bed['nama'];
  delete_list_data2($dataname, 'admisi/data-bed?msg=2','admisi/data-bed?msr=7' ,array("delete from bed where id=".$_GET['id']),generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
?>
