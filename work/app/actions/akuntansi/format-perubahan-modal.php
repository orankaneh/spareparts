<?php
$formatPM = format_perubahan_modal_muat_data();
?>
<script type="text/javascript">
 
	function hapuspenjpm(el){
		var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
		 var tr=$('.t_penjpm');
        var countTr=tr.length;
        for(var i=1;i<=countTr;i++){
            $('.t_penjpm:eq('+i+')').removeClass('even');
            $('.t_penjpm:eq('+i+')').addClass('even');
			$('.t_penjpm:eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.tjPm').attr('id','tjPm'+(i+1));
			$('.t_penjpm:eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.hideauto').attr('id','id_penjumlahPm'+(i+1));
			initAutocomplete(i,'tjPm','id_penjumlahPm',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
        }
	}
	
	function hapuspengpm(el){
		var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
		 var tr=$('.t_pengpm');
        var countTr=tr.length;
        for(var i=1;i<=countTr;i++){
            $('.t_pengpm:eq('+i+')').removeClass('even');
            $('.t_pengpm:eq('+i+')').addClass('even');
			$('.t_pengpm:eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.tkPm').attr('id','tkPm'+(i+1));
			$('.t_pengpm:eq('+i+')').children('td:eq(0)').children('dd:eq(0)').children('.hideauto').attr('id','id_pengurangPm'+(i+1));
			initAutocomplete(i,'tjPm','id_pengurangPm',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
        }
	}
	
	function addpm(a){
		var rekPenjumlah = $('.tjPm').length+1;
		var rekPengurang = $('.tkPm').length+1;
		if(a=='rekening_penjumlahpm'){
			var str = "<tr class='even t_penjpm' ><td width='50%'><dd>- <input type='text' name='t_rekpenjumlah[]' id='tjPm"+rekPenjumlah+"'  class='tjPm'> <input class='hideauto' type='hidden' name='id_rekpenjumlah[]' id='id_penjumlahPm"+rekPenjumlah+"'> </dd></td><td width='20%'></td><td width='20%'>Rp AAA.AAA</td><td width='10%'><a href='#' class='delete' onClick='hapuspenjpm(this)'>delete</a></td></tr>";
			$("#"+a).append(str);
			initAutocomplete(rekPenjumlah,'tjPm','id_penjumlahPm',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
		}else{
			var str = "<tr class='even' t_pengpm><td width='50%'><dd>- <input type='text' name='t_rekpengurang[]' id='tkPm"+rekPengurang+"' class='tkPm'> <input class='hideauto' type='hidden' name='id_rekpengurang[]' id='id_pengurangPm"+rekPengurang+"'> </dd></td><td width='20%'>Rp BBB.BBB</td><td width='20%'></td><td width='10%'><a href='#' class='delete' onClick='hapuspengpm(this)'>delete</a></td></tr>";
			$("#"+a).append(str);
			initAutocomplete(rekPengurang,'tkPm','id_pengurangPm',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
		}
	}
</script>
<div style='clear: both'>
   <div class="data-list w700px">
        <div class="floleft">
            <a href="#" class="add" onClick="addpm('rekening_penjumlahpm')"><div class="icon button-add"></div>Tambah Penjumlah</a>
            <a href="#" class="add" onClick="addpm('rekening_pengurangpm')"><div class="icon button-add"></div>Tambah Pengurang</a>
        </div>
    </div> 
</div>

<div class='data-list w700px'>
	<form action='<?php echo app_base_url('akuntansi/control/formatlaporan/add');?>' method='post' name='fPerubahanModal' id='fPerubahanModal'>
	<fieldset><legend>Format Laporan Prrubahan Modal</legend>
		<table id='rekening_penjumlahpm' class='data-list w700px' style='padding: 0x 0px 0px 0px'>
				<tr>
					<td colspan="4" ><dt><b>Penjumlah</b></dt></td>
				</tr>
				<tr class='even'>
					<td width="50%"><dd>- Modal (awal)</dd></td><td width="20%"></td><td width="20%">Rp AAA.AAA</td><td width="10%"></td>
				</tr>
				<tr class='even'>
					<td width="50%"><dd>- Investasi</dd></td><td width="20%"></td><td width="20%">Rp AAA.AAA</td><td width="10%"></td>
				</tr>
				<tr class='even'>
					<td width="50%"><dd>- Laba / Rugi Bersih</dd></td><td width="20%">Rp CCC.CCC<br>__________ - / +</td><td width="20%"></td><td width="10%"></td>
				</tr><tr>
					<td width="50%"><dd></dd></td><td width="20%"></td><td width="20%">Rp DDD.DDD</td><td width="10%"></td>
				</tr>
				<?php
					$penjPM = 1;
					foreach($formatPM['penjumlah'] as $data){
					?>
					<tr class='even t_penj' ><td width='50%'><dd>- <input type='text' name='t_rekpenjumlah[]' id="<?php echo 'tjPm'.$penjPM ;?>"  class='tjPm' value="<?php echo $data['nama'];?>"> <input class='hideauto' type='hidden' name='id_rekpenjumlah[]' id="<?php echo 'id_penjumlahPm'.$penjPM;?>" value="<?php echo $data['id'];?>"> </dd></td><td width='20%'></td ><td width='20%'>RP.XXX.XXX</td><td width='10%'><a href='#' class='delete' onClick='hapuspenj(this)'>delete</a></td></tr>
					<script>
						initAutocomplete('<?php echo $penjPM ;?>','tjPm','id_penjumlahPm',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
					</script>
				<?php
					$penjPM++;
					}
				?>
		</table>	
		<table id='rekening_pengurangpm' class='data-list w700px' style='padding: 0x 0px 0px 0px'>
			<dl >
				<tr>
					<td colspan="4" ><dt><b>Pengurang</b></dt></td>
				</tr>
				<tr class='even'>
					<td width="50%"><dd>- Prive</dd></td><td width="20%">Rp BBB.BBB</td><td width="20%"></td>
				</tr>
					<?php
					$penjPM = 1;
					foreach($formatPM['pengurang'] as $data){
					?>
					<tr class='even' t_peng><td width='50%'><dd>- <input type='text' name='t_rekpengurang[]' id="<?php echo 'tkPm'.$penjPM ;?>" class='tkPm' value="<?php echo $data['nama'];?>" > <input class='hideauto' type='hidden' name='id_rekpengurang[]' id="<?php echo 'id_pengurangPm'.$penjPM;?>" value="<?php echo $data['id'];?>"> </dd></td><td width='20%'>Rp MMM.MMM</td width='20%'><td></td><td width='10%'><a href='#' class='delete' onClick='hapuspeng(this)'>delete</a></td></tr>
					<script>
						initAutocomplete('<?php echo $penjPM ;?>','tkPm','id_pengurangPm',"<?= app_base_url('akuntansi/search?opsi=kategoriRekening') ?>");
					</script>
				<?php
					$penjPM++;
					}
				?>
			</dl>
		</table>	
		<table class='data-list w700px' style='padding: 0x 0px 0px 0px'>
			<dl >
				<tr>
					<td width="50%"><dt><b></b></dt></td><td width="20%"></td><td width="20%">Rp BBB.BBB<br>_________ -</td><td width="10%"></td>
				</tr>
				<tr class='even'>
					<td width="50%"><dt><b>Modal (akhir)</b></dt></td><td width="20%"></td><td width="20%">Rp ZZZ.ZZZ</td><td width="10%"></td>
				</tr>
			</dl>
		</table>	
	</fieldset>
		<input type='submit' name="formatPM" value='Simpan' class="stylebutton">
		<a href="<?php echo app_base_url('akuntansi/master-format-laporan-keuangan?tab=pm');?> "><input type='button' name="cancel" value='Batal' class="stylebutton"></a>
	</form>
</div>