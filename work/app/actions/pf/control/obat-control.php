<?php
if(isset($_GET['do']) && $_GET['do']=='delete'){
    require_once 'app/lib/pf/obat.php';
    $obat=obat_muat_data($_GET['id']);
	$sql = "select count(*) as jumlah from detail_formularium where id_obat = '$_GET[id]'";
	$jml = _select_unique_result($sql);
	
	$sqlA= "select count(*) as jumlah from packing_barang where id_barang = '$_GET[id]'";
	$rowA= _select_unique_result($sqlA);
	
	if (($jml['jumlah'] > 0) or ($rowA['jumlah'] > 0)) {
		header('location:'.  app_base_url('pf/obat').'?msr=7'."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	} else {
		delete_list_data2($obat['nama_barang'], 'pf/obat/?msg=2', 'pf/obat/?msr=7', array(0=>"delete from obat where id='$_GET[id]'",1=>"delete from barang where id='$_GET[id]'"),generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	}
}else if(isset ($_POST['simpan'])){
    if(isset($_POST['idObat'])&& $_POST['idObat']!=''){
        $id=$_POST['idObat'];
        $namaObat = isset ($_POST['namaObat'])?$_POST['namaObat']:NULL;
        $idSediaan = isset ($_POST['idSediaan'])?$_POST['idSediaan']:NULL;
        $indikasi = isset ($_POST['indikasi'])?$_POST['indikasi']:NULL;
        $idFarmakologi = isset ($_POST['idFarmakologi'])?$_POST['idFarmakologi']:NULL;
        $perundangan = isset ($_POST['perundangan'])?$_POST['perundangan']:NULL;
        $ven = isset ($_POST['ven'])?$_POST['ven']:NULL;
        $generik = isset ($_POST['generik'])?$_POST['generik']:NULL;
        $id = isset ($_POST['idObat'])?$_POST['idObat']:NULL;
        $kekuatan = isset ($_POST['kekuatan'])?$_POST['kekuatan']:NULL;
        $idPabrik = isset ($_POST['idPabrik'])?$_POST['idPabrik']:NULL;


        $barang = _update("update barang set nama='$namaObat',id_instansi_relasi_pabrik='$idPabrik' where id='$_POST[idObat]'");

        $exe=_update("
        update obat set
        id_sediaan='$idSediaan',
        indikasi='$indikasi',
        id_sub_sub_farmakologi='$idFarmakologi',
        id_gol_perundangan='$perundangan',
        ven='$ven',
        generik='$generik',
	kekuatan='$kekuatan'
        WHERE id='$_POST[idObat]'
        ");

        if($exe)
            header('location:'.  app_base_url('pf/obat').'?msg=1&code='.$_POST['idObat'].'&id='.$_POST['idObat'].'&code='.$id);
        else
            header('location:'.  app_base_url('pf/obat').'?msr=8');

    }else{
        $namaObat = isset ($_POST['namaObat'])?$_POST['namaObat']:NULL;
        $select = _select_arr("select o.* from obat o left join barang b on o.id=b.id where b.nama='$namaObat' and o.kekuatan='$_POST[kekuatan]' and o.id_sediaan='$_POST[idSediaan]' and b.id_instansi_relasi_pabrik='$_POST[idPabrik]'");
        $count = count($select);
        if($count > 0){
			header('location:'.  app_base_url('pf/obat').'?msr=11');
        }else{
            $barang = _insert("insert into barang (id,nama,id_sub_kategori_barang,id_instansi_relasi_pabrik) values ('','$_POST[namaObat]',1,'$_POST[idPabrik]')");
            $id = _last_id();
            $exe = _insert("insert into obat
            (id,id_sediaan,indikasi,id_sub_sub_farmakologi,id_gol_perundangan,ven,generik,kekuatan)
            values
           ('$id','$_POST[idSediaan]','$_POST[indikasi]','$_POST[idFarmakologi]','$_POST[perundangan]','$_POST[ven]','$_POST[generik]','$_POST[kekuatan]')");

        if($exe)
        header('location:'.  app_base_url('pf/obat').'?msg=1&code='.$id);
        else
        header('location:'.  app_base_url('pf/obat').'?msr=8');
        }
    }
}
?>