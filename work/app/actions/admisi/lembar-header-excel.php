<?php
 include_once "app/lib/common/master-data.php";
 function head_excel($colspan){
     $head = head_laporan_muat_data();
     
     $data="
        <tr>    
        <td>".$head['nama']."</td>
          </tr>
          <tr>
            <td>".$head['alamat'].",".$head['kabupaten']."</td>
          </tr>
          <tr>
            <td>Telp: ".$head[telp].", Fax: ".$head[fax].", Email: ".$head[email].", Website: ".$head[web]."</td>
          </tr>         
    ";
     
     return $data;
 }
?>
 
  


