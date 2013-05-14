<?php
	include_once "app/lib/common/master-data.php";
?>
<script type="text/javascript">
    $(function () {
        $('#bayar').keyup(function () {
            var sisa  = $('#sisa_bayar').val();
            var bayar = currencyToNumber($('#bayar').val());
            var kembali = bayar - sisa;
            if (!isNaN(kembali)) {
                if (sisa > bayar) {
                    $('#sisa_tagihan').html(numberToCurrency(kembali));
                    $('#kembali').html('-');
                } else if (sisa < bayar) {
                    $('#sisa_tagihan').html('-');
                    $('#kembali').html(numberToCurrency(kembali));
                } else {
                    $('#sisa_tagihan').html('-');
                    $('#kembali').html('-');
                }
            } else {
                $('#kembali').html('-');
                $('#sisa_tagihan').html('-');
            }
        })
        $('input[name=submit]').click(function() {
            if ($('#bayar').val() == "") {
                alert('Jumlah bayar tidak boleh kosong');
                $('#bayar').focus();
                return false;
            }
        })
    })
</script>
<div class="data-list">

<table class="tabel" id="tblPembelian" style="width:70%">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th style="width: 10%">No.Penjualan</th>
        <th>Jumlah Bayar(Rp.)</th>
        <th>Sisa Tagihan(Rp.)</th>
		
    </tr>
    <?php
    $no = 0;
    $count = NULL;
	$pembayaran_penjualan = pembayaran_penjualan_muat_data($_GET['nopenjualan']);
	//$billing = pasien_discharge_muat_data($_GET['norm']);
	$bayar_total = 0;
        $sisa_bayar = 0;
    foreach ($pembayaran_penjualan as $row) {

    if ($row['jumlah_bayar'] == 0) {
        $sisa = $row['total_tagihan'];
    } else {
        $sisa = $row['sisa'];
    }
    ?>
        <tr class="barang_tr <?=($no%2==1)?"odd":"even"?>">
            <td align="center"  class="listBarang"><?= ++$no ?></td>
            <td align="center"><?= $row['nopenjualan'] ?></td>
            <td align="right"><?= rupiah($row['jumlah_bayar']) ?></td>
            <td align="right"><?= rupiah($sisa) ?></td>
			
        </tr>
	
<?php 
	
	$bayar_total	= $row['jumlah_bayar'] + $bayar_total;
	$sisa_bayar	= $sisa;
	
	} ?>
	<tr class="total-sum"><td colspan="2">Total</td>
            <td align="right"><?= rupiah($bayar_total) ?></td><td align="right"><?= rupiah($sisa_bayar) ?>
            <input type="hidden" id="sisa_bayar" name="harus_dibayar" value="<?= $sisa_bayar ?>" /></td>
        </tr>
</table>

</div>
<?php
if ($sisa_bayar <= 0) {
    $disable = "disabled";
}
?>
<table style="width:100%">
    <tr><td style="width:78%">&nbsp;</td><td>Bayar</td><td>:</td><td><input style="width:100%" type="text" name="bayar" onkeyup="formatNumber(this)" class="right" id="bayar" <?= isset($disable)?$disable:null; ?> /></td></tr>
	<tr><td>&nbsp;</td><td>Sisa</td><td>:</td><td align="right" id="sisatagihan"><?= rupiah($sisa_bayar) ?></td></tr>
	<tr><td>&nbsp;</td><td>Kembali</td><td>:</td><td id="kembali" align="right"></td></tr>
        <tr><td>&nbsp;</td><td>Sisa Tagihan</td><td>:</td><td id="sisa_tagihan" align="right"></td></tr>
        <tr><td>&nbsp;</td><td></td><td></td><td>
                <input type="submit" name="submit" value="Simpan" class="tombol" <?= isset($disable)?$disable:null; ?> />
                <input type="button" value="Batal" onClick=location.href="<?= app_base_url('billing/pembayaran-penjualan') ?>" /></td></tr>
</table>

<? exit; ?>