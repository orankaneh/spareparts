<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function jenis_instansi_relasi_muat_data($id=null,$sort = NULL,  $page=NULL,$dataPerPage = null) {
    if($id != NULL){
        $where = "where id='$id'";
    }else $where = "";

    if($sort != NULL && $sort == 1){
        $order = "order by id";
    }else if($sort != NULL && $sort ==2){
        $order = "order by nama";
    }else $order = "order by nama asc";
	if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
	 $dataPerPage = $dataPerPage;
    $offset = ($noPage - 1) * $dataPerPage;
    $batas = "";
    if ($dataPerPage != null) {
        $batas = "limit $offset, $dataPerPage";
    }
	     $result = array();
    $sql = "select * from jenis_instansi_relasi $where $order $batas";
	

  if ($id != null) {
    	$result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
		
		
    }else{
      $result['list'] = _select_arr($sql);
	
	  }    
		  $sqli = "select * from jenis_instansi_relasi $where $order";
	      $result['paging'] = paging($sqli, $dataPerPage);
          $result['offset'] = $offset;
	      $result['total'] = countrow($sqli);
	   return $result;
}

function instansi_relasi_muat_data($id=null,$sort=null,$sortBy = NULL, $page=NULL,$dataPerPage = null,$key = NULL) {
	if($key != NULL){
        $where = "where i.nama like ('%$key%')";
    }else $where = "";
     $cari=null;
 
    if($sort==1){
        $action = "order by i.id $sortBy";
    }else if($sort==2){
        $action = "order by i.nama $sortBy";
    }else if($sort==3){
        $action = "order by j.nama $sortBy";
    }else $action = "order by i.nama asc";
	if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
	if ($id != null) {
 $cari = " where i.id = '$id'";
}
  $dataPerPage = $dataPerPage;
    $offset = ($noPage - 1) * $dataPerPage;
    $batas = "";
    if ($dataPerPage != null) {
        $batas = "limit $offset, $dataPerPage";
    }
    $result = array();
    $sql = "select i.id, i.nama, i.alamat,i.telp,i.email,i.fax,i.website, k.nama as nama_kelurahan, j.nama as jenis_instansi from instansi_relasi i
            join kelurahan k on (i.id_kelurahan = k.id)
            join jenis_instansi_relasi j on (i.id_jenis_instansi_relasi = j.id) $where $cari $action $batas";

	if ($id != null) {
         $result = _select_unique_result($sql);
         $result['list'] = _select_arr($sql);
	
    } else {
        $result['list'] = _select_arr($sql);

    }
	 $sqli = "select i.id, i.nama, i.alamat,i.telp,i.email,i.fax,i.website, k.nama as nama_kelurahan, j.nama as jenis_instansi from instansi_relasi i
            join kelurahan k on (i.id_kelurahan = k.id)
            join jenis_instansi_relasi j on (i.id_jenis_instansi_relasi = j.id) $where $cari $action";
	   $result['paging'] = paging($sqli, $dataPerPage);
       $result['offset'] = $offset;
	   $result['total'] = countrow($sqli);
	   return $result;
}
function pemakaian_muat_data($id){
    $return = array();
    $master = "select p.waktu,pd.nama as penduduk,u.nama as unit from pemakaian p 
            join pegawai pg on p.id_pegawai = pg.id
            join penduduk pd on pg.id = pd.id
            join unit u on p.id_unit = u.id
            where p.id = '$id'";
    $detail = "select dp.jumlah,b.nama as barang,dp.batch,o.generik,o.kekuatan,ins.nama as pabrik,sd.nama as sediaan,pb.nilai_konversi,st.nama as satuan_terkecil from detail_pemakaian dp
            join packing_barang pb on dp.id_packing_barang = pb.id
            join barang b on pb.id_barang = b.id
            left join obat o on o.id = b.id
            left join sediaan sd on o.id_sediaan = sd.id
            left join satuan st on pb.id_satuan_terkecil = st.id
            left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
            where dp.id_pemakaian = '$id'";
    $return['master'] = _select_arr($master);
    $return['detail'] = _select_arr($detail);
    
    return $return;
}
function instansi_relasi_muat_data_by_id($id) {

    $sql = "select i.*, k.nama as nama_kelurahan, j.nama as jenis_instansi from instansi_relasi i
            join kelurahan k on (i.id_kelurahan = k.id)
            join jenis_instansi_relasi j on (i.id_jenis_instansi_relasi = j.id)
            where i.id = '$id'";
    $exe = mysql_query($sql);
    $result = array();
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}
function barang_muat_data_by_nosp($nosp){
    $sql="select pb.id as idbarang,
    dpf.id as id_detail,o.generik,pb.id as id_packing,pb.nilai_konversi,sd.nama as sediaan,o.kekuatan,
    b.nama as nama_barang,dpf.jumlah_pesan as jumlah,
    s.nama as satuan_terkecil,s2.nama as satuan_terbesar,ir.nama as pabrik,
    o.generik,(select sisa from stok WHERE stok.id_packing_barang=pb.id ORDER BY waktu desc,id desc LIMIT 0,1) as sisa
    from detail_pemesanan_faktur dpf
    JOIN packing_barang pb on pb.id=dpf.id_packing_barang
    JOIN barang b on b.id=pb.id_barang
    left join obat o on b.id=o.id
    left join sediaan sd on o.id_sediaan = sd.id
    JOIN satuan s on s.id=pb.id_satuan_terkecil
    JOIN satuan s2 on s2.id=pb.id_satuan_terbesar
    left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
        WHERE dpf.id_pemesanan='$nosp'
    group by dpf.id_pemesanan,pb.id";
    $result = _select_arr($sql);
    return $result;
}
function barang_muat_data_by_id_beli($no){
    $sql = "SELECT
				dbeli.*, b.nama AS nama_barang, o.generik, o.kekuatan, sd.nama AS sediaan, pb.nilai_konversi,
				s.nama AS satuan_terkecil, ir.nama AS pabrik, st.ed, s2.nama AS satuan_terbesar, dbeli.jumlah_pembelian AS jumlah
			FROM detail_pembelian dbeli
			JOIN packing_barang pb ON pb.id = dbeli.id_packing_barang
			JOIN barang b ON b.id = pb.id_barang
			LEFT JOIN stok st ON st.id_transaksi = dbeli.id_pembelian
			LEFT JOIN obat o ON b.id = o.id
			LEFT JOIN sediaan sd ON sd.id = o.id_sediaan
			JOIN satuan s ON s.id = pb.id_satuan_terkecil
			JOIN satuan s2 ON s2.id = pb.id_satuan_terbesar
			LEFT JOIN instansi_relasi ir ON ir.id = b.id_instansi_relasi_pabrik
			WHERE dbeli.id_pembelian = $no
			GROUP BY dbeli.id";
    $result = _select_arr($sql);
    return $result;
}
function detail_barang_sp_muat_data($nosp){
    $sql="select b.nama as barang, pb.id as idbarang, pb.nilai_konversi, st.nama as satuan, sk.nama as satuan_terkecil, st.id as idsatuan,
    dp.id as id_detail,dp.lead_time,dp.id_pemesanan, pbl.no_faktur,
    dp.jumlah_pesan,dp.jumlah_pembelian,sediaan.nama as sediaan,obat.kekuatan,obat.generik,ir.nama as pabrik
    FROM pemesanan p
    LEFT JOIN detail_pemesanan_faktur dp on dp.id_pemesanan=p.id
    LEFT JOIN pembelian pbl on dp.id_pembelian=pbl.id
    LEFT JOIN packing_barang pb on pb.id=dp.id_packing_barang
    LEFT JOIN barang b on b.id=pb.id_barang
    LEFT JOIN satuan st on st.id=pb.id_satuan_terbesar
    LEFT JOIN satuan sk on sk.id=pb.id_satuan_terkecil
    left join obat on obat.id=b.id
    left join sediaan on sediaan.id=obat.id_sediaan
    left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
    WHERE p.id='$nosp'";
    //echo $sql;
    $result = _select_arr($sql);
    return $result;
}

