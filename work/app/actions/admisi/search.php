    <?php

require_once 'app/config/db.php';
include_once "app/lib/common/master-data.php";
include_once "app/lib/common/functions.php";
//require_once 'app/lib/nusoap/nusoap.php';
if (isset($_GET['q'])) {
    $q = strtolower($_GET['q']);
    if ($_GET['opsi'] == "sales") {
        $sql = mysql_query("select s.*,u.id as idne from sales s
					join users u on(u.id=s.id) 
					left join role r on(u.id_role=r.id_role)
                    where s.nama like '%$q%'");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } 
	  if ($_GET['opsi'] == "pengirim") {
        $sql = mysql_query("select pd.nama as nama,dp.id_penduduk as idPen,k.id as id ,kl.nama as kelurahan,kc.nama as kecamatan,kb.nama as kabupaten from kunjungan k
		left join penduduk pd on (k.id_penduduk_pengantar=pd.id)
		 left join dinamis_penduduk dp on (dp.id_penduduk=pd.id and dp.akhir='1')
            left join kelurahan kl on (dp.id_kelurahan=kl.id)
            left join kecamatan kc on (kl.id_kecamatan=kc.id)
            left join kabupaten kb on (kc.id_kabupaten=kb.id)
		where pd.nama like '%$q%' LIMIT 5
            ");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } 
	else if ($_GET['opsi'] == 'kepesertaan_asuransi') {
        $sql = mysql_query("select k.id as id_kunjungan,pd.nama as penduduk,dp.alamat_jalan,kel.nama as kelurahan from kunjungan k 
                left join pasien ps on k.id_pasien = ps.id
                left join penduduk pd on ps.id_penduduk = pd.id
                left join dinamis_penduduk dp on dp.id_penduduk = pd.id
                left join kelurahan kel on dp.id_kelurahan = kel.id
                where pd.nama like '%$q%'");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'penduduk') {
        $sql = mysql_query("SELECT
                        p.*,
                        dp.id_kelurahan,
                        dp.alamat_jalan,
                        dp.no_telp,
                dp.id_pendidikan_terakhir,
                dp.id_profesi,
                dp.id_agama,
                dp.status_pernikahan,
                concat_ws('/',substr(p.tanggal_lahir, 9, 2),
                substr(p.tanggal_lahir, 6, 2),
                substr(p.tanggal_lahir, 1,4)) as tanggal_lahir,
                k.nama as nama_kel,
                po.nama_posisi
                FROM
                penduduk p left join dinamis_penduduk dp
                on (p.id = dp.id_penduduk)
                left join kelurahan k on (k.id = dp.id_kelurahan)
		  left join posisi po on (po.id_posisi = p.posisi_di_keluarga) where locate('$q',p.nama) >0 order by locate ('$q',p.nama) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'calon_pegawai') {
        $sql = mysql_query("SELECT
                        p.*,
                        dp.id_kelurahan,
                        dp.alamat_jalan,
                        dp.no_telp,
                dp.id_pendidikan_terakhir,
                dp.id_profesi,
                dp.id_agama,
                dp.status_pernikahan,
                concat_ws('/',substr(p.tanggal_lahir, 9, 2),
                substr(p.tanggal_lahir, 6, 2),
                substr(p.tanggal_lahir, 1,4)) as tanggal_lahir,
                k.nama as nama_kel
		  FROM
		  penduduk p left join dinamis_penduduk dp
		  on (p.id = dp.id_penduduk)
                left join kelurahan k on (k.id = dp.id_kelurahan)
		  where p.id not in (select id from pegawai) and locate('$q',p.nama) >0 order by locate ('$q',p.nama) LIMIT 10");
        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "noRm") {
        $sql = mysql_query("select ps.id as id_pasien,ag.nama as agama, p.id,pkj.nama as pekerjaan, p.nama as nama_pas, p.jenis_kelamin, p.gol_darah, dp.*, kl.nama as nama_kelurahan, pr.id as id_pro, pr.nama as nama_pro, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, dp.id_agama,concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir from penduduk p
	left join pasien ps on (p.id = ps.id_penduduk) 
	left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
	left join kelurahan kl on(dp.id_kelurahan = kl.id)
	left join profesi pr on(pr.id = dp.id_profesi)
        left join pekerjaan pkj on (pkj.id = dp.id_pekerjaan)        
        left join agama ag on(ag.id = dp.id_agama)    
	where locate('$q', ps.id) > 0 and dp.akhir = '1' order by locate('$q', ps.id) LIMIT 10");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if($_GET['opsi'] == "pasien_rm"){
        $sql = mysql_query("select ps.id as id_pasien,ag.nama as agama, p.id,pkj.nama as pekerjaan, p.nama as nama_pas, p.jenis_kelamin, p.gol_darah, dp.*, kl.nama as nama_kelurahan, pr.id as id_pro, pr.nama as nama_pro, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, dp.id_agama,concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir from penduduk p
	join pasien ps on (p.id = ps.id_penduduk) 
	left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
	left join kelurahan kl on(dp.id_kelurahan = kl.id)
	left join profesi pr on(pr.id = dp.id_profesi)
        left join pekerjaan pkj on (pkj.id = dp.id_pekerjaan)        
        left join agama ag on(ag.id = dp.id_agama)    
	where locate('$q', p.nama) > 0 and dp.akhir = '1' order by locate('$q', p.nama) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    }else if ($_GET['opsi'] == "nama") {
        $sql = mysql_query("select
                ps.id as id_pasien,
                p.id as id_penduduk,
                p.nama as nama_pas,
				p.no_identitas as no_identitas,
                p.jenis_kelamin,
                p.gol_darah, dp.*,
                kl.nama as nama_kelurahan,
				kl.id as id_kelurahan,
				kl.kode as kode_kelurahan,
				kc.nama as nama_kecamatan,
				kc.id as id_kecamatan,
				kc.kode as kode_kecamatan,
				kb.nama as nama_kabupaten,
				kb.id as id_kabupaten,
				kb.kode as kode_kabupaten,
                pr.id as id_pro,
                pr.nama as nama_pro,
                dp.alamat_jalan,
                dp.status_pernikahan,
                dp.id_pendidikan_terakhir,
                dp.id_agama,
           concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir from penduduk p
        left join pasien ps on (p.id = ps.id_penduduk)
		left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
		left join kelurahan kl on(dp.id_kelurahan = kl.id)
		left join kecamatan kc on(kl.id_kecamatan = kc.id)
		left join kabupaten kb on(kc.id_kabupaten = kb.id)
		left join profesi pr on(pr.id = dp.id_profesi)
        left join agama ag on(ag.id = dp.id_agama)
	where locate('$q', p.nama) > 0 and dp.akhir = '1' order by locate('$q', p.nama) LIMIT 10");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    }else if ($_GET['opsi'] == "nik") {
        $sql = mysql_query("select
                ps.id as id_pasien,
                p.id as id_penduduk,
                p.no_identitas as no_identitas,
                p.nama as nama_pas,
                p.jenis_kelamin,
                p.gol_darah, dp.*,
                kl.nama as nama_kelurahan,
                kl.id as id_kelurahan,
				kl.kode as kode_kelurahan,
				kc.nama as nama_kecamatan,
				kc.id as id_kecamatan,
				kc.kode as kode_kecamatan,
				kb.nama as nama_kabupaten,
				kb.id as id_kabupaten,
				kb.kode as kode_kabupaten,
                pr.id as id_pro,
                pr.nama as nama_pro,
                dp.alamat_jalan,
                dp.status_pernikahan,
                dp.id_pendidikan_terakhir,
                dp.id_agama,
           concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir from penduduk p
        left join pasien ps on (p.id = ps.id_penduduk)
		left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
		left join kelurahan kl on(dp.id_kelurahan = kl.id)
		left join kecamatan kc on(kl.id_kecamatan = kc.id)
		left join kabupaten kb on(kc.id_kabupaten = kb.id)
		left join profesi pr on(pr.id = dp.id_profesi)
        left join agama ag on(ag.id = dp.id_agama)
	where locate('$q', p.no_identitas) > 0 and dp.akhir = '1' order by locate('$q', p.no_identitas) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    }else if($_GET['opsi'] == 'pegawai_dokter_nik'){
	$sql = "select 
		p.id as id_penduduk,
		p.no_identitas as no_identitas,
		p.sip,
		p.nama as nama_dok,
		p.jenis_kelamin,
		dp.alamat_jalan,
		kel.nama as nama_kelurahan,
		kel.id as id_kelurahan,
		dp.id_agama,
		peg.id_level,
		peg.id_unit
		from 
		penduduk p join dinamis_penduduk dp on p.id=dp.id_penduduk 
		left join pegawai peg on p.id = peg.id
                left join profesi pr on dp.id_profesi = pr.id
		join kelurahan kel on dp.id_kelurahan=kel.id
		where locate('$q', p.no_identitas) > 0 and dp.akhir = '1' and pr.id = 2 and p.id not in (select id from dokter) order by locate('$q', p.no_identitas) LIMIT 10";
		$dokter = mysql_query($sql);
	   $hasil = array();
        while ($data = mysql_fetch_object($dokter)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
	}else if($_GET['opsi'] == 'pegawai_dokter_nama'){
	$sql = "select 
		p.id as id_penduduk,
		p.no_identitas as no_identitas,
		p.sip,
		p.nama as nama_dok,
		p.jenis_kelamin,
		dp.alamat_jalan,
		kel.nama as nama_kelurahan,
		kel.id as id_kelurahan,
		dp.id_agama,
		peg.id_level,
		peg.id_unit
		from 
		penduduk p join dinamis_penduduk dp on p.id=dp.id_penduduk 
		left join pegawai peg on p.id = peg.id
                left join profesi pr on dp.id_profesi = pr.id
		join kelurahan kel on dp.id_kelurahan=kel.id
		where locate('$q', p.nama) > 0 and dp.akhir = '1' and pr.id = 2 and p.id not in (select id from dokter) order by locate('$q', p.nama) LIMIT 10";
		$dokter = mysql_query($sql);
	   $hasil = array();
        while ($data = mysql_fetch_object($dokter)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
	} else if ($_GET['opsi'] == "calonPasien") {
        $sql = ("select
                p.id as id_penduduk,
                p.nama as nama_pas,
                p.jenis_kelamin,
                p.gol_darah, dp.*,
                kl.nama as nama_kelurahan,
                pr.id as id_pro,
                pr.nama as nama_pro,
                dp.alamat_jalan,
                dp.status_pernikahan,
                dp.id_pendidikan_terakhir,
                dp.id_agama,
           concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir from penduduk p
		left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
		left join kelurahan kl on(dp.id_kelurahan = kl.id)
		left join profesi pr on(pr.id = dp.id_profesi)
        left join agama ag on(ag.id = dp.id_agama)
	where locate('$q', p.nama) > 0 and dp.akhir = '1' order by locate('$q', p.nama) LIMIT 10");
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "nmKeluarga") {
        $sql = mysql_query("select p.*, dp.alamat_jalan, dp.no_telp, p.posisi_di_keluarga as nama_posisi from penduduk p 
                left join dinamis_penduduk dp on (p.id = dp.id_penduduk) 
                where locate('$q', p.nama) > 0 and dp.akhir = '1' order by locate('$q', p.nama)");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "kelurahan_kec") {
        $sql = mysql_query("SELECT
                            ku.id AS id_kelurahan, ku.nama AS kelurahan, kc.id AS id_kecamatan, kc.nama AS kecamatan, k.nama AS kabupaten, p.nama AS provinsi
                        FROM
                            provinsi p, kabupaten k, kecamatan kc, kelurahan ku
                        WHERE
                            p.id = k.id_provinsi
                            AND k.id = kc.id_kabupaten
                            AND kc.id = ku.id_kecamatan
                            AND LOCATE('$q', ku.nama) > 0
                        ORDER BY LOCATE('$q', ku.nama)
                    ");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    }  else if ($_GET['opsi'] == "kelurahan") {
        $sql = mysql_query("select ku.id as id_kel, ku.nama as nama_kel, kc.nama as nama_kec, k.nama as nama_kab, p.nama as nama_pro from provinsi p, kabupaten k, kecamatan kc, kelurahan ku where p.id = k.id_provinsi and k.id = kc.id_kabupaten and kc.id = ku.id_kecamatan and locate('$q', ku.nama) > 0 order by locate('$q', ku.nama) LIMIT 10");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "kecamatan") {
        $sql = mysql_query("SELECT c.id, c.nama, k.nama AS kabupaten, p.nama AS provinsi FROM kecamatan c, kabupaten k, provinsi p WHERE c.nama LIKE '%$q%' AND c.id_kabupaten = k.id AND k.id_provinsi = p.id LIMIT 10") ;
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "kabupaten") {
        $sql = mysql_query("SELECT k.id, k.nama, p.nama AS provinsi, k.id_provinsi FROM kabupaten k, provinsi p WHERE k.nama LIKE '%$q%' AND k.id_provinsi = p.id LIMIT 10");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "provinsi") {
        $sql = mysql_query("select id, nama from provinsi where nama like '%$q%' LIMIT 10");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "namaPkj") {
        $sql = mysql_query("select * from profesi where locate('$q', nama) > 0 order by locate('$q', nama) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "nmPjw") {
        $sql = mysql_query("select p.*, dp.alamat_jalan, dp.no_telp from penduduk p 
        left join dinamis_penduduk dp on (p.id = dp.id_penduduk) 
        where locate('$q', p.nama) > 0 and dp.akhir = '1' order by locate('$q', p.nama) LIMIT 10");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "rujukan") {
        $sql = mysql_query("select ir.* from instansi_relasi ir
        join jenis_instansi_relasi jir on ir.id_jenis_instansi_relasi = jir.id
        where jir.id in (4,6,9) and locate('$q', ir.nama) > 0
        order by locate('$q', ir.nama) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "nakes") {
		$pasien='';
	if(isset ($_GET['pasien'])){
		$pasien="and p.nama !='$pasien'";
		}
        $sql = ("select p.*,p.id as idpen, dp.alamat_jalan, dp.no_telp, p.posisi_di_keluarga as nama_posisi 
                from penduduk p
                left join pegawai on pegawai.id=p.id
                left join dinamis_penduduk dp on (p.id=dp.id_penduduk and dp.id_profesi !='')
				left join profesi pr on(pr.id=dp.id_profesi)
                where pr.jenis='Nakes' $pasien and dp.id_profesi !='1' and locate('$q', p.nama) > 0 and dp.akhir = '1' order by locate('$q', p.nama) LIMIT 10");
        die(json_encode(_select_arr($sql)));
    } else if ($_GET['opsi'] == 'asuransi') {
        $sql = mysql_query("select * from jenis_asuransi where locate('$q', jenis_asuransi) > 0 order by locate('$q', jenis_asuransi)");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'charity') {
        $sql = mysql_query("select * from jenis_charity where locate('$q', jenis_charity) > 0 order by locate('$q', jenis_charity) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "kelurahan") {
        $sql = mysql_query("select ku.id as id_kel, ku.nama as nama_kel, kc.nama as nama_kec, k.nama as nama_kab, p.nama as nama_pro from provinsi p, kabupaten k, kecamatan kc, kelurahan ku where p.id = k.id_provinsi and k.id = kc.id_kabupaten and kc.id = ku.id_kecamatan and locate('$q', ku.nama) > 0 order by locate('$q', ku.nama) LIMIT 10");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'provinsi') {
        $sql = mysql_query("select * from provinsi where locate('$q',nama) > 0 order by locate('$q',nama) LIMIT 10");
        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'kabupaten') {
        $sql = mysql_query("select * from kabupaten where locate('$q',nama) > 0 order by locate('$q',nama) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'pegawai') {
        $sql = mysql_query("
                select p.nama,p.id as id_penduduk,pg.*,dp.alamat_jalan 
                from penduduk p join pegawai pg on (p.id = pg.id)
                left join dinamis_penduduk dp on p.id=dp.id_penduduk
                where  dp.akhir = 1 and p.id not in (select id from users) and locate('$q',p.nama) > 0 order by locate('$q',p.nama) LIMIT 10") or die(mysql_error());
        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'pegawai_info') {
        $sql = mysql_query("select p.nama,pg.id as id_pegawai,pg.*,dp.alamat_jalan 
                from pegawai pg join penduduk p on (pg.id = p.id)
                left join dinamis_penduduk dp on pg.id=dp.id_penduduk
                where  p.nama like '%$q%' LIMIT 5") or die(mysql_error());
        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'kecamatan') {
        $sql = mysql_query("select * from kecamatan where locate('$q',nama) > 0 order by locate('$q',nama) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'discharge') {
        $order = "";
        if (isset($_GET['nama'])) {
            $order = "and locate ('$q',pd.nama) > 0 order by locate ('$q',pd.nama)";
        } else if (isset($_GET['norm'])) {
            $order = "and locate ('$q',ps.id) > 0 order by locate ('$q',ps.id)";
        }
        $sql = "select b.id as id_billing, ps.id as pasien, pd.nama as penduduk,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten 
				from billing b
                left join pasien ps on (b.id_pasien = ps.id)  
				left join penduduk pd on (ps.id_penduduk=pd.id) 
				left join dinamis_penduduk dp on (pd.id=dp.id_penduduk and dp.id=(select max(id) from dinamis_penduduk where dinamis_penduduk.id_penduduk=pd.id and dinamis_penduduk.akhir=1))
				left join kelurahan kel on (dp.id_kelurahan=kel.id) 
				left join kecamatan kec on (kel.id_kecamatan=kec.id)
				left join kabupaten kab on (kec.id_kabupaten=kab.id)				
				where b.id in (select max(id) from billing where id_pasien in (select id_pasien from billing group by id_pasien) group by id_pasien) $order LIMIT 10
				";

        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'kunjungan') {
        $sql = "select k.id,k.id_pasien,k.no_kunjungan_pasien,ps.id as pasien, pd.nama as penduduk,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,(select max(id) from billing where id_pasien=ps.id) as id_billing,k.rencana_cara_bayar as carabayar from kunjungan k
                        left join pasien ps on (k.id_pasien=ps.id) 
                        left join penduduk pd on (ps.id_penduduk=pd.id) 
                        left join dinamis_penduduk dp on (pd.id=dp.id_penduduk and dp.id=(select max(id) from dinamis_penduduk where dinamis_penduduk.id_penduduk=pd.id and dinamis_penduduk.akhir=1))
                        left join kelurahan kel on (dp.id_kelurahan=kel.id) 
                        left join kecamatan kec on (kel.id_kecamatan=kec.id)
                        left join kabupaten kab on (kec.id_kabupaten=kab.id) 
						where 
			k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and locate ('$q',pd.nama) > 0 order by locate ('$q',pd.nama) LIMIT 10";

        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } 
	
	else if ($_GET['opsi'] == 'kunjungansekarang') {
        $today = date("Y-m-d");
        $sql = "select k.id,k.id_pasien,ps.id as pasien, pd.nama as penduduk,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,(select max(id) from billing where id_pasien=ps.id) as id_billing from kunjungan k
                        left join pasien ps on (k.id_pasien=ps.id) 
                        left join penduduk pd on (ps.id_penduduk=pd.id) 
                        left join dinamis_penduduk dp on (pd.id=dp.id_penduduk) 
                        left join kelurahan kel on (dp.id_kelurahan=kel.id) 
                        left join kecamatan kec on (kel.id_kecamatan=kec.id)
                        left join kabupaten kab on (kec.id_kabupaten=kab.id) where 
			k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id) and k.waktu LIKE '$today%' and locate ('$q',pd.nama) > 0 group by k.id_pasien LIMIT 5"; //locate ('$q',pd.nama)";

        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'norm_kunjungan') {
        $sql = mysql_query("select k.id,k.id_pasien,ps.id as pasien,k.no_kunjungan_pasien, pd.nama as penduduk,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,(select max(id) from billing where id_pasien=ps.id) as id_billing ,k.rencana_cara_bayar as carabayar
                        from kunjungan k
                        left join pasien ps on (k.id_pasien=ps.id) 
                        left join penduduk pd on (ps.id_penduduk=pd.id) 
                        left join dinamis_penduduk dp on (pd.id=dp.id_penduduk and dp.id=(select max(id) from dinamis_penduduk where dinamis_penduduk.akhir=1 and dinamis_penduduk.id_penduduk)) 
                        left join kelurahan kel on (dp.id_kelurahan=kel.id) 
                        left join kecamatan kec on (kel.id_kecamatan=kec.id)
                        left join kabupaten kab on (kec.id_kabupaten=kab.id)			
						 where 
			k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and locate ('$q',ps.id) > 0 order by locate ('$q',ps.id) LIMIT 10");

        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    }else if($_GET['opsi'] == 'asuransi_kunjungan'){ 
        
        if(isset ($_GET['id_kunjungan'])){
            if(!empty ($_GET['id_kunjungan'])){
                
                $sql="
                    select akk.id as id_asuransi, ap.nama as nama_asuransi
                    from
                    asuransi_kepesertaan_kunjungan akk
                    left join asuransi_produk ap on ap.id=akk.id_asuransi_produk
                    where akk.id_kunjungan=".$_GET['id_kunjungan'];
                $hasil=_select_arr($sql);
                die(json_encode($hasil));
            }
        }
    }else if ($_GET['opsi'] == 'asuransiProduk') {
        $sql = "select ap.nama as nama_asuransi, ap.id as id_asuransi, ir.nama as nama_pabrik,ir.alamat as alamat_pabrik,kelurahan.nama as nama_kelurahan
                from asuransi_produk ap
                JOIN instansi_relasi ir on ir.id=ap.id_instansi_relasi
                JOIN kelurahan on kelurahan.id=ir.id_kelurahan
                where ap.nama like '%$q%' LIMIT 5
                ";
        die(json_encode(_select_arr($sql)));
    } else if ($_GET['opsi'] == 'asuransi-pasien') {
        die(json_encode(kepesertaan_asuransi($_GET['idPenduduk'])));
    } else if ($_GET['opsi'] == 'layanan') {
        die(json_encode(_select_arr("select l.* from layanan l where l.nama like '%$q%' and l.jenis='Semua'")));
    } else if ($_GET['opsi'] == 'layanan_all') {
        die(json_encode(_select_arr("select * from layanan where nama like '%$q%'")));
    } else if ($_GET['opsi'] == 'layanan_rawat_jalan') {
        die(json_encode(_select_arr("select distinct l.nama,l.*,sp.nama as spesialisasi,p.nama as profesi,ins.nama as instalasi
                             from layanan l 
                             left join spesialisasi sp on l.id_spesialisasi = sp.id 
                             left join instalasi ins on l.id_instalasi=ins.id
                             left join profesi p on sp.id_profesi = p.id
                             where concat_ws(' ',l.nama,p.nama,sp.nama) like '%$q%' and l.jenis='Semua' LIMIT 10")));
    } 
	else if ($_GET['opsi'] == 'layanan_rawat_jalan_aja') {
        die(json_encode(_select_arr("select distinct l.nama,l.*,sp.nama as spesialisasi,p.nama as profesi,ins.nama as instalasi
                             from layanan l 
                             left join spesialisasi sp on l.id_spesialisasi = sp.id 
                             left join instalasi ins on l.id_instalasi=ins.id
                             left join profesi p on sp.id_profesi = p.id
                             where concat_ws(' ',l.nama,p.nama,sp.nama) like '%$q%' and l.jenis!='Rawat Inap' LIMIT 10")));
    } 
	else if ($_GET['opsi'] == 'layanan_tarif') {
        die(json_encode(_select_arr("select l.*,sp.nama as spesialisasi,p.nama as profesi,ins.nama as instalasi
                                    from layanan l 
                                    left join spesialisasi sp on l.id_spesialisasi = sp.id 
                                    left join instalasi ins on l.id_instalasi=ins.id
                                    left join profesi p on sp.id_profesi = p.id
                                    where concat_ws(' ',l.nama,p.nama,sp.nama) like '%$q%' LIMIT 10")));
    }
	else if ($_GET['opsi'] == 'layanan_full') {
        die(json_encode(_select_arr("select l.*,sp.nama as spesialisasi,p.nama as profesi from layanan l left join spesialisasi sp on l.id_spesialisasi = sp.id 
                                     left join profesi p on sp.id_profesi = p.id
                                     where l.nama like '%$q%' and l.jenis='Semua' LIMIT 5")));
  } 

  else if ($_GET['opsi'] == 'billing') {
        $sql = "
          select ps.id as id_pasien, p.id as id_penduduk, p.nama as nama_pas, p.jenis_kelamin, p.gol_darah, dp.*, kl.nama as kelurahan,kc.nama as kecamatan, pr.id as id_pro, pr.nama as nama_pro, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, dp.id_agama,concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir,
            bil.id as id_billing,
			k.rencana_cara_bayar as carabayar,k.no_kunjungan_pasien,k.id as id_kunjungan
            from penduduk p
            join pasien ps on (p.id = ps.id_penduduk)
            left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
			left join kunjungan k on (k.id_pasien=ps.id and k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) )
            left join kelurahan kl on(dp.id_kelurahan = kl.id)
			left join kecamatan kc on(kc.id = kl.id_kecamatan)
            left join profesi pr on(pr.id = dp.id_profesi)
            left join agama ag on(ag.id = dp.id_agama)
		  	 LEFT JOIN billing bil ON (bil.id_pasien=ps.id)
            where locate('$q', ps.id) > 0 and dp.akhir = '1'  AND bil.status_pembayaran='0' order by locate('$q', ps.id) LIMIT 10
        ";
        die(json_encode(_select_arr($sql)));
    } 
	else if ($_GET['opsi'] == 'ceknamabilling') {
        $sql = "
          select ps.id as id_pasien, p.id as id_penduduk, p.nama as nama_pas, p.jenis_kelamin, p.gol_darah, dp.*, kl.nama as kelurahan,kc.nama as kecamatan, pr.id as id_pro, pr.nama as nama_pro, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, dp.id_agama,concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir,
            bil.id as id_billing,
				k.rencana_cara_bayar as carabayar,k.no_kunjungan_pasien,k.id as id_kunjungan
            from penduduk p
            join pasien ps on (p.id = ps.id_penduduk)
            left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
            left join kelurahan kl on(dp.id_kelurahan = kl.id)
			 left join kecamatan kc on(kc.id = kl.id_kecamatan)
            left join profesi pr on(pr.id = dp.id_profesi)
            left join agama ag on(ag.id = dp.id_agama)
		left join kunjungan k on (k.id_pasien=ps.id and k.id in (select max(id) from kunjungan 
		where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) )
		 LEFT JOIN billing bil ON (bil.id_pasien=ps.id)
            where locate('$q', p.nama) > 0 and dp.akhir = '1' AND bil.status_pembayaran='0' order by locate('$q', p.nama) LIMIT 10
        ";
        die(json_encode(_select_arr($sql)));
    } 
	
	
	else if ($_GET['opsi'] == 'layananBilling') {
        if (isset($_GET['kelas']) && $_GET['kelas'] != "") {
            $where = " and t.id_kelas='$_GET[kelas]' and ins.id = '$_GET[instalasi]'";
        }else
            $where = "";
     //   if (isset($_GET['jenis']) && $_GET['jenis']=='rawat_inap') {
      //      $action = "and l.jenis='Rawat Inap'";
      //  }else
       //     $action = "";
		$sql = "select t.id as tarif,l.id as id_layanan,l.nama as layanan,l.bobot,
        ins.nama as instalasi,t.total,kelas.nama as kelas,
        sp.nama as spesialisasi,pr.nama as profesi
        from tarif t
        left join layanan l on t.id_layanan=l.id
        join kelas on t.id_kelas=kelas.id
        join instalasi ins on l.id_instalasi=ins.id
        left join spesialisasi sp on sp.id=l.id_spesialisasi
        left join profesi pr on pr.id=sp.id_profesi
        where locate('$q', l.nama) > 0 $where  and l.jenis != 'Rawat Inap' and t.status='Berlaku' order by locate('$q',l.nama) limit 10";

//      and l.jenis ='Rawat Inap'  echo $sql;
        die(json_encode(_select_arr($sql)));
    }else if ($_GET['opsi'] == 'layananBillingRW') {
     //   if (isset($_GET['kelas']) && $_GET['kelas'] != "") {
           // $where = " and t.id_kelas='$_GET[kelas]' and ins.id = '$_GET[instalasi]'";
       // }else
         //   $where = "";
     //   if (isset($_GET['jenis']) && $_GET['jenis']=='rawat_inap') {
      //      $action = "and l.jenis='Rawat Inap'";
      //  }else
       //     $action = "";
		$sql = "select t.id as tarif,l.id as id_layanan,l.nama as layanan,l.bobot as bobot,
        ins.nama as instalasi,t.total,kelas.nama as kelas,
        sp.nama as spesialisasi,pr.nama as profesi
        from tarif t
        left join layanan l on t.id_layanan=l.id
        join kelas on t.id_kelas=kelas.id
        join instalasi ins on l.id_instalasi=ins.id
        left join spesialisasi sp on sp.id=l.id_spesialisasi
        left join profesi pr on pr.id=sp.id_profesi
		  where locate('$q', l.nama) > 0 and l.jenis = 'Rawat Inap' and t.status='Berlaku' order by locate('$q',l.nama)";
//      and l.jenis ='Rawat Inap'  echo $sql;
        die(json_encode(_select_arr($sql)));
    }else if ($_GET['opsi'] == "bed_rawat_jalan") {
        $where = '';
        if (isset($_GET['status'])) {
            $where = " and b.status='$_GET[status]' ";
        }
        //hanya mencari no bed dengan instalasi poliklinik dan gawar darurat saja
        $query = "select b.*,k.nama as kelas,i.nama as instalasi
                from bed b left
                join kelas k on b.id_kelas=k.id left
                join instalasi i on b.id_instalasi=i.id
                where locate('$q', b.nama) > 0 and (i.id=3 OR i.id=4)
                $where order by locate('$q', b.nama) limit 10";
        die(json_encode(_select_arr($query)));
    } else if($_GET['opsi'] == "bed_kosong"){
        $query = "select b.*,k.nama as kelas,i.nama as instalasi
                from bed b left
                join kelas k on b.id_kelas=k.id left
                join instalasi i on b.id_instalasi=i.id
                where locate('$q', b.nama) > 0 and b.status = 'Kosong' order by locate('$q', b.nama) LIMIT 5";
        die(json_encode(_select_arr($query)));
    }else if($_GET['opsi'] == "bed_all"){
        $query = "select b.*,k.nama as kelas,i.nama as instalasi
                from bed b left
                join kelas k on b.id_kelas=k.id left
                join instalasi i on b.id_instalasi=i.id
                where locate('$q', b.nama) > 0 order by locate('$q', b.nama) LIMIT 5";
        die(json_encode(_select_arr($query)));
    }else if ($_GET['opsi'] == "bed_rawat_inap") {
        if (isset($_GET['status'])) {
            $where = " and b.status='$_GET[status]' ";
        }
        
        $query = "select b.*, k.nama as kelas, k.id as id_kelas, i.id as id_instalasi, i.nama as instalasi
                from bed b 
                left join kelas k on b.id_kelas=k.id left
                join instalasi i on b.id_instalasi=i.id
                where i.id not in (1,2,3,4) and k.id != 1 $where and locate('$q', concat_ws(' ',b.nama,i.nama)) > 0 order by locate('$q', b.nama) LIMIT 10";
        die(json_encode(_select_arr($query)));
    } else if($_GET['opsi'] == "dokter_rm"){
        $query = "select p.id as id_dokter,p.nama as dokter,p.sip,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi from dokter d 
        join penduduk p on d.id = p.id
        join dinamis_penduduk dp on dp.id_penduduk = p.id
        join kelurahan kel on dp.id_kelurahan = kel.id
        join kecamatan kec on kel.id_kecamatan = kec.id
        join kabupaten kab on kec.id_kabupaten = kab.id
        join provinsi pro on kab.id_provinsi = pro.id 
        where dp.akhir = 1 and locate('$q', p.nama) > 0 order by locate('$q', p.nama) LIMIT 10";
        
        die(json_encode(_select_arr($query)));
    }else if($_GET['opsi'] == "kejadian"){
        $query = "select k.*,kel.nama as kelurahan from kejadian_sakit k
        join kelurahan kel on k.id_kelurahan = kel.id LIMIT 5";
        
        die(json_encode(_select_arr($query)));
    }else if ($_GET['opsi'] == "no_antrian") {
        require_once 'app/lib/admisi/admisi-models.php';
        $number = create_medical_record_number();
        $sequence = squence_number($_GET['idLayanan']);
        $result = array('number' => $number, 'kartu_kunjungan' => $sequence);
        die(json_encode($result));
    } else if ($_GET['opsi'] == 'info-pasien') {
        $sql = mysql_query("select pd.id as idpddk,k.id_pasien as norm, pd.nama as pasien, 
		dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi from kunjungan k 
        left join pasien ps on k.id_pasien = ps.id
        left join penduduk pd on ps.id_penduduk = pd.id  
        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
        left join kelurahan kel on dp.id_kelurahan = kel.id
        left join kecamatan kec on kel.id_kecamatan = kec.id
        left join kabupaten kab on kec.id_kabupaten = kab.id
        left join provinsi pro on kab.id_provinsi = pro.id
        where locate('$q', pd.nama) > 0 group by ps.id order by locate('$q',pd.nama) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } 
	
	else if ($_GET['opsi'] == 'norm-pasien') {
        $sql = mysql_query("select pd.id as idpddk,k.id_pasien as norm, pd.nama as pasien, 
		dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi from kunjungan k 
        left join pasien ps on k.id_pasien = ps.id
        left join penduduk pd on ps.id_penduduk = pd.id  
        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
        left join kelurahan kel on dp.id_kelurahan = kel.id
        left join kecamatan kec on kel.id_kecamatan = kec.id
        left join kabupaten kab on kec.id_kabupaten = kab.id
        left join provinsi pro on kab.id_provinsi = pro.id
        where locate('$q', k.id_pasien) > 0 group by ps.id order by locate('$q',k.id_pasien) LIMIT 5");
        $hasil = array();
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } 
	else if ($_GET['opsi'] == "instalasi") {
        if (isset($_GET['jenis'])) {
            $where = " AND i.jenis='$_GET[jenis]'";
        }else
            $where="";
        $query = "select i.* from instalasi i
                where locate('$q', i.nama) > 0 $where order by locate('$q', i.nama) LIMIT 10";
        die(json_encode(_select_arr($query)));
    }
	 else if ($_GET['opsi'] == "infobed") {
        $query = "select i.* from instalasi i
                where locate('$q', i.nama) > 0 and id > 4 order by locate('$q', i.nama) LIMIT 5";
        die(json_encode(_select_arr($query)));
    }
	else if ($_GET['opsi'] == "kelas") {
        $query = "select k.* from kelas k
                where locate('$q', k.nama) > 0 order by locate('$q', k.nama) LIMIT 5";
        die(json_encode(_select_arr($query)));
    }
		else if ($_GET['opsi'] == "perundangan") {
        $query = "select p.* from perundangan p
                where locate('$q', p.nama) > 0 order by locate('$q', p.nama) LIMIT 5";
        die(json_encode(_select_arr($query)));
    }
	
	else if ($_GET['opsi'] == "cekNip") {
        if (isset($_GET['edit']))
            $query = "select * from pegawai where nip='$q' and id!='" . $_GET['idpegawai'] . "'";
        else
            $query = "select * from pegawai where nip='$q'";
        die(json_encode(_select_arr($query)));
    }else if ($_GET['opsi'] == "cekNamaPegawai") {
        $query = "select pd.nama from pegawai pg left join penduduk pd on pg.id=pd.id where pd.nama='$q'";
        die(json_encode(_select_arr($query)));
    } else if ($_GET['opsi'] == "cek_norm") {
        $jumlah = _select_unique_result("select count(*) as jumlah from pasien where id='$_GET[q]'");
        if ($jumlah['jumlah'] == 0) {
            die(json_encode(array('status' => true)));
        } else {
            $id = _select_unique_result("select max(id) as id from pasien");
            $id++;
            die(json_encode(array('status' => false, 'id_pasien' => "$id[id]")));
        }
    } else if ($_GET['opsi'] == "spesialisasi") {
        $query = "select s.*,p.nama as profesi from spesialisasi s left join profesi p on s.id_profesi = p.id where locate('$q', s.nama) > 0 order by locate('$q', s.nama) limit 10";
        die(json_encode(_select_arr($query)));
    } else if ($_GET['opsi'] == "profesi") {
        $query = "select * from profesi where locate('$q', nama) > 0 order by locate('$q', nama) limit 10";
        die(json_encode(_select_arr($query)));
    } else if ($_GET['opsi'] == "nakes_admisi") {
        $query = "
          select p.nama,p.id as id_penduduk,p.sip,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,prov.nama as provinsi from penduduk p
          left join dinamis_penduduk dp on dp.id_penduduk = p.id
          left join profesi pr on dp.id_profesi = pr.id
          left join kelurahan kel on dp.id_kelurahan = kel.id
          left join kecamatan kec on kel.id_kecamatan = kec.id
          left join kabupaten kab on kec.id_kabupaten = kab.id
          left join provinsi prov on kab.id_provinsi = prov.id 
          where dp.akhir = '1' and pr.nama = 'Dokter' and p.id in (select id from pegawai)
          and locate('$q', p.nama) > 0 order by locate('$q', p.nama) LIMIT 10
        ";
        //and (p.sip<>'' and p.sip is not null) 
        die(json_encode(_select_arr($query)));
    }
}
if ($_GET['opsi'] == "cek_valid_layanan") {
    if (isset($_GET['edit'])) {
        $row = _select_unique_result("select count(*) as jumlah from layanan where id!='" . $_GET['idLayanan'] . "' AND nama='" . $_GET['nama'] . "' AND id_instalasi='" . $_GET['idInstalasi'] . "' AND id_spesialisasi='" . $_GET['idSpesialisasi'] . "' AND bobot='" . $_GET['kategori'] . "' AND jenis='" . $_GET['jenis'] . "'");
    } else {
        $row = _select_unique_result("select count(*) as jumlah from layanan where nama='" . $_GET['nama'] . "' AND id_instalasi='" . $_GET['idInstalasi'] . "' AND id_spesialisasi='" . $_GET['idSpesialisasi'] . "' AND bobot='" . $_GET['kategori'] . "' AND jenis='" . $_GET['jenis'] . "'");
    }


    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;

    die(json_encode(array('status' => $status)));
}else if ($_GET['opsi'] == "cek_faktur") {
    if (isset($_GET['no'])) {
        $row = _select_unique_result("select count(*) as jumlah from pembelian where no_faktur = $_GET[no] LIMIT 5" );
        if ($row['jumlah'] == 0) {
            $status = true;
        }else
            $status = false;
    }
    die(json_encode(array('status' => $status)));
}else if ($_GET['opsi'] == "cek_valid_pegawai") {

    if (isset($_GET['edit'])) {
        $row = _select_unique_result("select count(*) as jumlah from pegawai p
            left join penduduk pdd on pdd.id=p.id
            left join dinamis_penduduk dp on (dp.id_penduduk=pdd.id and dp.akhir=1)
            where p.id!='" . $_GET['idpegawai'] . "' and pdd.id!='" . $_GET['idpenduduk'] . "' and pdd.nama='" . ucwords($_GET['nama']) . "' and dp.alamat_jalan='" . $_GET['almt'] . "'");
    } else {
        $row = _select_unique_result("select count(*)as jumlah from pegawai p
            left join penduduk pdd on pdd.id=p.id
            left join dinamis_penduduk dp on (dp.id_penduduk=pdd.id and dp.akhir=1)
            where pdd.nama='" . ucwords($_GET['nama']) . "' and dp.alamat_jalan='" . $_GET['almt'] . "'");
    }

    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;

    die(json_encode(array('status' => $status)));
}else if ($_GET['opsi'] == "hapus_kepesertaan") {
    $id = $_GET['id'];
    $query = _delete("delete from kepesertaan_asuransi_kunjungan where id='$id'");
    if ($query) {
        $status = true;
    }else
        $status = false;

    die(json_encode(array('status' => $status)));
}else if ($_GET['opsi'] == "paging_jenis_instansi_relasi") {
    require_once 'app/lib/common/master-inventory.php';
    $nama = (isset($result)) ? $result['nama'] : null;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $code = isset($_GET['code']) ? $_GET['code'] : NULL;
    $page = isset($_GET['page']) ? $_GET['page'] : NULL;
    $dataPerPage = get_value('perPage');
    $jenisRelasi = jenis_instansi_relasi_muat_data($code, $sort, $page, $dataPerPage);
    die(json_encode($jenisRelasi));
}else if ($_GET['opsi'] == "paging_pegawai") {
    require_once 'app/lib/common/master-data.php';
    $key = isset($_GET['key']) ? $_GET['key'] : NULL;
    $page = isset($_GET['page']) ? $_GET['page'] : NULL;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
    $code = isset($_GET['code']) ? $_GET['code'] : NULL;
    $dataPerPage = get_value('perPage');
    $pegawaiList = pegawai_muat_data($code, $sort, $sortBy, $page, $dataPerPage, $key);
    die(json_encode($pegawaiList));
}else if ($_GET['opsi'] == "paging_penduduk") {
    require_once 'app/lib/common/master-data.php';
    $category = isset ($_GET['category'])?$_GET['category']:NULL;
    $sort = isset($_GET['sort'])?$_GET['sort']:NULL;
    $sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
    $page = isset($_GET['page'])?$_GET['page']:NULL;
    $key = isset($_GET['key'])?$_GET['key']:NULL;
    $dataPerPage = get_value('perPage');
    $id = isset ($_GET['idPenduduk'])?$_GET['idPenduduk']:NULL;
    $penduduk = penduduk_muat_data($id,$key,$category,$sort,$sortBy,$page,$dataPerPage);
    die(json_encode($penduduk));
}else if ($_GET['opsi'] == "paging_spesialisasi") {
    require_once 'app/lib/common/master-data.php';
    $dataPerPage = get_value('perPage');
    $page = isset ($_GET['page'])?$_GET['page']:NULL;
    $code = isset($_GET['code'])?$_GET['code']:NULL;
    $spesialisasi = spesialisasi_muat_data($code,$page,$dataPerPage=15);
    die(json_encode($spesialisasi));
}else if ($_GET['opsi'] == "paging_unit") {
    require_once 'app/lib/common/master-data.php';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : '';
    if (isset($_GET['do']) && $_GET['do'] == 'edit') {
        $result = unit_muat_data($_GET['id']);
    }
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 15;
    $id = (isset($result)) ? $result['id'] : null;
    $nama = (isset($result)) ? $result['nama'] : null;
    $code = isset($_GET['code']) ? $_GET['code'] : NULL;
    $jenisRelasi = $unit = unit_muat_data($code, $sort, $sortBy, $page, $perPage);
    die(json_encode($jenisRelasi));
}else if($_GET['opsi'] == "cek_bed"){
    if (isset($_GET['edit'])) {
        $row = _select_unique_result("select count(*) as jumlah from bed where id<>'".$_GET['idBed']."' and nama='".$_GET['bed']."' and id_kelas='".$_GET['kelas']."' and id_instalasi='".$_GET['instalasi']."'");
    } else {
        $row = _select_unique_result("select count(*) as jumlah from bed where nama='".$_GET['bed']."' and id_kelas='".$_GET['kelas']."' and id_instalasi='".$_GET['instalasi']."'");
    }


    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;

    die(json_encode(array('status' => $status)));
}else if($_GET['opsi'] == "cek_role"){
    if(isset ($_GET['kategori'])){
        $action = "and id_kategori_barang_pemesanan_role='".$_GET['kategori']."'";
    }else $action = "";
    
    if (isset($_GET['editrole'])) {
        $row = _select_unique_result("select count(*) as jumlah from role where id_role<>'".$_GET['id']."' and nama_role='".$_GET['nama_role']."' $action");
    } else {
        $row = _select_unique_result("select count(*) as jumlah from role where nama_role='".$_GET['namarole']."' $action");
    }


    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;

    die(json_encode(array('status' => $status)));
}else if($_GET['opsi'] == "cek_tarif"){
    if (isset($_GET['edit'])) {
        $row = _select_unique_result("select count(id) as jumlah from tarif where id<>'".$_GET['id']."' and id_layanan='".$_GET['id_layanan']."' and id_kelas='".$_GET['id_kelas']."'");
    } else {
        $row = _select_unique_result("select count(id) as jumlah from tarif where id_layanan='".$_GET['id_layanan']."' and id_kelas='".$_GET['id_kelas']."'");
    }


    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;

    die(json_encode(array('status' => $status)));
}else if ($_GET['opsi'] == "penduduk_data_pemda") {
	
		$no_identitas = str_replace('.','',$_GET['push']);
		$client = new nusoap_client('http://interop.slemankab.go.id/gen.services/ws.SIAK/wsserv.php');
		$wil = array('KEY1'=>'','KEY2'=>'','P01'=>$no_identitas);
		$result_gatwalk = $client->call('getPendudukByNIK_SIMRS', array('krit' => $wil));
		$return = array();
			if ($client->fault) {
				return $return;
			} else {
				$err = $client->getError();
				if ($err) {
					return $return;
				} else {
					if(is_array($result_gatwalk)){
						foreach($result_gatwalk as $data){
						$tgl = explode('-',$data['TGL_LAHIR']);$tgl= $tgl[2].'/'.$tgl[1].'/'.$tgl[0];
						$query_prov = mysql_query("select nama as nama_prov from provinsi where id='".$data['ID_PROP']."' ");
						$nama_prov = mysql_fetch_assoc($query_prov);
						$return = array(
							'nik'=>$data['NIK'],
							'nama'=>$data['NAMA'],
							'tanggal_lahir'=>$tgl,
							'kota_lahir'=>$data['KOTA_LAHIR'],
							'jkelamin'=>$data['KJKEL'],
							'gdarah'=>$data['KDARAH'],
							'agama'=>$data['KAGAMA'],
							'pend_terakhir'=>$data['KTPU'],
							'pekerjaan'=>$data['KKERJA'],
							'status_nikah'=>$data['KNIKAH'],
							'no_kk'=>$data['NO_KK'],
							'provinsi'=>$nama_prov['nama_prov'],
							'kabupaten'=>$data['KAB'],
							'kecamatan'=>$data['KEC'],
							'kelurahan'=>$data['KEL'],
							'alamat'=>$data['ALAMAT'],
							'rt'=>$data['RT'],
							'rw'=>$data['RW'],
							'profesi'=>'2',
							'id_provinsi'=>$data['ID_PROP'],
							'id_kabupaten'=>$data['ID_KAB'],
							'id_kecamatan'=>$data['ID_KEC'],
							'id_kelurahan'=>$data['ID_KEL']
						);
						}
					}
					die(json_encode($return));
				}
			}
}else if($_GET['opsi'] == 'kepesertaan_jamkesmas'){
		$no_identitas = str_replace('.','',$_GET['push']);
		$client = new nusoap_client('http://interop.slemankab.go.id/gen.services/ws.Kemiskinan/wsserv.php');
		$wil = array('KEY1'=>'','KEY2'=>'','P01'=>$no_identitas);
		$result_gatwalk = $client->call('getPendudukMiskin_SIMRS', array('krit' => $wil));
		$return = array();
			if ($client->fault) {
				echo $return;
			} else {
				$err = $client->getError();
				if ($err) {
					return $return;
				} else {
					if(is_array($result_gatwalk)){
						$return = array('nik'=>$no_identitas);
					}
					die(json_encode($return));
				}
			}
}else if ($_GET['opsi'] == "asuransi_terakhir_pasien") {
    $norm=$q;
    $sql="SELECT k.id as id_kunjungan,akk.id as id_asuransi_kunjungan,akk.no_polis,akk.id_asuransi_produk, ap.nama as nama_asuransi
          FROM
          kunjungan k
          join asuransi_kepesertaan_kunjungan akk on akk.id_kunjungan=k.id         
          join asuransi_produk ap on ap.id=akk.id_asuransi_produk
          where k.id_pasien=$q order by akk.id desc limit 1";
    $hasil=_select_unique_result($sql);
    die(json_encode($hasil));
}
exit;
?>
