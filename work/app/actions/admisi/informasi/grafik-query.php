<?php

function reform($date)
{
    $date_reform = explode("/", $date);
    return "$date_reform[2]-$date_reform[1]-$date_reform[0]";
}

$no        = 1;
$jenis     = isset($_GET['jenis_laporan']) ? $_GET['jenis_laporan'] : null;
$submit    = isset($_GET['submit_jenis']) ? $_GET['submit_jenis'] : null;
$kecamatan = isset($_GET['kec']) ? $_GET['kec'] : null;
$awal      = isset($_GET['awal']) ? $_GET['awal'] : null;
$akhir     = isset($_GET['akhir']) ? $_GET['akhir'] : null;
$periode   = isset($_GET['periode']) ? $_GET['periode'] : null;
$tahun1    = isset($_GET['thawal']) ? $_GET['thawal'] : null;
$tahun2    = isset($_GET['thakhir']) ? $_GET['thakhir'] : null;
$bulan1    = isset($_GET['bln1']) ? $_GET['bln1'] : null;
$bulan2    = isset($_GET['bln2']) ? $_GET['bln2'] : null;

$first     = indo_tgl($awal, "/");
$end       = indo_tgl($akhir, "/");
$awal      = reform($awal);
$akhir     = reform($akhir);
if ($awal == $akhir)
	$time = "AND k.waktu LIKE '%$awal%'";
else
	$time = "AND date(k.waktu) >= '$awal' AND date(k.waktu) <= '$akhir'";

if ($jenis == 1)
    $teks = "Pekerjaan";
else if ($jenis == 2)
    $teks = "Pendidikan";
else if ($jenis == 3)
    $teks = "Agama";
else if ($jenis == 4)
    $teks = "Wilayah/Kecamatan";
else if ($jenis == 5)
    $teks = "Golongan Darah";

$data      = "<h3><b>Grafik Demografi Kunjungan Pasien Berdasarkan $teks $first Sampai $end</b></h3>
            <fieldset>
               <table id=\"grafik\" class=\"tabel\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
$jumlah	   = 0;

