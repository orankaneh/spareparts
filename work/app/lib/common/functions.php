<?php
function grafik($maxScale = NULL,$xAxis = array(),$yAxis = array(),$graphTitle = "",$xTitle = "",$yTitle = "",$imageName = ""){
      $graph = new Graph(800,400,"auto");
      $graph->SetScale("textlin", 0, ($maxScale+3));
      $graph->SetMargin(50,50,40,40);
      $graph->SetBox(false);
      $graph->yaxis->HideLine(false);
      $graph->yaxis->HideTicks(false,false);
      $graph->yaxis->HideZeroLabel();
      $graph->xaxis->HideLine(false);
      $graph->xaxis->HideTicks(false,false);
      $graph->xaxis->HideZeroLabel();

      $graph->xaxis->setTickLabels($xAxis);
      $graph->title->Set("$graphTitle");
      $graph->xaxis->title->Set("$xTitle");
      $graph->yaxis->title->Set("$yTitle");
      $graph->SetBackgroundImage("assets/images/company/watermark.jpg",BGIMG_FILLFRAME);

      $barplot = new BarPlot($yAxis);
      $barplot->SetFillColor("red");
      $barplot->value->show();
      $barplot->SetFillGradient("navy","#EEEEEE",GRAD_LEFT_REFLECTION);
      $graph->Add($barplot);
      $graph->Stroke("assets/images/$imageName.png");
}
function antri($value) {

//    $value = $value + 1;
    $jml = strlen($value);
    if ($jml == 1)
        $no = "000" . $value;
    else if ($jml == 2)
        $no = "00" . $value;
    else if ($jml == 3)
        $no = "0" . $value;
    else if ($jml == 4)
        $no = $value;
    return $no;
}

/**
 *
 * @param <type> $tgl d/m/y
 * @return <type>
 */
function indo_tgl($tgl, $type=null) {
    if ($type == null) {
        $type = "/";
    }
    $tgl = explode($type, $tgl);
    if ($tgl[1] == '01')
        $mo = "Januari";
    if ($tgl[1] == '02')
        $mo = "Februari";
    if ($tgl[1] == '03')
        $mo = "Maret";
    if ($tgl[1] == '04')
        $mo = "April";
    if ($tgl[1] == '05')
        $mo = "Mei";
    if ($tgl[1] == '06')
        $mo = "Juni";
    if ($tgl[1] == '07')
        $mo = "Juli";
    if ($tgl[1] == '08')
        $mo = "Agustus";
    if ($tgl[1] == '09')
        $mo = "September";
    if ($tgl[1] == '10')
        $mo = "Oktober";
    if ($tgl[1] == '11')
        $mo = "November";
    if ($tgl[1] == '12')
        $mo = "Desember";
    $new = "$tgl[0] $mo $tgl[2]";

    return $new;
}

function noRm($value) {

    $jml = strlen($value);
    if ($jml == 1)
        $no = "0000000" . $value;
    if ($jml == 2)
        $no = "000000" . $value;
    if ($jml == 3)
        $no = "00000" . $value;
    if ($jml == 4)
        $no = "0000" . $value;
    if ($jml == 5)
        $no = "000" . $value;
    if ($jml == 6)
        $no = "00" . $value;
    if ($jml == 7)
        $no = "0" . $value;
    if ($jml == 8)
        $no = $value;
    if ($jml == 0)
        $no = "00000001";

    return $no;
}

function strtoint($var) {
	$jml 	= substr_count($var,'.');
	$str 	= explode(".",$var);
	$new 	= array();
	for ($i = 0; $i <= $jml; $i++) {
		$new = $str;
	}
	
	return implode('',$new);
}

function inttocur($jml) {
	$int = number_format($jml, 0, '','.');
	return $int;
}

function rupiah($jml) {
	$int = number_format($jml, 2, ',','.');
	return $int;
}
function tarifrupiah($jml) {
	if ($jml!=''){
	$int = number_format($jml, 2, ',','.');
	return $int;
	}
}

function rupiahplus($jml) {
	$int = number_format($jml, 2, ',','.');
	return "<span class='floleft'>Rp </span>".$int;
}

function rupiah2($jml) {
	$int = number_format($jml, 0, '','.');
	return $int;
}

