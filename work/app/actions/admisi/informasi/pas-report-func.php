<?php

function perkawinan_get_for_selection()
{
    $perkawinan = array();
    $sql = mysql_query("select * from perkawinan");
    while ($row = mysql_fetch_array($sql)) {
        $perkawinan[$row['id_perkawinan']] = $row['perkawinan'];
    }

    return $perkawinan;
}
function pendidikan_get_for_selection()
{
    $pendidikan = array();
    $sql = mysql_query("select * from pendidikan");
    while ($row = mysql_fetch_array($sql)) {
        $pendidikan[$row['id']] = $row['nama'];
    }

    return $pendidikan;
}
function profesi_get_for_selection()
{
    $profesi = array();
    $sql = mysql_query("select * from profesi");
    while ($row = mysql_fetch_array($sql)) {
        $profesi[$row['id']] = $row['nama'];
    }

    return $profesi;
}
function agama_get_for_selection()
{
    $agama = array();
    $sql = mysql_query("select * from agama");
    while ($row = mysql_fetch_array($sql)) {
        $agama[$row['id']] = $row['nama'];
    }

    return $agama;
}
function instalasi_get_for_selection()
{
    $instalasi = array();
    $sql = mysql_query("select * from instalasi");
    while ($row = mysql_fetch_array($sql)) {
        $instalasi[$row['id']] = $row['nama'];
    }

    return $instalasi;
}

