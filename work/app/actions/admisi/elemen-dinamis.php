<?php
include_once "app/lib/common/master-data.php";
if(isset ($_GET['ruang'])){
$kelas = kelas_muat_data_by_instalasi($_GET['ruang']);
?>
   <option value="">Pilih Kelas</option>   
<?
    foreach ($kelas as $kel){
?>
   <option value="<?= $kel['id']?>"><?= $kel['nama']?></option>
<?
    }
}else if(isset ($_GET['kelas'])){
$bed = bed_muat_data_by_kelas($_GET['kelas']);
?>
   <option value="">Pilih Bed</option>
<?   
   foreach ($bed as $row){
?>
   <option value="<?= $row['id']?>"><?= $row['nama']?></option>
<?   
   }
}
exit();
?>
