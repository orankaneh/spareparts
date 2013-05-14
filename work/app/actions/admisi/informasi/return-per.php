<?
require_once 'app/lib/common/report-data.php';
require_once 'app/lib/admisi/atribut-pelaporan.php';
//echo urldecode($_SERVER['REQUEST_URI']);

$medicalRecord  = isset($_GET['noRm'])?$_GET['noRm']:'';
$name           = isset($_GET['nama'])?$_GET['nama']:'';
$patientType    = isset($_GET['tipepas'])?$_GET['tipepas']:'';
$sex            = isset($_GET['jeKel'])?$_GET['jeKel']:'';
$marriage       = isset($_GET['idPerkawinan'])?$_GET['idPerkawinan']:'';
$destination    = isset($_GET['idKunjungan'])?$_GET['idKunjungan']:'';
$education      = isset($_GET['idPendidikan'])?$_GET['idPendidikan']:'';
$job            = isset($_GET['idPekerjaan'])?$_GET['idPekerjaan']:'';
$religion       = isset($_GET['idAgama'])?$_GET['idAgama']:'';
$village        = isset($_GET['idKel'])?$_GET['idKel']:'';
$payment        = isset($_GET['idPembiayaan'])?$_GET['idPembiayaan']:'';



if ($_GET['period'] == 1) {

$difference = difference_time($_GET['awal'], $_GET['akhir']);
$colscount  = $difference + 2;
echo "
<div class=data-list>
    <center><b class=judul>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN <br/>PERIODE:$_GET[awal] s . d $_GET[akhir]</b></center>
    <table cellpadding='0' cellspacing='0' border='0' class='tabel'>

    <tr>
    <th rowspan='2' width='20'>No</th>
    <th rowspan='2' width='150'></th>";
    if ($destination and $patientType) {
        echo "<th rowspan='2' width='150'></th>";
    }

    echo "<th colspan='$colscount'>BANYAK PASIEN HARIAN</th></tr>";

    $date = explode("/",$_GET['awal']);
    for ($i = 0; $i <= $difference; $i ++) {
        $x  = mktime(0, 0, 0, date($date[1]), date($date[0])+$i, date($date[2]));
        $new = date("d M",$x);
        echo "<th>$new</th>";
        $tgl[] = date("Y-m-d",$x);
    }
    echo "<th>total</th></tr>";
if ($destination and empty($patientType)) {
    $showBy = "Tujuan Kunjungan";
    $data = report_instalasi_muat_data($destination);
    require_once 'app/actions/admisi/report/tujuan.php';
    //exit;
    
}
else if ($patientType and empty($destination)) {
    $showBy = "Tipe Pasien";
    $data = data_tipe_pasien($patientType);
    require_once 'app/actions/admisi/report/tipe-pasien.php';
    
}
else if ($sex) {
    $showBy = "Jenis Kelamin";
    $data = data_gender($sex);
    require_once 'app/actions/admisi/report/tipe-gender.php';

}
else if ($education) {
    $showBy = "Pendidikan Terakhir";
    $data = pendidikan_muat_data($education);
    require_once 'app/actions/admisi/report/pendidikan.php';

}
else if ($job) {
    $showBy = "Pekerjaan";
    $data = profesi_muat_data($job);
    require_once 'app/actions/admisi/report/pekerjaan.php';

}
else if ($religion) {
    $showBy = "Agama";
    $data = agama_muat_data($religion);
    require_once 'app/actions/admisi/report/agama.php';

}
else if ($village) {
    $showBy = "Alamat Kelurahan";
    $data = kelurahan_muat_data($village);
    require_once 'app/actions/admisi/report/alamat.php';

}
else if ($payment) {
    $showBy = "Pembayaran";
    $data = data_payment($payment);
    require_once 'app/actions/admisi/report/pembiayaan.php';
}

else if ($destination and $patientType) {
    $showBy = "Tipe Pasien & Kunjungan";
    $data = report_instalasi_muat_data($destination);
    require_once 'app/actions/admisi/report/tujuan-pasien.php';
}

echo "<tr><td align='center'></td><td align='center'>Total</td>";
    for ($i = 0; $i <= $difference; $i++) {
        echo "<td align='center'></td>";
    }
    echo "<td align='center'></td>
</tr>
</table>
</div>";
}
else if($_GET['period'] == 2){
  $sql = mysql_query("select week('".date2mysql($_GET['awal'])."',1) as minggu1, week('".date2mysql($_GET['akhir'])."',1) as minggu2");
  $rows = mysql_fetch_array($sql);

  $difference = $rows['minggu2'] - $rows['minggu1'];
  $a = mysql_fetch_array(mysql_query("select dayofweek('".date2mysql($_GET['awal'])."') as hari_ke"));

  $slh_hari = $a['hari_ke'] - 2; // inisialisasi awal hari senin
  if ($slh_hari == 0) {
    $tanggal = date2mysql($_GET['awal']);
  }
  if ($slh_hari > 0) {
    $tanggal = mysql_fetch_array(mysql_query("select '".date2mysql($_GET['awal'])."' - INTERVAL $slh_hari DAY as new_day"));
    //echo "select INTERVAL $slh_hari DAY - '".date2mysql($_GET[awal])."' as new_day";
    $tanggal = $tanggal['new_day'];
  }
  if ($slh_hari < 0) {
    $tanggal = mysql_fetch_array(mysql_query("select '".date2mysql($_GET['awal'])."' - INTERVAL $slh_hari DAY as new_day"));
    $tanggal = $tanggal['new_day'];
  }
  echo "
      <div class=data-list>
      <center><b class=judul>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN  <br/>PERIODE:$_GET[awal] s . d $_GET[akhir]</b></center>
      <table cellpadding='0' cellspacing='0' border='0' class='tabel'>
      <tr>
      <th rowspan='2' width='20'>No</th>
      <th rowspan='2' width='150'></th>
      <th colspan='".($difference+2)."'>BANYAK PASIEN MINGGUAN</th></tr>";

  $date = explode("-",$tanggal);
  $no = 0;
  for ($i = $rows['minggu1']; $i <= $rows['minggu2']; $i ++) {
    $x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$no), date($date[0]));
    $thn = date("Y-m-d",$x);
    $sqli = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

    echo "<th>$i</th>";
    $no += 1;
    }
    echo "<th>total</th></tr>";
    
    //
