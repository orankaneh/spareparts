<?php
$patientId = $_GET['idp'];
$sql = mysql_query("select p.id as id_pas, pd.*, dp.id , dp.* from penduduk pd join pasien p on (pd.id = p.id_penduduk) left join dinamis_penduduk dp on (dp.id_penduduk = pd.id) where p.id = '$patientId' and dp.akhir = 1 group by p.id order by pd.id desc");
$row = mysql_fetch_array($sql);

$almt= mysql_query("select ku.id as id_kel, ku.nama as nama_kel, kc.nama as nama_kec, k.nama as nama_kab, p.nama as nama_pro from provinsi p, kabupaten k, kecamatan kc, kelurahan ku where p.id = k.id_provinsi and k.id = kc.id_kabupaten and kc.id = ku.id_kecamatan and ku.id = '$row[id_kelurahan]'");
$rowQ= mysql_fetch_array($almt);
?>
<style type="text/css">

	@font-face{
		font-family: 'barcode';
		src:url('<?= app_base_url('/assets/fonts/free3of9-webfont.eot')?>');
		src:url('<?= app_base_url('/assets/fonts/free3of9-webfont.eot?#iefix')?>') format('embedded-opentype'),
		url('<?= app_base_url('/assets/fonts/free3of9-webfont.woff') ?>') format('woff'), 
		url('<?= app_base_url('/assets/fonts/free3of9-webfont.ttf') ?>') format('truetype'), 
		url('<?= app_base_url('/assets/fonts/free3of9-webfont.svg#barcodesvg') ?>') format('svg');    
	}
	
	.idnumber {font: 14px arial,tahoma; letter-spacing: 11px; color: #000}
    .wrapper{
        border: 1px solid silver;
        background: none;
        font: 11px Tahoma,arial,verdana,sans-serif;
        -moz-border-radius: 5px;
        width: 8.5cm;
        height: 5.5cm;
        color: whitesmoke;
    }
	
	.nama {font: 14px arial,tahoma; font-weight: bold; text-transform: uppercase; line-height: 30px}
    .header{
        font: 14px Arial,Tahoma,Verdana;
        font-weight: bold;
        text-align: center;
        padding: 5px;
        color: #000
    }
    .content{
        padding: 10px;
    }
    table td{
        padding: 5px;
        font-size: 8px;
        font-weight: bold;
    }
    .footer{
        -moz-border-radius-bottomleft: 5px;
        -moz-border-radius-bottomright: 5px;
    }
    .tombol {
    background: url(../assets/images/tile.jpg) repeat;
    font-weight: normal;
    font-size: 10px;
	padding: 2px 20px;
    border: 1px solid #cccccc;
    cursor: pointer;
    color: #ffffff;
    -moz-border-radius:3px;
    -webkit-border-radius: 3px;
	}
	label {
		display:block;
		color:#000;
		font-size:10px;
		padding-bottom:5px;

	}
</style>
<div class="wrapper">
<div class="header">Kartu Pasien</div>
<div class="content">    
<span class="idnumber"><?php echo $patientId?></span>
<label><span id="stikerBarcode" style="font-size: 48px;padding-top: 5px; font-family: 'barcode';"><?echo "$patientId";?></span></label>

<label><?php echo "<span class='nama'>$row[nama]</span><br>$row[alamat_jalan]<br>$rowQ[nama_kel]<br>Kec: $rowQ[nama_kec]<br>$rowQ[nama_kab]<br>Prov: $rowQ[nama_pro]";?></label>
</div>    
<div class="footer">&nbsp;</div>
</div>    
<p><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'></span></p>
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
<?php
exit;
?>

