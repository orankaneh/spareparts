<?php
foreach ($_POST['barang'] as $row) {
    if ($row[margin] != null) {
        $sql = "update margin_packing_barang_kelas set nilai_persentase='$row[margin]' where id='$row[id_margin]'";
        _insert($sql);
    }
}
header('location:'.  app_base_url('inventory/adm-harga'));
?>
