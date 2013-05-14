<?php
$id=  get_value('id');
$cek=_select_unique_result("select count(*) as jumlah from detail_pemesanan_faktur where id_pemesanan=$id and id_pembelian is not null");
if($cek['jumlah']!=0){
    header('location:'.app_base_url('inventory/info-pemesanan?')."msr=7".generate_get_parameter($_GET, null, array('id')));
}
$query[0]="delete from detail_pemesanan_faktur where id_pemesanan='$id'";
$query[1]='delete from pemesanan where id="'.$id.'"';
delete_list_data2("pemesanan $id", 'inventory/info-pemesanan?msg=1', 'inventory/info-pemesanan?msr=1', $query);
?>
