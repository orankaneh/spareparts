<style>
body {margin: 0 30px; padding: 0; font-family: "Consolas","Fixedsys",arial !important;}
td { font-size: 12px !important}
.tabel-judul {border-top: 1px dotted #666; border-bottom: 1px dotted #666; width: 700px; margin: 20px 0}
.head-cetak-instansi {font-size: 22px; font-family: "Arial Narrow",tahoma; font-weight: 800}
</style>

<?php
echo "
<html>
<head>
  <title>Lembar Poliklinik</title>
  <link rel='stylesheet' type='text/css' href='".app_base_url('/assets/css/base.css')."'>
</head>
<body><center>
<div style='margin-left:65px'>
";
require_once 'app/actions/admisi/lembar-header.php';
?>
</div>
</center><br><table class="contain2" border="0" cellpadding="0" cellspacing="0" width="600px">
    <tr align="center">
        <td width="10%">Tanggal &amp; Jam</td><td>Anamnesis &amp; pemeriksaan</td><td>Diagnosis &amp; Therapi</td><td>ICD</td><td width="15%">Dokter</td>
    </tr>
    <tr>
        <td height="500">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
    </tr>
</table>
<?
echo"        <center>
          <p><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'></span></p>
        </center>
</body>
</html>";?>

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
<?
exit;
?>
