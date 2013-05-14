<?
$instalasi = $_POST['instalasi'];
$select = _select_arr("select * from instalasi where nama='$instalasi'");
        $count = count($select);
        if($count > 0){
            header('location:'.  app_base_url('admisi/data-instalasi').'?msr=12');
        }else{
$sql = "insert into instalasi (nama) values ('$instalasi')";
$exe = _insert($sql);
  $id = _last_id();
if ($exe) {
    header("location: ".app_base_url('admisi/data-instalasi/')."?msg=1&code=$id");
}
}