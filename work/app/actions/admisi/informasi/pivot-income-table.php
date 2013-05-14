<?php
function cost($jml) {
    if($jml==0)
        $fulus="-";
    else
        $fulus = number_format($jml, 0, '','.');
    return $fulus;
}

/**
 *
 * @param  Date $awal
 * @param  Date $akhir
 * @return table total report
 */
require_once "app/actions/admisi/report/pivot-master.php";

function createTable($table,$period=null){
    $data=$table['data'];
    $column=$table['column'];

    $content="";
    $content.="<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='width:100%;' style='width:100%;'>
            <thead>
                            <tr>
                                    <th rowspan='2'><h3>No</h3></th>
                                    <th rowspan='2'><h3>Item Pendapatan<h3></th>
                                    <th colspan='".(count($column))."' class='nosort' style='text-align:center;'><h3>Pendapatan "."Per $period"." (Rp.)</h3></th></tr>";

            $pertama=true;
            foreach ($column as $col){
                if(!$pertama)
                    $content.="<th class='nosort' style='text-align:center;'><h3>$col</h3></th>";
                else {$pertama=false;}
            }

    $content.="<th class='nosort' style='text-align:center;'><h3>Total</h3></th></thead>";
    $content.="<tbody>";
    $i=1;
    $sumPerDate=array();
    $countColumn=count($column);
    for($ii=0;$ii<$countColumn;$ii++){
        $sumPerDate[]=0;
    }
    $ganjil=true;
    foreach ($data as $dt){
        if ($ganjil){
            $warna= "#FFFFFF";
            $ganjil=false;
        }else{
            $warna= "#F9F9F9";
            $ganjil=true;
        }
        $content.="<tr bgcolor='$warna'><td align='center'>".$i++."</td>";
        $a=0;
        $total=0;
        $pertama=true;
        for($ii=0;$ii<$countColumn;$ii++){
            if($dt[$ii]!=null){
                if(!$pertama){
                    $content.="<td align=center>".cost($dt[$ii])."</td>";
                }else{
                    $content.="<td align=left>".($dt[$ii])."</td>";
                    $pertama=false;
                }
                $total+=$dt[$ii];
                $sumPerDate[$ii]+=$dt[$ii];
            }else{
                $content.="<td align=center>-</td>";
            }
        }
        $content.="<td align=center>".cost($total)."</td>";
        $content.="</tr>";
    }
    //mencetak jumlah
    $content.="<tr bgcolor=#FFFFF><td></td><td>TOTAL</td>";
    //column pertama (index ke-0)=nama pendapatan
    $jumlah=0;
    for($ii=1;$ii<$countColumn;$ii++){
        $content.="<td align=center>".cost($sumPerDate[$ii])."</td>";
        $jumlah+=$sumPerDate[$ii];
    }
    $content.="<td align=center>".cost($jumlah)."</td>";
    $content.="</tr>";

    $content.="</tbody>";
    $content.="</table>";
    return $content;
}



function getPivotIncomeTable($awal,$akhir,$period){
        $content="";
        $content.= "<div class='dasar'>";
        if ($period == '1') {
            $awal = date2mysql($_GET['awal']);
            $akhir = date2mysql($_GET['akhir']);

            $table=pivot_muat_data_byHari($awal, $akhir);
            $data=$table['data'];
            $column=$table['column'];
            $content.="
                <center>LAPORAN HARIAN UNIT ADMISI REKAP PENDAPATAN PENDAFTARAN <br>
                    PERIODE: ".indo_tgl($_GET['awal'])." s. d ".indo_tgl($_GET['akhir'])." </center>
            ";
            $content.=createTable($table,'Hari');
        }
        else if ($period == '2') {
                $awal = date2mysql($_GET['awal']);
                $akhir = date2mysql($_GET['akhir']);
                $table=pivot_muat_data_byMinggu($awal, $akhir);
                $data=$table['data'];
                $column=$table['column'];

            $content.="
                <center>LAPORAN HARIAN UNIT ADMISI REKAP PENDAPATAN PENDAFTARAN <br>
                    PERIODE: ".indo_tgl($_GET['awal'])." s. d ".indo_tgl($_GET['akhir'])." </center>
            ";
            $content.=createTable($table,'Minggu');
        }
        else if ($period == '3') {
            $table=pivot_muat_data_byBulan(array('bln'=>$_GET['bln1'],'thn'=>$_GET['thawal']),array('bln'=>$_GET['bln2'],'thn'=>$_GET['thakhir']));
            $content.= "
                <center>LAPORAN BULANAN UNIT ADMISI REKAP PENDAPATAN PENDAFTARAN <br>
                PERIODE: $_GET[bln1] $_GET[thawal] s.d $_GET[bln2] $_GET[thakhir] </center>";
                $content.=createTable($table,'Bulan');
        }
        else if ($period == "4") {

            $selisih = $_GET['akhir'] - $_GET['awal'];
            $awalan = "$_GET[awal]-01-01";
            $akhiran= "$_GET[akhir]-12-31";
            $content.= "
                    <center>LAPORAN TAHUNAN UNIT ADMISI REKAP PENDAPATAN PENDAFTARAN <br>
                    PERIODE: $_GET[awal] s.d". $_GET['akhir']." </center>";
            $table=pivot_muat_data_byTahun($_GET['awal'], $_GET['akhir']);
            $content.=createTable($table,'Tahun');
        }
        return $content;
}
?>