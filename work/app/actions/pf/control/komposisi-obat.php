<?php

if(isset($_POST['add'])){

$obat = $_POST['idobat'];
$zat_aktif = $_POST['zat_aktif'];
    if (count($zat_aktif) == 0) {
        header("location:".app_base_url('pf/komposisi-obat')."?msr=13");
    }
    else {
        _delete("delete from komposisi_obat where id_obat=$obat");
        foreach ($zat_aktif as $row) {
            $insert = _insert("insert into komposisi_obat values ('','$obat','$row')");
        }
        header("location:".app_base_url('pf/komposisi-obat')."?msg=1");
    }
}

?>