function admisi_check_report_params($params) {
    $map_komponen = array(
        1 => array('noRm'),
        2 => array('idNama'),
        3 => array('umur1', 'umur2'),
        5 => array('jeKel'),
        6 => array('idPkw'),
        7 => array('idPdd'),
        8 => array('idPkj'),
        9 => array('idAgm'),
        11 => array('idKel'),
        15 => array(),
        16 => array('idKun'),
        17 => array('idPem'),
        21 => array('nikp'),
        22 => array('niko'),
    );

    return array_contains_all_field($params, array('awal', 'akhir', 'idLap', 'variabel'))
            && array_contains_either_field($params, $map_komponen[$params['idLap']]);
}
function admisi_get_report_columns_map()
{
    return array(
        'p.id'=> array( 'alias' => 'noRm', 'label' => 'No. RM'),
        'pd.nama' => array('alias' => 'nama', 'label' => 'Nama'),
        'pd.umur' => array('alias' => 'umur', 'label' => 'Umur'),
        'pd.jenis_kelamin' => array('alias' => 'jeKel', 'label' => 'Jenis Kelamin'),
        'kw.perkawinan'=> array( 'alias' => 'stskw', 'label' => 'Status Perkawinan'),
        'pdd.nama'=> array( 'alias' => 'pdd', 'label' => 'Pendidikan'),
        'pr.nama'=> array( 'alias' => 'profesi', 'label' => 'Profesi'),
        'a.nama'=> array( 'alias' => 'agama', 'label' => 'Agama'),
        'dp.alamat_jalan'=> array( 'alias' => 'almtJln', 'label' => 'Alamat Jalan'),
        'pnj.nama'=> array( 'alias' => 'pngJwb', 'label' => 'Penanggung Jwb'),
        'pg.id'=> array( 'alias' => 'nik', 'label' => 'No. Karyawan'),
        'pd.tanggal_lahir'=> array( 'alias' => 'tglLahir', 'label' => 'Tgl Lahir'),
    );
}
function admisi_fetch_report($params)
{
    $map_kolom = admisi_get_report_columns_map();

    $hsl = array();
    foreach ($params['variabel'] as $var) {
        $hsl[$var] = $var . ' as ' .$map_kolom[$var]['alias'];
    }
    $kolom = implode(",",$hsl);

    if ($params['idLap'] == 1) {
        $by = "NO. REKAM MEDIK";
        $kunci = "WHERE p.id = $params[noRm]";
    }
    if ($params['idLap'] == 2) {
        $by = "NAMA";
        $kunci = "WHERE pd.id = $params[idNama]";
    }
    if ($params['idLap'] == 3) {
        $by = "UMUR";
        if (empty($params['umur1']) and !empty($params['umur2'])) {
            $kunci = "WHERE pd.umur = '$params[umur2]'";
        }
        else if (!empty($params['umur1']) and empty($params['umur2'])) {
            $kunci = "WHERE pd.umur = '$params[umur1]'";
        }
        else if (!empty($params['umur1']) and !empty($params['umur2'])) {
            if ($params['umur1'] < $params['umur2']) {
                $kunci = "WHERE pd.umur between $params[umur1] and $params[umur2] order by pd.umur ASC";
            } else {
                $kunci = "WHERE pd.umur between $params[umur1] and $params[umur2] order by pd.umur DESC";
            }
        }
    }
    if ($params['idLap'] == 5) {
        $by = "JENIS KELAMIN";
		if ($_GET['jeKel'] <> 'LP') {
        	$kunci = "WHERE pd.jenis_kelamin = '$params[jeKel]'";
		} else {
			$kunci = "where pd.jenis_kelamin in ('L','P')";
		}
    }
    if ($params['idLap'] == 6) {
        $by = "STATUS PERKAWINAN";
		if ($_GET['idPkw'] <> 'ss') {
        	$kunci = "WHERE dp.status_pernikahan = '$params[idPkw]'";
		} else {
			$kunci = "WHERE dp.status_pernikahan in (select id_perkawinan from perkawinan)";
		}
    }
    if ($params['idLap'] == 7) {
        $by = "PENDIDIKAN TERAKHIR";
		if ($_GET['idPdd'] <> 'sp') {
        	$kunci = "WHERE dp.id_pendidikan_terakhir = '$params[idPdd]'";
		} else {
			$kunci = "WHERE dp.id_pendidikan_terakhir in (select id from pendidikan)";
		}
    }
    if ($params['idLap'] == 8) {
        $by = "PROFESI";
		if ($_GET['idPkj'] <> 'spk') {
        	$kunci = "WHERE dp.id_profesi = '$params[idPkj]'";
		} else {
			$kunci = "WHERE dp.id_profesi in (select id from profesi)";
		}
    }
    if ($params['idLap'] == 9) {
        $by = "AGAMA";
		if ($_GET['idAgm'] <> 'spk') {
    	    $kunci = "WHERE dp.id_agama = '$params[idAgm]'";
		} else {
			$kunci = "WHERE dp.id_agama in (select id from agama)";
		}
    }
    if ($params['idLap'] == 11) {
        $by = "KELURAHAN";
        $kunci = "WHERE dp.id_kelurahan = '$params[idKel]'";
    }
    if ($params['idLap'] == 16) {
        $by = "TUJUAN KUNJUNGAN";
        $kunci = "WHERE k.id_instalasi_tujuan = '$params[idKun]'";
    }
    if ($params['idLap'] == 21) {
        $by = "NOMOR INDUK PEGAWAI";
        $kunci = "WHERE pg.id = '$params[nikp]'";
    }
    if ($params['idLap'] == 22) {
        $by = "NOMOR INDUK PEGAWAI";
        $kunci = "WHERE pg.id = '$params[niko]'";
    }
	if ($kunci <> '') {
		$time = " and k.waktu between '".date2mysql($_GET[awal])."' and '".date2mysql($_GET[akhir])."'";
	}
    $sql = "SELECT $kolom
    FROM penduduk pd
    JOIN pasien p ON ( p.id_penduduk = pd.id )
    LEFT JOIN dinamis_penduduk dp ON ( dp.id_penduduk = pd.id )
    LEFT JOIN perkawinan kw ON ( dp.status_pernikahan = kw.id_perkawinan )
    LEFT JOIN pendidikan pdd ON ( pdd.id = dp.id_pendidikan_terakhir )
    LEFT JOIN agama a ON ( a.id = dp.id_agama )
    LEFT JOIN kepegawaian pg ON ( pg.id_penduduk = pd.id )
    LEFT JOIN profesi pr ON ( pr.id = dp.id_profesi )
    LEFT JOIN kunjungan k ON ( k.id_pasien = p.id )
    left join penduduk pnj on (k.id_penduduk_penanggungjawab = pnj.id)
    $kunci $time";
	
	//echo $sql; die;
    $query = mysql_query($sql);

    $report_result = array();
    while ($row = mysql_fetch_array($query)) {
        $report_result[] = $row;
    }

    return array(
        'title' => array(
            'berdasar' => $by,
            'awal' => $params['awal'],
            'akhir' => $params['akhir']),
        'columns' => array_keys($hsl),
        'data' => $report_result
    );
}

function array_contains_all_field(array $arr, array $fields)
{
    $satisfied = true;
    foreach ($fields as $field) {
        $satisfied = !empty($arr[$field]) && $satisfied;
    }

    return $satisfied;
}
function array_contains_either_field(array $arr, array $fields)
{
    if (empty($fields)) return true;

    $satisfied = false;
    foreach ($fields as $field) {
        $satisfied = !empty($arr[$field]) || $satisfied;
    }

    return $satisfied;
}