function set_time_zone() {
    $time = date_default_timezone_set('Asia/Jakarta');
    return $time;
}

function date2mysql($tgl) {
    $new = null;
    $tgl = explode("/", $tgl);
    if (empty($tgl[2]))
        return "";
    $new = "$tgl[2]-$tgl[1]-$tgl[0]";
    return $new;
}
function date3mysql($tgl) {
    $new = null;
    $tgl = explode("/", $tgl);
	$time=date("H:i:s");
    if (empty($tgl[2]))
        return "";
    $new = "$tgl[2]-$tgl[0]-$tgl[1] $time";
    return $new;
}
function date2mysql2($tgl) {
    $new = null;
    $tgl = explode("/", $tgl);
    if (empty($tgl[2]))
        return "";
    $new = "$tgl[2]-$tgl[0]-$tgl[1]";
    return $new;
}

function datefmysql($tgl) {
	if($tgl=='' || $tgl==null){
		return "-";
    }else{
	$tgl = explode("-", $tgl);
    $new = $tgl[2]."/".$tgl[1]."/".$tgl[0];
    return $new;
	}
}
/**
 *
 * @param <type> $tgl1 Y-m-d
 * @return <type>
 */
function createUmur($tgl1) {

    $tgl2 = date("Y-m-d");
    $sql = mysql_query("select datediff('$tgl2', '$tgl1') as tahun");
    $rows = mysql_fetch_array($sql);
    return floor($rows['tahun'] / 365);
}
/**
 *
 * @param <type> $tgl d/m/Y
 * @return <type>
 */
function hitungUmur($tgl){
    $tanggal = explode("/", $tgl);
    $tahun = $tanggal[2];
    $bulan = $tanggal[1];
    $hari = $tanggal[0];
    
    $day = date('d');
    $month = date('m');
    $year = date('Y');
    
    $tahun = $year-$tahun;
    $bulan = $month-$bulan;
    $hari = $day-$hari;
    
    $jumlahHari = 0;
    $bulanTemp = ($month==1)?12:$month-1;
    if($bulanTemp==1 || $bulanTemp==3 || $bulanTemp==5 || $bulanTemp==7 || $bulanTemp==8 || $bulanTemp==10 || $bulanTemp==12){
        $jumlahHari=31;
    }else if($bulanTemp==2){
        if($tahun % 4==0)
            $jumlahHari=29;
        else
            $jumlahHari=28;
    }else{
        $jumlahHari=30;
    }
    
    if($hari<=0){
        $hari+=$jumlahHari;
        $bulan--;
    }
    if($bulan<0 || ($bulan==0 && $tahun!=0)){
        $bulan+=12;
        $tahun--;
    }
    if ($tahun =='0'){
	$tahunz='';
	}
	else{
	$tahunz=$tahun." Tahun ";
	}
    return $tahunz.$bulan." Bulan ".$hari." Hari";
}
function hitungUmur2($tgl){
    $tanggal = explode("-", $tgl);
    $tahun = $tanggal[0];
    $bulan = $tanggal[1];
    $hari = $tanggal[2];
    
    $day = date('d');
    $month = date('m');
    $year = date('Y');
    
    $tahun = $year-$tahun;
    $bulan = $month-$bulan;
    $hari = $day-$hari;
    
    $jumlahHari = 0;
    $bulanTemp = ($month==1)?12:$month-1;
    if($bulanTemp==1 || $bulanTemp==3 || $bulanTemp==5 || $bulanTemp==7 || $bulanTemp==8 || $bulanTemp==10 || $bulanTemp==12){
        $jumlahHari=31;
    }else if($bulanTemp==2){
        if($tahun % 4==0)
            $jumlahHari=29;
        else
            $jumlahHari=28;
    }else{
        $jumlahHari=30;
    }
    
    if($hari<=0){
        $hari+=$jumlahHari;
        $bulan--;
    }
    if($bulan<0 || ($bulan==0 && $tahun!=0)){
        $bulan+=12;
        $tahun--;
    }
      if ($tahun =='0'){
	$tahunz='';
	}
	else{
	$tahunz=$tahun." Tahun ";
	}
    return $tahunz.$bulan." Bulan ".$hari." Hari";
}
function datetime($dt) {
    $var = explode(" ", $dt);
    $var1 = explode("-", $var[0]);
    $var2 = "$var1[2]/$var1[1]/$var1[0]";

    return $var2 . " " . $var[1];
}
function datetime2mysql($dt){
    $var = explode(" ", $dt);
    $var1 = explode("/", $var[0]);
    $var2 = "$var1[2]-$var1[1]-$var1[0]";

    return $var2 . " " . $var[1];
}
function deletetime($dtm) {
    $var = explode(" ", $dtm);
    $var1 = explode("-", $var[0]);
    $var2 = "$var1[2]/$var1[1]/$var1[0]";

    return $var2;
    //$var[1]
}
function hapuswaktu($hwt) {
    $var = explode(" ", $hwt);
    $var2 = "$var[0]";

    return $var2;
    //$var[1]
}
function pecahwaktu($pwt) {
    $varx = explode(" ", $pwt);
    $var = explode("-", $varx[0]);
    $tahun = "$var[0]";
    $bulan= "$var[1]";
	$hari= "$var[2]";
    $jd = GregorianToJD($bulan, $hari, $tahun);
	return $jd;
    //$var[1]
}

