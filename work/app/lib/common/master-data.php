<?php

include_once "app/lib/common/functions.php";

set_time_zone();
$now = date('Y-m-d');
$lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
function instalasi_muat_data($id = NULL, $sort = NULL, $sortBy=null, $key = NULL) {
    if ($id != NULL) {
        $action = "where id=$id";
    }else
        $action=null;

    if ($sort != NULL && $sort == 1) {
        $order = "order by id $sortBy";
    } else if ($sort != NULL && $sort == 2) {
        $order = "order by nama $sortBy";
    }else if($sort != NULL && $sort == 3){
        $order = "order by jenis $sortBy";
    }else $order = "order by nama asc";
    
    if($key != NULL){
        $where = "where nama like '%$key%'";
    }else $where = "";
    
    return _select_arr("select * from instalasi $action $where $order");
}

function layanan_muat_data($id = NULL,$sort = NULL,$sortBy=null, $page=NULL,$dataPerPage = null, $cari = null, $category= NULL) {
$action="";
    if ($id != NULL) {
        $action = "where l.id = '$id'";
    } 
	if ($cari!= NULL) {
        if ($category == 1) {
            $action .= "where l.nama like '%$cari%'";
        }else if($category == 2){
            $action .= "where p.nama like '%$cari%'";
        }
    }  
	
   if ($sort == 1) {
        $order = "order by l.id $sortBy";
    } else if ($sort != NULL && $sort == 2) {
        $order = "order by l.nama $sortBy";
    }else if($sort != NULL && $sort == 3){
        $order = "order by ins.nama $sortBy";
    }else if($sort != NULL && $sort == 4){
        $order = "order by s.nama $sortBy";
    }else if($sort != NULL && $sort == 5){
        $order = "order by p.nama $sortBy";
    }else $order = "order by l.nama asc";

    if (isset($dataPerPage) && $dataPerPage != null) {
            if ($page!=null) {
                $noPage = $page;
            } else {
                $noPage = 1;
            }
            $offset = ($noPage - 1) * $dataPerPage;
            $batas = "limit $offset, $dataPerPage";
        } else {
            $batas = '';
            $offset = '';
        }
    $sql="select l.*,kt.nama as nama_ktarif, p.nama as profesi,s.id as id_spesialisasi,s.nama as spesialisasi,ins.nama as instalasi,ins.id as id_instalasi from layanan l
            left join kategori_tarif kt on l.id_kategori_tarif=kt.id
            left join spesialisasi s on l.id_spesialisasi=s.id
            left join instalasi ins on l.id_instalasi=ins.id
            left join profesi p on s.id_profesi=p.id $action  $order $batas";
     //htiung total data
     $sqltotal="select * from layanan l $action";
    $result= _select_arr($sql);
    if($page!=NULL || $dataPerPage != null){
        //paging
        $result['list']=_select_arr($sql);
        $sqli="select l.*,p.nama as profesi,s.id as id_spesialisasi,s.nama as spesialisasi,ins.nama as instalasi,ins.id as id_instalasi from layanan l
            left join spesialisasi s on l.id_spesialisasi=s.id
            left join instalasi ins on l.id_instalasi=ins.id
            left join profesi p on s.id_profesi=p.id $action $order";
        $sqltotal="select * from layanan l $action";
        $result['paging'] = paging($sqli, $dataPerPage);
        $result['offset'] = $offset;
        return $result;
    }else{
        return $result;
    }

    
}



function layanan_kunjungan(){
    return _select_arr("select * from layanan where jenis='Rawat Jalan'");
}
function layanan_muat_data_by_jenis($jenis=null){
    if($jenis!=null){
        $where="where jenis='$jenis'";
    }else{
        $where="";
    }
    return _select_arr("select * from layanan $where");
}
function perkawinan_muat_data() {
    return _select_arr("select * from perkawinan");
}

function pendidikan_muat_data($id = null,$sort = NULL,$sortBy = NULL, $key=null) {
    $result = array();
    if ($id != null) {
        $require_once = "where id = '$id'";
    }else
        $require_once='';
    
    if($key != NULL){
      $cari = "where nama like ('%$key%')";      
    } else{
      $cari = '';
    }
    if($sort != NULL){
        if($sort == 1){
            $sorting = "order by id $sortBy";
        }else if($sort == 2){
            $sorting = "order by nama $sortBy";
        }
    }else $sorting = " order by nama asc ";
    
    return _select_arr("select * from pendidikan $require_once $cari $sorting ");
}

function agama_muat_data($id=null,$key=null) {
 $where=null;
 if ($id != null) {
 $where = " where id = '$id'";
}
if($key != NULL){
       $cari = "where nama like ('%$key%') ";
      } else
      $cari='';
  $result = array();
   $sql="select * from agama $where $cari order by id asc";

 if ($id != null) {
    	$result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    }else
      $result['list'] = _select_arr($sql);
	  
	   return $result;
}

function posisi_keluarga_muat_data() {
    return _select_arr("select * from posisi");
}

function profesi_muat_data($id = null, $sort = null,$sortBy = NULL, $key=null) {
    if($key != NULL){
       $cari = "where nama like ('%$key%')";
      } else
      $cari='';
      
    if ($sort == 1) {
        $sortir = "order by id $sortBy";
    }else if ($sort == 2) {
        $sortir = "order by nama $sortBy";
    }else $sortir = " order by nama asc ";
    
    $result = array();
    if ($id !=null) {
        $require_onced = "where id = '$id'";
    }else
        $require_onced="";
     
    $sql = "select * from profesi $require_onced $cari $sortir";
    $result = _select_arr($sql);
    return $result;
}

function pekerjaan_muat_data($id = null, $sort = null,$sortBy = null, $page=NULL,$dataPerPage = null, $key = null) {
    $sortir = "";

    if ($sort == 2) {
        $sortir = "order by id $sortBy";
    }else if ($sort == 1) {
        $sortir = "order by nama $sortBy";
    }else{
        $sortir=" order by nama asc ";
    }
    if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
    if (isset($dataPerPage) && $dataPerPage != null) {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas = "limit $offset, $dataPerPage";
    } else {
        $batas = '';
        $offset = '';
    }
	
	if ($key != null) {
		$cari = "where nama like ('%$key%')";
	}else{
            $cari='';
        }
	
    $result = array();
    if ($id != null) {
        $require_onced = "where id = '$id'";
    }else
        $require_onced='';
    $sql="select * from pekerjaan $cari $require_onced $sortir $batas";
    if ($id != null) {
       $result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    } else {
        $result['list'] = _select_arr($sql);
    }

        $sql="select * from pekerjaan $require_onced $sortir";
        if($dataPerPage!=null){
            $result['paging'] = paging($sql, $dataPerPage);
            $result['offset'] = $offset;
			$result['total'] = countrow($sql);
        }
	return $result;
    }




function kelas_muat_data($id=null) {
    $sql = "select kelas.id,kelas.nama,kelas.margin from kelas";
    if ($id == null) {
        return _select_arr($sql);
    } else {
        return _select_unique_result($sql . " where kelas.id='$id'");
    }
    //return $result;
}

function kelas_muat_data2($id=null, $key = NULL) {
 $where=null;
 if ($id != null) {
 $where = " where id = '$id'";
}
    if($key != NULL){
       $cari = "where nama like ('%$key%')";
      } else
      $cari=''; 
  $result = array();
    $sql = "select * from kelas $where $cari order by nama asc";
if ($id != null) {
    	$result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    }else
      $result['list'] = _select_arr($sql);
	  
	   return $result;
}


function kelas_instalasi_muat_data() {
    $sql = "select k.* from kelas k ";
    return _select_arr($sql);
}

function kelas_muat_data_by_instalasi($id_instalasi = NULL) {
    if ($id_instalasi != NULL) {
        $where = "where id_instalasi = '$id_instalasi'";
    }else
        $where = "";
    return _select_arr("select * from kelas $where");
}

function bed_muat_data_by_kelas($id_kelas = NULL) {
    if ($id_kelas != NULL) {
        $where = "where id_kelas = '$id_kelas'";
    }else
        $where = "";
    return _select_arr("select * from bed $where");
}

function bed_by_kelas_instalasi($id=NULL, $page=NULL, $dataPerPage = NULL, $sort = NULL,$bed=null,$category=NULL,$sortBy=NULL) {
    if(isset ($sort)){
        if($sort == 1){
            $order = "order by b.id $sortBy";
        }else if($sort == 2){
            $order = "order by i.nama $sortBy";
        }else if($sort == 3){
            $order = "order by k.nama $sortBy";
        }else if($sort == 4){
            $order = "order by b.nama $sortBy";
        }else if($sort == 5){
            $order = "order by b.status $sortBy";
        }else if($sort == 6){
            $order = "order by b.jenis $sortBy";
        }
    }else $order = "order by b.nama,i.nama,k.nama $sortBy";
    $where="where 1=1";
    if ($id != NULL) {
        $where .= " and b.id='$id'";
    }
    if ($bed != NULL) {
        if ($category == 1) {
            $where .= " and b.nama like '%$bed%'";
        }else if($category == 2){
            $where .= " and i.nama like '%$bed%'";
        }
    }    
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
    $sql = "select b.*, i.id as aidi, i.nama as instalasi,k.nama as kelas from bed b
        LEFT JOIN kelas k on k.id=b.id_kelas
        left join instalasi i on (b.id_instalasi=i.id) $where $order $batas";
    if ($id != null) {
        $result['list'] = _select_arr($sql);
        $result = $result['list'][0]; // what is this
    } else {
        $result['list'] = _select_arr($sql);
    }
$sqli = "select b.*,i.nama as instalasi,k.nama as kelas from bed b
        LEFT JOIN kelas k on k.id=b.id_kelas
        left join instalasi i on (b.id_instalasi=i.id) $where";

		$result['paging'] = paging($sqli, $dataPerPage);
    $result['offset'] = $offset;
    return $result;
}

function bed_muat_data_by_id($id){
    $sql="select b.*, i.id as aidi, i.nama as instalasi,k.nama as kelas from bed b
        LEFT JOIN kelas k on k.id=b.id_kelas
        left join instalasi i on (b.id_instalasi=i.id) where b.id=$id";
    
    return _select_unique_result($sql);
}

function tarif_muat_data($id = NULL, $page = null, $dataPerPage = null, $key = NULL, $sort=NULL, $sortBy=NULL) {

//    $action = " where t.status='Berlaku'";
    $action = "";
    if ($id != NULL) {
        $action .= "where t.id='$id'";
    }
$sortir = " order by id ASC ";
    if ($sort == 1) {
        $sortir = " order by id $sortBy";
    }
    if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }

    if($key != NULL&&$id == NULL){
        $action .= "where l.nama like ('%$key%')";
    }else if($key != NULL){
        $action .= " and l.nama like ('%$key%')";
    }

    $dataPerPage = $dataPerPage;
    $offset = ($noPage - 1) * $dataPerPage;
    $batas = "";
    if ($dataPerPage != null) {
        $batas = "limit $offset, $dataPerPage";
    }

    $sql = "select t.*,kt.nama as nama_ktarif, l.nama as layanan,l.bobot,l.jenis,ins.nama as instalasi,sp.id as id_spesialisasi,sp.nama as spesialisasi,pr.nama as profesi,k.nama as kelas from tarif t
        left join layanan l on t.id_layanan = l.id
        left join kategori_tarif kt on l.id_kategori_tarif=kt.id
        left join instalasi ins on l.id_instalasi=ins.id
        left join kelas k on t.id_kelas = k.id
        left join spesialisasi sp on l.id_spesialisasi=sp.id
        left join profesi pr on sp.id_profesi = pr.id $action $sortir $batas
	";
    
    if ($id != null) {
        $result['list'] = _select_arr($sql);
//        $result = $result['list'][0];
    } else {
        $result['list'] = _select_arr($sql);
    }

    $sqli = "
        select t.*,l.nama as layanan,l.bobot,l.jenis,ins.nama as instalasi,sp.id as id_spesialisasi,sp.nama as spesialisasi,pr.nama as profesi,k.nama as kelas from tarif t
        left join layanan l on t.id_layanan = l.id
        left join instalasi ins on l.id_instalasi=ins.id
        left join kelas k on t.id_kelas = k.id
        left join spesialisasi sp on l.id_spesialisasi=sp.id
        left join profesi pr on sp.id_profesi = pr.id $action";

    $result['paging'] = paging($sqli, $dataPerPage);
    $result['offset'] = $offset;
    return $result;
}

function pasien_muat_data($id = NULL, $key = NULL, $category = NULL, $sort = NULL,$sortBy=null, $page = null, $dataPerPage = null) {
    if ($id != NULL) {
        $action1 = "and p.id = '$id'";
    } else {
        $action1 = "";
    }

    if ($key != NULL) {
        if ($category == 1) {
            $action2 = "and p.id like ('%$key%')";
        } else if ($category == 2) {
            $action2 = "and pd.nama like ('%$key%')";
        } else if ($category == 3) {
            $action2 = "and pd.jenis_kelamin like ('%$key%')";
        } else if ($category == 4) {
            $action2 = "and dp.alamat_jalan like ('%$key%')";
        }
    } else {
        $action2 = "";
    }

    if ($sort != NULL) {
        if ($sort == 1) {
            $action3 = "order by p.id $sortBy";
        } else if ($sort == 2) {
            $action3 = "order by pd.nama $sortBy";
        } else if ($sort == 3) {
            $action3 = "order by pd.jenis_kelamin $sortBy";
        }
    }else
        $action3 = "order by p.id asc";

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
    $return = array();
    $sql = "select dp.id_agama,p.id as id_pas,ag.nama as agama, pkj.nama as pekerjaan,pd.*,pd.nama as nama_pas,dp.id, dp.*, k.nama as nama_kelurahan from penduduk pd
	join pasien p on (pd.id = p.id_penduduk)
	left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
        left join kelurahan k on (dp.id_kelurahan = k.id) 
        left join agama ag on dp.id_agama = ag.id
        left join pekerjaan pkj on dp.id_pekerjaan = pkj.id
	where dp.akhir = 1 $action1 $action2
	group by p.id $action3 $batas";
	  $sqltotal = "select dp.id_agama,p.id as id_pas, pd.*,pd.nama as nama_pas,dp.id, dp.*, k.nama as nama_kelurahan from penduduk pd
	join pasien p on (pd.id = p.id_penduduk)
	left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
    left join kelurahan k on (dp.id_kelurahan = k.id) 
	where dp.akhir = 1 $action1 $action2
	group by p.id $action3";
    if (isset($id)) {
        $return = _select_unique_result($sql);
		$return['total'] = countrow($sqltotal);
    } else {
        $return['list'] = _select_arr($sql);
        $sqli = "
        select p.id as id_pas, pd.*,pd.nama as nama_pas,dp.id, dp.*, k.nama as nama_kelurahan from penduduk pd
		join pasien p on (pd.id = p.id_penduduk)
		left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
        left join kelurahan k on (dp.id_kelurahan = k.id) where dp.akhir = 1 $action1 $action2
		group by p.id $action3";

        $return['paging'] = paging($sqli, $dataPerPage);
        $return['offset'] = $offset;
		$return['total'] = countrow($sqli);
    }




    return $return;
}
function informasi_pasien_muat_data($id = NULL, $key = NULL, $category = NULL, $sort = NULL,$sortBy=null, $page = null, $dataPerPage = null) {
    if ($id != NULL) {
        $action1 = "and p.id = '$id'";
    } else {
        $action1 = "";
    }

    if ($key != NULL) {
        if ($category == 1) {
            $action2 = "and p.id like ('%$key%')";
        } else if ($category == 2) {
            $action2 = "and pd.nama like ('%$key%')";
        } else if ($category == 3) {
            $action2 = "and pd.jenis_kelamin like ('%$key%')";
        } else if ($category == 4) {
            $action2 = "and k.nama like ('%$key%')";
        } else if ($category == 5) {
            $action2 = "and kec.nama like ('%$key%')";
        }
        
    } else {
        $action2 = "";
    }

    if ($sort != NULL) {
        if ($sort == 1) {
            $action3 = "order by p.id $sortBy";
        } else if ($sort == 2) {
            $action3 = "order by pd.nama $sortBy";
        } else if ($sort == 3) {
            $action3 = "order by pd.jenis_kelamin $sortBy";
        }
    }else
        $action3 = "order by p.id asc";

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
    $return = array();
    $sql = "select dp.id_agama,p.id as id_pas,ag.nama as agama, pkj.nama as pekerjaan,pd.*,pd.nama as nama_pas,dp.id, dp.*, k.nama as nama_kelurahan, 
    kec.nama as nama_kecamatan,kab.nama as nama_kabupaten,dp.no_telp,(select max(no_kunjungan_pasien) from kunjungan where kunjungan.id_pasien=p.id)as no_kunjungan
    from penduduk pd
	join pasien p on (pd.id = p.id_penduduk)
	left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
        left join kelurahan k on (dp.id_kelurahan = k.id) 
        left join kecamatan kec on (k.id_kecamatan = kec.id) 
        left join kabupaten kab on (kec.id_kabupaten = kab.id) 
        left join provinsi prov on (kab.id_provinsi = prov.id) 
        left join agama ag on dp.id_agama = ag.id
        left join pekerjaan pkj on dp.id_pekerjaan = pkj.id
	where dp.akhir = 1 $action1 $action2
	group by p.id $action3 $batas";
	  $sqltotal = "select dp.id_agama,p.id as id_pas, pd.*,pd.nama as nama_pas,dp.id, dp.*, k.nama as nama_kelurahan
    from penduduk pd
	join pasien p on (pd.id = p.id_penduduk)
	left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
    left join kelurahan k on (dp.id_kelurahan = k.id)    
     left join kecamatan kec on (k.id_kecamatan = kec.id) 
    left join kabupaten kab on (kec.id_kabupaten = kab.id) 
    left join provinsi prov on (kab.id_provinsi = prov.id) 
	where dp.akhir = 1 $action1 $action2
	group by p.id $action3";
    if (isset($id)) {
        $return = _select_unique_result($sql);
		$return['total'] = countrow($sqltotal);
    } else {
        $return['list'] = _select_arr($sql);
        $sqli = "
        select p.id as id_pas, pd.*,pd.nama as nama_pas,dp.id, dp.*, k.nama as nama_kelurahan from penduduk pd
		join pasien p on (pd.id = p.id_penduduk)
		left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
        left join kelurahan k on (dp.id_kelurahan = k.id)
        left join kecamatan kec on (k.id_kecamatan = kec.id) 
    left join kabupaten kab on (kec.id_kabupaten = kab.id) 
    left join provinsi prov on (kab.id_provinsi = prov.id) 
        where dp.akhir = 1 $action1 $action2
		group by p.id $action3";

        $return['paging'] = paging($sqli, $dataPerPage);
        $return['offset'] = $offset;
		$return['total'] = countrow($sqli);
    }




    return $return;
}
function pasien_opname_muat_data($id = NULL, $key = NULL, $category = NULL, $sort = NULL,$sortBy=null, $page = null, $dataPerPage = null) {
    $action1= " and p.id not in (select id_pasien from billing) and (select count(*) from kunjungan where kunjungan.id_pasien=p.id)<=1 ";
    if ($id != NULL) {
        $action1 .= "and p.id = '$id'";
    } else {
        $action1 .= "";
    }

    if ($key != NULL) {
        if ($category == 1) {
            $action2 = "and p.id like ('%$key%')";
        } else if ($category == 2) {
            $action2 = "and pd.nama like ('%$key%')";
        } else if ($category == 3) {
            $action2 = "and pd.jenis_kelamin like ('%$key%')";
        } else if ($category == 4) {
            $action2 = "and k.nama like ('%$key%')";
        }else if ($category == 5) {
            $action2 = "and kc.nama like ('%$key%')";
        }
    } else {
        $action2 = "";
    }

    if ($sort != NULL) {
        if ($sort == 1) {
            $action3 = "order by p.id $sortBy";
        } else if ($sort == 2) {
            $action3 = "order by pd.nama $sortBy";
        } else if ($sort == 3) {
            $action3 = "order by pd.jenis_kelamin $sortBy";
        }
    }else
        $action3 = "order by p.id asc";

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
    $return = array();
    $sql = "select pd.id as id_penduduk,
            (select max(no_kunjungan_pasien) from kunjungan where kunjungan.id_pasien=p.id)as no_kunjungan,
            dp.id_agama,p.id as id_pas, pd.*,pd.nama as nama_pas,dp.id, dp.*, 
            k.nama as nama_kelurahan,kc.nama as nama_kecamatan
    from penduduk pd
	join pasien p on (pd.id = p.id_penduduk)
	left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
    left join kelurahan k on (dp.id_kelurahan = k.id) 
    left join kecamatan kc on (k.id_kecamatan = kc.id) 
	where dp.akhir = 1 $action1 $action2
	group by p.id $action3 $batas";
    $sqltotal = "select dp.id_agama,p.id as id_pas, pd.*,pd.nama as nama_pas,dp.id, dp.*, k.nama as nama_kelurahan,kc.nama as nama_kecamatan from penduduk pd
	join pasien p on (pd.id = p.id_penduduk)
	left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
    left join kelurahan k on (dp.id_kelurahan = k.id) 
    left join kecamatan kc on (k.id_kecamatan = kc.id) 
	where dp.akhir = 1 $action1 $action2
	group by p.id $action3";
    if (isset($id)) {
        $return = _select_unique_result($sql);
		$return['total'] = countrow($sqltotal);
    } else {
        $return['list'] = _select_arr($sql);
        $sqli = "
        select p.id as id_pas, pd.*,pd.nama as nama_pas,dp.id, dp.*, k.nama as nama_kelurahan,kc.nama as nama_kecamatan from penduduk pd
		join pasien p on (pd.id = p.id_penduduk)
		left join dinamis_penduduk dp on (dp.id_penduduk = pd.id)
        left join kelurahan k on (dp.id_kelurahan = k.id)
        left join kecamatan kc on (k.id_kecamatan = kc.id) 
        where dp.akhir = 1 $action1 $action2
		group by p.id $action3";

        $return['paging'] = paging($sqli, $dataPerPage);
        $return['offset'] = $offset;
		$return['total'] = countrow($sqli);
    }




    return $return;
}
function kunjungan_muat_data($id = null, $startDate=null, $endDate=null, $category=NULL, $key=NULL, $sort='waktu', $by='asc') {
    $return = array();
    if (null != $id) {
        $require_oncement = "and k.id = '$id'";
    }else
        $require_oncement='';
    if ($startDate != null and $endDate != null) {
        $require_oncement.=" and date(k.waktu) between '$startDate' and '$endDate' ";
    }
    if ($category != NULL) {
        if ($category == 1) {
            $require_oncement.= "and p.nama like ('%$key%')";
        } else if ($category == 2) {
            $require_oncement.= "and ps.id = '$key'";
        }
    }
    $sql = "select k.id as id_kunjungan,k.no_kunjungan_pasien,l.bobot,ins.nama as instalasi,spe.nama as spesialisasi,pro.nama as profesi,ins.id as aidi, l.nama as layanan, pd2.nama as dokter,ps.id as no_rm, p.id as id_penduduk, p.nama, p.jenis_kelamin, p.tanggal_lahir, dp.*, kel.nama as nama_kelurahan, pr.nama as nama_profesi, dp.status_pernikahan as perkawinan,k.id as id_kunjungan,date(k.waktu) as waktu, time(k.waktu) as jam
	from penduduk p
	join pasien ps on (p.id = ps.id_penduduk)
	join kunjungan k on (k.id_pasien = ps.id)
        join layanan l on (k.id_layanan = l.id)
	left join bed bed on k.id_bed = bed.id
        left join instalasi ins on (bed.id_instalasi=ins.id)
        left join spesialisasi spe on (l.id_spesialisasi=spe.id)
        left join profesi pro on (spe.id_profesi=pro.id)
        join penduduk pd2 on (k.id_penduduk_dpjp = pd2.id)
	left join dinamis_penduduk dp on (dp.id_penduduk = p.id)
	left join penduduk pdk on (pdk.id = p.id)
	left join kelurahan kel on (dp.id_kelurahan = kel.id)
	left join profesi pr on (dp.id_profesi = pr.id)
	where dp.akhir = '1' $require_oncement  and k.status = 'Masuk' and bed.jenis != 'Rawat Inap' order by " . $sort . " " . $by;
    $return = _select_arr($sql);
    //echo "<pre>$sql</pre>";
    return $return;
}
function kunjungan_rj_muat_data($id = null, $startDate=null, $endDate=null, $category=NULL, $key=NULL, $sort='waktu', $by='asc'){
    $return = array();
    $require_oncement = '';
    if ($startDate != null and $endDate != null) {
        $require_oncement.="where date(k.waktu) between '$startDate' and '$endDate' ";
    }
    if ($category != NULL) {
        if ($category == 1) {
            $require_oncement.= "and penduduk.nama like ('%$key%')";
        } else if ($category == 2) {
            $require_oncement.= "and pasien.id = '$key'";
        }
    }
	
    
    $sql = _select_arr("SELECT distinct(k.id_pasien) as dist,(select max(id) from kunjungan 
            where id_pasien=dist) as id FROM kunjungan k
            LEFT JOIN pasien on pasien.id=k.id_pasien
            LEFT JOIN penduduk on penduduk.id=pasien.id_penduduk $require_oncement");
    foreach ($sql as $row){
        $sql2 = "select k.id as id_kunjungan,k.no_kunjungan_pasien,l.bobot,ins.nama as instalasi,spe.nama as spesialisasi,pro.nama as profesi,ins.id as aidi, l.nama as layanan, pd2.nama as dokter,ps.id as no_rm, p.id as id_penduduk, p.nama, p.jenis_kelamin, p.tanggal_lahir, dp.*, kel.nama as nama_kelurahan, pr.nama as nama_profesi, dp.status_pernikahan as perkawinan,k.id as id_kunjungan,date(k.waktu) as waktu, time(k.waktu) as jam
	from penduduk p
	join pasien ps on (p.id = ps.id_penduduk)
	join kunjungan k on (k.id_pasien = ps.id)
        join layanan l on (k.id_layanan = l.id)
	left join bed bed on k.id_bed = bed.id
        left join instalasi ins on (bed.id_instalasi=ins.id)
        left join spesialisasi spe on (l.id_spesialisasi=spe.id)
        left join profesi pro on (spe.id_profesi=pro.id)
        join penduduk pd2 on (k.id_penduduk_dpjp = pd2.id)
	left join dinamis_penduduk dp on (dp.id_penduduk = p.id)
	left join penduduk pdk on (pdk.id = p.id)
	left join kelurahan kel on (dp.id_kelurahan = kel.id)
	left join profesi pr on (dp.id_profesi = pr.id)
	where dp.akhir = '1' and k.id='$row[id]' and k.status = 'Masuk'";
        
        $return[] = _select_unique_result($sql2);
    }
    return $return;
}
function detail_kunjungan($id){
    $sql="
    select
    k.id as id_kunjungan,penduduk.id as id_penduduk,k.no_antrian,kecamatan.nama as kecamatan,kabupaten.nama as kabupaten,layanan.id as id_layanan,layanan.nama as nama_layanan,layanan.bobot as bobot,dokter.nama as nama_dokter,bed.nama as nama_bed,bed.id as id_bed,instalasi.id as id_instalasi,instalasi.nama as nama_instalasi,
    pasien.id as norm, penduduk.nama as nama_pasien,dp.alamat_jalan,kelurahan.nama as nama_kelurahan,
    penduduk.jenis_kelamin,penduduk.gol_darah,penduduk.tanggal_lahir,dp.status_pernikahan as perkawinan,pendidikan.nama as nama_pendidikan,
    agama.nama as nama_agama, k.rencana_cara_bayar,penanggungjawab.nama as nama_penanggungjawab,
    dp_penanggungjawab.alamat_jalan as alamat_penanggungjawab,dp_penanggungjawab.no_telp as no_telp_penanggungjawab,
    pengantar.nama as nama_pengantar,dp_pengantar.alamat_jalan as alamat_pengantar,dp_pengantar.no_telp as no_telp_pengantar,
    rujukan.no_surat_rujukan,ir.nama as nama_rujukan,nakes.nama as nama_nakes,profesi.nama as nama_profesi, pekerjaan.nama as nama_pekerjaan,
    (select count(*) from kunjungan kj WHERE kj.id_pasien=pasien.id) as jumlah_kunjungan,sp.nama as spesialisasi
    from kunjungan k
    LEFT JOIN pasien on pasien.id=k.id_pasien
    LEFT JOIN penduduk on penduduk.id=pasien.id_penduduk
    LEFT JOIN dinamis_penduduk dp on dp.id_penduduk=penduduk.id and dp.akhir = '1'
    LEFT JOIN layanan on layanan.id=k.id_layanan
    LEFT JOIN penduduk dokter on dokter.id=k.id_penduduk_dpjp
    LEFT JOIN bed on bed.id=k.id_bed
    LEFT JOIN instalasi on bed.id_instalasi=instalasi.id
    LEFT JOIN kelurahan on kelurahan.id=dp.id_kelurahan
    LEFT JOIN kecamatan on kecamatan.id=kelurahan.id_kecamatan
    LEFT JOIN kabupaten on kabupaten.id=kecamatan.id_kabupaten
    LEFT JOIN pendidikan on pendidikan.id=dp.id_pendidikan_terakhir
    LEFT JOIN agama on agama.id=dp.id_agama
    LEFT JOIN penduduk penanggungjawab on penanggungjawab.id=k.id_penduduk_penanggungjawab
    LEFT JOIN penduduk pengantar on pengantar.id=k.id_penduduk_pengantar
    LEFT JOIN dinamis_penduduk dp_penanggungjawab on dp_penanggungjawab.id_penduduk=penanggungjawab.id and dp_penanggungjawab.akhir = '1'
    LEFT JOIN dinamis_penduduk dp_pengantar on dp_pengantar.id_penduduk=pengantar.id and dp_pengantar.akhir = '1'
    LEFT JOIN rujukan on rujukan.id=k.id_rujukan
    LEFT JOIN instansi_relasi ir on ir.id=rujukan.id_instansi_relasi
    LEFT JOIN penduduk nakes on nakes.id=rujukan.id_penduduk_nakes
    LEFT JOIN profesi on profesi.id=dp.id_profesi
    LEFT JOIN pekerjaan on pekerjaan.id=dp.id_pekerjaan
    left join spesialisasi sp on layanan.id_spesialisasi = sp.id 
where k.id='$id'";
    return _select_unique_result($sql);
}
function detail_kunjungan_muat_data($id = NULL) {
    if ($id != NULL) {
        $action = "where k.id='$id'";
    }else
        $action = "";
    $sql = "select
    ps.id as idPasien,p.nama as namaPasien,ps.id_penduduk,p.tanggal_lahir as tanggal_lahir, pr.nama as profesiPasien,
    agm.nama as agamaPasien, dp.no_telp as telpPasien,
    dp.id_pendidikan_terakhir,dp.id_profesi,pdd.id as id_pendidikan, pdd.nama as pendidikan,
    k.id,k.no_kunjungan_pasien,k.id_penduduk_penanggungjawab,p.nama as namaPasien,p.jenis_kelamin,dp.alamat_jalan as alamatPasien, kel.nama as kelurahanPasien,
    rj.no_surat_rujukan as noRujukan, ir.nama as namaRujukan, pkw.id_perkawinan, pkw.perkawinan, pJ.id, pJ.nama as penanggungJawab,
    pNakes.id,pNakes.nama as nakes,pd2.nama as dokter,b.nama as bed,ins.nama as instalasi,kls.nama as kelas
    from kunjungan k
    left join penduduk pd2 on (k.id_penduduk_dpjp=pd2.id)
    left join bed b on (k.id_bed=b.id)
    left join instalasi ins on (b.id_instalasi=ins.id)
    left join kelas kls on (b.id_kelas=kls.id)
    left join pasien ps on (ps.id=k.id_pasien)
    left join penduduk p on (p.id=ps.id_penduduk)
    left join dinamis_penduduk dp on (dp.id_penduduk=p.id)
    left join pendidikan pdd on (pdd.id=dp.id_pendidikan_terakhir)
    left join profesi pr on (pr.id=dp.id_profesi)
    left join agama agm on(agm.id=dp.id_agama)
    left join kelurahan kel on (kel.id=dp.id_kelurahan)
    left join penduduk pJ on (pJ.id=k.id_penduduk_penanggungjawab)
    left join rujukan rj on (rj.id=k.id_rujukan)
    left join penduduk pNakes on (pNakes.id=rj.id_penduduk_nakes)
    left join instansi_relasi ir on (ir.id=rj.id_instansi_relasi)
	
    left join perkawinan pkw on(dp.status_pernikahan=pkw.id_perkawinan) $action";
    $return = _select_arr($sql);
    return $return;
}
/**
 *
 * @param Date $startDate
 * @param Date $endDate
 * @return array pendapatan
 */
