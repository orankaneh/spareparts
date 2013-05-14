<?php

require_once 'app/config/db.php';
include_once "app/lib/common/master-data.php";
include_once "app/lib/common/functions.php";
if (isset($_GET['q'])) {
    $q = strtolower($_GET['q']);
    if ($_GET['opsi'] == "nopenjualan") {
        $sql = "select p.id, dp.alamat_jalan, k.nama as kelurahan, pd.nama from penjualan p
		join penduduk pd on (p.id_penduduk_pembeli = pd.id)
		join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
		join kelurahan k on (dp.id_kelurahan = k.id)
		where p.id = '$q'";
		$hasil = _select_arr($sql);
        die(json_encode($hasil));
    }else if($_GET['opsi'] == "norm_pembayaran"){
        $sql="SELECT ps.id as norm,pd.id as id_penduduk, pd.nama as pasien,dp.alamat_jalan,kel.nama as kelurahan,
                kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi
              FROM pasien ps
                left join penduduk pd on ps.id_penduduk = pd.id
                left join dinamis_penduduk dp on dp.id_penduduk = pd.id
                left join kelurahan kel on dp.id_kelurahan = kel.id
                left join kecamatan kec on kel.id_kecamatan = kec.id
                left join kabupaten kab on kec.id_kabupaten = kab.id
                left join provinsi pro on kab.id_provinsi = pro.id
                left join penjualan pj on pj.id_penduduk_pembeli=ps.id_penduduk
                left join billing bil on bil.id_pasien=ps.id
              where 
                (pj.id=(select max(id) from penjualan pj2 where pj2.id_penduduk_pembeli=pd.id)
              or
                bil.id=(select max(id) from billing bil2 where bil2.id_pasien=ps.id))
                and locate('$q', ps.id) > 0
                and dp.akhir = 1 group by ps.id
                order by locate('$q', ps.id)";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    }else if($_GET['opsi'] == "nama_pembayaran"){
        $sql="SELECT ps.id as norm,pd.id as id_penduduk, pd.nama as pasien,dp.alamat_jalan,kel.nama as kelurahan,
                kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi
              FROM pasien ps
                left join penduduk pd on ps.id_penduduk = pd.id
                left join dinamis_penduduk dp on dp.id_penduduk = pd.id
                left join kelurahan kel on dp.id_kelurahan = kel.id
                left join kecamatan kec on kel.id_kecamatan = kec.id
                left join kabupaten kab on kec.id_kabupaten = kab.id
                left join provinsi pro on kab.id_provinsi = pro.id
                left join penjualan pj on pj.id_penduduk_pembeli=ps.id_penduduk
                left join billing bil on bil.id_pasien=ps.id
              where 
                (pj.id=(select max(id) from penjualan pj2 where pj2.id_penduduk_pembeli=pd.id)
              or
                bil.id=(select max(id) from billing bil2 where bil2.id_pasien=ps.id))
                and locate('$q', pd.nama) > 0
                and dp.akhir = 1 group by ps.id
                order by locate('$q', ps.id)";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    }else if($_GET['opsi'] == "no_penjualan_bebas_pembayaran"){
        $sql="select
                p.id as id_penjualan
            from
                penjualan p
            where p.status_pembayaran='0' and locate('$q', p.id) > 0 and p.jenis='Bebas' and p.id_penduduk_pembeli is null
            order by locate('$q', p.id) ";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    }else if($_GET['opsi'] == "pembayaranBilling"){
        $query = "select b.id,b.id_pasien as norm,
        pd.nama as pasien,dp.alamat_jalan,kel.nama as kelurahan,
        kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi ,
        (select count(*) from detail_pembayaran_billing where id_billing = b.id)+1 as pembayaran
        from billing b
        left join pasien ps on b.id_pasien = ps.id
        left join penduduk pd on ps.id_penduduk = pd.id
        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
        left join kelurahan kel on dp.id_kelurahan = kel.id
        left join kecamatan kec on kel.id_kecamatan = kec.id
        left join kabupaten kab on kec.id_kabupaten = kab.id
        left join provinsi pro on kab.id_provinsi = pro.id
        where locate('$q', b.id_pasien) > 0 and dp.akhir = 1 and b.id=(select max(bll.id) from billing bll where bll.id_pasien=ps.id)
        group by ps.id
        order by locate('$q',pd.nama) limit 10";
        die(json_encode(_select_arr($query)));
 
		}else if($_GET['opsi'] == "pembayaranBillingnama"){
        $query = "select b.id,b.id_pasien as norm,
        pd.nama as pasien,dp.alamat_jalan,kel.nama as kelurahan,
        kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi ,
        (select count(*) from detail_pembayaran_billing where id_billing = b.id)+1 as pembayaran
        from billing b
        left join pasien ps on b.id_pasien = ps.id
        left join penduduk pd on ps.id_penduduk = pd.id
        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
        left join kelurahan kel on dp.id_kelurahan = kel.id
        left join kecamatan kec on kel.id_kecamatan = kec.id
        left join kabupaten kab on kec.id_kabupaten = kab.id
        left join provinsi pro on kab.id_provinsi = pro.id
        where locate('$q', pd.nama) > 0 and dp.akhir = 1 and b.id=(select max(bll.id) from billing bll where bll.id_pasien=ps.id)
        group by ps.id
        order by locate('$q',pd.nama) limit 10";
        die(json_encode(_select_arr($query)));
        }
        else if ($_GET['opsi'] == 'nakes') {
            $sql = "select p.*, pro.nama as profesi
            from penduduk p
            join pegawai on pegawai.id=p.id
            join dinamis_penduduk dp on (p.id = dp.id_penduduk)
            join profesi pro on (pro.id = dp.id_profesi)
            where dp.id_profesi = '$_GET[id_profesi]' AND p.nama like '%$q%' and dp.akhir = 1";
            die(json_encode(_select_arr($sql)));
        }
        else if ($_GET['opsi'] == 'unit') {
            $sql = "select * from unit where nama like ('%$q%')";
            die(json_encode(_select_arr($sql)));
        }
}else if($_GET['opsi'] == "asuransiKepesertaan"){
        $query = "select max(id) as id_kunjungan from kunjungan where id_pasien = '$_GET[norm]'";
        $data = _select_arr($query);
        foreach ($data as $row);
        $qry = "select no_polis,ap.nama as asuransi_produk from asuransi_kepesertaan_kunjungan akk join asuransi_produk ap on akk.id_asuransi_produk = ap.id where akk.id_kunjungan = '$row[id_kunjungan]'";
        
        die(json_encode(_select_arr($qry)));
}else if ($_GET['opsi'] == 'petugas') {
    $sql = "select pdd.nama, pg.id, pg.nip, u.nama as unit, u.id as id_unit from pembayaran p
        join pegawai pg on (p.id_pegawai_petugas = pg.id)
        join penduduk pdd on (pg.id = pdd.id)
        left join unit u on (pg.id_unit = u.id)
        where pdd.nama like '%$q%' group by pg.id";
    die(json_encode(_select_arr($sql)));
}else if ($_GET['opsi'] == 'pembeli') {
    $sql = "select pdd.nama, pdd.id, dp.alamat_jalan, k.nama as kelurahan from pembayaran p
        join penjualan pj on (p.id_penjualan = pj.id)
        join penduduk pdd on (pdd.id = pj.id_penduduk_pembeli)
        left join dinamis_penduduk dp on (pdd.id = dp.id_penduduk)
        left join kelurahan k on (dp.id_kelurahan = k.id)
        where dp.akhir = 1 and pdd.nama like '%$q%' group by pdd.id";
    die(json_encode(_select_arr($sql)));
}

exit ();