function tglLahir($umur) {
    $x = mktime(0, 0, 0, date("m"), date("d"), date("Y") - $umur);
    $bd = date("Y-m-d", $x);
    return $bd;
}

function getBln($bln) {
    $sls = $_GET['thakhir'] - $_GET['thawal'];
    for ($i = 0; $i <= $sls; $i++) {
        switch ($bln) {
            case 1 + (12 * $i):
                $val = "01";
                break;

            case 2 + (12 * $i):
                $val = "02";
                break;

            case 3 + (12 * $i):
                $val = "03";
                break;

            case 4 + (12 * $i):
                $val = "04";
                break;

            case 5 + (12 * $i):
                $val = "05";
                break;

            case 6 + (12 * $i):
                $val = "06";
                break;

            case 7 + (12 * $i):
                $val = "07";
                break;

            case 8 + (12 * $i):
                $val = "08";
                break;

            case 9 + (12 * $i):
                $val = "09";
                break;

            case 10 + (12 * $i):
                $val = "10";
                break;

            case 11 + (12 * $i):
                $val = "11";
                break;

            case 12 + (12 * $i):
                $val = "12";
                break;
        }
    }
    return $val;
}

function blnAngka($bln) {
    $val = "0";
    switch ($bln) {
        case "Januari":
            $val = "1";
            break;

        case "Februari":
            $val = "2";
            break;

        case "Maret":
            $val = "3";
            break;

        case "April":
            $val = "4";
            break;

        case "Mei":
            $val = "5";
            break;

        case "Juni":
            $val = "6";
            break;

        case "Juli":
            $val = "7";
            break;

        case "Agustus":
            $val = "8";
            break;

        case "September":
            $val = "9";
            break;

        case "Oktober":
            $val = "10";
            break;

        case "November":
            $val = "11";
            break;

        case "Desember":
            $val = "12";
            break;
    }
    return $val;
}

function bln($bln) {
    $n = $_GET['thakhir'] - $_GET['thawal'];
    if ($n >= 0) {
        for ($i = 0; $i <= $n; $i++) {
            switch ($bln) {
                case 1 + ($i * 12):
                    $val = "Januari";
                    break;

                case 2 + ($i * 12):
                    $val = "Februari";
                    break;

                case 3 + ($i * 12):
                    $val = "Maret";
                    break;

                case 4 + ($i * 12):
                    $val = "April";
                    break;

                case 5 + ($i * 12):
                    $val = "Mei";
                    break;

                case 6 + ($i * 12):
                    $val = "Juni";
                    break;

                case 7 + ($i * 12):
                    $val = "Juli";
                    break;

                case 8 + ($i * 12):
                    $val = "Agustus";
                    break;

                case 9 + ($i * 12):
                    $val = "September";
                    break;

                case 10 + ($i * 12):
                    $val = "Oktober";
                    break;

                case 11 + ($i * 12):
                    $val = "November";
                    break;

                case 12 + ($i * 12):
                    $val = "Desember";
                    break;
            }
        }
        return $val;
    }
}

/**
 *
 * @param int $bln bulan ke- (mulai dari angka 1-12)
 * @return string 
 */
