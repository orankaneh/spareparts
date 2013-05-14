<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
$id = isset($_GET['id'])?$_GET['id']:NULL;

$sql = "select * from penduduk where id = '$id'";
$row = _select_unique_result($sql);
$table=array('dinamis_penduduk','pemusnahan','pembelian','pemesanan','rujukan');
$field=array('id_penduduk','id_penduduk_saksi','id_instansi_suplier','id_instansi_relasi_suplier','id_instansi_relasi');
/*foreach($table as $row){
foreach($field as $row2){
$sql = "select count(*) as jumlah from $row where $row2 = '$_GET[id]'";
	$jml = _select_unique_result($sql);
if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('pf/inventory/instansi-relasi').'?msr=14');
	} 
	}
	}
 */
delete_list_data2($row['nama'], 'admisi/penduduk?msg=2', 'admisi/penduduk?msr=7',array(1=>'delete from penduduk where id="'.$_GET['id'].'"'), generate_get_parameter($_GET, null, array('do','id')));
?>