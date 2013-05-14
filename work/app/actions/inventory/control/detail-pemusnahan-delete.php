<?php
    $sql="delete from detail_pemusnahan where id_detail_pemusnahan='$_GET[id]'";
    $status=array('status'=>  _delete($sql));
    die(json_encode($status));
?>
