<script language="javascript">
	function goDisplayPM(el1,el2){
		var tahun = $(el1).val();
		var bulan = $(el2).val();
		$.ajax({
				url: "search?opsi=cek_saldo_bulan_terpilih"+"&tahun="+tahun+"&bulan="+bulan,
				cache: false,
				dataType: 'json',
				success: function(msg){
					if(msg.status=="1"){
						$("#contentPM").html("<div class='notif'>Tidak Ditemukan Saldo ( Buku Besar ) Pada Bulan Tersebut</div>");
					}else if(msg.status=="status"){
						if(msg.lr=="false"){
							bulan = msg.bulan;
							tahun = msg.tahun;
							$.get('<?php echo app_base_url('akuntansi/report/perubahan-modal') ?>',{to:'PM',bulan:bulan,tahun:tahun},function(data){
								$('#alert_PM').html(data);
							});
						}else{
							go('ya','alert_PM','contentPM','<?php echo app_base_url("akuntansi/report/perubahan-modal?PM=true") ?>'+'&bulan='+bulan+'&tahun='+tahun);
						}
					}else{
							go('ya','alert_PM','contentPM','<?php echo app_base_url("akuntansi/report/perubahan-modal?PM=true") ?>'+'&bulan='+bulan+'&tahun='+tahun);
					}
				},
				error:function(error){
					alert("ERROR : "+error);
				}
		});  
	}
	
	function getButtonGeneratePM(){
		$('.display_PM').html("");
		$.ajax({
				url: "search?opsi=bulan_belum_tergeneratePM",
				cache: false,
				dataType: 'html',
				success: function(msg){
					$('.display_PM').html(msg);
				},
				error:function(error){
					alert("ERROR : "+error);
				}
		}); 
	}
	getButtonGeneratePM();
</script>
<div style='clear: both'>
		<div class="floleft display_PM">
			
		</div>
</div>
<div id='alert_PM'></div>
<div class="data-input">
<fieldset><legend>Tampil Laporan Perubahan Modal</legend>
    <form action="" method="" name="form">
        <label for="period">Tahun</label>
		<select name='tPM' id='tPM' class='select-style'>
        <?php
			$tahun = date('Y');$tawal =	$tahun-5;$takhir =	$tahun;
			$th = isset($_GET['tahun'])?$_GET['tahun']:date('Y');
			for($i=$tawal;$i<=$takhir;$i++){
				$selected=($th==$i)?"selected='selected'":"";
				echo "<option value='".$i."' $selected >".$i."</option>";
			}
		?>
		</select>
        <label for="laporan">Bulan</label>
		<select name='bPM' id='bPM' class='select-style'>
        <?php
		$bl = isset($_GET['bulan'])?$_GET['bulan']:date('m');
		foreach($array_bulan as $key=>$bulan){
			$selected=($bl==$key)?"selected='selected'":"";
			echo "<option value='".$key."' $selected >".$bulan."</option>";
		}
		?>
		</select>
		<fieldset class="input-process">
            <input type="button" id="show-report" value="Tampilkan" class="stylebutton" onClick="goDisplayPM('#tPM','#bPM')"/>
        </fieldset>
     </form>
</fieldset>
</div>