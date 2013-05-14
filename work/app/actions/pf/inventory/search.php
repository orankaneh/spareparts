<?php

require_once 'app/config/db.php';

if (isset($_GET['q'])) {
$q = strtolower($_GET['q']);
    
if($_GET['opsi'] == "provinsi")
{    
$sql = mysql_query("select * from provinsi where locate('$q', nama) > 0 order by locate('$q', nama)");

$hasil = array();
while ($data = mysql_fetch_object($sql)) {
	$hasil[] = $data;
}
die(json_encode($hasil));}

else if($_GET['opsi'] == "kabupaten")
{
    $provinsi = $_GET['idprovinsi'];
    
    $sql = mysql_query("select * from kabupaten where id_provinsi = '$provinsi'
    and locate('$q', nama) > 0 order by locate('$q', nama)");
    $hasil = array();
    while($data = mysql_fetch_object($sql))
    {
        $hasil[] = $data;
    }

    die(json_encode($hasil));
}

else if($_GET['opsi'] == "kecamatan")
{
    $kabupaten = $_GET['idkabupaten'];

    $sql = mysql_query("select * from kecamatan where id_kabupaten = '$kabupaten'
    and locate('$q', nama) > 0 order by locate('$q', nama)");
    $hasil = array();
    while($data = mysql_fetch_object($sql))
    {
        $hasil[] = $data;
    }

    die(json_encode($hasil));
}

else if ($_GET['opsi'] == "allKelurahan") {
    
    $sql = "select ku.id as id_kelurahan, ku.nama as nama_kelurahan, kc.nama as nama_kecamatan, k.nama as nama_kabupaten, p.nama as nama_propinsi from provinsi p, kabupaten k, kecamatan kc, kelurahan ku where p.id = k.id_provinsi and k.id = kc.id_kabupaten and kc.id = ku.id_kecamatan and locate('$q', ku.nama) > 0 order by locate('$q', ku.nama) limit 10";
    $exe = mysql_query($sql);
    $hasil = array();
    while ($row = mysql_fetch_array($exe)) 
    {
        $hasil[] = $row;
    }

    die(json_encode($hasil));
}
}
?>