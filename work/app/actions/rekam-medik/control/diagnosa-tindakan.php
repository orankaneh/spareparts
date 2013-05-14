<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

if (isset($_POST['save'])) {
    $id_layanan = $_POST['layanan'];
    $data_icd10 = $_POST['nama'];
    $id_icd10   = $_POST['idicd'];
	$norm= $_POST['no-rm'];
	$namapasien= $_POST['nama'];

    $tindakan   = $_POST['namaTindakan'];
    $idTindakan = $_POST['idicdTindakan'];
    $diagnosa_temp=array();
    $tindakan_temp=array();
    foreach ($data_icd10 as $key => $rows) {
        if($id_icd10[$key] != ""){
            $sqls = "insert INTO diagnosa_rekam_medik values ('','$id_layanan','$id_icd10[$key]')";
            echo $sqls . "<br/>";
            $exe = _insert($sqls);  
            $diagnosa_temp[]=_last_id();
        }
    }
    $no=1;
    foreach ($tindakan as $keys => $datas) {
        if($idTindakan[$keys] != ""){
            $ic = isset($_POST['ic'.$no])?$_POST['ic'.$no]:NULL;
            if ($ic == NULL) {
                $ic = "Tidak";
            } else $ic = "Ya";
            $ic_temp[]=$ic;
            $sql = "insert INTO tindakan_rekam_medik VALUES ('','$id_layanan','$idTindakan[$keys]','$ic')";
            echo $sql . "<br/>";
            $no++;
            $exe = _insert($sql);
            $tindakan_temp[]=_last_id();
            //echo "$id_layanan $idTindakan[$keys] $ic[$keys]<br/>";
        }
    }
    
    $diagnosa_param=serialize($diagnosa_temp);
    $tindakan_param=serialize($tindakan_temp);
    header("location:".app_base_url('rekam-medik/diagnosa-tindakan')."?msg=1&norm=".$_POST['norm']."&diagnosa=$diagnosa_param&tindakan=$tindakan_param");
}
?>
