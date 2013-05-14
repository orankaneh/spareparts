<?php
require_once 'app/lib/common/functions.php';
?>
<h1 class="judul">INPUT & EDIT DATA INSTANSI RELASI</h1>
<?
$table=array('asuransi_produk','barang','pembelian','pemesanan','rujukan');
//$field=array('id_instansi_relasi','id_instansi_relasi_pabrik','id_instansi_suplier','id_instansi_relasi_suplier','id_instansi_relasi');
$field=array('id_instansi_relasi','id_instansi_relasi_pabrik','id_instansi_suplier','id_instansi_relasi_suplier','id_instansi_relasi');

foreach($table as $key=>$row){
        
        $sql = "select count(*) as jumlah from $row where $field[$key] = '$_GET[id]'";
	$jml = _select_unique_result($sql);
    
    
        if ($jml['jumlah'] > 0) {
            //echo $sql."<br/> ".$jml['jumlah'];
            header('location:'.  app_base_url('pf/inventory/instansi-relasi').'?msr=14');
	} 	
    }
 
delete_list_data($_GET['id'], 'instansi_relasi', 'pf/inventory/instansi-relasi?msg=2','pf/inventory/instansi-relasi?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