if ($destination) {
    $showBy = "Tujuan Kunjungan";
    $data = report_instalasi_muat_data($destination);
    require_once 'app/actions/admisi/report/tujuan.php';
    
    
}
if ($patientType) {
    $showBy = "Tipe Pasien";
    $data = data_tipe_pasien($patientType);
    require_once 'app/actions/admisi/report/tipe-pasien.php';
    
}
if ($sex) {
    $showBy = "Jenis Kelamin";
    $data = data_gender($sex);
    require_once 'app/actions/admisi/report/tipe-gender.php';

}
if ($education) {
    $showBy = "Pendidikan Terakhir";
    $data = pendidikan_muat_data($education);
    require_once 'app/actions/admisi/report/pendidikan.php';

}
if ($job) {
    $showBy = "Pekerjaan";
    $data = profesi_muat_data($job);
    require_once 'app/actions/admisi/report/pekerjaan.php';

}
if ($religion) {
    $showBy = "Agama";
    $data = agama_muat_data($religion);
    require_once 'app/actions/admisi/report/agama.php';

}
if ($village) {
    $showBy = "Alamat Kelurahan";
    $data = kelurahan_muat_data($village);
    require_once 'app/actions/admisi/report/alamat.php';

}
if($marriage){
    $showBy = "Status Perkawinan";
    require_once 'app/actions/admisi/report/status-perkawinan.php';
}
if($name){
    $showBy = "Nama";
    require_once 'app/actions/admisi/report/nama.php';
}
if($payment){
    $showBy = "Pembiayaan";
    require_once 'app/actions/admisi/report/pembiayaan.php';
}
//
$sumarray = "";
echo "<tr><td align='center'></td><td align='center'>Total</td>";
    for ($i = 0; $i <= $difference; $i++) {
        echo "<td align='center'>$sumarray</td>";
    }
    echo "<td align='center'></td></tr>