function penerimaan_unit_muat_data($id){
    $sql="select dd.*,pb.nilai_konversi,s1.nama as satuan_terkecil,s2.nama as satuan_terbesar,o.generik,o.kekuatan,sd.nama as sediaan,ins.nama as pabrik,b.nama as barang,o.generik,(select SUM(jumlah_penerimaan_unit) from detail_distribusi_penerimaan_unit where id_distribusi=dd.id_distribusi and id_packing_barang=dd.id_packing_barang) as sisa from detail_distribusi_penerimaan_unit dd
          left join packing_barang pb on (dd.id_packing_barang=pb.id) 
          left join satuan s1 on (pb.id_satuan_terkecil=s1.id) 
          left join satuan s2 on (pb.id_satuan_terbesar=s2.id) 
          left join barang b on (pb.id_barang=b.id)
          left join obat o on b.id=o.id
          left join sediaan sd on o.id_sediaan=sd.id
          left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
          where dd.id_distribusi='$id'";
    $result = _select_arr($sql);
    return $result;
}
function penerimaan_unit_muat_data_by_id($id = NULL){
    $return = array();
    $master = "select detail.id_distribusi,pu.id,pend.nama as pegawai,pu.waktu from penerimaan_unit pu
               left join detail_distribusi_penerimaan_unit detail on pu.id = detail.id_penerimaan_unit
               join pegawai pg on pu.id_pegawai=pg.id
               join penduduk pend on pg.id=pend.id where pu.id = '$id'";
    $return['master'] = _select_arr($master);
    
    $detail = "select detail.batch,b.nama as barang,st.nama as satuan,sd.nama as sediaan,ins.nama as pabrik,o.generik,o.kekuatan,pb.nilai_konversi,detail.jumlah_penerimaan_unit,st2.nama as kemasan from detail_penerimaan_unit_retur_unit detail
               left join packing_barang pb on detail.id_packing_barang = pb.id
               left join satuan st on pb.id_satuan_terkecil = st.id
			   left join satuan st2 on pb.id_satuan_terbesar = st2.id
               left join barang b on pb.id_barang = b.id
               left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
               left join obat o on o.id = b.id
               left join sediaan sd on o.id_sediaan = sd.id
               where detail.id_penerimaan_unit = '$id'";
    $return['detail'] = _select_arr($detail);
    return $return;
}
function aturan_pakai_muat_data() {
	$sql = "select * from aturan_pakai";
	$result = _select_arr($sql);
	return $result;
}

