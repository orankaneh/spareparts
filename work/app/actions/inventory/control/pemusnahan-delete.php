<?php
$id=  get_value('id');
$query[0]="delete from detail_pemusnahan where id_pemusnahan='$id'";
$query[1]='delete from pemusnahan where id="'.$id.'"';
delete_list_data2("pemusnahan $id", 'inventory/info-pemusnahan?msg=1', 'inventory/info-pemusnahan?msr=1', $query);
?>