function bulan($bln) {
    switch ($bln) {
        case 1 :
            $val = "Januari";
            break;

        case 2 :
            $val = "Februari";
            break;

        case 3 :
            $val = "Maret";
            break;

        case 4 :
            $val = "April";
            break;

        case 5 :
            $val = "Mei";
            break;

        case 6 :
            $val = "Juni";
            break;

        case 7 :
            $val = "Juli";
            break;

        case 8 :
            $val = "Agustus";
            break;

        case 9 :
            $val = "September";
            break;

        case 10 :
            $val = "Oktober";
            break;

        case 11 :
            $val = "November";
            break;

        case 12 :
            $val = "Desember";
            break;
        default :
            $val = "";
            break;
    }
    return $val;
}

function paging($sql, $dataPerPage, $tab = NULL, $ajax = NULL) {

    $showPage = NULL;
    ob_start();
    echo "
        <div class='body-page'>";
    if (!empty($_GET['page'])) {
        $noPage = $_GET['page'];
    } else {
        $noPage = 1;
    }

    $dataPerPage = $dataPerPage;
    $offset = ($noPage - 1) * $dataPerPage;

    $hasil = mysql_query($sql);

    $data = mysql_num_rows($hasil);
    $jumData = $data;
    $jumPage = ceil($jumData / $dataPerPage);
    $get=$_GET;
    if ($jumData > $dataPerPage) {
        if ($noPage > 1){            
            $get['page']=($noPage - 1);
			if ($ajax != NULL) "<span class='page-prev' onclick='contentloader(\"?" .  generate_get_parameter($get). "\",\"#content\")'>prev</span>";
            else echo "<span class='page-prev' onClick=location.href='?" .  generate_get_parameter($get). "'>prev</span>";
        }
        for ($page = 1; $page <= $jumPage; $page++) {
            if ((($page >= $noPage - 9) && ($page <= $noPage + 9)) || ($page == 1) || ($page == $jumPage)) {
                if (($showPage == 1) && ($page != 2))
                    echo "...";
                if (($showPage != ($jumPage - 1)) && ($page == $jumPage))
                    echo "...";
                if ($page == $noPage)
                    echo " <span class='noblock'>" . $page . "</span> ";
                else{
                    $get['page']=$page;
                    
                    if($tab != NULL){
                        $get['tab'] = $tab;
                    }
					if ($ajax != NULL) echo " <a class='block' onclick='contentloader(\"?" .  generate_get_parameter($get). "\",\"#content\")'>" . $page . "</a> ";
                    else echo " <a class='block' href='?" .  generate_get_parameter($get). "'>" . $page . "</a> ";
                }
                $showPage = $page;
            }
        }

        if ($noPage < $jumPage){
            $get['page']=($noPage + 1);
			if ($ajax != NULL) echo "<span class='page-next' onclick='contentloader(\"?" .  generate_get_parameter($get). "\",\"#content\")'>next</span>";
            else echo "<span class='page-next' onClick=location.href='?" .  generate_get_parameter($get). "'>next</span>";
        }
    }
    echo "</div>";

    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
}

function pagination($sql, $dataPerPage, $tab = NULL){
             
    $showPage = NULL;
    ob_start();
    echo "
        <div class='body-page'>";
    if (!empty($_GET['pages'])) {
        $noPage = $_GET['pages'];
    } else {
        $noPage = 1;
    }

    $dataPerPage = $dataPerPage;
    $offset = ($noPage - 1) * $dataPerPage;

    $hasil = mysql_query($sql);

    $data = mysql_num_rows($hasil);
    $jumData = $data;
    $jumPage = ceil($jumData / $dataPerPage);
    $get=$_GET;
    if ($jumData > $dataPerPage) {
        if ($noPage > 1){            
            $get['pages']=($noPage - 1);
            echo "<span class='page-prev' onClick=location.href='?" .  generate_get_parameter($get). "'>prev</span>";
        }
        for ($page = 1; $page <= $jumPage; $page++) {
            if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)) {
                if (($showPage == 1) && ($page != 2))
                    echo "...";
                if (($showPage != ($jumPage - 1)) && ($page == $jumPage))
                    echo "...";
                if ($page == $noPage)
                    echo " <span class='noblock'>" . $page . "</span> ";
                else{
                    $get['pages']=$page;
                    
                    if($tab != NULL){
                        $get['tab'] = $tab;
                    }
                    
                    echo " <a class='block' href='?" .  generate_get_parameter($get). "'>" . $page . "</a> ";
                }
                $showPage = $page;
            }
        }

        if ($noPage < $jumPage){
            $get['pages']=($noPage + 1);
            echo "<span class='page-next' onClick=location.href='?" .  generate_get_parameter($get). "'>next</span>";
        }
    }
    echo "</div>";

    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
}

