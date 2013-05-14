<?php
/**
 *
 * @param Date $startDate yy-mm-dd
 * @param Date $endDate yy-mm-dd
 * @return result pivot table
 */
function pivot_muat_data_byHari($startDate,$endDate){
    $selisih = (strtotime($endDate)-strtotime($startDate))/24/60/60;
    $selisih++;
    $new=$startDate;
    $startDate=explode('-', $startDate);
    $columnSelect="";
    for($i=1;$i<=$selisih;$i++){
        $tgl=explode('-', $new);
        $columnSelect.="(select sum(t.total) from tarif t
            right join layanan p on (t.id_layanan=p.id)
            right join detail_billing db on(t.id=db.id_tarif)
            where date(db.waktu)='$new' and t.id=ta.id
            ) as '$tgl[2]'";
        if($i!=($selisih)) $columnSelect.=",";
        $x  = mktime(0, 0, 0, date($startDate[1]), date($startDate[2])+$i, $startDate[0]);
        $new = date("Y-m-d",$x);
    }
    $sql="select layanan.nama,
        $columnSelect
        from tarif ta
        join layanan on ta.id_layanan=layanan.id
        group by layanan.id";
    $query=mysql_query($sql) or die(mysql_error());

    $data=array();
    $i=0;
    while($d=  mysql_fetch_array($query)){
        $data[]=$d;
        $i++;
    }
    
    $field= mysql_num_fields($query);
    $column=array();
    for($i=0;$i<$field;$i++){
        $column[]=mysql_field_name($query, $i);
        //echo $column[$i]."<br>";
    }
    return array(
        'data'=>$data,
        'column'=>$column
    );
}
/**
 *
 * @param Date $startDate yy-mm-dd
 * @param Date $endDate yy-mm-dd
 * @return table result
 */
function pivot_muat_data_byMinggu($startDate,$endDate){
    $sql = mysql_query("select week('".$startDate."',1) as minggu1, week('".$endDate."',1) as minggu2");
    $row = mysql_fetch_array($sql);

    $selisih = $row['minggu2'] - $row['minggu1'];
    $a = mysql_fetch_array(mysql_query("select dayofweek('".$startDate."') as hari_ke"));

    $slh_hari = $a['hari_ke'] - 2; // inisialisasi awal hari senin
    if ($slh_hari == 0) {
            $tanggal = $startDate;
    }
    if ($slh_hari > 0) {
            $tanggal = mysql_fetch_array(mysql_query("select '".$startDate."' - INTERVAL $slh_hari DAY as new_day"));
            //$content.= "select INTERVAL $slh_hari DAY - '".$startDate."' as new_day";
            $tanggal = $tanggal['new_day'];
    }
    if ($slh_hari < 0) {
            $tanggal = mysql_fetch_array(mysql_query("select '".$startDate."' - INTERVAL $slh_hari DAY as new_day"));
            $tanggal = $tanggal['new_day'];
    }

    $date = explode("-",$tanggal);
    $n = 0;
    $totalSemua = 0;
    $columnSelect="";
    //dari minggu1 sampai minggu2 lakukan
    for ($i = $row['minggu1']; $i <= $row['minggu2']; $i ++) {
        $x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$n), date($date[0]));
        $thn = date("Y-m-d",$x);
        $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
        $subSql="
        select sum(t.total) from tarif t
            right join layanan p on (t.id_layanan=p.id)
            right join detail_billing db on(t.id=db.id_tarif)
        where db.waktu between '$thn' and '$next[0]' and t.id=ta.id ";
        $columnSelect.="($subSql) as '$i'"."";
        if($i!=($row['minggu2'])) $columnSelect.=",";
        $n++;
    }
    $sql="select p.nama,
        $columnSelect
        from tarif ta
        join layanan p on ta.id_layanan=p.id
        group by p.id";
   // echo "<h1>$sql</h1>";
    $query=mysql_query($sql) or die(mysql_error());

    $data=array();
    $i=0;
    while($d=  mysql_fetch_array($query)){
        $data[]=$d;
        //echo "$d[0] $d[1] $d[2]<br>";
        //echo count($d)."<br>";
        //echo "tes ".$data[$i][0]." ".$data[$i][1]." ".$data[$i][2]." "."<br>";
        $i++;
    }

    $field= mysql_num_fields($query);
    $column=array();
    for($i=0;$i<$field;$i++){
        $column[]=mysql_field_name($query, $i);
        //echo $column[$i]."<br>";
    }
    return array(
        'data'=>$data,
        'column'=>$column
    );
}
/**
 *
 * @param array('bln'='bulan','thn'=>'tahun') $bulan1
 * @param array('bln'='bulan','thn'=>'tahun') $bulan2
 */

