<?php
require_once 'app/lib/common/master-data.php';
$norm = isset($_GET['noRm'])?$_GET['noRm']:NULL;
$noBilling = isset($_GET['noBilling'])?$_GET['noBilling']:NULL;

 if ($noBilling  != '') {
echo "<span class='cetak' id='nota'>Cetak Kitir</span>";
}
  ?>
<div class="data-list">
        <table width="100%" class="tabel" cellspacing=0>

            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Waktu</th>
                <th style="width: 30%">Nama Tarif</th>
                <th style="width: 15%">Harga @</th>
                <th style="width: 7%">Frekuensi</th>
                <th style="width: 15%">Subtotal (Rp.)</th>
            </tr>

<?php
    $total = 0;
    if ($norm != '') {
        $billing = informasi_billing_muat_data($norm);
        foreach ($billing as $num => $row):
            $total = $row['subtotal'] + $total;
            $bobot=($row['bobot'] == 'Tanpa Bobot')?"":$row['bobot'];
            $profesi=($row['profesi'] == 'Tanpa Profesi')?"":$row['profesi'];
            $spesialisasi=($row['spesialisasi'] == 'Tanpa Spesialisasi')?"":$row['spesialisasi'];
            $layanans=($row['jenis'] == "Rawat Inap" && $row['id_instalasi']<>9)?"$row[layanan] $row[instalasi]":$row['layanan'];
            $layanan = "$layanans $bobot $profesi $spesialisasi ";
            $layanan.=($row['id_kelas']!='1')?" ".$row['kelas']:'';
?>
            <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td align="center"><?= datefmysql($row['tanggal']) . " " . $row['waktu'] ?></td>
                <td align="left"><?= $layanan ?></td>
                <td align="right"><?= rupiah($row['harga']) ?></td>
                <td align="center"><?= $row['frekuensi'] ?></td>
                <td align="right"><?= rupiah($row['subtotal']) ?></td>
            </tr>
<?php endforeach; ?>
<?php } ?>
        </table>
        <div class="perpage" style="margin-top: 5px">
            Total : <? echo "Rp. " . rupiah($total) . ",00"; ?>
        </div>
    </div>
    <script type="text/javascript">
	$(function(){
		$("#nota").click(function(){
                    var win = window.open('print/nota-billing?id='+$('#noBilling').val()+'&cara='+$('#bayar').val()+'&idKunjungan='+$('#idKunjungan').val(), 'MyWindow', 'width=600px, height=500px, scrollbars=1');
		})
	})
</script>
<?php
exit;
?>
