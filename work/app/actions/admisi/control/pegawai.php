<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

if(isset ($_POST['tambah']) || isset ($_POST['edit'])){
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$idPenduduk = $_POST['idpenduduk'];
$level = $_POST['level'];
$unit = $_POST['unit'];
$noIdentitas = $_POST['no_identitas'];
$alamat = $_POST['almt'];
$idKelurahan = $_POST['idKelurahan'];
$jenkel = $_POST['jeKel'];
$tglLahir = date2mysql($_POST['tglLahir']);
$noKK = $_POST['no_kk'];
$posisi = $_POST['posisi'];
$sip = $_POST['sip'];
$telpon = $_POST['no_telp'];
$pendidikan = $_POST['idPendidikan'];
$profesi = $_POST['idProfesi'];
$pekerjaan = $_POST['idPekerjaan'];
$agama = $_POST['idAgama'];
$perkawinan = $_POST['idPerkawinan'];
$umur = isset($_POST['umur'])?$_POST['umur']:null;
//echo $posisi; exit;
// penanggulangi gagal update jika reference kolom induk tidak diisi atau NULL value
$arr = array('index_',$jenkel,$noKK,$posisi,$sip,$telpon,$pendidikan,$profesi,$pekerjaan,$agama,$perkawinan);
$i=1;
$arr_length = count($arr);
while ($i < ($arr_length)) {
        $arr[$i]=trim($arr[$i]);
        if ($arr[$i] == ''){
                $arr[$i] = "NULL";
        }
++$i;
}
//exit;
if($umur != "" && $tglLahir != ""){
    $date = $tglLahir;
}
if ($umur != '' && $tglLahir == "") {
    $date = tglLahir($umur);
} else {
    $date = $tglLahir;
}
}

if (isset($_POST['tambah'])) {
    if (empty ($_POST['idpenduduk'])) {
        $sql = _insert("insert into penduduk
            (no_identitas,nama,jenis_kelamin,tanggal_lahir,no_kartu_keluarga,posisi_di_keluarga,sip)
            VALUES
            ('$noIdentitas','$nama','{$arr[1]}','$date','{$arr[2]}','{$arr[3]}','{$arr[4]}')");
		
        $id = _last_id();
		
        $sql = "insert into dinamis_penduduk           (tanggal,id_penduduk,alamat_jalan,no_telp,id_kelurahan,status_pernikahan,id_pendidikan_terakhir,id_profesi,id_agama,akhir,id_pekerjaan)
            VALUES
            (now(),'$id','$alamat','$telpon','$idKelurahan','{$arr[10]}',{$arr[6]},{$arr[7]},{$arr[9]},1,{$arr[8]})";
        _insert($sql);
        $sql = _insert("insert into pegawai values ('$id','$nip','$level','$unit')");
		$id = _last_id();
    } else {
        $sql = _insert("insert into pegawai values ('$idPenduduk','$nip','$level','$unit')");
		$id = $idPenduduk;
        _update("update dinamis_penduduk set akhir=0 where id_penduduk=$id");        
        $sql = "insert dinamis_penduduk
            (tanggal,id_penduduk,alamat_jalan,no_telp,id_kelurahan,status_pernikahan,id_pendidikan_terakhir,id_profesi,id_agama,akhir,id_pekerjaan)
            VALUES
            (now(),'$id','$alamat','$telpon','$idKelurahan','{$arr[10]}',{$arr[6]},{$arr[7]},{$arr[9]},1,{$arr[8]})";        
         _insert($sql);   
    }
    if ($sql) {
        header("location:".  app_base_url('admisi/pegawai?msg=1')."&code=".$id);
    }else{
        header("location:".  app_base_url('admisi/pegawai?msr=3'));
    }
} else if (isset($_POST['edit'])) {
    $id = $_POST['idpegawai'];

    $query = _update("update pegawai set nip='$nip',id_level='$level',id_unit='$unit' where id='$id'");
    $sql = "update penduduk SET
            no_identitas='$noIdentitas',nama='$nama',jenis_kelamin='{$arr[1]}',
            tanggal_lahir='$date',no_kartu_keluarga='{$arr[2]}',posisi_di_keluarga='{$arr[3]}',sip='{$arr[4]}'
            WHERE id='$id'";
    _update($sql);
    $sql = "update dinamis_penduduk set
            alamat_jalan='$alamat',no_telp='{$arr[5]}',id_kelurahan='$idKelurahan',
            status_pernikahan='{$arr[10]}',id_pendidikan_terakhir={$arr[6]},id_profesi={$arr[7]},id_pekerjaan={$arr[8]},id_agama={$arr[9]}
            where id_penduduk = '$id' and akhir = '1'";
    _update($sql);
    if ($query) {
        header("location:" . app_base_url('admisi/pegawai?msg=1')."&code=".$id);
    }else{
        header("location:".  app_base_url('admisi/pegawai?msr=3'));
    }
} else if (isset ($_GET['do']) == "delete") {
?>
   <h2 class="judul">Master Data Pegawai</h2>
<?
    $pegawai = pegawai_muat_data($_GET['id']);
    $data = $pegawai['list'];
	$id=$_GET['id'];
		$table=array('pemesanan','pembelian','retur_pembelian','reretur_pembelian','pemusnahan','distribusi','penerimaan_unit','penerimaan_retur_unit','penjualan','retur_penjualan','retur_pembelian','retur_unit','pemakaian','penjualan');
		foreach($table as $row){
		$sql = "select count(*) as jumlah from $row where id_pegawai = '$id'";
			$jml = _select_unique_result($sql);
	$table2=array('billing','pembayaran','pembayaran_billing');
	foreach($table2 as $row2){
	$sql2 = "select count(*) as jumlah from $row2 where id_pegawai_petugas = '$id'";
			$jml2 = _select_unique_result($sql2);
	
	$sql3 = "select count(*) as jumlah from formularium where id_pegawai_panitia_farmasi = '$id'";
			$jml3 = _select_unique_result($sql3);
			
		$sql4 = "select count(*) as jumlah from produksi where id_petugas_pegawai = '$id'";
			$jml4 = _select_unique_result($sql4);
				
	if (((($jml['jumlah'] > 0) OR ($jml2['jumlah'] > 0) OR ($jml3['jumlah'] > 0) OR ($jml4['jumlah'] > 0)))) {
		header('location:'.  app_base_url('admisi/pegawai').'?msr=14');
	} 
	}
	}
	
	
    delete_list_data($_GET['id'], 'pegawai', 'admisi/pegawai?msg=2', 'admisi/pegawai?msr=7', $data[0]['nama'],null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
    

}
?>
