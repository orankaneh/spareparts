<?php
if (isset($_POST['save']))
{
	$id			= $_POST['nosp'];
	$ppn		= $_POST['ppn'];
	$materai	= str_ireplace(".", "", $_POST['materai']);
	$jatuhTempo = date2mysql($_POST['tempo']);
	$sql1		= mysql_query("
					UPDATE pembelian
					SET
						ppn		= $ppn,
						materai = $materai,
						tanggal_jatuh_tempo = '$jatuhTempo'
					WHERE
						id = $id
				") or die(mysql_error());
	echo $jatuhTempo;
	$barang		= $_POST['barang'];
	$max		= count($barang);
	for ($i = 1; $i <= $max; $i++)
	{
		$id		= $barang[$i]['id_beli'];
		$batch	= $barang[$i]['no_batch'];
		$ed		= date2mysql2($barang[$i]['ed']);
		$jumlah	= $barang[$i]['jumlah'];
		$harga1	= str_ireplace(".", "", $barang[$i]['harga']);
		$harga	= str_ireplace(",", ".", $harga1);
		$diskon	= $barang[$i]['diskon'];
		echo '<br />'.$diskon;
		$sql2	= mysql_query("
					UPDATE detail_pembelian
					SET
						batch = '$batch',
						harga_pembelian = $harga,
						diskon	= $diskon,
						jumlah_pembelian = $jumlah
					WHERE
						id = $id
				") or die(mysql_error());
	}
}
header('location:'.  app_base_url('inventory/pembelian-edit?msg=1')."&id=$_POST[nosp]");		 
?>