function embalage_muat_data() {
	$sql = "select * from embalage";
	$result = _select_arr($sql);
	return $result;
}

function resep_auto_increment() {
	$sql = "select max(no_resep+1) as new_numb from detail_resep_penjualan";
	$result = _select_arr($sql);
	return $result;
}
function detail_distribusi_muat_data($id = NULL){
   if($id != NULL){
       $where = "where dp.id_distribusi = '$id'";
   }else $where = "";
   $sql = "select dp.id_distribusi as pu,dp.jumlah_distribusi,st2.nama as satuan_terbesar,
            sd.nama as sediaan,o.kekuatan,o.generik,ins.nama as pabrik,
            dp.id_penerimaan_unit,dp.jumlah_penerimaan_unit,pb.nilai_konversi,st.nama as satuan,
            br.nama as barang
           from detail_distribusi_penerimaan_unit dp
           join packing_barang pb on dp.id_packing_barang = pb.id
           left join satuan st on pb.id_satuan_terkecil = st.id
           join barang br on pb.id_barang = br.id
           left join obat o on br.id=o.id
           left join satuan st2 on pb.id_satuan_terbesar = st2.id
           left join sediaan sd on o.id_sediaan=sd.id
           left join instansi_relasi ins on br.id_instansi_relasi_pabrik = ins.id
           $where"; 
   
   return _select_arr($sql);
}

