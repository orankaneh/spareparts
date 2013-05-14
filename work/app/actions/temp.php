<?php
$sql=_select_arr("select * from privileges");
foreach($sql as $row){
    echo "\$exce=_update(\"update privileges set icon='$row[icon]' where url='$row[url]'\");<br>";
    echo "\$count=_select_unique_result(\"select count(*) as jumlah from privileges where url='$row[url]' \");<br>";
    echo "if(\$count['jumlah']==0){<br>
        _insert(\"insert into privileges (icon,id_module,status_module,nama,url) values <br>
            ('$row[icon]','$row[id_module]','$row[status_module]','$row[nama]','$row[url]')\");<br><br>
    }";
}
?>
