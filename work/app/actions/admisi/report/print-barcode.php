

<?php
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
$idPacking = $_GET['idPacking'];
$jumlah = $_GET['jumlah'];

$sql = "select * from packing_barang where id='$idPacking'";
$data = _select_unique_result($sql);
if($data['barcode'] == ""){
    $barcode = $data['id'];
}else $barcode = $data['barcode'];
?>
<html>
  <head>
      <title>Cetak Barcode</title>
      <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/barcode.css') ?>" />
      <script type="text/javascript">
          function cetak() {  		
  		SCETAK.innerHTML = '';
		window.print();
		if (confirm('Apakah menu print ini akan ditutup?')) {
                    show_form2();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
  	}
      </script>    
  </head>  
  <body>
	  <div style="width: 200px;margin: 5px 20px">
      <table>
      <?
        for($i=strlen($barcode);$i<11;$i++){
            $barcode="0".$barcode;
        }
        for($i=1;$i<=$jumlah;$i++){
       ?>     
            <tr>
              <td align="center">
                <span style="font-size: 40px;font-family: 'barcode';">*<?= $barcode?>*</span><br>
                <span style="letter-spacing:10px; font: 15px arial,tahoma; line-height: 18px"><?= "&nbsp".$barcode?></span><br>
                <span style="font: 10px 'consolas',arial,tahoma; line-height: 10px"><?= $_GET['barang']?></span>
              <td>
            </tr>
      <?      
        }
      ?>
      </table>   
	  </div>
      <p><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'></span></p>
  </body>    
</html>    
<?
exit();
?>
