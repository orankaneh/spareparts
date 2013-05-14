<style type="text/css">
    *{
        font-size:12px;
    }
    div{
        font-family: arial;
        
    }
    table{
        margin-top: 10px;
        border-top: 1px solid #000000;
        border-left: 1px solid #000000;
    }
    
   td,th{
        padding: 2px;       
        border-bottom: 1px solid #000000;
        border-right: 1px solid #000000;
    }
    
    td.noborder{
        border-right: 0;
    }
</style>
<?php
    require_once 'app/config/db.php';
    require_once 'app/lib/common/master-inventory.php';
    require_once 'app/lib/common/functions.php';
    require_once 'app/lib/common/master-data.php';
    $penjualan = detail_penjualan_muat_data($_GET['id']);   
?>

	<? require_once 'app/actions/admisi/lembar-header.php'; ?>
<br/>
        <center><span style='width:100%;'>INFORMASI PENJUALAN</span></center>
<div class="body-nota">
	<table width='100%' cellpadding="0" cellspacing="0">
               <tr>
                <th>No Nota</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga Jual</th>
               </tr> 
               <?php
                foreach($penjualan as $row){
                    echo "
                        <tr><td>$row[id]</td>
                            <td>".datefmysql($row['tanggal'])."</td>
                            <td>$row[barang] $row[nilai_konversi] $row[satuan]</td>
                            <td>$row[jumlah_penjualan]</td>
                            <td>".rupiah($row['hna'])."</td>
                        </tr>
                    ";
                }
               ?>
	</table>
</div>
        <br/>
<span id="SCETAK"><input type="button" class="tombol" value="Cetak" onClick="cetak()"/></span>
<script type="text/javascript">
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
die;
?>