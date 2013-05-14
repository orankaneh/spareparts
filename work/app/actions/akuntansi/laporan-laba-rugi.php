<script language="javascript">
	function goDisplayLR(el1,el2){
		$("#contentLR").html("");
		$('#alert_LR').html("");
		var tahun = $(el1).val();
		var bulan = $(el2).val();
		$.ajax({
				url: "search?opsi=cek_saldo_bulan_terpilih"+"&tahun="+tahun+"&bulan="+bulan,
				cache: false,
				dataType: 'json',
				success: function(msg){
					if(msg.status=="1"){
						$("#contentLR").html("<div class='notif'>Tidak Ditemukan Saldo ( Buku Besar ) Pada Bulan Tersebut</div>");
					}else if(msg.status=="status"){
						if(msg.lr=="false"){
							bulan = msg.bulan;
							tahun = msg.tahun;
							$.get('<?php echo app_base_url('akuntansi/report/laba-rugi') ?>',{to:'LR',bulan:bulan,tahun:tahun},function(data){
								$('#alert_LR').html(data);
							});
						}else{
							go('ya','alert_LR','contentLR','<?php echo app_base_url("akuntansi/report/laba-rugi?LR=true") ?>'+'&bulan='+bulan+'&tahun='+tahun);
						}
					}else{
							go('ya','alert_LR','contentLR','<?php echo app_base_url("akuntansi/report/laba-rugi?LR=true") ?>'+'&bulan='+bulan+'&tahun='+tahun);
					}
				},
				error:function(error){
					alert("ERROR : "+error);
				}
				
		});  
	}
	
	function getButtonGenerate(){
		$('.display_LR').html("");
		$.ajax({
				url: "search?opsi=bulan_belum_tergenerate",
				cache: false,
				dataType: 'html',
				success: function(msg){
					$('.display_LR').html(msg);
				},
				error:function(error){
					alert("ERROR : "+error);
				}
		}); 
	}
	getButtonGenerate();
</script><?php
set_time_zone();
$mont_cek = date('m');$year_cek=date('Y');
?>
<div style='clear: both'>
		<div class="floleft display_LR">
		</div>
</div>
<div id='alert_LR'></div>
<div class="data-input">
<fieldset><legend>Tampil Laba / Rugi</legend>
    <form action="" method="" name="form">
        <label for="period">Tahun</label>
		<select name='tLR' id='tLR' class="select-style">
        <?php
			$tahun = date('Y');$tawal =	$tahun-5;$takhir =	$tahun;
			for($i=$tawal;$i<=$takhir;$i++){
				$selected=(date('Y')==$i)?"selected='selected'":"";
				echo "<option value='".$i."' $selected>".$i."</option>";
			}
		?>
		</select>
        <label for="laporan">Bulan</label>
		<select name='bLR' id='bLR' class="select-style">
        <?php
		foreach($array_bulan as $key=>$bulan){
			$selected=(date('m')==$key)?"selected='selected'":"";
			echo "<option value='".$key."' $selected>".$bulan."</option>";
		}
		?>
		</select>
		<fieldset class="input-process">
            <input type="button" id="show-report" value="Tampilkan" class="stylebutton" onClick="goDisplayLR('#tLR','#bLR')"/>
        </fieldset>
     </form>
</fieldset>
</div>