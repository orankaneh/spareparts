<?php
//	Master Data Akuntansi 
// 	Created at 17-10-2011




// --Modul Akuntasi :: Rekening-- //
function profile_rumah_sakit_muat_data(){
    $rs=_select_unique_result("select * from rumah_sakit");
    return $rs;
}
function data_rekening($id = null, $page=NULL,$data_perpage=NULL,$urut_berdasar=NULL,$key=null){
    $result = array();
    $noPage = 1;
    $where="";
    $batas = "";
    if ($id != null) {
        $where.="where id = '$id'";
    }
    if($urut_berdasar != NULL){
            $where.="order by $urut_berdasar ";
    } else {
            $where.="order by rek.kode asc ";
    }
    
    if($key != NULL){
       $cari = "where rek.nama like ('%$key%') ";
    } else
      $cari='';
          
    if (!empty($page)){$noPage = $page;}
        $offset = ($noPage - 1) * $data_perpage;
    if ($data_perpage != null) {
        $batas = "limit $offset, $data_perpage";
    }
    $sql_kategori = mysql_query("select * from kategori_rekening order by cast(kode as signed)");
  
    while ($row=mysql_fetch_array($sql_kategori)) {
	$data_kategori=array();
	$data_kategori['nama'] = $row['nama'];
	$data_kategori['kode'] = $row['kode'];
	$sql_rekening = mysql_query("
	    select
	    rek.id as id_rekening,
	    rek.kode as kode_rekening,
	    rek.nama as nama_rekening,
	    rek.status
	    from rekening rek join kategori_rekening k_rek on(rek.id_kategori=k_rek.id) and rek.id_kategori='".$row['id']."' $cari $where");
	    $rekening=array();
	    while($rek=mysql_fetch_array($sql_rekening)) {
		$rekening['id_rekening'] = $rek['id_rekening'];
		$rekening['kode_rekening'] = $rek['kode_rekening'];
		$rekening['nama_rekening'] = $rek['nama_rekening'];
		$rekening['status'] = $rek['status'];
		$data_kategori['datarekening'][]=$rekening;
	    }
	    $result[]=$data_kategori;
    }

    return $result;
}

function data_kategori_rekening($where=null,$sortby=null) {
    $where="";
	
	if($sortby !=null) $sortby="order by cast($sortby as signed)";
	else $sortby="order by nama";
    if ($where != null) $where="where id='$where'";
    
    $sql = "select * from kategori_rekening $where $sortby";
    if ($where !=null) $result = _select_unique_result($sql);
    else $result = _select_arr($sql);
    return $result;
}

function data_rekening_list($bulan,$tahun){

    $result = array();
    $sql = "select * from rekening where id in (
			select d.id_rekening as id from detail_jurnal d join jurnal j on (d.id_jurnal=j.id) where month(j.tanggal) = '".$bulan."' and year(j.tanggal) = '".$tahun."') order by kode";
	
	$result['list'] = _select_arr($sql);
    return $result;
}

function data_rekening_muat_data($id = null) {
    
    $require = "";
    if ($id != null) $require = "where id = '$id'";
    
    $sql = "select * from rekening $require";
    if ($id != null) $result = _select_unique_result($sql);
    else $result = _select_arr($sql);
    return $result;

}