function delete_list_data($id, $tabel, $link, $err_link, $dataname=null, $page=NULL, $tab = NULL,$add_param=null) {

    $result = mysql_query("SELECT * from $tabel");
    $property = mysql_fetch_field($result);
    if($page != NULL){
        $pages = "&page=$page";
    }else $pages = "";
    
    if($tab != NULL){
        $tabs = "&tab=$tab";
    }else $tabs = "";
    
    if (isset($_POST['delete'])) {
        $sql = mysql_query("DELETE FROM $tabel WHERE " . $property->name . " = '$id'");
        if ($sql) {
            if($add_param!=null){
                header("location:" . app_base_url('' . $link . '') . "$pages"."$tabs"."&" . $add_param."");
            }else{
                header("location:" . app_base_url('' . $link . '') . "$pages"."$tabs");
            }
            
        } else {
            if($add_param!=null){
                header("location:" . app_base_url('' . $err_link . '') . "$pages"."$tabs"."&" . $add_param."");
            }else{
                header("location:" . app_base_url('' . $err_link . '') . "$pages"."$tabs");
            }
            
        }
    }
    if ($dataname == null) {
        $sql = mysql_query("select * from $tabel where " . $property->name . " = '$id'");
        $row = mysql_fetch_row($sql);
        $dataname = "$row[1]";
    }
?>
    <fieldset><legend>Konfirmasi delete data</legend>
        <form class="data-input" action="" method="post">
            Yakin akan menghapus data <b><?= $dataname ?> </b> ?
            <fieldset class="field-group">
                <input type="submit" value="OK" class="tombol" name="delete" />&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:history.go(-1)" />
            </fieldset>
        </form>
    </fieldset>
<?
}

/**
 *
 * @param <type> $dataname label data yang akan dihapus
 * @param <type> $link link jika data berhasil dihapus
 * @param <type> $err_link link jika data gagal dihapus
 * @param <type> $query daftar query yang dijalankan ketika data dihapus
 */
function delete_list_data2($dataname, $link, $err_link, $query=array(),$add_param=null) {
    if (isset($_POST['delete2'])) {
        //query delete
        foreach ($query as $id => $s) {
            $sql = _delete($s);
            if (!$sql)
                break;
        }
        if(!$sql) {
            if($add_param!=null){
                header("location:" . app_base_url('' . $err_link . '')."&" . $add_param."");
            }else{
                header("location:" . app_base_url('' . $err_link . '') . "");
            }
        } else {
            if($add_param!=null){
                header("location:" . app_base_url('' . $link . '')."&". $add_param."");
            }else{
                header("location:" . app_base_url('' . $link . ''). "");             
            }
        }
    }
?>
    <fieldset><legend>Konfirmasi delete data</legend>
        <form class="data-input" action="" method="post">
            Yakin akan menghapus data <b><?= $dataname ?> </b> ?
            <fieldset class="field-group">
                <input type="submit" value="OK" class="tombol" name="delete2" />&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:history.go(-1)" />
            </fieldset>
        </form>
    </fieldset>
<?
}

function delete_data($kolom,$id,$table,$redirect) {
    $sql = mysql_query("DELETE FROM $table WHERE " . $kolom . " = '". $id ."'");
    if ($sql) header("location:" . app_base_url('' . $redirect . '') . "");
}
function difference_time($begin, $end) {

    $begin = date2mysql($begin);
    $end = date2mysql($end);

    $sql = "select datediff('$end','$begin') as new";

    $exe = mysql_query($sql);
    $row = mysql_fetch_array($exe);

    return $row['new'];
}

function diffyear($begin, $end) {

    return $diff = $end - $begin;
}

function countrow($sql) {

    $rowcount = mysql_num_rows(mysql_query($sql));
    return $rowcount;
}