function detail_nota_penjualan($id = null, $kelas = null,$nor=null) {
	/*if (($id != null) and ($kelas != null)) {
		$id = $id;
		$kelas = "and k.id = $kelas";
	}else{
            $kelas = "and k.nama = 'Tanpa Kelas'";
        }*/
        $kelas='';
        
        if ($nor != null) {
            $nomer = "and drp.no_r=$nor";
        }else{
            $nomer='';
        }
	$cek_jenis = _select_unique_result("select jenis from penjualan where id = '$id'");
        $require = "";
        $order = "";
        if ($cek_jenis['jenis'] == 'Bebas') {
            $require = "p.id = '$id'";
        } else {
            //$no_resep= _select_unique_result("select no_resep from detail_penjualan_retur_penjualan where id_penjualan = '$id'");
            //$require = "drp.no_resep = '$id'";
            $require = "p.id = '$id'";
            $order = "order by drp.no_r";
        }
        $sql = "
            select
                dprp.hna as hna,dprp.margin as margin,dprp.jumlah_retur as jumlah_retur,dprp.alasan as alasan,p.id,pdd.nama as nama_pembeli,p.jenis,p.diskon,p.total_tagihan,ob.id as id_obat,brg.nama as nama_obat,ob.kekuatan,ob.generik,sed.nama as sediaan,st.sisa,
                pb.nilai_konversi,ir.nama as pabrik,ap.id as id_aturan_pakai,ap.nama as aturan_pakai,sat1.nama as satuan_terkecil,sat2.nama as satuan_terbesar,skb.nama as sub_kategori_barang,
                drp.no_r,dprp.id_packing_barang,drp.jenis_r,drp.kekuatan_r_racik,drp.jumlah_r_resep,drp.jumlah_r_tebus,drp.jumlah_pakai,(drp.jumlah_r_resep-drp.jumlah_r_tebus) as detur,
                dprp.jumlah_penjualan,floor((dprp.hna*(dprp.margin/100))+dprp.hna) as harga,floor((dprp.hna*(dprp.margin/100))+dprp.hna) as hna,
                (select count(distinct drp1.no_r) from detail_resep_penjualan drp1
                    where drp1.id_detail_penjualan_retur_penjualan=dprp.id)*drp.biaya_apoteker as biaya_apoteker,
                drp.jumlah_r_resep-(sum(drp.jumlah_r_tebus)) as kekurangan_tebus,date(p.waktu) as waktu
                from penjualan p
                left join detail_penjualan_retur_penjualan dprp on(dprp.id_penjualan=p.id)
                left join detail_resep_penjualan drp on(drp.id_detail_penjualan_retur_penjualan=dprp.id)
                left join penduduk pdd on(pdd.id=p.id_penduduk_pembeli)
                left join packing_barang pb on(pb.id=dprp.id_packing_barang)
                left join barang brg on(brg.id=pb.id_barang)
                left join obat ob on(ob.id=brg.id)
                left join aturan_pakai ap on(ap.id=drp.id_aturan_pakai)
                left join sediaan sed on (sed.id=ob.id_sediaan)
                left join instansi_relasi ir on(ir.id=brg.id_instansi_relasi_pabrik)
                left join satuan sat1 on(sat1.id=pb.id_satuan_terkecil)
                left join satuan sat2 on(sat2.id=pb.id_satuan_terbesar)
                left join sub_kategori_barang skb on(skb.id=brg.id_sub_kategori_barang)
                left join stok_unit st on(st.id=(select max(st1.id) FROM stok_unit st1 where st1.id_packing_barang=pb.id))
                where $require $nomer $kelas group by pb.id $order 
            ";
        //echo "<pre>$sql</pre>"; die;
	$result['list'] = _select_arr($sql);
	   $result['total'] = countrow($sql);
	return $result;
}
function nota_penjualan_muat_data($id = null, $kelas = null,$nor=null) {
	/*if (($id != null) and ($kelas != null)) {
		$id = $id;
		$kelas = "and k.id = $kelas";
	}else{
            $kelas = "and k.nama = 'Tanpa Kelas'";
        }*/
        $kelas='';
        
        if ($nor != null) {
            $nomer = "and drp.no_r=$nor";
        }else{
            $nomer='';
        }
	$cek_jenis = _select_unique_result("select jenis from penjualan where id = '$id'");
        $require = "";
        $order = "";
        if ($cek_jenis['jenis'] == 'Bebas') {
            $require = "p.id = '$id'";
        } else {
            //$no_resep= _select_unique_result("select no_resep from detail_penjualan_retur_penjualan where id_penjualan = '$id'");
            //$require = "drp.no_resep = '$id'";
            $require = "p.id = '$id'";
            $order = "order by drp.no_r";
        }
        $sql = "
            select
                dprp.hna as hna,dprp.margin as margin,dprp.jumlah_retur as jumlah_retur,dprp.alasan as alasan,p.id,pdd.nama as nama_pembeli,p.jenis,p.diskon,p.total_tagihan,ob.id as id_obat,brg.nama as nama_obat,ob.kekuatan,ob.generik,sed.nama as sediaan,st.sisa,
                pb.nilai_konversi,ir.nama as pabrik,ap.id as id_aturan_pakai,ap.nama as aturan_pakai,sat1.nama as satuan_terkecil,sat2.nama as satuan_terbesar,skb.nama as sub_kategori_barang,
                drp.no_r,dprp.id_packing_barang,drp.jenis_r,drp.kekuatan_r_racik,drp.jumlah_r_resep,drp.jumlah_r_tebus,drp.jumlah_pakai,(drp.jumlah_r_resep-drp.jumlah_r_tebus) as detur,
                dprp.jumlah_penjualan,(dprp.hna+((dprp.margin/100)*dprp.hna)) as harga,floor((dprp.hna*(dprp.margin/100))+dprp.hna) as hna,
                (select count(distinct drp1.no_r) from detail_resep_penjualan drp1
                    where drp1.id_detail_penjualan_retur_penjualan=dprp.id)*drp.biaya_apoteker as biaya_apoteker,
                drp.jumlah_r_resep-(select sum(drp2.jumlah_r_tebus) from detail_resep_penjualan drp2 where drp2.no_resep=drp.no_resep) as kekurangan_tebus,date(p.waktu) as waktu
                from penjualan p
                left join detail_penjualan_retur_penjualan dprp on(dprp.id_penjualan=p.id)
                left join detail_resep_penjualan drp on(drp.id_detail_penjualan_retur_penjualan=dprp.id)
                left join penduduk pdd on(pdd.id=p.id_penduduk_pembeli)
                left join packing_barang pb on(pb.id=dprp.id_packing_barang)
                left join barang brg on(brg.id=pb.id_barang)
                left join obat ob on(ob.id=brg.id)
                left join aturan_pakai ap on(ap.id=drp.id_aturan_pakai)
                left join sediaan sed on (sed.id=ob.id_sediaan)
                left join instansi_relasi ir on(ir.id=brg.id_instansi_relasi_pabrik)
                left join satuan sat1 on(sat1.id=pb.id_satuan_terkecil)
                left join satuan sat2 on(sat2.id=pb.id_satuan_terbesar)
                left join sub_kategori_barang skb on(skb.id=brg.id_sub_kategori_barang)
                left join stok_unit st on(st.id=(select max(st1.id) FROM stok_unit st1 where st1.id_packing_barang=pb.id and st1.batch=dprp.batch))
                where $require $nomer $kelas $order 
            ";
      //echo "<pre>$sql</pre>"; die;
	$result['list']= _select_arr($sql);
	 $result['total'] = countrow($sql);
	return $result;
}
function info_salin_resep($id){
    $sql="select 
                distinct p.id,p.id_penduduk_dokter as id_dokter,p.catatan,
                p.id_penduduk_pembeli as id_pembeli,pdd2.sip,pdd2.nama as nama_dokter,pas.id as no_rm,pdd.nama as nama_pembeli,
                kls.id as id_kelas,kls.nama as kelas,date(p.waktu) as waktu,p.jenis
                from penjualan p
                left join penduduk pdd on (pdd.id=p.id_penduduk_pembeli)
                left join pasien pas on (pas.id_penduduk=pdd.id)
                left join kunjungan kjg on(kjg.id_pasien=pas.id)
                left join bed on(bed.id=kjg.id_bed)
                left join kelas kls on (kls.id = bed.id_kelas)
                left join temp_detail_penjualan_retur tdpr on(tdpr.id_temp_penjualan=p.id)
                left join temp_detail_resep tdr on(tdr.id_temp_detail_penjualan_retur=p.id)
                left join penduduk pdd2 on (pdd2.id=p.id_penduduk_dokter)
                left join pegawai pgw on pgw.id=pdd2.id
                where p.id=$id ";
    return _select_arr($sql);
}

