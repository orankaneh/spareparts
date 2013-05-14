<?php
/*************************************************************************
* -> Edit Pembelian
* -> Created by Fahmi Auliya Tsani
*************************************************************************/

set_time_zone();
include_once "app/lib/common/master-data.php";
require_once 'app/lib/common/master-inventory.php';
include 'app/actions/admisi/pesan.php';
$pembelian	= pembelian_muat_data_by_id($_GET['id']);
//show_array($pembelian);
$barang = barang_muat_data_by_id_beli($_GET['id']);
?>
<script type="text/javascript">
	var id = <?php echo $pembelian['id']; ?>;
	$.ajax(
	{
		url: "<?php echo app_base_url('inventory/pembelian-barang-table') ?>",
		cache: false,
		data:'&id='+id+'&do=edit',
		success: function(msg){
					$('#tabel-barang').html(msg);
					initTanggal();
                                        $('.materai').trigger('blur');
					//$('#tabel-barang').html($('#temp').html());
				}
	});
    function getPPN(){
        var ppn=$("input[name=ppn]").attr('value')*1;
        if(ppn==''||ppn==null||isNaN(ppn))
            ppn=0;
        return ppn;
    }
</script>


<form action="<?php echo app_base_url('inventory/control/pembelian-update'); ?>" method="post">
	<h2 class="judul">Edit Pembelian</h2>
	<?php echo isset($pesan) ? $pesan : NULL; ?>
	<div class="data-input">
		<fieldset>
			<legend>Pembelian Barang</legend>
			<label for="nosp">No. SP*</label><input type="text" name="nosp" id="nosp" maxlength="11" value="<?php echo $pembelian['id']; ?>" readonly="readonly" />
            <input type="hidden" name="tanggalPemesanan" id="tanggalPemesanan" readonly="readonly" />
            <label for="suplier">Suplier</label><input type="text" name="suplier" id="suplier" value="<?php echo $pembelian['suplier']; ?>" disabled="disabled" />
			<input type="hidden" name="idsuplier" value="<?php echo $pembelian['idSuplier']; ?>" id="idSuplier" />
            <label for="nofaktur">No. Faktur*</label><input type="text" value="<?php echo $pembelian['no_faktur']; ?>" name="nofaktur" id="nofaktur" disabled="disabled" onblur="return cekFaktur()" maxlength="11"/>
            <label for="tanggal">Tanggal*</label><input type="text" name="tanggal" id="awal" disabled="disabled" value="<?php echo datefmysql($pembelian['waktu']); ?>" maxlength="11"/>
            <label for="ppn">PPN (%)</label><input type="text" name="ppn" onkeyup='Desimal(this)' value="<?php echo $pembelian['ppn']; ?>" class="mini ppn right" maxlength="5" />
            <label for="materai">Biaya Materai</label><input type="text" name="materai" value="<?php echo inttocur($pembelian['materai']); ?>" class="materai right" onKeyup="formatNumber(this)" maxlength="11"/>
            <label for="tempo">Tanggal Jatuh Tempo*</label><input type="text" value="<?php echo datefmysql($pembelian['tanggal_jatuh_tempo']); ?>" name="tempo" id="akhir" maxlength="11"/>
		</fieldset>
	</div>
		<div id="tabel-barang">

		</div>
		<div class="field-group" id="btn-group" style="clear:left">
			<input type="submit" value="Simpan" name="save" class="tombol" />
			<input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?php echo app_base_url('inventory/pembelian') ?>'" />
		</div>
	
</form>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('#materai').keyup(function()
		{
			var materai = $('#materai').val();
			$('.materai').val(materai);
		});
	});
		function initTanggal()
		{
			$('.tanggal').datepicker(
			{
				changeMonth: true,
				changeYear: true
			});
		}
</script>
<div id="temp">
</div>