function _select_arr($sql) {
    $result = array();
    $exe = mysql_query($sql) or die(mysql_error() . "<pre><hr>" . $sql."</pre>");
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}

function _select($sql) {
    $exe = mysql_query($sql) or die(mysql_error() . "<hr>" . $sql);
    return $exe;
}

function _select_unique_result($sql) {
    $exe = mysql_query($sql) or die(mysql_error() . "<hr>" . $sql);
    $row = mysql_fetch_array($exe);
    return $row;
}

function _farray($sql) {
    $data = null;
    if (!empty($sql)) {
        $data = mysql_fetch_array($sql);
        return $data;
    }
}

function _insert($sql) {
    $exe = mysql_query($sql) or die(mysql_error() . "<hr>" . $sql);
    if ($exe == 0)
        exit;
    return $exe;
}

function _update($sql) {
    $exe = mysql_query($sql) or die(mysql_error() . "<hr>" . $sql);
    return $exe;
}

function _delete($sql) {
    $exe = mysql_query($sql);// or die("<hr>$sql".mysql_error());
    return $exe;
}

function _last_id() {
    return mysql_insert_id();
}

function show_array($array) {
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function post_value($name) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    } else {
        return null;
    }
}

function get_value($name) {
    if (isset($_GET[$name])) {
        return $_GET[$name];
    } else {
        return null;
    }
}

function array_value($array, $index) {
    if (isset($array[$index])) {
        return $array[$index];
    } else {
        return null;
    }
}
function _num_rows($sql){
    $exe = mysql_query($sql) or die(mysql_error());
    $count = mysql_num_rows($exe);
    return $count;
}

function get_date_now() {
    return date("d/m/Y");
}

/**
 * fungsi $endDate-$startDate
 * @param <type> $startDate format tanggal Y-M-D
 * @param <type> $endDate format tanggal Y-M-D
 */
function selisih_hari($startDate, $endDate) {
    $tgl1 = $startDate;  // 1 Oktober 2009
    $tgl2 = $endDate;  // 10 Oktober 2009
    // memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
    // dari tanggal pertama
//    echo "$tgl1 $tgl2";
    $pecah1 = explode("-", $tgl1);
    
    $date1 = $pecah1[2];
    $month1 = $pecah1[1];
    $year1 = $pecah1[0];

    // memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
    // dari tanggal kedua

    $pecah2 = explode("-", $tgl2);
    $date2 = $pecah2[2];
    $month2 = $pecah2[1];
    $year2 = $pecah2[0];

    // menghitung JDN dari masing-masing tanggal

    $jd1 = GregorianToJD($month1, $date1, $year1);
    $jd2 = GregorianToJD($month2, $date2, $year2);

    // hitung selisih hari kedua tanggal

    $selisih = $jd2 - $jd1;
    return $selisih;
}
function generate_sort_parameter($sort,$sortBy=null,$tab = NULL){
    $link=$_GET;
    $link['sort']=$sort;

    if($sortBy=='asc' && $_GET['sort']==$sort)
        $link['sortBy']='desc';
    else
        $link['sortBy']='asc';
    if($tab != NULL){
        $tabs['tab']=$tab;
    }else $tabs['tab']="";
    
    $link=generate_get_parameter($link,$tabs);
    return $link;
}
function generate_get_parameter($get,$addArr=array(),$removeArr=array()) {
    if($addArr==null)
        $addArr=array();
    foreach($removeArr as $rm){
        unset($get[$rm]);
    }
    $link = "";
    $get=array_merge($get, $addArr);
    foreach ($get as $key => $val) {
        if ($link == null) {
            $link.="$key=$val";
        }else
            $link.="&$key=$val";
    }
    return $link;
}

function int_to_money($nominal) {
    return "Rp. " . number_format($nominal, 0, '', '.');
}