function cetak_salin_resep_muat_data($id, $kelas,$nor=null) {
        if (($id != null) and ($kelas != null)) {
		$id = $id;
		$kelas = "and mp.id_kelas = $kelas";
	}
        $nomer = "";
        if ($nor != null) {
            $nomer = "and dr.no_r=$nor";
        }

        if ($kelas == null) {
            $separat = "or";
        } else if ($kelas != null) {
            $separat = "and";
        }

	$sql = "select dr.id as id_drp, rp.id, p.id as no_penjualan, dr.jenis_r, pd.nama as pembeli, Date(p.waktu) as tanggal,petugas.nama as petugas, petugas.sip, pdk.nama as dokter,
	b.nama, dr.no_r, dr.jumlah_r_resep, dr.jumlah_r_tebus, (dr.jumlah_r_resep - dr.jumlah_r_tebus) as detur,
        sediaan.nama as sediaan,dr.kekuatan_r_racik,o.kekuatan, ap.nama as aturan_pakai, pa.nilai_konversi, i.nama as pabrik, b.nama as nama_barang, s.nama as satuan, dp.jumlah_penjualan, (dp.jumlah_penjualan * ((st.hna*(mp.nilai_persentase/100))+st.hna)) as subtotal,
        ((st.hna*(mp.nilai_persentase/100))+st.hna) as harga, p.total_tagihan
        from penjualan p
	left join penduduk pd on (p.id_penduduk_pembeli = pd.id)
	left join pegawai pgw on (p.id_pegawai = pgw.id)
	left join detail_penjualan_retur_penjualan dp on(dp.id_penjualan = p.id)
        left join detail_resep_penjualan dr on (dr.id_penjualan = p.id)
        left join aturan_pakai ap on (dr.id_aturan_pakai = ap.id)
        left join resep rp on (dr.id_resep = rp.id)
	left join packing_barang pb on (dp.id_packing_barang = pb.id or dr.id_packing_barang = pb.id)	
	left join barang b on (pb.id_barang = b.id)
	left join packing_barang pa on (pa.id_barang = b.id)
	left join stok_unit st on (st.id=(select max(id) from stok_unit where stok_unit.id_packing_barang=pa.id ) )
        left join obat o on (b.id=o.id)
	Left join sediaan on (o.id_sediaan=sediaan.id)
	left join instansi_relasi i on (i.id = b.id_instansi_relasi_pabrik)
	left join satuan s on (pb.id_satuan_terkecil = s.id)
        left JOIN penduduk petugas on (petugas.id=pgw.id)
        left JOIN penduduk pdk on (pdk.id = rp.id_penduduk_dokter)
	left join margin_packing_barang_kelas mp on (pb.id = mp.id_packing_barang)
	where p.id = $id $nomer $kelas group by pb.id order by dr.no_r";
        
        //echo "<pre>$sql</pre>";
        
        return _select_arr($sql);
        
	
}

