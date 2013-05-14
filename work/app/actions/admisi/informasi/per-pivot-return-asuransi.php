<?php
$id_asuransi  (isset($_GET['id_asuransi'])) ? $_GET['id_asuransi'] : null;
echo "<div class='data-list'>";
echo '<table cellpadding="0" cellspacing="0" border="0" id="table1" class="tabel" style="display:none"></table>';
if ($_GET['period'] == 1){
    $selisih = (strtotime($akhir) - strtotime($awal)) / 24 / 60 / 60;
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KEPESERTAAN ASURANSI<br />
PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' >
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Asuransi Produk</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK PASIEN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>";
        if($id_asuransi!='' && $id_asuransi!=null) $where=" where id=$_GET[id_asuransi]";
        else{
            $where="";
        }
        $sql = _select_arr("select * from asuransi_produk $where");
        $no = 1;
        $jumlahTotal = 0;
        foreach ($sql as $row) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
            $tot = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = count(_select_arr("select * from 
                    penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, bed b,kunjungan k  
                    JOIN asuransi_kepesertaan_kunjungan on k.id=asuransi_kepesertaan_kunjungan.id_kunjungan
                    JOIN asuransi_produk on asuransi_produk.id=asuransi_kepesertaan_kunjungan.id_asuransi_produk
                    where  k.status='Masuk' and k.id_bed = b.id and ps.id = k.id_pasien
                    and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk 
                    and b.id_kelas = 1 and asuransi_produk.id='$row[id]' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tot+=$jml;
            }
            echo "<td align=center>" . getValue($tot) . "</td></tr>
			";
            $jumlahTotal+=$tot;
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl=0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, bed b, kunjungan k  
                    JOIN asuransi_kepesertaan_kunjungan on k.id=asuransi_kepesertaan_kunjungan.id_kunjungan
                    JOIN asuransi_produk on asuransi_produk.id=asuransi_kepesertaan_kunjungan.id_asuransi_produk
                    where  k.status='Masuk' and k.id_bed = b.id and ps.id = k.id_pasien and pd.id = ps.id_penduduk and b.id_kelas = 1 and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl=$jmlttl+$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>"; //dah
}

if ($_GET['period'] == 2) {
    if (($_GET['idLap']==15)) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN KEPESERTAAN ASURANSI<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";

        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' >
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='125px' rowspan=2>Asuransi Produk</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK PASIEN MINGGU KE -</th></tr>";

        $date = explode("-", $tanggal);
        $no = 0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $sqli = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            echo "<th class='nosort' style='text-align:center;'>$i</th>";
            $no += 1;
        }
        echo "<th class='nosort' style='text-align:center;'>Total</th></tr><tbody>
				";

       if($id_asuransi!='' && $id_asuransi!=null) $where=" where id=$_GET[id_asuransi]";
        else{
            $where="";
        }
        $sql = _select_arr("select * from asuransi_produk $where");
        $no = 1;
        foreach($sql as $rows) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$rows[nama]</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
			$jmlttl =0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, bed b, kunjungan k 
                        JOIN asuransi_kepesertaan_kunjungan on k.id=asuransi_kepesertaan_kunjungan.id_kunjungan
                        JOIN asuransi_produk on asuransi_produk.id=asuransi_kepesertaan_kunjungan.id_asuransi_produk and asuransi_produk.id='$rows[id]'
                        where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and 
                        ps.id = k.id_pasien and pd.id = ps.id_penduduk 
                        and pd.id = dp.id_penduduk and k.waktu 
                        between '$thn' and '$next[0]'"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $n += 1;
                $jmlttl+=$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
			</tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
        $date = explode("-", $tanggal);
        $no = 0;
        $jumlahTotal = 0;
        if($id_asuransi!='' && $id_asuransi!=null) $where=" and asuransi_produk.id=$_GET[id_asuransi]";
        else{
            $where="";
        }
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, bed b, kunjungan k
                     JOIN asuransi_kepesertaan_kunjungan on k.id=asuransi_kepesertaan_kunjungan.id_kunjungan
                     JOIN asuransi_produk on asuransi_produk.id=asuransi_kepesertaan_kunjungan.id_asuransi_produk $where
                        where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and 
                    ps.id = k.id_pasien and pd.id = ps.id_penduduk 
                    and pd.id = dp.id_penduduk and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
            $jumlahTotal+=$total;
        }
        echo "<td align=center>" . getValue($jumlahTotal) . "</td></tr>
		</table>";
    }
}



