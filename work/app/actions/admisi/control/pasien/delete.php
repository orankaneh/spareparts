<?php
require_once 'app/lib/common/master-data.php';
$pasien=  pasien_opname_muat_data($_GET['id']);
delete_list_data2($pasien['nama'], 'admisi/opname-pasien?msg=2', 'admisi/opname-pasien?msr=7', 
            array("delete from kunjungan where id_pasien=$pasien[id_pas]",
                "delete from pasien where id=$pasien[id_pas]",
                ));
?>