function cek_etiket ($id) {
    $sql = "select * from penjualan where id = '$id'";
    return _select_unique_result($sql);
}
function cetak_etiket_muat_data($id = NULL){
    if($id != NULL){
        $action = "where drp.id_penjualan='$id'";
    }else $action = "";
    $sql = "select drp.id_resep,ap.nama as aturan_pakai,pd.nama as pasien,DATE(pj.waktu) as tanggal,s.nama as sediaan from detail_resep_penjualan drp
    join penjualan pj on drp.id_penjualan = pj.id
    join resep r on drp.id_resep = r.id
    join penduduk pd on r.id_penduduk_objek = pd.id
    join aturan_pakai ap on drp.id_aturan_pakai = ap.id
    join packing_barang pb on drp.id_packing_barang = pb.id
    left join obat o on pb.id_barang = o.id
    left join sediaan s on o.id_sediaan = s.id
        $action group by drp.no_r
    ";
    
    return _select_unique_result($sql);
}
function detail_retur_penjualan_muat_data($id = NULL){
   if($id != NULL){
       $where = "where dp.id_retur_penjualan = '$id'";
   }else $where = "";
   $sql = "select dp.hna,dp.margin,dp.jumlah_retur,dp.alasan,pb.nilai_konversi,penjualan.id as no_nota,
        obat.generik,st.nama as satuan_terkecil,obat.kekuatan, sediaan.nama as sediaan,ir.nama as pabrik,
            st.nama as satuan,br.nama as barang 
           from detail_penjualan_retur_penjualan dp
           join penjualan on dp.id_penjualan=penjualan.id
           join packing_barang pb on dp.id_packing_barang = pb.id
           left join satuan st on pb.id_satuan_terkecil = st.id
           join barang br on pb.id_barang = br.id
           left join obat on br.id=obat.id
            left join sediaan on sediaan.id=obat.id
            left join instansi_relasi ir on ir.id=br.id_instansi_relasi_pabrik
            left join satuan sk on sk.id=pb.id_satuan_terbesar
   $where"; 
   
   return _select_arr($sql);
}