function pivot_muat_data_byBulan($startMonth=array(),$endMonth=array()){
        if (strlen(blnAngka($startMonth['bln'])) < 2) {
                $bln1 = "0".blnAngka($startMonth['bln'])."";
        }
        else if (strlen(blnAngka($startMonth['bln'])) == 2) {
                $bln1 = blnAngka($startMonth['bln']);
        }

        if (strlen(blnAngka($endMonth['bln'])) < 2) {
                $bln2 = "0".blnAngka($endMonth['bln'])."";
        }
        else if (strlen(blnAngka($endMonth['bln'])) == 2) {
                $bln2 = blnAngka($endMonth['bln']);
        }
        $awal = "$startMonth[thn]$bln1";
        $akhir = "$endMonth[thn]$bln2";

        $sql = mysql_query("select PERIOD_DIFF($akhir,$awal) as selisih");
        $data= mysql_fetch_array($sql);
        $date = explode("/","$bln1/01/$_GET[thawal]");
        $columnSelect="";
        for ($i = 0; $i <= $data['selisih']; $i ++) {
                $x  = mktime(0, 0, 0, date($date[0])+$i, date($date[1]), date($date[2]));
                $month = date("m",$x);
                $year=date("Y",$x);
                $subSql="
                    (select sum(t.total) from tarif t
                        right join layanan p on (t.id_layanan=p.id)
                        right join detail_billing db on(t.id=db.id_tarif)
                    where month(db.waktu)=$month and year(db.waktu)=$year and t.id=ta.id )";

                $columnSelect.="($subSql) as '".substr(bulan($month), 0,3)."'";
                if($i!=$data['selisih']) $columnSelect.=",";
        }
        $sql="select p.nama,
        $columnSelect
        from tarif ta
        join layanan p on ta.id_layanan=p.id
        group by p.id";
//        echo "<h1>$sql</h1>";
        $query=mysql_query($sql) or die(mysql_error());

        $data=array();
        $i=0;
        while($d=  mysql_fetch_array($query)){
            $data[]=$d;
            $i++;
        }

        $field= mysql_num_fields($query);
        $column=array();
        for($i=0;$i<$field;$i++){
            $column[]=mysql_field_name($query, $i);
            //echo $column[$i]."<br>";
        }
        return array(
            'data'=>$data,
            'column'=>$column
        );
}

function pivot_muat_data_byTahun($startYear,$endYear){
    $selisih =$endYear-$startYear+1;
    $columnSelect="";
    $year=$startYear;
    for($i=1;$i<=$selisih;$i++){
        $columnSelect.="(select sum(t.total) from tarif t
            right join layanan p on (t.id_layanan=p.id)
             right join detail_billing db on(t.id=db.id_tarif)
            where year(db.waktu)='$year' and t.id=ta.id
            ) as '$year'";
        if($i!=($selisih)) $columnSelect.=",";
        $year++;
    }
    $sql="select p.nama,
        $columnSelect
        from tarif ta
        join layanan p on ta.id_layanan=p.id
        group by p.id";
    $query=mysql_query($sql);

    $data=array();
    $i=0;
    while($d=  mysql_fetch_array($query)){
        $data[]=$d;
        //echo "$d[0] $d[1] $d[2]<br>";
        //echo count($d)."<br>";
        //echo "tes ".$data[$i][0]." ".$data[$i][1]." ".$data[$i][2]." "."<br>";
        $i++;
    }

    $field= mysql_num_fields($query);
    $column=array();
    for($i=0;$i<$field;$i++){
        $column[]=mysql_field_name($query, $i);
        //echo $column[$i]."<br>";
    }
    return array(
        'data'=>$data,
        'column'=>$column
    );
}
?>
