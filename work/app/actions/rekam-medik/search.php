<?php

require_once 'app/config/db.php';
include_once "app/lib/common/functions.php";
set_time_zone();

if (isset($_GET['q'])) {
    $q = strtolower($_GET['q']);
    if ($_GET['opsi'] == 'nama') {
            $sql = mysql_query("select max(p.id) as max_id_pelayanan, 
						p.id,
						pd.nama as pasien,
						substr(p.waktu, 1,10) as waktu,
						p.jenis,
						ps.id as norm,
						b.nama as bed,
						kels.nama as kelas,
						ins.nama as instalasi,
						pd2.nama as dokter,
						concat_ws('/',substr(pd.tanggal_lahir, 9, 2),
						substr(pd.tanggal_lahir, 6, 2), 
						substr(pd.tanggal_lahir, 1,4)) as tanggal_lahir,
						ag.nama as agama,
						pkj.nama as pekerjaan,
						dp.alamat_jalan,
						kel.nama as kelurahan 
					from penduduk pd
					 left join pasien ps on (ps.id_penduduk = pd.id)
					  left join pelayanan p on (p.id_pasien = ps.id)
					left join penduduk pd2 on (p.id_dokter = pd2.id)
                    left join dinamis_penduduk dp on (pd.id = dp.id_penduduk)
                    left join agama ag on (dp.id_agama = ag.id)
                    left join pekerjaan pkj on (dp.id_pekerjaan = pkj.id)
                    left join kelurahan kel on (dp.id_kelurahan = kel.id)
                    left join bed b on (p.id_bed = b.id)
					left join instalasi ins on (b.id_instalasi = ins.id)
					left join kelas kels on (b.id_kelas = kels.id)
                    where locate('$q', pd.nama) > 0 and dp.akhir = '1' 
					order by locate('$q', pd.nama) LIMIT 5");
         $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
			if ($data->pasien != NULL)
			$hasil[] = $data;
        }
        die(json_encode($hasil));
	//	echo $sql;
     
    } else if ($_GET['opsi'] == 'noRm') {
            if(isset($_GET['mode'])){
                if($_GET['mode']=='fix'){
                $where= "and ps.id=$q LIMIT 1";
                }
            }else{
                $where="
					and locate('$q', ps.id) > 0 and dp.akhir = '1' order by locate('$q', ps.id)";
            }
            $sql = mysql_query("select 
					max(p.id) as max_id_pelayanan,
					p.id,
					pd.nama as pasien,
					substr(p.waktu, 1,10) as waktu,
					p.jenis,
					ps.id as norm,
					pd2.nama as dokter,
					b.nama as bed,
					kels.nama as kelas,
					ins.nama as instalasi,
					pd2.nama as dokter,
					concat_ws('/',substr(pd.tanggal_lahir, 9, 2),
					substr(pd.tanggal_lahir, 6, 2), 
					substr(pd.tanggal_lahir, 1,4)) as tanggal_lahir,
					ag.nama as agama,
					pkj.nama as pekerjaan,
					dp.alamat_jalan,
					kel.nama as kelurahan from pelayanan p
                    join pasien ps on p.id_pasien = ps.id
                    join penduduk pd on ps.id_penduduk = pd.id
                    join penduduk pd2 on p.id_dokter = pd2.id
                    join dinamis_penduduk dp on pd.id = dp.id_penduduk
                    left join agama ag on dp.id_agama = ag.id
                    left join pekerjaan pkj on dp.id_pekerjaan = pkj.id
                    left join kelurahan kel on dp.id_kelurahan = kel.id
                    join bed b on p.id_bed = b.id
					join instalasi ins on b.id_instalasi = ins.id
					join kelas kels on b.id_kelas = kels.id
                    where p.id = (select max(pel.id) from pelayanan pel where pel.id_pasien=ps.id) $where");
					  $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
			if ($data->norm != NULL)
			$hasil[] = $data;
        }
       // $exe = _select_arr($sql);
        die(json_encode($hasil));
    }
    else if ($_GET['opsi'] == 'namaicd10') {
        $sql = "select * from icd_10 where nama like ('%$q%') order by locate('$q', nama)";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    }else if ($_GET['opsi'] == 'kodeicd10') {
        $sql = "select * from icd_10 where kode like ('%$q%') order by locate('$q', kode)";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    }
    else if ($_GET['opsi'] == 'namaicd9') {
        $sql = "select * from icd_9 where nama like ('%$q%') order by locate('$q', nama)";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'kodeicd9') {
        $sql = "select * from icd_9 where kode like ('%$q%') order by locate('$q', kode)";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if($_GET["opsi"]=="instalasi_inap"){
		$return = _select_arr("select distinct(ins.id) as id,ins.nama as nama from instalasi ins
			join bed b on ins.id=b.id_instalasi where b.jenis in('Rawat Inap','Semua')
		");
		die(json_encode($return));
	}
}
exit;