<?php
$id = $_POST['id'];
$id_kapelayanan = $_POST['idk_pelayanan'];
$jasaSarana = strtoint($_POST['jasaSarana']);
$bhp = strtoint($_POST['bhp']);
$profit = $_POST['profit'];
$total = strtoint($_POST['total']);

$totalUtama = strtoint($_POST['totalUtama']);
$nakesUtama =$_POST['nakesUtama'];
$rsUtama =$_POST['rsUtama'];

$totalPendamping = strtoint($_POST['totalPendamping']);
$nakesPendamping =$_POST['nakesPendamping'];
$rsPendamping =$_POST['rsPendamping'];

$totalPendukung =strtoint( $_POST['totalPendukung']);
$nakesPendukung =$_POST['nakesPendukung'];
$rsPendukung =$_POST['rsPendukung'];
show_array($_POST);
if(isset($_POST['update'])){
    $sql = "update tarif set id_layanan='$id_kapelayanan', jasa_sarana='$jasaSarana',bhp='$bhp',total_utama='$totalUtama',persen_nakes_utama='$nakesUtama',persen_rs_utama='$rsUtama',
    total_pendamping='$totalPendamping',persen_nakes_pendamping='$nakesPendamping',persen_rs_pendamping='$rsPendamping',
    total_pendukung='$totalPendukung',persen_nakes_pendukung='$nakesPendukung',persen_rs_pendukung='$rsPendukung',persen_profit='$profit',total='$total'
    WHERE id='$id'";
    $act=_update($sql);
}else{
    $tarif=_select_unique_result("select * from tarif where id='$id'");
    _update("update tarif set status='Tidak' where id_layanan='$id_kapelayanan' and id_kelas='$tarif[id_kelas]'");
    $sql = "insert into tarif (id_layanan,id_kelas,jasa_sarana,bhp,total_utama,
        persen_nakes_utama,persen_rs_utama,total_pendamping,persen_nakes_pendamping,persen_rs_pendamping,total_pendukung,
        persen_nakes_pendukung,persen_rs_pendukung,persen_profit,total,status) VALUES ('$_POST[idk_pelayanan]','$tarif[id_kelas]',
        '$jasaSarana','$bhp','$totalUtama','$nakesUtama','$rsUtama','$totalPendamping','$nakesPendamping',
        '$rsPendamping','$totalPendukung','$nakesPendukung','$rsPendukung','$profit','$total','Berlaku')";
    $act=_insert($sql);
    $id=_last_id();
}

 if($act)
   header("location: " . app_base_url('admisi/data-tarif') . "?msg=1&id=$id");
else
    header("location: " . app_base_url('admisi/data-tarif') . "?msr=2");
