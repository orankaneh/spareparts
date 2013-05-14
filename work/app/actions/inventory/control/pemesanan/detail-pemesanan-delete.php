<?php
    $sql="delete from detail_pemesanan_faktur where id='$_GET[id]'";
    $status=array('status'=>  _delete($sql));
    die(json_encode($status));
?>
