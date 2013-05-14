<?php
require_once "app/lib/common/functions.php";
set_time_zone();
?>
<html>
    <head>
        <title>Laporan</title>
   <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.css')?>">
        <script type="text/javascript" src="<?= app_base_url('/assets/js/jquery-1.4.2.min.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('a').attr('href','#');
                $(document).removeData('input');
            })
        </script>
         <script language='JavaScript'>
  	function cetak() {  		
  		SCETAK.innerHTML = '';
		window.print();
		if (confirm('Apakah menu print ini akan ditutup?')) {
			window.close();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
  	}
  
   </script>
    </head>
    <body>
   <? require_once 'app/actions/admisi/lembar-header.php';?>
        <?include_once "app/actions/admisi/informasi/per-pivot-return.php";?>
        <center>
      <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
    </center>
    </body>
</html>

<?php
exit;
