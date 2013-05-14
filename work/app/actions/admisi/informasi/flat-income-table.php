<?php
function getFlatIncomeTable($awal,$akhir){
        require_once "app/lib/common/master-data.php";
        ob_start();
	set_time_zone();
	if (strtotime($akhir) < strtotime($awal)) {
		echo json_encode(array('error' => 'Tanggal akhir harus lebih besar dari tanggal awal'));
		exit;
	}
        $datas=pendapatan_pelayanan_muat_date($awal, $akhir);
		
        $content="";
	$content.= "<div class='data-list'>
	<center>LAPORAN UNIT ADMISI REKAP PENDAPATAN PENDAFTARAN <br>
	PERIODE: ".indo_tgl($_GET['awal'])." s. d ".indo_tgl($_GET['akhir'])."</center>
	<table cellpadding='0' cellspacing='0' border='0' id='table' class='tabel'>
		
			<tr>
				<th><h3>No</h3></th>
				<th><h3>Item Pendapatan</h3></th>
				<th style='text-align:center;'><h3>Jumlah</h3></th>
				<th><h3>Total Pendapatan (Rp.)</h3></th>
			</tr><tbody>";
	$no = 1;
        $jumlah['jumlah']=0;
        $jumlah['total']=0;
        foreach ($datas as $row){
            $content.= "<tr class='";
            if ($no % 2 == 0) $content.= "odd"; else $content.= "even";
            $content.= "'>
				<td align=center>$no</td>
				<td>$row[nama]</td>
				<td align=right>".rupiah($row['total'])."</td>
				<td align=right>".rupiah($row['total'])."</td>
		</tr>";
            //$jumlah['jumlah']+=$row['jumlah'];
            $jumlah['total']+=$row['total'];
            $no++;
        }
        $content.="<tr align=center class='total'><td colspan=2>JUMLAH</td><td align=right>".rupiah($jumlah['total'])."</td><td align=right>".rupiah2($jumlah['total'])."</td></tr>";
        $content.= "</tbody>";
	$content.="</table>";
        return $content;
}
?>