if($_GET['period']== 3){
    
 ?>
        <h2 align="center">DAFTAR PASIEN BERDASARKAN KEPESERTAAN ASURANSI<br>
            PERIODE: <?php echo $awal . " s.d " . $akhir ?></h2>
<?
        
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' >
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='145px' rowspan=2>Alamat Kelurahan</th>";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            $cols = 12 - (blnAngka($_GET['bln' . $no]) - 1);
            if ($selisih == 1) {
                $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
            }
            if ($selisih == 2) {
                if ($no == 2) {
                    if (blnAngka($_GET['bln2']) > 6) {
                        $cols = blnAngka($_GET['bln2']);
                    }
                }
            }
            if ($selisih > 2) {
                if ($no >= 2) {
                    $cols = 12;
                } else if ($no == $selisih) {
                    $cols = blnAngka($_GET['bln2']);
                }
            }

            echo "<th colspan='$cols'>$i</th>";
            $no += 1;
        }
        echo "</tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];

        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px'>" . bln($i) . "</th>";
        }
        echo "</tr>";
        
        if($id_asuransi!='' && $id_asuransi!=null) $where=" where id=$_GET[id_asuransi]";
        else{
            $where="";
        }
        $sql = _select_arr("select * from asuransi_produk $where");
        $no = 1;
        foreach($sql as $row) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . $row['nama'] . "</td>";

            for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
                echo "<td align=center>";
                $num = 0;
                for ($j = $_GET['thawal']; $j <= $_GET['thakhir']; $j++) {
                    if ($i > (12 * $num)) {
                        $tahun = $thawal + $num;
                    } else {
                        $tahun = $thawal;
                    }
                    $num += 1;
                }

                $tgl = "$tahun-" . getBln($i) . "";
                $jml = _select_unique_result("select count(*) as jumlah from penduduk pd, pasien p, 
                        dinamis_penduduk dp, bed b , kunjungan k
                        JOIN asuransi_kepesertaan_kunjungan on k.id=asuransi_kepesertaan_kunjungan.id_kunjungan
                        JOIN asuransi_produk on asuransi_produk.id=asuransi_kepesertaan_kunjungan.id_asuransi_produk and asuransi_produk.id=$row[id]
                        where k.status='Masuk' and  
                        k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and 
                        pd.id = p.id_penduduk and p.id = k.id_pasien  
                        and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'");
                $jml=$jml['jumlah'];
                echo "" . ($jml) . "</td>";
            }
            echo "
			</tr>
			";
            $no += 1;
        }

        echo "
		<tr><td></td><td>Total</td>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];

        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<td align=center>";
            $num = 0;
            for ($j = $_GET['thawal']; $j <= $_GET['thakhir']; $j++) {
                if ($i > (12 * $num)) {
                    $tahun = $thawal + $num;
                } else {
                    $tahun = $thawal;
                }
                $num += 1;
            }
            $tgl = "$tahun-" . getBln($i) . "";
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, 
                    bed b ,kunjungan k
                    JOIN asuransi_kepesertaan_kunjungan on k.id=asuransi_kepesertaan_kunjungan.id_kunjungan
                     JOIN asuransi_produk on asuransi_produk.id=asuransi_kepesertaan_kunjungan.id_asuransi_produk $where
                    where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
        }
        echo "</tr>
		</table>
		";
}

if($_GET['period']== 4){
    
        echo "<h2 align=center align=center>LAPORAN TAHUNAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KEPESERTAAN ASURANSI <br />
PERIODE: $startDate s . d $endDate</h2>";
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' >
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Produk Asuransi</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK PASIEN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        if($id_asuransi!='' && $id_asuransi!=null) $where=" where id=$_GET[id_asuransi]";
        else{
            $where="";
        }
        $sql = _select_arr("select * from asuransi_produk $where");
        $no = 1;
        foreach( $sql as $row) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = _select_unique_result("select count(*) jumlah from penduduk pd, pendidikan p, dinamis_penduduk dp, 
                        pasien ps, bed b, kunjungan k 
                        JOIN asuransi_kepesertaan_kunjungan on k.id=asuransi_kepesertaan_kunjungan.id_kunjungan
                        JOIN asuransi_produk on asuransi_produk.id=asuransi_kepesertaan_kunjungan.id_asuransi_produk and asuransi_produk.id=$row[id]
                        where k.status='Masuk' and  k.id_bed = b.id 
                        and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and 
                        p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and 
                        k.waktu like ('$tgl[$i]%')");
                $jml=$jml['jumlah'];
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl+=$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, 
                    dinamis_penduduk dp, pasien ps, bed b, kunjungan k
                    JOIN asuransi_kepesertaan_kunjungan on k.id=asuransi_kepesertaan_kunjungan.id_kunjungan
                     JOIN asuransi_produk on asuransi_produk.id=asuransi_kepesertaan_kunjungan.id_asuransi_produk $where
                    where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
}

?>