function jurnal_umum_muat_data($bulan,$tahun,$tipe,$id = null) {

    $result=array();
    $require = "";

    if ($id != null) $require = "and ju.id = '$id'";
    $sql = mysql_query("select 
		p.nama as nama_terkait,
		inst.nama as nama_instansi,
		hp.status as status_terkait, 
		hp.id_terkait as id_terkait,
		ju.*
		from jurnal ju
		left join hutang_piutang hp on (ju.id=hp.id_jurnal)
		left join penduduk p on (p.id = hp.id_terkait)
		left join instansi_relasi inst on (inst.id = hp.id_terkait)
        where ju.status = '".$tipe."' and month(ju.tanggal) = '".$bulan."' and year(ju.tanggal) = '".$tahun."' $require order by ju.tanggal, ju.id");

	if (mysql_num_rows($sql) != 0) {
	while($row=mysql_fetch_array($sql)) {
		$data=array();
		$data['nama_terkait'] = $row['nama_terkait'];
		$data['nama_instansi'] = $row['nama_instansi'];
		$data['status_terkait'] = $row['status_terkait'];
		$data['id_terkait'] = $row['id_terkait'];
		$data['tanggal'] = $row['tanggal'];
		$data['id'] = $row['id'];
		$data['nama'] = $row['nama'];
		$data['nomor_bukti'] = $row['nomor_bukti'];
		$data['jumlah'] = $row['jumlah'];
		$data['checkedit'] = check_laporan_hasil_akuntansi($bulan,$tahun);
		$data['rekening_debet'] = array();
		$data['rekening_kredit'] = array();
		
		$sql_rek_debet = mysql_query("select r.kode,r.id, r.nama as nama_rekening , r.id_kategori as id_kategori, dj.jumlah as jumlah from detail_jurnal dj join rekening r on(dj.id_rekening=r.id) and dj.id_jurnal = '".$row['id']."' and dj.status = 'd'");

		while($row_debet = mysql_fetch_array($sql_rek_debet)) {
			$data_debet = array(
				"id_rekening" => $row_debet['id'],
				"kode_rekening" => $row_debet['kode'],
				"nama_rekening" => $row_debet['nama_rekening'],
				"id_kategori" =>  $row_debet['id_kategori'],
				"jumlah_rekening" => $row_debet['jumlah']
			);
			$data['rekening_debet'][] = $data_debet;	
		}	
		
		$sql_rek_kredit = mysql_query("select r.kode,r.id, r.nama as nama_rekening, r.id_kategori as id_kategori, dj.jumlah as jumlah from detail_jurnal dj join rekening r on(dj.id_rekening=r.id) and dj.id_jurnal = '".$row['id']."' and dj.status = 'k'");

		while($row_kredit = mysql_fetch_array($sql_rek_kredit)) {
			$data_kredit = array(
				"id_rekening" => $row_kredit['id'],
				"kode_rekening" => $row_kredit['kode'],
				"nama_rekening" => $row_kredit['nama_rekening'],
				"id_kategori" =>  $row_kredit['id_kategori'],
				"jumlah_rekening" => $row_kredit['jumlah']
			);
			$data['rekening_kredit'][] = $data_kredit;
		}	
		if(count($data['rekening_kredit']) < count($data['rekening_debet'])) $data['jumlah_max_rekening'] = count($data['rekening_debet']);
		else $data['jumlah_max_rekening'] = count($data['rekening_kredit']);
		
	
		if ($id != null) $result=$data; 
		else $result[]=$data;
	}
	
	} 
	
	return $result;

}

function check_laporan_hasil_akuntansi($bulan,$tahun) {
	$saldoawal = _select_unique_result("select min(tanggal) as tanggal_awal from saldo");
	
	$now=strtotime(date('Y-m')."-01");
	$past=strtotime($tahun."-".$bulan."-01");

	
	$saldo = _num_rows("select * from saldo where month(tanggal) = '".$bulan."' and year(tanggal) = '".$tahun."'");
	$laporan = _num_rows("select * from hasil_laporan_akuntansi where id_laporan = '1' and month(tanggal) = '".$bulan."' and year(tanggal) = '".$tahun."'");
	
	$result=1;
	if ($saldo != 0 and $laporan != 0) $result = 1;
	else if (($saldo != 0 and $laporan == 0) and $past != strtotime($saldoawal['tanggal_awal'])) $result = 0;
	else if (($saldo == 0 and $laporan == 0) and $past == $now) $result = 0;

	return $result;
}


function data_person_hutang_piutang($id,$tipe) {

	$sql =  "select 
		p.nama as nama_terkait,
		inst.nama as nama_instansi,
		hp.status as status_terkait, 
		hp.id_terkait as id_terkait
		from hutang_piutang hp
		left join penduduk p on (p.id = hp.id_terkait)
		left join instansi_relasi inst on (inst.id = hp.id_terkait)
		where hp.id_terkait = '".$id."' and hp.status = '".$tipe."'";
	return _select_unique_result($sql);
	
}

function data_list_hutang_piutang($tipe=null,$status=null) {

	if ($tipe != null) $tipe = "hp.tipe = '$tipe'";
	if ($status != null) $status = "hp.status = '$status'";
	
	$konj1 = "";
	$konj2 = "";
	
	if ($tipe != null and $status==null) {
		$konj1 = " where ";
	} else if ($tipe != null and $status != null) {
		$konj1 =" where "; $konj2=" and ";
	} else if ($tipe == null and $status !=null) {
		$konj2 = " where ";
	}
	
	
	$sql = "select 
		p.nama as nama_terkait,
		inst.nama as nama_instansi,
		hp.status as status_terkait, 
		hp.id_terkait as id_terkait,
		hp.tipe as tipe
		from hutang_piutang hp 
		join jurnal ju on (ju.id=hp.id_jurnal)
		left join penduduk p on (p.id = hp.id_terkait)
		left join instansi_relasi inst on (inst.id = hp.id_terkait) $konj1 $tipe $konj2 $status
		group by hp.id_terkait, hp.status,hp.tipe order by ju.tanggal,ju.id,hp.tipe";
	
	return _select_arr($sql);


}

function data_hutang_piutang($id,$tipe,$status) {

    $result=array();
    
    $sql = mysql_query("select 
		p.nama as nama_terkait,
		inst.nama as nama_instansi,
		hp.status as status_terkait, 
		hp.id_terkait as id_terkait,
		ju.*
		from hutang_piutang hp 
		join jurnal ju on (ju.id=hp.id_jurnal)
		left join penduduk p on (p.id = hp.id_terkait)
		left join instansi_relasi inst on (inst.id = hp.id_terkait) where hp.id_terkait = '".$id."' and hp.tipe = '".$tipe."' and hp.status='".$status."' order by ju.tanggal,ju.id");

	
	if (mysql_num_rows($sql) != 0) {
	while($row=mysql_fetch_array($sql)) {
		$data=array();
		$data['nama_terkait'] = $row['nama_terkait'];
		$data['nama_instansi'] = $row['nama_instansi'];
		$data['status_terkait'] = $row['status_terkait'];
		$data['id_terkait'] = $row['id_terkait'];
		$data['tanggal'] = $row['tanggal'];
		$data['id'] = $row['id'];
		$data['nama'] = $row['nama'];
		$data['nomor_bukti'] = $row['nomor_bukti'];
		$data['jumlah'] = $row['jumlah'];
		
		$sql_rek_debet = mysql_query("select kr.id as kategori,r.kode,r.id, r.nama as nama_rekening ,dj.jumlah as jumlah, r.status as status 
			from detail_jurnal dj 
			join rekening r on(dj.id_rekening=r.id) 
			join kategori_rekening kr on(r.id_kategori=kr.id)
			and dj.id_jurnal = '".$row['id']."' and dj.status = 'd'");

		while($row_debet = mysql_fetch_array($sql_rek_debet)) {
			$data_debet = array(
				"id_rekening" => $row_debet['id'],
				"kode_rekening" => $row_debet['kode'],
				"nama_rekening" => $row_debet['nama_rekening'],
				"jumlah_rekening" => $row_debet['jumlah'],
				"status" => $row_debet['status'],
				"kategori"=> $row_debet['kategori']
			);
			$data['rekening_debet'][] = $data_debet;
		}	
		
		$sql_rek_kredit = mysql_query("select kr.id as kategori, r.kode,r.id, r.nama as nama_rekening ,dj.jumlah as jumlah, r.status as status 
			from detail_jurnal dj 
			join rekening r on(dj.id_rekening=r.id)
			join kategori_rekening kr on(r.id_kategori=kr.id)
			and dj.id_jurnal = '".$row['id']."' and dj.status = 'k'");

		while($row_kredit = mysql_fetch_array($sql_rek_kredit)) {
			$data_kredit = array(
				"id_rekening" => $row_kredit['id'],
				"kode_rekening" => $row_kredit['kode'],
				"nama_rekening" => $row_kredit['nama_rekening'],
				"jumlah_rekening" => $row_kredit['jumlah'],
				"status" => $row_kredit['status'],
				"kategori"=> $row_kredit['kategori']
			);
			$data['rekening_kredit'][] = $data_kredit;
		}	
		if(count($data['rekening_kredit']) < count($data['rekening_debet'])) $data['jumlah_max_rekening'] = count($data['rekening_debet']);
		else $data['jumlah_max_rekening'] = count($data['rekening_kredit']);
	    
		$result[]=$data;
	}
	
	} 
	
	return $result;

}

function data_bukubesar($bulan,$tahun,$no_rekening,$tipe) {
	$sql = "select
			j.nama as nama,
			j.nomor_bukti as nomor_bukti,
			j.tanggal as tanggal_jurnal,
			j.jumlah as jumlah_transaksi,
			r.id as id_rekening,
			r.status as status,
			dj.jumlah as jumlah_rekening,
			dj.status as status_rekening
			from rekening r
			join detail_jurnal dj on (dj.id_rekening=r.id)
			join jurnal j on (dj.id_jurnal=j.id)
			where YEAR(j.tanggal)='$tahun' AND MONTH(j.tanggal)='$bulan' AND r.id='".$no_rekening."' and j.status='".$tipe."' order by j.tanggal, j.id";
    return _select_arr($sql);
}

function data_saldobulanlalu($bulan,$tahun,$rekening) {
	set_time_zone();
	$data=array();

	$sql = "select tanggal from saldo";

	if (_num_rows($sql) != 0) {
		$min_tanggal ="select min(tanggal) as tanggal_awal from saldo";
		$data_tanggal_awal=_select_unique_result($min_tanggal);
		$tanggal=$data_tanggal_awal['tanggal_awal'];
			
		$strAwal = strtotime($tanggal);
		$strAkhir = strtotime($tahun."-".$bulan."-01");
		
		$ulang=0;
		$ketemu=0;

		while($strAkhir >= $strAwal and $ketemu!=1) {

			$date = date("Y-m-d",strtotime("-1month",$strAkhir));
			$bulan_data = date("m",strtotime($date));
			$tahun_data = date("Y",strtotime($date));

			$sql="select jumlah_akhir from saldo where YEAR(tanggal) = '".$tahun_data."' and MONTH(tanggal) = '".$bulan_data."' and id_rekening = '".$rekening."'";
			$result=_num_rows($sql);
			
			if ($result!=0) {
				$ketemu=1;
				$data=_select_unique_result($sql);
			} else {
				$data['jumlah_akhir']=0;
			}
			
			$strAkhir = strtotime($date);	
			$ulang+=1;
		}
	
		if ($ulang==0) $total=0;
		else $total = $data['jumlah_akhir'];
	} else {
	$total=0;
	}
	
	return $total;
}

function hapus_full_saldo($bulan,$tahun,$rekening) {
	$cek = _num_rows("select * from detail_jurnal dj join jurnal j on (dj.id_jurnal=j.id) and dj.id_rekening='".$rekening."' and month(j.tanggal) = '".$bulan."' and year(j.tanggal) = '".$tahun."'");
	if ($cek == 0) _delete("delete from saldo where id_rekening = '".$rekening."' and month(tanggal) = '".$bulan."' and year(tanggal) = '".$tahun."'");	
}

function simpan_bukubesar($saldo,$bulan,$tahun,$rekening,$tipe) {

	set_time_zone();
	$sql="select MONTH(tanggal) as bulan,YEAR(tanggal) as tahun, jumlah, jumlah_disesuaikan from saldo where YEAR(tanggal) = '".$tahun."' and MONTH(tanggal) = '".$bulan."' and id_rekening = '".$rekening."'";

	if (_num_rows($sql)!=0) {
		$data_temp = _select_unique_result($sql);
		
	    if ($tipe == 1) {
			$saldoakhir = $saldo+$data_temp['jumlah_disesuaikan'];
			_update("update saldo set jumlah='".$saldo."', jumlah_akhir='".$saldoakhir."' where YEAR(tanggal) = '".$tahun."' and MONTH(tanggal) = '".$bulan."' and id_rekening = '".$rekening."'");
			return $saldoakhir;
	    } else {
			$saldoakhir = $saldo+$data_temp['jumlah'];
			$saldosimpan = ($saldo==0)?"NULL":$saldo;
			_update("update saldo set jumlah_disesuaikan='".$saldosimpan."', jumlah_akhir='".$saldoakhir."' where YEAR(tanggal) = '".$tahun."' and MONTH(tanggal) = '".$bulan."' and id_rekening = '".$rekening."'");
			
			$bulan = (strlen($bulan)==1)?"0".$bulan:$bulan;
			
			transaksi_jurnalumum($bulan,$tahun,$rekening,$saldoakhir);
			
		}
	} else {

		$saldoakhir = $saldo;
	    if ($tipe == 1) {
			_insert("insert into saldo (jumlah,jumlah_akhir,tanggal,id_rekening) values('".$saldo."','".$saldoakhir."','".$tahun."-".$bulan."-01','".$rekening."')");
			return $saldoakhir;
		} else {
			_insert("insert into saldo (jumlah_disesuaikan,jumlah_akhir,tanggal,id_rekening) values('".$saldo."','".$saldoakhir."','".$tahun."-".$bulan."-01','".$rekening."')");
		}
	}
	
}



function transaksi_jurnalumum($bulan_data,$tahun_data,$rekening,$jumlah_data=null) {
	
	if (isset($jumlah_data)) {
		
		$saldo_awal = $jumlah_data;
		$tanggal_awal = $tahun_data."-".$bulan_data."-01";
	
	} else {
		set_time_zone();
		$sql_saldo_awal = "select jumlah_akhir,tanggal from saldo where id_rekening = '".$rekening."'and (tanggal = (select min(tanggal) from saldo where id_rekening = '".$rekening."') or tanggal = (select min(tanggal) from hasil_laporan_akuntansi where id_rekening = '".$rekening."')) order by tanggal desc";
		if (_num_rows($sql_saldo_awal) == 0) {
			$sql = _select_arr("select tanggal from saldo group by tanggal");
			foreach ($sql as $row) {
				_insert("insert into saldo (tanggal,jumlah,jumlah_akhir,id_rekening) values ('".$row['tanggal']."','0','0','".$rekening."')");
			}
		}
		$saldo_awal_result = _select_unique_result($sql_saldo_awal);
		$saldo_awal = $saldo_awal_result['jumlah_akhir'];
		$tanggal_awal = $saldo_awal_result['tanggal'];
	}
	$tanggal_current = date('Y-m')."-01";
	$tanggal_lanjut = $tanggal_awal;
	
		echo "<br><br>";
	
	$counting=1;
	while(strtotime($tanggal_current)>strtotime($tanggal_lanjut)) {
		$tanggal_ambil = ($counting==1)?$tanggal_awal:$tanggal_lanjut;
		$bulan = date("m",strtotime("+1month",strtotime($tanggal_ambil)));
		$tahun = date("Y",strtotime("+1month",strtotime($tanggal_ambil)));
		
		$bukubesar = data_bukubesar($bulan,$tahun,$rekening,1);
		
		if (count($bukubesar>0)) {
			$saldo=($counting==1)?$saldo_awal:$saldoakhir;
			foreach ($bukubesar as $row):
			   if ($row['status']==1) {
					if ($row['status_rekening']=="d") $saldo+=$row['jumlah_rekening'];
					else $saldo-=$row['jumlah_rekening'];
				} else {
					if ($row['status_rekening']=="d") $saldo-=$row['jumlah_rekening'];
					else $saldo+=$row['jumlah_rekening'];
				}
			endforeach;
			$saldoakhir=simpan_bukubesar($saldo,$bulan,$tahun,$rekening,1);
		} 
		
		$tanggal_lanjut = date("Y-m-d",strtotime("+1month",strtotime($tanggal_ambil)));
		
		$counting+=1;
	}
	
}


function transaksi_jurnalpenyesuaian($bulan,$tahun,$rekening) {

	$bukubesar = data_bukubesar($bulan,$tahun,$rekening,2);
	
	$saldo=0;
    foreach ($bukubesar as $row):
	   if ($row['status']==1) {
                if ($row['status_rekening']=="d") {
                    $saldo+=$row['jumlah_rekening'];
                } else {
                    $saldo-=$row['jumlah_rekening'];
                }
	    } else {
				if ($row['status_rekening']=="d") {
                    $saldo-=$row['jumlah_rekening'];
                } else {
                    $saldo+=$row['jumlah_rekening'];
                }
		}
	endforeach;
		
	simpan_bukubesar($saldo,$bulan,$tahun,$rekening,2); 
	
}


function format_labarugi_muat_data(){
	$data['penjumlah'] = _select_arr("select kr.nama,kr.id from format_laporan_akuntansi fla join kategori_rekening kr on fla.id_kategori_rekening=kr.id where id_laporan='1' and ket1='penjumlah' and waktu <>'0000-00-00 00:00:00' ");
	$data['pengurang'] = _select_arr("select kr.nama,kr.id from format_laporan_akuntansi fla join kategori_rekening kr on fla.id_kategori_rekening=kr.id where id_laporan='1' and ket1='pengurang' and waktu <>'0000-00-00 00:00:00'");
	return $data;
}

function format_perubahan_modal_muat_data(){
	$data['penjumlah'] = _select_arr("select kr.nama,kr.id from format_laporan_akuntansi fla join kategori_rekening kr on fla.id_kategori_rekening=kr.id where  id_laporan='2' and ket1='penjumlah' and waktu <>'0000-00-00 00:00:00' ");
	$data['pengurang'] = _select_arr("select kr.nama,kr.id from format_laporan_akuntansi fla join kategori_rekening kr on fla.id_kategori_rekening=kr.id where  id_laporan='2' and ket1='pengurang' and waktu <>'0000-00-00 00:00:00'");
	return $data;
}

function format_neraca_muat_data(){
	$data['penjumlah_kiri'] = _select_arr("select kr.nama,kr.id from format_laporan_akuntansi fla join kategori_rekening kr on fla.id_kategori_rekening=kr.id where  id_laporan='3' and ket1='penjumlah' and ket2='kiri' and waktu <>'0000-00-00 00:00:00' ");
	$data['pengurang_kiri'] = _select_arr("select kr.nama,kr.id from format_laporan_akuntansi fla join kategori_rekening kr on fla.id_kategori_rekening=kr.id where  id_laporan='3' and ket1='pengurang' and ket2='kiri' and waktu <>'0000-00-00 00:00:00' ");
	$data['penjumlah_kanan'] = _select_arr("select kr.nama,kr.id from format_laporan_akuntansi fla join kategori_rekening kr on fla.id_kategori_rekening=kr.id where  id_laporan='3' and ket1='penjumlah' and ket2='kanan' and waktu <>'0000-00-00 00:00:00' ");
	$data['pengurang_kanan'] = _select_arr("select kr.nama,kr.id from format_laporan_akuntansi fla join kategori_rekening kr on fla.id_kategori_rekening=kr.id where  id_laporan='3' and ket1='pengurang' and ket2='kanan' and waktu <>'0000-00-00 00:00:00' ");
	return $data;
}

function laporan_labarugi_muat_data($bulan=NULL,$tahun=NULL,$option=NULL){
	$counter["pengurang"]=0;
	$counter["penjumlah"]=0;
	$data['penjumlah'] = array();$data['pengurang'] = array();
	$row_kategori = _select_arr("select 
					fla.ket1,fla.ket2,
					kr.id,kr.nama
					from format_laporan_akuntansi fla 
					left join kategori_rekening kr on fla.id_kategori_rekening=kr.id 
					where fla.id_laporan='1' group by kr.nama order by fla.id");
	foreach($row_kategori as $kat){
		$data[$kat['ket1']][$kat['nama']]=array();
		$record = _select_arr("select 
					r.kode,r.nama as nama_rek,
					s.jumlah as jumlah_saldo,
					s.jumlah_disesuaikan as penyesuaian
					from rekening r 
					left join saldo s on r.id=s.id_rekening
					where r.id_kategori='".$kat['id']."' and MONTH(s.tanggal)='$bulan' and  YEAR(s.tanggal)='$tahun' order by r.kode");
		foreach($record as $datas){
			$saldo = ($datas['penyesuaian']==NULL )?$datas['jumlah_saldo']:$datas['jumlah_saldo']+$datas['penyesuaian'];
			$data[$kat['ket1']][$kat['nama']][]=array(
				'nama_rek'=>$datas['nama_rek'],
				'kode_rek'=>$datas['kode'],
				'saldo'=>$saldo
			);
			$counter[$kat['ket1']] += $saldo;
		}
	}
		$sum = $counter['penjumlah']-$counter['pengurang'];
		cek_hasil_laporan($bulan,$tahun,$sum,'lr');
	if($option!=NULL){
		return $sum;
	}
	return $data;
}

function cek_hasil_laporan($bulan,$tahun,$jumlah,$laporan){
    
	$status = ($jumlah>0)?'positif':'negatif';
	if($laporan=='lr'){
		$sql_cek = countrow("select * from hasil_laporan_akuntansi where id_laporan = '1' and MONTH(tanggal)='".$bulan."' and YEAR(tanggal)='".$tahun."' ");
		if($sql_cek>0){
			_update("update hasil_laporan_akuntansi set jumlah='".$jumlah."',status='".$status."' where id_laporan = '1' and MONTH(tanggal)='".$bulan."' and YEAR(tanggal)='".$tahun."'");
		}else{
			_insert("insert into hasil_laporan_akuntansi(id_laporan,tanggal,jumlah,status) values('1','".$tahun.'-'.$bulan.'-'.date('d')."','".$jumlah."','".$status."')");
		}		
	}else if($laporan=='pm'){
		$sql_cek = countrow("select * from hasil_laporan_akuntansi where id_laporan = '2' and MONTH(tanggal)='".$bulan."' and YEAR(tanggal)='".$tahun."' ");
		if($sql_cek>0){
			_update("update hasil_laporan_akuntansi set jumlah='".$jumlah."',status='".$status."' where id_laporan = '2' and MONTH(tanggal)='".$bulan."' and YEAR(tanggal)='".$tahun."'");
		}else{
			_insert("insert into hasil_laporan_akuntansi(id_laporan,tanggal,jumlah,status) values('2','".$tahun.'-'.$bulan.'-'.date('d')."','".$jumlah."','".$status."')");
		}		
	}else if($laporan=='n'){
			$sql_cek = countrow("select * from hasil_laporan_akuntansi where id_laporan = '3' and MONTH(tanggal)='".$bulan."' and YEAR(tanggal)='".$tahun."' ");
		if($sql_cek>0){
			_update("update hasil_laporan_akuntansi set jumlah='".$jumlah."',status='".$status."' where id_laporan = '3' and MONTH(tanggal)='".$bulan."' and YEAR(tanggal)='".$tahun."'");
		}else{
			_insert("insert into hasil_laporan_akuntansi(id_laporan,tanggal,jumlah,status) values('3','".$tahun.'-'.$bulan.'-'.date('d')."','".$jumlah."','".$status."')");
		}		
	}
}

function perubahan_modal_muat_data($bulan=NULL,$tahun=NULL,$option=NULL){
	$counter["pengurang"]=0;
	$counter["penjumlah"]=0;
	$lr = laporan_labarugi_muat_data($bulan,$tahun,"generate");
	$data['penjumlah'] = array();$data['pengurang'] = array();
	$row_kategori = _select_arr("select 
					fla.ket1,fla.ket2,
					kr.id,kr.nama
					from format_laporan_akuntansi fla 
					left join kategori_rekening kr on fla.id_kategori_rekening=kr.id 
					where fla.id_laporan='2' group by kr.nama order by fla.id");
	foreach($row_kategori as $kat){
		$data[$kat['ket1']][$kat['nama']]=array();
		$record = _select_arr("select 
					r.kode,r.nama as nama_rek,
					s.jumlah as jumlah_saldo,
					s.jumlah_disesuaikan as penyesuaian
					from rekening r 
					left join saldo s on r.id=s.id_rekening
					where r.id_kategori='".$kat['id']."' and MONTH(s.tanggal)='$bulan' and  YEAR(s.tanggal)='$tahun' order by r.kode");
		foreach($record as $datas){
			$saldo = ($datas['penyesuaian']==NULL)?$datas['jumlah_saldo']:$datas['jumlah_saldo']+$datas['penyesuaian'];
			$data[$kat['ket1']][$kat['nama']][]=array(
				'nama_rek'=>$datas['nama_rek'],
				'kode_rek'=>$datas['kode'],
				'saldo'=>$saldo
			);
			$counter[$kat['ket1']] += $saldo;
		}
	}
	//$lr = _select_unique_result("select jumlah from hasil_laporan_akuntansi where id_laporan='1' and MONTH(tanggal)='$bulan' and  YEAR(tanggal)='$tahun'");
	$data['labarugi']=$lr;
	cek_hasil_laporan($bulan,$tahun,($lr+$counter['penjumlah'])-$counter['pengurang'],'pm');
	if($option!=NULL){
		return ($lr+$counter['penjumlah'])-$counter['pengurang'];
	}
	return $data;
}

function neraca_muat_data($bulan=NULL,$tahun=NULL){
	$counter['kiri']["pengurang"]=0;
	$counter['kiri']["penjumlah"]=0;
	$counter['kanan']["pengurang"]=0;
	$counter['kanan']["penjumlah"]=0;
	$pm = perubahan_modal_muat_data($bulan,$tahun,'generate');
	$data['kanan']['pengurang']=array();
	$row_kategori = _select_arr("select 
					fla.ket1,fla.ket2,
					kr.id,kr.nama
					from format_laporan_akuntansi fla 
					left join kategori_rekening kr on fla.id_kategori_rekening=kr.id 
					where fla.id_laporan='3' and kr.id<>'6' group by kr.nama order by fla.id");
	foreach($row_kategori as $kat){
		$data[$kat['ket2']][$kat['ket1']][$kat['nama']]=array();
		$record = _select_arr("select 
					r.kode,r.nama as nama_rek,
					s.jumlah as jumlah_saldo,
					s.jumlah_disesuaikan as penyesuaian
					from rekening r 
					left join saldo s on r.id=s.id_rekening
					where r.id_kategori='".$kat['id']."' and MONTH(s.tanggal)='$bulan' and  YEAR(s.tanggal)='$tahun' order by r.kode");
		foreach($record as $datas){
			$saldo = ($datas['penyesuaian']==NULL )?$datas['jumlah_saldo']:$datas['jumlah_saldo']+$datas['penyesuaian'];
			$data[$kat['ket2']][$kat['ket1']][$kat['nama']][]=array(
				'nama_rek'=>$datas['nama_rek'],
				'kode_rek'=>$datas['kode'],
				'saldo'=>$saldo
			);
			$counter[$kat['ket2']][$kat['ket1']] += $saldo;
		}
	}
	
	//$lr = _select_unique_result("select jumlah from hasil_laporan_akuntansi where id_laporan='2' and MONTH(tanggal)='$bulan' and  YEAR(tanggal)='$tahun'");
	$data['perubahanmodal']=$pm;
	cek_hasil_laporan($bulan,$tahun,$counter['kiri']['penjumlah']-$counter['kiri']['pengurang'],'n');
	return $data;
}

function neracasaldo_muatdata($bulan,$tahun) {
	
	$sql="
	select s.*,r.status,r.nama,r.kode
	from rekening r 
	join saldo s on (r.id=s.id_rekening) and s.id IN (
	select s.id
	from rekening r 
	join saldo s on (r.id=s.id_rekening)
	join detail_jurnal dj on (r.id=dj.id_rekening)
	join jurnal jr on (jr.id=dj.id_jurnal)
	and month(s.tanggal) = '".$bulan."' and year(s.tanggal) = '".$tahun."' 
	and month(jr.tanggal) = '".$bulan."' and year(jr.tanggal) = '".$tahun."' union select id from saldo where month(tanggal) = '".$bulan."' and year(tanggal) = '".$tahun."' and jumlah_akhir !=0)
	order by r.kode";

	return _select_arr($sql);
}

function check_saldoavailable() {
	$sql = "select month(tanggal) as bulan, year(tanggal) as tahun from saldo order by tanggal";
	if (_num_rows($sql)>0) {
		$data = _select_unique_result($sql);
		$result=array('set'=>count($data),'bulan' => $data['bulan'],'tahun' => $data['tahun']);
	} else {
		$result=array('set'=>0,'bulan'=>0,'tahun'=>0);
	}
	return $result;
}

function kertas_kerja_muat_data($bulan,$tahun){
	$data=array();
	$sql_data_rek = _select_arr("select 
		kr.nama as nama_kategori,
		rek.id as id_rekening,
		rek.status as debet_kredit,
		rek.nama as nama_rekening,
		(select jumlah from saldo where id_rekening=rek.id and month(tanggal)='$bulan' and year(tanggal)='$tahun') as saldo,
		(select jumlah_disesuaikan from saldo where id_rekening=rek.id and month(tanggal)='$bulan' and year(tanggal)='$tahun') as saldo_disesuaikan,
		s.jumlah_akhir,
		(select jumlah_akhir from saldo where id_rekening=rek.id and month(tanggal)='$bulan' and year(tanggal)='$tahun' and rek.id in (select id from rekening where id_kategori in(select id_kategori_rekening from format_laporan_akuntansi where id_laporan='1'))) as laba_rugi,
		(select jumlah_akhir from saldo where id_rekening=rek.id and month(tanggal)='$bulan' and year(tanggal)='$tahun' and rek.id in (select id from rekening where id_kategori in(select id_kategori_rekening from format_laporan_akuntansi where id_laporan in('2','3')))) as neraca
		from 
		rekening rek join kategori_rekening kr on rek.id_kategori=kr.id
		join saldo s on rek.id=s.id_rekening
		where month(s.tanggal)='$bulan' and year(s.tanggal)='$tahun' and kr.id in('1','4','10','2','6','5','7','3','11') group by rek.id");
	foreach($sql_data_rek as $data_rek){
		$kredit3 =$debet3=$debet4=$kredit4="";
		$debet = ($data_rek["debet_kredit"]=='1')?$data_rek['saldo']:"";
		$kredit = ($data_rek["debet_kredit"]=='2')?$data_rek['saldo']:"";
		$debet_penyesuaian = ($data_rek["debet_kredit"]=='1')?(($data_rek['saldo_disesuaikan']!=NULL)?$data_rek['saldo_disesuaikan']:""):"";
		$kredit_penyesuaian = ($data_rek["debet_kredit"]=='2')?(($data_rek['saldo_disesuaikan']!=NULL)?$data_rek['saldo_disesuaikan']:""):"";
		$debet_ns = ($data_rek["debet_kredit"]=='1')?(($data_rek['jumlah_akhir']!=NULL)?$data_rek['jumlah_akhir']:""):"";
		$kredit_ns = ($data_rek["debet_kredit"]=='2')?(($data_rek['jumlah_akhir']!=NULL)?$data_rek['jumlah_akhir']:""):"";
		
		if(($debet_penyesuaian)>0){
			$debet3 = $debet_penyesuaian;	
		}else if($debet_penyesuaian<0){
			$kredit3 = $debet_penyesuaian;
		}
		if(($kredit_penyesuaian)>0){
			$kredit3 = $kredit_penyesuaian;
		}else if($kredit_penyesuaian<0){
			$debet3 = $kredit_penyesuaian;
		}
		if($debet_ns>0){
			$debet4 = $debet_ns;
		}else if($debet_ns<0){
			$kredit4 = $debet_ns;
		}
		if($kredit_ns>0){
			$kredit4 = $kredit_ns;
		}else if($kredit_ns<0){
			$debit4 = $kredit_ns;
		}
		$data[$data_rek["nama_kategori"]][] =array(
		'nama_rek'=>$data_rek['nama_rekening'],
		'saldo'=>array(
			'debet'=>$debet,
			'kredit'=>$kredit
		),
		'penyesuaian'=>array(
			'debet'=>abs($debet3),
			'kredit'=>abs($kredit3)
		),
		'saldo_disesuaikan'=>array(
			'debet'=>abs($debet4),
			'kredit'=>abs($kredit4)
		),
		'laba_rugi'=>array(
			'debet'=>($data_rek["debet_kredit"]=='1')?(($data_rek['laba_rugi']!=NULL )? $data_rek['laba_rugi']:""):"",
			'kredit'=>($data_rek["debet_kredit"]=='2')?(($data_rek['laba_rugi']!=NULL )? $data_rek['laba_rugi']:""):""
		),
		'neraca'=>array(
			'debet'=>($data_rek["debet_kredit"]=='1')?(($data_rek['neraca']!=NULL )? $data_rek['neraca']:""):"",
			'kredit'=>($data_rek["debet_kredit"]=='2')?(($data_rek['neraca']!=NULL )? $data_rek['neraca']:""):""
		)
		);
	}
	return $data;
}

function setting_waktu_muat_data(){
	$data = _select_unique_result("select tutup_kas as waktu from setting");
	return $data;
}

function laporan_harian_muat_data($tanggal=NULL){
	set_time_zone();
	$idBillingRecord=array();
	$idBillingRecordSisa=array();
	$idPembayaranBilling=array();
	$result["non_piutang"]=array();
	$result["piutang_terbayar"]='0';
	$result["piutang_diterima"]='0';
	$result["piutang_belum_terbayar"] = '0';
	$array_time = setting_waktu_muat_data();
	$time = (isset($array_time["waktu"]) && $array_time["waktu"]!="")?$array_time["waktu"]:date("H:m:s");
	$awal = date("Y-m-d", strtotime("-1day",strtotime($tanggal)))." ".date("H:i:s",strtotime("+1sec",strtotime($time)));
	$akhir = $tanggal." ".$time;
	$awal2 = $tanggal." ".date("H:i:s",strtotime("+1sec",strtotime($time)));
	$akhir2 = date("Y-m-d", strtotime("+1day",strtotime($tanggal)))." 00:00:00";
	// query detail pembayaran billing pada tanggal bersangkutan
	$data = _select_arr("select 
                        p.waktu as tanggal_jam,
                        date(p.waktu) as tanggal_bayar,
                        time(p.waktu) as jam_bayar,
                        p.id as id_pembayaran,
                        p.jumlah_tagihan,
                        (p.jumlah_bayar-p.jumlah_kembalian) as jumlah_bayar,
                        p.jumlah_sisa_tagihan as sisa_tagihan,
                        dp.id_penjualan_billing as id_billing,
                        date(b.waktu) as tanggal_billing,
                        (select 1=1) as status
                        from pembayaran p
                        join detail_pembayaran dp on p.id=dp.id_pembayaran_billing
                        join billing b on dp.id_penjualan_billing = b.id
                        where p.waktu between '$awal' and '$akhir'
			union select 
                        p.waktu as tanggal_jam,
                        date(p.waktu) as tanggal_bayar,
                        time(p.waktu) as jam_bayar,
                        p.id as id_pembayaran,
                        p.jumlah_tagihan,
                        (p.jumlah_bayar-p.jumlah_kembalian) as jumlah_bayar,
                        p.jumlah_sisa_tagihan as sisa_tagihan,
                        dp.id_penjualan_billing as id_billing,
                        date(b.waktu) as tanggal_billing,
                        (select 1+1) as status
                        from pembayaran p
                        join detail_pembayaran dp on p.id=dp.id_pembayaran_billing
                        join billing b on dp.id_penjualan_billing = b.id
                        where p.waktu between '$awal2' and '$akhir2'
			group by dp.id,b.id,p.waktu
			order by id_billing asc ,tanggal_jam asc ,tanggal_bayar asc ,status asc");
    
	foreach($data as $record){
		if($record["status"]=='1'){
			if(!array_key_exists($record["id_billing"],$idBillingRecordSisa)){
				$idBillingRecordSisa[$record["id_billing"]]=array('id_billing'=>$record["id_billing"]);
				$sisa = _select_unique_result("SELECT 
                                    (SELECT sum(db.frekuensi * tar.total) FROM detail_billing db join `tarif` tar on db.id_tarif=tar.id WHERE db.id_billing='".$record["id_billing"]."' and db.waktu<'$akhir2')
                                        -
                                    (SELECT sum(p.`jumlah_bayar`- p.`jumlah_kembalian`) FROM pembayaran p join detail_pembayaran dp on p.id=dp.id_pembayaran_billing WHERE dp.id_penjualan_billing='".$record["id_billing"]."' and p.waktu<'$akhir2') as total_sisa");
                              
                                $idBillingRecordSisa[$record["id_billing"]]=array('sisa_tagihan'=>$sisa['total_sisa']);		
			}
			if($record["sisa_tagihan"]==0  && $idBillingRecordSisa[$record["id_billing"]]['sisa_tagihan']==0 && (strtotime($record['tanggal_billing'])==strtotime($record['tanggal_bayar'])) ){
				if(!array_key_exists($record["id_billing"],$idBillingRecord)){
					$idBillingRecord[$record["id_billing"]]=true;
						$sql_layanan = mysql_query("select 
						t.total as total_tarif,l.nama as nama_layanan,
						l.jenis as jenis_layanan,db.frekuensi as frekuensi,
						ins.nama as nama_instalasi
						from billing b 
						join detail_billing db on b.id = db.id_billing 
						join tarif t on db.id_tarif=t.id 
						join layanan l on t.id_layanan=l.id
						join instalasi ins on l.id_instalasi=ins.id
						where b.id='".$record["id_billing"]."' and db.waktu<'$akhir2'
						");
						while($row = mysql_fetch_assoc($sql_layanan)){
							$result["non_piutang"][str_replace(" ","_",$row["jenis_layanan"])][$row["nama_instalasi"]]=array(
								'total'=>(isset($result["non_piutang"][str_replace(" ","_",$row["jenis_layanan"])][$row["nama_instalasi"]]))?$result["non_piutang"][str_replace(" ","_",$row["jenis_layanan"])][$row["nama_instalasi"]]["total"]+($row["total_tarif"]*$row["frekuensi"]):($row["total_tarif"]*$row["frekuensi"])
							);
						}
				}
			}else if($record["sisa_tagihan"]!=0  && $idBillingRecordSisa[$record["id_billing"]]['sisa_tagihan']!=0){
				$result["piutang_terbayar"] +=  $record["jumlah_bayar"];
			}
		}else{
                    if(!array_key_exists($record["id_pembayaran"],$idPembayaranBilling)){
                        $idPembayaranBilling[$record["id_pembayaran"]]=true;
			$result["piutang_diterima"] +=  $record["jumlah_bayar"];
                    }
		}
	}
	
	$billing_belum_terbayar = _select_unique_result("SELECT 
							((SELECT sum(db.frekuensi * tar.total) FROM detail_billing db join `tarif` tar on db.id_tarif=tar.id WHERE db.waktu < '$akhir2' ) -
							(SELECT sum(p.jumlah_bayar-p.jumlah_kembalian) from pembayaran p join detail_pembayaran dp on p.id=dp.id_pembayaran_billing where dp.id_penjualan_billing in(SELECT distinct(db.id_billing) FROM detail_billing db join `tarif` tar on db.id_tarif=tar.id WHERE db.waktu < '$akhir2') and p.waktu <'$akhir2')) as billing_belum_terbayar
	");
	
	$result["piutang_belum_terbayar"] += ($billing_belum_terbayar['billing_belum_terbayar']>0)?$billing_belum_terbayar['billing_belum_terbayar']:0;
	//$result["piutang_belum_terbayar"] += $billing_belum_terbayar['billing_belum_terbayar'];
	return $result;
}

function generateBulanSebelumnya($bulan,$tahun,$option=NULL){
	$bulan_terselect = $tahun."-".$bulan."-"."01";
	$record_bulan_sebelumnya = _select_arr("
		select concat(substr(tanggal,1,4),substr(tanggal,5,3)) as periode from saldo where concat(substr(tanggal,1,4),substr(tanggal,5,3)) not in(select concat(substr(tanggal,1,4),substr(tanggal,5,3)) from hasil_laporan_akuntansi where id_laporan='1') and date(tanggal)<'".$bulan_terselect."' group by concat(substr(tanggal,1,4),substr(tanggal,5,3)) 
	");
	foreach($record_bulan_sebelumnya as $data){
		$select = explode('-',$data['periode']);
			neraca_muat_data($select[1],$select[0]);
	}
	
}
function laporan_cash_piutang($tanggal=NULL){
	set_time_zone();

    $array_time = setting_waktu_muat_data();
    $time = (isset($array_time["waktu"]) && $array_time["waktu"]!="")?$array_time["waktu"]:date("H:m:s");
    $awal = date("Y-m-d", strtotime("-1day",strtotime($tanggal)))." ".date("H:i:s",strtotime("+1sec",strtotime($time)));
    $akhir = $tanggal." ".$time;
    
    $sqlCash = "select pb.jumlah_bayar,b.id as id_billing,pd.nama as nama_pas from detail_pembayaran dp
    join pembayaran pb on dp.id_pembayaran_billing = pb.id
    join billing b on dp.id_penjualan_billing = b.id
    join pasien ps on b.id_pasien = ps.id
    join penduduk pd on ps.id_penduduk = pd.id
    where dp.jenis = 'Jasa' and pb.waktu between '$awal' and '$akhir' and b.waktu between '$awal' and '$akhir'";
    $data['cash'] = _select_arr($sqlCash);
    
    $sqlPiutang = "select pb.jumlah_sisa_tagihan,b.id as id_billing,pd.nama as nama_pas from detail_pembayaran dp
    join pembayaran pb on dp.id_pembayaran_billing = pb.id
    join billing b on dp.id_penjualan_billing = b.id
    join pasien ps on b.id_pasien = ps.id
    join penduduk pd on ps.id_penduduk = pd.id
    where dp.jenis = 'Jasa' and (select jumlah_sisa_tagihan from pembayaran where id = (select max(id) from pembayaran where id = dp.id_pembayaran_billing)) > 0 
    and pb.id = (select max(id) from pembayaran where id = dp.id_pembayaran_billing) and b.waktu <= '$akhir' union
    select b.total_tagihan as jumlah_sisa_tagihan,b.id as id_billing,pd.nama as nama_pas from billing b 
    join pasien ps on b.id_pasien = ps.id
    join penduduk pd on ps.id_penduduk = pd.id
    where b.id not in (select id_penjualan_billing from detail_pembayaran where jenis = 'Jasa') and b.waktu <= '$akhir'";
    $data['piutang'] = _select_arr($sqlPiutang);
    
    $sqlPiutangDibayar = "select pb.jumlah_bayar,b.id as id_billing,pd.nama as nama_pas from detail_pembayaran dp
    join pembayaran pb on dp.id_pembayaran_billing = pb.id
    join billing b on dp.id_penjualan_billing = b.id
    join pasien ps on b.id_pasien = ps.id
    join penduduk pd on ps.id_penduduk = pd.id
    where dp.jenis = 'Jasa' and pb.waktu between '$awal' and '$akhir' and b.waktu < '$awal'";
    $data['piutang_dibayar'] = _select_arr($sqlPiutangDibayar);
    
    return $data;
}
?>

