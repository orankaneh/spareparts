<?php
require_once 'app/lib/common/master-akuntansi.php';
require_once 'app/config/db.php';

$bulan=isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahun=isset($_GET['tahun'])?$_GET['tahun']:date('Y');
$jmlHari=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); 
	

set_time_zone();

$profil = profile_rumah_sakit_muat_data();
$namaFile = "neraca-saldo_".$bulan."-".$tahun.".xls";

// header file excel

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,
        pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

// header untuk nama file
header("Content-Disposition: attachment;
        filename=".$namaFile."");

header("Content-Transfer-Encoding: binary ");

?>

<center><h2 style="padding: 0; margin: 0">NERACA SALDO<br><?= $profil['nama'] ?></h2>
Periode 1 -<?php echo $jmlHari." ".bulan($bulan)." ".$tahun; ?></center><br>
<?php
$neraca=neracasaldo_muatdata($bulan,$tahun);
?>
<center>
<table border=1 width=1200>
        <tr>
            <th width="4%" rowspan="2">No</th>
            <th width="18%" rowspan="2">Rekening / No</th>

			<th width="39%" colspan="2">Sebelum Disesuaikan</th>
			<th width="39%" colspan="2">Penyesuaian</th>
			<th width="39%" colspan="2">Setelah Disesuaikan</th>
        </tr>
        <tr>
            <th width="13%">Debet</th>
            <th width="13%">Kredit</th>
			<th width="13%">Debit</th>
			<th width="13%">Kredit</th>
			<th width="13%">Debit</th>
			<th width="13%">Kredit</th>
			</tr>
        <?php
        $no=1;
		$saldo_debet=0;
		$saldo_kredit=0;
		$saldo_penyesuaian_debet=0;
		$saldo_penyesuaian_kredit=0;
        foreach ($neraca as $key => $row) { ?>
        <tr class="<?= ($key%2)?'odd':'even' ?>" id="<?=$row['id']; ?>">
            <td align="center"><?php echo $no ?></td>
            <td><?php echo $row['nama']." / ".$row['kode']; ?></td>
           <?php 
			// Sebelum Penyesuaian
			
			if ($row['status']==1) {
				/*if ($row['jumlah'] < 0) {
					echo "<td></td>";
					echo "<td align='right'>".rupiahplus(abs($row['jumlah']))."</td>";
				} else {*/
					echo "<td align='right'>",rupiah($row['jumlah'])."</td>";
					echo "<td></td>";
				/*}*/
				$saldo_debet+=$row['jumlah'];
			} else {
				/*if ($row['jumlah'] < 0) {
					echo "<td align='right'>",rupiahplus(abs($row['jumlah']))."</td>";
					echo "<td></td>";
				} else {*/
					echo "<td></td>";
					echo "<td align='right'>",rupiah($row['jumlah'])."</td>";
				/*}*/
				$saldo_kredit+=$row['jumlah'];
			}
			
			// Penyesuaian
			
			if ($row['status']==1) {
				if ($row['jumlah_disesuaikan'] < 0) {
					echo "<td></td>";
					echo "<td align='right'>";
					echo (!empty($row['jumlah_disesuaikan']))?rupiah(abs($row['jumlah_disesuaikan'])):Null;
					echo "</td>";
				} else {
					echo "<td align='right'>";
					echo (!empty($row['jumlah_disesuaikan']))?rupiah($row['jumlah_disesuaikan']):Null;
					echo "</td>";
					echo "<td></td>";
				}
			} else {
				if ($row['jumlah_disesuaikan'] < 0) {
					echo "<td align='right'>";
					echo (!empty($row['jumlah_disesuaikan']))?rupiah(abs($row['jumlah_disesuaikan'])):Null;
					echo "</td>";
					echo "<td></td>";
				} else {
					echo "<td></td>";
					echo "<td align='right'>";
					echo (!empty($row['jumlah_disesuaikan']))?rupiah($row['jumlah_disesuaikan']):Null;
					echo "</td>";
				}
			}

			
			// Setelah Penyesuaian
			
			
			if ($row['status']==1) {
				
				/*if ($row['jumlah_akhir'] < 0) {
					echo "<td></td>";
					echo "<td align='right'>";
					echo !empty($row['jumlah_akhir'])?rupiahplus(abs($row['jumlah_akhir'])):Null;
					echo "</td>";
				} else {*/
					echo "<td align='right'>";
					echo !empty($row['jumlah_akhir'])?rupiah($row['jumlah_akhir']):Null;
					echo "</td>";
					echo "<td></td>";
				/*}*/
				$saldo_penyesuaian_debet+=$row['jumlah_akhir'];
			} else {
				/*if ($row['jumlah_akhir'] < 0) {
					echo "<td align='right'>";
					echo !empty($row['jumlah_akhir'])?rupiahplus(abs($row['jumlah_akhir'])):Null;
					echo "</td>";
					echo "<td></td>";
				} else {*/
					echo "<td></td>";
					echo "<td align='right'>";
					echo !empty($row['jumlah_akhir'])?rupiah($row['jumlah_akhir']):Null;
					echo "</td>";
				/*}*/
				$saldo_penyesuaian_kredit+=$row['jumlah_akhir'];
			} ?>
        </tr>
        <?php
		$no+=1;
		}
        ?>
		<tr>
			<td colspan=2 align="right"><b>TOTAL SALDO</b></td>
			<td align="right"><b><?php echo rupiah($saldo_debet); ?></b></td>
			<td align="right"><b><?php echo rupiah($saldo_kredit); ?></b></td>
			<td width=150 align='center'>-</td>
			<td width=150 align='center'>-</td>
			<td align="right"><b><?php echo rupiah($saldo_penyesuaian_debet); ?></b></td>
			<td align="right"><b><?php echo rupiah($saldo_penyesuaian_kredit); ?></b></td>
		</tr>
    </table></center>


<?php exit(); ?>