</table>
</div>";
}
else if ($_GET['period'] == 4) {

$difference = diffyear($_GET['awal'], $_GET['akhir']);

$awal = $_GET['awal'];
echo "<div class=data-list>
    <center><b class=judul>LAPORAN TAHUNAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN  <br/>PERIODE:$_GET[awal] s . d $_GET[akhir]</b></center>
    <table cellpadding='0' cellspacing='0' border='0' class='tabel'>

    <tr>
    <th width='20'>No</th>
    <th width='150'></th>";
    if ($destination and $patientType) {
        echo "<th width='150'></th>";
    }
    for ($i = 0; $i <= $difference; $i++) {
        echo "<th width='150'>".$awal++."</th>";
    }
    echo "<th>Total</th></tr>";

    if ($destination and empty($patientType)) {
       $showBy = "Tujuan Kunjungan";
        $data = report_instalasi_muat_data($destination);
        require_once 'app/actions/admisi/report/tujuan.php';
    }
    else if ($patientType and empty($destination)) {
        $showBy = "Tipe Pasien";
        $data = data_tipe_pasien($patientType);
        require_once 'app/actions/admisi/report/tipe-pasien.php';

    }if($marriage){
    $showBy = "Status Perkawinan";
    require_once 'app/actions/admisi/report/status-perkawinan.php';
    }
    if($name){
        $showBy = "Nama";
        require_once 'app/actions/admisi/report/nama.php';
    }
    if($payment){
        $showBy = "Pembiayaan";
        require_once 'app/actions/admisi/report/pembiayaan.php';
    }
    else if ($sex) {
    $showBy = "Jenis Kelamin";
    $data = data_gender($sex);
    require_once 'app/actions/admisi/report/tipe-gender.php';

}
    else if ($education) {
        $showBy = "Pendidikan Terakhir";
        $data = pendidikan_muat_data($education);
        require_once 'app/actions/admisi/report/pendidikan.php';

    }
    else if ($job) {
        $showBy = "Pekerjaan";
        $data = profesi_muat_data($job);
        require_once 'app/actions/admisi/report/pekerjaan.php';

    }
    else if ($religion) {
        $showBy = "Agama";
        $data = agama_muat_data($religion);
        require_once 'app/actions/admisi/report/agama.php';

    }
    else if ($village) {
        $showBy = "Alamat Kelurahan";
        $data = kelurahan_muat_data($village);
        require_once 'app/actions/admisi/report/alamat.php';

    }
    else if ($payment) {
        $showBy = "Pembayaran";
        $data = data_payment($payment);
        require_once 'app/actions/admisi/report/pembiayaan.php';
    }

    else if ($destination and $patientType) {
        $showBy = "Tipe Pasien & Kunjungan";
        $data = report_instalasi_muat_data($destination);
        require_once 'app/actions/admisi/report/tujuan-pasien.php';
    }
    echo "<tr><td></td><td align=center>Total</td>";
    for ($i = 0; $i <= $difference; $i++) {
        echo "<td width='150'></td>";
    }
    if ($destination and $patientType) {
        echo "<td width='150'></td>";
    }
    echo "<td></td></tr>
    </table>
</div>";
}


$url = urldecode($_SERVER['REQUEST_URI']);
$replace = str_replace($_SERVER['PHP_SELF'], 'print/Adm-report/',$url);
//echo "<center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./$replace','popup','width=1000,height=650,scrollbars=yes, resizable=no');\"></center>";
?>