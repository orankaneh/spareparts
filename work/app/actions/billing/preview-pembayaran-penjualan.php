<?php
require_once 'app/config/db.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

$pembayaran = pembayaran_penjualan_muat_data($_GET['id']);
$pembayarans= pembayaran_penjualan_muat_data($_GET['id']);
foreach ($pembayaran as $row);
?>
<h2 class="judul">Pembayaran Penjualan</h2>
<div style="margin: 5px 0px;">
    <span class="cetak" id="nota">Cetak Nota</span>

</div>
<fieldset><legend>Detail Pembeli</legend>
	<table width=50%>
                <tr><td width="26%">Nomor Penjualan</td><td width="0%">:</td><td width="74%"><?= $_GET['id'] ?></td></tr>
		<tr><td width="26%">Pembeli</td><td width="0%">:</td><td width="74%"><?= $row['nama'] ?></td></tr>
                <tr><td width="26%">Total Tagihan</td><td width="0%">:</td><td width="74%"><?= rupiah($row['total_tagihan']) ?></td></tr>
                <tr><td width="26%">Tanggal Penjualan</td><td>:</td><td><?= $row['waktu'] ?></td></tr>
	</table>
</fieldset>
<div class="data-list">
    <fieldset><legend>Detail Pembayaran Penjualan</legend>
	<table width=100% class="tabel" cellspacing="0">
            <tr>
                <th width="5%">No</th>
                <th width="10">Tanggal Bayar</th>
                <th width="40%">Pegawai</th>
                <th width="10%">Jumlah Bayar(Rp.)</th>
                <th width="10%">Sisa Tagihan(Rp.)</th>
            </tr>
	<?php
	$total = 0;
	foreach($pembayarans as $key => $rows): ?>
		<tr class="<?= ($key%2)?'odd':'even' ?>">
                    <td align="center"><?= ++$key ?></td>
                    <td><?= $rows['waktu'] ?></td><td><?= $rows['petugas'] ?></td>
                    <td align="right"><?= rupiah($rows['jumlah_bayar']) ?></td><td align="right"><?= rupiah($rows['sisa']) ?></td>
		</tr>

	<?php
	$total = $total + $rows['jumlah_bayar'];
        $sisa  = $rows['sisa'];
	endforeach; ?>
                <tr><td colspan="3" align="center">TOTAL</td><td align="right"><?= rupiah($total) ?></td><td align="right"><?= rupiah($sisa) ?></td></tr>
	</table>

	<table width=100% style="border:none">
		
		<tr><td></td><td></td><td align="right">&nbsp;</td></tr>
		<tr><td></td><td></td><td align="right"><?= $_SESSION['nama'] ?><br/>PETUGAS</td></tr>
	</table>

        </fieldset>
</div>
<script type="text/javascript">
	$(function(){
            $("#nota").click(function(){
                    var win = window.open('report/pembayaran-penjualan?id=<?= $_GET['id'] ?>', 'MyWindow', 'width=500px, height=500px, scrollbars=1');
            })
        })
</script>