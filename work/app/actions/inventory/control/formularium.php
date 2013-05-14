<?php
set_time_zone();
if(isset ($_POST['add'])){
    
$tanggal = date2mysql($_POST['tanggal']);    
$obat = $_POST['obat'];
$user = User::$id_user;
$jumlahObat = count($obat);

if($jumlahObat > 0){
    $insert = _insert("insert into formularium values ('','$tanggal','$user')");
    $id = _last_id();

foreach ($obat as $key => $row){
    if($row != ""){
       $sql = "insert into detail_formularium values('','$id','$row')";
       $exe = _insert($sql); 
    }else $exe = false;
}
  header('location:'.  app_base_url('inventory/formularium').'?msg=1');
}else{
  header('location:'.  app_base_url('inventory/formularium').'?msr=3');  
}
}
?>
