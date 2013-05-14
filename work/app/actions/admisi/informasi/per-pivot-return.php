<?
require_once "app/lib/common/functions.php";
echo "<div class='data-list'>";
echo '<table cellpadding="0" cellspacing="0" border="0" id="table1" class="tabel" style="display:none"></table>';
function getValue($val) {
    if ($val == 0)
        return '0';
    else
        return $val;
}

$aksi           = "";
$axsi           = "";
$n              = 0;
$startDate      = (isset($_GET['awal'])) ? $_GET['awal'] : null;
$endDate        = (isset($_GET['akhir'])) ? $_GET['akhir'] : null;
$startDateMysql = ($startDate != NULL) ? date2mysql($startDate) : null;
$endDateMysql   = ($endDate != NULL) ? date2mysql($endDate) : null;
$thawal         = isset($_GET['thawal']) ? $_GET['thawal'] : null;
$thakhir        = isset($_GET['thakhir']) ? $_GET['thakhir'] : null;
$idPrf=  (isset($_GET['idPrf'])) ? $_GET['idPrf'] : null;
//show_array($_GET);
$awal           = "" . date2mysql($startDate) . " 00:00:00";
$akhir          = "" . date2mysql($endDate) . " 23:59:59";
if ($_GET['period'] == 1)
{
    $selisih = (strtotime($akhir) - strtotime($awal)) / 24 / 60 / 60;

    if (!empty($_GET['jeKel']))
	{
		if ($_GET['jeKel'] != 'LP')
            $axsi = "and pd.jenis_kelamin = '$_GET[jeKel]'";
			
		echo '<h2 align="center">LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN JENIS KELAMIN <br />PERIODE: ' . indo_tgl($startDate) . ' s . d ' . indo_tgl($endDate) . '</h2>
		<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="overflow: auto;width: 100%;display: block">
			<tr>
				<th rowspan="2" style="width: 20px;">No</th>
				<th rowspan="2" style="width: 150px;">Jenis Kelamin</th>
				<th colspan="' . ($selisih + 2) . '">BANYAK KUNJUNGAN HARIAN</th>
			</tr>';
				
		$date = explode("/", $_GET['awal']);
		for ($i = 0; $i <= $selisih; $i++)
		{
			//$x     = mktime(0, 0, 0, date($date[1]), date($date[0])+$i, date($date[2]));
			$x     = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
			$new   = date("d M", $x);
			echo   '<th class="nosort" style="text-align:center;">'.$new.'</th>';
			$tgl[] = date("Y-m-d", $x);
        }
        echo '<th style="text-align:center;">total</th></tr>';
		if ($_GET['jeKel'] == 'LP')
		{
			echo '<tr>
				<td align="center">1</td>
				<td>Laki-laki</td>';
			$jmlttlL = 0;
			for ($i = 0; $i <= $selisih; $i++)
			{
				$jmlL = mysql_num_rows(
							mysql_query("
								select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and
								pd.id=p.id_penduduk and p.id=k.id_pasien and k.id_bed=b.id and
								pd.jenis_kelamin = 'L' and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%')
							")
						);
				echo '<td align="center">' . getValue($jmlL) . '</td>';
				$jmlttlL = $jmlttlL + $jmlL;
			}
			echo '<td align="center">' . getValue($jmlttlL) . '</td>
				</tr>
				<tr class="#F4F4F4">
					<td align="center">2</td>
					<td>Perempuan</td>';
			//dah
			
			$jmlttlP = 0;
			for ($i = 0; $i <= $selisih; $i++)
			{
				$jmlP = mysql_num_rows(
							mysql_query("
								select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and
								pd.id=p.id_penduduk and k.id_bed=b.id and p.id=k.id_pasien and
								pd.jenis_kelamin = 'P' and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%')
							")
						);
                echo '<td align="center">' . getValue($jmlP) . '</td>';
				$jmlttlP = $jmlttlP + $jmlP;
			}
            echo '<td align="center">' . getValue($jmlttlP) . '</td></tr>';
			//dah
		}
        if ($_GET['jeKel'] == 'L')
		{
			$jmlL = mysql_num_rows(
						mysql_query("
							select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and
							pd.id=p.id_penduduk and k.id_bed = b.id and p.id=k.id_pasien and
							pd.jenis_kelamin = 'L' and b.id_kelas = 1 and date(k.waktu)
							between '$startDateMysql' and '$endDateMysql'
						")
					);
			echo '<tr>
					<td align="center">1</td>
					<td>Laki-laki</td>';
			$jmlttl = 0;
			for ($i = 0; $i <= $selisih; $i++)
			{
				$jmlL = mysql_num_rows(
							mysql_query("
								select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and
								pd.id=p.id_penduduk and p.id=k.id_pasien and k.id_bed = b.id and
								pd.jenis_kelamin = 'L' and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%')
							")
						);
				echo '<td align="center">' . getValue($jmlL) . '</td>';
				$jmlttl = $jmlttl + $jmlL;
			}
            echo '<td align="center">' . getValue($jmlttl) . '</td>
				</tr>';
			//dah
			
		}
		
		if ($_GET['jeKel'] == 'P')
		{
			$jmlP = mysql_num_rows(
						mysql_query("
							select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and 
							pd.id=p.id_penduduk and k.id_bed = b.id and p.id=k.id_pasien and
							pd.jenis_kelamin = 'P' and b.id_kelas = 1 and date(k.waktu)
							between '$startDateMysql' and '$endDateMysql'
						")
					);
			echo '<tr>
					<td align="center">1</td>
					<td>Perempuan</td>';
			$jmlttl = 0;
			for ($i = 0; $i <= $selisih; $i++)
			{
				$jmlP = mysql_num_rows(
							mysql_query("
								select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and 
								pd.id=p.id_penduduk and p.id=k.id_pasien and k.id_bed = b.id and
								pd.jenis_kelamin = 'P' and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%')
							")
						);
				echo '<td align="center">' . getValue($jmlP) . '</td>';
				$jmlttl = $jmlttl + $jmlP;
			}
            echo '<td align="center">' . getValue($jmlttl) . '</td>
				</tr>';
			//dah
		}
		if ($_GET['jeKel'] != 'LP')
			$aksi = "and jenis_kelamin = '$_GET[jeKel]'";
		else
			$aksi = "";
        echo '</tbody>
			<tr>
				<td></td>
				<td>Total</td>';
		$jmlttl = 0;
        for ($i = 0; $i <= $selisih; $i++)
		{
            $total = mysql_num_rows(
						mysql_query("
							select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and 
							pd.id=p.id_penduduk and k.id_bed = b.id and p.id=k.id_pasien and
							(pd.jenis_kelamin = 'P' or pd.jenis_kelamin = 'L') and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') $aksi
						")
					);
            echo '<td align="center">' . getValue($total) . '';
			$jmlttl = $jmlttl + $total;
        }
        echo '<td align="center">' . getValue($jmlttl) . '</td>
			</tr> 
		</table>';
		// udah
		
		$ignoreRows = "[2]";
		$ignoreCols = "[1]";
	}
    if (!empty($_GET['idPkw'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PERKAWINAN <br />
PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if ($_GET['idPkw'] != 'ss') {
            $aksi = "where id_perkawinan = '$_GET[idPkw]'";
            $axsi = "where dp.status_pernikahan = '$_GET[idPkw]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Status Perkawinan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th style='text-align:center;'>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select dinamis_penduduk.status_pernikahan as perkawinan from dinamis_penduduk $axsi  Group by  dinamis_penduduk.status_pernikahan");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[perkawinan]</td>";
			
			$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and ps.id = k.id_pasien and pd.id = ps.id_penduduk  and pd.id = dp.id_penduduk and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl=$jmlttl+$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
			"; //dah
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
        $jmlttl=0;
		for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and ps.id = k.id_pasien
			and pd.id = ps.id_penduduk and pd.id = dp.id_penduduk and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl=$jmlttl+$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>"; //dah
    }

    if (!empty($_GET['idPdd'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PENDIDIKAN <br />
PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if ($_GET['idPdd'] != 'sp') {
            $aksi = "where id = '$_GET[idPdd]'";
            $axsi = "and dp.id_pendidikan_terakhir = '$_GET[idPdd]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Status Pendidikan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from pendidikan $aksi");
        $no = 1;
        $jumlahTotal = 0;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
            $tot = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b  where  k.status='Masuk' and k.id_bed = b.id and ps.id = k.id_pasien
				and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and b.id_kelas = 1 and dp.id_pendidikan_terakhir = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b  where  k.status='Masuk' and k.id_bed = b.id and ps.id = k.id_pasien and pd.id = ps.id_penduduk and b.id_kelas = 1 and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl=$jmlttl+$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>"; //dah
    }
//profesi harian>>
   if (!empty($_GET['idPrf']))
	{
 if ($idPrf != 'spk') {
            $aksi = "where id = '$idPrf'";
            $axsi = "and dp.id_profesi = '$idPrf'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>profesi</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from profesi $aksi");
        $no = 1;
        $jumlahTotal = 0;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
            $tot = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and ps.id = k.id_pasien and pd.id = ps.id_penduduk and b.id_kelas = 1 and p.id = dp.id_profesi and pd.id = dp.id_penduduk and dp.id_profesi = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tot+=$jml;
            }
            echo "<td align=center>" . getValue($tot) . "</td></tr>";
            $jumlahTotal+=$tot;
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and ps.id = k.id_pasien and pd.id = ps.id_penduduk and b.id_kelas = 1 and p.id = dp.id_profesi and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
        }
        echo "<td align=center>" . getValue($jumlahTotal) . "</td></tr>
		</table>";
	}
	//<<end profesi
    if (!empty($_GET['idPkj'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PEKERJAAN <br />
PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if ($_GET['idPkj'] != 'spk') {
            $aksi = "where id = '$_GET[idPkj]'";
            $axsi = "and dp.id_pekerjaan = '$_GET[idPkj]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Pekerjaan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from pekerjaan $aksi");
        $no = 1;
        $jumlahTotal = 0;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
            $tot = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pekerjaan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and ps.id = k.id_pasien and pd.id = ps.id_penduduk and b.id_kelas = 1 and p.id = dp.id_pekerjaan and pd.id = dp.id_penduduk and dp.id_pekerjaan = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tot+=$jml;
            }
            echo "<td align=center>" . getValue($tot) . "</td></tr>";
            $jumlahTotal+=$tot;
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pekerjaan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and ps.id = k.id_pasien and pd.id = ps.id_penduduk and b.id_kelas = 1 and p.id = dp.id_pekerjaan and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
        }
        echo "<td align=center>" . getValue($jumlahTotal) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idAgm'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN AGAMA <br />
PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if ($_GET['idAgm'] != 'sa') {
            $aksi = "where id = '$_GET[idAgm]'";
            $axsi = "and dp.id_agama = '$_GET[idAgm]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Agama</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from agama $aksi");
        $no = 1;
        
        $jumlahTotal = 0;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
			$tot = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and ps.id = k.id_pasien and
				pd.id = ps.id_penduduk and p.id = dp.id_agama and b.id_kelas = 1 and pd.id = dp.id_penduduk and dp.id_agama = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tot+=$jml;
            }
            echo "<td align=center>" . getValue($tot) . "</td></tr></tbody>";
            $no += 1;
        }

        echo "
		<tr><td></td><td>Total</td>";
		$jmlttl=0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and ps.id = k.id_pasien and pd.id = ps.id_penduduk and b.id_kelas = 1 and p.id = dp.id_agama and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl=$jmlttl+$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idKel'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KELURAHAN <br />
PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if (isset($_GET['idKel'])) {
            if ($_GET['idKel'] != 'all') {
                $aksi = "where id = '$_GET[idKel]'";
                $axsi = "and dp.id_kelurahan = '$_GET[idKel]'";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Kelurahan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from kelurahan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>";
			$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and b.id_kelas = 1 and p.id = k.id_pasien and dp.id_kelurahan = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl=$jmlttl+$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl=0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and b.id_kelas = 1 and p.id = k.id_pasien and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl=$jmlttl+$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idKec'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KECAMATAN <br />
PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if (isset($_GET['idKec'])) {
            if ($_GET['idKec'] != 'all') {
                $aksi = "where id = '$_GET[idKec]'";
                $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$_GET[idKec]')";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Kecamatan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from kecamatan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>";
			$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and k.id_pasien = ps.id and ps.id_penduduk = p.id and b.id_kelas = 1 and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$row[id]') and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl=$jmlttl+$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl=0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl=$jmlttl+$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idKab'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KABUPATEN <br />
PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if (isset($_GET['idKab'])) {
            if ($_GET['idKab'] != 'all') {
                $aksi = "where id = '$_GET[idKab]'";
                $axsi = " and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$_GET[idKab]'))";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Nama Kabupaten</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from kabupaten $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>";
			$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and k.id_pasien = ps.id and ps.id_penduduk = p.id and b.id_kelas = 1 and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$row[id]')) and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl=$jmlttl+$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl=0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and k.id_pasien = ps.id and ps.id_penduduk = p.id and b.id_kelas = 1 and p.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl=$jmlttl+$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
    if (!empty($_GET['idProp'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PROVINSI <br />
PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if (isset($_GET['idProp'])) {
            if ($_GET['idProp'] != 'all') {
                $aksi = "where id = '$_GET[idProp]'";
                $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$_GET[idProp]')))";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Nama Propinsi</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from provinsi $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>";
			$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps, bed b where  k.status='Masuk' and k.id_bed = b.id and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and b.id_kelas = 1 and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$row[id]'))) and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl=$jmlttl+$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl=0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps, bed b where  k.status='Masuk' and k.id_bed = b.id and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl=$jmlttl+$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idKun'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN LAYANAN<br>
		PERIODE " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if ($_GET['idKun'] != 'st') {
            $aksi = "where k.id = '$_GET[idKun]'";
            $axsi = "and k.id_layanan = '$_GET[idKun]'";
        }

        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180'>Layanan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from layanan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
			$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and k.id_layanan = '$row[id]' and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl=$jmlttl+$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl=0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl=$jmlttl+$total;
        }
		echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idPem'])) {
        if ($_GET['idPem'] == 'charity') {
            echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN CHARITY<br>
		PERIODE " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
            if ($_GET['idPem'] != 'spm') {
                $aksi = "";
            }
            echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180'align=center>Cara<br>Pembayaran</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

            $date = explode("/", $_GET['awal']);
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
                $new = date("d M", $x);
                echo "<th>$new</th>";
                $tgl[] = date("Y-m-d", $x);
            }
            echo "<th>Total</th></tr><tbody>
				";
                        $sql2 = mysql_query("select k.id from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.rencana_cara_bayar='Bayar Sendiri'");
            while ($data2 = mysql_fetch_array($sql2)) {
                $bs[] = $data2['id'];
            }
            if (isset($bs))
                $id_bs = implode(",", $bs);
            else
                $id_bs=0;
			$no = 1;
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>Charity</td>";
            $jmlah = 0;
			$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') and k.id not in($id_bs)"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl=$jmlttl+$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>";


            echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') and k.id not in($id_bs)"));
                echo "<td align=center>" . getValue($total) . "</td>";
				$jmlttl=$jmlttl+$total;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>
		
		";
        }else if ($_GET['idPem'] == 'bs') {
            echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN BIAYA SENDIRI<br>
		PERIODE " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
            if ($_GET['idPem'] != 'spm') {
                $aksi = "";
            }
            echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180' align=center>Cara<br>Pembayaran</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

            $date = explode("/", $_GET['awal']);
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
                $new = date("d M", $x);
                echo "<th>$new</th>";
                $tgl[] = date("Y-m-d", $x);
            }
            echo "<th>Total</th></tr><tbody>
				";

            $sql2 = mysql_query("select k.id from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.rencana_cara_bayar='Charity'");
            while ($data2 = mysql_fetch_array($sql2)) {
                $charity[] = $data2['id'];
            }
            if (isset($charity))
                $id_charity = implode(",", $charity);
            else
                $id_charity=null;

            if ($id_charity == null)
                $id_charity = 0;
            $no = 1;
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>Biaya Sendiri</td>";
            $jmlah = 0;
			$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') and k.id not in($id_charity)"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl=$jmlttl+$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>";


            echo "</tbody>
		<tr><td></td><td>Total</td>";
            $totals = 0;
			$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $total = mysql_num_rows(mysql_query("select * from kunjungan k,bed b where  k.status='Masuk' and k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') and k.id not in($id_charity)"));
                echo "<td align=center>" . getValue($total) . "</td>";
				$jmlttl=$jmlttl+$total;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
        }
    }
    if (!empty($_GET['tipePas'])) {
        $row = mysql_fetch_array(mysql_query("select datediff('" . date2mysql($endDate) . "','" . date2mysql($startDate) . "') as selisih"));
        //echo "select datediff(".date2mysql($endDate).",".date2mysql($startDate).") as selisih";
        $selisih = "$row[selisih]";
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN TIPE PASIEN<br>
		PERIODE " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";

        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180'>Nama Tipe Pasien</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th align=center>Total</th></tr><tbody>
				";
        if ($_GET['tipePas'] == 2)
            $aksi = "and k.no_kunjungan_pasien = 1";
        if ($_GET['tipePas'] == 1)
            $aksi = "and k.no_kunjungan_pasien > 1";
        if ($_GET['tipePas'] == 3)
            $aksi = "";
        $jumlahTotal = 0;
        if ($_GET['tipePas'] == 2) {
            echo "<tr>
                            <td align=center>1</td>
                            <td>Pasien Baru</td>
                            ";
            $date = explode("/", $_GET['awal']);
            $tr = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
                $tgl = date("Y-m-d", $x);
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama,k.no_kunjungan_pasien
                                                   from kunjungan k join pasien ps on k.id_pasien=ps.id join penduduk p on ps.id_penduduk=p.id
												   join bed b on k.id_bed = b.id
                                                   where  k.status='Masuk' and date(k.waktu)='$tgl' and k.no_kunjungan_pasien = 1 and b.id_kelas = 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tr+=$jml;
            }
            echo "<td align=center>" . getValue($tr) . "</td></tr>";
            $jumlahTotal+=$tr;
        } else if ($_GET['tipePas'] == 1) {
            echo "<tr>
                            <td align=center>1</td>
                            <td>Pasien Lama</td>
                            ";
            $date = explode("/", $_GET['awal']);
            $tr = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
                $tgl = date("Y-m-d", $x);
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama,k.no_kunjungan_pasien
                                                   from kunjungan k join pasien ps on k.id_pasien=ps.id join penduduk p on ps.id_penduduk=p.id
												   join bed b on k.id_bed = b.id
                                                   where  k.status='Masuk' and date(k.waktu)='$tgl' and b.id_kelas = 1 and k.no_kunjungan_pasien > 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tr+=$jml;
            }
            echo "<td align=center>" . getValue($tr) . "</td></tr>";
            $jumlahTotal+=$tr;
        } else {
            echo "<tr>
                            <td align=center>1</td>
                            <td>Pasien Baru</td>
                            ";
            $date = explode("/", $_GET['awal']);
            $tr = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
                $tgl = date("Y-m-d", $x);
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama,k.no_kunjungan_pasien
                                                   from kunjungan k join pasien ps on k.id_pasien=ps.id join penduduk p on ps.id_penduduk=p.id
												   join bed b on k.id_bed = b.id
                                                   where  k.status='Masuk' and date(k.waktu)='$tgl' and b.id_kelas = 1 and k.no_kunjungan_pasien = 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tr+=$jml;
            }
            $jumlahTotal+=$tr;
            echo "<td align=center>" . getValue($tr) . "</td>
                            </tr>";

            $sql = mysql_query("select k.id_pasien, p.nama, count(k.id_pasien) as jml_kunjungan from kunjungan k,pasien ps ,penduduk p, bed b where  k.status='Masuk' and k.id_bed = b.id and k.id_pasien=ps.id and
                                ps.id_penduduk=p.id and b.id_kelas = 1 and	k.waktu between '" . date2mysql($startDate) . "' and '" . date2mysql($endDate) . "' group by k.id_pasien having
                                count(k.id_pasien) > 1
                                                            ");
            $jmlh = array();
            while ($row = mysql_fetch_array($sql)) {
                $jmlh[] = $row['jml_kunjungan'];
            }
            $jml = count($jmlh);
            echo "<tr class='odd'>
                            <td align=center>2</td>
                            <td>Pasien Lama</td>
                            ";
            $date = explode("/", $_GET['awal']);
            $tr = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
                $tgl = date("Y-m-d", $x);
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama,k.no_kunjungan_pasien
                                                   from kunjungan k join pasien ps on k.id_pasien=ps.id join penduduk p on ps.id_penduduk=p.id
                                                   join bed b on k.id_bed = b.id
                                                   where  k.status='Masuk' and date(k.waktu)='$tgl' and b.id_kelas = 1 and k.no_kunjungan_pasien > 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tr+=$jml;
            }
            $jumlahTotal+=$tr;
            echo "<td align=center>" . getValue($tr) . "</td>
                            </tr>";
        }
        echo "</tbody><tr>
			<td align=center></td>
			<td>Total</td>
			";
        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $tgl = date("Y-m-d", $x);
            $total = mysql_num_rows(mysql_query("select k.id_pasien, p.nama,k.no_kunjungan_pasien
                                                 from kunjungan k join pasien ps on k.id_pasien=ps.id join penduduk p on ps.id_penduduk=p.id
												 join bed b on k.id_bed = b.id
                                                 where  k.status='Masuk' and  date(k.waktu)='$tgl' and b.id_kelas = 1 $aksi"));

            echo "<td align=center>" . getValue($total) . "</td>";
        }

        echo "<td align=center>" . getValue($jumlahTotal) . "</td>
			</tr>";

        echo "</table>";
    }
    if (!empty($_GET['idPerujuk'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ASAL RUJUKAN<br>
		PERIODE " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
        if ($_GET['perujuk'] <> '') {
            if ($_GET['idPerujuk'] != 'all') {
                $aksi = "and i.id = '$_GET[idPerujuk]'";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180'>Nama Rujukan</th>
				<th rowspan='2' width='180'>Nama Nakes</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("/", $_GET['awal']);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[0]) + $i, date($date[2]));
            $new = date("d M", $x);
            echo "<th style='text-align:center;'>$new</th>";
            $tgl[] = date("Y-m-d", $x);
        }
        echo "<th>Total</th></tr><tbody>
				";

        $sql = mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from instansi_relasi i, rujukan r, penduduk p,
		kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and b.id_kelas = 1 and k.id_rujukan = r.id $aksi group by i.id");

        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama_ins]</td>
                        <td>$row[nama]</td>";
            $rightTotal = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_fetch_array(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from instansi_relasi i,
			rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and k.id_rujukan = r.id and 
			i.id = '$row[id_ins]' and date(k.waktu) = '$tgl[$i]' group by i.id"));
                echo "<td align=center>" . getValue($jml['jumlah']) . "</td>";
                $rightTotal += $jml['jumlah'];
            }
            echo "<td align=center>" . getValue($rightTotal) . "</td></tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td colspan='2'>Total</td>";
        $totals = 0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_fetch_array(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from instansi_relasi i,
			rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and k.id_rujukan = r.id and 
			date(k.waktu) = '$tgl[$i]' $aksi"));
            echo "<td align=center>" . getValue($total['jumlah']) . "</td>";
            $totals += $total['jumlah'];
        }

        echo "<td align=center>" . getValue($totals) . "</td></tr>
		</table>
		
		";
    }
}
if ($_GET['period'] == 2) {
    $sql = mysql_query("select week('" . date2mysql($startDate) . "',1) as minggu1, week('" . date2mysql($endDate) . "',1) as minggu2");
    $row = mysql_fetch_array($sql);

    $selisih = $row['minggu2'] - $row['minggu1'];
    $a = mysql_fetch_array(mysql_query("select dayofweek('" . date2mysql($startDate) . "') as hari_ke"));

    $slh_hari = $a['hari_ke'] - 2; // inisialisasi awal hari senin
    if ($slh_hari == 0) {
        $tanggal = date2mysql($startDate);
    }
    if ($slh_hari > 0) {
        $tanggal = mysql_fetch_array(mysql_query("select '" . date2mysql($startDate) . "' - INTERVAL $slh_hari DAY as new_day"));
        //echo "select INTERVAL $slh_hari DAY - '".date2mysql($startDate)."' as new_day";
        $tanggal = $tanggal['new_day'];
    }
    if ($slh_hari < 0) {
        $tanggal = mysql_fetch_array(mysql_query("select '" . date2mysql($startDate) . "' - INTERVAL $slh_hari DAY as new_day"));
        $tanggal = $tanggal['new_day'];
    }

    //echo "$tanggal";
    if (!empty($_GET['jeKel'])) {

        if ($_GET['jeKel'] != 'LP') {
            $axsi = "and pd.jenis_kelamin = '$_GET[jeKel]'";
        }
        echo "<h2 align=center>LAPORAN MINGGUAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN JENIS KELAMIN <br />PERIODE: " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'> 
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Jenis Kelamin</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

        $date = explode("-", $tanggal);
        $no = 0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $sqli = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

            echo "<th class='nosort' style='text-align:center;'>$i</th>";

            $no += 1;
            //echo "select (INTERVAL 6 DAY + '$thn') as new_day";
        }
        echo "<th class='nosort' style='text-align:center;'>Total</th></tr>
				";
        if ($_GET['jeKel'] == 'LP') {


            echo "
					<tr>
						<td align=center> 1</td>
						<td>Laki-laki</td>";
            $date = explode("-", $tanggal);
            $no = 0;
			$jmlttl=0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and
							pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and k.waktu between '$thn' and '$next[0]'"));
                echo "<td align=center>" . getValue($jmlL) . "</td>";
                $no += 1;
				$jmlttl+=$jmlL;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
					<tr class='#F4F4F4'>
						<td align=center> 2</td>
						<td>Perempuan</td>";
            $date = explode("-", $tanggal);
            $no = 0;
			$jmlttl=0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and
							pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and k.waktu between '$thn' and '$next[0]'"));
                echo "<td align=center>" . getValue($jmlP) . "</td>";
				$jmlttl+=$jmlP;
                $no += 1;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
				";
        }
        if ($_GET['jeKel'] == 'L') {
            $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and date(k.waktu) between '$startDateMysql' and '$endDateMysql'"));
            echo "
					<tr>
						<td align=center> 1</td>
						<td>Laki-laki</td>";
            $date = explode("-", $tanggal);
            $no = 0;
			$jmlttl=0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and
							pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and k.waktu between '$thn' and '$next[0]'"));
                echo "<td align=center>" . getValue($jmlL) . "</td>";
				$jmlttl+=$jmlL;
                $no += 1;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
					</tr>
				";
        }

        if ($_GET['jeKel'] == 'P') {
            $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and date(k.waktu) between '$startDateMysql' and '$endDateMysql'"));
            echo "
					<tr>
						<td align=center> 1</td>
						<td>Perempuan</td>";
            $date = explode("-", $tanggal);
            $no = 0;
			$jmlttl =0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and
							pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and k.waktu between '$thn' and '$next[0]'"));
                echo "<td align=center>" . getValue($jmlP) . "</td>";
				$jmlttl+=$jmlP;
                $no += 1;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
					</tr>
				";
        }
        if ($_GET['jeKel'] != 'LP')
            $aksi = "and jenis_kelamin = '$_GET[jeKel]'";

        echo "
				<tr><td></td><td>Total</td>";
        $date = explode("-", $tanggal);
        $no = 0;
		$jmlttl =0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

            $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and
							pd.id=p.id_penduduk and p.id=k.id_pasien and k.waktu between '$thn' and '$next[0]' $aksi"));
            echo "<td align=center>" . getValue($jmlP) . "</td>";
			$jmlttl+=$jmlP;
            $no += 1;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>
				</tr>
				</table>	
				";
    }
    if (!empty($_GET['idPkw'])) {

        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PERKAWINAN<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if ($_GET['idPkw'] != 'ss') {
            $aksi = "where id_perkawinan = '$_GET[idPkw]'";
            $axsi = "where dp.status_pernikahan = '$_GET[idPkw]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='95px' rowspan=2>Jenis</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

        $date = explode("-", $tanggal);
        $no = 0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $sqli = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

            echo "<th class='nosort' style='text-align:center;'>$i</th>";

            $no += 1;
            //echo "select (INTERVAL 6 DAY + '$thn') as new_day";
        }
        echo "<th class='nosort' style='text-align:center;'>Total</th></tr><tbody>
				";

        $sql = mysql_query("select dinamis_penduduk.status_pernikahan as perkawinan from dinamis_penduduk $axsi  Group by  dinamis_penduduk.status_pernikahan");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$rows[perkawinan]</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
			$jmlttl =0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jml = mysql_num_rows(mysql_query("select dp.id from penduduk pd, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and k.waktu between '$thn' and '$next[0]'"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl+=$jml;
                $n += 1;
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
		$jmlttl =0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

            $total = mysql_num_rows(mysql_query("select dp.id from penduduk pd,  dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and pd.id = dp.id_penduduk
		and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
    if (!empty($_GET['idPdd'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PENDIDIKAN<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if ($_GET['idPdd'] != 'sp') {
            $aksi = "where id = '$_GET[idPdd]'";
            $axsi = "and dp.id_pendidikan_terakhir = '$_GET[idPdd]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='95px' rowspan=2>Jenis</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

        $date = explode("-", $tanggal);
        $no = 0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $sqli = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

            echo "<th class='nosort' style='text-align:center;'>$i</th>";

            $no += 1;
            //echo "select (INTERVAL 6 DAY + '$thn') as new_day";
        }
        echo "<th class='nosort' style='text-align:center;'>Total</th></tr><tbody>
				";

        $sql = mysql_query("select * from pendidikan $aksi");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

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

                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and 
							dp.id_pendidikan_terakhir = '$rows[id]' and k.waktu between '$thn' and '$next[0]'"));
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
		$jmlttl =0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idPkj'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PEKERJAAN<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if ($_GET['idPkj'] != 'spk') {
            $aksi = "where id = '$_GET[idPkj]'";
            $axsi = "and dp.id_pekerjaan = '$_GET[idPkj]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='125px' rowspan=2>Jenis</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

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

        $sql = mysql_query("select * from pekerjaan $aksi");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

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

                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pekerjaan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pekerjaan and pd.id = dp.id_penduduk and dp.id_pekerjaan = '$rows[id]' and k.waktu between '$thn' and '$next[0]'"));
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
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pekerjaan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pekerjaan and pd.id = dp.id_penduduk and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
            $jumlahTotal+=$total;
        }
        echo "<td align=center>" . getValue($jumlahTotal) . "</td></tr>
		</table>";
    }
	//profesi mingguan
	   if (!empty($idPrf)) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PROFESI<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if ($idPrf != 'spk') {
            $aksi = "where id = '$idPrf'";
            $axsi = "and dp.id_profesi = '$idPrf'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='125px' rowspan=2>Jenis</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

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

        $sql = mysql_query("select * from profesi $aksi");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

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

                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and dp.id_profesi = '$rows[id]' and k.waktu between '$thn' and '$next[0]'"));
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
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
            $jumlahTotal+=$total;
        }
        echo "<td align=center>" . getValue($jumlahTotal) . "</td></tr>
		</table>";
    }
	//end
    if (!empty($_GET['idAgm'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PEKERJAAN<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if ($_GET['idAgm'] != 'sa') {
            $aksi = "where id = '$_GET[idAgm]'";
            $axsi = "and dp.id_agama = '$_GET[idAgm]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='125px' rowspan=2>Nama Agama</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

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

        $sql = mysql_query("select * from agama $aksi");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

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

                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_agama and pd.id = dp.id_penduduk and dp.id_agama = '$rows[id]' and k.waktu between '$thn' and '$next[0]'"));
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
		$jmlttl =0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_agama and pd.id = dp.id_penduduk and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
    if (!empty($_GET['idKel'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KELURAHAN<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if (isset($_GET['idKel'])) {
            if ($_GET['idKel'] != 'all') {
                $aksi = "where id = '$_GET[idKel]'";
                $axsi = "and dp.id_kelurahan = '$_GET[idKel]'";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='145px' rowspan=2>Nama Kelurahan</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

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

        $sql = mysql_query("select * from kelurahan $aksi");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($rows['nama'])) . "</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
			$jmlttl =0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and dp.id_kelurahan = '$rows[id]' and k.waktu between '$thn' and '$next[0]'"));
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
		$jmlttl =0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
    if (!empty($_GET['idKec'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KECAMATAN<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if (isset($_GET['idKec'])) {
            if ($_GET['idKec'] != 'all') {
                $aksi = "where id = '$_GET[idKec]'";
                $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$_GET[idKec]')";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='145px' rowspan=2>Nama Kelurahan</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

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

        $sql = mysql_query("select * from kecamatan $aksi");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($rows['nama'])) . "</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
			$jmlttl =0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$rows[id]') and k.waktu between '$thn' and '$next[0]'"));
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
		$jmlttl =0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
			$jmlttl+=$total;
        }
        echo "<td align=center>$jmlttl </td></tr>
		</table>";
    }
    if (!empty($_GET['idKab'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KABUPATEN<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if (isset($_GET['idKab'])) {
            if ($_GET['idKab'] != 'all') {
                $aksi = "where id = '$_GET[idKab]'";
                $axsi = " and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$_GET[idKab]'))";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='145px' rowspan=2>Nama Kabupaten</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

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

        $sql = mysql_query("select * from kabupaten $aksi");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($rows['nama'])) . "</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
			$jmlttl =0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$rows[id]')) and k.waktu between '$thn' and '$next[0]'"));
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
		$jmlttl =0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
    if (!empty($_GET['idProp'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PROPINSI<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if (isset($_GET['idProp'])) {
            if ($_GET['idProp'] != 'all') {
                $aksi = "where id = '$_GET[idProp]'";
                $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$_GET[idProp]')))";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='145px' rowspan=2>Nama Propinsi</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

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

        $sql = mysql_query("select * from provinsi $aksi");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($rows['nama'])) . "</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
			$jmlttl =0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps, bed b where  k.status='Masuk' and k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$rows[id]'))) and k.waktu between '$thn' and '$next[0]'"));
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
		$jmlttl=0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps, bed b where k.id_bed = b.id and  k.status='Masuk' and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idKun'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KUNJUNGAN<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";

        if ($_GET['idKun'] != 'st') {
            $aksi = "where k.id = '$_GET[idKun]'";
            $axsi = "and k.id_layanan = '$_GET[idKun]'";
        }

        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='145px' rowspan=2>Tujuan Kunjungan</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

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

        $sql = mysql_query("select * from layanan $aksi");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

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
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_layanan = '$rows[id]' and k.waktu between '$thn' and '$next[0]'"));
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
		$jmlttl=0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu between '$thn' and '$next[0]' $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
            $no += 1;
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }
    if (!empty($_GET['idPem'])) {
        if ($_GET['idPem'] == 'charity') {
            echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN CHARITY<br>
		PERIODE " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
            if ($_GET['idPem'] != 'spm') {
                $aksi = "";
            }
            echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='145px' rowspan=2 align=center>Cara<br>Pembayaran</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

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
            $sql2 = mysql_query("select k.id from  kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.rencana_cara_bayar='Bayar Sendiri'");
            while ($data2 = mysql_fetch_array($sql2)) {
                $bs[] = $data2['id'];
            }
            if (isset($bs))
                $id_bs = implode(",", $bs);
            else
                $id_bs=0;


            $no = 1;
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>Charity</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu between '$thn' and '$next[0]' and k.id not in($id_bs)"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $n += 1;
            }
            $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu between '$tanggal' and '$next[0]' and k.id not in($id_bs)"));
            echo "<td align=center>" . getValue($jml) . "</td>";
            echo "</tr>";
            echo "</tbody>
		<tr><td></td><td>Total</td>";
            $date = explode("-", $tanggal);
            $n = 0;
			$jmlttl =0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
                $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu between '$thn' and '$next[0]' and k.id not in($id_bs)"));
                echo "<td align=center>" . getValue($total) . "</td>";
                $n += 1;
				$jmlttl+=$total;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
		</table>
		";
        } else {
            echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN BIAYA SENDIRI<br>
		PERIODE " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";
            if ($_GET['idPem'] != 'spm') {
                $aksi = "";
            }
            echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='145px' rowspan=2>Cara Pembayaran</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

            $date = explode("-", $tanggal);
            $no = 0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
                $thn = date("Y-m-d", $x);
                $sqli = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
                echo "<th class='nosort' style='text-align:center;'>$i</th>";
                $no += 1;
            }
            echo "<th class='nosort' style='text-align:center;'>Total</th></tr><tbody>";

            $sql2 = mysql_query("select k.id from  kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.rencana_cara_bayar='Charity'");
            while ($data2 = mysql_fetch_array($sql2)) {
                $charity[] = $data2['id'];
            }
            if (isset($charity))
                $id_charity = implode(",", $charity);
            else
                $id_charity=0;


            $no = 1;
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>Biaya Sendiri</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu between '$thn' and '$next[0]' and k.id not in($id_charity)"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $n += 1;
            }
            $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu between '$tanggal' and '$next[0]' and k.id not in($id_charity)"));
            echo "<td align=center>" . getValue($jml) . "</td>";
            echo "</tr>";
            echo "</tbody>
		<tr><td></td><td>Total</td>";
            $date = explode("-", $tanggal);
            $n = 0;
			$jmlttl =0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
                $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu between '$thn' and '$next[0]' and k.id not in($id_charity)"));
                echo "<td align=center>" . getValue($total) . "</td>";
                $n += 1;
				$jmlttl+=$total;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
		</table>
		
		";
        }
    }
    if (!empty($_GET['tipePas'])) {

        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN TIPE PASIEN<br>
		PERIODE " . indo_tgl($startDate) . " s . d " . indo_tgl($endDate) . "</h2>";

        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180'>Nama Tipe Pasien</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

        $date = explode("-", $tanggal);
        $n = 0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            echo "<th class='nosort' style='text-align:center;'>$i</th>";
            $tgl[] = date("Y-m-d", $x);
            $n += 1;
        }
        echo "<th>Total</th></tr><tbody>
				";
        if ($_GET['tipePas'] == 2)
            $aksi = "and k.no_kunjungan_pasien = 1";
        if ($_GET['tipePas'] == 1)
            $aksi = "and k.no_kunjungan_pasien > 1";
        if ($_GET['tipePas'] == 3)
            $aksi = "";
        $jumlahTotal = 0;
        if ($_GET['tipePas'] == 2) {
            echo "<tr>
			<td align=center>1</td>
			<td>Pasien Baru</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
            $tot = 0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where  k.status='Masuk' and k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu between '$thn' and '$next[0]' and k.no_kunjungan_pasien = 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $n += 1;
                $tot+=$jml;
            }
            $jumlahTotal+=$tot;
            echo "<td align=center>" . getValue($tot) . "</td>
			</tr>";
        } else if ($_GET['tipePas'] == 1) {
            echo "<tr>
			<td align=center>1</td>
			<td>Pasien Lama</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
            $tot = 0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where  k.status='Masuk' and k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu between '$thn' and '$next[0]' and k.no_kunjungan_pasien > 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tot+=$jml;
                $n += 1;
            }
            $jumlahTotal+=$tot;
            echo "<td align=center>" . getValue($tot) . "</td></tr>";
        } else {
            echo "<tr>
			<td align=center>1</td>
			<td>Pasien Baru</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
            $tot = 0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where  k.status='Masuk' and k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu between '$thn' and '$next[0]' and k.no_kunjungan_pasien = 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $tot+=$jml;
                $n += 1;
            }
            $jumlahTotal+=$tot;
            echo "<td align=center>" . getValue($tot) . "</td>
			</tr>";

            echo "<tr class='odd'>
			<td align=center>2</td>
			<td>Pasien Lama</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;
            $tot = 0;
            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
                $jmlL = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where  k.status='Masuk' and k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu between '$thn' and '$next[0]' and k.no_kunjungan_pasien > 1"));
                echo "<td align=center>" . getValue($jmlL) . "</td>";
                $tot+=$jmlL;
                $n += 1;
            }
            echo "<td align=center>" . getValue($tot) . "</td>
			</tr>";
            $jumlahTotal+=$tot;
        }
        echo "</tbody><tr>
			<td align=center></td>
			<td>Total</td>
			";
        $date = explode("-", $tanggal);
        $n = 0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
            $total = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu between '$thn' and '$next[0]' $aksi"));

            echo "<td align=center>" . getValue($total) . "</td>";
            $n += 1;
        }
        echo "<td align=center>" . getValue($jumlahTotal) . "</td>
			</tr>";

        echo "</table>";
    }
    if (!empty($_GET['idPerujuk'])) {

        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ASAL RUJUKAN<br>
	PERIODE: " . indo_tgl(datefmysql($awal)) . " s / d " . indo_tgl(datefmysql($akhir)) . "</h2>";
        if ($_GET['perujuk'] <> '') {
            if ($_GET['idPerujuk'] != 'all') {
                $aksi = "and i.id = '$_GET[idPerujuk]'";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='155px' rowspan=2>Nama Perujuk</th>
                                <th width='155px' rowspan=2>Nama Nakes</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN MINGGU KE -</th></tr>";

        $date = explode("-", $tanggal);
        $no = 0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $sqli = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

            echo "<th class='nosort' style='text-align:center;'>$i</th>";

            $no += 1;
            //echo "select (INTERVAL 6 DAY + '$thn') as new_day";
        }
        echo "<th class='nosort' style='text-align:center;'>Total</th></tr><tbody>
				";

        $sql = mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from instansi_relasi i, rujukan r, penduduk p,
		kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and k.id_rujukan = r.id $aksi group by i.id");
        $no = 1;
        while ($rows = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$rows[nama_ins]</td>
                        <td>$rows[nama]</td>
			";
            $date = explode("-", $tanggal);
            $n = 0;

            for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
                $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $n), date($date[0]));
                $thn = date("Y-m-d", $x);
                $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

                $jml = mysql_fetch_array(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from
							 instansi_relasi i, rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and 
							 k.id_rujukan = r.id and i.id = '$rows[id_ins]' and k.waktu between '$thn' and '$next[0]'"));
                echo "<td align=center>$jml[jumlah] </td>";
                $n += 1;
            }
            $jml = mysql_fetch_array(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from
							instansi_relasi i, rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and 
							k.id_rujukan = r.id and i.id = '$rows[id_ins]' and k.waktu between '$tanggal' and '$next[0]'"));
            echo "<td align=center>$jml[jumlah] </td>";
            echo "</tr>";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td colspan='2'>Total</td>";
        $date = explode("-", $tanggal);
        $no = 0;
        for ($i = $row['minggu1']; $i <= $row['minggu2']; $i++) {
            $x = mktime(0, 0, 0, date($date[1]), date($date[2]) + (7 * $no), date($date[0]));
            $thn = date("Y-m-d", $x);
            $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));

            $total = mysql_fetch_array(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from
							 instansi_relasi i, rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and 
							 k.id_rujukan = r.id and k.waktu between '$thn' and '$next[0]' $aksi"));
            echo "<td align=center>$total[jumlah]</td>";
            $no += 1;
        }
        $total = mysql_fetch_array(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from
							 instansi_relasi i, rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and 
							 k.id_rujukan = r.id and k.waktu between '$tanggal' and '$next[0]' $aksi"));
        echo "<td align=center>$total[jumlah]</td>";
        echo "</tr>
		</table>";
    }
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ BULANAN +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++==
if ($_GET['period'] == 3) {

    $awal = "$_GET[bln1] $thawal";
    $akhir = "$_GET[bln2] $thakhir";
    $awalan = "$thawal-" . getBln(blnAngka($_GET['bln1'])) . "-01";
    $akhiran = "$thakhir-" . getBln(blnAngka($_GET['bln2'])) . "-31";

    $selisih = $_GET['thakhir'] - $_GET['thawal'];
    if (!empty($_GET['idTmpLahir'])) {
 ?>
        <h2 align="center">DAFTAR PASIEN BERDASARKAN TEMPAT LAHIR<br>
            PERIODE: <?php echo $awal . " s.d " . $akhir ?></h2>
<?
        if ($_GET['tmpLahir'] <> '') {
            if ($_GET['idTmpLahir'] != 'all') {
                $aksi = "where id = '$_GET[idTmpLahir]'";
                $axsi = "and dp.id_kelurahan = '$_GET[idTmpLahir]'";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
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
        $sql = mysql_query("select * from kelurahan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>";

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
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and dp.id_kelurahan = '$row[id]' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));

                echo "" . getValue($jml) . "</td>";
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
        }
        echo "</tr>
		</table>
		";
    }
    if (!empty($_GET['jeKel'])) {
        if ($_GET['jeKel'] != 'LP') {
            $axsi = "and pd.jenis_kelamin = '$_GET[jeKel]'";
        }
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN JENIS KELAMIN<br>
		PERIODE $awal s . d $akhir</h2>";
        echo "<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='95px' rowspan=2>Jenis</th>";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];

        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "
			</tr></tbody>";
        if ($_GET['jeKel'] == 'LP') {
            echo "
			<tr>
				<td align=center> 1</td>
				<td>Laki-laki</td>
				";

			$jmlttl =0;
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
                $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
                echo "" . getValue($jmlL) . "</td>";
				$jmlttl+=$jmlL;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
			</tr>
			<tr class='odd'>
				<td align=center> 2</td>
				<td>Perempuan</td>
				";
			$jmlttl =0;
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
                $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
                echo "" . getValue($jmlP) . "</td>";
				$jmlttl+=$jmlP;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>";
        }
        if ($_GET['jeKel'] == 'L') {

            echo "
			<tr>
				<td align=center> 1</td>
				<td>Laki-laki</td>
				";

			$jmlttl =0;
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
                $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
                echo "" . getValue($jmlL) . "</td>";
				$jmlttl+=$jmlL;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
			</tr>
	";
        }

        if ($_GET['jeKel'] == 'P') {

            echo "
			<tr>
				<td align=center> 1</td>
				<td>Perempuan</td>
				";

			$jmlttl =0;
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
                $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
                echo "" . getValue($jmlL) . "</td>";
				$jmlttl+=$jmlL;
            }
			echo "<td align=center>" . getValue($jmlttl) . "</td>
			</tr>
	";
        }
        echo "</tbody>
	<tr><td></td><td>Total</td>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
		$jmlttl =0;
            
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
            $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($jmlL) . "</td>";
			$jmlttl+=$jmlL;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
	</table>
	";
    }

    if (!empty($_GET['idPkw'])) {
        ;
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PERKAWINAN<br>
	PERIODE $awal s / d $akhir</h2>";
        if ($_GET['idPkw'] != 'ss') {
            $aksi = "where id_perkawinan = '$_GET[idPkw]'";
            $axsi = "where dp.status_pernikahan = '$_GET[idPkw]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='95px' rowspan=2>Status Perkawinan</th>
				";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "
			</tr><tbody>";
        $sql = mysql_query("select dinamis_penduduk.status_pernikahan as perkawinan from dinamis_penduduk $axsi  Group by  dinamis_penduduk.status_pernikahan");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[perkawinan]</td>
			";
			$jmlttl =0;	
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
                $jml = mysql_num_rows(mysql_query("select dp.id from penduduk pd,  dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and pd.id = 
							dp.id_penduduk and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));

                echo "" . getValue($jml) . "</td>";
				$jmlttl+=$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
			</tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
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
            $jml = mysql_num_rows(mysql_query("select dp.id from penduduk pd, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and pd.id = dp.id_penduduk
		and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
			$jmlttl+=$jml;
            echo "<td align=center>" . getValue($jml) . "</td>";
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }

    if (!empty($_GET['idPdd'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PENDIDIKAN<br>
	PERIODE $awal s / d $akhir</h2>";
        if ($_GET['idPdd'] != 'sp') {
            $aksi = "where id = '$_GET[idPdd]'";
            $axsi = "and dp.id_pendidikan_terakhir = '$_GET[idPdd]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan=2 width=20px>No</th>
				<th rowspan=2 width=130px>Jenis</th>
				";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . bln($i) . "</th>";
        }
        echo "
			</tr><tbody>";
        $sql = mysql_query("select * from pendidikan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {
            $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and dp.id_pendidikan_terakhir = '$row[id]' and date(k.waktu) between '$startDateMysql' and '$endDateMysql'"));
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp,
                            pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and
                            p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and dp.id_pendidikan_terakhir = '$row[id]' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));

                echo "" . getValue($jml) . "</td>";
				$jmlttl+=$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
                        </tr>";
            $no += 1;
        }
        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
    if (!empty($_GET['idPkj'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PEKERJAAN<br>
	PERIODE $awal s / d $akhir</h2>";
        if ($_GET['idPkj'] != 'spk') {
            $aksi = "where id = '$_GET[idPkj]'";
            $axsi = "and dp.id_pekerjaan = '$_GET[idPkj]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan=2 width=20px>No</th>
				<th rowspan=2 width=140px>Jenis</th>
				";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . bln($i) . "</th>";
        }
        echo "<tbody>
			</tr>";
        $sql = mysql_query("select * from pekerjaan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>

			<td align=center>$no</td>
			<td>$row[nama]</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pekerjaan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pekerjaan and pd.id = dp.id_penduduk and dp.id_pekerjaan = '$row[id]' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
                        </tr>";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pekerjaan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pekerjaan and pd.id = dp.id_penduduk and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
//profesi
  if (!empty($idPrf)) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PROFESI<br>
	PERIODE $awal s / d $akhir</h2>";
        if ($idPrf != 'spk') {
            $aksi = "where id = '$idPrf'";
            $axsi = "and dp.id_profesi = '$idPrf'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan=2 width=20px>No</th>
				<th rowspan=2 width=140px>Jenis</th>
				";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . bln($i) . "</th>";
        }
        echo "<tbody>
			</tr>";
        $sql = mysql_query("select * from profesi $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and dp.id_profesi = '$row[id]' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
                        </tr>";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
//
    if (!empty($_GET['idAgm'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN AGAMA<br>
	PERIODE $awal s / d $akhir</h2>";
        if ($_GET['idAgm'] != 'sa') {
            $aksi = "where id = '$_GET[idAgm]'";
            $axsi = "and dp.id_agama = '$_GET[idAgm]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan=2 width=20px>No</th>
				<th rowspan=2 width=95px>Jenis</th>
				";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "<tbody>
			</tr>";
        $sql = mysql_query("select * from agama $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_agama and pd.id = dp.id_penduduk and dp.id_agama = '$row[id]' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
				</tr>";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_agama and pd.id = dp.id_penduduk and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idKel'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ALAMAT KELURAHAN<br>
	PERIODE $awal s / d $akhir</h2>";
        if (isset($_GET['idKel'])) {
            if ($_GET['idKel'] != 'all') {
                $aksi = "where id = '$_GET[idKel]'";
                $axsi = "and dp.id_kelurahan = '$_GET[idKel]'";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
                        <th rowspan=2 width=20px>No</th>
                        <th rowspan=2 width=140px>Kelurahan</th>
                        ";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "</tbody>
			</tr>";
        $sql = mysql_query("select * from kelurahan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and dp.id_kelurahan = '$row[id]' and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
                        </tr>";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idKec'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ALAMAT KECAMATAN<br>
	PERIODE $awal s / d $akhir</h2>";
        if (isset($_GET['idKec'])) {
            if ($_GET['idKec'] != '') {
                $aksi = "where id = '$_GET[idKec]'";
                $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$_GET[idKec]')";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
                        <th rowspan=2 width=20px>No</th>
                        <th rowspan=2 width=140px>Kecamatan</th>
                        ";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else

                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "<tbody>
			</tr>";
        $sql = mysql_query("select * from kecamatan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$row[id]') and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
                        </tr>";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
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
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idKab'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ALAMAT KABUPATEN<br>
	PERIODE $awal s / d $akhir</h2>";
        if (isset($_GET['idKab'])) {
            if ($_GET['idKab'] != 'all') {
                $aksi = "where id = '$_GET[idKab]'";
                $axsi = " and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$_GET[idKab]'))";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
                        <th rowspan=2 width=20px>No</th>
                        <th rowspan=2 width=140px>Kabupaten</th>
                        ";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "
			</tr><tbody>";
        $sql = mysql_query("select * from kabupaten $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$row[id]')) and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
                        </tr>";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
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
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }

    if (!empty($_GET['idProp'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PROVINSI<br>
	PERIODE $awal s / d $akhir</h2>";
        if (isset($_GET['idProp'])) {
            if ($_GET['idProp'] != 'all') {
                $aksi = "where id = '$_GET[idProp]'";
                $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$_GET[idProp]')))";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
                        <th rowspan=2 width=20px>No</th>
                        <th rowspan=2 width=130px>Propinsi</th>
                        ";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "<tbody>
			</tr>";
        $sql = mysql_query("select * from provinsi $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps, bed b where  k.status='Masuk' and k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$row[id]'))) and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "'"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
                        </tr>";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
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
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $axsi"));
            echo "" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
    if (!empty($_GET['idKun'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN LAYANAN<br>
	PERIODE $awal s / d $akhir</h2>";
        if ($_GET['idKun'] != 'st') {
            $aksi = "where k.id = '$_GET[idKun]'";
            $axsi = "and k.id_layanan = '$_GET[idKun]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
                        <th rowspan=2 width=20px>No</th>
                        <th rowspan=2 width=150px>Kunjungan</th>
                        ";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "<tbody>
			</tr>";
        $sql = mysql_query("select * from layanan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {


            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_layanan = '$row[id]' and k.waktu like ('$tgl%')"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
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
            $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl%') $axsi"));
            echo "" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
    if (!empty($_GET['idPem'])) {
        if ($_GET['idPem'] == 'charity') {
            echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN CHARITY<br>
		PERIODE $awal s . d $akhir";
            if ($_GET['idPem'] != 'spm') {
                $aksi = "";
            }
            echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan=2>No</th>
				<th rowspan=2 align=center>Cara<br>Pembayaran</th>
				";
            $no = 1;
            $selisih = $selisih + 1;
            for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
                if ($no == 1) {
                    if ($_GET['thawal'] == $_GET['thakhir'])
                        $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                    else
                        $cols = 12 - blnAngka($_GET['bln1']) + 1;
                }
                else if ($no == $selisih) {
                    $cols = blnAngka($_GET['bln2']);
                } else {
                    $cols = 12;
                }

                echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
                $no += 1;
            }
            echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
            $selisih = $_GET['thakhir'] - $_GET['thawal'];
            for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
                echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
            }
            echo "<tbody>
			</tr>";
            $sql2 = mysql_query("select k.id from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.rencana_cara_bayar='Bayar Sendiri'");
            while ($data2 = mysql_fetch_array($sql2)) {
                $bs[] = $data2['id'];
            }
            if (isset($bs))
                $id_bs = implode(",", $bs);
            else
                $id_bs=0;


            $no = 1;
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
				<td align=center>$no</td>
				<td>Charity</td>
				";
				$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl%') and k.id not in($id_bs)"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
				</tr>";


            echo "</tbody>
			<tr><td></td><td>Total</td>";
			$jmlttl =0;
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
                $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl%') and k.id not in($id_bs)"));
                echo "" . getValue($total) . "</td>";
				$jmlttl+=$total;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
			</table>";
        } 
        //bayar sediri 'bs'
        else {
            echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN BIAYA SENDIRI<br>
			PERIODE $awal s . d $akhir";
            if ($_GET['idPem'] != 'spm') {
                $aksi = "";
            }
            echo "
			<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
				<tr>
					<th rowspan=2>No</th>
					<th rowspan=2>Cara Pembayaran</th>";
            $no = 1;
            $selisih = $selisih + 1;
            for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
                if ($no == 1) {
                    if ($_GET['thawal'] == $_GET['thakhir'])
                        $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                    else
                        $cols = 12 - blnAngka($_GET['bln1']) + 1;
                }
                else if ($no == $selisih) {
                    $cols = blnAngka($_GET['bln2']);
                } else {
                    $cols = 12;
                }

                echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
                $no += 1;
            }
            echo "<th rowspan=2>Total</th></tr><tr>";
            $selisih = $_GET['thakhir'] - $_GET['thawal'];
            for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
                echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
            }
            echo "<tbody>
			</tr>";
            $sql2 = mysql_query("select k.id from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.rencana_cara_bayar='Charity'");
            while ($data2 = mysql_fetch_array($sql2)) {
                $charity[] = $data2['id'];
            }
            if (isset($charity))
                $id_charity = implode(",", $charity);
            else
                $id_charity=0;


            $no = 1;
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
				<td align=center>$no</td>
				<td>Biaya Sendiri</td>
				";
				$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl%') and k.id not in($id_charity)"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
				</tr>";


            echo "</tbody>
			<tr><td></td><td>Total</td>";
			$jmlttl =0;
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
                $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl%') and k.id not in($id_charity)"));
                echo "" . getValue($total) . "</td>";
				$jmlttl+=$total;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
			</table>";
        }
    }
    if (!empty($_GET['tipePas'])) {

        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN TIPE PASIEN<br>
		PERIODE $_GET[bln1] $thawal s . d $_GET[bln2] $thakhir";
        echo "<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
				<tr>
					<th rowspan=2>No</th>
					<th rowspan=2>Cara Pembayaran</th>";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "<tbody>
			</tr>";
        if ($_GET['tipePas'] == 2)
            $aksi = " and k.no_kunjungan_pasien = 1";
        if ($_GET['tipePas'] == 1)
            $aksi = " and k.no_kunjungan_pasien > 1";
        if ($_GET['tipePas'] == 3)
            $aksi = "";

        if ($_GET['tipePas'] == 2) {
            echo "<tr>
				<td align=center>1</td>
				<td>Pasien Baru</td>
				";
            $tot = 0;
            for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {

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
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' and k.no_kunjungan_pasien = 1 and k.id=(select max(k2.id) from kunjungan k2 where k2.id_pasien=k.id_pasien)")) or die(mysql_error());

                echo "<td align=center>" . getValue($jml) . "</td>";
                $tot+=$jml;
            }
            $n += 1;
            echo"<td>" . getValue($tot) . "</td>";
            echo "</tr></tbody>";
        } else if ($_GET['tipePas'] == 1) {
            echo "<tr>
				<td align=center>1</td>
				<td>Pasien Lama</td>
				";
            $tot = 0;
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
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' and k.no_kunjungan_pasien > 1"));

                echo "" . getValue($jml) . "</td>";
                $tot+=$jml;
            }

            $n += 1;
            echo"<td>" . getValue($tot) . "</td>";
            echo "</tr></tbody>";
        } else {
            echo "<tr>
                                <td align=center>1</td>
                                <td>Pasien Baru</td>
                                ";
            $tot = 0;
            for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
                echo "<td align=center>";
                $num = 0;
                for ($j = $_GET['thawal']; $j <= $_GET['thakhir']; $j++) {
                    if ($i > (12 * $num)) {
                        $tahun = $_GET['thawal'] + $num;
                    } else {
                        $tahun = $_GET['thawal'];
                    }
                    $num += 1;
                }
                $tgl = "$tahun-" . getBln($i) . "";
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' and k.no_kunjungan_pasien = 1 and k.id=(select max(k2.id) from kunjungan k2 where k2.id_pasien=k.id_pasien)"));

                echo "" . getValue($jml) . "</td>";
                $tot+=$jml;
            }

            $n += 1;
            echo "<td>" . getValue($tot) . "</td></tr>";
            echo "<tr class='#F4F4F4'>
                                    <td align=center>2</td>
                                    <td>Pasien Lama</td>
                                    ";
            $tot = 0;
            for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
                echo "<td align=center>";
                $num = 0;
                for ($j = $_GET['thawal']; $j <= $_GET['thakhir']; $j++) {
                    if ($i > (12 * $num)) {
                        $tahun = $_GET['thawal'] + $num;
                    } else {
                        $tahun = $_GET['thawal'];
                    }
                    $num += 1;
                }
                $tgl = "$tahun-" . getBln($i) . "";
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' and k.no_kunjungan_pasien > 1"));
                $tot+=$jml;
                echo "" . getValue($jml) . "</td>";
            }

            $n += 1;

            echo "<td>" . getValue($tot) . "</td></tr></tbody>";
        }
        echo "<tr>
			<td align=center></td>
			<td>Total</td>
			";
        $tot = 0;
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<td align=center>";
            $num = 0;
            for ($j = $_GET['thawal']; $j <= $_GET['thakhir']; $j++) {
                if ($i > (12 * $num)) {
                    $tahun = $_GET['thawal'] + $num;
                } else {
                    $tahun = $_GET['thawal'];
                }
                $num += 1;
            }
            $tgl = "$tahun-" . getBln($i) . "";
            $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' $aksi"));

            $tot+=$jml;
            echo "" . getValue($jml) . "</td>";
        }

        $n += 1;
        echo "<td>" . getValue($tot) . "</td>";
        echo "</tr>";
        echo "</table>";
    }
    if (!empty($_GET['idPerujuk'])) {

        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ASAL RUJUKAN<br>
	PERIODE $awal s / d $akhir</h2>";

        if ($_GET['idPerujuk'] != 'all') {
            $aksi = "and i.id = '$_GET[idPerujuk]'";
        }



        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th width='20px' rowspan=2>No</th>
				<th width='155px' rowspan=2>Nama Perujuk </th>
                                <th width='155px' rowspan=2>Nama Nakes </th>
				";
        $no = 1;
        $selisih = $selisih + 1;
        for ($i = $_GET['thawal']; $i <= $_GET['thakhir']; $i++) {
            if ($no == 1) {
                if ($_GET['thawal'] == $_GET['thakhir'])
                    $cols = blnAngka($_GET['bln2']) - blnAngka($_GET['bln1']) + 1;
                else
                    $cols = 12 - blnAngka($_GET['bln1']) + 1;
            }
            else if ($no == $selisih) {
                $cols = blnAngka($_GET['bln2']);
            } else {
                $cols = 12;
            }

            echo "<th colspan='$cols' class='nosort' style='text-align:center;'><h3>$i</h3></th>";
            $no += 1;
        }
        echo "<th rowspan=2 width=90px><h3>Total</h3></th></tr><tr>";
        $selisih = $_GET['thakhir'] - $_GET['thawal'];
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
            echo "<th width='65px' class='nosort' style='text-align:center;'>" . substr(bln($i), 0, 3) . "</th>";
        }
        echo "
			</tr><tbody>";
        $sql = mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from instansi_relasi i, rujukan r, penduduk p,
		kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and k.id_rujukan = r.id $aksi group by i.id");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama_ins]</td>
                        <td>$row[nama]</td>
			";
			$jmlttl =0;
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
                $jml = mysql_num_rows(mysql_query("select i.nama from instansi_relasi i, rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' and i.id = '$row[id_ins]' and k.id_rujukan = r.id $aksi"));
				$jmlttl+=$jml;
                echo "" . getValue($jml) . "</td>";
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>
			</tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td colspan='2'>Total</td>";
		$jmlttl =0;
        for ($i = blnAngka($_GET['bln1']); $i <= blnAngka($_GET['bln2']) + ($selisih * 12); $i++) {
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
            $jml = mysql_num_rows(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan from instansi_relasi i, rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and year(k.waktu)='$tahun' and month(k.waktu)='" . getBln($i) . "' and k.id_rujukan = r.id $aksi"));
			$jmlttl+=$jml;
            echo "<td align=center>" . getValue($jml) . "</td>";
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td></tr>
		</table>";
    }
}
if ($_GET['period'] == 4) {
    $awal = "01/01/$startDate";
    $akhir = "31/12/$endDate";
    $awalan = date2mysql($awal);
    $akhiran = date2mysql($akhir);
    $selisih = ($endDate - $startDate);

    if (!empty($_GET['jeKel'])) {
        if ($_GET['jeKel'] != 'LP') {
            $axsi = "and pd.jenis_kelamin = '$_GET[jeKel]'";
        }
        echo "<h2 align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN JENIS KELAMIN <br />PERIODE: $startDate s . d $endDate</h2>
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Jenis Kelamin</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        if ($_GET['jeKel'] == 'LP') {


            echo "
					<tr>
						<td align=center> 1</td>
						<td>Laki-laki</td>";
						$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and
							pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jmlL) . "</td>";
				$jmlttl+=$jmlL;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
					<tr class='odd'>
						<td align=center> 2</td>
						<td>Perempuan</td>";
						$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jmlP) . "</td>";
				$jmlttl+=$jmlP;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
				";
        }
        if ($_GET['jeKel'] == 'L') {
            $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and date(k.waktu) between '$startDateMysql' and '$endDateMysql'"));
            echo "
					<tr>
						<td align=center> 1</td>
						<td>Laki-laki</td>";
						$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and
							pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jmlL) . "</td>";
				$jmlttl+=$jmlL;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "
					</tr>
				";
        }

        if ($_GET['jeKel'] == 'P') {
            $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and date(k.waktu) between '$startDateMysql' and '$endDateMysql'"));
            echo "
					<tr>
						<td align=center> 1</td>
						<td>Perempuan</td>";
						$jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jmlP) . "</td>";
				$jmlttl+=$jmlP;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "
					</tr>
				";
        }
        if ($_GET['jeKel'] != 'LP')
            $aksi = "and jenis_kelamin = '$_GET[jeKel]'";

        echo "</tbody>
				<tr><td></td><td>Total</td>";
				$jmlttl =0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id=p.id_penduduk and p.id=k.id_pasien and k.waktu like ('$tgl[$i]%') $aksi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
				</table>	
				";
    }
    if (!empty($_GET['idPkw'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PERKAWINAN <br />
PERIODE: $startDate s . d $endDate</h2>";
        if ($_GET['idPkw'] != 'ss') {
            $aksi = "where id_perkawinan = '$_GET[idPkw]'";
            $axsi = "where dp.status_pernikahan = '$_GET[idPkw]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Status Perkawinan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select dinamis_penduduk.status_pernikahan as perkawinan from dinamis_penduduk $axsi  Group by  dinamis_penduduk.status_pernikahan");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[perkawinan]</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and k.waktu like ('$tgl[$i]%')"));
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }

    if (!empty($_GET['idPdd'])) {
        echo "<h2 align=center align=center>LAPORAN TAHUNAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PENDIDIKAN <br />
PERIODE: $startDate s . d $endDate</h2>";
        if ($_GET['idPdd'] != 'sp') {
            $aksi = "where id = '$_GET[idPdd]'";
            $axsi = "and dp.id_pendidikan_terakhir = '$_GET[idPdd]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Status Pendidikan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from pendidikan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and dp.id_pendidikan_terakhir = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }

    if (!empty($_GET['idPkj'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PEKERJAAN <br />
PERIODE: $startDate s . d $endDate</h2>";
        if ($_GET['idPkj'] != 'spk') {
            $aksi = "where id = '$_GET[idPkj]'";
            $axsi = "and dp.id_pekerjaan = '$_GET[idPkj]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Pekerjaan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from pekerjaan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";

            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pekerjaan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pekerjaan and pd.id = dp.id_penduduk and dp.id_pekerjaan = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
            }
            $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pekerjaan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pekerjaan and pd.id = dp.id_penduduk and dp.id_pekerjaan = '$row[id]' and k.waktu between '$awalan' and '$akhiran'"));
            echo "<td align=center>" . getValue($jml) . "</td>";
            echo "</tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pekerjaan p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pekerjaan and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }
//profesi
   if (!empty($idPrf)) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PPROFESI <br />
PERIODE: $startDate s . d $endDate</h2>";
        if ($idPrf != 'spk') {
            $aksi = "where id = '$idPrf'";
            $axsi = "and dp.id_profesi = '$idPrf'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>profesi</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from profesi $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";

            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and dp.id_profesi = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
            }
            $jml = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and dp.id_profesi = '$row[id]' and k.waktu between '$awalan' and '$akhiran'"));
            echo "<td align=center>" . getValue($jml) . "</td>";
            echo "</tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
        for ($i = 0; $i <= $selisih; $i++) {
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }

//
    if (!empty($_GET['idAgm'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN AGAMA <br />
PERIODE: $startDate s . d $endDate</h2>";
        if ($_GET['idAgm'] != 'sa') {
            $aksi = "where id = '$_GET[idAgm]'";
            $axsi = "and dp.id_agama = '$_GET[idAgm]'";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Agama</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from agama $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_agama and pd.id = dp.id_penduduk and dp.id_agama = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_agama and pd.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }

    if (!empty($_GET['idKel'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KELURAHAN <br />
PERIODE: $startDate s . d $endDate</h2>";
        if (!empty($_GET['idKel'])) {
            if ($_GET['idKel'] != 'all') {
                $aksi = "where id = '$_GET[idKel]'";
                $axsi = "and dp.id_kelurahan = '$_GET[idKel]'";
            }
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Kelurahan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from kelurahan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and dp.id_kelurahan = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
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
            $total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }

    if (!empty($_GET['idKec'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KECAMATAN <br />
PERIODE: $startDate s . d $endDate</h2>";
        if ($_GET['idKec'] != 'all') {
            $aksi = "where id = '$_GET[idKec]'";
            $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$_GET[idKec]')";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Kecamatan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from kecamatan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$row[id]') and k.waktu like ('$tgl[$i]%')"));
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
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }

    if (!empty($_GET['idKab'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN KABUPATEN <br />
PERIODE: $startDate s . d $endDate</h2>";
        if ($_GET['idKab'] != 'all') {
            $aksi = "where id = '$_GET[idKab]'";
            $axsi = " and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$_GET[idKab]'))";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Nama Kabupaten</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from kabupaten $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$row[id]')) and k.waktu like ('$tgl[$i]%')"));
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
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }
    if (!empty($_GET['idProp'])) {
        echo "<h2 align=center align=center>LAPORAN HARIAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PROVINSI <br />
PERIODE: $startDate s . d $endDate</h2>";
        if ($_GET['idProp'] != 'all') {
            $aksi = "where id = '$_GET[idProp]'";
            $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$_GET[idProp]')))";
        }
        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='150'>Nama Propinsi</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from provinsi $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>" . ucwords(strtolower($row['nama'])) . "</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps, bed b where  k.status='Masuk' and k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$row[id]'))) and k.waktu like ('$tgl[$i]%')"));
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
            $total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps, bed b where  k.status='Masuk' and k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }

    if (!empty($_GET['idKun'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN LAYANAN<br>
		PERIODE $startDate s . d $endDate </h2>";
        if ($_GET['idKun'] != 'st') {
            $aksi = "where k.id = '$_GET[idKun]'";
            $axsi = "and k.id_layanan = '$_GET[idKun]'";
        }

        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180'>Layanan</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select * from layanan $aksi");
        $no = 1;
        while ($row = mysql_fetch_array($sql)) {

            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_layanan = '$row[id]' and k.waktu like ('$tgl[$i]%')"));
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
            $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') $axsi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }

    if (!empty($_GET['idPem'])) {
        if ($_GET['idPem'] == 'charity') {
            echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN CHARITY<br>
		PERIODE $startDate s . d $endDate) </h2>";
            if ($_GET['idPem'] != 'spm') {
                $aksi = "";
            }
            echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180' align=center>Cara<br>Pembayaran</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

            $date = explode("/", $awal);
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
                $new = date("Y", $x);
                echo "<th class='nosort' style='text-align:center;'>$new</th>";
                $tgl[] = date("Y", $x);
            }
            echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
            $sql2 = mysql_query("select k.id from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.rencana_cara_bayar='Bayar Sendiri'");
            while ($data2 = mysql_fetch_array($sql2)) {
                $bs[] = $data2['id'];
            }
            if (isset($bs))
                $id_bs = implode(",", $bs);
            else
                $id_bs=0;

            $no = 1;
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>Charity</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') and k.id not in($id_bs)"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl+=$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
			";


            echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') and k.id not in($id_bs)"));
                echo "<td align=center>" . getValue($total) . "</td>";
				$jmlttl+=$total;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
		</table>
		";
        }else if ($_GET['idPem'] == 'bs') {
            echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN BIAYA SENDIRI<br>
		PERIODE: $startDate s . d $endDate</h2>";
            if ($_GET['idPem'] != 'spm') {
                $aksi = "";
            }
            echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180' align=center>Cara<br>Pembayaran</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN HARIAN</th></tr>";

            $date = explode("/", $awal);
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
                $new = date("Y", $x);
                echo "<th class='nosort' style='text-align:center;'>$new</th>";
                $tgl[] = date("Y", $x);
            }
            echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
            
            $sql2 = mysql_query("select k.id from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.rencana_cara_bayar='Charity'");
            while ($data2 = mysql_fetch_array($sql2)) {
                $charity[] = $data2['id'];
            }
            if (isset($charity))
                $id_charity = implode(",", $charity);
            else
                $id_charity=0;

            $no = 1;
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>Biaya Sendiri</td>";
			$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') and k.id not in($id_charity)"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl+=$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
			";


            echo "</tbody>
		<tr><td></td><td>Total</td>";
		$jmlttl =0;
            for ($i = 0; $i <= $selisih; $i++) {
                $total = mysql_num_rows(mysql_query("select * from kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.waktu like ('$tgl[$i]%') and k.id not in($id_charity)"));
                echo "<td align=center>" . getValue($total) . "</td>";
				$jmlttl+=$total;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
		</table>";
        }
    }
    if (!empty($_GET['tipePas'])) {
        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN TIPE PASIEN<br>
		PERIODE: $startDate s . d $endDate</h2>";

        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180'>Nama Tipe Pasien</th>
				
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TIAP TAHUN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $n += 1;
        }
        echo "<th>Total</th></tr><tbody>
				";
        if ($_GET['tipePas'] == 2)
            $aksi = " and k.no_kunjungan_pasien = 1";
        if ($_GET['tipePas'] == 1)
            $aksi = " and k.no_kunjungan_pasien > 1";
        if ($_GET['tipePas'] == 3)
            $aksi = "";
        if ($_GET['tipePas'] == 2) {
            echo "<tr>
                            <td align=center>1</td>
                            <td>Pasien Baru</td>
                            ";
            $date = explode("/", $awal);
            $tot = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
                $new = date("Y", $x);
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu like ('$new%') and k.no_kunjungan_pasien = 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $n += 1;
                $tot+=$jml;
            }
            echo "<td align=center>" . getValue($tot) . "</td>
                            </tr>";
        } else if ($_GET['tipePas'] == 1) {
            echo "<tr>
			<td align=center>1</td>
			<td>Pasien Lama</td>
			";
            $date = explode("/", $awal);
            $tot = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
                $new = date("Y", $x);
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu like ('$new%') and k.no_kunjungan_pasien > 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $n += 1;
                $tot+=$jml;
            }
            echo "<td align=center>" . getValue($tot) . "</td>
			</tr>";
        } else {
            echo "<tr>
                            <td align=center>1</td>
                            <td>Pasien Baru</td>
                            ";
            $date = explode("/", $awal);
            $tot = 0;
            $jmlh = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
                $new = date("Y", $x);
                $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu like ('$new%') and k.no_kunjungan_pasien = 1"));
                echo "<td align=center>" . getValue($jml) . "</td>";
                $n += 1;
                $jmlh+=$jml;
            }
            echo "<td align=center>" . getValue($jmlh) . "</td>
                            </tr>";
            $tot+=$jmlh;
            echo "<tr class='odd'>
                            <td align=center>2</td>
                            <td>Pasien Lama</td>
                            ";
            $date = explode("/", $awal);
            $jmlh = 0;
            for ($i = 0; $i <= $selisih; $i++) {
                $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
                $new = date("Y", $x);
                $jmlL = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu like ('$new%') and k.no_kunjungan_pasien > 1"));
                echo "<td align=center>" . getValue($jmlL) . "</td>";
                $n += 1;
                $jmlh+=$jmlL;
            }
            echo "<td align=center>" . getValue($jmlh) . "</td>
                            </tr>";
            $tot+=$jmlh;
        }
        echo "</tbody><tr>
			<td align=center></td>
			<td>Total</td>
			";
        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            $total = mysql_num_rows(mysql_query("select k.id_pasien, p.nama from kunjungan k,pasien ps ,penduduk p, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu like ('$new%') $aksi"));

            echo "<td align=center>" . getValue($total) . "</td>";
            $n += 1;
        }
        echo "<td align=center>" . getValue($tot) . "</td>
			</tr>";

        echo "</table>";
    }
    if (!empty($_GET['idPerujuk'])) {

        echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN LAYANAN<br>
		PERIODE $startDate s . d $endDate</h2>";
        if ($_GET['perujuk'] <> '') {
            if ($_GET['idPerujuk'] != 'all') {
                $aksi = "and r.id_instansi_relasi = '$_GET[idPerujuk]'";
            }
        }

        echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel' style='overflow: auto;width: 100%;display: block'>
		
			<tr>
				<th rowspan='2' width='20'>No</th>
				<th rowspan='2' width='180'>Nama Rujukan</th>
				<th rowspan='2' width='180'>Nama Nakes</th>
				<th class='nosort' style='text-align:center;' colspan='" . ($selisih + 2) . "'>BANYAK KUNJUNGAN TAHUNAN</th></tr>";

        $date = explode("/", $awal);
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            echo "<th class='nosort' style='text-align:center;'>$new</th>";
            $tgl[] = date("Y", $x);
        }
        echo "<th style='text-align:center;'>Total</th></tr><tbody>
				";
        $sql = mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan, count(i.id) as jumlah from instansi_relasi i, rujukan r, penduduk p,
		kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and k.id_rujukan = r.id $aksi group by i.id");

        $no = 1;
        while ($row = mysql_fetch_array($sql)) {
            
            echo "<tr class='";
            if ($no % 2 == 1)
                echo "odd"; else
                echo "even"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama_ins]</td>
                        <td>$row[nama]</td>";
            $jmlttl=0;
            for ($i = 0; $i <= $selisih; $i++) {
                $jml = mysql_num_rows(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan from instansi_relasi i, rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and k.id_rujukan = r.id and i.id = '$row[id_ins]' and k.waktu like ('$tgl[$i]%')"));
                echo "<td align=center>" . getValue($jml) . "</td>";
				$jmlttl+=$jml;
            }
            echo "<td align=center>" . getValue($jmlttl) . "</td>";
            echo "</tr>
			";
            $no += 1;
        }

        echo "</tbody>
		<tr><td></td><td colspan='2'>Total</td>
		";
        $date = explode("/", $awal);
		$jmlttl =0;
        for ($i = 0; $i <= $selisih; $i++) {
            $x = mktime(0, 0, 0, date($date[0]), date($date[1]), date($date[2]) + $i);
            $new = date("Y", $x);
            $total = mysql_num_rows(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama, k.id_rujukan from instansi_relasi i, rujukan r, penduduk p, kunjungan k, bed b where k.status='Masuk' and  k.id_bed = b.id and b.id_kelas = 1 and i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and k.id_rujukan = r.id and k.waktu like ('$tgl[$i]%') $aksi"));
            echo "<td align=center>" . getValue($total) . "</td>";
			$jmlttl+=$total;
        }
        echo "<td align=center>" . getValue($jmlttl) . "</td>";
        echo "</tr>
		</table>";
    }
}
echo "<script type='text/javascript' src='" . app_base_url('assets/js/sorter/script.js') . "'></script>
	<script type='text/javascript'>
  var sorter = new TINY.table.sorter('sorter');
	sorter.head = 'head';
	sorter.asc = 'asc';
	sorter.desc = 'desc';
	sorter.even = 'evenrow';
	sorter.odd = 'oddrow';
	sorter.evensel = 'evenselected';
	sorter.oddsel = 'oddselected';
	sorter.paginate = true;
	sorter.currentid = 'currentpage';
	sorter.limitid = 'pagelimit';
	sorter.init('table',0);
  </script></div>";
  
if (empty($_GET['cetak'])) {
?>
    <br><span class=cetak onclick="window.open('<?= app_base_url('admisi/informasi/per-pivot-report_popup?cetak=1') . "&" . generate_get_parameter($_GET) ?>','popup','width=1000','height=650')">Cetak</span>
    <a class="excel" href="<?= app_base_url('admisi/informasi/excel/per-pivot-report?cetak=1') . "&" . generate_get_parameter($_GET) ?>">Cetak</a>

<?
}
?>
<!--
Contoh tabel source untuk grafik
<table cellspacing="0" cellpadding="0" border="0" class="tabel" id="table" style="display: none;">
	<tbody>
		<tr>
			<th style="width: 150px;">Jenis Kelamin</th>
			<th style="text-align:center;" class="nosort">21 Jul</th>
			<th style="text-align:center;" class="nosort">22 Jul</th>
			<th style="text-align:center;">total</th>
		</tr>
		<tr>
			<td>Laki-laki</td>
			<td align="center">2</td>
			<td align="center">3</td>
			<td align="center">5</td>
		</tr>
		<tr class="#F4F4F4">
			<td>Perempuan</td>
			<td align="center">4</td>
			<td align="center">2</td>
			<td align="center">6</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td></td>
			<td>Total</td>
			<td align="center">6</td>
			<td align="center">5</td>
			<td align="center">11</td>
		</tr> 
	</tbody>
</table> -->
<script type="text/javascript">
        $(document).ready(
                function(){         
                    $("#table1").html($("#table").html()); 
                    
                   var didasarkan=$("#table1 tr:first").children().eq(1);
                   $("#table1 tr").eq(1).prepend("<th>"+didasarkan.html()+"</th>");
                   $("#table1 tr:first").remove();
                   for(var i=1;i<$("#table1 tr").length-1;i++){
                      $("#table1 tr").eq(i).children().first().remove();
                   }
                   $("#table1").children().eq(1).remove();
                   /*
                   $('#table1').convertToFusionCharts(
                    {
                            swfPath: "<?= app_base_url('/assets/js/Charts')?>",
                            type: "MSColumn2D",
                            data: "#table1",
                            dataFormat: "HTMLTable",
                            dataOptions: {
                                    major: "row",
                                    useLegend: true,
                                    labelSourceIndex: 2
                            }
                    });
					*/
                }
            );
            
	
</script>