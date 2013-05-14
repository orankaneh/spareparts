<?php

function execution_muat_data($sql) {
    $exe = mysql_query($sql);
    $row = mysql_fetch_array($exe);

    if ($row['data'] == NULL) {
        return 0;
    } else {
        return $row['data'];
    }
}

function report_instalasi_muat_data($id = NULL) {

    if ($id != 0) {
        $require_onced = "where id = '$id'";
    }else $require_onced='';
    $result = array();
    $sql = "select * from instalasi $require_onced";
    //echo $sql; die;
    $exe = mysql_query($sql);
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}
function report_cols_instalasi_mingguan($id, $date, $next){
    $result = array();
    $sql = "select count(*) as data from kunjungan where id_instalasi_tujuan = '$id' and waktu between '$date' and '$next'";
    $exe = mysql_query($sql);
    $row = mysql_fetch_array($exe);
    
    return $row['data'];
}
function report_cols_instalasi($id, $day, $week_start, $week_end, $mount_start, $mount_end, $year_start, $year_end, $period) {

    switch($period) {
        case '1':
        $period = " and date(waktu) = '$day'";
            break;
        case '4':
        $period = " and year(waktu) = '".$year_start."'";
            break;
    }
    
    $result = array();
    $sql = "select count(*) as data from kunjungan where id_instalasi_tujuan = '$id' $period";
    //echo $sql;
    $exe = mysql_query($sql);
    $row = mysql_fetch_array($exe);
    
    return $row['data'];
}

function report_tipepasien_muat_data($id, $day, $week_start, $week_end, $mount_start, $mount_end, $year_start, $year_end, $period) {

    if ($id == 1) $id = "= 1"; else $id = "> 1";
    switch($period) {
        case '1':
        $period = " and date(waktu) = '$day'";
            break;
        case '4':
        $period = " and year(waktu) = '".$year_start."'";
            break;
    }
    $sql = "select count(*) as data from kunjungan k,pasien ps ,penduduk p where k.id_pasien=ps.id and ps.id_penduduk=p.id $period group by k.id_pasien having count(k.id_pasien) $id";
    //echo $sql;
    $exe = mysql_query($sql);
    $row = mysql_fetch_array($exe);
    if ($row['data'] == NULL) {
        return 0;
    } else {
        return $row['data'];
    }
}
function report_gender_muat_data($id, $day, $week_start, $week_end, $mount_start, $mount_end, $year_start, $year_end, $period) {

    switch($period) {
        case '1':
        $period = " and date(waktu) = '$day'";
            break;
        case '4':
        $period = " and year(waktu) = '".$year_start."'";
            break;
    }
    $sql = "select count(*) as data from penduduk pd, pasien p, kunjungan k where pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = '$id' $period";
   
    $exe = mysql_query($sql);
    $row = mysql_fetch_array($exe);

    if ($row['data'] == NULL) {
        return 0;
    } else {
        return $row['data'];
    }
}

function report_pendidikan_muat_data($id, $day, $week_start, $week_end, $mount_start, $mount_end, $year_start, $year_end, $period) {

    switch($period) {
        case '1':
        $period = " and date(waktu) = '$day'";
            break;
        case '4':
        $period = " and year(waktu) = '".$year_start."'";
            break;
    }
    $sql = "select count(*) as data from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k  where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and dp.id_pendidikan_terakhir = '$id' $period";
    //echo $sql;
    return execution_muat_data($sql);

}

function report_pekerjaan_muat_data($id, $day, $week_start, $week_end, $mount_start, $mount_end, $year_start, $year_end, $period) {
    switch($period) {
        case '1':
        $period = " and date(waktu) = '$day'";
            break;
        case '4':
        $period = " and year(waktu) = '".$year_start."'";
            break;
    }
    $sql = "select count(*) as data from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and dp.id_profesi = '$id' $period";
    return execution_muat_data($sql);

}

function report_agama_muat_data($id, $day, $week_start, $week_end, $mount_start, $mount_end, $year_start, $year_end, $period) {
    switch($period) {
        case '1':
        $period = " and date(waktu) = '$day'";
            break;
        case '4':
        $period = " and year(waktu) = '".$year_start."'";
            break;
    }
    
    $sql = "select count(*) as data from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_agama and pd.id = dp.id_penduduk and dp.id_agama = '$id' $period";
    return execution_muat_data($sql);

}

function report_kelurahan_muat_data($id, $day, $week_start, $week_end, $mount_start, $mount_end, $year_start, $year_end, $period) {
    switch($period) {
        case '1':
        $period = " and date(waktu) = '$day'";
            break;
        case '4':
        $period = " and year(waktu) = '".$year_start."'";
            break;
    }
    
    $sql = "select count(*) as data from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k where pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and dp.id_kelurahan = '$id' $period";
    return execution_muat_data($sql);

}

function report_pembiayaan_muat_data($id, $day, $week_start, $week_end, $mount_start, $mount_end, $year_start, $year_end, $period) {
    switch($period) {
        case '1':
        $period = " and date(waktu) = '$day'";
            break;
        case '4':
        $period = " and year(waktu) = '".$year_start."'";
            break;
    }
    if ($id == 3) {
        $sql = "select count(*) as data from kunjungan k, charity c, jenis_charity j where k.id = c.id_kunjungan and c.id_jenis_charity = j.id_jenis_charity $period";
    }
    else if ($id == 2) {
        $sql = "select count(*) as data from kunjungan k, asuransi a, jenis_asuransi j where k.id = a.id_kunjungan and a.id_jenis_asuransi = j.id_jenis_asuransi $period";
    }
    else {
        $sql1 = mysql_query("select id_kunjungan from asuransi");
        while ($data = mysql_fetch_array($sql1)) {
                $asuransi[] = $data['id_kunjungan'];
        }
        $id_asuransi = implode(",",$asuransi);

        $sql2= mysql_query("select id_kunjungan from charity");
        while ($data2 = mysql_fetch_array($sql2)) {
                $charity[] = $data2['id_kunjungan'];
        }
        $id_charity = implode(",",$charity);

        $sql = "select count(*) as data from kunjungan where id not in ($id_asuransi,$id_charity) $period";
    }
    //echo $sql;
    return execution_muat_data($sql);
}

function report_tujuan_pasien_muat_data($id,$tipe, $day, $week_start, $week_end, $mount_start, $mount_end, $year_start, $year_end, $period) {

    if ($tipe == 1) $tipe = "= 1"; else $tipe = "!= 1";
    switch($period) {
        case '1':
        $period = " and date(waktu) = '$day'";
            break;
        case '4':
        $period = " and year(waktu) = '".$year_start."'";
            break;
    }
    $sql = "SELECT k.id FROM instalasi i left join kunjungan k on(k.id_instalasi_tujuan = i.id) where i.id = '$id' $period and k.no_kunjungan_pasien $tipe group by k.id_pasien, k.id_instalasi_tujuan";

    //echo $sql;
    $exe = mysql_query($sql);
    return $countrow = mysql_num_rows($exe);
}

?>
