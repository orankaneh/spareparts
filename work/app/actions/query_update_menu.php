<?php
$sql=_select_arr("select * from privileges");
foreach($sql as $row){
    echo "update privileges set icon='$row[icon]' where url='$row[url]';<br>";
}
?>
