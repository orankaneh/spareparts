<?php
 include_once "app/lib/common/master-data.php";
 $head = head_laporan_muat_data();
?>
<style type="text/css">
    .head-cetak{
        width: 600px;
        text-align: left;
        height:100px;
        padding-top: 15px;
    }
    #head-cetak-logo{
        height: 80px;
        padding-top: 15px;
    }
    #logo{
       height: 90%;
        float: left;
        width: 90px;
    }
    
</style>
<center>
<div class="head-cetak" >    
    <div id="logo">
       <img src="<?= app_base_url('assets/images/logo/').$head['gambar']?>"/>
    </div>
    <div id="head-cetak-logo">
        <?= $head['nama']?><br/>
        <?= $head['alamat']?>, <?= $head['kabupaten']?><br/>
        <?= "Telp: $head[telp], Fax: $head[fax]"?><br/>
        <?= "Email: $head[email]"?><br/>
        <?= "Website: $head[web]"?><br/>
    </div>
</div>    
</center>    
