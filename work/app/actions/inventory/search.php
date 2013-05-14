<?php

require_once 'app/config/db.php';
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
set_time_zone();

if (isset($_GET['q'])) {
    $q = strtolower($_GET['q']);
    if ($_GET['opsi'] == "suplier") {
        if (isset($_GET['jenis_instansi'])) {
            $where = " AND i.id_jenis_instansi_relasi='$_GET[jenis_instansi]'";
        }else
            $where="";
        $sql = "select i.*,k.nama as nama_kelurahan
                from instansi_relasi i
                left join kelurahan k on (i.id_kelurahan = k.id)
                LEFT JOIN jenis_instansi_relasi  jir on jir.id=i.id_jenis_instansi_relasi
                where locate('$q', i.nama) > 0 $where order by locate('$q', i.nama) ";

        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if($_GET['opsi'] == "zatAktif"){
        die(json_encode(_select_arr("select * from zat_aktif where nama like '%$q%'")));
    } else if($_GET['opsi'] == "batch"){
        die(json_encode(_select_arr("select batch from stok where batch like '%$q%' group by batch")));
    } else if($_GET['opsi'] == "no_retur"){
        die(json_encode(_select_arr("select retur.id,instansi_relasi.nama as suplier 
                from retur_pembelian retur
                left join instansi_relasi on instansi_relasi.id=retur.id_instansi_relasi_suplier
                where retur.id like '%$q%'")));
    }else if (($_GET['opsi'] == "namabarang") && (isset($_GET['jenissp']))) {
        $sp = $_GET['jenissp'];
        if ($sp == "Umum")
            $where = "";
        else if ($sp == "Narkotik")
            $where = "and o.id_gol_perundangan = 4";
        else if ($sp == "Psikotropik")
            $where = "and o.id_gol_perundangan = 5";
				if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where k.id !='0'";
	}
	else{
	$katbarang=" where k.id='" . User::$pemesanan_barang_role . "'";
	}
        $now = date('Y-m-d');
        $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
        $sql = "SELECT
                o.kekuatan,o.generik,sediaan.nama as sediaan,b.nama as nama_barang, pb.id as id,pb.barcode,pb.id_satuan_terbesar,pb.id_satuan_terkecil,pb.nilai_konversi,
                ir.nama as pabrik,stb.nama as satuan_terbesar,stk.nama as satuan_terkecil,sk.nama as kategori,o.kekuatan,
                (SELECT sisa from stok where id_packing_barang=pb.id and id_unit='$_SESSION[id_unit]' order by waktu desc limit 0,1) as sisa
                FROM packing_barang pb
                LEFT JOIN  barang b on b.id=pb.id_barang
                LEFT JOIN  obat o on (o.id = b.id)
                LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                LEFT JOIN  sub_kategori_barang sk on b.id_sub_kategori_barang=sk.id
                LEFT JOIN  kategori_barang k on k.id=sk.id_kategori_barang
                LEFT JOIN  satuan stk on stk.id=pb.id_satuan_terkecil
                LEFT JOIN  satuan stb on stb.id=pb.id_satuan_terbesar
                LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
               $katbarang and locate('$q', b.nama) > 0 order by locate('$q', b.nama) LIMIT 10";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "namabarang") {
        $now = date('Y-m-d');
        $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
			if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where k.id !='0'";
	}
	else{
	$katbarang=" where k.id='" . User::$pemesanan_barang_role . "'";
	}
        $sql = "SELECT
                o.kekuatan,o.generik,sediaan.nama as sediaan,b.id as id_barang,b.nama as nama_barang, pb.id as id,pb.barcode,pb.id_satuan_terbesar,pb.id_satuan_terkecil,pb.nilai_konversi,
                ir.nama as pabrik,stb.nama as satuan_terbesar,stk.nama as satuan_terkecil,sk.nama as kategori,o.kekuatan,
                (SELECT sisa from stok where id_packing_barang=pb.id and id_unit='$_SESSION[id_unit]' order by waktu desc limit 0,1) as sisa
                FROM packing_barang pb
                LEFT JOIN  barang b on b.id=pb.id_barang
                LEFT JOIN  obat o on (o.id = b.id)
                LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                LEFT JOIN  sub_kategori_barang sk on b.id_sub_kategori_barang=sk.id
                LEFT JOIN  kategori_barang k on k.id=sk.id_kategori_barang
                LEFT JOIN  satuan stk on stk.id=pb.id_satuan_terkecil
                LEFT JOIN  satuan stb on stb.id=pb.id_satuan_terbesar
                LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
               $katbarang and locate('$q', b.nama) > 0 order by locate('$q', b.nama) ";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "namabarang3") {
        $where = "";
        $now = date('Y-m-d');
        $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
        if(isset ($_GET['id_barang'])){
            $where = "and b.id = '$_GET[id_barang]'";
        }
		 if(isset ($_GET['batch'])){
            $batch = "and s.batch = '$_GET[batch]'";
        }
        if(isset ($_GET['id_satuan_terbesar'])){
            $where .= " and pb.id_satuan_terbesar = '$_GET[id_satuan_terbesar]'";
        }
		 if (isset($_GET['nofaktur']) && $_GET['nofaktur'] != "") {
            $where = ' AND p.no_faktur="' . $_GET['nofaktur'] . '"';
        }else
            $where="";
				if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where k.id !='0'";
	}
	else{
	$katbarang=" where k.id='" . User::$pemesanan_barang_role . "'";
	}
        $sql = "SELECT
                b.nama as nama_barang,sediaan.nama as sediaan, pb.id as id,pb.barcode,pb.id_satuan_terbesar,pb.id_satuan_terkecil,pb.nilai_konversi,
                ir.nama as pabrik,stb.nama as satuan_terbesar,stk.nama as satuan_terkecil,sk.nama as kategori,o.kekuatan,o.generik
                FROM packing_barang pb
                LEFT JOIN  barang b on b.id=pb.id_barang
                LEFT JOIN  obat o on (o.id = b.id)
                LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                LEFT JOIN  sub_kategori_barang sk on b.id_sub_kategori_barang=sk.id
                LEFT JOIN  kategori_barang k on k.id=sk.id_kategori_barang
                LEFT JOIN  satuan stk on stk.id=pb.id_satuan_terkecil
                LEFT JOIN  satuan stb on stb.id=pb.id_satuan_terbesar
                LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
              $katbarang $where  and locate('$q', b.nama) > 0 group by pb.id  order by locate('$q', b.nama) ";

        $hasil = _select_arr($sql);
	//	echo show_array($hasil);;
		//exit;
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "barang_retur") {
        if (isset($_GET['nofaktur']) && $_GET['nofaktur'] != "") {
            $where = ' AND p.no_faktur="' . $_GET['nofaktur'] . '"';
        }else
            $where="";
				if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
        $sql = "select o.kekuatan,skb.nama as kategori,ir.nama as pabrik,o.generik,sediaan.nama as sediaan,dp.id as id_detail, p.no_faktur, dp.batch,b.nama,pb.id as id_packing,pb.nilai_konversi,stan.nama as satuan_terbesar,stn.nama as satuan_terkecil
        from detail_pembelian dp
            JOIN packing_barang pb on pb.id=dp.id_packing_barang
            JOIN barang b on b.id=pb.id_barang
            LEFT JOIN  obat o on (o.id = b.id)
            LEFT JOIN sediaan on o.id_sediaan=sediaan.id
            JOIN satuan stn on stn.id=pb.id_satuan_terkecil
            JOIN satuan stan on stan.id=pb.id_satuan_terbesar
            JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
            JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
            JOIN pembelian p on p.id=dp.id_pembelian
	    LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
            $katbarang AND b.nama like '%$q%' $where";

        $result = _select_arr($sql);
        die(json_encode($result));
    }else if ($_GET['opsi'] == "barang_reretur") {
        if (isset($_GET['no_retur']) && $_GET['no_retur'] != "") {
            $where = ' AND dp.id_retur_pembelian="' . $_GET['no_retur'] . '"';
        }else
            $where="";
        $sql = "select o.kekuatan,skb.nama as kategori,
            ir.nama as pabrik,o.generik,sediaan.nama as sediaan,
            dp.id as id_detail, p.no_faktur, dp.batch,b.nama,
            pb.id as id_packing,pb.nilai_konversi,stan.nama as satuan_terbesar,
            stk.nama as satuan_terkecil,dp.id_retur_pembelian
        from detail_pembelian dp
            JOIN packing_barang pb on pb.id=dp.id_packing_barang
            JOIN barang b on b.id=pb.id_barang
            LEFT JOIN  obat o on (o.id = b.id)
            LEFT JOIN sediaan on o.id_sediaan=sediaan.id
            JOIN satuan stan on stan.id=pb.id_satuan_terbesar
            JOIN satuan stk on stk.id=pb.id_satuan_terkecil
            JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
            JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
            JOIN pembelian p on p.id=dp.id_pembelian
            LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
            $katbarang AND b.nama like '%$q%' $where and dp.id_retur_pembelian is not null";
        $result = _select_arr($sql);
        die(json_encode($result));
    }else if ($_GET['opsi'] == 'no_retur') {
        die(json_encode(_select_arr("
            select id_retur_pembelian from detail_pembelian 
                where id_packing_barang='$_GET[id_packing]' 
                and id_retur_pembelian is not null ")));
        
    } else if ($_GET['opsi'] == "barang_margin") {
			if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where k.id !='0'";
	}
	else{
	$katbarang=" where k.id='" . User::$pemesanan_barang_role . "'";
	}
        $now = date('Y-m-d');
        $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
        $sql = "SELECT
                b.nama as nama_barang, pb.id as id,pb.id_satuan_terbesar,pb.id_satuan_terkecil,pb.nilai_konversi,ir.nama as pabrik,
                 stb.nama as satuan_terbesar,stk.nama as satuan_terkecil,sk.nama as kategori,o.kekuatan,o.generik,sd.nama as sediaan,
                (SELECT sisa from stok where id_packing_barang=pb.id and id_unit='$_SESSION[id_unit]' order by waktu desc limit 0,1) as sisa
                FROM packing_barang pb
                LEFT JOIN  barang b on b.id=pb.id_barang
                LEFT JOIN  obat o on (o.id = b.id)
                LEFT JOIN  sub_kategori_barang sk on b.id_sub_kategori_barang=sk.id
                LEFT JOIN  kategori_barang k on k.id=sk.id_kategori_barang
                LEFT JOIN sediaan sd on o.id_sediaan = sd.id
                LEFT JOIN  satuan stk on stk.id=pb.id_satuan_terkecil
                LEFT JOIN  satuan stb on stb.id=pb.id_satuan_terbesar
                LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
               $katbarang and locate('$q', b.nama) > 0 order by locate('$q', b.nama)";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } 
		else if($_GET['opsi'] == "batchretur"){
		$idpacking     = $_GET['id_packing'];
    $sql= "select batch from stok where batch like '%$q%' and id_packing_barang='$idpacking'  group by batch";
    $hasil       = _select_arr($sql);
	die(json_encode($hasil));
    }
	else if ($_GET['opsi'] == "namabarang2") {
			if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where k.id !='0'";
	}
	else{
	$katbarang=" where k.id='" . User::$pemesanan_barang_role . "'";
	}
        $sql = "SELECT
                b.nama as nama_barang, pb.id as id, pb.id_satuan_terbesar,pb.id_satuan_terkecil,pb.nilai_konversi,ir.nama as pabrik,
                 stb.nama as satuan_terbesar,stk.nama as satuan_terkecil,sk.nama as kategori,o.kekuatan,
                (SELECT sisa from stok where id_packing_barang=pb.id and id_unit='$_SESSION[id_unit]' order by waktu desc limit 0,1) as sisa
                FROM packing_barang pb
                LEFT JOIN  barang b on b.id=pb.id_barang
                LEFT JOIN  obat o on (o.id = b.id)
                LEFT JOIN  sub_kategori_barang sk on b.id_sub_kategori_barang=sk.id
                LEFT JOIN  kategori_barang k on k.id=sk.id_kategori_barang
                LEFT JOIN  satuan stk on stk.id=pb.id_satuan_terkecil
                LEFT JOIN  satuan stb on stb.id=pb.id_satuan_terbesar
                LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
               $katbarang and locate('$q', b.nama) > 0 order by locate('$q', b.nama) ";

        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "barang_stok") {
        $return = array();
        $where="";
        if(isset($_GET['key']) && $_GET['key']=='batch'){
            if(isset($_GET['batch'])){
                $where.=" AND s.batch like '%$_GET[batch]%' and s.sisa>0";
            }
            if (isset($_GET['id_packing'])) {
                $where.=" AND pb.id='$_GET[id_packing]%'";
            }
        }else{
            $where = "and locate('$q',b.nama)";
        }
			if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
        $sql = _select_arr("select pb.id as id_packing,s.batch,b.nama as barang
           from stok s
           left join packing_barang pb on (s.id_packing_barang=pb.id) join unit u on (s.id_unit=u.id)
           left join jenis_transaksi j on (s.id_jenis_transaksi=j.id) join satuan st on (pb.id_satuan_terkecil=st.id)
           left join barang b on (pb.id_barang=b.id)
           left join sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
           left join kategori_barang kb on kb.id=skb.id_kategori_barang
           $katbarang and s.sisa > 0 $where
           group by pb.id,s.batch
           order by s.id desc,s.waktu desc ");
        foreach($sql as $data) {
            $query = "SELECT s.batch,pb.id as id_packing,s.id as stok,sk.nama as kategori,o.generik,s.batch,s.sisa,pb.id as id_packing,pb.nilai_konversi,st.nama as satuan_terkecil,stn.nama as kemasan,b.nama as barang,ins.nama as pabrik,o.kekuatan,sd.nama as sediaan
            from stok s
            left join packing_barang pb on s.id_packing_barang = pb.id
            left join satuan st on pb.id_satuan_terkecil = st.id
	    left join satuan stn on pb.id_satuan_terbesar = stn.id
            left join barang b on pb.id_barang = b.id
	    LEFT JOIN sub_kategori_barang sk on b.id_sub_kategori_barang=sk.id
            left join obat o on b.id=o.id   
            left join sediaan sd on o.id_sediaan=sd.id        
            left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id where pb.id='$data[id_packing]' and s.batch='$data[batch]' order by s.waktu desc limit 0,1";
            $return[] = _select_unique_result($query);
        }
        die(json_encode($return));
    } else if($_GET['opsi'] == "barang_pemakaian"){
      $idUnit = isset ($_GET['id_unit'])?$_GET['id_unit']:NULL;
        if($idUnit == 1 || $idUnit == 2 || $idUnit == 20){
            $stok = "stok";
        }else{
            $stok = "stok_unit";
        }
        $return = array();
        $sql = mysql_query("select pb.id as id_packing,s.batch as batch from $stok s
            left join packing_barang pb on s.id_packing_barang = pb.id
            left join unit u on s.id_unit = u.id
            left join barang b on pb.id_barang = b.id
            left join instansi_relasi ir on b.id_instansi_relasi_pabrik = ir.id
                left join sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
           left join kategori_barang kb on kb.id=skb.id_kategori_barang
            where b.nama like '%$q%' and s.sisa > 0 and s.id_unit='$idUnit'
            group by pb.id,s.batch order by s.id desc,s.waktu desc");
        while ($data = mysql_fetch_array($sql)) {
            
            $where = "where pb.id='$data[id_packing]' and s.batch='$data[batch]' and s.id_unit='$idUnit' order by s.waktu desc limit 0,1";
            
            $query = "SELECT pb.id as id_packing,
                    s.id as stok,
                    sk.nama as kategori,
                    o.generik,
                    s.batch,
                    s.sisa,
                    pb.id as id_packing,
                    pb.nilai_konversi,
                    stn.nama as satuan_terbesar,
                    st.nama as satuan_terkecil,
                    b.nama as barang,
                    ins.nama as pabrik,
                    o.kekuatan,
                    sd.nama as sediaan from $stok s
            left join packing_barang pb on s.id_packing_barang = pb.id
            left join satuan st on pb.id_satuan_terkecil = st.id
	    left join satuan stn on pb.id_satuan_terbesar = stn.id
            left join barang b on pb.id_barang = b.id
	    LEFT JOIN  sub_kategori_barang sk on b.id_sub_kategori_barang=sk.id
            left join obat o on b.id=o.id   
            left join sediaan sd on o.id_sediaan=sd.id        
            left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id 
            $where ";
            $return[] = _select_unique_result($query);
        }
        die(json_encode($return));
    }else if ($_GET['opsi'] == "unit") {
        $sql = mysql_query("select * from unit where locate('$q',nama) > 0 order by locate('$q',nama)");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "unitDistribusi") {
        $id_user = $_SESSION['id_user'];
        $id_unit = _select_unique_result("SELECT id_unit FROM users WHERE id = $id_user");
        $unit	= _select_unique_result("SELECT nama FROM unit WHERE id = $id_unit[id_unit]");
//        $sql = mysql_query("select * from unit where locate('$q',nama) > 0 and nama not like '%$unit[nama]%' order by locate('$q',nama)");
        $sql = mysql_query("select * from unit where locate('$q',nama) > 0 and id != $id_unit[id_unit] order by locate('$q',nama) ");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "nosp") {
        $sql = mysql_query("
            select p.*,i.id as idInstansi,i.nama as instansi,DATE(p.waktu) as tanggal
            from pemesanan p
            left join instansi_relasi i on (p.id_instansi_relasi_suplier=i.id)
            where
                (
                    select count(*) from detail_pemesanan_faktur dpf
                    JOIN packing_barang pb on pb.id=dpf.id_packing_barang
                    JOIN barang b on b.id=pb.id_barang
                    JOIN sub_kategori_barang subkategori on subkategori.id=b.id_sub_kategori_barang
                    JOIN kategori_barang kategori on kategori.id=subkategori.id_kategori_barang
                    where kategori.id!='0' and dpf.id_pemesanan=p.id
                )>0
                    AND locate('$q',p.id) > 0 order by locate ('$q',p.id) ");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "nofaktur") {
        //pencarian no faktur berdasarkan id_packing
        //join packing barang JANGAN DIGANTI left join, karena id_packing HARUS ditemukan
        $packing = $_GET['id_packing'];
        $suplier = $_GET['id_suplier'];
        $sql = "select no_faktur,ir.nama as suplier,dpr.batch,dpr.jumlah_pembelian,ir.id as id_suplier, p.waktu,st.nama as satuan_terbesar 
        from pembelian p
                left JOIN instansi_relasi ir on ir.id=p.id_instansi_suplier
                LEFT JOIN detail_pembelian dpr on dpr.id_pembelian=p.id
                JOIN packing_barang pb on pb.id=dpr.id_packing_barang
                left join satuan st on pb.id_satuan_terbesar = st.id
                where no_faktur like '%$q%' and pb.id='$packing' and p.id_instansi_suplier='$suplier'
                group by no_faktur ";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "nosp2") {
        $sql = mysql_query("select p.id as nosp,b.nama as nama_barang,pd.jumlah_pesan as jumlah_pesan, s.nama as satuan  from pemesanan p
		JOIN detail_pemesanan_faktur pd on (pd.id_pemesanan=p.id)
		JOIN packing_barang pb on pd.id_packing_barang=pb.id
                JOIN barang b on pb.id_barang=b.id
                JOIN satuan s on pb.id_satuan_terkecil=s.id
		where p.id like '%$q%'");
        $hasil = array();
        $i = 0;
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "barangsp") {
        $sql = mysql_query("select p.id as nosp,b.nama as nama_barang,pd.jumlah_pesan as jumlah_pesan, s.nama as satuan  from pemesanan p
		JOIN detail_pemesanan_faktur pd on (pd.id_pemesanan=p.id)
		JOIN packing_barang pb on pd.id_packing_barang=pb.id
                JOIN barang b on pb.id_barang=b.id
                JOIN sub_kategori_barang subkategori on subkategori.id=b.id_sub_kategori_barang
                JOIN kategori_barang kategori on kategori.id=subkategori.id_kategori_barang
                JOIN satuan s on pb.id_satuan_terkecil=s.id
            where kategori.id!='0' AND b.nama like '%$q%'");
        $hasil = array();
        $i = 0;
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "saksi") {
        $user_pengguna = $_SESSION['nama'];
        $hasil = _select_arr("select p.*,p.nama as nama,ps.nama as profesi, kel.nama as kelurahan, kec.nama as kecamatan, kab.nama as kabupaten
            from penduduk p 
            join dinamis_penduduk dina on (dina.id_penduduk=p.id and dina.akhir=1)
			join pegawai pg on(pg.id=p.id)
            left join profesi ps on ps.id=dina.id_profesi
            left join kelurahan kel on kel.id=dina.id_kelurahan
            left join kecamatan kec on kec.id=kel.id_kecamatan
            left join kabupaten kab on kab.id=kec.id_kabupaten
		where p.nama like '%$q%' and p.nama!='$user_pengguna' order by p.nama ");
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "pegawai") {
        $sql = mysql_query("SELECT * FROM pegawai pgw
            JOIN penduduk pdd on pdd.id=pgw.id
            where pdd.nama like '%$q%'");
        $hasil = array();
        $i = 0;
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "penduduk") {
        $sql = mysql_query("select p.id,p.nama,dp.alamat_jalan from penduduk p join dinamis_penduduk dp on (p.id=dp.id_penduduk)");
        $hasil = array();
        $i = 0;
        while ($data = mysql_fetch_array($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "barang") {
			if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
        $sql = "select b.id,b.nama,kb.nama as kategori,ins.nama as pabrik,o.kekuatan, o.generik,
            sd.nama as sediaan from barang b
                left join obat o on b.id=o.id
                left join sediaan sd on o.id_sediaan=sd.id
                left JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                left JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
                left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
                $katbarang AND locate('$q', b.nama) > 0 order by locate('$q', b.nama)
				";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if($_GET['opsi'] == "data_kategori_tarif"){
         $sql_tarif = "select * from kategori_tarif where locate('$q', nama) > 0 order by locate('$q',nama) ";
         $hasil = _select_arr($sql_tarif);
        die(json_encode($hasil));
    }else if($_GET['opsi'] == "data_kategori_pelayanan"){
         $sql_tarif = "select * from layanan where locate('$q', nama) > 0 order by locate('$q',nama)";
         $hasil = _select_arr($sql_tarif);
        die(json_encode($hasil));
    }else if ($_GET['opsi'] == "packing_barang") {
        if(isset ($_GET['id_barang'])){
            $action = "and b.id='$_GET[id_barang]'";
        }else $action = "";
        
        $now = date('Y-m-d');
        $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
			if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
        $query = "SELECT p.id as id_packing, o.generik, o.kekuatan,sediaan.nama as sediaan,
            ir.nama as pabrik,p . *, 
            s.waktu, s.sisa, s.id_unit, s.id as stok, s.batch, b.nama as barang,b.id as id_barang, st1.nama as satuan_terkecil, st2.nama as satuan_terbesar, skb.nama as kategori
                            FROM packing_barang p
                            LEFT JOIN stok s ON ( p.id = s.id_packing_barang )
                            LEFT JOIN barang b ON (p.id_barang=b.id)
                            LEFT JOIN  obat o on (o.id = b.id)
                            LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                            LEFT JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                            LEFT JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
                            left join satuan st1 on (p.id_satuan_terkecil = st1.id)
                            left join satuan st2 on (p.id_satuan_terbesar = st2.id)
                            LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
                $katbarang  AND  b.nama like '%$q%'
                and s.waktu = (select max(waktu) from stok where id_unit='$_SESSION[id_unit]' and id_packing_barang=p.id) $action ";
        /*and s.waktu = (select max(waktu) from stok where id_unit='$_SESSION[id_unit]' and id_packing_barang=p.id)*/ // jika di perlukan silahkan di tambahkan pada query
       // echo $query; die;
        $hasil = _select_arr($query);
        die(json_encode($hasil));
    } 
	else if ($_GET['opsi'] == "packing_barang_distribusi") {
        if(isset ($_GET['id_barang'])){
            $action = "and b.id='$_GET[id_barang]'";
        }else $action = "";
        
        $now = date('Y-m-d');
        $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
			if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
        $query = "SELECT p.id as id_packing, o.generik, o.kekuatan,sediaan.nama as sediaan,
            ir.nama as pabrik,p . *, 
            s.waktu, s.sisa, s.id_unit, s.id as stok, s.batch,s.ed,b.nama as barang,b.id as id_barang, st1.nama as satuan_terkecil, st2.nama as satuan_terbesar, skb.nama as kategori
                            FROM packing_barang p
                            LEFT JOIN stok s ON ( p.id = s.id_packing_barang )
                            LEFT JOIN barang b ON (p.id_barang=b.id)
                            LEFT JOIN  obat o on (o.id = b.id)
                            LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                            LEFT JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                            LEFT JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
                            left join satuan st1 on (p.id_satuan_terkecil = st1.id)
                            left join satuan st2 on (p.id_satuan_terbesar = st2.id)
                            LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
                $katbarang  AND  b.nama like '%$q%'
                and s.waktu = (select max(waktu) from stok where id_unit='$_SESSION[id_unit]' and id_packing_barang=p.id) $action";
        /*and s.waktu = (select max(waktu) from stok where id_unit='$_SESSION[id_unit]' and id_packing_barang=p.id)*/ // jika di perlukan silahkan di tambahkan pada query
       // echo $query; die;
	   
        $hasil = _select_arr($query);
		//show_array($hasil);
		$apa=array();
		foreach($hasil as $key => $content){
		if($content['ed']!="0000-00-00"){
			$apa[] = $content;
		}
		}
        die(json_encode($apa));
    }
	else if ($_GET['opsi'] == "packing_barang_stok") {
        //mencari packing barang dengan stok!=0
        if(isset ($_GET['id_barang'])){
            $action = "and b.id='$_GET[id_barang]'";
        }else $action = "";
        
        $now = date('Y-m-d');
        $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
        if(User::$pemesanan_barang_role == '')
            $katbarang=" where kb.id !='0'";
        else
            $katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";

        $query = "SELECT p.id as id_packing, o.generik, o.kekuatan,sediaan.nama as sediaan,
            ir.nama as pabrik,p . *,p.id_satuan_terkecil, 
            s.waktu, s.sisa, s.id_unit,s.batch, s.id as stok, s.hpp, s.hna, b.nama as barang,b.id as id_barang, st1.nama as satuan_terkecil, st2.nama as satuan_terbesar, skb.nama as kategori,s.ed as ed
                            FROM packing_barang p
                            LEFT JOIN stok s ON ( p.id = s.id_packing_barang and s.sisa<>0)
                            LEFT JOIN barang b ON (p.id_barang=b.id)
                            LEFT JOIN  obat o on (o.id = b.id)
                            LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                            LEFT JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                            LEFT JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
                            left join satuan st1 on (p.id_satuan_terkecil = st1.id)
                            left join satuan st2 on (p.id_satuan_terbesar = st2.id)
                            LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
                $katbarang  AND  b.nama like '%$q%'
                and s.waktu = (select max(waktu) from stok where id_unit='$_SESSION[id_unit]' and id_packing_barang=p.id) $action ";
        /*and s.waktu = (select max(waktu) from stok where id_unit='$_SESSION[id_unit]' and id_packing_barang=p.id)*/ // jika di perlukan silahkan di tambahkan pada query
       // echo $query; die;
        $hasil = _select_arr($query);
		$apa=array();
		foreach($hasil as $key => $content){
		if($content['ed']!="0000-00-00"){
			$apa[] = $content;
		}
		}
        die(json_encode($apa));
    } 
	 else if ($_GET['opsi'] == "pecah-stok")
{
	     if(isset ($_GET['id_barang'])){
            $action = "and b.id='$_GET[id_barang]'";
        }else $action = "";
		 $now = date('Y-m-d');
        $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
	    if(User::$pemesanan_barang_role == '4')
            $katbarang=" where kb.id !=''";
        else
            $katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	$query	= "SELECT p.id as id_packing, 
                o.generik, 
                o.kekuatan,
                sediaan.nama as sediaan,
                ir.nama as pabrik,
                p . *,
                p.id_satuan_terkecil, 
                s.waktu, 
                s.sisa, 
                s.id_unit, 
                s.id as stok, 
                s.hpp, 
                s.hna,
                s.margin as margin, 
                b.nama as barang,
                p.id as id_barang, 
                st1.nama as satuan_terkecil, 
                st2.nama as satuan_terbesar, 
                skb.nama as kategori,
                p.nilai_konversi
                            FROM packing_barang p
                            JOIN stok_unit s ON (p.id = s.id_packing_barang and s.sisa<>0 and s.id_unit=$_SESSION[id_unit])
                            LEFT JOIN barang b ON (p.id_barang=b.id)
                            JOIN  obat o on (o.id = b.id)
                            LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                            LEFT JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                            LEFT JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
                            left join satuan st1 on (p.id_satuan_terkecil = st1.id)
                            left join satuan st2 on (p.id_satuan_terbesar = st2.id)
                            LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
                $katbarang  AND  b.nama like '%$q%'
                and s.waktu = (select max(waktu) from stok_unit where id_packing_barang=p.id and id_unit=$_SESSION[id_unit])";
        
        //and s.waktu = (select max(waktu) from stok where id_unit='$_SESSION[id_unit]' and id_packing_barang=p.id)*/ // jika di perlukan silahkan di tambahkan pada query
       // echo $query; die;*/
        $hasil = _select_arr($query);
	
        die(json_encode($hasil));
}
    else if ($_GET['opsi'] == "no_batch_stok") {
     $query = "select sisa,ed,lead_time,batch from stok where waktu = (select max(su.waktu) from stok su where su.id_packing_barang='$_GET[id_barang]' and su.batch !='') and id_packing_barang='$_GET[id_barang]' and batch !=''";
        $hasil = _select_unique_result($query);
	
        die(json_encode($hasil));
    }
    else if ($_GET['opsi'] == "no_batch_stok_untuk_pecah_stok") {
     $query = "
        select su.id,su.sisa,s.ed,su.batch,stu.nama as satuan_terbesar from stok_unit su
        join stok s on(su.id_packing_barang=s.id_packing_barang and s.batch=su.batch)
        join packing_barang p on(su.id_packing_barang=p.id)
        left join satuan stu on (p.id_satuan_terbesar = stu.id)
        where su.id_packing_barang='$_GET[id_packing]' and su.id_unit=$_SESSION[id_unit] and su.id = (select max(id) from stok_unit where id_packing_barang=$_GET[id_packing] and batch=su.batch and id_unit=$_SESSION[id_unit]) group by su.id";
     $hasil = _select_arr($query);
        die(json_encode($hasil));
    }
	else if ($_GET['opsi'] == "distribusi") {
     $query = "select distribusi.*,unit.nama as unit_tujuan from distribusi
        JOIN unit on unit.id=distribusi.id_unit_tujuan
        where distribusi.id like '%$q%' and distribusi.id_unit_tujuan = '$_SESSION[id_unit]' ";
        die(json_encode(_select_arr($query)));
    } else if ($_GET['opsi'] == "penerimaan_unit_retur") {
	if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
                $katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
        $sql = "select distinct o.kekuatan,skb.nama as kategori,ir.nama as pabrik,o.generik,sediaan.nama as sediaan,stk.batch as batch,
                b.nama,pb.id as id_packing,pb.nilai_konversi,dpuru.jumlah_retur_penerimaan_unit as jumlah_retur,
                stan.nama as satuan_terbesar,stn.nama as satuan_terkecil
                FROM packing_barang pb
                JOIN barang b on b.id=pb.id_barang
		join detail_penerimaan_unit_retur_unit dpuru on(dpuru.id_packing_barang=pb.id)
                LEFT JOIN  obat o on (o.id = b.id)
                LEFT JOIN sediaan on o.id_sediaan=sediaan.id
		LEFT JOIN stok stk on (stk.id_packing_barang=pb.id)
                JOIN satuan stn on stn.id=pb.id_satuan_terkecil
                JOIN satuan stan on stan.id=pb.id_satuan_terbesar
                JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
                LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
                $katbarang AND b.nama like '%$q%' and dpuru.batch=(select distinct batch from stok where id_packing_barang=stk.id_packing_barang and batch=stk.batch)
                and dpuru.id_retur_unit is NOT NULL ";
        $result = _select_arr($sql);
        die(json_encode($result));
    }else if($_GET['opsi'] == "batch_penerimaan_unit_retur"){
        $query = "select distinct batch from detail_penerimaan_unit_retur_unit where id_packing_barang='$_GET[id_packing]' and batch like '%$q%' ";
        $result = _select_arr($query);
        die(json_encode($result));
    }  else if ($_GET['opsi'] == "barang_unit_retur") {
        if(User::$pemesanan_barang_role == '4'){
            $katbarang=" where kb.id !='0' and (dp.batch is NOT NULL or dp.batch!='')";
	}
	else{
            $katbarang=" where kb.id='" . User::$pemesanan_barang_role . "' and (dp.batch is NOT NULL or dp.batch!='')";
	}
        $sql = "select o.kekuatan,skb.nama as kategori,ir.nama as pabrik,o.generik,sediaan.nama as sediaan,
                dp.id as id_detail, b.nama,pb.id as id_packing,pb.nilai_konversi,p.id as no_penerimaan,
                stan.nama as satuan_terbesar,stn.nama as satuan_terkecil,dp.id as id_detail,dp.batch
                from detail_penerimaan_unit_retur_unit dp
                    JOIN packing_barang pb on pb.id=dp.id_packing_barang
                    JOIN barang b on b.id=pb.id_barang
                    LEFT JOIN  obat o on (o.id = b.id)
                    LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                    JOIN satuan stn on stn.id=pb.id_satuan_terkecil
                    JOIN satuan stan on stan.id=pb.id_satuan_terbesar
                    JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                    JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
                    JOIN penerimaan_unit p on p.id=dp.id_penerimaan_unit
                    LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
            $katbarang AND b.nama like '%$q%'  ";
        
        $result = _select_arr($sql);
        die(json_encode($result));
    }
else if ($_GET['opsi'] == "barang_unit_retur2") {
	$idUnit = $_SESSION['id_unit'];
        if(User::$pemesanan_barang_role == '4'){
            $katbarang=" where kb.id !='0' and (dp.batch is NOT NULL or dp.batch!='')";
	}
	else{
	
            $katbarang=" where kb.id='" . User::$pemesanan_barang_role . "' and (dp.batch is NOT NULL or dp.batch!='')";
	}
        $sql = "select o.kekuatan,skb.nama as kategori,ir.nama as pabrik,o.generik,sediaan.nama as sediaan,
                dp.id as id_detail, b.nama,pb.id as id_packing,pb.nilai_konversi,p.id as no_penerimaan,
                stan.nama as satuan_terbesar,stn.nama as satuan_terkecil,dp.id as id_detail,stku.batch,stku.sisa as sisa
                from detail_penerimaan_unit_retur_unit dp
                    JOIN packing_barang pb on pb.id=dp.id_packing_barang
					JOIN stok_unit stku on stku.id_packing_barang=pb.id
                    JOIN barang b on b.id=pb.id_barang
                    LEFT JOIN  obat o on (o.id = b.id)
                    LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                    JOIN satuan stn on stn.id=pb.id_satuan_terkecil
                    JOIN satuan stan on stan.id=pb.id_satuan_terbesar
                    JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                    JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
                    JOIN penerimaan_unit p on p.id=dp.id_penerimaan_unit
                    LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
            $katbarang AND b.nama like '%$q%' and stku.id_unit = '$idUnit' and stku.id=(select max(id) from stok_unit where id_packing_barang=pb.id and id_unit = '$idUnit' and batch=stku.batch) group by stku.id_packing_barang,stku.batch";
        
        $result = _select_arr($sql);
		$apa=array();
		foreach($result as $key => $content){
		if($content['sisa']>0){
			$apa[] = $content;
		}
		}
        die(json_encode($apa));
	
    }
    else if ($_GET['opsi'] == "caridokter") {
        //join pegawai menunjukkan dokter adalah pegawai rumah sakit
        $query = mysql_query("select p.*,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan, kab.nama as kabupaten, prov.nama as provinsi
        from dokter d 
        join penduduk p on d.id = p.id
        join dinamis_penduduk dp on (p.id = dp.id_penduduk)
        join kelurahan kel on kel.id=dp.id_kelurahan
        JOIN kecamatan kec on kec.id=kel.id_kecamatan
        JOIN kabupaten kab on kab.id=kec.id_kabupaten
        JOIN provinsi prov on prov.id=kab.id_provinsi
        where p.nama like '%$q%' and dp.akhir = 1 ");

        $hasil = array();
        $i = 0;
        while ($data = mysql_fetch_array($query)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    }
    else if ($_GET['opsi'] == "caridokter_penjualan") {
        //join pegawai menunjukkan dokter adalah pegawai rumah sakit
        $query = mysql_query("select p.*,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan, kab.nama as kabupaten, prov.nama as provinsi
        from penduduk p
        join pegawai on pegawai.id=p.id
        join dinamis_penduduk dp on (p.id = dp.id_penduduk)
        join kelurahan kel on kel.id=dp.id_kelurahan
        JOIN kecamatan kec on kec.id=kel.id_kecamatan
        JOIN kabupaten kab on kab.id=kec.id_kabupaten
        JOIN provinsi prov on prov.id=kab.id_provinsi

        where dp.id_profesi = '3' AND p.nama like '%$q%' and dp.akhir = 1");

        $hasil = array();
        $i = 0;
        while ($data = mysql_fetch_array($query)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } 

    else if ($_GET['opsi'] == "satuan") {
        $query = mysql_query("select * from satuan where locate('$q', nama) > 0 order by locate('$q', nama)");

        $hasil = array();
        $i = 0;
        while ($data = mysql_fetch_array($query)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "bed") {
        $query = mysql_query("select b.*,k.nama as kelas,i.nama as instalasi from bed b left join kelas k on b.id_kelas=k.id left join instalasi i on b.id_instalasi=i.id where locate('$q', b.nama) > 0 order by locate('$q', b.nama)");

        $hasil = array();
        $i = 0;
        while ($data = mysql_fetch_array($query)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "tmppraktek") {
        $query = mysql_query("select i.nama, i.id, j.nama as jenis, i.alamat from instansi_relasi i join jenis_instansi_relasi j on (i.id_jenis_instansi_relasi = j.id)");

        $hasil = array();
        $i = 0;
        while ($data = mysql_fetch_array($query)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "barang-resep") {

        if ($_GET['kelas'] != '') {
            $kelas = "and k.id ='$_GET[kelas]'";
        } else {
            $kelas = "and k.nama = 'Tanpa Kelas'";
        }
        $sql = "select sk.nama as kategori,o.kekuatan,o.generik,st.sisa,sediaan.nama as sediaan,p.id as id_packing,st.batch as batch,
                b.nama, b.id, i.nama as pabrik, p.id as id_packing, k.nama as kelas, k.id as id_kelas, o.kekuatan,
                p.nilai_konversi, s.nama as satuan_terkecil,st.hna, (st.hna+((k.margin/100)*st.hna)) as harga, k.margin as nilai_persentase
		from kelas k,barang b 
		left join instansi_relasi i on (i.id = b.id_instansi_relasi_pabrik)
		left join obat o on (b.id=o.id)
		Left join sediaan on o.id_sediaan=sediaan.id
		left join packing_barang p on (p.id_barang = b.id)
		left join stok_unit st on (st.id_packing_barang = p.id)		                		
		left join satuan s on (s.id = p.id_satuan_terkecil)
		left join sub_kategori_barang sk on (b.id_sub_kategori_barang=sk.id) 
		left join kategori_barang kb on (sk.id_kategori_barang=kb.id) 
		where b.id>0 $kelas		
                and locate('$q', b.nama) > 0 and st.id_unit = '$_SESSION[id_unit]' and sk.permit_penjualan='Bisa'
		and st.sisa >0 and st.batch !='' and st.id = (select max(id) from stok_unit where id_packing_barang = st.id_packing_barang and batch = st.batch and id_unit = '$_SESSION[id_unit]')
		order by locate('$q', b.nama)";
        //group by st.batch
        //echo $sql;
        $hasil=_select_arr($sql);
        die(json_encode($hasil));
    }
    else if ($_GET['opsi'] == "produksi-data") {

//        $sql = "select sk.nama as kategori,o.kekuatan,o.generik,st.sisa,sediaan.nama as sediaan,p.id as id_packing, b.nama, b.id, i.nama as pabrik, p.id as id_packing, k.nama as kelas, mp.id_kelas, o.kekuatan, p.nilai_konversi, s.nama as satuan_terkecil, (st.hna+((mp.nilai_persentase/100)*st.hna)) as harga, mp.nilai_persentase
//		from barang b
//		left join instansi_relasi i on (i.id = b.id_instansi_relasi_pabrik)
//		left join obat o on (b.id=o.id)
//		Left join sediaan on o.id_sediaan=sediaan.id
//		left join packing_barang p on (p.id_barang = b.id)
//		left join stok_unit st on (st.id_packing_barang = p.id)
//		left join margin_packing_barang_kelas mp on(mp.id_packing_barang = p.id)
//		left join kelas k on (k.id = mp.id_kelas)
//		left join satuan s on (s.id = p.id_satuan_terkecil)
//		left join sub_kategori_barang sk on (b.id_sub_kategori_barang=sk.id)
//		left join kategori_barang kb on (sk.id_kategori_barang=kb.id)
//		where kb.id ='".User::$pemesanan_barang_role."' and mp.id_kelas = (select id from kelas where nama = 'Tanpa Kelas')
//		and st.id_packing_barang in (select id_packing_barang from stok where id in (select max(id) from stok group by id_packing_barang))  and locate('$q', b.nama) > 0 group by p.id order by locate('$q', b.nama)";              
        	if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
        $sql="select pb.id as id_packing,b.nama as barang,s.id as stok,(s.hna+((k.margin/100)*s.hna)) as harga,
            skb.nama as kategori,o.generik,s.sisa,pb.id as id_packing,pb.nilai_konversi,st.nama as satuan_terkecil,
            stn.nama as kemasan,b.nama as barang,ins.nama as pabrik,o.kekuatan,sd.nama as sediaan
           from kelas k,stok_unit s
           left join packing_barang pb on (s.id_packing_barang=pb.id)
           left join unit u on (s.id_unit=u.id)           
           left join jenis_transaksi j on (s.id_jenis_transaksi=j.id)           
           left join barang b on (pb.id_barang=b.id)
	   left join satuan st on pb.id_satuan_terkecil = st.id
	   left join satuan stn on pb.id_satuan_terbesar = stn.id
           left join sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
           left join kategori_barang kb on kb.id=skb.id_kategori_barang
	   left join obat o on b.id=o.id   
           left join sediaan sd on o.id_sediaan=sd.id        
           left join instansi_relasi ins on b.id_instansi_relasi_pabrik
           $katbarang  and k.nama = 'Tanpa Kelas' and s.id_unit = '$_SESSION[id_unit]' and locate('a',b.nama) and s.id in
	(select max(su.id) from stok_unit su where su.id_packing_barang=pb.id) and	
		s.sisa > 0 group by pb.id
           order by s.id desc,s.waktu desc ";
        
        $hasil=_select_arr($sql);
        die(json_encode($hasil));
    }
    else if ($_GET['opsi'] == 'nopenjualan') {
        $sql = "select r.id as nopenjualan, drp.no_resep, pd.nama as dokter, pd.id as id_dokter,p.id as id_penduduk_pasien,kls.nama as nama_kelas,
        ps.id as norm, p.nama as nama_pasien, b.id_kelas, r.*, pj.jenis, dp.alamat_jalan from penjualan r
                join detail_penjualan_retur_penjualan dprp on (dprp.id_penjualan=r.id)
		left join penduduk p on (p.id = r.id_penduduk_pembeli)
		left join penduduk pd on (pd.id = r.id_penduduk_dokter)
		join detail_resep_penjualan drp on (drp.id_detail_penjualan_retur_penjualan = dprp.id)
		join penjualan pj on (pj.id = dprp.id_penjualan)
		join penduduk pdk on (pdk.id = pj.id_penduduk_pembeli)
		join pasien ps on (ps.id_penduduk = pdk.id)
		join kunjungan k on (k.id_pasien = ps.id)
		join bed b on (b.id = k.id_bed)
		join dinamis_penduduk dp on (dp.id_penduduk = p.id)
		left join kelas kls on (kls.id = b.id_kelas)
		where r.id like ('%$q%') and dp.akhir = '1' group by r.id";
        $query = _select_arr($sql);
        die(json_encode($query));
    }
    else if ($_GET['opsi'] == "noresep") {

        $sql = "
		select r.id as nopenjualan, drp.no_resep, pd.nama as dokter, pd.id as id_dokter,p.id as id_penduduk_pasien,kls.nama as nama_kelas,
        ps.id as norm, p.nama as nama_pasien, b.id_kelas, r.*, pj.jenis, dp.alamat_jalan from penjualan r 
                join detail_penjualan_retur_penjualan dprp on (dprp.id_penjualan=r.id)
		left join penduduk p on (p.id = r.id_penduduk_pembeli)
		left join penduduk pd on (pd.id = r.id_penduduk_dokter)
		join detail_resep_penjualan drp on (drp.id_detail_penjualan_retur_penjualan = dprp.id)
		join penjualan pj on (pj.id = dprp.id_penjualan)
		join penduduk pdk on (pdk.id = pj.id_penduduk_pembeli)
		join pasien ps on (ps.id_penduduk = pdk.id)
		join kunjungan k on (k.id_pasien = ps.id)
		join bed b on (b.id = k.id_bed)
		join dinamis_penduduk dp on (dp.id_penduduk = p.id)
		left join kelas kls on (kls.id = b.id_kelas)
		where drp.no_resep = '$q' and dp.akhir = '1' group by drp.no_resep ";
        //echo $sql;
        

        $hasil = _select_arr($sql);
        
        
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'no_penjualan') {
        $sql = "select p.id as no_penjualan, pembeli.nama as pembeli from penjualan p
            LEFT JOIN penduduk pembeli on pembeli.id=p.id_penduduk_pembeli where p.id = '$q'";
        $exe = _select_arr($sql);
        die(json_encode($exe));
        
    } else if ($_GET['opsi'] == 'kodepenjualan') {
        $sql = "select p.*,pd.nama,
                (select count(distinct drp1.no_r) from detail_resep_penjualan drp1 where drp1.id_detail_penjualan_retur_penjualan=dprp.id)*drp.biaya_apoteker as biaya_apoteker
                from penjualan p
                LEFT JOIN penduduk pd on (pd.id=p.id_penduduk_pembeli)
                left join detail_penjualan_retur_penjualan dprp on (dprp.id_penjualan=p.id)
                LEFT JOIN detail_resep_penjualan drp on (drp.id_detail_penjualan_retur_penjualan=dprp.id)
                where p.id = '$q' ";
        $exe=array();
        $result = _select_arr($sql);
            if(!empty ($result)){
                $sql="select count(distinct drp.no_r)*drp.biaya_apoteker as biaya_apoteker
                        from penjualan p
                        LEFT JOIN penduduk pd on (pd.id=p.id_penduduk_pembeli)
                        left join detail_penjualan_retur_penjualan dprp on (dprp.id_penjualan=p.id)
                        LEFT JOIN detail_resep_penjualan drp on (drp.id_detail_penjualan_retur_penjualan=dprp.id)
                        where p.id = '$q'";
                $biaya_apoteker_total=  _select_unique_result($sql);
                $exe[0]=$result[0];
                $exe[0]['biaya_apoteker_total']=$biaya_apoteker_total[0];
            }
            die(json_encode($exe));
        
    }else if ($_GET['opsi'] == 'kodetemppenjualan') {
    $sql = "   select 
                distinct tp.id,tp.id_penduduk_dokter as id_dokter,tp.catatan,
                tp.id_penduduk_pembeli as id_pembeli,pdd2.nama as nama_dokter,pas.id as no_rm,pdd.nama as nama_pembeli,
                kls.id as id_kelas,kls.nama as kelas,date(tp.waktu) as waktu,tp.jenis
                from temp_penjualan tp
                left join penduduk pdd on (pdd.id=tp.id_penduduk_pembeli)
                left join pasien pas on (pas.id_penduduk=pdd.id)
                left join kunjungan kjg on(kjg.id_pasien=pas.id)
                left join bed on(bed.id=kjg.id_bed)
                left join kelas kls on (kls.id = bed.id_kelas)
                left join temp_detail_penjualan_retur tdpr on(tdpr.id_temp_penjualan=tp.id)
                left join temp_detail_resep tdr on(tdr.id_temp_detail_penjualan_retur=tp.id)
                left join penduduk pdd2 on (pdd2.id=tp.id_penduduk_dokter)
                where tp.id=$q order by kjg.id desc limit 1";
        $exe = _select_arr($sql);
        if(!empty($exe)){
            $exe[0]['tanggal']=datefmysql($exe[0]['waktu']);
        }
        die(json_encode($exe));
        
    }else if ($_GET['opsi'] == 'nama') {
        $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : NULL;
        if ($jenis == 'bebas') {
            $sql = "select k.status as status_kunjungan,ps.id as id_pasien, pd.id as id_penduduk, pd.nama as nama_pas, pd.jenis_kelamin,dp.*, kl.nama as nama_kelurahan, kab.nama as kabupaten, kec.nama as kecamatan, pro.nama as provinsi from penduduk pd
            left join pasien ps on (pd.id = ps.id_penduduk)
            left JOIN kunjungan k on (k.id_pasien=ps.id and k.id=(select max(id) from kunjungan where kunjungan.id_pasien=ps.id))
            left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
            left join kelurahan kl on(dp.id_kelurahan = kl.id)
            left join kecamatan kec on kl.id_kecamatan = kec.id
            left join kabupaten kab on kec.id_kabupaten = kab.id
            left join provinsi pro on kab.id_provinsi = pro.id
            where locate('$q', pd.nama) > 0 and dp.akhir = '1' order by locate('$q', pd.nama) 
        ";
        } else {
            $sql = "select k.status as status_kunjungan,kls.nama as nama_kelas, bed.id_kelas, ps.id as id_pasien, p.id as id_penduduk, p.nama as nama_pas, p.jenis_kelamin, p.gol_darah, dp.*, kl.nama as nama_kelurahan, kab.nama as kabupaten, kec.nama as kecamatan, pro.nama as provinsi, pr.id as id_pro, pr.nama as nama_pro, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, dp.id_agama,concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir
            from penduduk p
            join pasien ps on (p.id = ps.id_penduduk)
            left JOIN kunjungan k on (k.id_pasien=ps.id  and k.id=(select max(id) from kunjungan where kunjungan.id_pasien=ps.id))
            left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
            left join kelurahan kl on(dp.id_kelurahan = kl.id)
            left join profesi pr on(pr.id = dp.id_profesi)
            left join bed bed on (k.id_bed = bed.id)
            left join agama ag on(ag.id = dp.id_agama)
            left join kelas kls on (kls.id = bed.id_kelas)
            left join kecamatan kec on kl.id_kecamatan = kec.id
            left join kabupaten kab on kec.id_kabupaten = kab.id
            left join provinsi pro on kab.id_provinsi = pro.id
            where k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and locate('$q', p.nama) > 0 and dp.akhir = '1' order by locate('$q', p.nama) ";
        }
        $exe = mysql_query($sql);
        $hasil = array();
        while ($data = mysql_fetch_object($exe)) {
            if($data->status_kunjungan!='Keluar')
//            show_array($data);
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    }else if($_GET['opsi'] == 'billingPasien'){
        $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : NULL;
        if ($jenis == 'bebas') {
            $sql = "select ps.id as id_pasien, pd.id as id_penduduk, pd.nama as nama_pas, kec.nama as kecamatan, kab.nama as kabupaten, prov.nama as provinsi, pd.jenis_kelamin,dp.*, kl.nama as nama_kelurahan,k.rencana_cara_bayar as carabayar,k.no_kunjungan_pasien,k.id as id_kunjungan ,   (select max(id) from billing where id_pasien=ps.id) as id_billing from penduduk pd
			left join pasien ps on (pd.id = ps.id_penduduk)
			left join kunjungan k on (ps.id = kj.id_pasien)
			left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
			left join kelurahan kl on(dp.id_kelurahan = kl.id)
                        left join kecamatan kec on kl.id_kecamatan = kec.id
                        left join kabupaten kab on kec.id_kabupaten = kab.id
                        left join provinsi prov on kab.id_provinsi = prov.id
			where locate('$q', pd.nama) > 0 order by locate('$q', p.nama)
		";
        } else {
            $sql = "select kls.nama as nama_kelas, bed.id_kelas, ps.id as id_pasien, kec.nama as kecamatan, kab.nama as kabupaten, prov.nama as provinsi, p.id as id_penduduk, p.nama as nama_pas, p.jenis_kelamin, p.gol_darah, dp.*, kl.nama as nama_kelurahan, pr.id as id_pro, pr.nama as nama_pro, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, dp.id_agama,concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir,k.rencana_cara_bayar as carabayar,k.no_kunjungan_pasien,k.id as id_kunjungan,   (select max(id) from billing where id_pasien=ps.id) as id_billing 
            from penduduk p
            join pasien ps on (p.id = ps.id_penduduk)
			left join kunjungan k on (k.id_pasien = ps.id)
			left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
			left join kelurahan kl on(dp.id_kelurahan = kl.id)
                        left join kecamatan kec on kl.id_kecamatan = kec.id
                        left join kabupaten kab on kec.id_kabupaten = kab.id
                        left join provinsi prov on kab.id_provinsi = prov.id
			left join profesi pr on(pr.id = dp.id_profesi)
			left join bed bed on (k.id_bed = bed.id)
                        left join agama ag on(ag.id = dp.id_agama)
			left join kelas kls on (kls.id = bed.id_kelas)
            where k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and locate('$q', p.nama) > 0 and dp.akhir = '1' order by locate('$q', p.nama)";
        }
        $exe = _select_arr($sql);
        die(json_encode($exe));
    } 
    else if ($_GET['opsi'] == 'nama-penjualan') {
        $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : NULL;
        if ($jenis == 'bebas') {
            $sql = "select ps.id as id_pasien, pd.id as id_penduduk, kec.nama as kecamatan, kab.nama as kabupaten, prov.nama as provinsi, pd.nama as nama_pas, pd.jenis_kelamin,dp.*, kl.nama as nama_kelurahan from penduduk pd
			 join pasien ps on (pd.id = ps.id_penduduk)
			left join kunjungan k on (k.id_pasien = ps.id)
			left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
			left join kelurahan kl on(dp.id_kelurahan = kl.id)
                        left join kecamatan kec on kl.id_kecamatan = kec.id
                        left join kabupaten kab on kec.id_kabupaten = kab.id
                        left join provinsi prov on kab.id_provinsi = prov.id
			where k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and locate('$q', pd.nama) > 0 order by locate('$q', pd.nama) LIMIT 10
		";
        } else {
            $sql = "select kls.nama as nama_kelas, bed.id_kelas, kec.nama as kecamatan, kab.nama as kabupaten, prov.nama as provinsi, ps.id as id_pasien, p.id as id_penduduk, p.nama as nama_pas, p.jenis_kelamin, p.gol_darah, dp.*, kl.nama as nama_kelurahan, pr.id as id_pro, pr.nama as nama_pro, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, dp.id_agama,concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir
            from penduduk p
            join pasien ps on (p.id = ps.id_penduduk)
			left join kunjungan k on (k.id_pasien = ps.id)
			left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
			left join kelurahan kl on(dp.id_kelurahan = kl.id)
                        left join kecamatan kec on kl.id_kecamatan = kec.id
                        left join kabupaten kab on kec.id_kabupaten = kab.id
                        left join provinsi prov on kab.id_provinsi = prov.id
			left join profesi pr on(pr.id = dp.id_profesi)
			left join bed bed on (k.id_bed = bed.id)
                        left join agama ag on(ag.id = dp.id_agama)
			left join kelas kls on (kls.id = bed.id_kelas)
            where k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and locate('$q', p.nama) > 0 and dp.akhir = '1' order by locate('$q', p.nama) LIMIT 10";
        }
        $exe = _select_arr($sql);
        die(json_encode($exe));
    }
	else if($_GET['opsi'] == 'asuransi_penjualan'){ 
        
        if(isset ($_GET['id_pasien'])){
            if(!empty ($_GET['id_pasien'])){
                
                $sql="
                    select akk.id as id_asuransi, ap.nama as nama_asuransi
                    from kunjungan k
                    left join asuransi_kepesertaan_kunjungan akk on akk.id_kunjungan=k.id
                    left join asuransi_produk ap on ap.id=akk.id_asuransi_produk
                    where k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and k.id_pasien=".$_GET['id_pasien'];
                $hasil=_select_arr($sql);
                die(json_encode($hasil));
            }
        }
    }
    else if ($_GET['opsi'] == 'noRm') {
        $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : NULL;
        if ($jenis == 'bebas') {
            $sql = "select ps.id as id_pasien, pd.id as id_penduduk, kec.nama as kecamatan, kab.nama as kabupaten, prov.nama as provinsi, pd.nama as nama_pas, pd.jenis_kelamin,dp.*, kl.nama as nama_kelurahan,k.rencana_cara_bayar as carabayar,k.no_kunjungan_pasien,k.id as id_kunjungan ,   (select max(id) from billing where id_pasien=ps.id) as id_billing from penduduk pd
			left join pasien ps on (pd.id = ps.id_penduduk)
			left join kunjungan k on (ps.id = kj.id_pasien)
			left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
			left join kelurahan kl on(dp.id_kelurahan = kl.id)
                        left join kecamatan kec on kl.id_kecamatan = kec.id
                        left join kabupaten kab on kec.id_kabupaten = kab.id
                        left join provinsi prov on kab.id_provinsi = prov.id
			where locate('$q', ps.id) > 0 order by locate('$q', ps.id) LIMIT 10
		";
        } else {
            $sql = "select kls.nama as nama_kelas, bed.id_kelas, kec.nama as kecamatan, kab.nama as kabupaten, prov.nama as provinsi, ps.id as id_pasien, p.id as id_penduduk, p.nama as nama_pas, p.jenis_kelamin, p.gol_darah, dp.*, kl.nama as nama_kelurahan, pr.id as id_pro, pr.nama as nama_pro, dp.alamat_jalan, dp.status_pernikahan, dp.id_pendidikan_terakhir, dp.id_agama,concat_ws('/',substr(p.tanggal_lahir, 9, 2),substr(p.tanggal_lahir, 6, 2), substr(p.tanggal_lahir, 1,4)) as tanggal_lahir,k.rencana_cara_bayar as carabayar,k.no_kunjungan_pasien,k.id as id_kunjungan,   (select max(id) from billing where id_pasien=ps.id) as id_billing
            from penduduk p
            join pasien ps on (p.id = ps.id_penduduk)
			left join kunjungan k on (k.id_pasien = ps.id)
			left join dinamis_penduduk dp on(p.id = dp.id_penduduk)
			left join kelurahan kl on(dp.id_kelurahan = kl.id)
                        left join kecamatan kec on kl.id_kecamatan = kec.id
                        left join kabupaten kab on kec.id_kabupaten = kab.id
                        left join provinsi prov on kab.id_provinsi = prov.id
			left join profesi pr on(pr.id = dp.id_profesi)
			left join bed bed on (k.id_bed = bed.id)
                        left join agama ag on(ag.id = dp.id_agama)
			left join kelas kls on (kls.id = bed.id_kelas)
            where k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and locate('$q', ps.id) > 0 and dp.akhir = '1' order by locate('$q', ps.id) LIMIT 10";
        }
        $exe = _select_arr($sql);
        die(json_encode($exe));
    } else if ($_GET['opsi'] == 'obat') {
        $sql = mysql_query("select o.*,b.nama from obat o join barang b on o.id=b.id where locate('$q', b.nama) > 0 order by locate('$q', b.nama) ");
        $hasil = array();
        while ($data = mysql_fetch_object($sql)) {
            $hasil[] = $data;
        }
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == "penjualan_barang_retur") {
        $where='';
        if(isset($_GET['id_penduduk'])){
            if($_GET['id_penduduk']!=''){
                $where=" and p.id_penduduk_pembeli=".$_GET['id_penduduk'];
            }
        }
        
        $sql = "select
                dp.id as id_detail,dp.hna,dp.margin,dp.id_penjualan as no_faktur,dp.jumlah_penjualan,dp.batch,
                b.nama,pb.id as id_packing,pb.nilai_konversi,obat.generik,obat.kekuatan,
                sediaan.nama as sediaan,ir.nama as pabrik,st.nama as satuan_terkecil, sk.nama as satuan_terbesar
            from penjualan p
            join detail_penjualan_retur_penjualan dp on dp.id_penjualan=p.id
            JOIN packing_barang pb on pb.id=dp.id_packing_barang
            JOIN barang b on b.id=pb.id_barang
            left join obat on b.id=obat.id
            left join sediaan on sediaan.id=obat.id
            left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
            left join satuan st on st.id= pb.id_satuan_terkecil
            left join satuan sk on sk.id=pb.id_satuan_terbesar
            where b.nama like '%$q%' $where ";
        $hasil = _select_arr($sql);
        die(json_encode($hasil));
    } else if ($_GET['opsi'] == 'barang_sp') {
        $sql = "select
                o.kekuatan,sediaan.nama as sediaan,o.generik,dp.id as id_detail_pemesanan,b.nama as nama_barang,
                sk.nama as satuan_terbesar,pb.id as idbarang,st.nama as satuan_terkecil,pb.nilai_konversi,
                st.id as idsatuan,dp.id as id_detail,dp.jumlah_pesan,ir.nama as pabrik
                FROM pemesanan p
                JOIN detail_pemesanan_faktur dp on dp.id_pemesanan=p.id
                JOIN packing_barang pb on pb.id=dp.id_packing_barang
                JOIN barang b on b.id=pb.id_barang
                LEFT JOIN  obat o on (o.id = b.id)
                LEFT JOIN sediaan on o.id_sediaan=sediaan.id
                JOIN satuan st on st.id=pb.id_satuan_terkecil
                JOIN satuan sk on sk.id=pb.id_satuan_terbesar
                LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
                WHERE p.id='$_GET[nosp]' and b.nama like '%$q%'";
        die(json_encode(_select_arr($sql)));
    } else if ($_GET['opsi'] == 'sub_kategori_barang') {
        $sql = "select id,nama from sub_kategori_barang where locate ('$q',nama) > 0 order by locate ('$q',nama)";
        die(json_encode(_select_arr($sql)));
    } else if ($_GET['opsi'] == "no_penerimaan") {
        die(json_encode(_select_arr("select*from penerimaan_unit where id like '%$q%'")));
    } else if ($_GET['opsi'] == 'sub_kategori') {
        die(json_encode(_select_arr("SELECT * FROM sub_kategori_barang where id_kategori_barang!='0' and nama like '%$q%'")));
    }
} else if ($_GET['opsi'] == "cek_packing_barang") {
    $where = ($_GET['id_packing'] != '') ? "and id<>$_GET[id_packing] " : "";
    $sql = "select * from packing_barang 
        where id_barang='$_GET[id_barang]' 
        and id_satuan_terkecil='$_GET[satuan_terkecil]'  
        and id_satuan_terbesar='$_GET[satuan_terbesar]'  
        and nilai_konversi='$_GET[nilai_konversi]'
        $where";
    die(json_encode(_select_arr($sql)));
} else if ($_GET['opsi'] == 'paging_barang') {
    require_once 'app/lib/common/master-data.php';
    $code = NULL;
    $page = isset($_GET['page']) ? $_GET['page'] : NULL;
    $category = isset($_GET['category']) ? $_GET['category'] : NULL;
    $key = isset($_GET['key']) ? $_GET['key'] : NULL;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
    $barang = barang_muat_data($code, $sort, $sortBy, $page, $_GET['perPage'], $key, $category);
    die(json_encode($barang['list']));
} else if ($_GET['opsi'] == 'paging_instansi_relasi') {
    require_once 'app/lib/common/master-inventory.php';
    $code = NULL;
    $page = isset($_GET['page']) ? $_GET['page'] : NULL;
    $category = isset($_GET['category']) ? $_GET['category'] : NULL;
    $key = isset($_GET['key']) ? $_GET['key'] : NULL;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
    $barang = instansi_relasi_muat_data($code, $sort, $sortBy, $page, $_GET['perPage'], $key, $category);
    die(json_encode($barang['list']));
} else if ($_GET['opsi'] == 'paging_data_layanan') {
    require_once 'app/lib/common/master-data.php';
    $code = NULL;
    $page = isset($_GET['page']) ? $_GET['page'] : NULL;
    $category = isset($_GET['category']) ? $_GET['category'] : NULL;
    $key = isset($_GET['key']) ? $_GET['key'] : NULL;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
    $barang = layanan_muat_data($code, $sort, $sortBy, $page, $_GET['perPage'], $key, $category);
    die(json_encode($barang['list']));
} else if($_GET['opsi'] == 'paging_tarif'){
    $id = NULL;
    $page = isset($_GET['page']) ? $_GET['page'] : NULL;
    $dataPerPage = isset ($_GET['perPage'])?$_GET['perPage']:NULL;
    
    $tarif = tarif_muat_data($id, $page, $dataPerPage);
    die(json_encode($tarif['list']));
}else if ($_GET['opsi'] == 'cek_barang') {
    $nama = $_GET['nama'];
    $id = $_GET['idbarang'];
    if ($id != '') {
        $where = " and id<>'$id'";
    }else
        $where="";
    $row = _select_unique_result("select count(*) as jumlah from barang where nama='$nama'
            and id_instansi_relasi_pabrik='$_GET[idpabrik]' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }else
        $status=false;
    die(json_encode(array('status' => $status)));
}else if ($_GET['opsi'] == 'cek_agama') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from agama where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_Propinsi') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from provinsi where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_zat_aktif') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from zat_aktif where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_aturan') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from aturan_pakai where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }else
        $status=false;
    die(json_encode(array('status' => $status)));
}else if ($_GET['opsi'] == 'cek_farmakologi') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from farmakologi where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_instalasi') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from instalasi where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_instansiR') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from instansi_relasi where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_perundangan') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from perundangan where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_layanan') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from layanan where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_jenis_instansi') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from jenis_instansi_relasi where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_kelas') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from kelas where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_obat') {
    $nama = $_GET['namaObat'];
    $where="";
    if (isset($_GET['idObat'])) {
        if($_GET['idObat']){
            $where = " and o.id<>'$_GET[idObat]'";
        }        
    }
        
    $row = _select_arr("select o.*,
                            b.id as id_barang,b.nama as nama_barang,s.nama as sediaan,ssf.nama as sub_sub_farmakologi,sf.nama as sub_farmakologi,f.nama as farmakologi,
                            p.nama as perundangan,ins.nama as pabrik,ins.id as id_pabrik
                            FROM obat o
                            LEFT JOIN  barang b on b.id=o.id
                            LEFT JOIN sediaan s on s.id=o.id_sediaan
                            LEFT JOIN sub_sub_farmakologi ssf on ssf.id=o.id_sub_sub_farmakologi
                            LEFT JOIN sub_farmakologi sf on sf.id=ssf.id_sub_farmakologi
                            LEFT JOIN farmakologi f on f.id=sf.id_farmakologi
                            LEFT JOIN perundangan p on p.id=o.id_gol_perundangan
                            left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id 
                            join sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                            where skb.id=1
                            and b.nama='$nama' and b.id_instansi_relasi_pabrik='$_GET[idPabrik]' and o.kekuatan='$_GET[kekuatan]' and o.id_sediaan='$_GET[idSediaan]' $where");    
    $status = (count($row) < 1?false:true);
    $data=!empty($row)?$row[0]:"";
    die(json_encode(array('status' => $status,'data'=>$row)));
}
else if ($_GET['opsi'] == 'cek_Pekerjaan') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from pekerjaan where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_icd10') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $kode = $_GET['kode'];
    $row = _select_unique_result("select count(*) as jumlah from icd_10 where kode='$kode' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_Profesi') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from profesi where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_Satuan') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from satuan where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_Sediaan') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from sediaan where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_gol') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from sub_farmakologi where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_SubKategori') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from sub_kategori_barang where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_Pendidikan') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from pendidikan where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_unit') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from unit where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_kabupaten') {
    if (isset($_GET['kab']) && $_GET['kab'] != '') {
        $where = " AND id <> $_GET[kab]";
    } else
        $where = "";
    $nama     = $_GET['nama'];
	$provinsi = $_GET['provinsi'];
    $row      = _select_unique_result("SELECT COUNT(*) AS jumlah FROM kabupaten WHERE nama = '$nama' AND id_provinsi = $provinsi $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_kecamatan') {
    if (isset($_GET['kec']) && $_GET['kec'] != '') {
        $where = " AND id <> $_GET[kec]";
    }else
        $where="";
    $nama      = $_GET['nama'];
	$kabupaten = $_GET['kabupaten'];
    $row       = _select_unique_result("SELECT COUNT(*) AS jumlah FROM kecamatan where nama = '$nama' AND id_kabupaten = $kabupaten $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_kelurahan') {
    if (isset($_GET['kel']) && $_GET['kel'] != '') {
        $where = " AND id <> $_GET[kel]";
    }else
        $where="";
    $nama      = $_GET['nama'];
    $kecamatan = $_GET['kecamatan'];
    $row       = _select_unique_result("SELECT COUNT(*) AS jumlah FROM kelurahan WHERE nama = '$nama' AND id_kecamatan = $kecamatan $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_special') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $prof = $_GET['profesi'];
    $row = _select_unique_result("select count(*) as jumlah from spesialisasi where nama='$nama' and id_profesi='$prof' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'cek_SSF') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>$_GET[id]";
    }else
        $where="";
    $nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from sub_sub_farmakologi where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }
    else
        $status=false;
    die(json_encode(array('status' => $status)));
}
else if ($_GET['opsi'] == 'hitung_rop') {
    $id = $_GET['idPacking'];
    include_once "app/lib/common/master-data.php";
    die(json_encode(array('rop'=>hitung_rop($id))));
}else if ($_GET['opsi'] == 'no_batch') {
    $id = $_GET['idPacking'];
    include_once "app/lib/common/master-data.php";
    die(json_encode(array('rop'=>hitung_rop($id))));
}
else if($_GET['opsi'] == 'cek_jumlah_retur'){
    $idPacking = $_GET['idPacking'];
    $noFaktur = $_GET['noFaktur'];
    $batch = $_GET['batch'];
    $jumlahPembelian = $_GET['jumlahPembelian'];
    $jumlahRetur = $_GET['jumlahRetur'];
    
//    $query = _select_arr("select dprr.jumlah_retur_pembelian from detail_pembelian dprr 
//    join pembelian p where dprr.id_packing_barang='$idPacking' and p.no_faktur='$noFaktur' and dprr.batch = '$batch'");
    $query = _select_arr("select jumlah_retur from detail_retur_reretur where no_faktur='$noFaktur' and id_packing='$idPacking' and batch_retur='$batch'");
    $jumlah = 0;
    foreach ($query as $row){
        $jumlah = $jumlah + $row['jumlah_retur'];
    }
    $jumlahTotal = $jumlah + $jumlahRetur;
    $jumlahSisa = $jumlahPembelian - $jumlah;
    
    if($jumlahTotal > $jumlahPembelian){
        $status = false;
    }else $status = true;
    
    die(json_encode(array('status'=>$status,'jumlahSisa' => $jumlahSisa)));
}
else if($_GET['opsi'] == 'cek_id_reretur'){
    $id = $_GET['id'];
    
    $row = _select_unique_result("SELECT COUNT(*) AS jumlah FROM reretur_pembelian WHERE no_surat = $id");
    if ($row['jumlah'] == 0) {
        $status = false;
    }else{
        $status=true;
	}
	die(json_encode(array('status' => $status)));
}
else if($_GET['opsi'] == 'kategori_tarif'){
    $where="";
	if (isset($_GET['id']) && $_GET['id'] != '') {
        $where = " and id<>'".$_GET['id']."'";
    }
	$nama = $_GET['nama'];
    $row = _select_unique_result("select count(*) as jumlah from kategori_tarif where nama='$nama' $where");
    if ($row['jumlah'] == 0) {
        $status = true;
    }else{
        $status=false;
	}
	die(json_encode(array('status' => $status)));
}
else if($_GET['opsi'] == "data_kategori_tarif"){
     $sql_tarif = "select * from kategori_tarif ";
     $hasil = _select_arr($sql_tarif);
     show_array($hasil);
     die(json_encode($hasil));
} else if ($_GET['opsi'] == "cek_barcode")
{
    $barcode     = $_GET['barcode'];
    $sql_barcode = "SELECT * FROM packing_barang where barcode = $barcode";
    $hasil       = _select_arr($sql_barcode);
    die(json_encode($hasil));
} 
exit;