function nota_temp_penjualan_muat_data($id = null, $kelas = null,$nor=null){        
        
        $kelas='';
        
        $nomer = "";
        if ($nor != null) {
            $nomer = "and tdr.no_r=$nor";
        }
        
        $cek_jenis = _select_unique_result("select jenis from temp_penjualan where id = '$id'");
	$order = "";
        if ($cek_jenis['jenis'] == 'Bebas') {
            $require = "tp.id = '$id'";
        } else {
            $require = "tp.id = '$id'";
            $order = "order by tdr.no_r";
        }
    
	$sql = "select
                tp.id,pdd.nama as nama_pembeli,tp.jenis,tp.diskon,tp.total_tagihan,ob.id as id_obat,brg.nama as nama_obat,ob.kekuatan,ob.generik,st.sisa,sed.nama as sediaan,
                pb.nilai_konversi,ir.nama as pabrik,ap.id as id_aturan_pakai,ap.nama as aturan_pakai,sat1.nama as satuan_terkecil,sat2.nama as satuan_terbesar,
                tdr.no_r,tdpr.id_packing_barang,tdr.jenis_r,tdr.kekuatan_r_racik,tdr.jumlah_r_resep,tdr.jumlah_r_tebus,tdr.jumlah_pakai,(tdr.jumlah_r_resep-tdr.jumlah_r_tebus) as detur,
                tdpr.jumlah_penjualan,floor((tdpr.hna*(tdpr.margin/100))+tdpr.hna) as harga,floor((tdpr.hna*(tdpr.margin/100))+tdpr.hna) as hna,
                (select count(distinct tdr1.no_r) from temp_detail_resep tdr1 where tdr1.id_temp_detail_penjualan_retur=tdpr.id)*tdr.biaya_apoteker as biaya_apoteker,tp.waktu
                from temp_penjualan tp
                left join temp_detail_penjualan_retur tdpr on(tdpr.id_temp_penjualan=tp.id)
                left join temp_detail_resep tdr on(tdr.id_temp_detail_penjualan_retur=tdpr.id)
                left join penduduk pdd on(pdd.id=tp.id_penduduk_pembeli)                
                left join packing_barang pb on(pb.id=tdpr.id_packing_barang)
                left join barang brg on(brg.id=pb.id_barang)
                left join obat ob on(ob.id=brg.id)
                left join aturan_pakai ap on(ap.id=tdr.id_aturan_pakai)
                left join sediaan sed on (sed.id=ob.id_sediaan)
                left join instansi_relasi ir on(ir.id=brg.id_instansi_relasi_pabrik)
                left join stok_unit st on(st.id=(select max(st1.id) FROM stok_unit st1 where st1.id_packing_barang=pb.id))
                left join satuan sat1 on(sat1.id=pb.id_satuan_terkecil)
                left join satuan sat2 on(sat2.id=pb.id_satuan_terbesar)
                where $require $nomer $kelas group by pb.id $order";
                
        //echo "<pre>$sql</pre>";
                return _select_arr($sql);
}

