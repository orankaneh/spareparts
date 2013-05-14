<?php
$formatLR = format_labarugi_muat_data();
?>
<script type="text/javascript">
	
	function hapuspenj(el){
		var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
		 var tr=$('.t_penj');
        var countTr=tr.length;
        for(var i=1;i<=countTr;i++){
            $('.t_penj:eq('+i+')').removeClass('even');
            $('.t_penj:eq('+i+')').addClass('even');
			$('.t_penj:eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.tj').attr('id','tj'+(i+1));
			$('.t_penj:eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.hideauto').attr('id','id_penjumlah'+(i+1));
			initAutocomplete(i,'tj','id_penjumlah',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
        }
	}
	
	function hapuspeng(el){
		var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
		 var tr=$('.t_peng');
        var countTr=tr.length;
        for(var i=1;i<=countTr;i++){
            $('.t_peng:eq('+i+')').removeClass('even');
            $('.t_peng:eq('+i+')').addClass('even');
			$('.t_peng:eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.tk').attr('id','tk'+(i+1));
			$('.t_peng:eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.hideauto').attr('id','id_pengurang'+(i+1));
			initAutocomplete(i,'tj','id_pengurang',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
        }
	}
	
	function add(a){
		var rekPenjumlah = $('.tj').length+1;
		var rekPengurang = $('.tk').length+1;
		if(a=='rekening_penjumlah'){
			var str = "<tr class='even t_penj' ><td width='50%'><dd>- <input type='text' name='t_rekpenjumlah[]' id='tj"+rekPenjumlah+"' class='tj'> <input class='hideauto' type='hidden' name='id_rekpenjumlah[]' id='id_penjumlah"+rekPenjumlah+"'> </dd></td><td width='20%'></td ><td>Rp XXX.XXX</td><td width='10%'><a href='#' class='delete' onClick='hapuspenj(this)'>delete</a></td></tr>";
			$("#"+a).append(str);
			initAutocomplete(rekPenjumlah,'tj','id_penjumlah',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
		}else{
			var str = "<tr class='even' t_peng><td width='50%'><dd>- <input type='text' name='t_rekpengurang[]' id='tk"+rekPengurang+"' class='tk'> <input class='hideauto' type='hidden' name='id_rekpengurang[]' id='id_pengurang"+rekPengurang+"'> </dd></td><td width='20%'>Rp YYY.YYY</td ><td width='20%'></td><td width='10%'><a href='#' class='delete' onClick='hapuspeng(this)'>delete</a></td></tr>";
			$("#"+a).append(str);
			initAutocomplete(rekPengurang,'tk','id_pengurang',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
		}
	}
</script>
<div style='clear: both'>
   <div class="data-list w700px">
        <div class="floleft">
            <a href="#" class="add" onClick="add('rekening_penjumlah')"><div class="icon button-add"></div>Tambah Penjumlah</a>
            <a href="#" class="add" onClick="add('rekening_pengurang')"><div class="icon button-add"></div>Tambah Pengurang</a>
        </div>
    </div> 
</div>

<div class='data-list w700px'>
	<form action='<?php echo app_base_url('akuntansi/control/formatlaporan/add');?>' method='post' name='fLabarugi' id='fLabarugi'>
	<fieldset><legend>Format Laporan Labarugi</legend>
		<table id='rekening_penjumlah' class='data-list w700px' style='padding: 0x 0px 0px 0px' >
			<dl>
				<tr>
					<td colspan="4"><dt><b>Penjumlah</b></dt></td>
				</tr>
				<tr class='even'>
					<td width="50%"><dd>- Pendapatan</dd></td><td width="20%"></td><td width="20%">Rp XXX.XXX</td><td width='10%'></td>
				</tr>
				<?php
					$penjLR = 1;
					foreach($formatLR['penjumlah'] as $data){
					?>
					<tr class='even t_penj' ><td width='50%'><dd>- <input type='text' name='t_rekpenjumlah[]' id="<?php echo 'tj'.$penjLR ;?>"  class='tj' value="<?php echo $data['nama'];?>"> <input class='hideauto' type='hidden' name='id_rekpenjumlah[]' id="<?php echo 'id_penjumlah'.$penjLR;?>" value="<?php echo $data['id'];?>"> </dd></td><td width='20%'></td><td width='20%'>Rp XXX.XXX</td><td width='10%'><a href='#' class='delete' onClick='hapuspenj(this)'>delete</a></td></tr>
					<script>
						initAutocomplete('<?php echo $penjLR ;?>','tj','id_penjumlah',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
					</script>
				<?php
					$penjLR++;
					}
				?>
			</dl>
		</table>	
		<table id='rekening_pengurang' class='data-list w700px' style='padding: 0px 0px 0px 0px'>
			<dl >
				<tr>
					<td colspan="4"><dt><b>Pengurang</b></dt></td>
				</tr>
				<tr class='even'>
					<td width="50%"><dd>- Beban</dd></td><td width="20%">Rp YYY.YYY</td><td width="20%"></td><td width='10%'></td>
				</tr>
				<tr class='even'>
					<td width="50%"><dd>- Pajak</dd></td><td width="20%">Rp YYY.YYY</td><td width="20%"></td><td width='10%'></td>
				</tr>
				<?php
					$penjLR = 1;
					foreach($formatLR['pengurang'] as $data){
					?>
					<tr class='even' t_peng><td width='50%'><dd>- <input type='text' name='t_rekpengurang[]' id="<?php echo 'tk'.$penjLR ;?>" class='tk' value="<?php echo $data['nama'];?>" > <input class='hideauto' type='hidden' name='id_rekpengurang[]' id="<?php echo 'id_pengurang'.$penjLR;?>" value="<?php echo $data['id'];?>"> </dd></td><td width='20%'>Rp YYY.YYY</td ><td width='20%'></td><td width='10%'><a href='#' class='delete' onClick='hapuspeng(this)'>delete</a></td></tr>
					<script>
						initAutocomplete('<?php echo $penjLR ;?>','tk','id_pengurang',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
					</script>
				<?php
					$penjLR++;
					}
				?>
			</dl>
		</table>	
		<table class='data-list w700px' style='padding: 0px 0px 0px 0px' >
			<dl >
				<tr class='even'>
					<td width="50%"><dd></dd></td><td width="20%"></td><td width="20%">Rp YYY.YYY<br>__________&nbsp;-</td><td width='10%'></td>
				</tr>
				<tr class='even'>
					<td width="50%"><dd><b>Laba /Rugi Bersih</b></dd></td><td width="20%"></td><td width="20%">Rp ZZZ.ZZZ</td><td width='10%'></td>
				</tr>
			</dl>
		</table>	
	</fieldset>
		<input type='submit' name="formatLR" value='Simpan' class="stylebutton">
		<a href="<?php echo app_base_url('akuntansi/master-format-laporan-keuangan?tab=lr');?> "><input type='button' name="cancel" value='Batal' class="stylebutton"></a>
	</form>
</div>