function pendapatan_pelayanan_muat_date($startDate, $endDate) {
    $sql = "select l.nama, t.total from detail_billing db
	join tarif t on (t.id = db.id_tarif)
	join layanan l on (t.id_layanan = l.id)
	where date(db.waktu) between '$startDate' and '$endDate'";
    return _select_arr($sql);
}

//--------------------WILAYAH-----------------------------------------------------------

function propinsi_muat_data($id = NULL, $order = NULL, $key = NULL, $page = NULL, $dataPerPage = NULL) {
    if ($id != NULL) {
        $action = "where id = $id";
    }else
        $action = "";
    if($key != NULL){
        $where = "where nama like ('%$key%')";
    }else $where = "";
    if ($order != NULL) {
        $action2 = $order;
    }else
        $action2 = "ORDER BY nama ASC";
    
    if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
    if (isset($dataPerPage) && $dataPerPage != null) {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas = "limit $offset, $dataPerPage";
    } else {
        $batas = '';
        $offset = '';
    }
    
    $result = array();
    $sql = "select * from provinsi $action $where $action2 $batas";
     if ($id != null) {
       $result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    } else {
        $result['list'] = _select_arr($sql);
    }

    $sqli = "select * from provinsi $action $where $action2";
    
    $result['paging'] = paging($sqli, $dataPerPage, "prov");
    $result['offset'] = $offset;
    $result['propinsi'] = countrow("select * from provinsi");
    return $result;
}

function kabupaten_by_propinsi($id, $order = NULL, $key = NULL) {
    if ($order != NULL) {
        $action = $order;
    }else
        $action = "";
    
    if($key != NULL){
        $where = "and nama like ('%$key%')";
    }else{
        $where = "";
    }
    $return = array();

    $sql = "select * from kabupaten where id_provinsi = '$id' $where $action";
    $return['list'] = _select_arr($sql);
    $return['kabupaten'] = countrow("select * from kabupaten");
    
    return $return;
}

function kabupaten_muat_data($id = NULL, $order = NULL, $key = NULL, $page = NULL, $dataPerPage = NULL, $prov = NULL)
{
    if ($id != NULL)
    {
        if ($prov != NULL)
            $action = "WHERE k.id = $id AND k.id_provinsi = $prov";
	else
            $action = "WHERE k.id = $id AND k.id_provinsi = p.id";
    } else
        $action = "WHERE k.id_provinsi = p.id";
    if ($prov != NULL)
        $actionz = "WHERE k.id_provinsi = $prov";
    else
        $actionz = "";
    if($key != NULL)
        $where = "and k.nama like ('%$key%')";
    else
        $where = "";
    if ($order != NULL)
        $action2 = $order;
    else
        $action2 = "ORDER BY k.nama ASC";
    
    if (!empty($page))
        $noPage = $page;
    else
        $noPage = 1;

    if (isset($dataPerPage) && $dataPerPage != null)
    {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas  = "LIMIT $offset, $dataPerPage";
    } else
    {
        $batas  = '';
        $offset = '';
    }
    $return = array();
    $sql = "SELECT k.nama AS namaKabupaten, k.kode AS kodeKabupaten, k.id AS idKabupaten, k.id_provinsi, p.nama AS namaProvinsi, p.id AS IdProvinsi
            FROM kabupaten k, provinsi p
			$action $actionz $where $action2
			$batas";
    if ($id != null)
    {
        $result         = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    } else
        $result['list'] = _select_arr($sql);
    $sqli = "SELECT k.nama AS namaKabupaten, k.kode AS kodeKabupaten, k.id AS idKabupaten, k.id_provinsi, p.nama AS namaProvinsi, p.id AS IdProvinsi
            FROM kabupaten k, provinsi p $action $actionz $where";
    $result['paging']    = paging($sqli, $dataPerPage, "kab");
    $result['offset']    = $offset;
    $result['kabupaten'] = countrow("SELECT * FROM kabupaten");
    return $result;
}

function kabupaten_muat_data_by_id($id = NULL) {
    if ($id != NULL) {
        $action = "where id=$id";
    }
    $return = array();
    $sql = mysql_query("select * from kabupaten $action");
    while ($row = mysql_fetch_array($sql)) {
        $return[] = $row;
    }
    return $return;
}

function kecamatan_by_kabupaten($id, $order = NULL, $key = NULL, $code = NULL) {
    if ($order != NULL) {
        $action = $order;
    }else
        $action = "";
    if($key != NULL){
        $where = "and nama like ('%$key%')";
    }else $where = "";
	if($code != NULL){
        $where = "and id = '$code'";
		}
    $return = array();

    $sql = "select * from kecamatan where id_kabupaten = '$id' $where $action";
    $return['list'] = _select_arr($sql);
    $return['kecamatan'] = countrow("select * from kecamatan");

    return $return;
}

function kecamatan_muat_data_by_id($id = NULL) {
    if ($id != NULL) {
        $action = "where id = $id";
    }
	
    $return = array();
    $sql = mysql_query("select * from kecamatan $action");
    while ($row = mysql_fetch_array($sql)) {
        $return[] = $row;
    }
    return $return;
}

function kecamatan_muat_data($id = NULL, $order = NULL, $key = NULL, $page = NULL, $dataPerPage = NULL, $kab = NULL)
{
    if ($id != NULL)
    {
		if ($kab != NULL)
            $action = "WHERE k.id = $id AND k.id_kabupaten = $kab";
		else
            $action = "WHERE k.id = $id AND k.id_kabupaten = p.id";
    } else
        $action = "WHERE k.id_kabupaten = p.id";
    if($key != NULL)
        $where = "and k.nama like ('%$key%')";
    else
        $where = "";
    if ($order != NULL)
        $action2 = $order;
    else
        $action2 = "ORDER BY k.nama ASC";
    
    if (!empty($page))
        $noPage = $page;
    else
        $noPage = 1;

    if (isset($dataPerPage) && $dataPerPage != null)
    {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas  = "LIMIT $offset, $dataPerPage";
    } else
    {
        $batas  = '';
        $offset = '';
    }
    $return = array();
    $sql = "SELECT k.nama AS namaKecamatan, k.kode AS kodeKecamatan, k.id AS idKecamatan, k.id_kabupaten, p.nama AS namaKabupaten, p.id AS IdKabupaten
            FROM kecamatan k, kabupaten p
			$action $where $action2
			$batas";
    if ($id != null)
    {
        $result         = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    } else
        $result['list'] = _select_arr($sql);
    $sqli = "SELECT k.nama AS namaKecamatan, k.kode AS kodeKecamatan, k.id AS idKecamatan, k.id_kabupaten, p.nama AS namaKabupaten, p.id AS IdKabupaten
            FROM kecamatan k, kabupaten p $action $where $action2";
    
    $result['paging']    = paging($sqli, $dataPerPage, "kec");
    $result['offset']    = $offset;
    $result['kecamatan'] = countrow("SELECT * FROM kecamatan");
    return $result;
}

function kelurahan_muat_data($id = NULL, $order = NULL, $key = NULL, $page = NULL, $dataPerPage = NULL, $kab = NULL)
{
    if ($id != NULL)
    {
		if ($kab != NULL)
            $action = "WHERE k.id = $id AND k.id_kecamatan = $kab";
		else
            $action = "WHERE k.id = $id AND k.id_kecamatan = p.id";
    } else
        $action = "WHERE k.id_kecamatan = p.id";
    if($key != NULL)
        $where = "and k.nama like ('%$key%')";
    else
        $where = "";
    if ($order != NULL)
        $action2 = $order;
    else
        $action2 = "ORDER BY k.nama ASC";
    
    if (!empty($page))
        $noPage = $page;
    else
        $noPage = 1;

    if (isset($dataPerPage) && $dataPerPage != null)
    {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas  = "LIMIT $offset, $dataPerPage";
    } else
    {
        $batas  = '';
        $offset = '';
    }
    $return = array();
    $sql = "SELECT k.nama AS namaKelurahan, k.kode AS kodeKelurahan, k.id AS idKelurahan, k.id_kecamatan, p.nama AS namaKecamatan, p.id AS IdKecamatan
            FROM kelurahan k, kecamatan p
			$action $where $action2
			$batas";
    if ($id != null)
    {
        $result         = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    } else
        $result['list'] = _select_arr($sql);
    $sqli = "SELECT k.nama AS namaKelurahan, k.kode AS kodeKelurahan, k.id AS idKelurahan, k.id_kecamatan, p.nama AS namaKecamatan, p.id AS IdKecamatan
            FROM kelurahan k, kecamatan p $action $where $action2";
    
    $result['paging']    = paging($sqli, $dataPerPage, "kel");
    $result['offset']    = $offset;
    $result['kelurahan'] = countrow("SELECT * FROM kelurahan");
    return $result;
}

function kelurahan_kecamatan_muat_data($idKelurahan, $idKecamatan) {
    $return = array();
    $sql = mysql_query("select kel.id as idKelurahan,kel.nama as namaKelurahan,kec.id as idKecamatan,kec.nama as namaKecamatan from kelurahan kel,kecamatan kec where kel.id = '$idKelurahan' and kec.id = '$idKecamatan'");
    while ($row = mysql_fetch_array($sql)) {
        $return[] = $row;
    }
    return $return;
}

function kelurahan_by_kecamatan($id, $order = NULL,$key = NULL) {
    if ($order != NULL) {
        $action = $order;
    }else
        $action = "";
    
    if($key != NULL){
        $where = "and nama like ('%$key%')";
    }else $where = "";
    $return = array();
    $sql = mysql_query("select * from kelurahan where id_kecamatan = '$id' $where $action");

    while ($row = mysql_fetch_array($sql)) {
        $return[] = $row;
		  
    }
    return $return;
}

function kode_wilayah($kel, $idKec)
{
    $kodeKel = $kel;
    $kodeKec = _select_unique_result("SELECT kode, id_kabupaten FROM kecamatan WHERE id = $idKec");
    $kodeKab = _select_unique_result("SELECT kode, id_provinsi FROM kabupaten WHERE id = $kodeKec[id_kabupaten]");
    $kodePro = _select_unique_result("SELECT kode FROM provinsi WHERE id = $kodeKab[id_provinsi]");
	return "$kodePro[kode].$kodeKab[kode].$kodeKec[kode].$kodeKel";
}

function penduduk_muat_data($id = NULL, $key = NULL, $category = NULL, $sort = NULL,$sortBy=null, $page=NULL, $dataPerPage = NULL) {
    if ($id != NULL) {
        $action1 = "and p.id = '$id'";
    }else
        $action1 = "";

    if ($key != NULL) {
        if ($category == 1) {
            $action2 = "and p.nama like ('%$key%')";
        } else if ($category == 2) {
            $action2 = "and k.nama like ('%$key%')";
        }else if ($category == 3) {
            $action2 = "and kc.nama like ('%$key%')";
        } else if ($category == 4) {
            $action2 = "and p.no_kartu_keluarga like ('%$key%')";
        } else if ($category == 5) {
            $action2 = "and p.tanggal_lahir like ('%" . date2mysql($key) . "%')";
        } else if ($category == 6) {
            $action2 = "and p.jenis_kelamin like ('%$key%')";
        } else if ($category == 7) {
            $action2 = "and dp.no_telp like ('%$key%')";
        }
    } else
        $action2 = "";

    if ($sort != NULL) {
        if ($sort == 1) {
            $action3 = "order by p.nama $sortBy";
        } else if ($sort == 2) {
            $action3 = "order by p.tanggal_lahir $sortBy";
        } else if ($sort == 3) {
            $action3 = "order by p.jenis_kelamin $sortBy";
        } else if ($sort == 0) {
            $action3 = "order by p.id $sortBy";
        }
    } else
        $action3 = "order by p.nama asc";
    if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
    if (isset($dataPerPage) && $dataPerPage != null) {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas = "limit $offset, $dataPerPage";
    } else {
        $batas = '';
        $offset = '';
    }
    $result = array();
    $sql = "SELECT p.*, dp.id_kelurahan, dp.alamat_jalan, dp.no_telp,dp.id_pendidikan_terakhir,dp.id_profesi, dp.id_pekerjaan, dp.id_agama,dp.status_pernikahan, k.nama as nama_kel,kc.nama as nama_kec, p.posisi_di_keluarga as posisi
		  FROM
		  penduduk p 
                  left join dinamis_penduduk dp on (p.id = dp.id_penduduk) 
                  left join kelurahan k on (k.id = dp.id_kelurahan)
                  left join kecamatan kc on (kc.id=k.id_kecamatan)
                where (dp.akhir = 1 or dp.akhir is NULL) $action1 $action2 $action3 $batas";
	if ($id != null) {
		$result =  _select_unique_result($sql);
                $result['list'] = _select_arr($sql);
                
	} else {
		$result['list'] = _select_arr($sql);
	}
	
    $sql = "SELECT p.*, dp.id_kelurahan, dp.alamat_jalan, dp.no_telp,dp.id_pendidikan_terakhir,dp.id_profesi,dp.id_agama,dp.status_pernikahan, k.nama as nama_kel,kc.nama as nama_kec, p.posisi_di_keluarga
		  FROM
		  penduduk p left join dinamis_penduduk dp
		  on (p.id = dp.id_penduduk)
                  left join kelurahan k on (k.id = dp.id_kelurahan)
                  left join kecamatan kc on (kc.id=k.id_kecamatan)
		  where (dp.akhir = 1 or dp.akhir is NULL) $action1 $action2 $action3";
    $result['paging'] = paging($sql, $dataPerPage);
    $result['offset'] = $offset;
    $result['total'] = countrow($sql);
    return $result;
}

function asuransi_muat_data($id = null, $sort = NULL) {
    $require_onced = null;
    if (!empty($id)) {
        $require_onced = "where id_jenis_asuransi = '$id'";
    }
    if (!empty($sort)) {
        $order = "order by jenis_asuransi";
    }else
        $order = "";

    $sql = "select * from jenis_asuransi $require_onced $order";
    $exe = mysql_query($sql);
    $result = array();
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}

function charity_muat_data($id = null, $sort = NULL) {
    $require_onced = null;
    if (!empty($id)) {
        $require_onced = "where id_jenis_charity = '$id'";
    }
    if (!empty($sort)) {
        $order = "order by jenis_charity";
    } else
        $order = "";

    $sql = "select * from jenis_charity $require_onced $order";

    $exe = mysql_query($sql);
    $result = array();
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}

function macam_barang_muat_data() {
    $result = array();
    $sql = "select * from sub_macam_barang";
    $exe = mysql_query($sql);
    while ($row = mysql_fetch_array($exe)) {
        $result[] = $row;
    }
    return $result;
}

function barang_muat_data($id=null, $sort = null, $sortBy=null, $page=NULL, $dataPerPage = NULL,$key=NULL, $kategori = NULL) {
	
 
    if($sort != NULL){
    if ($sort == 1) {
        $sortir = "order by b.nama $sortBy";
    } else if ($sort == 3) {
        $sortir = "order by subkategori.nama $sortBy";
    }else if ($sort == 0) {
        $sortir = "order by b.id $sortBy";
    }else if($sort == 2){
        $sortir = "order by ir.nama $sortBy";
    }
}else $sortir = "order by b.nama asc";
    
    if($key != NULL){
        if($kategori == 1){
           $action = "and b.nama like '%$key%'"; 
        }else if($kategori == 2){
           $action = "and subkategori.nama like '%$key%'"; 
        }else if($kategori == 3){
           $action = "and ir.nama like '%$key%'"; 
        }
    }else  $action = "";
    
    if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
	 $where=null;
	if ($id != null) {
		$where="and b.id = '$id'";
	}
    $dataPerPage = $dataPerPage;
    $offset = ($noPage - 1) * $dataPerPage;
    $batas = "";
    if ($dataPerPage != null) {
        $batas = "limit $offset, $dataPerPage";
    }
		if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
    $sql = "
        SELECT
            b.id,b.nama,b.id_sub_kategori_barang,subkategori.nama as kategori, ir.id as idPabrik, ir.nama as pabrik, s.nama as sediaan, ob.generik, ob.kekuatan, ob.ven
        FROM barang b
		LEFT JOIN obat ob on (b.id = ob.id)
		LEFT JOIN sediaan s on (s.id = ob.id_sediaan)
        LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
        JOIN sub_kategori_barang subkategori on subkategori.id=b.id_sub_kategori_barang
        JOIN kategori_barang kb on kb.id=subkategori.id_kategori_barang
        $katbarang $where $action $sortir $batas";
	
    if ($id != null) {
       $result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    } else {
        $result['list'] = _select_arr($sql);
    }
	if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
    $sqli = "
        SELECT
            b.id,b.nama,b.id_sub_kategori_barang,subkategori.nama as kategori, ir.id as idPabrik, ir.nama as pabrik, s.nama as sediaan
        FROM barang b
		LEFT JOIN obat ob on (b.id = ob.id)
		LEFT JOIN sediaan s on (s.id = ob.id_sediaan)
        LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
        JOIN sub_kategori_barang subkategori on subkategori.id=b.id_sub_kategori_barang
        JOIN kategori_barang kb on kb.id=subkategori.id_kategori_barang
        $katbarang $where $action";

    $result['paging'] = paging($sqli, $dataPerPage);
    $result['offset'] = $offset;
    return $result;
}
/**
 *
 * @param <type> $id
 * @param <type> $page
 * @param <type> $dataPerPage
 * @param <type> $sort 
 * @param <type> $key nama barang
 * @return <type>
 */
function packing_barang_muat_data($id=null, $page = null, $dataPerPage = null, $sort = NULL,$sortBy=null,$key=null) {
    if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
    if(isset ($sort)){
        if($sort == 1){
           $order = "order by pb.id $sortBy";
        }else if($sort == 2){
           $order = "order by pb.barcode $sortBy";
        }else if($sort == 3){
           $order = "order by b.nama $sortBy";
        }
    } else $order = "";

    $dataPerPage = $dataPerPage;
    $offset = ($noPage - 1) * $dataPerPage;
    $batas = "";
    if ($dataPerPage != null) {
        $batas = "limit $offset, $dataPerPage";
    }
    if($key!=null){
        $where=" and b.nama like '%$key%'";
    }else
        $where="";
		 $dimana=null;
	if ($id != null) {
		$dimana="and pb.id = '$id'";
	}
		if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
    $sql = "
        SELECT
        pb.id as id_packing,pb.barcode,pb.id_barang,pb.id_satuan_terbesar,o.kekuatan,sd.nama as sediaan,ins.nama as instansi_relasi,
        pb.nilai_konversi,pb.id_satuan_terkecil,b.id as id_barang,b.nama as nama_barang,satuan.nama as satuan_terkecil,
        kb.nama as nama_kategori,o.generik,
        kemasan.nama as kemasan,satuan.nama as satuan
        FROM packing_barang pb
        LEFT JOIN barang b on b.id=pb.id_barang
        left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
        left join obat o on b.id=o.id
        left join sediaan sd on o.id_sediaan=sd.id
        LEFT JOIN sub_kategori_barang subkategori on subkategori.id=b.id_sub_kategori_barang
        LEFT JOIN kategori_barang kb on kb.id=subkategori.id_kategori_barang
        LEFT JOIN satuan kemasan on kemasan.id=pb.id_satuan_terbesar
        LEFT JOIN satuan on satuan.id=pb.id_satuan_terkecil
        $katbarang and pb.barcode !='' $where $dimana $order $batas";
    if ($id != null) {
		$result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    } else {
        $result['list'] = _select_arr($sql);
    }
    $sqli = "
       SELECT
        pb.id as id_packing,pb.barcode,pb.id_barang,pb.id_satuan_terbesar,o.kekuatan,sd.nama as sediaan,ins.nama as instansi_relasi,
        pb.nilai_konversi,pb.id_satuan_terkecil,b.id as id_barang,b.nama as nama_barang,satuan.nama as satuan_terkecil,
        kb.nama as nama_kategori,o.generik,
        kemasan.nama as kemasan,satuan.nama as satuan
        FROM packing_barang pb
        LEFT JOIN barang b on b.id=pb.id_barang
        left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
        left join obat o on b.id=o.id
        left join sediaan sd on o.id_sediaan=sd.id
        LEFT JOIN sub_kategori_barang subkategori on subkategori.id=b.id_sub_kategori_barang
        LEFT JOIN kategori_barang kb on kb.id=subkategori.id_kategori_barang
        LEFT JOIN satuan kemasan on kemasan.id=pb.id_satuan_terbesar
        LEFT JOIN satuan on satuan.id=pb.id_satuan_terkecil
        $katbarang  and pb.barcode !='' $where $dimana";

    $result['paging'] = paging($sqli, $dataPerPage);
    $result['offset'] = $offset;
    return $result;
}

function kategori_barang_muat_data($id=null, $sort = null,$sortBy = null, $page=NULL,$dataPerPage = null, $key = null) {
     $where=null;
	if ($id != null) {
		$where="and sk.id = '$id'";
	}
        if($key != NULL){
           $cari = " and sk.nama like ('%$key%') ";
          } else
          $cari='';
        
	if ($sort == null) {
        $sortir = " order by sk.nama asc ";
    }else if($sort==1){
        $sortir = "order by id $sortBy";
    }else if($sort==2){
        $sortir = "order by nama $sortBy";
    }
    if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
    if (isset($dataPerPage) && $dataPerPage != null) {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas = "limit $offset, $dataPerPage";
    } else {
        $batas = '';
        $offset = '';
    }
	
    

    $sql = "SELECT sk.id,sk.permit_penjualan,sk.nama,k.nama as kategori FROM sub_kategori_barang sk
        JOIN kategori_barang k on k.id=sk.id_kategori_barang where k.id !='0' $where $cari $sortir $batas";

  if ($id != null) {
       $result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    } else {
        $result['list'] = _select_arr($sql);
    }
            $sqli = "SELECT sk.id,sk.nama,k.nama as kategori FROM sub_kategori_barang sk
                JOIN kategori_barang k on k.id=sk.id_kategori_barang where k.id !='0' $where $cari";
		
            $result['paging'] = paging($sqli, $dataPerPage);
            $result['offset'] = $offset;
            return $result;
    
    return $result;
}

function kategori_barang_muat_data2() {
    $sql = "select * from kategori_barang";
    return _select_arr($sql);
}

function penjualan_muat_data($startDate, $endDate, $jenis = null, $idPembeli = NULL, $idPegawai=null,$idDokter=null) {
    $where = "";
    if ($jenis != NULL) {
        $where .= " and p.jenis='$jenis'";
    }
    if ($idPembeli != null) {
        $where.=" and p.id_penduduk_pembeli='$idPembeli'";
    }
    if ($idPegawai != null) {
        $where.=" and p.id_pegawai='$idPegawai'";
    }
    if ($idDokter!= null) {
        $where.=" and p.id_penduduk_dokter='$idDokter'";
    }
    $sql = "SELECT p . * ,
            pdd1.nama as pembeli,
            pdd2.nama as pegawai,
            pdd3.nama as dokter,
            DATE( p.waktu ) AS tanggal
            FROM penjualan p
            left join penduduk pdd1 on(pdd1.id=p.id_penduduk_pembeli)
            left join penduduk pdd2 on(pdd2.id=p.id_pegawai)
            left join penduduk pdd3 on(pdd3.id=p.id_penduduk_dokter)
        where (DATE(p.waktu)<='$endDate' and DATE(p.waktu)>='$startDate')
        $where";
    //echo "<pre>$sql</pre>";
    $sql2="SELECT SUM(p.total_tagihan) FROM penjualan p            
        where (DATE(p.waktu)<='$endDate' and DATE(p.waktu)>='$startDate')
        $where";
    $sql3="SELECT drp.biaya_apoteker
            FROM penjualan p
            left join penduduk pdd1 on(pdd1.id=p.id_penduduk_pembeli)
            left join penduduk pdd2 on(pdd2.id=p.id_pegawai)
            left join penduduk pdd3 on(pdd3.id=p.id_penduduk_dokter)
            join detail_penjualan_retur_penjualan dprp on (dprp.id_penjualan=p.id)
            join detail_resep_penjualan drp on(drp.id_detail_penjualan_retur_penjualan=dprp.id)
            where (DATE(p.waktu)<='$endDate' and DATE(p.waktu)>='$startDate')
        $where group by drp.no_resep";
    $hasil=_select_arr($sql3);
    $jumlah_jasa_pelayanan=0;
    foreach($hasil as $row){
        $jumlah_jasa_pelayanan+=$row['biaya_apoteker'];
    }
    $result['list']=_select_arr($sql);
    $result['num_rows']=_num_rows($sql);
    $result['total_tagihan']=_select_unique_result($sql2);
    $result['total_jasa_pelayanan']=$jumlah_jasa_pelayanan;
    
    return $result;
}

function detail_penjualan_muat_data($id) {
    $sql = "select detail.hna,detail.margin,detail.jumlah_penjualan,detail.id_retur_penjualan,
            detail.jumlah_retur,detail.alasan,b.nama as barang,pb.nilai_konversi,st.nama as satuan,date(p.waktu) as tanggal,p.id
            from detail_penjualan_retur_penjualan detail
            left join penjualan p on(p.id=detail.id_penjualan)
            left join packing_barang pb on detail.id_packing_barang=pb.id
            left join barang b on pb.id_barang=b.id
            left join satuan st on pb.id_satuan_terkecil=st.id where detail.id_penjualan='$id'";

    return _select_arr($sql);
}

function pembelian_muat_data($startDate=null, $endDate=null, $suplier = null, $pegawai = NULL, $awalJatuhTempo = NULL, $akhiJatuhTempo = NULL,$idpacking=null,$batch) {
  	if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
    if (($startDate != null && $endDate != null) || $suplier != null) {
        $where = "";
        if ($startDate != null) {
            $where.=" and DATE(pb.waktu)>='$startDate' AND DATE(pb.waktu)<='$endDate'";
        }
        if ($suplier != null) {
            if ($startDate != null)
                $where.=" AND ";
            $where.=" ir.id='$suplier'";
        }if ($pegawai != NULL) {
            if ($startDate != null)
                $where.=" AND ";
            $where.=" pgw.id='$pegawai'";
        }if ($idpacking != NULL) {
            if ($startDate != null)
                $where.=" AND ";
            $where.=" pbr.id='$idpacking'";
        }if ($batch!= NULL) {
            if ($startDate != null)
                $where.=" AND ";
            $where.=" dpr.batch='$batch'";
        }if ($awalJatuhTempo != NULL && $akhiJatuhTempo != NULL) {
            if ($startDate != NULL) {
                $where.="AND ";
                $where.="pb.tanggal_jatuh_tempo>='$awalJatuhTempo' AND pb.tanggal_jatuh_tempo<='$akhiJatuhTempo'";
            }
        }
    }else
        $where="";
    
    $sql = "select pb.id,DATE(pb.waktu) as waktu,pb.no_faktur,pb.ppn,dpr.diskon,dpr.harga_pembelian,dpr.jumlah_pembelian,(dpr.jumlah_pembelian*dpr.harga_pembelian) as total,pb.tanggal_jatuh_tempo,pdd.nama as pegawai,pb.materai,ir.nama as suplier,
        dpr.id_packing_barang
        from pembelian pb
        JOIN detail_pembelian dpr on dpr.id_pembelian=pb.id
        JOIN pegawai pgw on pgw.id=pb.id_pegawai
        JOIN penduduk pdd on pdd.id=pgw.id
        LEFT JOIN instansi_relasi ir on ir.id=pb.id_instansi_suplier
        left join packing_barang pbr on dpr.id_packing_barang = pbr.id
        left join barang b on pbr.id_barang = b.id
        left join sub_kategori_barang skb on b.id_sub_kategori_barang = skb.id
        left join kategori_barang kb on skb.id_kategori_barang = kb.id
        $katbarang
        $where
        GROUP BY pb.id";
    return _select_arr($sql);
}

function pembelian_muat_data_by_id($id)
{
	$sql = "select pb.id,DATE(pb.waktu) as waktu,pb.no_faktur,pb.ppn,dpr.diskon,dpr.harga_pembelian,dpr.jumlah_pembelian,(dpr.jumlah_pembelian*dpr.harga_pembelian) as total,pb.tanggal_jatuh_tempo,pdd.nama as pegawai,pb.materai,ir.nama as suplier,
        dpr.id_packing_barang
        from pembelian pb
        JOIN detail_pembelian dpr on dpr.id_pembelian=pb.id
        JOIN pegawai pgw on pgw.id=pb.id_pegawai
        JOIN penduduk pdd on pdd.id=pgw.id
        LEFT JOIN instansi_relasi ir on ir.id=pb.id_instansi_suplier
        left join packing_barang pbr on dpr.id_packing_barang = pbr.id
        left join barang b on pbr.id_barang = b.id
        left join sub_kategori_barang skb on b.id_sub_kategori_barang = skb.id
        left join kategori_barang kb on skb.id_kategori_barang = kb.id
        where pb.id = '$id'
        GROUP BY pb.id";
    return _select_unique_result($sql);
}

