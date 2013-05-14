<?php
$formatN = format_neraca_muat_data();
?>
<script type="text/javascript">
	function hapuspenjn(el,le){
		var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
		 var tr=$('.t_penj'+le);
        var countTr=tr.length;
        for(var i=1;i<=countTr;i++){
            $('.t_penj'+le+':eq('+i+')').removeClass('even');
            $('.t_penj'+le+':eq('+i+')').addClass('even');
			$('.t_penj'+le+':eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.tj'+le).attr('id','tj'+le+(i+1));
			$('.t_penj'+le+':eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.hideauto').attr('id','id_penjumlah'+le+(i+1));
			initAutocomplete(i,'tj'+le,'id_penjumlah'+le,"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
        }
	}
	
	function hapuspengn(el,le){
		var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
		 var tr=$('.t_peng'+le);
        var countTr=tr.length;
        for(var i=1;i<=countTr;i++){
            $('.t_peng'+le+':eq('+i+')').removeClass('even');
            $('.t_peng'+le+':eq('+i+')').addClass('even');
			$('.t_peng'+le+':eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.tk'+le).attr('id','tk'+le+(i+1));
			$('.t_peng'+le+':eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.hideauto').attr('id','id_pengurang'+le+(i+1));
			initAutocomplete(i,'tk'+le,'id_pengurang'+le,"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
        }
	}
	function addn(a,b){
		var rekPenjumlah = $('.tj'+b).length+1;
		var rekPengurang = $('.tk'+b).length+1;
		if(a=='rekening_penjumlah'){
			var str = "<tr class='even t_penj"+b+"' ><td width='300px'><dd>- <input type='text' name='t_rekpenjumlah"+b+"[]' id='tj"+b+rekPenjumlah+"'  class='tj"+b+"'> <input class='hideauto' type='hidden' name='id_rekpenjumlah"+b+"[]' id='id_penjumlah"+b+""+rekPenjumlah+"'> </dd></td><td width='125px'></td><td width='125px'>Rp XXX</td><td width='50px'><a href='#' class='delete' onClick=\"hapuspenjn(this,\'"+b+"\')\">delete</a></td></tr>";
			$("#"+a+b).append(str);
			initAutocomplete(rekPenjumlah,'tj'+b,'id_penjumlah'+b,"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
		}else{
			var str = "<tr class='even t_peng"+b+"' ><td width='300px'><dd>- <input type='text' name='t_rekpengurang"+b+"[]' id='tk"+b+rekPengurang+"'  class='tk"+b+"'> <input class='hideauto' type='hidden' name='id_rekpengurang"+b+"[]' id='id_pengurang"+b+""+rekPengurang+"'> </dd></td><td width='125px'>Rp YYY</td><td width='125px'></td><td width='50px'><a href='#' class='delete' onClick=\"hapuspengn(this,\'"+b+"\')\">delete</a></td></tr>";
			$("#"+a+b).append(str);
			initAutocomplete(rekPengurang,'tk'+b,'id_pengurang'+b,"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
		}
	}
</script>
<div class='data-list '>
	<form action='<?php echo app_base_url('akuntansi/control/formatlaporan/add');?>' method='post' name='fNeraca' id='fNeraca'>
	<fieldset><legend>Format Neraca</legend>
		<table class="data-list " style="width:1200px;">
		<tr>
		<td>
		<fieldset style="width:600px;">
		<div style='clear: both'>
		   <div class="data-list " style="width:600px;">
				<div class="floleft">
					<a href="#" class="add" onClick="addn('rekening_penjumlah','kiri')"><div class="icon button-add"></div>Tambah Penjumlah</a>
					<a href="#" class="add" onClick="addn('rekening_pengurang','kiri')"><div class="icon button-add"></div>Tambah Pengurang</a>
				</div>
			</div> 
		</div>
		<legend>Kiri</legend>
		<table id='rekening_penjumlahkiri' class='data-list ' style='padding: 0x 0px 0px 0px' style="width:600px;">
				<tr>
					<td colspan="4"><dt><b>Penjumlah</b></dt></td>
				</tr>
				<tr class='even'>
					<td width="300px"><dd>- Kas</dd></td><td width='125px'></td><td width="125px">Rp XXX</td><td width='50px'></td>
				</tr>
				<tr class='even'>
					<td width="300px"><dd>- Piutang Usaha</dd></td><td width='125px'></td><td width="125px">Rp XXX</td><td width='50px'></td>
				</tr>
				<tr class='even'>
					<td width="300px"><dd>- Bangunan</dd></td><td width='125px'></td><td width="125px">Rp XXX</td><td width='50px'></td>
				</tr>
				<?php
					$penjNkiri = 1;
					foreach($formatN['penjumlah_kiri'] as $data){
					?>
					<tr class='even t_penjkiri' ><td width='300px'><dd>- <input type='text' name='t_rekpenjumlahkiri[]' id="<?php echo 'tjkiri'.$penjNkiri;?>" class="tjkiri" value="<?php echo $data['nama'];?>"> <input class='hideauto' type='hidden' name='id_rekpenjumlahkiri[]' id="<?php echo 'id_penjumlahkiri'.$penjNkiri;?>" value="<?php echo $data['id'];?>"> </dd></td><td width='125px'></td><td width='125px'>Rp XXX</td><td width='50px'><a href='#' class='delete' onClick="hapuspenjn(this,'kiri')">delete</a></td></tr>
					<script>
						initAutocomplete('<?php echo $penjNkiri ;?>','tjkiri','id_penjumlahkiri',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
					</script>
				<?php
					$penjNkiri++;
					}
				?>
		</table>	
		<table id='rekening_pengurangkiri' class='data-list ' style='padding: 0x 0px 0px 0px' style="width:600px;">
				<tr>
					<td colspan="4"><dt><b>Pengurang</b></dt></td>
				</tr>
				<tr class='even'>
					<td width="300px"><dd>- Akumulasi Penyusutan</dd></td><td width="125px">Rp YYY</td><td width='125px'></td><td width='50px'></td>
				</tr>
					<?php
					$penjNkiri = 1;
					foreach($formatN['pengurang_kiri'] as $data){
					?>
					<tr class='even t_pengkiri' ><td width='300px'><dd>- <input type='text' name='t_rekpengurangkiri[]' id="<?php echo 'tkkiri'.$penjNkiri;?>" class="tkkiri" value="<?php echo $data['nama'];?>"> <input class='hideauto' type='hidden' name='id_rekpengurangkiri[]' id="<?php echo 'id_pengurangkiri'.$penjNkiri;?>" value="<?php echo $data['id'];?>"> </dd></td><td width='125px'>Rp YYY</td><td width='125px'></td><td width='50px'><a href='#' class='delete' onClick="hapuspengn(this,'kiri')">delete</a></td></tr>
					<script>
						initAutocomplete('<?php echo $penjNkiri ;?>','tkkiri','id_pengurangkiri',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
					</script>
				<?php
					$penjNkiri++;
					}
				?>
		</table>	
		<table class='data-list ' style='padding: 0px 0px 0px 0px' style="width:600px;">
			<dl >
				<tr class='even'>
					<td width="300px"><dd><b></b></dd></td><td width="125px"></td><td width="125px">Rp YYY<br>________ - </td><td width="50px"></td>
				</tr>
				<tr class='even'>
					<td width="300px"><dd><b>Total HarTa</b></dd></td><td width="125px"></td><td width="125px">Rp ZZZ</td>
				</tr>
			</dl>
		</table>	
		</fieldset>
		</td>
		<td>
		<fieldset style="width:600px;">
		<div style='clear: both'>
		   <div class="data-list " style='width=600px'>
				<div class="floleft">
					<a href="#" class="add" onClick="addn('rekening_penjumlah','kanan')"><div class="icon button-add"></div>Tambah Penjumlah</a>
					<a href="#" class="add" onClick="addn('rekening_pengurang','kanan')"><div class="icon button-add"></div>Tambah Pengurang</a>
				</div>
			</div> 
		</div>
		
		
		
		<legend>Kanan</legend>
			<table id='rekening_penjumlahkanan' class='data-list ' style='padding: 0x 0px 0px 0px' style="width:600px;">
				<tr>
					<td ><dt><b>Penjumlah</b></dt></td>
				</tr>
				<tr class='even'>
					<td width="300px"><dd>- Utang</dd></td><td width="125px"></td><td width="125px">Rp XXX</td><td width="50px"></td>
				</tr>
				<tr class='even'>
					<td width="300px"><dd>- Modal akhir</dd></td><td width="125px"></td><td width="125px">Rp XXX</td><td width="50px"></td>
				</tr>
					<?php
					$penjNkiri = 1;
					foreach($formatN['penjumlah_kanan'] as $data){
					?>
					<tr class='even t_penjkanan' ><td width='300px'><dd>- <input type='text' name='t_rekpenjumlahkanan[]' id="<?php echo 'tjkiri'.$penjNkiri;?>" class="tjkanan" value="<?php echo $data['nama'];?>"> <input class='hideauto' type='hidden' name='id_rekpenjumlahkanan[]' id="<?php echo 'id_penjumlahkanan'.$penjNkiri;?>" value="<?php echo $data['id'];?>"> </dd></td><td width='125px'>Rp XXX</td><td width='125px'><a href='#' class='delete' onClick="hapuspenjn(this,'kanan')">delete</a></td></tr>
					<script>
						initAutocomplete('<?php echo $penjNkiri ;?>','tjkanan','id_penjumlahkanan',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
					</script>
				<?php
					$penjNkiri++;
					}
				?>
		</table>	
		<table id='rekening_pengurangkanan' class='data-list ' style='padding: 0x 0px 0px 0px' style="width:600px;">
				<tr>
					<td ><dt><b>Pengurang</b></dt></td>
				</tr>
				<?php
					$penjNkiri = 1;
					foreach($formatN['pengurang_kanan'] as $data){
					?>
					<tr class='even t_pengkanan' ><td width='300px'><dd>- <input type='text' name='t_rekpengurangkanan[]' id="<?php echo 'tkkanan'.$penjNkiri;?>" class="tkkanan" value="<?php echo $data['nama'];?>"> <input class='hideauto' type='hidden' name='id_rekpengurangkanan[]' id="<?php echo 'id_pengurangkanan'.$penjNkiri;?>" value="<?php echo $data['id'];?>"> </dd></td><td width='125px'>Rp XXX</td><td width='125px'><a href='#' class='delete' onClick="hapuspengn(this,'kanan')">delete</a></td></tr>
					<script>
						initAutocomplete('<?php echo $penjNkiri ;?>','tkkanan','id_pengurangkanan',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
					</script>
				<?php
					$penjNkiri++;
					}
				?>
		</table>	
		<table class='data-list ' style='padding: 0px 0px 0px 0px' style="width:600px;">
			<dl >
				<tr class='even'>
					<td width="300px"><dd><b></b></dd></td><td width="125px"></td><td width="125px">Rp YYY<br>________ - </td><td width="50px"></td>
				</tr>
				<tr class='even'>
					<td width="300px"><dd><b>Total Utang dan Modal</b></dd></td><td width="125px"></td><td width="125px">Rp ZZZ</td>
				</tr>
			</dl>
		</table>	
		</fieldset>
		</td>
		</tr>
		</table>	
	</fieldset>
		<input type='submit' name="formatNeraca" value='Simpan' class="stylebutton">
		<a href="<?php echo app_base_url('akuntansi/master-format-laporan-keuangan?tab=n');?> "><input type='button' name="cancel" value='Batal' class="stylebutton"></a>
	</form>
</div>