if ($jenis == 1) {
    $data           .= '<tr><th style="width: 85%;">Pekerjaan</th><th>Jumlah (orang)</th></tr>';
    $query_pekerjaan = mysql_query("SELECT * FROM pekerjaan");
    while ($data_pekerjaan = mysql_fetch_array($query_pekerjaan)) {
        $jumlah_query = mysql_query("SELECT COUNT(*) AS jumlah
                                    FROM
                                        dinamis_penduduk d,
                                        pasien p,
										kunjungan k
                                    WHERE
                                        d.id_penduduk = p.id_penduduk
                                        AND
                                        d.id_pekerjaan = $data_pekerjaan[id]
                                        AND p.id = k.id_pasien
                                        $time
                                ") or die(mysql_error());
        while ($data_jumlah = mysql_fetch_array($jumlah_query)) {
            $class = ($no % 2 == 0) ? "even" : "odd";
            $data .= "<tr class=\"" . $class . "\"><td>$data_pekerjaan[nama]</td><td>$data_jumlah[jumlah]</td></tr>";
            $no++;
			$jumlah = $jumlah + $data_jumlah['jumlah'];
        }
    }
} else if ($jenis == 2) {
    $data            .= "<tr><th style=\"width: 85%;\">Pendidikan</th><th>Jumlah (orang)</th></tr>";
    $query_pendidikan = mysql_query("SELECT * FROM pendidikan");
    while ($data_pendidikan = mysql_fetch_array($query_pendidikan)) {
        $jumlah_query = mysql_query("SELECT COUNT(*) AS jumlah
                                    FROM
                                        dinamis_penduduk d,
                                        pasien p,
										kunjungan k
                                    WHERE
                                        d.id_penduduk = p.id_penduduk
                                        AND
                                        d.id_pendidikan_terakhir = $data_pendidikan[id]
                                        AND p.id = k.id_pasien
                                        $time
                                ");
        while ($data_jumlah = mysql_fetch_array($jumlah_query)) {
            $class = ($no % 2 == 0) ? "even" : "odd";
            $data .= "<tr class=\"" . $class . "\"><td>$data_pendidikan[nama]</td><td>$data_jumlah[jumlah]</td></tr>";
            $no ++;
			$jumlah = $jumlah + $data_jumlah['jumlah'];
        }
    }

} else if ($jenis == 3) {
  //  if ($bulan == 'Januari')
    $data       .= "<tr><th style=\"width: 85%;\">Agama</th><th>Jumlah (orang)</th></tr>";
    $query_agama = mysql_query("SELECT * FROM agama");
    while ($data_agama = mysql_fetch_array($query_agama)) {
        $jumlah_query = mysql_query("SELECT COUNT(*) AS jumlah
                                    FROM
                                        dinamis_penduduk d,
                                        pasien p,
										kunjungan k
                                    WHERE
                                        d.id_penduduk = p.id_penduduk
                                        AND
                                        d.id_agama = $data_agama[id]
                                        AND p.id = k.id_pasien
                                        $time
                                ");
        while ($data_jumlah = mysql_fetch_array($jumlah_query)) {
            $class = ($no % 2 == 0) ? "even" : "odd";
            $data .= "<tr class=\"" . $class . "\"><td>$data_agama[nama]</td><td>$data_jumlah[jumlah]</td></tr>";
            $no ++;
			$jumlah = $jumlah + $data_jumlah['jumlah'];
        }
    }

} else if ($jenis == 4) {
    $data            .= "<tr><th style=\"width: 85%;\">Kelurahan</th><th>Jumlah (orang)</th></tr>";
    $query_kelurahan  = mysql_query("SELECT * FROM kelurahan WHERE id_kecamatan = $kecamatan");
    while ($data_kelurahan = mysql_fetch_array($query_kelurahan)) {
        $jumlah_query = mysql_query("SELECT COUNT(*) AS jumlah
                                    FROM
                                        dinamis_penduduk d,
                                        pasien p,
										kunjungan k
                                    WHERE
                                        d.id_penduduk = p.id_penduduk
                                        AND
                                        d.id_kelurahan = $data_kelurahan[id]
                                        AND p.id = k.id_pasien
                                        $time
                                ");
        while ($data_jumlah = mysql_fetch_array($jumlah_query)) {
            $class = ($no % 2 == 0) ? "even" : "odd";
            $data .= "<tr class=\"" . $class . "\"><td>$data_kelurahan[nama]</td><td>$data_jumlah[jumlah]</td></tr>";
            $no ++;
			$jumlah = $jumlah + $data_jumlah['jumlah'];
        }
    }

} else if ($jenis == 5) {
    $data            .= "<tr><th style=\"width: 85%;\">Golongan Darah</th><th>Jumlah (orang)</th></tr>";
    for ($i = 1; $i <= 4; $i++)
    {
        if ($i == 1) $darah = 'A';
        else if ($i == 2) $darah = 'B';
        else if ($i == 3) $darah = 'O';
        else $darah = 'AB';
        $jumlah_query = mysql_query("SELECT COUNT(*) AS jumlah
                                    FROM
                                        penduduk d,
                                        pasien p,
										kunjungan k
                                    WHERE
                                        d.id = p.id_penduduk
                                        AND
                                        d.gol_darah = '$darah'
                                        AND p.id = k.id_pasien
                                        $time
                                ");
		while ($data_jumlah = mysql_fetch_array($jumlah_query)) {
            $class = ($no % 2 == 0) ? "even" : "odd";
            $data .= "<tr class=\"" . $class . "\"><td>$darah</td><td>$data_jumlah[jumlah]</td></tr>";
            $no ++;
			$jumlah = $jumlah + $data_jumlah['jumlah'];
        }
    }
}
/*
  if ($grafik == 1)
  $chart	= "Bar2D";
  else if ($grafik == 2)
  $chart	= "Column2D";
  else if ($grafik == 3)
  $chart	= "Column3D";
  else if ($grafik == 4)
  $chart	= "Doughnut2D";
  else if ($grafik == 5)
  $chart	= "Funnel";
  else if ($grafik == 6)
  $chart	= "MSBar2D";
  else if ($grafik == 7)
  $chart	= "MSColumn2D";
  else if ($grafik == 8)
  $chart	= "MSColumn3D";
  else if ($grafik == 9)
  $chart	= "Pie2D";
  else if ($grafik == 10)
  $chart	= "Pie3D";
  else if ($grafik == 11)
  $chart	= "StackedBar2D";
  else if ($grafik == 12)
  $chart	= "StackedColumn2D";
  else if ($grafik == 13)
  $chart	= "StackedColumn3D";
 */

$data .= "	</table>
			</fieldset>";
if ($jumlah != 0)
{
	$data .= "<script type=\"text/javascript\">
				$('#grafik').convertToFusionCharts(
				{
					swfPath: \"" . app_base_url('/assets/js/Charts') . "\",
					type: \"MSColumn2D\",
					data: \"#grafik\",
					dataFormat: \"HTMLTable\"
				});
			</script>";
}
echo $data;
exit;
?>