function detail_pembelian_muat_data($id) {
    $sql = "
        select dpr.id,dpr.id_packing_barang,dpr.batch,dpr.jumlah_pembelian,ir.nama as pabrik,o.generik,o.kekuatan,sd.nama as sediaan,dpr.harga_pembelian,dpr.diskon,
        pb.id,pmb.materai,pb.id_barang,pb.nilai_konversi,b.nama,st.nama as satuan_terkecil,o.generik,pb.nilai_konversi,
        (select sum(detail.harga_pembelian*detail.jumlah_pembelian-(detail.harga_pembelian*detail.jumlah_pembelian*detail.diskon/100))
        from detail_pembelian detail where detail.id_pembelian=pmb.id)+
        ((select sum(detail2.harga_pembelian*detail2.jumlah_pembelian-(detail2.harga_pembelian*detail2.jumlah_pembelian*detail2.diskon/100))
        from detail_pembelian detail2 where detail2.id_pembelian=pmb.id)*pmb.ppn/100)+pmb.materai
        as total, sto.ed as ed
        from detail_pembelian dpr
        left join pembelian pmb on dpr.id_pembelian=pmb.id
        left join packing_barang pb on dpr.id_packing_barang=pb.id
        left join satuan st on pb.id_satuan_terkecil = st.id
        left join barang b on pb.id_barang=b.id 
        left join obat o on b.id=o.id 
        left join sediaan sd on sd.id=o.id_sediaan
        left join instansi_relasi ir on b.id_instansi_relasi_pabrik=ir.id
        left join stok sto on sto.id=(SELECT max(id) FROM stok sto2 where sto2.id_packing_barang=dpr.id_packing_barang)
        where dpr.id_pembelian='$id'
    ";

    return _select_arr($sql);
}

function penjualan_barang_muat_data($idPenjualan, $idBarang) {
    $sql = "select detail.id as iddetail,pb.id as idpacking,b.nama as barang,detail.jumlah_penjualan,detail.hna,detail.margin,detail.diskon from detail_penjualan_retur_penjualan detail
            LEFT JOIN packing_barang pb on detail.id_packing_barang=pb.id
            left JOIN barang b on b.id=pb.id_barang
            where detail.id_penjualan='$idPenjualan' and detail.id_packing_barang='$idBarang'
            ";
    return _select_arr($sql);
}

function penerimaan_muat_data($startDate = NULL, $endDate = NULL, $suplier = NULL, $status = NULL) {

    $requirement = "";
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);

    if ($startDate != null and $endDate != null) {
        $requirement .= "where pn.waktu>='$startDate' and pn.waktu<='$endDate'";
    }

    if ($suplier != NULL) {
        $requirement .= " and pm.id_instansi_relasi_suplier = '$suplier'";
    }

    $result= _select_arr("select pn.id as id_penerimaan,pn.waktu as tanggal_penerimaan,pn.id_pemesanan,pmd.jumlah as jumlah_pemesanan,pnd.no_batch,pnd.jumlah as jumlah_penerimaan,pnd.tanggal_kadaluarsa,pnd.id_barang,pnd.jumlah as jumlah_penerimaan,pm.tanggal as tanggal_pemesanan,br.nama as nama_barang,datediff(pn.waktu,pm.tanggal) as lead_time 
                        from penerimaan pn 
                        join detail_pemesanan pmd on (pn.id_pemesanan = pmd.id_pemesanan)
                        join penerimaan_detail pnd on (pn.id=pnd.id_penerimaan) 
                        join pemesanan pm on (pm.id=pn.id_pemesanan)
                        join barang br on (pnd.id_barang=br.id) $requirement");

    return $result;
}

function pegawai_muat_data($id=NULL, $sort=NULL,$sortBy=null, $page = NULL, $dataPerPage = NULL, $key = NULL) {
 if($key != NULL){
        $where = "and p.nama like ('%$key%')";
    }else $where = "";
    if ($sort != NULL) {
        if($sort==1){
            $action2 = "order by pg.id $sortBy";
        }else if($sort==2){
            $action2 = "order by pg.nip $sortBy";
        }else if($sort==3){
            $action2 = "order by p.nama $sortBy";
        }
    } else
        $action2 = "order by p.nama asc";

  
   

    if($id!=null){
        $where="and pg.id='$id'";
    }

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
	
   $sql = "select pg.*,p.id as id_penduduk,p.sip,p.nama,ag.nama as agama,p.no_kartu_keluarga,p.posisi_di_keluarga as posisi, pkj.nama as pekerjaan,prf.nama as profesi,pdd.nama as pendidikan,p.jenis_kelamin,p.no_identitas,p.tanggal_lahir,l.nama as nama_level,u.nama as nama_unit,kec.nama as kecamatan,dp.no_telp,dp.alamat_jalan,kel.nama as kelurahan,kab.nama as kabupaten,prov.nama as provinsi 
    from pegawai pg
    left join penduduk p on (pg.id = p.id)
    left join dinamis_penduduk dp on (p.id = dp.id_penduduk)
    left join agama ag on dp.id_agama = ag.id
    left join kelurahan kel on (dp.id_kelurahan = kel.id)
    left join kecamatan kec on (kel.id_kecamatan = kec.id)
    left join kabupaten kab on (kec.id_kabupaten = kab.id)
    left join provinsi prov on (kab.id_provinsi = prov.id)
    left join pendidikan pdd on dp.id_pendidikan_terakhir = pdd.id
    left join pekerjaan pkj on dp.id_pekerjaan = pkj.id
    left join profesi prf on dp.id_profesi = prf.id
    left join level l on(l.id=pg.id_level)
    left join unit u on(u.id=pg.id_unit)
    where dp.akhir = 1 $where $action2 $batas ";
    $sqltotal="select * from pegawai";
     if ($id != null) {
       $result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
			$result['total'] = countrow($sqltotal);
    } else {
        $result['list'] = _select_arr($sql);
			$result['total'] = countrow($sqltotal);
    }

    $sqli = "
    select pg.*,p.id as id_penduduk,p.nama,ag.nama as agama,p.no_kartu_keluarga,pkj.nama as pekerjaan,prf.nama as profesi,pdd.nama as pendidikan,p.jenis_kelamin,p.no_identitas,p.tanggal_lahir,l.nama as nama_level,kec.nama as kecamatan,dp.no_telp,dp.alamat_jalan,kel.nama as kelurahan,kab.nama as kabupaten,prov.nama as provinsi 
    from pegawai pg 
    left join penduduk p on(pg.id = p.id)
    left join dinamis_penduduk dp on (pg.id = dp.id_penduduk)
    left join agama ag on dp.id_agama = ag.id
    left join kelurahan kel on (dp.id_kelurahan = kel.id)
    left join kecamatan kec on (kel.id_kecamatan = kec.id)
    left join kabupaten kab on (kec.id_kabupaten = kab.id)
    left join provinsi prov on (kab.id_provinsi = prov.id)
    left join pendidikan pdd on dp.id_pendidikan_terakhir = pdd.id
    left join pekerjaan pkj on dp.id_pekerjaan = pkj.id
    left join profesi prf on dp.id_profesi = prf.id
    left join level l on(l.id=pg.id_level) where dp.akhir = 1 $where $action2";
    //echo "<pre>" . $sql."</pre>";
   $result['paging'] = paging($sqli, $dataPerPage);
    $result['offset'] = $offset;
		$result['total'] = countrow($sqli);
    return $result;
}

function stok_barang_muat_data($startDate = NULL, $endDate = NULL, $unit = NULL, $packing = NULL, $jenisTransaksi = NULL) {
    $now = date('Y-m-d');
    $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    $yearNow = date("Y");

    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);

    $requirement = "where DATE(s.waktu)>='$startDate' and DATE(s.waktu)<='$endDate'";
    if ($unit != NULL) {
        $requirement .= " and s.id_unit = '$unit'";
    }
    if ($packing != NULL) {
        $requirement .= "and s.id_packing_barang = '$packing'";
    }
    if ($jenisTransaksi != NULL) {
        $requirement .= "and s.id_jenis_transaksi = '$jenisTransaksi'";
    }
    $stok=_select_arr("select pb.id as id_packing,s.batch
           from stok s
           join packing_barang pb on (s.id_packing_barang=pb.id) join unit u on (s.id_unit=u.id)
           join jenis_transaksi j on (s.id_jenis_transaksi=j.id) join satuan st on (pb.id_satuan_terkecil=st.id)
           join barang b on (pb.id_barang=b.id)
            $requirement
            group by pb.id,s.batch
            order by s.id desc,s.waktu desc");
    $result=array();
    foreach($stok as $a){
        $where=(isset($a['batch']) && $a['batch']!='')?" and s.batch='$a[batch]'":'';
        $result[] = _select_unique_result("select s.id,DATE(s.waktu) as tanggal,s.id_unit,s.awal,s.masuk,s.keluar,pb.nilai_konversi,s.ed,s.batch,
           s.sisa,s.id_packing_barang,pb.id,pb.id_barang,pb.id_satuan_terkecil,u.nama as unit,
           st.nama as satuan,j.nama as jenis_transaksi,b.nama as barang,
           (select stok.hpp from stok where stok.id_packing_barang=pb.id and stok.id_jenis_transaksi='2' order by stok.waktu desc limit 0,1) as hpp
           from stok s
           join packing_barang pb on (s.id_packing_barang=pb.id) join unit u on (s.id_unit=u.id)
           join jenis_transaksi j on (s.id_jenis_transaksi=j.id) join satuan st on (pb.id_satuan_terkecil=st.id)
           join barang b on (pb.id_barang=b.id)
            $requirement
            and pb.id=$a[id_packing] $where
            order by s.id desc,s.waktu desc
                LIMIT 0,1");
    }

    
    return $result;
}

function stok_barang_muat_data2($startDate = NULL,$endDate=null, $unit = NULL, $packing = NULL, $jenisTransaksi = NULL, $subKategori = NULL) {
    $now = date('Y-m-d');
    $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    $yearNow = date("Y");

    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);

    $requirement = "where DATE(s.waktu) between '$startDate' and '$endDate'";
    if ($unit != NULL) {
        $requirement .= " and s.id_unit = '$unit'";
    }
    if ($packing != NULL) {
        $requirement .= "and s.id_packing_barang = '$packing'";
    }
			$nilai=',(s.sisa*s.hna) as hargax';
    if ($jenisTransaksi != NULL) {
        $requirement .= "and s.id_jenis_transaksi = '$jenisTransaksi'";
	
		if($jenisTransaksi=='2'){
		$nilai= ',(s.masuk*s.hna) as hargax';
		}
		
		if($jenisTransaksi=='5'){
		$nilai= ',(s.keluar*s.hna) as hargax';
		}
		
    }
    if($subKategori != NULL){
        $requirement .= "and b.id_sub_kategori_barang = '$subKategori'";
    }
    
    $stok = _select_arr("select date(s.waktu) as tanggal,s.*,b.nama as barang,st2.nama as kemasan,o.kekuatan,pb.nilai_konversi,o.generik,sd.nama as sediaan,st.nama as satuan,ir.nama as pabrik,jt.nama as jenis_transaksi,pb.id as id_packing_barang $nilai 
                                  from stok s 
                                  join packing_barang pb on s.id_packing_barang = pb.id
                                  join barang b on pb.id_barang = b.id
                                  join unit u on s.id_unit = u.id
                                  join jenis_transaksi jt on s.id_jenis_transaksi = jt.id
                                  join satuan st on pb.id_satuan_terkecil = st.id
                                  join satuan st2 on pb.id_satuan_terbesar = st2.id
                                  left join obat o on b.id = o.id
                                  left join sediaan sd on o.id_sediaan = sd.id
                                  left join instansi_relasi ir on b.id_instansi_relasi_pabrik = ir.id
                                  join sub_kategori_barang skb on b.id_sub_kategori_barang = skb.id $requirement order by s.waktu desc");
   return $stok;

}

function stok_obat_muat_data($startDate, $endDate, $unit = NULL, $packing = NULL, $jenisTransaksi = NULL, $perundangan=null, $generik=null, $indikasi=null, $ven=null, $ssf=null, $formularium=NULL) {
    $now = date('Y-m-d');
    $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    $yearNow = date("Y");
    $requirement = "";
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);

    if ($startDate != null and $endDate != null) {
        $requirement .= "where DATE(s.waktu)>='$startDate' and DATE(s.waktu)<='$endDate' ";
    }
    if ($unit != NULL) {
        $requirement .= " and s.id_unit = '$unit' ";
    }
    if ($packing != NULL) {
        $requirement .= "and s.id_packing_barang = '$packing' ";
    }
    if ($jenisTransaksi != NULL) {
        $requirement .= "and s.id_jenis_transaksi = '$jenisTransaksi' ";
    }
    if ($perundangan != NULL) {
        $requirement .= "and obat.id_gol_perundangan = '$perundangan' ";
    }
    if ($generik != NULL) {
        if ($generik == "all") {
            $requirement .= "";
        } else {
            $requirement .= "and obat.generik= '$generik' ";
        }
    }
    if ($ven != NULL) {
        $requirement .= "and obat.ven= '$ven' ";
    }
    if ($indikasi != NULL) {
        $requirement .= "and obat.indikasi like '%$indikasi%' ";
    }
    if ($ssf != NULL) {
        $requirement .= "and obat.id_sub_sub_farmakologi='$ssf'  ";
    }
    if ($formularium != NULL) {
        if ($formularium == "all") {
            $requirement .= "";
        } else if ($formularium == "Formularium") {
            $requirement .= "and obat.id in (select id_obat from detail_formularium)";
        } else if ($formularium == "Non Formularium") {
            $requirement .= "and obat.id not in (select id_obat from detail_formularium)";
        }
    }
    $sql = "select s.id,DATE(s.waktu) as tanggal,s.id_unit,s.awal,s.masuk,s.keluar,pb.nilai_konversi,satuan.nama as satuan_terbesar,ir.nama as pabrik,sediaan.nama as sediaan,
           s.sisa,s.id_packing_barang,pb.id,pb.id_barang,pb.id_satuan_terkecil,u.nama as unit,obat.generik,obat.kekuatan,
           st.nama as satuan,j.nama as jenis_transaksi,b.nama as barang,
           (select stok.hpp from stok where stok.id_packing_barang=pb.id and stok.id_jenis_transaksi='2' order by stok.waktu desc limit 0,1) as hpp,
           ((select sum(detail.lead_time) from detail_pemesanan_faktur detail
            JOIN pemesanan p on p.id=detail.id_pemesanan
            where detail.id_packing_barang='pb.id' and YEAR(p.waktu)='$yearNow')/(select count(*) from detail_pemesanan_faktur detail
            JOIN pemesanan p on p.id=detail.id_pemesanan
            where detail.id_packing_barang='pb.id' and YEAR(p.waktu)='$yearNow'))*
            ((select sum(keluar) from stok
            WHERE id_packing_barang='pb.id' and id_unit='1' and YEAR(waktu)=$yearNow)/
            (select COUNT(*) from stok
            WHERE id_packing_barang='pb.id' and id_unit='1' and  YEAR(waktu)=$yearNow))/365 as rop
           from stok s
           join packing_barang pb on (s.id_packing_barang=pb.id)
           left join unit u on (s.id_unit=u.id)
           join jenis_transaksi j on (s.id_jenis_transaksi=j.id)
           join satuan st on (pb.id_satuan_terkecil=st.id)
           join barang b on (pb.id_barang=b.id)
           JOIN satuan on satuan.id=pb.id_satuan_terbesar
           left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
           JOIN obat on obat.id=b.id
           left join sediaan on sediaan.id=obat.id_sediaan
            $requirement order by s.waktu desc";
    return _select_arr($sql);
}

function stok_obat_muat_data2($startDate, $unit = NULL, $packing = NULL, $jenisTransaksi = NULL, $perundangan=null, $generik=null, $indikasi=null, $ven=null, $ssf=null, $formularium=NULL,$endDate=null) {
    $now = date('Y-m-d');
    $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    $yearNow = date("Y");
    $requirement = "";
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);

    if ($startDate != null) {
        $requirement .= "where DATE(s.waktu) >= '$startDate' and DATE(s.waktu) <='$endDate'";
    }
    if ($unit != NULL) {
        $requirement .= " and s.id_unit = '$unit' ";
    }
    if ($packing != NULL) {
        $requirement .= "and s.id_packing_barang = '$packing' ";
    }
    if ($jenisTransaksi != NULL) {
        $requirement .= "and s.id_jenis_transaksi = '$jenisTransaksi' ";
    }
    if ($perundangan != NULL) {
        $requirement .= "and obat.id_gol_perundangan = '$perundangan' ";
    }
    if ($generik != NULL) {
        if ($generik == "all") {
            $requirement .= "";
        } else {
            $requirement .= "and obat.generik= '$generik' ";
        }
    }
    if ($ven != NULL) {
        $requirement .= "and obat.ven= '$ven' ";
    }
    if ($indikasi != NULL) {
        $requirement .= "and obat.indikasi like '%$indikasi%' ";
    }
    if ($ssf != NULL) {
        $requirement .= "and obat.id_sub_sub_farmakologi='$ssf'  ";
    }
    if ($formularium != NULL) {
        if ($formularium == "all") {
            $requirement .= "";
        } else if ($formularium == "Formularium") {
            $requirement .= "and obat.id in (select id_obat from detail_formularium)";
        } else if ($formularium == "Non Formularium") {
            $requirement .= "and obat.id not in (select id_obat from detail_formularium)";
        }
    }
    $sql = "select s.id,DATE(s.waktu) as tanggal,obat.generik,s.id_transaksi,s.hna,s.batch,s.ed,s.id_unit,s.awal,s.masuk,s.keluar,pb.nilai_konversi,satuan.nama as satuan_terkecil,sat.nama as satuan_terbesar,obat.kekuatan,ins.nama as pabrik,sediaan.nama as sediaan,
           s.sisa,s.id_packing_barang,pb.id,pb.id_barang,pb.id_satuan_terkecil,u.nama as unit,obat.generik,obat.kekuatan,
           st.nama as satuan,j.nama as jenis_transaksi,b.nama as barang,
           (select stok.hpp from stok where stok.id_packing_barang=pb.id and stok.id_jenis_transaksi='2' order by stok.waktu desc limit 0,1) as hpp,
           s.id_packing_barang
           from stok s
           left join packing_barang pb on (s.id_packing_barang=pb.id)
           left join unit u on (s.id_unit=u.id)
           left join jenis_transaksi j on (s.id_jenis_transaksi=j.id)
           left join satuan st on (pb.id_satuan_terkecil=st.id)
           left join barang b on (pb.id_barang=b.id)
           left JOIN instansi_relasi ins on ins.id=b.id_instansi_relasi_pabrik
           left JOIN satuan on satuan.id=pb.id_satuan_terkecil
	   left JOIN satuan sat on sat.id=pb.id_satuan_terbesar
           left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
           JOIN obat on obat.id=b.id
           left join sediaan on sediaan.id=obat.id_sediaan
            $requirement order by s.waktu desc";
    return _select_arr($sql);
}

function stok_barang_pelayanan_muat_data2($startDate = NULL,$endDate = NULL,$unit = NULL,$packing = NULL,$jenisTransaksi = NULL,$idSubKategori = NULL){
    $yearNow = date("Y");
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);
    
    $requirement = "where DATE(s.waktu) between '$startDate' and '$endDate'";
    if ($unit != NULL) {
        $requirement .= " and s.id_unit = '$unit'";
    }
    if ($packing != NULL) {
        $requirement .= "and s.id_packing_barang = '$packing'";
    }
    if ($jenisTransaksi != NULL) {
        $requirement .= "and s.id_jenis_transaksi = '$jenisTransaksi'";
    }
    if($idSubKategori != NULL){
        $requirement .= "and b.id_sub_kategori_barang = '$idSubKategori'";
    }
    $sql = "select DATE(s.waktu) as tanggal,s.*,b.nama as barang,o.kekuatan,o.generik,pb.nilai_konversi,st.nama as satuan,jt.nama as jenis_transaksi,u.nama as unit,o.generik,ins.nama as pabrik,sd.nama as sediaan,
            (select stok.hpp from stok where stok.id_packing_barang=pb.id and stok.id_jenis_transaksi='2' order by stok.waktu desc limit 0,1) as hpp,
            s.id_packing_barang,stb.nama as satuan_terbesar
            from stok_unit s
            left join packing_barang pb on s.id_packing_barang = pb.id
            left join barang b on pb.id_barang = b.id
            left join obat o on b.id = o.id
            left join sediaan sd on o.id_sediaan = sd.id
            left join unit u on s.id_unit = u.id
            left join jenis_transaksi jt on s.id_jenis_transaksi = jt.id
            left join satuan st on pb.id_satuan_terkecil = st.id
    left join satuan stb on pb.id_satuan_terbesar = stb.id
            left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id $requirement order by DATE(s.waktu) desc";
    return _select_arr($sql);
}