function header_excel($namaFile) {
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,
            pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // header untuk nama file
    header("Content-Disposition: attachment;
            filename=" . $namaFile . "");
    header("Content-Transfer-Encoding: binary ");
}

function include_css() {
?>
 <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/barcode.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.flipflopfolding.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.partsselector.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>" media="all" /> <!-- Keterangan Form -->
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tipsy.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.ui.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.autocomplete.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.multiselect.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/ui.slider.css') ?>" media="all" />
<?
}

function include_css_excel_report() {
?>
    <style type="text/css">
        h2{
            font-size: 16px;
        }
        td{
            background-color: #ffffff;
            border: 1px solid #000;
        }
        table{
            background-color: #ffffff;
        }
        tr.odd{
            background-color:#ffffff;
        }
        tr.even{
            background-color:#ffffff;
        }
    </style>
<?
}

function tampilkan_pesan() {
    include 'app/actions/admisi/pesan.php';
    echo isset($pesan) ? $pesan : NULL;
}
function currencyToNumber($a){
    $b=str_ireplace(".", "", $a);
	return str_replace(",",".",$b);
}
function waktufmysql($waktu){
    $time=explode(" ", $waktu);
    $waktu=array();
    $waktu['tanggal']=datefmysql($time[0]);
    $waktu['jam']=$time[1];
    return $waktu;
}
function showWaktuFromMysql($waktu){
    $w=waktufmysql($waktu);
    return $w['tanggal']." ".$w['jam'];
}

function notifikasi($data,$center=null) {
	if ($center != null) return "<center><div class='notif' style='float: none; width: 23%'>".$data."</div></center>";
	return "<div class='notif'>".$data."</div><div style='clear: both'></div>";
}

function addButton($url,$title,$java=Null) {
	if ($java!=Null) {
	return "<a href='' onclick='".$url.";return false' id='".$java."' class='add'><div class='icon button-add'></div>".$title."</a>";
	} else {
	return "<a href='".app_base_url($url)."' class='add'><div class='icon button-add'></div>".$title."</a>";
	}
}

function topButton($url,$title) {
	return "<a href='".$url."' class='add'><div class='icon button-top'></div>".$title."</a>";
}


function excelButton($url,$title) {
	return "<a href='".app_base_url($url)."' class='varianButton'><div class='icon button-excel'></div>".$title."</a>";
}

function nama_packing_barang($data){
//urutan parameter array generik,nama_barang,kekuatan,sediaan,nilai_konversi,satuan_terkecil,pabrik    
    
    $nama = "$data[1]";
            if ($data['0'] == 'Generik'||$data[0] == 'Non Generik') {
                $nama.= ( $data[2] != 0) ? " $data[2], $data[3]" : " $data[3]";
            }
            /*if ($data[0] == 'Non Generik') {
                $nama.= ' '.$data[2];
                }*/
            $nama.=" @$data[4] $data[5]";
            $nama.= ( $data[0] == 'Generik') ? ' ' . $data[6] : ''; 
    
    return $nama;        
}
function nama_packing_barang2($data){
//urutan parameter array generik,nama_barang,kekuatan,sediaan,nilai_konversi,satuan_terkecil,pabrik    



            /*if ($data[0] == 'Non Generik') {
                $nama.= ' '.$data[2];
                }*/
            $nama=" $data[0]@$data[1] $data[2]";
          
    
    return $nama;        
}
function nomer_paging($page,$perpage) {
	if ($page > 1)
        $no = $perpage * ($page - 1) + 1;
        else
        $no = 1;
		
		return $no;
}

function test($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function boxnotif() {
	echo "<div id='box-notif'></div><div class='clear'></div>"; 
}

function lembar_header_excel($colspan){
     $head = head_laporan_muat_data();
     $data="
        <tr>    
		<td>
			<img src=\"http://".$_SERVER['SERVER_NAME'].app_base_url('assets/images/logo/').$head['gambar']."\" />&nbsp;&nbsp;
		</td>
        <td colspan='$colspan' style='border:0;text-align:center;'>
			<h1 />".$head['nama']."</h1></td>
          </tr>
		  <tr>
			<td colspan='$colspan' style='border:0;text-align:center;'></td>
		  </tr>
          <tr>
            <td  colspan='$colspan' style='border:0;text-align:center;'>".$head['alamat'].",".$head['kabupaten']."</td>
          </tr>
          <tr>
            <td  colspan='$colspan' style='border:0;text-align:center;'>Telp: ".$head['telp'].", Fax: ".$head['fax'].", Email: ".$head['email'].", Website: ".$head['web']."</td>
          </tr>         
          <tr>
            <td  colspan='$colspan' style='border:0;text-align:center;'></td>
          </tr>
    ";
     
     return $data;
 }