function no_penjualan_new_id() {
    $row = _select_unique_result("select max(id+1) as new from penjualan");
    if ($row['new'] == NULL) {
        $new = 1;
    } else {
        $new= $row['new'];
    }
    return $new;
}

function detail_retur_unit_muat_data($id = NULL){
   if($id != NULL){
       $where = "where dp.id_retur_unit = '$id'";
   }else $where = "";
   $sql = "select dp.id_penerimaan_unit as pu,dp.jumlah_penerimaan_unit,dp.jumlah_retur_penerimaan_unit,
            dp.alasan,pb.nilai_konversi,st.nama as satuan,br.nama as barang,dp.id_retur_unit,
            o.kekuatan,sd.nama as sediaan,o.generik,ir.nama as pabrik,dp.id_penerimaan_unit,satuan_terbesar.nama as satuan_terbesar,
            dp.batch
        from detail_penerimaan_unit_retur_unit dp
           join packing_barang pb on dp.id_packing_barang = pb.id
           left join satuan st on pb.id_satuan_terkecil = st.id
           join barang br on pb.id_barang = br.id
           left join obat o on br.id=o.id
           left join sediaan sd on o.id_sediaan = sd.id
           left join instansi_relasi ir on ir.id=br.id_instansi_relasi_pabrik
           left join satuan satuan_terbesar on satuan_terbesar.id=pb.id_satuan_terbesar
            $where";
   
   return _select_arr($sql);
}

function detail_penerimaan_unit_muat_data($id = NULL){
   if($id != NULL){
       $where = "where dp.id = '$id'";
   }else $where = "";
   $sql = "select dp.id_penerimaan_retur_unit as pu,dp.jumlah,pb.nilai_konversi,st.nama as satuan,br.nama as barang from detail_penerimaan_retur_unit dp
           join packing_barang pb on dp.id_packing_barang = pb.id
           left join satuan st on pb.id_satuan_terkecil = st.id
           join barang br on pb.id_barang = br.id $where"; 
   
   return _select_arr($sql);
}

function get_sip($id){
    $sql="select sip from penduduk p where p.id=$id";    
    return _select_unique_result($sql);
}
?>