function stok_obat_muat_data3($idPacking = NULL,$perundangan = NULL,$generik = NULL,$formularium = NULL,$indikasi = NULL,$ven = NULL,$ssf = NULL,$idZatAktif=null, $sortBy = NULL){
    $where = "where b.id_sub_kategori_barang = 1";
    if($idPacking != NULL){
        $where .= " and pb.id='$idPacking'";
    }
    if($perundangan != NULL){
        $where .= " and o.id_gol_perundangan = '$perundangan'";
    }if($generik != NULL){
        if($generik == "All" || $generik == "all" ){
            $where .= "";
        }else $where .= " and o.generik = '$generik'";
	}
    if ($sortBy != NULL && $sortBy == "asc") {
        $sortBy = "order by b.nama desc";
    } else if ($sortBy != NULL && $sortBy == "desc") {
        $sortBy = "order by b.nama asc";
    }else
        $sortBy= "order by b.nama asc";
		
    if ($formularium != NULL) {
        if ($formularium == "All" || $generik == "all") {
            $where .= "";
        } else if ($formularium == "Formularium") {
            $where .= " and o.id in (select id_obat from detail_formularium)";
        } else {
            $where .= " and o.id not in (select id_obat from detail_formularium)";
        }
    }if($indikasi != NULL){
        $where .= " and o.indikasi like '%$indikasi%'";
    }if($ven != NULL){
        $where .= " and o.ven = '$ven'";
    }if($ssf != NULL){
        $where .= " and o.id_sub_sub_farmakologi = '$ssf'";
    }
    if($idZatAktif!=NULL){
        $where .=" and o.id in (select id_obat from komposisi_obat where id_zat_aktif=$idZatAktif and id_obat=o.id) ";
    }
    $sql = _select_arr("select pb.id as id_packing,s.batch,o.generik
           from stok s
           join packing_barang pb on (s.id_packing_barang=pb.id) 
           join unit u on (s.id_unit=u.id)
           join jenis_transaksi j on (s.id_jenis_transaksi=j.id)
           join satuan st on (pb.id_satuan_terkecil=st.id)
           join barang b on (pb.id_barang=b.id)
           join obat o on (b.id=o.id) 
           join sub_kategori_barang skb on (b.id_sub_kategori_barang=skb.id) 
           $where  and s.id=(select max(id) from stok st12 where batch=s.batch and st12.id_packing_barang=pb.id) $sortBy");
    $result=array();
    $yearNow=date('Y');
    foreach ($sql as $row){
        if($row['batch']!='' && $row['batch']!=null){
            $req2="and s.batch='$row[batch]'";
        }else $req2="";
          $id = "select max(id) from stok group by s.batch";
        $result[] = _select_unique_result("select s.hpp,s.batch,s.ed,s.sisa,s.hna,b.nama as barang,pb.nilai_konversi,
                o.kekuatan,o.generik,st1.nama as satuan_terkecil,st2.nama as satuan_terbesar, sd.nama as sediaan,ir.nama as pabrik,
                 (s.hpp*s.sisa) as nilai,
                   s.id_packing_barang
                   from stok s 
                   left join packing_barang pb on (s.id_packing_barang=pb.id)
                    left join barang b on (pb.id_barang=b.id)
                   join obat o on b.id=o.id
                   left join satuan st1 on pb.id_satuan_terkecil=st1.id
                   left join satuan st2 on pb.id_satuan_terbesar=st2.id
                   left join sediaan sd on o.id_sediaan = sd.id
                   left join instansi_relasi ir on ir.id = b.id_instansi_relasi_pabrik
                   where pb.id=$row[id_packing] $req2 and s.id=(select max(id) from stok st12 where batch=s.batch and st12.id_packing_barang=pb.id)");
    }
    return $result;
}

function stok_obat_muat_data4($idPacking = NULL,$perundangan = NULL,$generik = NULL,$formularium = NULL,$indikasi = NULL,$ven = NULL,$ssf = NULL,$idZatAktif=null)
{
	$where = "WHERE b.id_sub_kategori_barang = 1";
	if($idPacking != NULL)
		$where .= " AND pb.id = '$idPacking'";
	if($perundangan != NULL)
		$where .= " AND o.id_gol_perundangan = '$perundangan'";
	if($generik != NULL)
		if($generik == "All" || $generik == "all" )
			$where .= "";
		else
			$where .= " AND o.generik = '$generik'";
	if($formularium != NULL)
	{
		if($formularium == "All" || $generik == "all")
			$where .= "";
		else if($formularium == "Formularium")
			$where .= " AND o.id IN (SELECT id_obat FROM detail_formularium)";
		else
			$where .= " AND o.id NOT IN (SELECT id_obat FROM detail_formularium)";
    }
	if($indikasi != NULL)
		$where .= " AND o.indikasi LIKE '%$indikasi%'";
	if($ven != NULL)
		$where .= " AND o.ven = '$ven'";
	if($ssf != NULL)
		$where .= " AND o.id_sub_sub_farmakologi = '$ssf'";
	if($idZatAktif!=NULL)
		$where .=" AND o.id IN (SELECT id_obat FROM komposisi_obat WHERE id_zat_aktif = $idZatAktif AND id_obat = o.id) ";
		
	$sql = _select_arr("
				SELECT pb.id AS id_packing
				FROM stok_unit s
					JOIN packing_barang pb ON (s.id_packing_barang = pb.id)
					JOIN unit u ON (s.id_unit = u.id)
					JOIN jenis_transaksi j ON (s.id_jenis_transaksi = j.id)
					JOIN satuan st ON (pb.id_satuan_terkecil = st.id)
					JOIN barang b ON (pb.id_barang = b.id)
					JOIN obat o ON (b.id = o.id)
					JOIN sub_kategori_barang skb ON (b.id_sub_kategori_barang = skb.id)
				$where
				GROUP BY pb.id
				ORDER BY s.id desc, s.waktu desc
			");
	$result  = array();
	$yearNow = date('Y');
	foreach ($sql as $row)
	{
			
		$result[] = _select_unique_result("
						SELECT s.hpp, u.nama AS unit, s.sisa, b.nama AS barang, pb.nilai_konversi, o.kekuatan, st1.nama AS satuan_terkecil,
							sd.nama AS sediaan, ir.nama AS pabrik, (s.hpp*s.sisa) AS nilai, s.id_packing_barang
						FROM stok_unit s
							JOIN unit u ON (s.id_unit = u.id)
							JOIN packing_barang pb ON (s.id_packing_barang = pb.id)
							JOIN barang b ON (pb.id_barang = b.id)
							JOIN obat o ON b.id = o.id
							LEFT JOIN satuan st1 ON pb.id_satuan_terkecil = st1.id
							LEFT JOIN sediaan sd ON o.id_sediaan = sd.id
							LEFT JOIN instansi_relasi ir ON ir.id = b.id_instansi_relasi_pabrik
						WHERE pb.id = $row[id_packing]
						ORDER BY s.id desc,s.waktu DESC
						LIMIT 0,1
					");
	}
	return $result;
}

function stok_obat_pelayanan_muat_data($idPacking = NULL,$perundangan = NULL,$generik = NULL,$formularium = NULL,$indikasi = NULL,$ven = NULL,$ssf = NULL,$idZatAktif=NULL,$getUnit=NULL){
    if($getUnit != NULL){
      $unit = $getUnit;  
    }else{
      $unit = $_SESSION['id_unit'];  
    }
    $where = "where s.id_unit = $unit and (s.batch is NOT NULL or s.batch!=NULL or s.batch!='' or s.batch<>'')";
    if($idPacking != NULL){
        $where .= " and pb.id='$idPacking'";
    }
    if($perundangan != NULL){
        $where .= " and o.id_gol_perundangan = '$perundangan'";
    }if($generik != NULL){
        if($generik == "All" || $generik == "all" ){
            $where .= "";
        }else $where .= " and o.generik = '$generik'";
    }if($formularium != NULL){
        if($formularium == "All"){
            $where .= "";
        }else if($formularium == "Formularium"){
            $where .= " and o.id in (select id_obat from detail_formularium)";
        }else{
            $where .= " and o.id not in (select id_obat from detail_formularium)";
        }
    }if($indikasi != NULL){
        $where .= " and o.indikasi like '%$indikasi%'";
    }if($ven != NULL){
        $where .= " and o.ven = '$ven'";
    }if($ssf != NULL){
        $where .= " and o.id_sub_sub_farmakologi = '$ssf'";
    }
     if($idZatAktif!=NULL){
        $where .=" and o.id in (select id_obat from komposisi_obat where id_zat_aktif=$idZatAktif and id_obat=o.id) ";
    }
    
    $sql = _select_arr("select distinct pb.id as id_packing,s.batch as batch
           from stok_unit s
           join packing_barang pb on (s.id_packing_barang=pb.id) join unit u on (s.id_unit=u.id)
           join jenis_transaksi j on (s.id_jenis_transaksi=j.id) join satuan st on (pb.id_satuan_terkecil=st.id)
           join barang b on (pb.id_barang=b.id)
           join obat o on (b.id=o.id) 
           join sub_kategori_barang skb on (b.id_sub_kategori_barang=skb.id) 
           $where
           
           order by s.id desc,s.waktu desc");
    $result=array();
    foreach ($sql as $row){
       $result[] = _select_unique_result("select s.hpp,s.sisa,b.nama as barang,st2.nama as satuan_terbesar,pb.nilai_konversi,o.kekuatan,st1.nama as satuan_terkecil,
                sd.nama as sediaan,ir.nama as pabrik,o.generik,s.id,s.batch as batch
               from stok_unit s join packing_barang pb on (s.id_packing_barang=pb.id)
               join barang b on (pb.id_barang=b.id)
               left join obat o on b.id=o.id
               left join satuan st1 on pb.id_satuan_terkecil=st1.id
               left join satuan st2 on pb.id_satuan_terbesar=st2.id
               left join sediaan sd on o.id_sediaan = sd.id
               left join instansi_relasi ir on ir.id = b.id_instansi_relasi_pabrik
               where pb.id=$row[id_packing] and s.id_unit = $unit and s.batch='$row[batch]' order by s.id desc,s.waktu desc
               LIMIT 0,1");
    }
    return $result;
}
function stok_obat_unit_muat_data($startDate, $endDate, $packing = NULL, $jenisTransaksi = NULL, $perundangan=null, $generik=null, $indikasi=null, $ven=null, $ssf=null, $formularium=NULL) {
    $now = date('Y-m-d');
    $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    $yearNow = date("Y");
    $requirement = "";
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);

    if ($startDate != null and $endDate != null) {
        $requirement .= "where DATE(s.waktu)>='$startDate' and DATE(s.waktu)<='$endDate' ";
    }
    if ($packing != NULL) {
        $requirement .= "and s.id_packing_barang = '$packing' ";
    }
    if ($jenisTransaksi != NULL) {
        $requirement .= "and s.id_jenis_transaksi = '$jenisTransaksi' ";
    }
    if ($perundangan != NULL) {
        $requirement .= "and obat.id_gol_perundangan = '$perundangan' ";
    }
    if ($generik != NULL) {
        if ($generik == "all") {
            $requirement .= "";
        } else {
            $requirement .= "and obat.generik= '$generik' ";
        }
    }
    if ($ven != NULL) {
        $requirement .= "and obat.ven= '$ven' ";
    }
    if ($indikasi != NULL) {
        $requirement .= "and obat.indikasi like '%$indikasi%' ";
    }
    if ($ssf != NULL) {
        $requirement .= "and obat.id_sub_sub_farmakologi='$ssf'  ";
    }
    if ($formularium != NULL) {
        if ($formularium == "all") {
            $requirement .= "";
        } else if ($formularium == "Formularium") {
            $requirement .= "and obat.id in (select id_obat from detail_formularium)";
        } else if ($formularium == "Non Formularium") {
            $requirement .= "and obat.id not in (select id_obat from detail_formularium)";
        }
    }
    $sql = "select s.id,DATE(s.waktu) as tanggal,obat.generik,s.awal,s.masuk,s.keluar,pb.nilai_konversi,satuan.nama as satuan_terkecil,ir.nama as pabrik,obat.kekuatan,sediaan.nama as sediaan,
           s.sisa,s.id_packing_barang,pb.id,pb.id_barang,pb.id_satuan_terkecil,
           st.nama as satuan,j.nama as jenis_transaksi,b.nama as barang,
           (select stok.hpp from stok where stok.id_packing_barang=pb.id and stok.id_jenis_transaksi='2' order by stok.waktu desc limit 0,1) as hpp,
           ((select sum(detail.lead_time) from detail_pemesanan_faktur detail
            JOIN pemesanan p on p.id=detail.id_pemesanan
            where detail.id_packing_barang='pb.id' and YEAR(p.waktu)='$yearNow')/(select count(*) from detail_pemesanan_faktur detail
            JOIN pemesanan p on p.id=detail.id_pemesanan
            where detail.id_packing_barang='pb.id' and YEAR(p.waktu)='$yearNow'))*
            ((select sum(keluar) from stok
            WHERE id_packing_barang='pb.id' and id_unit='1' and YEAR(waktu)=$yearNow)/
            (select COUNT(*) from stok
            WHERE id_packing_barang='pb.id' and id_unit='1' and  YEAR(waktu)=$yearNow))/365 as rop
           from stok_unit s
           left join packing_barang pb on (s.id_packing_barang=pb.id)
           left join jenis_transaksi j on (s.id_jenis_transaksi=j.id)
           left join satuan st on (pb.id_satuan_terkecil=st.id)
           left join barang b on (pb.id_barang=b.id)
           left JOIN satuan on satuan.id=pb.id_satuan_terkecil
           left JOIN instansi_relasi ir on b.id_instansi_relasi_pabrik=ir.id
           JOIN obat on obat.id=b.id
           left join sediaan on sediaan.id=obat.id_sediaan
    $requirement order by s.waktu desc";
    return _select_arr($sql);
}

function stok_obat_unit_muat_data2($startDate, $packing = NULL, $jenisTransaksi = NULL, $perundangan=null, $generik=null, $indikasi=null, $ven=null, $ssf=null, $formularium=NULL, $endDate) {
    $now = date('Y-m-d');
    $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    $yearNow = date("Y");
    $requirement = "";
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);

    if ($startDate != null) {
        $requirement .= "where s.id_unit = '$_SESSION[id_unit]' and DATE(s.waktu) between '$startDate' and '$endDate'";
    }
    if ($packing != NULL) {
        $requirement .= "and s.id_packing_barang = '$packing' ";
    }
    if ($jenisTransaksi != NULL) {
        $requirement .= "and s.id_jenis_transaksi = '$jenisTransaksi' ";
    }
    if ($perundangan != NULL) {
        $requirement .= "and obat.id_gol_perundangan = '$perundangan' ";
    }
    if ($generik != NULL) {
        if ($generik == "all") {
            $requirement .= "";
        } else {
            $requirement .= "and obat.generik= '$generik' ";
        }
    }
    if ($ven != NULL) {
        $requirement .= "and obat.ven= '$ven' ";
    }
    if ($indikasi != NULL) {
        $requirement .= "and obat.indikasi like '%$indikasi%' ";
    }
    if ($ssf != NULL) {
        $requirement .= "and obat.id_sub_sub_farmakologi='$ssf'  ";
    }
    if ($formularium != NULL) {
        if ($formularium == "all") {
            $requirement .= "";
        } else if ($formularium == "Formularium") {
            $requirement .= "and obat.id in (select id_obat from detail_formularium)";
        } else if ($formularium == "Non Formularium") {
            $requirement .= "and obat.id not in (select id_obat from detail_formularium)";
        }
    }
    $sql = "select s.id,DATE(s.waktu) as tanggal,s.awal,s.masuk,s.keluar,pb.nilai_konversi,satuan.nama as satuan_terkecil,
           s.sisa,s.id_packing_barang,pb.id,pb.id_barang,pb.id_satuan_terkecil,
           st.nama as satuan,j.nama as jenis_transaksi,b.nama as barang,
           (select stok_unit.hpp from stok_unit where stok_unit.id_packing_barang=pb.id and stok_unit.id_jenis_transaksi='2' order by stok_unit.waktu desc limit 0,1) as hpp,
            ir.nama as pabrik,obat.generik,sediaan.nama as sediaan, obat.kekuatan,s.id_packing_barang,stb.nama as satuan_terbesar,s.batch as batch
           from stok_unit s
           join packing_barang pb on (s.id_packing_barang=pb.id)
           join jenis_transaksi j on (s.id_jenis_transaksi=j.id)
           join satuan st on (pb.id_satuan_terkecil=st.id)
           join barang b on (pb.id_barang=b.id)
           JOIN satuan on satuan.id=pb.id_satuan_terkecil
    JOIN satuan stb on stb.id=pb.id_satuan_terbesar
           LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
           JOIN obat on obat.id=b.id
           left join sediaan on sediaan.id=obat.id_sediaan

            $requirement order by s.waktu desc";
    
    return _select_arr($sql);
}
function unit_muat_data($id = NULL,$sort = NULL,$sortBy=null,$page = NULL,$dataPerPage = NULL, $key = NULL) {
    $result = array();
    if ($id != NULL) {
        $where = " where id='$id'";
    }else
        $where = "";
     if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
    if (isset($dataPerPage) && $dataPerPage != null) {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas = "limit $offset, $dataPerPage";
    } else {
        $batas = '';
        $offset = '';
    }
    if($sort != NULL){
        if($sort == 1){
            $order = "order by id $sortBy";
        }else if($sort == 2){
            $order = "order by nama $sortBy";
        }
    }else $order = "order by nama asc";
     if($key != NULL){
       $cari = "where nama like ('%$key%')";
      } else
      $cari=''; 
    $sql = "select * from unit $cari $where $order $batas  ";
     if ($id != null) {
       $result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    } else {
        $result['list'] = _select_arr($sql);
    }
    $sqli = "select * from unit $cari $where  ";
    $result['paging'] = paging($sqli, $dataPerPage);
    $result['offset'] = $offset;
		$result['total'] = countrow($sqli);
    return $result;
}

function privilage_muat_data($idModul) {
    $privilageList = _select_arr('select * from `privileges` where id_module="' . $idModul . '" order by nama');
    return $privilageList;
}

function modul_muat_data($idParent=null) {
    if ($idParent != NULL) {
        $where = " where id_parent_modul='$idParent'";
    }else
        $where=' where id_parent_modul is NULL';
    $modulList = _select_arr("select * from module $where");
    foreach ($modulList as $key => $modul) {
        $subModul = modul_muat_data($modul['id']);
        if (count($subModul) > 0) {
            $modulList[$key]['subModul'] = $subModul;
        }
        $privilege = privilage_muat_data($modul['id']);
        if (count($privilege) > 0) {
            $modulList[$key]['privilege'] = $privilege;
        }
    }
    return $modulList;
}

function modul_muat_data2($idParent=null) {
    if ($idParent != NULL) {
        $where = " where id_parent_modul='$idParent'";
    }else
        $where=' where id_parent_modul is NULL';
    $modulList = _select_arr("select * from module $where");
    foreach ($modulList as $key => $modul) {
        $subModul = modul_muat_data2($modul['id']);
        if (count($subModul) > 0) {
            $modulList[$key]['subModul'] = $subModul;
        }
        $privilege = privilage_muat_data2($modul['id']);
        if (count($privilege) > 0) {
            $modulList[$key]['privilege'] = $privilege;
        }
    }
    return $modulList;
}

function privilage_muat_data2($idModul) {
    $sql = "select r.*,p.* from role_permission r
                                   join privileges p on (p.id=r.id_privileges)
                                   where r.id_role = '$_SESSION[id_role]' and p.id_module = '$idModul' order by p.nama";
	$privilageList = _select_arr($sql);
    return $privilageList;
}

function retur_muat_data($id = null,$startDate=null,$endDate=null,$idSuplier=null,$idPegawai=null) {
    $where=" where 1=1 ";
    if ($id != null) {
        $where .= " and retur.id='$id'";
    }
    if ($startDate != null) {
        $where .= " and  DATE(retur.waktu)>='".date2mysql($startDate)."'";
    }
    if ($endDate != null) {
        $where .= " and DATE(retur.waktu)<='".date2mysql($endDate)."'";
    }
    if ($idSuplier != null) {
        $where .= " and retur.id_instansi_relasi_suplier='$idSuplier'";
    }
    if ($idPegawai != null) {
        $where .= " and retur.id_pegawai='$idPegawai'";
    }
    $sql = "select retur.id as nosurat,retur.waktu,instansi_relasi.nama as suplier,penduduk.nama as pegawai
            from retur_pembelian retur 
            LEFT JOIN instansi_relasi on retur.id_instansi_relasi_suplier=instansi_relasi.id
            LEFT JOIN pegawai on pegawai.id=retur.id_pegawai
            left join penduduk on pegawai.id=penduduk.id
            $where";
    return _select_arr($sql);
}
function reretur_muat_data($id = null,$startDate=null, $endDate=null, $idPegawai=null,$nosurat=null) {
    $where="where 1=1 ";
    if($id!=null){
        $where.=" and reretur.id=$id";
    }
    if ($startDate != null) {
        $where .= " and  DATE(reretur.waktu)>='".date2mysql($startDate)."'";
    }
    if ($endDate != null) {
        $where .= " and DATE(reretur.waktu)<='".date2mysql($endDate)."'";
    }
    if ($nosurat != null) {
        $where .= " and reretur.no_surat='$nosurat'";
    }
    if ($idPegawai != null) {
        $where .= " and reretur.id_pegawai='$idPegawai'";
    }
    $sql="select reretur.id,reretur.no_surat,reretur.waktu,penduduk.nama as pegawai,
            (select instansi_relasi.nama as suplier from detail_retur_reretur detail 
            join retur_pembelian on detail.id_retur=retur_pembelian.id
            left join instansi_relasi on instansi_relasi.id=retur_pembelian.id_instansi_relasi_suplier where  detail.id_reretur=reretur.id limit 1) as suplier
            from reretur_pembelian reretur
            LEFT JOIN pegawai on pegawai.id=reretur.id_pegawai
            LEFT JOIN penduduk on penduduk.id=pegawai.id
        $where";
    if($id!=null){
        return _select_unique_result($sql);
    }else
        return _select_arr($sql);
}
function detail_reretur_muat_data($id){
    return _select_arr("select detail.*,b.nama as barang,o.kekuatan,o.generik,sd.nama as sediaan,
        ir.nama as pabrik,pb.nilai_konversi,st.nama as satuan_terkecil,sb.nama as satuan_terbesar 
        from 
        detail_retur_reretur detail 
        JOIN packing_barang pb on pb.id=detail.id_packing
        LEFT JOIN barang b on b.id=pb.id_barang
        LEFT JOIN satuan st on pb.id_satuan_terkecil=st.id
         LEFT JOIN satuan sb on pb.id_satuan_terbesar=sb.id    
        left join obat o on b.id=o.id 
        left join sediaan sd on sd.id=o.id_sediaan
        left join instansi_relasi ir on b.id_instansi_relasi_pabrik=ir.id
         where detail.id_reretur='$id'");
}
function retur_unit_muat_data($id = NULL) {
    if ($id != NULL) {
        $where = "where ru.id='$id'";
    }else
        $where = "";
    $sql = "
     select ru.*,pd.nama as pegawai from retur_unit ru join penduduk pd on ru.id_pegawai = pd.id $where    
     ";
    return _select_unique_result($sql);
}
function retur_penerimaan_muat_data($id = NULL) {
    if ($id != NULL) {
        $where = "where ru.id='$id'";
    }else
        $where = "";
    $sql = "
     select ru.*,pd.nama as pegawai from penerimaan_unit ru join penduduk pd on ru.id_pegawai = pd.id $where    
     ";
    return _select_arr($sql);
}

function retur_penjualan_muat_data($id = NULL) {
    if ($id != NULL) {
        $where = "where rp.id='$id'";
    }else
        $where = "";
    $sql = "
     select rp.*,pd.nama as pegawai,pembeli.nama as pembeli
            from retur_penjualan rp 
            join penduduk pd on rp.id_pegawai = pd.id
            JOIN detail_penjualan_retur_penjualan detail on rp.id=detail.id_retur_penjualan
            JOIN penjualan on penjualan.id=detail.id_penjualan
            LEFT JOIN penduduk pembeli on pembeli.id=penjualan.id_penduduk_pembeli 
    $where    
    GROUP BY rp.id
     ";
    return _select_arr($sql);
}


function level_muat_data() {
    $return = array();

    $sql = mysql_query("select * from level");
    while ($data = mysql_fetch_array($sql)) {
        $return[] = $data;
    }
    return $return;
}

function pemesanan_muat_data($id=NULL) {
    $return = array();
    if ($id != NULL) {
        $where = "where p.id=$id";
    }else
        $where = "";
    $sql = mysql_query("select p.*,ir.nama as instansi,p.id_instansi_relasi_suplier,pd.nama as pegawai from pemesanan p 
                       left join instansi_relasi ir on (p.id_instansi_relasi_suplier=ir.id)
                       left join penduduk pd on (p.id_pegawai=pd.id) $where");
    while ($data = mysql_fetch_array($sql)) {
        $return[] = $data;
    }
    return $return;
}

function pemusnahan_muat_data($startDate, $endDate, $idPegawai=null, $idSaksi=null, $idBarang=null) {
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);
    $requirement = "";
    if ($idPegawai != NULL) {
        $requirement .= " and pgw.id = '$idPegawai'";
    }
    if ($idSaksi != NULL) {
        $requirement .= "and saksi.id='$idSaksi'";
    }
    $sql = "
        select pm.id,DATE(pm.waktu) as tanggal,pgw.id as idPegawai,pdd.nama as namaPegawai,saksi.id as idSaksi, saksi.nama as namaSaksi from pemusnahan pm
        LEFT JOIN pegawai pgw on pgw.id=pm.id_pegawai
        LEFT JOIN penduduk pdd on pdd.id=pgw.id
        LEFT JOIN penduduk saksi on saksi.id=pm.id_penduduk_saksi
        LEFT JOIN detail_pemusnahan dpm on dpm.id_pemusnahan=pm.id
        LEFT JOIN packing_barang pb on pb.id=dpm.id_packing_barang
        LEFT JOIN barang b on b.id=pb.id_barang where DATE(pm.waktu)>='$startDate' and DATE(pm.waktu)<='$endDate' $requirement    
     ";
    return _select_arr($sql);
}

function detail_pemusnahan_muat_data($no) {
    $sql = "select b.nama as barang,dp.jumlah,o.kekuatan,o.generik,sd.nama as sediaan,ir.nama as pabrik,dp.alasan,dp.batch,pb.nilai_konversi,st.nama as satuan_terkecil
    from detail_pemusnahan dp
    LEFT JOIN packing_barang pb on pb.id=dp.id_packing_barang
    LEFT JOIN barang b on b.id=pb.id_barang
    LEFT JOIN satuan st on pb.id_satuan_terkecil=st.id
    left join obat o on b.id=o.id 
    left join sediaan sd on sd.id=o.id_sediaan
    left join instansi_relasi ir on b.id_instansi_relasi_pabrik=ir.id
    WHERE dp.id_pemusnahan='$no'";
    return _select_arr($sql);
}

function sp_muat_data($startDate = NULL, $endDate = NULL, $jenisSp = NULL, $idSuplier = NULL, $idPegawai = NULL) {
    $return = array();

    $requirement = "";
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);

    if ($startDate != null and $endDate != null) {
        $requirement .= " AND DATE(p.waktu)>='$startDate' and DATE(p.waktu)<='$endDate'";
    }

    if ($idSuplier != NULL) {
        $requirement .= " and p.id_instansi_relasi_suplier = '$idSuplier'";
    }
    if ($idPegawai != NULL) {
        $requirement .= "and p.id_pegawai='$idPegawai'";
    }
    if ($jenisSp != NULL) {
        $requirement .= "and p.jenis_sp='$jenisSp'";
    }
    $sql = mysql_query("select p.*,DATE(p.waktu) as tanggal,ir.nama as suplier
            FROM pemesanan p
           LEFT JOIN instansi_relasi ir on ir.id=p.id_instansi_relasi_suplier
            LEFT JOIN detail_pemesanan_faktur dpf on dpf.id_pemesanan=p.id
            LEFT JOIN packing_barang pb on pb.id=dpf.id_packing_barang
            LEFT JOIN barang b on b.id=pb.id_barang
            JOIN sub_kategori_barang subkategori on subkategori.id=b.id_sub_kategori_barang
            JOIN kategori_barang kategori on kategori.id=subkategori.id_kategori_barang
            where kategori.id!='0'
             $requirement group by p.id") or die(mysql_error());
    while ($data = mysql_fetch_array($sql)) {
        $return [] = $data;
    }
    return $return;
}

function detail_pemesanan_muat_data($id) {
    $return = array();

    if (isset($id)) {
        $action = "where dpf.id_pemesanan = '$id'";
    }else
        $action = "";
    $sql = mysql_query("select dpf.*,pb.id_satuan_terbesar,pb.id_barang,st.nama as satuan_terbesar,b.nama as barang,p.no_faktur,p.tanggal_jatuh_tempo,pd.nama as penerima 
                        from detail_pemesanan_faktur dpf
                        left join pembelian p on (dpf.id_pembelian=p.id)
                        left join penduduk pd on (p.id_pegawai=pd.id)
                        left join packing_barang pb on (dpf.id_packing_barang=pb.id)
                        left join satuan st on (pb.id_satuan_terbesar=st.id)
                        left join barang b on (pb.id_barang=b.id) $action");

    while ($data = mysql_fetch_array($sql)) {
        $return [] = $data;
    }
    return $return;
}

/**
 *
 * @param <type> $id_retur no retur
 * @param <type> $id_pembelian no pembelian
 */
function detail_retur_muat_data($id_retur) {

    if ($id_retur != null) {
        $where1 = " Where dpr.id_retur='$id_retur'";
    }else
        $where1="";
    $sql = "SELECT dpr.id as iddetail,s.nama as sediaan, pb.nilai_konversi, st.nama as satuan_terkecil, ir.nama as pabrik,
    o.*, dpr.id as iddetail,b.nama as barang,dpr.batch_retur,dpr.jumlah_retur,
    dpr.alasan,dpr.no_faktur,dpr.jumlah_reretur as jumlah_reretur,pb.id as id_packing,sb.nama as satuan_terbesar
FROM detail_retur_reretur dpr
    JOIN packing_barang pb on pb.id=dpr.id_packing
    JOIN barang b on b.id=pb.id_barang
    LEFT JOIN obat o on b.id = o.id
    LEFT JOIN sediaan s on s.id = o.id_sediaan
    LEFT JOIN satuan st on st.id = pb.id_satuan_terkecil
    LEFT JOIN satuan sb on sb.id = pb.id_satuan_terbesar
    LEFT JOIN retur_pembelian r on r.id=dpr.id_retur
    LEFT JOIN instansi_relasi ir on ir.id = b.id_instansi_relasi_pabrik
      $where1 group by dpr.id_retur,dpr.id_packing,dpr.no_faktur,dpr.batch_retur";
    return _select_arr($sql);
}

function jenis_transaksi_muat_data($id=NULL) {
    if ($id != NULL) {
        $where = "where id='$id'";
    }else
        $where = "";
    $sql = "select * from jenis_transaksi $where";
    return _select_arr($sql);
}

function sp_muat_data_by_id($id) {
    $sql = "select
    p.id,DATE(p.waktu) as tanggal,u.nama as unit,role.nama_role as role,p.id_instansi_relasi_suplier as id_suplier,ir.nama as suplier,kab.nama as kabupaten,ir.alamat,p.jenis_sp,pd.nama as pegawai,pd.sip,peg.nip,
    dp.alamat_jalan,dp.no_telp,l.nama as level
    from pemesanan p
    LEFT JOIN instansi_relasi ir on ir.id=p.id_instansi_relasi_suplier
    join penduduk pd on p.id_pegawai=pd.id
    left join dinamis_penduduk dp on pd.id = dp.id_penduduk
    left join pegawai peg on pd.id = peg.id
    left join level l on peg.id_level = l.id
    left join kelurahan kel on kel.id=ir.id_kelurahan
    LEFT JOIN kecamatan kec on kec.id=kel.id_kecamatan
    left join kabupaten kab on kab.id=kec.id_kabupaten
    left join users users on users.id = pd.id
    left join unit u on users.id_unit = u.id
    left join role role on users.id_role = role.id_role
    where p.id='$id'";
    $sp['master'] = _select_unique_result($sql);

    $sql = "select
    dpf.id as id_detail,o.generik,pb.id as id_packing,pb.nilai_konversi,sd.nama as sediaan,o.kekuatan,b.nama as nama_barang,dpf.jumlah_pesan,s.nama as satuan_terkecil,s2.nama as satuan_terbesar,ir.nama as pabrik,
    o.generik,(select sisa from stok WHERE stok.id_packing_barang=pb.id ORDER BY waktu desc,id desc LIMIT 0,1) as sisa
    from detail_pemesanan_faktur dpf
    JOIN packing_barang pb on pb.id=dpf.id_packing_barang
    JOIN barang b on b.id=pb.id_barang
    left join obat o on b.id=o.id
    left join sediaan sd on o.id_sediaan = sd.id
    JOIN satuan s on s.id=pb.id_satuan_terkecil
    JOIN satuan s2 on s2.id=pb.id_satuan_terbesar
    left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
    where dpf.id_pemesanan='$id'";
    $sp['barang'] = _select_arr($sql);

    return $sp;
}

function barang_adm_muat_data($idPacking=null, $barang=null, $idSubKategori=null, $idKelas=null, $page = NULL,$dataPerPage = NULL) {
		if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
    $where = " $katbarang ";
    if ($idPacking != null) {
        $where .= " AND pb.id='$idPacking'";
    } else if ($barang != null && $barang != '') {
        $where .=" AND b.nama like '%$barang%'";
    }
    if ($idSubKategori != null) {
        $where.=" AND sb.id='$idSubKategori'";
    }
    if ($idKelas != null) {
        $where.=" AND mp.id_kelas='$idKelas'";
    }
    
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
    
    $sql = "select mp.id as id_margin,k.nama as nama_kelas,b.nama as barang,pb.id as id_packing,mp.nilai_persentase as margin,pb.nilai_konversi,satuan.nama as satuan_terkecil,
        (select stok.hpp from stok where stok.id_packing_barang=pb.id and stok.id_jenis_transaksi='2' order by stok.waktu desc limit 0,1) as hpp,
        (select stok.hna from stok where stok.id_packing_barang=pb.id and stok.id_jenis_transaksi='2' order by stok.waktu desc limit 0,1) as hna
        from margin_packing_barang_kelas mp
        LEFT JOIN packing_barang pb on pb.id=mp.id_packing_barang
        LEFT JOIN barang b on b.id=pb.id_barang
        LEFT JOIN kelas k on k.id=mp.id_kelas
        LEFT JOIN sub_kategori_barang sb on sb.id=b.id_sub_kategori_barang
        LEFT JOIN kategori_barang kb on kb.id=sb.id_kategori_barang
        LEFT JOIN satuan ON satuan.id=pb.id_satuan_terkecil
        $where $batas";

    $result['list'] = _select_arr($sql);
    $sqli = "select mp.id as id_margin,k.nama as nama_kelas,b.nama as barang,pb.id as id_packing,mp.nilai_persentase as margin,pb.nilai_konversi,satuan.nama as satuan_terkecil,
        (select stok.hpp from stok where stok.id_packing_barang=pb.id and stok.id_jenis_transaksi='2' order by stok.waktu desc limit 0,1) as hpp,
        (select stok.hna from stok where stok.id_packing_barang=pb.id and stok.id_jenis_transaksi='2' order by stok.waktu desc limit 0,1) as hna
        from margin_packing_barang_kelas mp
        LEFT JOIN packing_barang pb on pb.id=mp.id_packing_barang
        LEFT JOIN barang b on b.id=pb.id_barang
        LEFT JOIN kelas k on k.id=mp.id_kelas
        LEFT JOIN sub_kategori_barang sb on sb.id=b.id_sub_kategori_barang
        LEFT JOIN kategori_barang kb on kb.id=sb.id_kategori_barang
        LEFT JOIN satuan ON satuan.id=pb.id_satuan_terkecil
        $where";
    
    $result['paging'] = pagination($sqli, $dataPerPage);
    $result['offset'] = $offset;
    return $result;
}
function adm_harga_muat_data($idPacking=null, $barang=null, $idSubKategori=null, $idKelas=null,$page=NULL, $dataPerPage = NULL, $sort = NULL, $sortBy = NULL){
   	if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
    $where = " $katbarang
                AND st.id IN (SELECT max( st2.id ) FROM stok_unit st2 WHERE st2.id_packing_barang = pb.id) ";
    if ($idPacking != null) {
        $where .= " AND pb.id='$idPacking'";
    } else if ($barang != null && $barang != '') {
        $where .=" AND b.nama like '%$barang%'";
    }
    if ($idSubKategori != null) {
        $where.=" AND sb.id='$idSubKategori'";
    }
    if ($idKelas != null) {
        $where.=" AND k.id='$idKelas'";
    }
    if(isset ($sort) && $sort != ""){
        if($sort == 1){
          $sorting = "order by b.nama $sortBy";
        }else if($sort == 2){
          $sorting = "order by k.nama $sortBy";
        }
    }else $sorting = "";

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
    $sql = "SELECT st.id AS id_stok, st.hpp, st.hna, ins.nama AS pabrik, sd.nama AS sediaan,
                o.kekuatan, o.generik, b.nama AS barang, pb.id AS id_packing, pb.nilai_konversi,
                satuan.nama AS satuan_terkecil,k.id as id_kelas,k.nama as nama_kelas,k.margin
            FROM kelas k, stok_unit st
                LEFT JOIN packing_barang pb ON pb.id = st.id_packing_barang
                LEFT JOIN barang b ON b.id = pb.id_barang
                LEFT JOIN obat o ON b.id = o.id
                LEFT JOIN sediaan sd ON o.id_sediaan = sd.id
                LEFT JOIN sub_kategori_barang sb ON sb.id = b.id_sub_kategori_barang
                LEFT JOIN kategori_barang kb ON kb.id = sb.id_kategori_barang
                LEFT JOIN instansi_relasi ins ON b.id_instansi_relasi_pabrik = ins.id
                LEFT JOIN satuan ON satuan.id = pb.id_satuan_terkecil
             $where $sorting $batas";

    $result['list'] = _select_arr($sql);
    $sqli = "SELECT st.id AS id_stok, st.hpp, st.hna, ins.nama AS pabrik, sd.nama AS sediaan,
                o.kekuatan, o.generik, b.nama AS barang, pb.id AS id_packing, pb.nilai_konversi,
                satuan.nama AS satuan_terkecil,k.id as id_kelas,k.nama as nama_kelas,k.margin
            FROM kelas k, stok_unit st
                LEFT JOIN packing_barang pb ON pb.id = st.id_packing_barang
                LEFT JOIN barang b ON b.id = pb.id_barang
                LEFT JOIN obat o ON b.id = o.id
                LEFT JOIN sediaan sd ON o.id_sediaan = sd.id
                LEFT JOIN sub_kategori_barang sb ON sb.id = b.id_sub_kategori_barang
                LEFT JOIN kategori_barang kb ON kb.id = sb.id_kategori_barang
                LEFT JOIN instansi_relasi ins ON b.id_instansi_relasi_pabrik = ins.id
                LEFT JOIN satuan ON satuan.id = pb.id_satuan_terkecil
            $where order by b.nama";

    $result['paging'] = paging($sqli, $dataPerPage);
    $result['offset'] = $offset;
    return $result;
}
function pemusnahan_muat_data_by_id($id) {
    $sql = "select pm.id_pegawai,pm.id_penduduk_saksi,p1.nama as pegawai,p2.nama as saksi ,pm.waktu
            from pemusnahan pm 
            left join penduduk p1 on pm.id_pegawai=p1.id
            left join penduduk p2 on pm.id_penduduk_saksi=p2.id 
            where pm.id='$id'";
    $pemusnahan['master'] = _select_unique_result($sql);

    $sql = "select satuan_terkecil.nama as satuan_terkecil,dp.id_packing_barang,
dp.batch,dp.jumlah,dp.alasan,b.nama as barang,o.generik,o.kekuatan,s.nama as sediaan,ir.nama as pabrik,pb.nilai_konversi,
(select sisa from stok WHERE stok.id_packing_barang=dp.id_packing_barang ORDER BY waktu desc,id desc LIMIT 0,1) as sisa
           from detail_pemusnahan dp 
    left join packing_barang pb on dp.id_packing_barang=pb.id 
    left join satuan satuan_terkecil on satuan_terkecil.id=pb.id_satuan_terkecil
    left join satuan satuan_terbesar on satuan_terbesar.id=pb.id_satuan_terbesar
    left join barang b on b.id=pb.id_barang 
    left join obat o on o.id=b.id
    left join sediaan s on s.id=o.id_sediaan
    left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
    where dp.id_pemusnahan='$id' ";
    $pemusnahan['detail'] = _select_arr($sql);
    return $pemusnahan;
}

function administrasi_apoteker_muat_data($id=NULL) {
    if ($id != NULL) {
        $where = "where id='$id'";
    }
    else
        $where = "";
    $sql = "select * from biaya_apoteker $where";
    $data = _select_arr($sql);
    if (count($data) == 0) {
        _insert("INSERT INTO biaya_apoteker (nilai) VALUES ('0')");
        return administrasi_apoteker_muat_data();
    }else
        return $data;
}

function penjualan_report_muat_data($idPenjualan) {
    $sql = "select p.id as no_penjualan,pembeli.nama as pembeli,Date(p.waktu) as tanggal,petugas.nama as petugas from penjualan p
    LEFT JOIN penduduk pembeli on pembeli.id=p.id_penduduk_pembeli
    LEFT JOIN pegawai pegw on pegw.id=p.id_pegawai
    LEFT JOIN penduduk petugas on petugas.id=pegw.id
    where p.id='$idPenjualan'";
    $penjualan['master'] = _select_unique_result($sql);
    $sql = "select b.nama as barang,detail.jumlah_penjualan,((pb.hna*(mp.nilai_persentase/100))+pb.hna) as harga,detail.diskon
        from detail_penjualan_retur_penjualan detail
        JOIN packing_barang pb on pb.id=detail.id_packing_barang
		JOIN margin_packing_barang_kelas mp on pb.id = mp.id_packing_barang
        JOIN barang b on b.id=pb.id_barang
        where detail.id_penjualan='$idPenjualan'";
    $penjualan['detail'] = _select_arr($sql);
    return $penjualan;
}

function salin_resep_muat_data($idResep) {
    $sql = "select r.id as no_resep,pasien.nama as pasien,dokter.nama as dokter,DATE(r.tanggal)as tanggal from resep r
        JOIN penduduk pasien on pasien.id=r.id_penduduk_objek
        JOIN penduduk dokter on dokter.id=r.id_penduduk_dokter
        where r.id='$idResep'";
    $resep['master'] = _select_unique_result($sql);
    $sql = "select b.nama as barang,dr.jumlah,dr.aturan_pakai,dr.jumlah_tebus from detail_resep dr
        JOIN packing_barang pb on pb.id=dr.id_packing_barang
        JOIN barang b on b.id=pb.id_barang
        where dr.id_resep='$idResep'";
    $resep['detail'] = _select_arr($sql);
    return $resep;
}

function penjualan_resep_muat_data($startDate=NULL, $endDate=NULL, $idDokter=NULL, $idPasien=NULL) {
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);
    $where = "";
    if ($startDate != NULL && $endDate != NULL) {
        $where .= "where r.tanggal >='$startDate' and r.tanggal <= '$endDate'";
    }if ($idDokter != NULL) {
        $where .= "and r.id_penduduk_dokter='$idDokter'";
    }if ($idPasien != NULL) {
        $where .= "and r.id_penduduk_objek='$idPasien'";
    }
    $sql = " select r.*,i.nama as instansi_relasi,pd1.nama as pasien,pd2.nama as dokter,pd2.sip from resep r
    left join instansi_relasi i on r.id_instansi_kesehatan = i.id
    join penduduk pd1 on r.id_penduduk_objek = pd1.id
    join penduduk pd2 on r.id_penduduk_dokter = pd2.id $where";

    return _select_arr($sql);
}

function asuransi_produk_muat_data($id=null,$key=NULL,$sort=NULL) {
    if ($id != null) {
        $where = " where ap.id='$id'";
    }else
        $where="";

    if ($sort == "desc")
        $order = "ORDER BY ap.nama DESC";
    else if ($sort == "asc")
        $order = "ORDER BY ap.nama ASC";
    else
        $order = "ORDER BY ap.nama ASC";

    $sql = "select ap.id,ap.nama as asuransi,ap.id_instansi_relasi,ir.nama as perusahaan from asuransi_produk ap
          LEFT JOIN instansi_relasi ir on ir.id=ap.id_instansi_relasi $where $order";

        return _select_arr($sql);
}

function distribusi_muat_data($startDate, $endDate, $idPegawai=null, $idUnit=null) {
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);
    $where = " WHERE  DATE(d.waktu)>='$startDate' AND DATE(d.waktu)<='$endDate' ";
    if ($idPegawai != null) {
        $where.=" AND p.id='$idPegawai'";
    }
    if ($idUnit != null) {
        $where.=" AND u.id='$idUnit'";
    }
    $sql = "select d.id as id_distribusi,DATE(d.waktu) as tanggal,u.nama as unit_tujuan,pdd.nama as nama_pegawai from distribusi d
        LEFT JOIN unit u on u.id=d.id_unit_tujuan
        LEFT JOIN pegawai p on p.id=d.id_pegawai
        LEFT JOIN penduduk pdd on pdd.id=p.id
        $where";
    return _select_arr($sql);
}

function resep_muat_data($startDate, $endDate, $idDokter=null, $idPasien=null) {
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);
    $where = " WHERE p.jenis='Resep' AND DATE(p.waktu)>='$startDate' AND DATE(p.waktu)<='$endDate' ";
    if ($idDokter != null) {
        $where.=" AND p.id_penduduk_dokter='$idDokter'";
    }
    if ($idPasien != null) {
        $where.=" AND p.id_penduduk_pembeli='$idPasien'";
    }
    $sql = "SELECT p.id as id_penjualan,drp.no_resep,
            date(p.waktu) as tanggal,pdd2.nama as nama_dokter,
                    pdd1.nama as nama_pasien
            FROM penjualan p
            left join detail_penjualan_retur_penjualan dprp on(dprp.id_penjualan=p.id)
            left join detail_resep_penjualan drp on (drp.id_detail_penjualan_retur_penjualan=dprp.id)
            left join penduduk pdd1 on(pdd1.id=p.id_penduduk_pembeli)
            left join penduduk pdd2 on(pdd2.id=p.id_penduduk_dokter)
        $where  AND drp.no_resep<>0 GROUP BY drp.no_resep";
    
//echo "<pre>$sql</pre>";
    return _select_arr($sql);
}

function jumlah_no_r_muat_data($startDate, $endDate, $idDokter=null, $idPasien=null){
    $startDate = date2mysql($startDate);
    $endDate = date2mysql($endDate);
    $where = " WHERE p.jenis='Resep' AND DATE(p.waktu)>='$startDate' AND DATE(p.waktu)<='$endDate' ";
    if ($idDokter != null) {
        $where.=" AND p.id_penduduk_dokter='$idDokter'";
    }
    if ($idPasien != null) {
        $where.=" AND p.id_penduduk_pembeli='$idPasien'";
    }
    $sql = "SELECT count(*) as jumlah_no_r
            FROM penjualan p
            left join detail_penjualan_retur_penjualan dprp on(dprp.id_penjualan=p.id)
            left join detail_resep_penjualan drp on (drp.id_detail_penjualan_retur_penjualan=dprp.id)
            left join penduduk pdd1 on(pdd1.id=p.id_penduduk_pembeli)
            left join penduduk pdd2 on(pdd2.id=p.id_penduduk_dokter)
        $where  AND drp.no_resep<>0";
    
//echo "<pre>$sql</pre>";
    return _select_unique_result($sql);
}

function detail_resep_muat_data($id,$id_resep=null) {
    if($id_resep!=null){
        $resep=" AND drp.no_resep=$id_resep";
    }else{
        $resep="";
    }
    $sql = "select
            dprp.id_penjualan as no_resep,dprp.id_penjualan as no_nota,drp.no_r,drp.kekuatan_r_racik,drp.jumlah_r_resep,
            ap.nama as aturan_pakai,drp.jumlah_r_tebus,(drp.jumlah_r_resep-drp.jumlah_r_tebus) as detur,
            dprp.hna,dprp.margin,dprp.jumlah_penjualan,dprp.id_retur_penjualan,
            dprp.jumlah_retur,dprp.alasan,b.nama as nama_barang,pb.nilai_konversi,st.nama as satuan_terkecil
        from detail_penjualan_retur_penjualan dprp
            left join detail_resep_penjualan drp on(drp.id_detail_penjualan_retur_penjualan=dprp.id)
            left join packing_barang pb on(pb.id=dprp.id_packing_barang)
            left join barang b on(b.id=pb.id_barang)
            left join satuan st on(st.id=pb.id_satuan_terkecil)
            left join aturan_pakai ap on(ap.id=drp.id_aturan_pakai)
        where dprp.id_penjualan='$id' $resep";
        
    return _select_arr($sql);
}

function stock_opname_muat_data2($gudang = NULL,$page = NULL,$dataPerPage = NULL, $code = NULL) {
    $result = array();
	if($gudang==1){
		$slc=",s.batch,s.ed";
		$st="stok";
                $grup = "group by s.id_packing_barang,s.batch";
	}else{
              
		$slc="";
		$st="stok_unit";
                $grup = "group by s.id_packing_barang,s.batch";
	}
	if($code != NULL){
           $cari = " and b.nama like ('%$code%') ";
          } else
          $cari='';
	$unit = $_SESSION['id_unit'];
	if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
    if (isset($dataPerPage) && $dataPerPage != null) {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas = "limit $offset, $dataPerPage";
    } else {
        $batas = '';
        $offset = '';
    }
    
    $sql = "select pb.id as id_packing,s.batch $slc
           from $st s
    left join packing_barang pb on s.id_packing_barang = pb.id
    left join barang b on pb.id_barang = b.id
    left join satuan st on pb.id_satuan_terkecil = st.id
    left join obat o on b.id = o.id
    left join sediaan sd on o.id_sediaan = sd.id
    left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
    where s.id_jenis_transaksi = 11 and s.id_unit='$unit' $cari order by s.waktu desc $batas
	";
		   

	
    
    $temp=array();
    $stok = _select_arr($sql);
    foreach ($stok as $row){
        $batch = isset ($row['batch'])?$row['batch']:"";
        
        if(($batch)!=''){
            $req2="and s.batch='$batch'";
        }else
            $req2="and s.batch='$batch'";
        
        $temp[] = _select_unique_result("select 
                s.id,s.id_packing_barang,s.waktu,s.batch,s.sisa,s.hpp,s.hna $slc,b.nama as barang,pb.nilai_konversi,st.nama as satuan,st12.nama as kemasan, ins.nama as pabrik, o.kekuatan, 
                sediaan.nama as sediaan, o.generik, sk.nama as kategori
	from $st s
        left join packing_barang pb on s.id_packing_barang = pb.id
        left join barang b on pb.id_barang = b.id
	LEFT JOIN obat o on (o.id = b.id)
	LEFT JOIN sediaan on o.id_sediaan=sediaan.id
	LEFT JOIN  sub_kategori_barang sk on b.id_sub_kategori_barang=sk.id
        left join satuan st on pb.id_satuan_terkecil = st.id
	left join satuan st12 on pb.id_satuan_terbesar = st12.id
	left join instansi_relasi ins on ins.id=b.id_instansi_relasi_pabrik 
        where s.id_unit='$unit' $req2 and pb.id = '$row[id_packing]' and s.id_jenis_transaksi='11' order by s.id desc");
    }
    $sqli = "select pb.id as id_packing $slc
           from $st s
           join packing_barang pb on (s.id_packing_barang=pb.id) join unit u on (s.id_unit=u.id)
           join jenis_transaksi j on (s.id_jenis_transaksi=j.id) join satuan st on (pb.id_satuan_terkecil=st.id)
           join barang b on (pb.id_barang=b.id)
           join sub_kategori_barang skb on (b.id_sub_kategori_barang=skb.id) where s.id_unit='$unit' s.id_jenis_transaksi='11' $cari $grup order by s.id,s.waktu desc";
    $result['paging'] = paging($sql, $dataPerPage);
    $result['list'] = $temp;
    $result['offset'] = $offset;
    $result['total'] = countrow($sql);
    
    return $result;
}

function stock_opname_muat_data($id = NULL,$gudang = NULL) {
    $unit = $_SESSION['id_unit'];
    if(isset ($id)){
        $action = "and s.id = '$id'";
    }else $action = "";
    if($gudang==1){
		$slc=",s.batch,s.ed";
		$st="stok";
	}else{
		$slc="";
		$st="stok_unit";
	}
    $sql = "select s.id,s.id_packing_barang,s.batch as batch,s.waktu,s.sisa,s.hpp,s.hna $slc,b.nama as barang,pb.nilai_konversi,st.nama as satuan, stn.nama as besar 
	from $st s
    left join packing_barang pb on s.id_packing_barang = pb.id
    left join barang b on pb.id_barang = b.id
    left join satuan st on pb.id_satuan_terkecil = st.id
	left join satuan stn on pb.id_satuan_terbesar = stn.id
    where s.id_jenis_transaksi = 11 and s.id_unit='$unit' $action";
    return _select_arr($sql);
}


function info_stock_opname_muat_data($idBarang = NULL, $startDate = NULL, $endDate = NULL) {
    $unit = $_SESSION['id_unit'];
    $where = "";
    if ($startDate != NULL && $endDate != NULL) {
        $where .= "and DATE(s.waktu) >='" . date2mysql($startDate) . "' and DATE(s.waktu) <= '" . date2mysql($endDate) . "'";
    }
    if ($idBarang != NULL) {
        $where .= " and s.id_packing_barang = '$idBarang'";
    }

    $sql = "select s.waktu,s.id_packing_barang,s.sisa,sd.nama as sediaan,o.kekuatan,o.generik,ins.nama as pabrik,s.hpp,s.hna,b.nama as barang,pb.nilai_konversi,st.nama as satuan,s.batch as batch from stok_unit s
    left join packing_barang pb on s.id_packing_barang = pb.id
    left join barang b on pb.id_barang = b.id
    left join satuan st on pb.id_satuan_terkecil = st.id
    left join obat o on b.id = o.id
    left join sediaan sd on o.id_sediaan = sd.id
    left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
    where s.id_jenis_transaksi = 11 and s.id_unit='$unit' $where order by s.waktu desc";

    return _select_arr($sql);
}
function info_stock_opname_gudang_muat_data($idBarang = NULL, $startDate = NULL, $endDate = NULL) {
    $unit = $_SESSION['id_unit'];
    $where = "";
    if ($startDate != NULL && $endDate != NULL) {
        $where .= "and DATE(s.waktu) >='" . date2mysql($startDate) . "' and DATE(s.waktu) <= '" . date2mysql($endDate) . "'";
    }
    if ($idBarang != NULL) {
        $where .= " and s.id_packing_barang = '$idBarang'";
    }

    $sql = "select s.waktu,s.id_packing_barang,s.batch,sd.nama as sediaan,o.kekuatan,s.ed,ins.nama as pabrik,o.generik,s.sisa,s.hpp,s.hna,b.nama as barang,pb.nilai_konversi,st.nama as satuan from stok s
    left join packing_barang pb on s.id_packing_barang = pb.id
    left join barang b on pb.id_barang = b.id
    left join satuan st on pb.id_satuan_terkecil = st.id
    left join obat o on b.id = o.id
    left join sediaan sd on o.id_sediaan = sd.id
    left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
    where s.id_jenis_transaksi = 11 and s.id_unit='$unit' $where order by s.waktu desc";

    return _select_arr($sql);
}
function info_repackage_muat_data($idBarang = NULL, $startDate = NULL, $endDate = NULL){
     $unit = $_SESSION['id_unit'];
    $where = "";
    if ($startDate != NULL && $endDate != NULL) {
        $where .= "and DATE(s.waktu) >='" . date2mysql($startDate) . "' and DATE(s.waktu) <= '" . date2mysql($endDate) . "'";
    }
    if ($idBarang != NULL) {
        $where .= " and s.id_packing_barang = '$idBarang'";
    }

    $sql = "select
    s.waktu,s.id_packing_barang,s.batch,s.ed,s.sisa,s.hpp,s.hna,b.nama as barang,pb.nilai_konversi,st.nama as satuan,st2.nama as kemasan,s.keluar,
    ir.nama as pabrik,o.kekuatan,o.generik,sd.nama as sediaan
    from stok s    
    left join packing_barang pb on s.id_packing_barang = pb.id
    left join barang b on pb.id_barang = b.id
    LEFT JOIN  obat o on (o.id = b.id)
    left join sediaan sd on o.id_sediaan = sd.id
    left join satuan st on pb.id_satuan_terkecil = st.id
    left join satuan st2 on pb.id_satuan_terbesar = st2.id
    LEFT JOIN instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
    where s.id_jenis_transaksi = 13 and s.id_unit='$unit' $where";
    
    return _select_arr($sql);
} 
function repackage_muat_data($stokAsal = NULL,$stokHasil = NULL){
    $sql = "select awal.hna,awal.hpp,awal.sisa,awal.batch,awal.keluar,br_asal.nama as barang,st2_asal.nama as satuan_terkecil,pb_asal.nilai_konversi,o_asal.generik,
    st1_asal.nama as satuan_terbesar,sd_asal.nama as sediaan,o_asal.kekuatan as kekuatan,ir_asal.nama as pabrik from stok awal 
    left join packing_barang pb_asal on awal.id_packing_barang = pb_asal.id
    left join barang br_asal on pb_asal.id_barang = br_asal.id
    left join obat o_asal on br_asal.id = o_asal.id
    left join sediaan sd_asal on o_asal.id_sediaan = sd_asal.id
    left join satuan st1_asal on pb_asal.id_satuan_terbesar = st1_asal.id
    left join satuan st2_asal on pb_asal.id_satuan_terkecil = st2_asal.id
    left join instansi_relasi ir_asal on br_asal.id_instansi_relasi_pabrik = ir_asal.id
    where awal.id = '$stokAsal'
    union select hasil.hna,hasil.hpp,hasil.sisa,hasil.batch,hasil.keluar,br_hasil.nama as barang,st2_hasil.nama as satuan_terkecil,pb_hasil.nilai_konversi,o_hasil.generik,
    st1_hasil.nama as satuan_terbesar,sd_hasil.nama as sediaan,o_hasil.kekuatan as kekuatan,ir_hasil.nama as pabrik from stok hasil 
    left join packing_barang pb_hasil on hasil.id_packing_barang = pb_hasil.id
    left join barang br_hasil on pb_hasil.id_barang = br_hasil.id
    left join obat o_hasil on br_hasil.id = o_hasil.id
    left join sediaan sd_hasil on o_hasil.id_sediaan = sd_hasil.id
    left join satuan st1_hasil on pb_hasil.id_satuan_terbesar = st1_hasil.id
    left join satuan st2_hasil on pb_hasil.id_satuan_terkecil = st2_hasil.id
    left join instansi_relasi ir_hasil on br_hasil.id_instansi_relasi_pabrik = ir_hasil.id where hasil.id = '$stokHasil'";
    
    return _select_arr($sql);
}
function pecah_stok_muat_data($stokAsal = NULL,$stokHasil = NULL){
    $sql = "select awal.hna,awal.hpp,awal.sisa,awal.keluar,br_asal.nama as barang,st2_asal.nama as satuan_terkecil,pb_asal.nilai_konversi,o_asal.generik,
    st1_asal.nama as satuan_terbesar,sd_asal.nama as sediaan,o_asal.kekuatan as kekuatan,ir_asal.nama as pabrik from stok_unit awal 
    left join packing_barang pb_asal on awal.id_packing_barang = pb_asal.id
    left join barang br_asal on pb_asal.id_barang = br_asal.id
    left join obat o_asal on br_asal.id = o_asal.id
    left join sediaan sd_asal on o_asal.id_sediaan = sd_asal.id
    left join satuan st1_asal on pb_asal.id_satuan_terbesar = st1_asal.id
    left join satuan st2_asal on pb_asal.id_satuan_terkecil = st2_asal.id
    left join instansi_relasi ir_asal on br_asal.id_instansi_relasi_pabrik = ir_asal.id
    where awal.id = '$stokAsal' and awal.waktu = (select max(waktu) from stok_unit where id_packing_barang=pb_asal.id) ";
     $result['sunit'] = _select_unique_result($sql);
	 
  $sql2="select hasil.hna,hasil.hpp,hasil.sisa,hasil.batch,hasil.awal,hasil.masuk,br_hasil.nama as barang,st2_hasil.nama as satuan_terkecil,pb_hasil.nilai_konversi,o_hasil.generik,
    st1_hasil.nama as satuan_terbesar,sd_hasil.nama as sediaan,o_hasil.kekuatan as kekuatan,ir_hasil.nama as pabrik from stok hasil 
    left join packing_barang pb_hasil on hasil.id_packing_barang = pb_hasil.id
    left join barang br_hasil on pb_hasil.id_barang = br_hasil.id
    left join obat o_hasil on br_hasil.id = o_hasil.id
    left join sediaan sd_hasil on o_hasil.id_sediaan = sd_hasil.id
    left join satuan st1_hasil on pb_hasil.id_satuan_terbesar = st1_hasil.id
    left join satuan st2_hasil on pb_hasil.id_satuan_terkecil = st2_hasil.id
    left join instansi_relasi ir_hasil on br_hasil.id_instansi_relasi_pabrik = ir_hasil.id where hasil.id = '$stokHasil'  and hasil.waktu = (select max(waktu) from stok_unit where id_packing_barang=pb_hasil.id) ";
       $result['stok'] = _select_unique_result($sql2);
   return $result;
}
function head_laporan_muat_data() {
    $sql = "select * from rumah_sakit";

    return _select_unique_result($sql);
}

function jumlah_jenis_pemesanan() {
    $sql = "select
    (select count(*) from pemesanan where pemesanan.jenis_sp='Umum')as Umum,
    (select count(*) from pemesanan where pemesanan.jenis_sp='Narkotik')as Narkotik,
    (select count(*) from pemesanan where pemesanan.jenis_sp='Psikotropik')as Psikotropik";
    return _select_unique_result($sql);
}

function sub_kategori_barang_muat_data($id_kategori = null) {
    $require = "";
    if ($id_kategori != null) {
        $require = "and s.id_kategori_barang = '$id_kategori'";
    }
    $sql = "select s.*, k.nama as kategori from sub_kategori_barang s join kategori_barang k on (s.id_kategori_barang = k.id) where s.id_kategori_barang !='0' $require order by s.nama asc";
    return _select_arr($sql);
}


function penjualan_laporan_abc_muat_data($starDate = null, $endDate = null) {
	$sqli = "select sum(s.hna + (s.hna * (s.margin/100))) as total
	from stok_unit s 
	join packing_barang pb on (s.id_packing_barang = pb.id)
	join barang b on (pb.id_barang = b.id)
	join sub_kategori_barang sk on (b.id_sub_kategori_barang = sk.id)
	where s.id_jenis_transaksi = 8 and date(waktu) between '".date2mysql($starDate)."' and '".date2mysql($endDate)."'";
	
	$result = _select_unique_result($sqli);
	return $result;
}

function laporan_abc_muat_data($id_sub_kategori_barang = null, $starDate = null, $endDate = null) {
    $syarat = null;
    if ($id_sub_kategori_barang != null) {
            $syarat = "and b.id_sub_kategori_barang = '$id_sub_kategori_barang'";
    }
    $result = array();
    $syarat = null;
    if ($id_sub_kategori_barang != null) {
        $syarat = "and b.id_sub_kategori_barang = '$id_sub_kategori_barang'";
    }
    $result = array();
    $sqli = mysql_query("select sum(s.hna + (s.hna * (s.margin/100))) as total
	from stok_unit s 
	join packing_barang pb on (s.id_packing_barang = pb.id)
	join barang b on (pb.id_barang = b.id)
	join sub_kategori_barang sk on (b.id_sub_kategori_barang = sk.id)
	where s.id_jenis_transaksi = 8 and date(waktu) between '" . date2mysql($starDate) . "' and '" . date2mysql($endDate) . "'");
    $result = mysql_fetch_array($sqli);

    $sql = "select b.nama, sum(s.keluar) as jumlah_penjualan, (s.hna + (s.hna * (s.margin/100))) as harga_jual, sum(s.hna + (s.hna * (s.margin/100))) as total_harga,
	sum(s.hna + (s.hna * (s.margin/100))) / $result[total] as persentase
	from stok_unit s 
	join packing_barang pb on (s.id_packing_barang = pb.id)
	join barang b on (pb.id_barang = b.id)
	join sub_kategori_barang sk on (b.id_sub_kategori_barang = sk.id)
	where s.id_jenis_transaksi = 8 and date(waktu) between '" . date2mysql($starDate) . "' and '" . date2mysql($endDate) . "' $syarat
	group by s.id_packing_barang";
    $result['list'] = _select_arr($sql);
    return $result;
}

function get_new_tarif_id() {
    $sql = "select max(id) as id from tarif";
    $id = _select_unique_result($sql);
    if (empty($id['id'])) {
        return 1;
    }else
        return $id['id'];
}

function aturan_pakai_muat_list_data($id = null,$key=null, $sort=null, $by=null) {
 if ($id != null) {
        $where = " where id = '$id'";
    }else
        $where='';
    if($key != NULL){
           $cari = "where nama like ('%$key%') ";
          } else
          $cari='';
		  
	if ($sort == "nama")
        $order = "ORDER BY nama $by";
    else if ($sort == "id")
        $order = "ORDER BY id $by";
    else
        $order = "ORDER BY id ASC";
    
    $sql = "select * from aturan_pakai $where $cari $order";//order by nama asc";
  if ($id != null) {
    	$result = _select_unique_result($sql);
        $result['list'] = _select_arr($sql);
    }else
      $result['list'] = _select_arr($sql);
	  
	   return $result;
}

function informasi_billing_muat_data($id) {
    //tidak menampilkan layanan yang mempunyai nama rekam medik
    $sql = "select b.id, DATE(b.waktu) as tanggal,TIME(b.waktu) as waktu, l.nama as layanan,l.bobot,s.nama as spesialisasi,p.nama as profesi, kl.nama as kelas, t.total as harga, detail.frekuensi, (t.total * detail.frekuensi) as subtotal,ins.nama as instalasi,
        l.jenis,kl.id as id_kelas,ins.id as id_instalasi
	from billing b
	left join detail_billing detail on (detail.id_billing = b.id)
	left join tarif t on (t.id = detail.id_tarif)
	left join layanan l on (l.id = t.id_layanan)
	left join kelas kl on (kl.id = t.id_kelas)
        left join spesialisasi s on l.id_spesialisasi=s.id
        left join instalasi ins on l.id_instalasi=ins.id
        left join profesi p on s.id_profesi=p.id
        where  b.id=(select max(id) from billing
            where billing.id_pasien = '$id') and b.id_pasien='$id'";

    return _select_arr($sql);
}

function detail_pasien_muat_data($pid) {
	$sql = "select pd.id as id_penduduk, pg.nip, p.id as id_pas,dp.status_pernikahan as perkawinan,pdd.nama as pendidikan,pkj.nama as pekerjaan,prf.nama as profesi,pd.*, dp.id , dp.*, pd.posisi_di_keluarga as nama_posisi
	from penduduk pd 
	left join pegawai pg on (pg.id = pd.id)
	join pasien p on (pd.id = p.id_penduduk) 
	left join dinamis_penduduk dp on (dp.id_penduduk = pd.id) 
    left join pendidikan pdd on dp.id_pendidikan_terakhir = pdd.id
    left join pekerjaan pkj on dp.id_pekerjaan = pkj.id
    left join profesi prf on dp.id_profesi = prf.id
	where p.id = '$pid' and dp.akhir = 1 
	group by p.id 
	order by pd.id desc";
	
	return _select_unique_result($sql);
}

function detail_alamat_pasien_muat_data($idAlamat) {
	$sql = "select ku.id as id_kel, ku.nama as nama_kel, kc.nama as nama_kec, k.nama as nama_kab, p.nama as nama_pro from provinsi p, kabupaten k, kecamatan kc, kelurahan ku where p.id = k.id_provinsi and k.id = kc.id_kabupaten and kc.id = ku.id_kecamatan and ku.id = '$idAlamat'";
	return _select_unique_result($sql);
	
}
function billing_muat_data($id){
    $sql="select b.id,b.id_pasien as norm,
        pd.nama as pasien,dp.alamat_jalan,kel.nama as kelurahan,
        kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi ,
        (select count(*) from detail_pembayaran_billing where id_billing = b.id) as pembayaran,
        (select sum(jumlah_bayar) from detail_pembayaran_billing where id_pembayaran_billing = b.id) as jumlah_bayara
        from billing b
        left join pasien ps on b.id_pasien = ps.id
        left join penduduk pd on ps.id_penduduk = pd.id
        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
        left join kelurahan kel on dp.id_kelurahan = kel.id
        left join kecamatan kec on kel.id_kecamatan = kec.id
        left join kabupaten kab on kec.id_kabupaten = kab.id
        left join provinsi pro on kab.id_provinsi = pro.id
        where b.id=$id";
    return _select_unique_result($sql);
}

function cari_pembayaran_muat_data($norm=null,$id_penjualan=null){
    
    $hasil=array();
    
    if($norm!=null){  
    $sql_a="SELECT
                bil.id as id_billing,bil.total_tagihan as total_tagihan_billing,l.nama as layanan,tr.total as harga,db.frekuensi as frekuensi,k.nama as kelas
            FROM pasien ps
            LEFT JOIN penduduk pd ON pd.id=ps.id_penduduk
            LEFT JOIN billing bil ON bil.id_pasien=ps.id AND bil.status_pembayaran='0'
			LEFT JOIN detail_billing db on db.id_billing=bil.id        
			LEFT JOIN tarif tr on tr.id=db.id_tarif 
			LEFT JOIN kelas k on tr.id_kelas=k.id
			LEFT JOIN layanan l on l.id=tr.id_layanan     
            WHERE ps.id=$norm

    ";

    $hasil['tabel']['billing']=_select_arr($sql_a);
       
	   
	
    $sql_b="SELECT
                pj.id as id_penjualan,pj.total_tagihan as total_tagihan_penjualan
            FROM pasien ps
            LEFT JOIN penduduk pd ON pd.id=ps.id_penduduk
            LEFT JOIN penjualan pj ON pj.id_penduduk_pembeli=ps.id_penduduk AND pj.status_pembayaran='0'
            WHERE ps.id=$norm
    ";

    $hasil['tabel']['penjualan']=_select_arr($sql_b);
    
    
        $sql="
            select pmb.id,pmb.jumlah_tagihan,pmb.jumlah_kembalian,pmb.jumlah_bayar,pmb.jumlah_sisa_tagihan
            from pembayaran pmb
            left join penduduk pdd on pdd.id=pmb.id_penduduk_customer
            left join pasien ps on ps.id_penduduk=pdd.id
            where ps.id=$norm order by pmb.id desc limit 1 
        ";

        $hasil['pembayaran']=_select_arr($sql);
    }else{
        $sql="SELECT
                pj.id as id_penjualan,pj.total_tagihan as total_tagihan_penjualan
                FROM  penjualan pj
            WHERE  pj.id=$id_penjualan";
        $hasil['tabel']['penjualan']=_select_arr($sql);
    }
    return $hasil;
}
function cari_pembayaran_muat_data2($norm=null,$id_penjualan=null){
    
    $hasil=array();
    
    if($norm!=null){  
    $sql_a="SELECT
                bil.id as id_billing,bil.total_tagihan as total_tagihan_billing,l.nama as layanan,tr.total as harga,sum(db.frekuensi) as frekuensi,k.nama as kelas
            FROM pasien ps
            LEFT JOIN penduduk pd ON pd.id=ps.id_penduduk
            LEFT JOIN billing bil ON bil.id_pasien=ps.id AND bil.status_pembayaran='0'
			LEFT JOIN detail_billing db on db.id_billing=bil.id        
			LEFT JOIN tarif tr on tr.id=db.id_tarif 
			LEFT JOIN kelas k on tr.id_kelas=k.id
			LEFT JOIN layanan l on l.id=tr.id_layanan     
            WHERE ps.id=$norm group by db.id_tarif order by db.id ASC

    ";
    $hasil['tabel']['billing']=_select_arr($sql_a);
       
	   
	
    $sql_b="SELECT
                pj.id as id_penjualan,pj.total_tagihan as total_tagihan_penjualan
            FROM pasien ps
            LEFT JOIN penduduk pd ON pd.id=ps.id_penduduk
            LEFT JOIN penjualan pj ON pj.id_penduduk_pembeli=ps.id_penduduk AND pj.status_pembayaran='0'
            WHERE ps.id=$norm
    ";

    $hasil['tabel']['penjualan']=_select_arr($sql_b);
    
    
        $sql="
            select pmb.id,pmb.jumlah_tagihan,pmb.jumlah_kembalian,pmb.jumlah_bayar,pmb.jumlah_sisa_tagihan
            from pembayaran pmb
            left join penduduk pdd on pdd.id=pmb.id_penduduk_customer
            left join pasien ps on ps.id_penduduk=pdd.id
            where ps.id=$norm order by pmb.id desc limit 1 
        ";

        $hasil['pembayaran']=_select_arr($sql);
    }else{
        $sql="SELECT
                pj.id as id_penjualan,pj.total_tagihan as total_tagihan_penjualan
                FROM  penjualan pj
            WHERE  pj.id=$id_penjualan";
        $hasil['tabel']['penjualan']=_select_arr($sql);
    }
    return $hasil;
}
function cari_total_tagihan($norm=null){
    $hasil=array();
    if($norm!=null){  
	$sql="SELECT sum(bil.total_tagihan) as jumlah
            FROM billing bil where bil.status_pembayaran='0'   
            and bil.id_pasien=$norm

    ";

    $hasil=_select_arr($sql);
	}
    return $hasil;
}
function cari_total_tagihan2($norm=null){
    $hasil=array();
    if($norm!=null){  
	$sql="SELECT sum(bil.total_tagihan) as jumlah
            FROM billing bil where bil.status_pembayaran='0'   
            and bil.id_pasien='$norm'

    ";

    $hasil= _select_unique_result($sql);
	}
    return $hasil;
}
function asuransi_penjualan_muat_data($idpenduduk){
$sql="select akk.id as id_asuransi, ap.nama as nama_asuransi from kunjungan k
                    join pasien ps on ps.id=k.id_pasien
                    left join asuransi_kepesertaan_kunjungan akk on akk.id_kunjungan=k.id
                    left join asuransi_produk ap on ap.id=akk.id_asuransi_produk
                    where k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and ps.id_penduduk='$idpenduduk'";
                $hasil=_select_arr($sql);
				  return $hasil;
}
function asuransi_penjualan_muat_data2($idpenduduk){
$sql="select akk.id as id_asuransi, ap.nama as nama_asuransi from kunjungan k
                    join pasien ps on ps.id=k.id_pasien
                    left join asuransi_kepesertaan_kunjungan akk on akk.id_kunjungan=k.id
                    left join asuransi_produk ap on ap.id=akk.id_asuransi_produk
                    where k.id in (select max(id) from kunjungan where id_pasien in (select id_pasien from kunjungan group by id_pasien) group by id_pasien) and ps.id_penduduk='$idpenduduk'";
                $hasil['list']=_select_arr($sql);
				$hasil['total']=countrow($sql);
				  return $hasil;
}
function detail_pembayaran_billing($id, $kat){
$sql="SELECT l.nama as layanan,tr.total as harga,db.frekuensi as frekuensi,kg.nama as kategori,kls.nama as kelas FROM billing bil 
			LEFT JOIN detail_billing db on db.id_billing=bil.id        
			LEFT JOIN tarif tr on tr.id=db.id_tarif 
			LEFT JOIN layanan l on l.id=tr.id_layanan 
			LEFT JOIN kategori_tarif kg on kg.id=l.id_kategori_tarif 
			LEFT JOIN kelas kls on kls.id=tr.id_kelas        
            WHERE bil.id=$id and kg.id='$kat'";
			 $result['total'] = countrow($sql);
			  $result['list'] = _select_arr($sql);
			 return $result;
}
function detail_pembayaran_billing2($id, $kat){
$sql="SELECT l.nama as layanan,tr.total as harga,sum(db.frekuensi) as frekuensi,kg.nama as kategori,kls.nama as kelas FROM billing bil 
			LEFT JOIN detail_billing db on db.id_billing=bil.id        
			LEFT JOIN tarif tr on tr.id=db.id_tarif 
			LEFT JOIN layanan l on l.id=tr.id_layanan 
			LEFT JOIN kategori_tarif kg on kg.id=l.id_kategori_tarif 
			LEFT JOIN kelas kls on kls.id=tr.id_kelas        
            WHERE bil.id=$id and kg.id='$kat' group by db.id_tarif";
			 $result['total'] = countrow($sql);
			  $result['list'] = _select_arr($sql);
			 return $result;
}
function kategori_tarif(){
 $sql = "select id,nama from kategori_tarif";
return _select_arr($sql);
}
function pembayaran_billing_muat_data($id_pembayaran){
	 if($id_pembayaran!=null){  
    $sql="SELECT
            dpb.id_penjualan_billing,dpb.jenis,dpb.jumlah_tagihan,pmb.jumlah_tagihan as jumlah_tagihan_total,
            pmb.jumlah_kembalian,pmb.jumlah_bayar,pmb.jumlah_sisa_tagihan 
            FROM pembayaran pmb
            LEFT JOIN detail_pembayaran dpb ON (dpb.id_pembayaran_billing=pmb.id and dpb.jenis='jasa')
			LEFT JOIN billing bil on (bil.id=dpb.id_penjualan_billing)  
            WHERE pmb.id=$id_pembayaran group by  dpb.id_penjualan_billing
        ";
	 }
    return _select_arr($sql);
}

function pembayaran_billing_penjualan_muat_data($id_pembayaran){
    $sql="SELECT
            dpb.id_penjualan_billing,dpb.jenis,dpb.jumlah_tagihan,pmb.jumlah_tagihan as jumlah_tagihan_total,
            pmb.jumlah_kembalian,pmb.jumlah_bayar,pmb.jumlah_sisa_tagihan
            FROM pembayaran pmb
            LEFT JOIN detail_pembayaran dpb ON (dpb.id_pembayaran_billing=pmb.id and dpb.jenis='penjualan')
            WHERE pmb.id=$id_pembayaran group by  dpb.id_penjualan_billing
        ";
    return _select_arr($sql);
}
function pembayaran_detail_billing_penjualan_muat_data($id_pembayaran){
    $sql="SELECT
            dpb.id_penjualan_billing,dpb.jenis,dpb.jumlah_tagihan,pmb.jumlah_tagihan as jumlah_tagihan_total,
            pmb.jumlah_kembalian,pmb.jumlah_bayar,pmb.jumlah_sisa_tagihan
            FROM pembayaran pmb
            LEFT JOIN detail_pembayaran dpb ON (dpb.id_pembayaran_billing=pmb.id)
            WHERE pmb.id=$id_pembayaran
        ";
    return _select_arr($sql);
}
function detail_billing_muat_data($id = NULL){
    if($id != NULL){
            $where = " where detail.id_billing='$id'";
    }else $where = "";
    
    $sql = "
       select detail.frekuensi,t.total,l.nama as layanan,k.nama as kelas,instalasi.nama as instalasi,nakes1.nama as nakes1,
        nakes2.nama as nakes2,nakes3.nama as nakes3,
        sp.nama as spesialisasi,l.bobot,pr.nama as profesi,l.jenis,instalasi.id as id_instalasi,k.id as id_kelas
        from detail_billing detail
        left join tarif t on detail.id_tarif = t.id
        left join layanan l on t.id_layanan = l.id
        left join instalasi on instalasi.id=l.id_instalasi
        left join penduduk nakes1 on nakes1.id=detail.id_penduduk_nakes1
        left join penduduk nakes2 on nakes2.id=detail.id_penduduk_nakes2
        left join penduduk nakes3 on nakes3.id=detail.id_penduduk_nakes3
        left join spesialisasi sp on sp.id=l.id_spesialisasi
        left join profesi pr on pr.id=sp.id_profesi
        left join kelas k on t.id_kelas = k.id
        $where order by detail.id asc";
    return _select_arr($sql);
}
function detail_billing_muat_data2($id = NULL){
    if($id != NULL){
            $where = " where detail.id_billing='$id'";
    }else $where = "";
    
    $sql = "
       select sum(detail.frekuensi) as frekuensi,t.total,l.nama as layanan,k.nama as kelas,instalasi.nama as instalasi,nakes1.nama as nakes1,
        nakes2.nama as nakes2,nakes3.nama as nakes3,
        sp.nama as spesialisasi,l.bobot,pr.nama as profesi,l.jenis,instalasi.id as id_instalasi,k.id as id_kelas
        from detail_billing detail
        left join tarif t on detail.id_tarif = t.id
        left join layanan l on t.id_layanan = l.id
        left join instalasi on instalasi.id=l.id_instalasi
        left join penduduk nakes1 on nakes1.id=detail.id_penduduk_nakes1
        left join penduduk nakes2 on nakes2.id=detail.id_penduduk_nakes2
        left join penduduk nakes3 on nakes3.id=detail.id_penduduk_nakes3
        left join spesialisasi sp on sp.id=l.id_spesialisasi
        left join profesi pr on pr.id=sp.id_profesi
        left join kelas k on t.id_kelas = k.id
        $where group by detail.id_tarif order by detail.id asc";
    return _select_arr($sql);
}

function pembayaran_muat_data($id, $kelas, $startDate, $endDate) {
	
	$sql = "select date(p.waktu) as waktu, b.id, sum(pb.jumlah_tagihan) as subtotal, sum(pb.jumlah_bayar) as jumlah_bayar,instalasi.nama as instalasi,kls.nama as kelas
	from pembayaran p
	left join detail_pembayaran_billing pb on (p.id = pb.id_pembayaran_billing)
	left join billing b on (b.id = pb.id_billing)
	left join detail_billing db on (b.id = db.id_billing)
	left join tarif t on (t.id = db.id_tarif)
	left join layanan l on (t.id_layanan = l.id)
	left join pasien ps on (b.id_pasien = ps.id)
	left join kunjungan k on (k.id_pasien = ps.id)
	left join bed bd on (k.id_bed = bd.id)
	left join kelas kls on (bd.id_kelas = k.id)
        left join instalasi on instalasi.id=l.id_instalasi
	where date(p.waktu) between '$startDate' and '$endDate'
	and k.id_layanan = '$id' and bd.id_kelas = '$kelas'
	group by b.id";
	
	return _select_arr($sql);
}
/**
 *
 * @param type $idKunjungan
 * @return type 
 */
function kepesertaan_asuransi($idKunjungan){
    return _select_arr("select ak.id as id_asuransi_kepesertaan,ak.no_polis,a.nama as nama_asuransi,
            a.id as id_asuransi_produk 
            from asuransi_kepesertaan_kunjungan ak
            JOIN asuransi_produk a on a.id=ak.id_asuransi_produk
            where id_kunjungan=$idKunjungan");

}
function formularium_muat_data($id=null,$tanggal = NULL,$sort = NULL,$page = NULL,$dataPerPage = NULL){
      $datas = array();
      
      if($sort != NULL){
          if($sort == 1){
              $order = "order by b.nama asc";
          }
      }else $order = "";
      
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
      
      if($tanggal != NULL){
        $sql = mysql_query("select max(id) from formularium where tanggal = '".date2mysql($tanggal)."'");
        $data = mysql_fetch_array($sql);
        $data['id']=$data[0]['id'];
        $where = "where f.tanggal = '".date2mysql($tanggal)."'";
      }else if($id != NULL){
        $data['id']=$id;
        $where = "where f.id= '$id'";
      }else{
        $sql = mysql_query("select max(id) as id from formularium")or die (mysql_error());  
        $data = mysql_fetch_array($sql);
        $where = "where f.id = '$data[id]'";
      }
      $query = "
        select o.generik,f.id,df.id as id_detail,s.nama as sediaan,b.nama as barang,o.kekuatan,
            ins.nama as pabrik,ssf.nama as sub_sub_farmakologi,sf.nama as sub_farmakologi,fa.nama as farmakologi
        FROM formularium f
        left join detail_formularium df on df.id_formularium = f.id
        left join obat o on df.id_obat = o.id
        left join sediaan s on o.id_sediaan = s.id 
        left join barang b on o.id = b.id
        left join instansi_relasi ins on b.id_instansi_relasi_pabrik=ins.id
        left join sub_sub_farmakologi ssf on o.id_sub_sub_farmakologi = ssf.id
        left join sub_farmakologi sf on ssf.id_sub_farmakologi = sf.id
        left join farmakologi fa on sf.id_farmakologi = fa.id   
        $where $order $batas";
      $exe = _select_arr($query);
      $datas['id'] = $data['id'];
      $datas['list'] = $exe;
      if(empty($dataPerPage)){
          return $datas;
      }
      $sqli = "
        select f.id,s.nama as sediaan,b.nama as barang,o.kekuatan,ssf.nama as sub_sub_farmakologi,sf.nama as sub_farmakologi,fa.nama as farmakologi from formularium f
        left join detail_formularium df on df.id_formularium = f.id
        left join obat o on df.id_obat = o.id
        left join sediaan s on o.id_sediaan = s.id 
        left join barang b on o.id = b.id
        left join sub_sub_farmakologi ssf on o.id_sub_sub_farmakologi = ssf.id
        left join sub_farmakologi sf on ssf.id_sub_farmakologi = sf.id
        left join farmakologi fa on sf.id_farmakologi = fa.id   
        $where
      ";
      
      $datas['paging'] = paging($sqli, $dataPerPage);
      $datas['offset'] = $offset;
      return $datas;
}


function info_riwayat_kunjungan_pasien($id = null, $startDate = null, $endDate = null) {
	$sql = "select k.waktu , k.no_kunjungan_pasien,k.status, i.nama as instalasi, kl.nama as kelas, b.nama as no_bed
	from kunjungan k
	join bed b on (k.id_bed = b.id)
	join instalasi i on (b.id_instalasi = i.id)
	join kelas kl on (b.id_kelas = kl.id)
	where k.id_pasien = '$id' and date(k.waktu) between '$startDate' and '$endDate'";
	
	return _select_arr($sql);
}
function infobed_rawat_inap_muat_data($page = NULL, $dataPerPage = NULL, $instalasi = NULL,$kelas = NULL){
    $return = array();
    $where = "";
    if($instalasi != NULL){
        $where .= " and ins.id = '$instalasi'";
    }
   if ($kelas != NULL) {
        if ($kelas == "all") {
            $where .= "";
        } else {
            $where .= " and kls.id= '$kelas'";
        }
    }
	if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
    if (isset($dataPerPage) && $dataPerPage != null) {
        $offset = ($noPage - 1) * $dataPerPage;
        $batas = "limit $offset, $dataPerPage";
    } else {
        $batas = '';
        $offset = '';
    }
    $sql = "
        select b.nama as nama, kls.nama as class, ins.nama as instalasi ,b.status as status from bed b
        left join kelas kls on (b.id_kelas = kls.id)
        left join instalasi ins on (b.id_instalasi = ins.id)
         where ins.id > 4 $where $batas
    ";
	$sqli = "
        select b.nama as nama, kls.nama as class, ins.nama as instalasi ,b.status as status from bed b
        left join kelas kls on (b.id_kelas = kls.id)
        left join instalasi ins on (b.id_instalasi = ins.id)
         where ins.id > 4 $where
    ";
    $return['paging'] = paging($sqli, $dataPerPage);
    $return['list'] = _select_arr($sql);
    return $return;
}
function riwayat_pemakaian_narkotik_muat_data($pasien = NULL,$perundangan = NULL, $packing= NULL){
		if(User::$pemesanan_barang_role == '4'){
		$katbarang=" where kb.id !='0'";
	}
	else{
	$katbarang=" where kb.id='" . User::$pemesanan_barang_role . "'";
	}
    $return = array();
    $where = "";
    if($pasien != NULL){
        $where .= " and p.id_penduduk_pembeli = '$pasien'";
    }
	 if($packing != NULL){
        $where .= " and pb.id = '$packing'";
    }
   if ($perundangan != NULL) {
        if ($perundangan == "all") {
            $where .= "";
        } else {
            $where .= " and pr.id= '$perundangan'";
        }
    }

    $sql = "
        select p.waktu as waktu,p.id as nota, b.nama as obats,dprp.jumlah_penjualan as jumlah,pb.nilai_konversi,
                o.kekuatan,o.generik,st1.nama as satuan_terkecil,st2.nama as satuan_terbesar, sd.nama as sediaan,ins.nama as pabrik from detail_penjualan_retur_penjualan dprp
        left join penjualan p on dprp.id_penjualan = p.id
		left join penduduk pdd on p.id_penduduk_pembeli = pdd.id
        left join packing_barang pb on dprp.id_packing_barang = pb.id
		left join barang b on b.id=pb.id_barang
	    left join obat o on b.id=o.id
	    left join satuan st1 on pb.id_satuan_terkecil=st1.id
        left join satuan st2 on pb.id_satuan_terbesar=st2.id
        left join sediaan sd on o.id_sediaan=sd.id
        left JOIN sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
                left JOIN kategori_barang kb on kb.id=skb.id_kategori_barang
                left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
				left join perundangan pr on o.id_gol_perundangan = pr.id
            $katbarang and skb.id=1 $where
    ";
    
    $return = _select_arr($sql);
    return $return;
}
function rawat_inap_muat_data($startDate = NULL, $endDate = NULL, $instalasi = NULL, $kelas = NULL, $sort = NULL, $sortBy = NULL)
{
	$result = array();
	
	$where  = "";
	if ($startDate != NULL && $endDate != NULL)
	{
		$where .= "AND DATE(k.waktu) >= '".date2mysql($startDate)."' AND DATE(k.waktu) <= '".date2mysql($endDate)."'";
	}
	if($instalasi != NULL)
	{
		$where .= " AND ins.id = '$instalasi'";
	}
	if ($kelas != NULL)
	{
		if ($kelas == "all")
			$where .= "";
		else
			$where .= " AND kls.id= '$kelas' ";
	}
	
	if ($sort != NULL && $sort == 1)
		$order = "k.waktu $sortBy";
	else if ($sort != NULL && $sort == 2)
		$order = "pd.nama $sortBy";
	else if($sort != NULL && $sort == 3)
		$order = "ps.id $sortBy";
	else if($sort != NULL && $sort == 4)
		$order = "kel.id $sortBy";
	else if($sort != NULL && $sort == 5)
		$order = "dokter.id $sortBy";
	else if($sort != NULL && $sort == 6)
		$order = "b.id $sortBy";
			
	else $order = "k.waktu ASC";
	
	$sql = "SELECT DISTINCT (k.id_pasien) AS dist,
			(SELECT MAX(id) FROM kunjungan WHERE id_pasien = dist) AS id, k.id AS idKunjungan, k.waktu AS tanggal, pd.nama AS pasien, ps.id AS norm, kel.nama AS kelurahan,
			kec.nama AS kecamatan, kab.nama AS kabupaten, dokter.nama AS nama_dokter, b.nama AS bed, kls.nama AS kelas,dp.alamat_jalan, ins.nama AS instalasi
			FROM kunjungan k
			LEFT JOIN pasien ps ON ps.id = k.id_pasien
			LEFT JOIN penduduk pd ON pd.id = ps.id_penduduk
			LEFT JOIN dinamis_penduduk dp ON dp.id_penduduk = pd.id
			LEFT JOIN penduduk dokter ON dokter.id = k.id_penduduk_dpjp
			LEFT JOIN kelurahan kel ON dp.id_kelurahan = kel.id
			LEFT JOIN kecamatan kec ON kec.id = kel.id_kecamatan
			LEFT JOIN kabupaten kab ON kab.id = kec.id_kabupaten
			LEFT JOIN bed b ON k.id_bed = b.id
			LEFT JOIN kelas kls ON b.id_kelas = kls.id
			LEFT JOIN instalasi ins ON b.id_instalasi = ins.id
			WHERE dp.akhir = '1' AND k.status != 'Keluar' and b.jenis = 'Rawat Inap' and k.id=(SELECT MAX(id) FROM kunjungan WHERE id_pasien = k.id_pasien) $where
			GROUP BY dist
			ORDER BY $order";
	$result = _select_arr($sql);
	return $result;
			

	// SQL yang lama -----------------------------------------------------------------------------------------------
	/*$sql = _select_arr("SELECT distinct(k.id_pasien) as dist,(select max(id) from kunjungan 
            where id_pasien=dist) as id FROM kunjungan k
            LEFT JOIN pasien on pasien.id=k.id_pasien
            LEFT JOIN penduduk on penduduk.id=pasien.id_penduduk 
            join bed b on k.id_bed = b.id
            join kelas kls on b.id_kelas = kls.id
            join instalasi ins on b.id_instalasi = ins.id
            $where");
    foreach ($sql as $row){
        $sql2 = "
            select k.id as idKunjungan,k.waktu as tanggal,pd.id as penduduk, k.id_pasien as norm,pd.nama as pasien,dp.alamat_jalan,dokter.nama as nama_dokter,
            kel.nama as kelurahan,kec.nama as kecamatan, kab.nama as kabupaten,kls.nama as kelas,ins.nama as instalasi,b.nama as bed from kunjungan k
            left join pasien ps on k.id_pasien = ps.id
            left join penduduk pd on ps.id_penduduk = pd.id
            left join dinamis_penduduk dp on dp.id_penduduk = pd.id
            LEFT JOIN penduduk dokter on dokter.id=k.id_penduduk_dpjp
            left join kelurahan kel on dp.id_kelurahan = kel.id
            left join kecamatan kec on kec.id = kel.id_kecamatan
            left join kabupaten kab on kab.id = kec.id_kabupaten
            left join bed b on k.id_bed = b.id
            left join kelas kls on b.id_kelas = kls.id
            left join instalasi ins on b.id_instalasi = ins.id
            left join layanan l on k.id_layanan = l.id where dp.akhir = '1' and k.id = '$row[id]' and k.status = 'Mutasi'
        ";
        
        $return[] = _select_unique_result($sql2);
		// End of old SQL -----------------------------------------------------------------------------------------
		*/
}
//    $sql = "
//        select k.id as idKunjungan,k.waktu as tanggal,k.id_pasien as norm,pd.nama as pasien,dp.alamat_jalan,dokter.nama as nama_dokter,kel.nama as kelurahan,kls.nama as kelas,ins.nama as instalasi from kunjungan k
//        left join pasien ps on k.id_pasien = ps.id
//        left join penduduk pd on ps.id_penduduk = pd.id
//        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
//	LEFT JOIN penduduk dokter on dokter.id=k.id_penduduk_dpjp
//        left join kelurahan kel on dp.id_kelurahan = kel.id
//        left join bed b on k.id_bed = b.id
//        left join kelas kls on b.id_kelas = kls.id
//        left join instalasi ins on b.id_instalasi = ins.id
//        left join layanan l on k.id_layanan = l.id
//        where l.jenis = 'Rawat Inap' and b.jenis = 'Rawat Inap' and dp.akhir = 1 $where
//    ";
//    
//    $return = _select_arr($sql);
//    return $return;
//}
function info_keuangan_ambulance($startDate = NULL,$endDate = NULL){
      $startDate = date2mysql($startDate);
      $endDate = date2mysql($endDate);
      $query = "select b.id_pasien,date(db.waktu) as tanggal,l.nama as layanan,pd.nama,db.frekuensi,t.total,nakes1.nama as nakes1,nakes2.nama as nakes2,nakes3.nama as nakes3 from detail_billing db 
        join billing b on db.id_billing = b.id
        join pasien p on b.id_pasien=p.id
        join penduduk pd on p.id_penduduk=pd.id
        join dinamis_penduduk dp on dp.id_penduduk=p.id
        join tarif t on db.id_tarif=t.id
        join layanan l on t.id_layanan = l.id
        left join penduduk nakes1 on db.id_penduduk_nakes1=nakes1.id
        left join penduduk nakes2 on db.id_penduduk_nakes2=nakes2.id
        left join penduduk nakes3 on db.id_penduduk_nakes3=nakes3.id
        where dp.akhir='1' and l.id_kategori_tarif = '17' and date(db.waktu) between '$startDate' and '$endDate'";
      $ambulance = _select_arr($query);
      
      return $ambulance;
}
function confirm_rawat_inap($norm = NULL){
    $sql = "select b.id as id_billing,pd.nama as dokter,ins.nama as instalasi,kls.nama as kelas,pd2.nama as pasien,l.nama as layanan,ps.id as norm from billing b
            join detail_billing det on det.id_billing = b.id
            join pasien ps on b.id_pasien = ps.id
            join penduduk pd2 on ps.id_penduduk = pd2.id
            left join penduduk pd on det.id_penduduk_nakes1 = pd.id
            join tarif t on det.id_tarif = t.id
            join layanan l on t.id_layanan = l.id
            join instalasi ins on l.id_instalasi = ins.id
            join kelas kls on t.id_kelas = kls.id
            where b.id_pasien = '$norm' and det.id = (select max(id) from detail_billing where id_billing = b.id)";
    
    $return = _select_arr($sql);
    return $return;
}
function detail_asuransi($norm = NULL){
    $cek = "select max(id) as idKun  from kunjungan where id_pasien = '$norm' and status='masuk'";
        $data = _select_unique_result($cek);
		$sql = "select akk.id as id_asuransi, ap.nama as nama_asuransi
                    from
                    asuransi_kepesertaan_kunjungan akk
                    left join asuransi_produk ap on ap.id=akk.id_asuransi_produk
                    where akk.id_kunjungan=".$data['idKun'];
    $return = _select_arr($sql);
    return $return;
}
function detail_rawat_inap($id = NULL){
    if($id != NULL){
        $where = "and k.id = $id";
    }else $where = "";
    $sql = "
        select k.waktu as tanggal,k.id_pasien as norm,b.nama as bed,b.id as idBed,k.*,pd.nama as pasien,dp.alamat_jalan,dokter.nama as nama_dokter,dokter.id as idDokter,kel.nama as kelurahan,kls.nama as kelas,l.id as idLayanan,k.rencana_cara_bayar as paying,ins.nama as instalasi,ap.nama as asuransi from kunjungan k
        left join pasien ps on k.id_pasien = ps.id
        left join penduduk pd on ps.id_penduduk = pd.id
        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
	LEFT JOIN penduduk dokter on dokter.id=k.id_penduduk_dpjp
        left join kelurahan kel on dp.id_kelurahan = kel.id
        left join bed b on k.id_bed = b.id
        left join kelas kls on b.id_kelas = kls.id
        left join instalasi ins on b.id_instalasi = ins.id
        left join layanan l on k.id_layanan = l.id
		 left join asuransi_kepesertaan_kunjungan akk on akk.id_kunjungan=k.id 
		  left join asuransi_produk ap on ap.id=akk.id_asuransi_produk
        where l.jenis = 'Rawat Inap' and dp.akhir = '1' $where
    ";
    
    $return = _select_arr($sql);
    return $return;
}
function return_rawat_inap($norm = NULL){
    if($norm != NULL){
        $where = "and b.id_pasien = '$norm'";
    }else $where = "";
    
    $sql = "select date(db.waktu) as tanggal,ins.nama as instalasi,db.waktu,kel.nama as kelurahan,dp.alamat_jalan,p.id as norm,dokter.nama as nama_dokter,pd.nama as pasien,(select b.nama from kunjungan k join bed b on k.id_bed = b.id where k.id_pasien = b.id_pasien order by k.id desc limit 0,1) as bed,(select kel.nama from kunjungan k join bed b on k.id_bed = b.id join kelas kel on b.id_kelas = kel.id where k.id_pasien = b.id_pasien order by k.id desc limit 0,1) as kelas,b.id_pasien from detail_billing db join billing b on db.id_billing = b.id
    join pasien p on b.id_pasien = p.id
    join penduduk pd on p.id_penduduk = pd.id
    join penduduk dokter on db.id_penduduk_nakes1 = dokter.id
    join dinamis_penduduk dp on dp.id_penduduk = pd.id
    join tarif t on db.id_tarif = t.id
    join layanan l on t.id_layanan = l.id
    join instalasi ins on l.id_instalasi = ins.id
    join kelurahan kel on dp.id_kelurahan = kel.id
    where l.jenis = 'Rawat Inap' and b.status_pembayaran = '0' $where order by db.id desc limit 0,1";
    
    $return = _select_arr($sql);
    return $return;
}
function layanan_rawat_inap_muat_data(){
    $sql = "select * from layanan ";
    $return = _select_arr($sql);
    return $return;
}
function bed_rawat_inap(){
    $sql = "select b.*,kls.nama as kelas,ins.nama as instalasi from bed b
            left join kelas kls on b.id_kelas = kls.id
            left join instalasi ins on b.id_instalasi = ins.id
            where ins.id not in (1,2,3,4)";
    $return = _select_arr($sql);
    return $return;
}
function ketersediaan_bed_muat_data($idinstalasi=null,$instalasi=null){
    if ($idinstalasi != NULL) {
        $where = "where b.id_instalasi='$idinstalasi'";
    }else if($instalasi){
        $where = "where i.nama like '%$instalasi%'";
    }else
        $where = "";
    $sql = "select b.*,i.nama as instalasi,k.nama as kelas,
        (select count(*) from kunjungan k where k.id_bed=b.id and k.id not in (select billing.id_kunjungan from billing)) as status_kunjungan
        from bed b
        LEFT JOIN kelas k on k.id=b.id_kelas
        left join instalasi i on (b.id_instalasi=i.id) $where";
    return _select_arr($sql);
}
function spesialisasi_muat_data($id=NULL,$page=NULL,$dataPerPage=NULL, $sort = NULL, $sortBy=null,$key=null){
    $result = array();
    if($id != NULL){
        $where = "where s.id='$id'";
    }else $where = "";
    
    if ($sort != NULL && $sort == 1) {
        $order = "order by s.id $sortBy";
    } else if ($sort != NULL && $sort == 2) {
        $order = "order by s.nama $sortBy";
    }else $order = "order by s.nama asc";
    
    if($key != NULL){
       $cari = "where s.nama like ('%$key%') ";
      } else
      $cari='';
          
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
      $sql = "select s.*,p.id as id_profesi,p.nama as profesi from spesialisasi s left join profesi p on s.id_profesi=p.id $where $cari $order $batas ";
      if ($id != null) {
		$result =_select_unique_result($sql); 
		$result['list'] = _select_arr($sql);
		
	} else {
		$result['list'] = _select_arr($sql);
      }
      $sqli = "select s.*,p.id as id_profesi,p.nama as profesi from spesialisasi s left join profesi p on s.id_profesi=p.id $where $cari";
      $result['paging'] = paging($sqli, $dataPerPage);
      $result['offset'] = $offset;

      return $result;
}

function jasa_medis_muat_data($startDate, $endDate, $nakes = null, $layanan = null) {

	$start = date2mysql($startDate);
	$end   = date2mysql($endDate);
	
	$require = null;
	if ($nakes != null) {
		$require.=" and db.id_penduduk_nakes1 = '$nakes'";
	}
	if ($layanan != null) {
		$require.=" and t.id_layanan = '$layanan'";
	}
	
	$sql = "select date(b.waktu) as waktu, p.nama as nakes, l.nama as layanan,l.bobot,l.jenis,ins.nama as instalasi,sp.nama as spesialisasi,pr.nama as profesi,k.nama as kelas,t.total, sum(t.total) as total
	from billing b 
	join detail_billing db on (db.id_billing = b.id)
	join tarif t on (db.id_tarif = t.id)
	join layanan l on (t.id_layanan = l.id)
        left join instalasi ins on l.id_instalasi=ins.id
        left join kelas k on t.id_kelas = k.id
        left join spesialisasi sp on l.id_spesialisasi=sp.id
        left join profesi pr on sp.id_profesi = pr.id
	join penduduk p on (db.id_penduduk_nakes1 = p.id)
	where date(b.waktu) between '$start' and '$end' $require
	group by db.id_penduduk_nakes1";
	
	return _select_arr($sql);
}
function rekap_barang_muat_data($kategori = NULL,$subKategori = NULL){
    if(isset ($kategori) && $subKategori == NULL){
        $sql = "select b.* from barang b left join sub_kategori_barang skb on b.id_sub_kategori_barang=skb.id left join kategori_barang kb on skb.id_kategori_barang=kb.id where kb.id='$kategori'";
        $count = _num_rows($sql);
    }else if(isset ($subKategori) && $kategori == NULL){
        $sql = "select skb.nama,(select count(*) from barang where id_sub_kategori_barang=skb.id) as jumlah from sub_kategori_barang skb where skb.id='$subKategori'";
        $count = _select_unique_result($sql);
    }
    
    return $count;
}
function rekap_instansi_relasi_muat_data($jenis){
    if(isset ($jenis)){
        $sql = "select j.nama,(select count(*) from instansi_relasi where id_jenis_instansi_relasi=j.id) as jumlah from jenis_instansi_relasi j where j.id = '$jenis'";
        $data = _select_unique_result($sql);
    }
    return $data;
}
function profile_rumah_sakit_muat_data(){
    $rs=_select_unique_result("select * from rumah_sakit");
    if(empty($rs['nama'])){
        _insert("insert into rumah_sakit (nama) values ('Nama Rumah Sakit')");
        $rs=profile_rumah_sakit_muat_data();
    }
    return $rs;
}
function stok_barang_pelayanan_muat_data($idPacking=null,$idPabrik=null,$idSubKategori=null,$getUnit=NULL){
    $where="";
    if($getUnit!=NULL){
        $where.="and s.id_unit='$getUnit'";
		$unit=" and su.id_unit='$getUnit'";
    }else{
        $where.="and s.id_unit='$_SESSION[id_unit]'";
		$unit=" and su.id_unit='$_SESSION[id_unit]'";
    }
    
    if($idPacking!=null){
        $where.="  and pb.id='$idPacking'";
    }
    if($idPabrik!=null){
        $where.=" and b.id_instansi_relasi_pabrik='$idPabrik' ";
    }
    if($idSubKategori!=null){
        $where.=" and b.id_sub_kategori_barang='$idSubKategori'";
    }
    $sql = "select pb.id as packing_barang,s.batch as batch from stok_unit s
            left join packing_barang pb on s.id_packing_barang = pb.id
            left join unit u on s.id_unit = u.id
            left join barang b on pb.id_barang = b.id
            left join instansi_relasi ir on b.id_instansi_relasi_pabrik = ir.id
                left join sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
           left join kategori_barang kb on kb.id=skb.id_kategori_barang
            where skb.id_kategori_barang !='' $where
            group by pb.id,s.batch order by s.id desc,s.waktu desc";
    $query = _select_arr($sql);

    $result = array();
    $yearNow=date('Y');
	
    foreach ($query as $row){
        /*$result[] = _select_unique_result("select st.nama as satuan,ir.nama as pabrik,o.kekuatan,stok.id_packing_barang,
                o.generik,sediaan.nama as sediaan,pb.nilai_konversi,b.nama as nama_barang, stok.sisa,
                stok.hpp,(stok.hpp*stok.sisa) as nilai,
                (select st.hpp from stok_unit st where st.id_packing_barang=pb.id and st.id_jenis_transaksi='2' order by st.waktu desc limit 0,1) as hpp,stok.batch as batch
                from stok_unit stok
            join packing_barang pb on pb.id=stok.id_packing_barang
            join barang b on b.id=pb.id_barang
            join satuan st on pb.id_satuan_terkecil = st.id
            join sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
            left join obat o on (o.id=b.id)
            left join sediaan on sediaan.id=o.id_sediaan
            left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik 
            where pb.id = '$idPacking' order by stok.id desc,stok.waktu desc limit 0,1");
    }*/
	
	
	$result[] = _select_unique_result("
			SELECT
					su.id_packing_barang, su.sisa, su.hpp, (su.hpp * su.sisa) AS nilai, st.nama AS satuan, pb.nilai_konversi,
					ir.nama AS pabrik, b.nama AS nama_barang, su.batch
				FROM
					stok_unit su
				left JOIN packing_barang pb ON ( pb.id = su.id_packing_barang ) 
				left JOIN barang b ON ( b.id = pb.id_barang ) 
				left JOIN satuan st ON ( pb.id_satuan_terkecil = st.id ) 
				left JOIN instansi_relasi ir ON ( ir.id = b.id_instansi_relasi_pabrik ) 
				WHERE
					su.id_packing_barang =  '$row[packing_barang]' and batch='$row[batch]'
					$unit order by su.waktu desc limit 0,1
				");
	}
	/*$result = _select_arr("select st.nama as satuan,ir.nama as pabrik,o.kekuatan,stok.id_packing_barang,
                o.generik,sediaan.nama as sediaan,pb.nilai_konversi,b.nama as nama_barang, stok.sisa,
                stok.hpp,(stok.hpp*stok.sisa) as nilai,
                (select st.hpp from stok_unit st where st.id_packing_barang=pb.id and st.id_jenis_transaksi='2' order by st.waktu desc limit 0,1) as hpp,stok.batch as batch
                from stok_unit stok
            join packing_barang pb on pb.id=stok.id_packing_barang
            join barang b on b.id=pb.id_barang
            join satuan st on pb.id_satuan_terkecil = st.id
            join sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
            left join obat o on (o.id=b.id)
            left join sediaan on sediaan.id=o.id_sediaan
            left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik 
            where pb.id = '$idPacking' order by stok.id desc,stok.waktu desc limit 0,1");*/
			

    return $result;
}
function stok_barang_gudang_muat_data($idPacking=null,$idPabrik=null,$idSubKategori=null){
    $where="";
    if($idPacking!=null){
        $where.="  and pb.id='$idPacking'";
    }
    if($idPabrik!=null){
        $where.=" and b.id_instansi_relasi_pabrik='$idPabrik' ";
    }
    if($idSubKategori!=null){
        $where.=" and b.id_sub_kategori_barang='$idSubKategori'";
    }
    $group="select stok.batch,stok.id_packing_barang from stok
            join packing_barang pb on pb.id=stok.id_packing_barang
            join barang b on b.id=pb.id_barang
            join sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
            where stok.id_unit='$_SESSION[id_unit]' and  skb.id_kategori_barang!='0' and stok.sisa > 0 $where
            group by pb.id,stok.batch order by stok.id DESC";
    $group=_select_arr($group);
    $result=array();
    $yearNow = date("Y");
    foreach($group as $a){
        $sql="select stok.id,stok.id_packing_barang,ir.nama as pabrik,o.kekuatan,o.generik,sediaan.nama as sediaan,b.nama as nama_barang,
        stok.ed, stok.batch,stok.sisa,st.nama as satuan,st12.nama as kemasan,pb.nilai_konversi,stok.hna,stok.hpp as hpp,
        (stok.hpp*stok.sisa) as nilai
            from stok
            join packing_barang pb on pb.id=stok.id_packing_barang
            join barang b on b.id=pb.id_barang
            join satuan st on pb.id_satuan_terkecil = st.id
            join satuan st12 on pb.id_satuan_terbesar = st12.id
            join sub_kategori_barang skb on skb.id=b.id_sub_kategori_barang
            left join obat o on (o.id=b.id)
            left join sediaan on sediaan.id=o.id_sediaan
            left join instansi_relasi ir on ir.id=b.id_instansi_relasi_pabrik
            where stok.id_packing_barang='$a[id_packing_barang]' and stok.batch='$a[batch]'
            and stok.id_unit='$_SESSION[id_unit]' order by stok.waktu desc limit 0,1";
//        echo $sql;
//        show_array(_select_unique_result($sql));
        $result[]=_select_unique_result($sql);
        
    }
    
    return $result;
}

function pembelian_muat_data2($id) {
    $sql = "select pb.id,DATE(pb.waktu) as waktu,pb.no_faktur,pb.ppn,detail.diskon,detail.harga_pembelian,
    detail.jumlah_pembelian,(detail.jumlah_pembelian*detail.harga_pembelian) as total,pb.tanggal_jatuh_tempo,
    pdd.nama as pegawai,pb.materai,ir.nama as suplier,ir.id as id_suplier,
        detail.id_packing_barang
        from pembelian pb
        JOIN detail_pembelian detail on detail.id_pembelian=pb.id
        JOIN pegawai pgw on pgw.id=pb.id_pegawai
        JOIN penduduk pdd on pdd.id=pgw.id
        LEFT JOIN instansi_relasi ir on ir.id=pb.id_instansi_suplier
        where pb.id='$id'";
    return _select_unique_result($sql);
}

function pasien_discharge_muat_data($id) {
	$row = _select_unique_result("select id, id_pasien, id_bed 
                from kunjungan 
                where id = (select max(id) from kunjungan where id_pasien = '$id') and id = (select max(id) from kunjungan where id_pasien = '$id')");
	/*(select bd.nama from kunjungan k join bed bd on (k.id_bed = bd.id) where k.id = $row[id]) as bed,
	*/
	$sql = "select t.total,k.nama as kelas, l.nama as layanan, i.nama as instalasi, db.frekuensi, db.waktu,
	(select bd.id from kunjungan k join bed bd on (k.id_bed = bd.id) where k.id = $row[id]) as id_bed, 
        sp.nama as spesialisasi,pr.nama as profesi,k.id as id_kelas,l.jenis,l.bobot
       from billing b
	join detail_billing db on (b.id = db.id_billing)
	join tarif t on (t.id = db.id_tarif)
	join layanan l on (l.id = t.id_layanan)
	join instalasi i on (i.id = l.id_instalasi)
	join kelas k on (k.id = t.id_kelas)
        left join spesialisasi sp on sp.id=l.id_spesialisasi
        left join profesi pr on pr.id=sp.id_profesi
	where b.id_pasien = '$id' and b.status_pembayaran = '0' order by db.id asc";
	$result['bed'] = $row['id_bed'];
	$result['list'] =($row['id']!=null)?_select_arr($sql):array();
	return $result;
}
function rawat_inap_undischarge($id){
        $sql = "select date(k.waktu) as tanggal,pd.nama as pasien,time(k.waktu) as jam,pr.nama as profesi,l.nama as layanan,l.bobot,s.nama as spesialisasi,p.nama as dokter,b.nama as bed,i.nama as instalasi,kls.nama as kelas from kunjungan k
        join layanan l on k.id_layanan = l.id
        join pasien ps on k.id_pasien = ps.id
        join penduduk pd on ps.id_penduduk = pd.id
        join bed b on k.id_bed = b.id
        join instalasi i on b.id_instalasi = i.id
        join kelas kls on b.id_kelas = kls.id
        left join penduduk p on k.id_penduduk_dpjp = p.id
        left join spesialisasi s on l.id_spesialisasi = s.id
        left join profesi pr on s.id_profesi = pr.id 
        where k.status !='keluar' and k.id_pasien = '$id' and kls.id != 1  and i.id not in (1,2,3,4) and k.no_kunjungan_pasien = (select max(no_kunjungan_pasien) from kunjungan where id_pasien='$id' and k.status !='keluar')
        and k.id = (select max(id) from kunjungan where id_pasien='$id' and k.status !='keluar')";
        $result = _select_arr($sql);
	return $result;
}
function last_detail_billing($id_billing,$waktu){
    $sql = "select db.id_tarif from detail_billing db join billing b on db.id_billing = b.id where b.id = '$id_billing' order by db.id desc limit 0,1";
    return _select_unique_result($sql);
}
function cek_rawat_inap($norm,$noKunjunganPasien){
    $sql = "select count(*) as jumlah from kunjungan where id_pasien = '$norm' and no_kunjungan_pasien = '$noKunjunganPasien' and status = 'Keluar'";
    $result = _select_unique_result($sql);
    return $result;
}
function pembayaran_penjualan_muat_data($id) {
	$sql = "select p.id as nopenjualan, pb.jumlah_bayar, pb.sisa, p.total_tagihan, pb.id AS id_pembayaran, pd.nama, pb.waktu, pdk.nama as petugas from penjualan p
                left join pembayaran pb on (pb.id_penjualan = p.id)
                left join penduduk pd on (p.id_penduduk_pembeli = pd.id)
                left join pasien ps on (pd.id = ps.id_penduduk)
                left join penduduk pdk on (pdk.id = pb.id_pegawai_petugas)
                where p.id = '$id'";
	return _select_arr($sql);
}
function distribusi_muat_data_by_id($id = NULL){
    $return = array();
    $master = "select d.waktu,u.nama as unit,pend.nama as pegawai from distribusi d
               join unit u on d.id_unit_tujuan = u.id
               join pegawai pg on d.id_pegawai=pg.id
               join penduduk pend on pg.id = pend.id where d.id='$id'";
    $return['master'] = _select_arr($master);
    $detail = "select detail.batch,b.nama as barang,st.nama as satuan,sd.nama as sediaan,ins.nama as pabrik,o.generik,o.kekuatan,pb.nilai_konversi,detail.jumlah_distribusi from detail_distribusi_penerimaan_unit detail
               left join packing_barang pb on detail.id_packing_barang = pb.id
               left join satuan st on pb.id_satuan_terkecil = st.id
               left join barang b on pb.id_barang = b.id
               left join instansi_relasi ins on b.id_instansi_relasi_pabrik = ins.id
               left join obat o on o.id = b.id
               left join sediaan sd on o.id_sediaan = sd.id
               where detail.id_distribusi = '$id'";
    $return['detail'] = _select_arr($detail);
    return $return;

}
function pasien_discharge_detail_muat_data($id){
    $result['master']=
    _select_unique_result("select pasien.id as norm,dp.alamat_jalan as alamat,bil.id,pdd.nama as penduduk,discharge.alasan_keluar,discharge.id_billing 
         from pasien_discharge discharge
            JOIN billing bil on bil.id=discharge.id_billing
            join pasien on pasien.id=bil.id_pasien
            join penduduk pdd on pdd.id=pasien.id_penduduk
            join dinamis_penduduk dp on (dp.id_penduduk=pdd.id and dp.id=(SELECT max(id) FROM dinamis_penduduk where dinamis_penduduk.id_penduduk=pdd.id and dinamis_penduduk.akhir=1))
            where discharge.id='$id'");
    $result['list']=detail_billing_muat_data($result['master']['id_billing']);
    return $result;
}
function billing_detail_muat_data($id){
    $result['master']=
    _select_unique_result("select pasien.id as norm,dp.alamat_jalan as alamat,k.nama as kelurahan,kb.nama as kabupaten,kc.nama as kecamatan,pro.nama as provinsi,bil.id,pdd.nama as penduduk 
         from billing bil
            join pasien on pasien.id=bil.id_pasien
            join penduduk pdd on pdd.id=pasien.id_penduduk
            join dinamis_penduduk dp on (dp.id_penduduk=pdd.id and dp.id=(SELECT max(id) FROM dinamis_penduduk where dinamis_penduduk.id_penduduk=pdd.id and dinamis_penduduk.akhir=1))
            left join kelurahan k on (dp.id_kelurahan = k.id)
        left join kecamatan kc on (k.id_kecamatan = kc.id) 
		  LEFT JOIN kabupaten kb on (kb.id=kc.id_kabupaten)
        left join provinsi pro on kb.id_provinsi 
			where bil.id='$id'");
    $result['list']=detail_billing_muat_data($id);
    return $result;
}
function hitung_rop($idPacking,$awal=null,$akhir=null){
    //ambil jumlah keluar barang dari table stok dengan transaksi distribusi
    if($awal==null){
        $awal=Date('d/m/Y');
    }
    if($akhir==null){
        $tgl=explode('/',$awal);
        $day=gregoriantojd($tgl['1'],$tgl['0'], $tgl['2']);
        $day=$day-30;
        $akhir=jdtogregorian($day);
        $date=explode('/', $akhir);
        $akhir="$date[2]-$date[0]-$date[1]";
    }else
        $akhir=date2mysql ($akhir);
    $awal=date2mysql($awal);

    $anual_usage=_select_unique_result("select sum(s.keluar) as jumlah_keluar,count(*) as jumlah_transaksi
        from stok s where s.id_packing_barang='$idPacking' and s.id_jenis_transaksi='5'
        and DATE(s.waktu)>='$awal' and DATE(s.waktu)<='$akhir'");
    $leadTime=_select_unique_result("select sum(s.lead_time) as jumlah_lead_time,count(*) as jumlah_transaksi
        from stok s where s.id_packing_barang='$idPacking' and s.id_jenis_transaksi='2'
        and DATE(s.waktu)>='$awal' and DATE(s.waktu)<='$akhir'");
   $selisihHari=selisih_hari( $akhir,$awal);
   if ($selisihHari==0){
       $hasil=($anual_usage['jumlah_keluar']/$anual_usage['jumlah_transaksi'])*($leadTime['jumlah_lead_time']/$leadTime['jumlah_transaksi'])/$selisihHari;
   }else{
        $hasil=0;
   }
   return $hasil;
}
function data_tarif($code=NULL,$page=NULL,$data_perpage=NULL,$key=NULL,$sort=NULL,$sortBy=NULL){
	$result = array();
	$noPage = 1;
	$where="";
    $batas = "";
	if($key != NULL){
		$where = "where nama like '%$key%'";
	}else if($code != null){
		$where= "where id = '$code'";
	}
    if (!empty($page)){$noPage = $page;}
    $offset = ($noPage - 1) * $data_perpage;
    if ($data_perpage != null) {
        $batas = "limit $offset, $data_perpage";
    }
	$sortir = " order by id ASC"; 
	 if ($sort == 1) {
        $sortir = " order by id $sortBy";
    }
    $sql = "select * from kategori_tarif  $where $sortir ";

    if ($code != null) {
       $result = _select_unique_result($sql.$batas);
        $result['list'] = _select_arr($sql.$batas);
    } else {
        $result['list'] = _select_arr($sql.$batas);
    }
	 

    $result['paging'] = paging($sql, $data_perpage);
    $result['offset'] = $offset;
    return $result;
}
function jasa_apoteker_muat_data($idPendudukApoteker,$startDate,$endDate){
    //id_penduduk==id_pegawai
    $pasiens=_select_arr("select pasien.id as norm, pdd.nama from pasien 
            RIGHT JOIN penduduk pdd on pdd.id=pasien.id_penduduk
            where 
            pasien.id in (select billing.id_pasien from billing 
                JOIN detail_billing detail on (detail.id_billing=billing.id and (detail.id_penduduk_nakes1='$idPendudukApoteker' or detail.id_penduduk_nakes2='$idPendudukApoteker' or detail.id_penduduk_nakes3='$idPendudukApoteker')) and DATE(billing.waktu)>='$startDate' and DATE(billing.waktu)<='$endDate')
            OR pdd.id in (select penjualan.id_penduduk_pembeli from penjualan where penjualan.id_pegawai='$idPendudukApoteker' and DATE(penjualan.waktu)>='$startDate' and DATE(penjualan.waktu)<='$endDate') group by pdd.id");

    $result=array();
    $i=0;
    foreach($pasiens as $pasien){
        $result[$i]=$pasien;
        //cari layanan dengan kategori konsultasi
        $konsultasi=_select_unique_result("select sum(t.total_utama*t.persen_nakes_utama/100) as konsultasi from detail_billing detail
            JOIN billing b on b.id=detail.id_billing
            JOIn tarif t on t.id=detail.id_tarif
            JOIN layanan l on l.id=t.id_layanan
            JOIN kategori_tarif kt on kt.id=l.id_kategori_tarif
            where kt.id=14 and b.id_pegawai_petugas='$idPendudukApoteker' and DATE(b.waktu)>='$startDate' and DATE(b.waktu)<='$endDate'
                and b.id_pasien='$pasien[norm]'");
        $result[$i]['konsultasi']=$konsultasi['konsultasi'];
        //ambil biay apoteker per resep
        $pelayanan_resep=_select_arr("SELECT resep.biaya_apoteker FROM detail_penjualan_retur_penjualan detail
                    JOIN detail_resep_penjualan resep on resep.id_detail_penjualan_retur_penjualan=detail.id
                    JOIN penjualan p on p.id=detail.id_penjualan
                    JOIN pasien on pasien.id_penduduk=p.id_penduduk_pembeli
                    WHERE p.id_pegawai='$idPendudukApoteker' and pasien.id=$pasien[norm]
                    and DATE(p.waktu)>='$startDate' and DATE(p.waktu)<='$endDate' group by resep.no_r, p.id");
        $layanan_resep=0;
        //jumlahkan biaya apoteker
        foreach ($pelayanan_resep as $row){
            $layanan_resep+=$row['biaya_apoteker'];
        }
        $result[$i]['layanan_resep']=$layanan_resep;
        $i++;
    }
    return $result;
}

function jasa_gizi_muat_data($idNakes, $startDate, $endDate) {
    $sql = "select b.id_pasien, pd.nama, (t.total_utama*(t.persen_nakes_utama/100)*db.frekuensi) as subtotal from detail_billing db
        join billing b on (b.id = db.id_billing)
        join pasien ps on (b.id_pasien = ps.id)
        join penduduk pd on (pd.id = ps.id_penduduk)
        join tarif t on (t.id = db.id_tarif)
        join layanan l on (t.id_layanan = l.id)
        join penduduk p on (p.id = db.id_penduduk_nakes1)
        where (db.id_penduduk_nakes1 = '$idNakes' or db.id_penduduk_nakes2 = '$idNakes' or db.id_penduduk_nakes3 = '$idNakes') and l.id_kategori_tarif = '14'
        and date(db.waktu) between '".date2mysql($startDate)."' and '".date2mysql($endDate)."'
        ";
    return _select_arr($sql);
}

function jasa_perawat_muat_data($id_unit,$startDate, $endDate) {
    //JOINnya jangan diganti LEFT JOIN ya...!!!
    $perawats=_select_arr("select pdd.id as id_penduduk,pg.nip,pdd.nama as perawat from penduduk pdd
            JOIN pegawai pg on (pg.id=pdd.id and pg.id_unit='$id_unit')
            JOIN dinamis_penduduk dp on (dp.id_penduduk=pdd.id and dp.akhir=1)
            JOIN profesi on (profesi.id=dp.id_profesi and profesi.id='4')");
    $result=array();
    $i=0;
    $where="AND DATE(b.waktu)>='$startDate' and DATE(b.waktu)<='$endDate'";
    foreach($perawats as $row){
        $id_penduduk=$row['id_penduduk'];
        $result[$i]=$row;
        
        $total_nakes_utama=_select_unique_result("select sum(t.total_utama*t.persen_nakes_utama/100) as total from detail_billing detail
            JOIN billing b on b.id=detail.id_billing
            JOIN tarif t on t.id=detail.id_tarif
            where detail.id_penduduk_nakes1='$id_penduduk' $where");
        $total_nakes_pendamping=_select_unique_result("select sum(t.total_pendamping*t.persen_nakes_pendamping/100) as total from detail_billing detail
            JOIN billing b on b.id=detail.id_billing
            JOIN tarif t on t.id=detail.id_tarif
            where detail.id_penduduk_nakes2='$id_penduduk' $where");
        $total_nakes_pendukung=_select_unique_result("select sum(t.total_pendukung*t.persen_nakes_pendukung/100) as total from detail_billing detail
            JOIN billing b on b.id=detail.id_billing
            JOIN tarif t on t.id=detail.id_tarif
            where detail.id_penduduk_nakes3='$id_penduduk' $where");
        $result[$i]['total']=$total_nakes_pendamping['total']+$total_nakes_pendukung['total']+$total_nakes_utama['total'];
        $i++;
    }
//    $sql = "select pg.id as id_pegawai, p.nama as perawat, sum(t.total_utama*(t.persen_nakes_utama/100)) as total from detail_billing db
//        join billing b on (b.id = db.id_billing)
//        join pasien ps on (b.id_pasien = ps.id)
//        join penduduk pd on (pd.id = ps.id_penduduk)
//        join tarif t on (t.id = db.id_tarif)
//        join layanan l on (t.id_layanan = l.id)
//        join penduduk p on (p.id = db.id_penduduk_nakes1 or p.id = db.id_penduduk_nakes2 or p.id = db.id_penduduk_nakes3)
//        join pegawai pg on (pg.id = p.id)
//        where pg.id_unit = '$id_unit' and date(db.waktu) between '".date2mysql($startDate)."' and '".date2mysql($endDate)."'
//            group by p.id";
//    //echo "<pre>".$sql."</pre>";
    return $result;
}

function jasa_bidan_muat_data($idNakes,$startDate,$endDate) {
    $sql = "select b.id_pasien, l.id_kategori_tarif, pd.nama,  (t.total_utama*(t.persen_nakes_utama/100)*db.frekuensi) as subtotal from detail_billing db
        join billing b on (b.id = db.id_billing)
        join pasien ps on (b.id_pasien = ps.id)
        join penduduk pd on (pd.id = ps.id_penduduk)
        join tarif t on (t.id = db.id_tarif)
        join layanan l on (t.id_layanan = l.id)
        join penduduk p on (p.id = db.id_penduduk_nakes1)
        where (db.id_penduduk_nakes1 = '$idNakes' or db.id_penduduk_nakes2 = '$idNakes' or db.id_penduduk_nakes3 = '$idNakes') and l.id_kategori_tarif in (3,4)
        and date(db.waktu) between '".date2mysql($startDate)."' and '".date2mysql($endDate)."'
        ";
    //echo "<pre>".$sql."</pre>";
    return _select_arr($sql);
}


function info_pembayaran_penjualan_muat_data($petugas = null, $pembeli = null, $startDate, $endDate) {
    $required = "";
    if ($petugas != null) {
        $required.=" and p.id_pegawai_petugas = '$petugas'";
    }
    if ($pembeli != null) {
        $required.=" and pj.id_penduduk_pembeli = '$pembeli'";
    }
    
    $sql = "select p.id, p.waktu, pdd.nama as petugas, pdk.nama as pembeli, p.jumlah_bayar, p.sisa from pembayaran p
        join pegawai pg on (p.id_pegawai_petugas = pg.id)
        join penjualan pj on (p.id_penjualan = pj.id)
        join penduduk pdd on (pg.id = pdd.id)
        left join penduduk pdk on (pdk.id = pj.id_penduduk_pembeli)
        where date(p.waktu) between '".date2mysql($startDate)."' and '".date2mysql($endDate)."' $required";
    return _select_arr($sql);
}

function detail_pembayaran_penjualan_muat_data($id) {
    $sql = "select p.id_penjualan, pj.total_tagihan, p.id, p.waktu, pdd.nama as petugas, pdk.nama as pembeli, p.jumlah_bayar, p.sisa from pembayaran p
        join pegawai pg on (p.id_pegawai_petugas = pg.id)
        join penjualan pj on (p.id_penjualan = pj.id)
        join penduduk pdd on (pg.id = pdd.id)
        left join penduduk pdk on (pdk.id = pj.id_penduduk_pembeli)
        where p.id = '$id'";
    return _select_arr($sql);
}

function jasa_dokter_muat_data($startDate, $endDate){
     $sql = "SELECT pen.nama AS nama_nakes, pen.id AS id_penduduk_nakes, sp.nama AS nama_spesialisasi,
                        (SELECT sum((t1.total_utama * t1.persen_nakes_utama) /100 )
                            FROM tarif t1 
                            join layanan lay ON t1.id_layanan = lay.id
                            join kategori_tarif kat on lay.id_kategori_tarif = kat.id
                            JOIN detail_billing db1 ON t1.id = db1.id_tarif
                            WHERE db1.id_penduduk_nakes1 = pen.id AND kat.id in ('3','4','12','14','16')) as on_nakes1,
                        (SELECT sum((t1.total_pendamping * t1.persen_nakes_pendamping) /100 )
                            FROM tarif t1
                            join layanan lay ON t1.id_layanan = lay.id
                            join kategori_tarif kat on lay.id_kategori_tarif = kat.id
                            JOIN detail_billing db1 ON t1.id = db1.id_tarif
                            WHERE db1.id_penduduk_nakes2 = pen.id AND kat.id in ('3','4','12','14','16')) as on_nakes2,
                        (SELECT sum((t1.total_pendukung * t1.persen_nakes_pendukung) /100 )
                            FROM tarif t1
                            join layanan lay ON t1.id_layanan = lay.id
                            join kategori_tarif kat on lay.id_kategori_tarif = kat.id
                            JOIN detail_billing db1 ON t1.id = db1.id_tarif
                            WHERE db1.id_penduduk_nakes3 = pen.id AND kat.id in ('3','4','12','14','16')) as on_nakes3
                    FROM penduduk pen
                    JOIN dinamis_penduduk dp ON pen.id = dp.id_penduduk
                    JOIN profesi p ON dp.id_profesi = p.id
                    JOIN spesialisasi sp ON p.id = sp.id_profesi
                    JOIN layanan l ON sp.id = l.id_spesialisasi
                    JOIN kategori_tarif kt ON l.id_kategori_tarif = kt.id
                    JOIN tarif t ON l.id = t.id_layanan
                    JOIN detail_billing db ON t.id = db.id_tarif
                    JOIN billing b ON db.id_billing = b.id
                    WHERE p.id = '3' AND dp.akhir = '1'
                    AND date( db.waktu ) BETWEEN '$startDate' AND '$endDate'
                    GROUP BY pen.id
                    ";
     return _select_arr($sql);
}

function detail_jasa_dokter_umum_muat_data($id_penduduk,$startDate,$endDate){
    $data_return = array();
    $sql = "SELECT ap.nama as nama_asuransi, date(pb.waktu) as tgl_pembayaran,
                    bil.id_pasien as no_rm, pen.nama as nama_pasien, kat_tar.nama as tindakan_medis,
                    dbil.id_penduduk_nakes1 as on_nakes1, dbil.id_penduduk_nakes2 as on_nakes2, dbil.id_penduduk_nakes3 as on_nakes3,
                    ((tar.total_utama*tar.persen_nakes_utama)/100) as ongkos_nakes_utama,
                    ((tar.total_pendamping*tar.persen_nakes_pendamping)/100) as ongkos_nakes_pendamping,
                    ((tar.total_pendukung*tar.persen_nakes_pendukung)/100) as ongkos_nakes_pendukung
                    FROM detail_billing dbil
                    join billing bil on dbil.id_billing = bil.id
                    join kunjungan kun on bil.id_pasien = kun.id_pasien
                    join pasien pas on bil.id_pasien=pas.id
                    join penduduk pen on pas.id_penduduk = pen.id
                    join tarif tar on dbil.id_tarif = tar.id
                    join layanan lay on tar.id_layanan = lay.id
                    join kategori_tarif kat_tar on lay.id_kategori_tarif = kat_tar.id
                    left join detail_pembayaran_billing dpb on bil.id = dpb.id_billing
                    left join pembayaran_billing pb on dpb.id_pembayaran_billing = pb.id
                    left join asuransi_kepesertaan_kunjungan akk on kun.id = akk.id_kunjungan
                    left join asuransi_produk ap on akk.id_asuransi_produk = ap.id
                    WHERE
                    (dbil.id_penduduk_nakes1 = '".$id_penduduk."' or dbil.id_penduduk_nakes2 = '".$id_penduduk."' or dbil.id_penduduk_nakes3 = '".$id_penduduk."')
                     AND bil.id_pasien not in(select kunj.id_pasien from kunjungan kunj join rujukan ruj on kunj.id_rujukan=ruj.id
                        where ruj.id_penduduk_nakes='$id_penduduk')
                    AND bil.id_pasien not in(select kunj.id_pasien from asuransi_kepesertaan_kunjungan askk join kunjungan kunj on(askk.id_kunjungan=kunj.id) where askk.id_asuransi_produk='4' group by kunj.id_pasien)
                    AND date(dbil.waktu) BETWEEN '$startDate' AND '$endDate'
                    group by dbil.id order by dbil.waktu,pas.id";
    $data_query = (_select_arr($sql));
    foreach ($data_query as $datas){
        $ongkos = 0;
        if(!array_key_exists($datas['no_rm'], $data_return)){
            $data_return[$datas['no_rm']]=array(
                'no_rm'=>$datas['no_rm'],
                'nama_asuransi'=>$datas['nama_asuransi'],
                'tgl_pembayaran'=>$datas['tgl_pembayaran'],
                'nama_pasien'=>$datas['nama_pasien'],
                'pemeriksaan'=>'0',
                'visit'=>'0',
                'tindakan'=>'0',
                'konsultasi'=>'0',
                'medikasi'=>'0'
            );
        }
        if($datas['tindakan_medis']=='Pemeriksaan'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['pemeriksaan'] += $ongkos;
        }else if($datas['tindakan_medis']=='Visit'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['visit'] += $ongkos;
        }else if($datas['tindakan_medis']=='Tindakan'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['tindakan'] += $ongkos;
        }else if($datas['tindakan_medis']=='Konsultasi'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$record['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['konsultasi'] += $ongkos;
         }else if($datas['tindakan_medis']=='Medikasi'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['medikasi'] += $ongkos;
         }
    }
    return $data_return;
}

function detail_jasa_dokter_pribadi_muat_data($id_penduduk,$startDate,$endDate){
    $data_return = array();
    $sql = "SELECT ap.nama as nama_asuransi, date(pb.waktu) as tgl_pembayaran,
                    bil.id_pasien as no_rm, pen.nama as nama_pasien, kat_tar.nama as tindakan_medis,
                    dbil.id_penduduk_nakes1 as on_nakes1, dbil.id_penduduk_nakes2 as on_nakes2, dbil.id_penduduk_nakes3 as on_nakes3,
                    ((tar.total_utama*tar.persen_nakes_utama)/100) as ongkos_nakes_utama,
                    ((tar.total_pendamping*tar.persen_nakes_pendamping)/100) as ongkos_nakes_pendamping,
                    ((tar.total_pendukung*tar.persen_nakes_pendukung)/100) as ongkos_nakes_pendukung
                    FROM detail_billing dbil
                    join billing bil on dbil.id_billing = bil.id
                    join kunjungan kun on bil.id_pasien = kun.id_pasien
                    join pasien pas on bil.id_pasien=pas.id
                    join penduduk pen on pas.id_penduduk = pen.id
                    join tarif tar on dbil.id_tarif = tar.id
                    join layanan lay on tar.id_layanan = lay.id
                    join kategori_tarif kat_tar on lay.id_kategori_tarif = kat_tar.id
                    left join detail_pembayaran_billing dpb on bil.id = dpb.id_billing
                    left join pembayaran_billing pb on dpb.id_pembayaran_billing = pb.id
                    left join asuransi_kepesertaan_kunjungan akk on kun.id = akk.id_kunjungan
                    left join asuransi_produk ap on akk.id_asuransi_produk = ap.id
                    WHERE
                    (dbil.id_penduduk_nakes1 = '".$id_penduduk."' or dbil.id_penduduk_nakes2 = '".$id_penduduk."' or dbil.id_penduduk_nakes3 = '".$id_penduduk."')
                    AND bil.id_pasien in (select kunj.id_pasien from kunjungan kunj join rujukan ruj on kunj.id_rujukan=ruj.id
                        where ruj.id_penduduk_nakes='$id_penduduk'
                        and kunj.id_pasien not in(select kunj.id_pasien from asuransi_kepesertaan_kunjungan askk join kunjungan kunj on(askk.id_kunjungan=kunj.id) where askk.id_asuransi_produk='4' group by kunj.id_pasien))
                    AND bil.id_pasien not in(select kunj.id_pasien from asuransi_kepesertaan_kunjungan askk join kunjungan kunj on(askk.id_kunjungan=kunj.id) where askk.id_asuransi_produk='4' group by kunj.id_pasien)
                    AND date(dbil.waktu) BETWEEN '$startDate' AND '$endDate'
                    group by dbil.id order by dbil.waktu,pas.id";
    $data_query = (_select_arr($sql));
    foreach ($data_query as $datas){
        $ongkos = 0;
        if(!array_key_exists($datas['no_rm'], $data_return)){
            $data_return[$datas['no_rm']]=array(
                'no_rm'=>$datas['no_rm'],
                'nama_asuransi'=>$datas['nama_asuransi'],
                'tgl_pembayaran'=>$datas['tgl_pembayaran'],
                'nama_pasien'=>$datas['nama_pasien'],
                'pemeriksaan'=>'0',
                'visit'=>'0',
                'tindakan'=>'0',
                'konsultasi'=>'0',
                'medikasi'=>'0'
            );
        }
        if($datas['tindakan_medis']=='Pemeriksaan'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['pemeriksaan'] += $ongkos;
        }else if($datas['tindakan_medis']=='Visit'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['visit'] += $ongkos;
        }else if($datas['tindakan_medis']=='Tindakan'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['tindakan'] += $ongkos;
        }else if($datas['tindakan_medis']=='Konsultasi'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$record['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['konsultasi'] += $ongkos;
         }else if($datas['tindakan_medis']=='Medikasi'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['medikasi'] += $ongkos;
         }
    }
    return $data_return;
}

function detail_jasa_dokter_jamkesmas_muat_data($id_penduduk,$startDate,$endDate){
    $data_return = array();
    $sql2 = "SELECT ap.nama as nama_asuransi, date(pb.waktu) as tgl_pembayaran,
                    bil.id_pasien as no_rm, pen.nama as nama_pasien, kat_tar.nama as tindakan_medis,dbil.waktu,
                    dbil.id_penduduk_nakes1 as on_nakes1, dbil.id_penduduk_nakes2 as on_nakes2, dbil.id_penduduk_nakes3 as on_nakes3,
                    ((tar.total_utama*tar.persen_nakes_utama)/100) as ongkos_nakes_utama,
                    ((tar.total_pendamping*tar.persen_nakes_pendamping)/100) as ongkos_nakes_pendamping,
                    ((tar.total_pendukung*tar.persen_nakes_pendukung)/100) as ongkos_nakes_pendukung
                    FROM detail_billing dbil
                    join billing bil on dbil.id_billing = bil.id
                    join kunjungan kun on bil.id_pasien = kun.id_pasien
                    join pasien pas on bil.id_pasien=pas.id
                    join penduduk pen on pas.id_penduduk = pen.id
                    join tarif tar on dbil.id_tarif = tar.id
                    join layanan lay on tar.id_layanan = lay.id
                    join kategori_tarif kat_tar on lay.id_kategori_tarif = kat_tar.id
                    join detail_pembayaran_billing dpb on bil.id = dpb.id_billing
                    join pembayaran_billing pb on dpb.id_pembayaran_billing = pb.id
                    join asuransi_kepesertaan_kunjungan akk on kun.id = akk.id_kunjungan
                    join asuransi_produk ap on akk.id_asuransi_produk = ap.id
                    WHERE
                    (dbil.id_penduduk_nakes1 = '".$id_penduduk."' or dbil.id_penduduk_nakes2 = '".$id_penduduk."' or dbil.id_penduduk_nakes3 = '".$id_penduduk."')
                    AND bil.id_pasien in(select kunj.id_pasien from asuransi_kepesertaan_kunjungan askk join kunjungan kunj on(askk.id_kunjungan=kunj.id) where askk.id_asuransi_produk='4' group by kunj.id_pasien)
                    AND date(dbil.waktu) BETWEEN '$startDate' AND '$endDate'
                    group by dbil.id order by dbil.waktu,pas.id";
    $data_query = _select_arr($sql2);
    foreach($data_query as $datas){
        $ongkos = 0;
        if(!array_key_exists($datas['no_rm'], $data_return)){
            $data_return[$datas['no_rm']]=array(
                'no_rm'=>$datas['no_rm'],
                'nama_asuransi'=>$datas['nama_asuransi'],
                'tgl_pembayaran'=>$datas['tgl_pembayaran'],
                'nama_pasien'=>$datas['nama_pasien'],
                'pemeriksaan'=>'0',
                'visit'=>'0',
                'tindakan'=>'0',
                'konsultasi'=>'0',
                'medikasi'=>'0'
            );
        }
        if($datas['tindakan_medis']=='Pemeriksaan'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['pemeriksaan'] += $ongkos;
        }else if($datas['tindakan_medis']=='Visit'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['visit'] += $ongkos;
        }else if($datas['tindakan_medis']=='Tindakan'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['tindakan'] += $ongkos;
        }else if($datas['tindakan_medis']=='Konsultasi'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$record['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['konsultasi'] += $ongkos;
         }else if($datas['tindakan_medis']=='Medikasi'){
           $ongkos += ($datas['on_nakes1']==$id_penduduk)?$datas['ongkos_nakes_utama']:'';
           $ongkos += ($datas['on_nakes2']==$id_penduduk)?$datas['ongkos_nakes_pendamping']:'';
           $ongkos += ($datas['on_nakes3']==$id_penduduk)?$datas['ongkos_nakes_pendukung']:'';
           $data_return[$datas['no_rm']]['medikasi'] += $ongkos;
         }
    }
     return $data_return ;
}



function produksi_muat_data($id) {
    $sql = "select pdd.nama as pegawai,br1.nama as barang,pr.jumlah as jumlahjadi,st1.nama as satuan1,pb1.nilai_konversi as nilai,o1.kekuatan as power,o1.generik,sd1.nama as sediaan,ins1.nama as pabrik,pr.jumlah as jumlah
        from produksi pr
		 JOIN packing_barang pb1 on pb1.id=pr.id_packing_barang
		 JOIN barang br1 on br1.id=pb1.id_barang
		 LEFT JOIN  obat o1 on (o1.id = br1.id)
        left join sediaan sd1 on o1.id_sediaan = sd1.id
        JOIN pegawai pgw on pgw.id=pr.id_petugas_pegawai
		        JOIN penduduk pdd on pdd.id=pgw.id
				 left join satuan st1 on pb1.id_satuan_terkecil = st1.id
				 left join instansi_relasi ins1 on br1.id_instansi_relasi_pabrik = ins1.id
        where pr.id='$id'";
    return _select_unique_result($sql);
}
function detail_produksi_muat_data($id) {
    $sql = "select br2.nama as baranginput ,st2.nama as satuan,pb2.nilai_konversi as nilai,o2.kekuatan as power,o2.generik,sd2.nama as sediaan,ins2.nama as pabrik,detail.jumlah as jumlah_produksi
        from detail_produksi detail
        JOIN produksi pr on pr.id=detail.id_produksi
		 JOIN packing_barang pb2 on pb2.id=detail.id_packing_barang
		 JOIN barang br2 on br2.id=pb2.id_barang
		 LEFT JOIN  obat o2 on (o2.id = br2.id)
                left join sediaan sd2 on o2.id_sediaan = sd2.id
				  left join satuan st2 on pb2.id_satuan_terkecil= st2.id
				 left join instansi_relasi ins2 on br2.id_instansi_relasi_pabrik = ins2.id
        where detail.id_produksi='$id'";
   return _select_arr($sql);
}
function top10_muat_data($startDate=null, $endDate=null,$jumlah=null, $jenis=null){
    $return = array();
    $where = "";
    if ($startDate != null and $endDate != null) {
        $where=" and date(pl.waktu) between '".date2mysql($startDate)."' and '".date2mysql($endDate)."'";
    }
    if($jenis != null){
        $where .= " and pl.jenis = '$jenis'";
    }
    $limit = "";
    if($jumlah != NULL){
        $limit = "limit 0,$jumlah";
    }
    $sql = "select count(*) as jumlah,drm.id_icd_10,icd10.nama as penyakit,icd10.kode as kode_icd_10 from diagnosa_rekam_medik drm 
    join rekam_medik rm on drm.id_rekam_medik = rm.id
    join icd_10 icd10 on drm.id_icd_10 = icd10.id
    join pelayanan pl on rm.id = pl.id
    $where
    group by drm.id_icd_10 order by jumlah desc $limit";
    
    $jumlah = array();
    $return['master'] = _select_arr($sql);
    foreach ($return['master'] as $row){
        $jumlah[] = $row['jumlah'];
    }
    $return['max'] = max($jumlah);
    return $return;
}
function icd_10_muat_data($id = null, $page=NULL,$data_perpage=NULL,$key=NULL){
    $result = array();
    $noPage = 1;
    $where="";
    $batas = "";
    if ($id != null) {
        $where.=" where id = '$id'";
    }
    if($key != NULL){
            $where.=" where nama like '%$key%' ";
    }
    if (!empty($page)){$noPage = $page;}
        $offset = ($noPage - 1) * $data_perpage;
    if ($data_perpage != null) {
        $batas = " limit $offset, $data_perpage";
    }
    
    $sql = "select * from icd_10";
    if ($id != null) {
        $result = _select_unique_result($sql.$where);
    }
    $result['list'] = _select_arr($sql. $where. $batas);
    $result['paging'] = paging($sql . $where, $data_perpage);
    $result['offset'] = $offset;
    
    return $result;
}
function icd_9_muat_data($id = null, $page=NULL,$data_perpage=NULL,$key=NULL){
    $result = array();
    $noPage = 1;
    $where="";
    $batas = "";
    if ($id != null) {
        $where.=" where id = '$id'";
    }
    if($key != NULL){
            $where.=" where nama like '%$key%' ";
    }
    if (!empty($page)){$noPage = $page;}
        $offset = ($noPage - 1) * $data_perpage;
    if ($data_perpage != null) {
        $batas = " limit $offset, $data_perpage";
    }

    $sql = "select * from icd_9";
    if ($id != null) {
        $result = _select_unique_result($sql.$where);
    }
    $result['list'] = _select_arr($sql. $where. $batas);
    $result['paging'] = paging($sql . $where, $data_perpage,null,"ajax");
    $result['offset'] = $offset;

    return $result;
}
function kejadian_sakit_muat_data($id = null, $page=NULL,$data_perpage=NULL){
    $result = array();
    $noPage = 1;
    $where="";
    $batas = "";
    if ($id != null) {
        $where.=" where k.id = '$id'";
    }
    
    if (!empty($page)){$noPage = $page;}
        $offset = ($noPage - 1) * $data_perpage;
    if ($data_perpage != null) {
        $batas = " limit $offset, $data_perpage";
    }
    
    $sql = "select k.*,kel.nama as kelurahan from kejadian_sakit k join kelurahan kel on k.id_kelurahan = kel.id";
    if ($id != null) {
        $result = _select_unique_result($sql.$where);
    }
    $result['list'] = _select_arr($sql. $where. $batas);
    $result['paging'] = paging($sql . $where, $data_perpage);
    $result['offset'] = $offset;

    return $result;
}
function spesialisasi_dokter_muat_data($id_penduduk=NULL, $page=NULL, $data_perpage = NULL, $sort = NULL, $sortBy = NULL, $key = NULL){
    $result = array();
    $where="";
    $batas = "";
    if($id_penduduk!=null){
        $where .= " and p.id='".$id_penduduk."' ";
    }
    if($key != NULL){
        $where .= " and p.nama like '%$key%'";
    }
    if ($sort == 1) {
        $sortir = "order by p.nama $sortBy";
    }else if($sort == 2){
        $sortir = "order by p.id $sortBy";
    }else{
        $sortir=" order by p.nama asc ";
    }
    if (!empty($page)) {
        $noPage = $page;
    } else {
        $noPage = 1;
    }
    if (!empty($page)){$noPage = $page;}
        $offset = ($noPage - 1) * $data_perpage;
    if ($data_perpage != null) {
        $batas = " limit $offset, $data_perpage";
    }
    $sql = "select p.no_identitas,p.nama as nama_dokter,p.id as id_penduduk, p.nama as nama_dok,p.jenis_kelamin,p.sip,dp.alamat_jalan,
            kel.nama as nama_kelurahan,kel.id as idKel,dp.id_agama,peg.id_level,peg.id_unit,s.nama as nama_spesialisasi ,prof.nama as profesi,s.id as id_spesialisasi
            from dokter dok  
            join penduduk p on dok.id=p.id 
            join dinamis_penduduk dp on p.id=dp.id_penduduk 
            left join pegawai peg on p.id = peg.id
            left join kelurahan kel on dp.id_kelurahan=kel.id
            left join spesialisasi s on dok.id_spesialisasi = s.id
            left join profesi prof on prof.id=s.id_profesi where 1=1 and dp.akhir = '1'
            ";
    if ($id_penduduk != null) {
        $result = _select_unique_result($sql.$where);
    }else{
        $result['list'] = _select_arr($sql. $where. $sortir. $batas);
        $result['paging'] = paging($sql . $where, $data_perpage);
        $result['offset'] = $offset;
    }

    return $result;
}
function saldo_muat_data($kode_rekening,$bulan, $tahun){
    return _select_unique_result("SELECT * from saldo 
        JOIN rekening on rekening.id=saldo.id_rekening    
        where 
        rekening.kode='$kode_rekening' and 
        MONTH(saldo.tanggal)='$bulan' and 
        YEAR(saldo.tanggal)='$tahun'");
}
function pelayanan_muat_data($norm){
    if($norm != ""){
        $where = "where pl.id_pasien = '$norm'";
    }else $where = "";
    
    $query = "select pl.id,pl.waktu,pd.nama as dokter,b.nama as bed,ins.nama as instalasi from pelayanan pl
    join pasien ps on pl.id_pasien = ps.id
    join dokter d on pl.id_dokter = d.id
    join penduduk pd on d.id = pd.id
    join bed b on pl.id_bed = b.id
    join instalasi ins on b.id_instalasi = ins.id $where";
    
    return _select_arr($query);
}
function info_rekam_medik_muat_data($id){
    if($id != ""){
        $where = "where rm.id = '$id'";
    }else $where = "";
    
    $query = "select rm.*,pl.waktu,pd.nama as dokter,ks.nama as kejadian_sakit,ks.waktu_tiba,ks.waktu_kejadian,ks.alamat_jalan as alamat_kejadian,ks.penyebab_cedera,kel.nama as kelurahan_kejadian,b.nama as bed,ins.nama as instalasi from rekam_medik rm
    join pelayanan pl on rm.id = pl.id
    left join kejadian_sakit ks on rm.id_kejadian_sakit = ks.id
    join dokter d on pl.id_dokter = d.id
    join penduduk pd on d.id = pd.id
    join bed b on pl.id_bed = b.id
    join instalasi ins on b.id_instalasi = ins.id
    left join kelurahan kel on ks.id_kelurahan = kel.id $where";
    
    return _select_arr($query);
}
function diagnosa_tindakan_rekam_medik($id_pelayanan){
    if($id_pelayanan != ""){
        $where1 = "where drm.id_rekam_medik = '$id_pelayanan'"; 
        $where2 = "where trm.id_rekam_medik = '$id_pelayanan'";
    }else{
        $where1 = "";
        $where2 = "";
    }
    
    $diagnosa = "select icd10.nama as penyakit,icd10.kode as kode_icd10 from diagnosa_rekam_medik drm
    join icd_10 icd10 on drm.id_icd_10 = icd10.id $where1";
    $tindakan = "select icd9.nama as penyakit,icd9.kode as kode_icd9,trm.informed_consent from tindakan_rekam_medik trm
    join icd_9 icd9 on trm.id_icd_9 = icd9.id $where2";
    
    $return['diagnosa'] = _select_arr($diagnosa);
    $return['tindakan'] = _select_arr($tindakan);
    
    return $return;
}

function info_diagnosa_tindakan_pasien($id_pasien=NULL){
	$return = array();
	if($id_pasien!=NULL){
		$return['rawat_jalan']['tindakan']=array();
		$return['rawat_jalan']['diagnosa']=array();
		$return['rawat_inap']=array();
		$return['rawat_darurat']['tindakan']=array();
		$return['rawat_darurat']['diagnosa']=array();
		$return['rawat_inap']['tindakan'] = array();
		$return['rawat_inap']['diagnosa_nosokomial'] = array();
		$return['rawat_inap']['diagnosa_inap'] = array();
		$return['rawat_inap']['diagnosa_utama'] = array();
		$data_rawat_jalan =  _select_arr("select ic9.nama as nama,1=1 as ket
			from kunjungan kunj
			left join rawat_jalan rj on kunj.id=rj.id_kunjungan
			left join detail_tindakan_jalan dtj on rj.id=dtj.id_rawat_jalan
			join icd_9 ic9 on dtj.id_icd_9=ic9.id
			where id_pasien='$id_pasien' 
			union
			select ic10.nama as nama,1+1 as ket
			from kunjungan kunj
			left join rawat_jalan rj on kunj.id=rj.id_kunjungan
			left join detail_diagnosa_jalan ddj on rj.id=ddj.id_rawat_jalan
			join icd_10 ic10 on ddj.id_icd_10=ic10.id
			where id_pasien='$id_pasien' ");
		foreach($data_rawat_jalan as $data){
			if($data['ket']=='1'){
				$return['rawat_jalan']['tindakan'][] = $data['nama'];
			}else{
				$return['rawat_jalan']['diagnosa'][] = $data['nama'];
			}
		}
		$data_rawat_inap = _select_arr("select 
			ic9.nama as nama,1=1 as ket
			from kunjungan kunj
			left join resume_inap ri on kunj.id=ri.id_kunjungan
			left join detail_tindakan_inap dti on ri.id=dti.id_resume_inap
			join icd_9 ic9 on dti.id_icd_9=ic9.id
			where id_pasien='$id_pasien' 
			union
			select 
			ic10.nama as nama, 1+1 as ket
			from kunjungan kunj
			left join resume_inap ri on kunj.id=ri.id_kunjungan
			left join detail_nosokomial_inap dni on ri.id=dni.id_resume_inap
			join icd_10 ic10 on dni.id_icd_10=ic10.id
			where id_pasien='$id_pasien' 
			union
			select 
			ic10_1.nama as nama, 1+2 as ket
			from kunjungan kunj
			left join resume_inap ri on kunj.id=ri.id_kunjungan
			left join detail_diagnosa_inap ddi on ri.id=ddi.id_resume_inap
			join icd_10 ic10_1 on ddi.id_icd_10=ic10_1.id
			where id_pasien='$id_pasien' 
			union
			select 
			ic_10_2.nama as nama, 1+4 as ket
			from kunjungan kunj
			left join resume_inap ri on kunj.id=ri.id_kunjungan
			join icd_10 ic_10_2 on ri.id_diagnosa_utama=ic_10_2.id
			where id_pasien='$id_pasien' 
			");
			foreach($data_rawat_inap as $data){
				if($data['ket']=='1'){
					$return['rawat_inap']['tindakan'][] = $data['nama'];
				}else if($data['ket']=='2'){
					$return['rawat_inap']['diagnosa_nosokomial'][] = $data['nama'];
				}else if($data['ket']=='3'){
					$return['rawat_inap']['diagnosa_inap'][] = $data['nama'];
				}else{
					$return['rawat_inap']['diagnosa_utama'][] = $data['nama'];
				}
			}
		$data_rawat_darurat = _select_arr("select 
			ic9.nama as nama, 1=1 as ket
			from kunjungan  kunj
			left join  rawat_darurat rd on kunj.id=rd.id_kunjungan
			left join detail_tindakan_igd dti on rd.id=dti.id_rawat_darurat
			join icd_9 ic9 on dti.id_icd_9=ic9.id
			where id_pasien='$id_pasien'
			union
			select ic10.nama as nama,1+1 as ket
			from kunjungan  kunj
			left join  rawat_darurat rd on kunj.id=rd.id_kunjungan
			left join detail_diagnosa_igd ddi on rd.id=ddi.id_rawat_darurat
			join icd_10 ic10 on ddi.id_icd_10=ic10.id
			where id_pasien='$id_pasien'");
			foreach($data_rawat_darurat as $data){
			if($data['ket']=='1'){
				$return['rawat_darurat']['tindakan'][] = $data['nama'];
			}else{
				$return['rawat_darurat']['diagnosa'][] = $data['nama'];
			}
		}
	}
	
	return $return;
	
}

function diagnosa_rekam_medik_muat_data($id=null,$id_arr=null){
    $where="";
    if($id!=null){
        $where=" drm.id=$id ";
    }
    
    if(!empty($id_arr)){
        $where=" ";
        $length=count($id_arr);
        
        $i=0;
        foreach($id_arr as $id){
            $i++;
            $where.=" drm.id=$id ";
            if($i<$length){
                $where.=" OR ";
            }
        }
    }
    
    $sql="SELECT drm.id as id_diagnosa,i.id as id_icd,drm.id_rekam_medik,
        i.kode,i.nama as nama_diagnosa,i.sub_diskripsi
        FROM diagnosa_rekam_medik drm
        JOIN icd_10 i ON drm.id_icd_10=i.id
        WHERE $where";
    
    return _select_arr($sql);
}

function tindakan_rekam_medik_muat_data($id=null,$id_arr=null){
    $where="";
    if($id!=null){
        $where=" trm.id=$id ";
    }
    
    if(!empty($id_arr)){
        $where=" ";
        $length=count($id_arr);
        $i=0;
        
        foreach($id_arr as $id){
            $i++;
            $where.=" trm.id=$id ";
            if($i<$length){
                $where.=" OR ";
            }
        }
    }
    
    $sql="SELECT
            trm.id as id_tindakan, i.id as id_icd,
            trm.informed_consent as ic,i.kode,i.nama as nama_tindakan
        FROM 
            tindakan_rekam_medik trm
        JOIN icd_9 i ON trm.id_icd_9=i.id

        WHERE $where";
    
    return _select_arr($sql);
}

function borMuatData($id_instalasi,$periode){
	$ex_period = explode("-",$periode);
	$jumHari = cal_days_in_month(CAL_GREGORIAN, $ex_period[1], $ex_period[0]);
	$awal  = $periode."-01";
	$akhir = $periode."-".$jumHari;
	$jml_masuk_awal = _select_unique_result("SELECT count(DISTINCT kunj2.id_pasien,kunj2.no_kunjungan_pasien) as masuk_awal FROM kunjungan kunj2 JOIN bed b ON kunj2.id_bed = b.id JOIN instalasi ins ON b.id_instalasi = ins.id WHERE ins.id='".$id_instalasi."' and kunj2.status = 'Mutasi' AND date( kunj2.waktu ) < '$awal' and kunj2.waktu_keluar='0000-00-00 00:00:00'");
	$jml_keluar_awal = _select_unique_result("select count(kunj1.id) as keluar_awal from kunjungan kunj1 join bed b on kunj1.id_bed =b.id join instalasi ins on b.id_instalasi=ins.id where ins.id='".$id_instalasi."' and kunj1.status='Keluar' and date(kunj1.waktu) < '$awal' or (kunj1.status='Mutasi' and kunj1.waktu_keluar!='0000-00-00 00:00:00')");
	$data['hari']=$jumHari;
	$data['jml_bed'] = _select_unique_result(" select count(*) as jml_bed from bed where id_instalasi='$id_instalasi' ");
	$data['jml_masuk_bulan_lalu'] = $jml_masuk_awal['masuk_awal'] - $jml_keluar_awal['keluar_awal'];
	$data['bulan_ini'] = _select_arr("select date(kunj.waktu) as tanggal,
			(select count(kunj1.id) from kunjungan kunj1 join bed b on kunj1.id_bed =b.id join instalasi ins on b.id_instalasi=ins.id where ins.id='".$id_instalasi."' and kunj1.status='Keluar' and date(kunj1.waktu)=date(kunj.waktu) or (kunj1.status='Mutasi' and date(kunj1.waktu_keluar)=date(kunj.waktu)) ) as jml_keluar,
			(SELECT count(DISTINCT kunj2.id_pasien,kunj2.no_kunjungan_pasien) FROM kunjungan kunj2 JOIN bed b ON kunj2.id_bed = b.id JOIN instalasi ins ON b.id_instalasi = ins.id WHERE ins.id='".$id_instalasi."' and kunj2.status = 'Mutasi' AND date( kunj2.waktu ) = date(kunj.waktu) and date(kunj2.waktu_keluar)!=date(kunj.waktu)) as jml_masuk
			from kunjungan kunj where date(kunj.waktu) between '$awal' and '$akhir' group by date(kunj.waktu)
		");
	return $data;
}
function asuransi_kunjungan_muat_data($idKunjungan) {
     $sql="
                    select akk.id as id_asuransi, ap.nama as nama_asuransi
                    from
                    asuransi_kepesertaan_kunjungan akk
                    left join asuransi_produk ap on ap.id=akk.id_asuransi_produk
                    where akk.id_kunjungan=".$_GET['idKunjungan'];
    return _select_arr($sql);
}
function pengirim_muat_data($startDate=NULL,$endDate=NULL,$id=NULL,$sort='k.waktu',$by='ASC') {
	 $return = array();
	  $where = "";
	if($id != NULL){
	$where =" where dp.id_penduduk='$id'";
	}
	else{
	$where =" where k.id_penduduk_pengantar!=''";
	}
	 if ($startDate != null and $endDate != null) {
	 	 $require_oncement= "AND DATE(k.waktu) >= '".$startDate."' AND DATE(k.waktu) <= '".$endDate."'";
       
    }
     $sql="select k.*,dp.*,pg.nama as pengantar,pa.nama as pasien,(select count(id_penduduk_pengantar) from kunjungan where id_penduduk_pengantar=dp.id_penduduk) as total from kunjungan k
	 left join penduduk pg on (pg.id=k.id_penduduk_pengantar)
	  left join dinamis_penduduk dp on (dp.id_penduduk=pg.id and dp.akhir='1')
	 left join pasien ps on (ps.id=k.id_pasien)
	 left join penduduk pa on (pa.id=ps.id_penduduk)
	 $where $require_oncement and k.status='Masuk'  group by pg.id order by " . $sort . " " . $by;
    return _select_arr($sql);
}
function info_pembayaran_muat_data($startdate=NULL, $enddate=NULL, $norm=NULL){
    $return = array();
    $where = "";
    if($norm != NULL){
        $where .= " and ps.id = '$norm'";
    }
 if ($startdate != null and $enddate != null) {
	 	 $require_oncement= "AND DATE(py.waktu) >= '".date2mysql($startdate)."' AND DATE(py.waktu) <= '".date2mysql($enddate)."'";
       
    }
    $sql = " select py.id as nota,py.waktu as tanggal,py.jumlah_tagihan as tagihan,py.jumlah_bayar as bayar,py.jumlah_sisa_tagihan as utang,pdd.nama as pembeli from pembayaran py
	left join detail_pembayaran dpy on(dpy.id_pembayaran_billing=py.id)
	left join penduduk pdd on (pdd.id=py.id_penduduk_customer)
	left join dinamis_penduduk dp on (dp.id_penduduk = pdd.id)
	left join pasien ps on (ps.id_penduduk=pdd.id)
	where dp.akhir = 1 $where $require_oncement group by py.id";
	
    $return = _select_arr($sql);
    return $return;
}