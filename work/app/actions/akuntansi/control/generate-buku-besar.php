<?php
    $exce=_insert("INSERT INTO saldo (jumlah,tanggal,id_rekening) values ('$_GET[jumlah]',now(),'$_GET[id_rekening]')");
    die(json_encode(array('status'=>$exce!=0)));
?>
