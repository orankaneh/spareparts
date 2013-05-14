<?php

$q=(isset($_GET['q']))?$_GET['q']:null;
if($_GET['opsi']=='sub_farmakologi'){
    require_once 'app/lib/pf/farmakologi.php';
    $data=sub_farmakologi_muat_data($_GET['q']);
    die(json_encode($data));
}else if($_GET['opsi']=='subFarmakologi'){
    $data=  _select_arr("select sf.*,f.nama as nama_farmakologi from sub_farmakologi sf
                JOIN farmakologi f on f.id=sf.id_farmakologi WHERE sf.nama like '%$q%' LIMIT 10");
    die(json_encode($data));
}else if($_GET['opsi']=='barang'){
    $sql = "select b.id,b.nama,kb.nama as kategori from barang b
                JOIN sub_kategori_barang kb on kb.id=b.id_sub_kategori_barang
                where kb.id=1 AND b.nama like '%$q%' AND b.id not in (select o.id from obat o)";
        $hasil=_select_arr($sql);
        die(json_encode($hasil));
}else if($_GET['opsi']=='barang2'){
    $sql = "select b.id,b.nama,kb.nama as kategori from barang b
                JOIN sub_kategori_barang kb on kb.id=b.id_sub_kategori_barang
                where b.nama like '%$q%' AND b.id not in (select o.id from obat o) AND kb.id=1";
        $hasil=_select_arr($sql);
        die(json_encode($hasil));
}else if($_GET['opsi']=='sediaan'){
    $sql = "SELECT * FROM sediaan where nama like '%$q%' LIMIT 10";
        $hasil=_select_arr($sql);
        die(json_encode($hasil));
}else if($_GET['opsi']=='sub_sub_farmakologi'){
    $data=_select_arr("SELECT
        ssf.id as id_sub_sub_farmakologi,ssf.nama,ssf.keterangan,
        sf.id as id_sub_farmakologi,sf.nama as nama_sub_farmakologi,
        f.id as id_farmakologi,f.nama as nama_farmakologi
        FROM sub_sub_farmakologi ssf
        left JOIN sub_farmakologi sf on sf.id=ssf.id_sub_farmakologi
        left JOIN farmakologi f on f.id=sf.id_farmakologi
        where ssf.nama like '%$q%' or sf.nama like '%$q%' or f.nama like '%$q%'");
    die(json_encode($data));
}else if($_GET['opsi']=='farmakologi'){
    $data=_select_arr("SELECT * FROM farmakologi WHERE nama like '%$q%' LIMIT 10");
    die(json_encode($data));
}else if($_GET['opsi']=='komposisiobat'){
    $id=$_GET['id_obat'];
    $data=array();
    $data['selected']=_select_arr("select zat.id,zat.nama from komposisi_obat k
            join zat_aktif zat on k.id_zat_aktif=zat.id
            where k.id_obat='$id'");
    $data['notselected']=_select_arr("select zat.id,zat.nama from zat_aktif zat
            where zat.id not in (select k.id_zat_aktif from komposisi_obat k where k.id_obat='$id')");
    die(json_encode($data));
}else if($_GET['opsi']=='paging_farmakologi'){
    require_once 'app/lib/pf/farmakologi.php';
    die(json_encode(farmakologi_muat_data_farmakologi(null, get_value('sort'), get_value('sortBy'), get_value('page'), 15)));
}else if($_GET['opsi']=='paging_subfarmakologi'){
    require_once 'app/lib/pf/farmakologi.php';
    die(json_encode(sub_farmakologi_muat_data(null,get_value('key'),get_value('sort'), get_value('sortBy'), get_value('page'), 15)));
}else if($_GET['opsi']=='paging_subsubfarmakologi'){
    require_once 'app/lib/pf/farmakologi.php';
    die(json_encode(sub_sub_farmakologi_muat_data(null, get_value('sort'), get_value('page'), 15, get_value('key'), get_value('sortBy'))));
}else if($_GET['opsi']=='paging_obat'){
    require_once 'app/lib/pf/obat.php';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
    $page = isset($_GET['page']) ? $_GET['page'] : NULL;
    $key = isset($_GET['key']) ? $_GET['key'] : NULL;
    $code = isset($_GET['code']) ? $_GET['code'] : NULL;
    $obats = obat_muat_data($code, $page, 15, $sort, $sortBy, $key);
    die(json_encode($obats));
}else if($_GET['opsi']=='paging_satuan'){
    require_once 'app/lib/pf/satuan.php';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $code = isset($_GET['code']) ? $_GET['code'] : NULL;
    $page = isset($_GET['page']) ? $_GET['page'] : NULL;
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
    $dataPerPage =get_value('perPage');
    $satuan = satuan_muat_data($code, $sort, $sortBy, $page, $dataPerPage);
    die(json_encode($satuan));
}else if($_GET['opsi']=='paging_sediaan'){
    require_once 'app/lib/pf/sediaan.php';
    $sort = isset($_GET['sort'])?$_GET['sort']:NULL;
    $sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
    $code = isset($_GET['code'])?$_GET['code']:NULL;
    $page = isset($_GET['page'])?$_GET['page']:NULL;
    $sediaan = sediaan_muat_data($code, $sort,$sortBy, $page, get_value('perPage'));
    die(json_encode($sediaan));
}
exit;
?>