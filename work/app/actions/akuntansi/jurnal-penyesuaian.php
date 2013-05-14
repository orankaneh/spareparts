<?php

$sub=isset($_GET['section'])?$_GET['section']:NULL;
if (isset($sub)) {

switch ($sub) {

	// --------------------------- Tabel Jurnal Penyesuaian --------------------------- //
	
	case "tabeljurnalumum":

	set_time_zone();
	require_once 'app/lib/common/master-akuntansi.php';
	$bulan=!empty($_GET['bulan'])?$_GET['bulan']:date('m');
	$tahun=!empty($_GET['tahun'])?$_GET['tahun']:date('Y');
	
	$profil = profile_rumah_sakit_muat_data();
	$data = jurnal_umum_muat_data($bulan,$tahun,2);
	$jmlHari=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

	$doublebutton = 0;
	if (count($data) == 0 and check_laporan_hasil_akuntansi($bulan,$tahun) == 0) {
		echo addBUtton('showFormAdd('.$bulan.','.$tahun.')','Tambah Transaksi Baru','addButton');
		$doublebutton = 1;
	}
	
	if (count($data) != 0) {
	?>
	
	<center><h2 class="judul">JURNAL PENYESUAIAN<br/><?= $profil['nama'] ?><br/>
	<?php if ($bulan == date('m') and $tahun == date('Y')) { ?>	
	Tanggal 1 - <?= date("d") ?> <?= bulan(date("m")) ?> <?= date("Y") ?></h2></center>
	<?php 
	} else {
	echo "Tanggal 1 - ".$jmlHari." ".bulan($bulan)." ".$tahun."</h2></center>";
	}
	if (check_laporan_hasil_akuntansi($bulan,$tahun) == 0) echo addBUtton('showFormAdd('.$bulan.','.$tahun.')','Tambah Transaksi Baru','addButton');
	echo excelButton("/akuntansi/report/jurnal-umum?bulan=".$bulan."&tahun=".$tahun."&tipe=2",'Cetak Excel');
	?>
	
	<table class="tabel full" style="margin-top: 10px" border=1 bordercolor='#ccc'>
        <tr>
            <th rowspan="2">Tanggal</th>
            <th rowspan="2">Transaksi</th>
            <th rowspan="2">No. Bukti</th>
            <th rowspan="2">Jumlah</th>
            <th colspan="2">Debet</th>
            <th colspan="2">Kredit</th>
			<?php if (check_laporan_hasil_akuntansi($bulan,$tahun) == 0) echo "<th rowspan=2>Aksi</th>"; ?>
           
        </tr>
        <tr>
            <th>Rekening Debet</th>
            <th>Jumlah</th>
            <th>Rekening Kredit</th>
            <th>Jumlah</th>
        </tr>
        <?php
		
		
       
        foreach ($data as $key => $row) { 
		$rspan=($row['jumlah_max_rekening']>0)?$row['jumlah_max_rekening']:1;
		
		$warnarekening=($key%2)?'odd':'even';
		?>
        <tr class="<?php echo $warnarekening; ?>" id="<?php echo $row['id']; ?>">
            <td align="center" rowspan=<?php echo $rspan; ?>><?= datefmysql($row['tanggal']) ?></td>
            <td rowspan=<?php echo $rspan; ?>><?php echo $row['nama'];
			if (!empty($row['status_terkait'])) {
				echo "<br><span style='font-size: 10px'>";
				switch($row['status_terkait']) {
					case "1": echo "(Pasien : ".$row['nama_terkait'].")";break;
					case "2": echo "(Pegawai : ".$row['nama_terkait'].")";break;
					case "3": echo "(Instansi : ".$row['nama_instansi'].")";break;
				}
				echo "</span>";
			}

			?></td>
            <td rowspan=<?php echo $rspan; ?>><?= $row['nomor_bukti'] ?></td>
			<td rowspan=<?php echo $rspan; ?> align="right"><?php echo rupiahplus($row['jumlah']) ?></td>
			<?php for ($i=0; $i < $rspan; $i++) { 
			
				if (isset($row['rekening_debet'][$i])) echo "<td class='".$row['id']."'>".$row['rekening_debet'][$i]['nama_rekening']."</td><td class='".$row['id']."' align='right'>".rupiahplus($row['rekening_debet'][$i]['jumlah_rekening'])."</td>";
				else echo "<td class='".$row['id']."'>-</td><td class='".$row['id']."'>-</td>";
				if (isset($row['rekening_kredit'][$i])) echo "<td class='".$row['id']."'>".$row['rekening_kredit'][$i]['nama_rekening']."</td><td class='".$row['id']."' align='right'>".rupiahplus($row['rekening_kredit'][$i]['jumlah_rekening'])."</td>";
				else echo "<td class='".$row['id']."'>-</td><td class='".$row['id']."'>-</td>";
			?>
			
			<?php if ($row['checkedit'] == 0 and $i == 0) { ?>
			<td rowspan=<?php echo $rspan; ?> class="aksi" style='border-bottom: 1px solid #ccc !important'>
                <a href="" onclick="editJurnalUmum('<?php echo $bulan; ?>','<?php echo $tahun; ?>','<?php echo $row['id']; ?>'); return false" class="edit">Edit</a>
                <a href="" onclick="showFormConfirm('Apakah Anda ingin menghapus transaksi <b><?php echo $row['nama']; ?></b> tersebut ?','<?= app_base_url('akuntansi/control/jurnal-umum?opsi=hapus'); ?>','<?=$row['id']; ?>','<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=tabeljurnalumum')."&bulan=".$bulan."&tahun=".$tahun; ?>'); return false" class="delete">Delete</a>
            </td>
			<?php } 
			
			if ($i<$rspan) echo "</tr><tr class='".$warnarekening."' id='".$row['id']."'>";
			?>
			
			
			<?php } ?>
			
        </tr>
        <?php 
		

		}
		} else {
		    if ($bulan == date('m') and $tahun == date('Y') and $doublebutton == 0) echo addBUtton('showFormAdd('.$bulan.','.$tahun.')','Tambah Transaksi Baru','addButton');
			echo notifikasi("Jurnal Penyesuaian tidak tersedia pada bulan ini",1);
		}
        ?>
    </table>
	<?php
	break;
	
	// --------------------------- Autocomplete Plano ---------------------------- //
	
	case "piutangplano": ?>
	<label>Nama/Instansi</label>
	<input type="text" readonly="readonly" id="piutang-plan"/>
	<?php
	break;

	// --------------------------- Autocomplete Pasien --------------------------- //
	
	case "piutangpasien": ?>
	<script type="text/javascript">
	$('#piutang').autocomplete("<?= app_base_url('/akuntansi/search?opsi=pasien') ?>",{
           parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                } return parsed;
            },formatItem: function(data,i,max){
                var str='<div class=result>'+data.nama+'</div>'; return str;
            },width: 300,dataType: 'json'
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#id_terkait').attr('value',data.id);}
    )
	</script>
	
	<label>Nama Pasien</label>
	<input type="text" id="piutang" value="<?php echo isset($_GET['nama'])?$_GET['nama']:NULL; ?>"/><input type="hidden" name="id_terkait" id="id_terkait" value="<?php echo isset($_GET['kode'])?$_GET['kode']:NULL; ?>"/>
	<?php
	break;
	
	// --------------------------- Autocomplete Pegawai --------------------------- //
	
	case "piutangpegawai": ?>
	<script type="text/javascript">
	$('#piutang').autocomplete("<?= app_base_url('/akuntansi/search?opsi=pegawai') ?>",{
           parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                } return parsed;
            },formatItem: function(data,i,max){
                var str='<div class=result>'+data.nama+'</div>'; return str;
            },width: 300,dataType: 'json'
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#id_terkait').attr('value',data.id);}
    )
	</script>
	
	<label>Nama Pegawai</label>
	<input type="text" id="piutang" value="<?php echo isset($_GET['nama'])?$_GET['nama']:NULL; ?>"/><input type="hidden" name="id_terkait" id="id_terkait" value="<?php echo isset($_GET['kode'])?$_GET['kode']:NULL; ?>"/>
	<?php
	break;
	
	// --------------------------- Autocomplete Instansi --------------------------- //
	
	case "piutanginstansi": ?>
	<script type="text/javascript">
	$('#piutang').autocomplete("<?= app_base_url('/akuntansi/search?opsi=instansi') ?>",{
           parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                } return parsed;
            },formatItem: function(data,i,max){
                var str='<div class=result>'+data.nama+'</div>'; return str;
            },width: 300,dataType: 'json'
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#id_terkait').attr('value',data.id);}
    )
	</script>
	
	<label>Nama Instansi</label>
	<input type="text" id="piutang" value="<?php echo isset($_GET['nama'])?$_GET['nama']:NULL; ?>"/><input type="hidden" name="id_terkait" id="id_terkait" value="<?php echo isset($_GET['kode'])?$_GET['kode']:NULL; ?>"/>
	<?php
	break;
	
	// ---------------------------- Form Add Jurnal Penyesuaian ----------------------------- //
	
	case "formjurnalumum":
    
	require_once 'app/lib/common/master-akuntansi.php';
	
	set_time_zone();	
	$id=isset($_GET['id'])?$_GET['id']:NULL;
	$bulan=isset($_GET['bulan'])?$_GET['bulan']:NULL;
	$tahun=isset($_GET['tahun'])?$_GET['tahun']:NULL;

	if (isset($id)) {
		$data_jurmum=jurnal_umum_muat_data($bulan,$tahun,2,$id);
		
		$tanggal = $data_jurmum['tanggal'];
		$nama = $data_jurmum['nama'];
		$kode = substr($data_jurmum['nomor_bukti'],0,3);
		$no_kode = substr($data_jurmum['nomor_bukti'],3,3);
		$jumlah = rupiah($data_jurmum['jumlah']);
		
		$statuspiutang = $data_jurmum['status_terkait'];
		$idterkait = $data_jurmum['id_terkait'];
		$nama_terkait = $data_jurmum['nama_terkait'];
		$nama_instansi = $data_jurmum['nama_instansi'];
		$rekening_debet = $data_jurmum['rekening_debet'];
		$rekening_kredit = $data_jurmum['rekening_kredit'];

		$urlsimpan=app_base_url('akuntansi/control/jurnal-umum?opsi=edit');
	} else {
		$urlsimpan=app_base_url('akuntansi/control/jurnal-umum?opsi=tambah');
	}
	
	
	// Select Bulan
	if (isset($tanggal)) {
		$p_tanggal=explode("-",$tanggal);
	} else if (isset($_GET['bulan'])) {
		$tanggal=$_GET['tahun']."-".$_GET['bulan']."-01";
		$p_tanggal=explode("-",$tanggal);
	} else {
		$tanggal=date("Y-m-d");
		$p_tanggal=explode("-",$tanggal);
	}
	
	$bulanArr=array(''=>'Pilih Bulan','1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember',);
	$bulanCb="<select name=bulan_jurnal_dis id=bulan_jurnal class='select-style' style='margin-right: 5px; min-width: 120px; max-width: 120px' disabled='disabled'>";
	foreach($bulanArr as $key=>$b){
	   if($key==$p_tanggal[1]){
		   $selected='selected';
	   }else{
		   $selected='';
	   }
	   $bulanCb.="<option value=$key $selected>$b</option>";
	}
	$bulanCb.="</select>";
	
	?>

        <script type="text/javascript">
				
		function addRekeningAutoComplete(boxid,boxresult) {
			$('#'+boxid).autocomplete("<?= app_base_url('/akuntansi/search?opsi=rekening') ?>",{
                parse: function(data){
                     var parsed = [];
                     for (var i=0; i < data.length; i++) {
                         parsed[i] = {
                             data: data[i],
                             value: data[i].nama // nama field yang dicari
                         };
                     } return parsed;
                 },formatItem: function(data,i,max){
                     var str='<div class=result>Kode: '+data.kode+' <br/><i> '+data.nama+'</i></div>';
                     return str;
                 },width: 300,dataType: 'json'
             }).result(
             function(event,data,formated){
                 $(this).attr('value',data.kode+' '+data.nama);
                 $('#'+boxresult).attr('value',data.id+"-"+data.id_kategori);
             });
		
		}
		
		
		
		function deleteDebet(el){
			var parent = el.parentNode;
			parent.parentNode.removeChild(parent);
			var tr=$('.t_debet');
			var countTr=tr.length;
			for(var i=1;i<=countTr;i++){
				$('.t_debet:eq('+i+')').removeClass('even');
				$('.t_debet:eq('+i+')').addClass('even');
				$('.t_debet:eq('+i+')').children('.rd').attr('id','rd'+(i+1));
				$('.t_debet:eq('+i+')').children('.hideauto').attr('id','id_debet'+(i+1));
				$('.t_debet:eq('+i+')').children('.labelDebet').html('Rekening Debet ke-'+(i+1));
				addRekeningAutoComplete('rd'+i,'id_debet'+i);
			}
		}
		
		function deleteKredit(el){
			var parent = el.parentNode;
			parent.parentNode.removeChild(parent);
			var tr=$('.t_kredit');
			var countTr=tr.length;
			for(var i=1;i<=countTr;i++){
				$('.t_kredit:eq('+i+')').removeClass('even');
				$('.t_kredit:eq('+i+')').addClass('even');
				$('.t_kredit:eq('+i+')').children('.rk').attr('id','rk'+(i+1));
				$('.t_kredit:eq('+i+')').children('.hideauto').attr('id','id_kredit'+(i+1));
				$('.t_kredit:eq('+i+')').children('.labelkredit').html('Rekening kredit ke-'+(i+1));
				addRekeningAutoComplete('rk'+i,'id_kredit'+i);
			}
		}
		
		function addDebet() {
			$('#jumlah_debet1').val("");
			var rekDebet = $('.rd').length+1;
			var str = "<div class='even t_debet'><label class='labelDebet'>Rekening Debet ke-"+rekDebet+"</label><input type='text' name='t_rekDebet[]' id='rd"+rekDebet+"' class='rd' style='min-width: 350px'><input class='hideauto' type='hidden' name='id_rekDebet[]' id='id_debet"+rekDebet+"'><span style='float: left'>Jumlah &nbsp; </span><input type='text' onkeyup='formatNumber(this)' style='min-width: 140px' id='jumlah_debet"+rekDebet+"' name='jumlah_rekdebet[]'><a href='#' class='autoadd-delete' onClick='deleteDebet(this)'></a>";
			$("#rek_debet").append(str);
			addRekeningAutoComplete('rd'+rekDebet,'id_debet'+rekDebet);
		}

		
		function addKredit() {
			$('#jumlah_kredit1').val("");
			var rekKredit = $('.rk').length+1;
			var str = "<div class='even t_kredit'><label class='labelKredit'>Rekening Kredit ke-"+rekKredit+"</label><input type='text' name='t_rekKredit[]' id='rk"+rekKredit+"' class='rk' style='min-width: 350px'><input class='hideauto' type='hidden' name='id_rekKredit[]' id='id_kredit"+rekKredit+"'><span style='float: left'>Jumlah &nbsp; </span><input type='text' onkeyup='formatNumber(this)' style='min-width: 140px'  id='jumlah_kredit"+rekKredit+"' name='jumlah_rekkredit[]'><a href='#' class='autoadd-delete' onClick='deleteKredit(this)'></a>";
			$("#rek_kredit").append(str);
			addRekeningAutoComplete('rk'+rekKredit,'id_kredit'+rekKredit);	
		}
		
		
        </script>
	<div class="data-input full" id="formAdd">
	<form action="<?php echo $urlsimpan ?>" method="post" onsubmit="simpanJurnal($(this));return false;">
		<fieldset id="master"><legend>Form Transaksi Jurnal Penyesuaian </legend>
			<label for="tanggal">Tanggal</label>
				<select name="tanggal_jurnal" class="select-style" style="min-width: 45px; max-width: 45px; padding: 3px 2px">
					<?php 
					for ($i=1; $i<=31; $i++) {
						$tglfull=(strlen($i)==1)?"0".$i:$i;
						if ($tglfull==$p_tanggal[2]) $selected="selected";
						else $selected="";
						echo "<option value='$i' $selected>";
						echo $tglfull;
						echo "</option>";
					} ?>
				</select>
				<?php echo $bulanCb ?><input type="text" onkeyup="Angka(this)" maxlength="4" value="<?php echo $p_tanggal[0]; ?>" style="min-width: 40px; max-width: 40px; padding: 3px 2px"  disabled='disabled'>
				<input type="hidden" value="<?php echo $p_tanggal[1]; ?>" name="bulan_jurnal"/>
				<input type="hidden" name="tahun_jurnal" id="tahun_jurnal" value="<?php echo $p_tanggal[0]; ?>"/>
			<label for="transaksi">Nama Transaksi *</label><input type="text" name="transaksi" id="transaksi" value="<? echo isset($nama)?$nama:''; ?>" />
			<label for="No. Bukti">Nomor Bukti *</label>
			<select name="kode" class="select-style" id="kode" style="min-width: 100px;">
				<option value="">Pilih Bukti ..</option>
				<option value="BKP" <?php if (isset($kode) and $kode == 'BKP') echo "selected "; ?>>BKP</option>
				<option value="BKK" <?php if (isset($kode) and $kode == 'BKK') echo "selected "; ?>>BKK</option>
			</select>
			<input type="text" name="nomor" id="nomor_bukti" style="min-width: 171px" onkeyup="Angka(this)" value="<?= isset($no_kode)?$no_kode:'' ?>" />
			<label for="jumlah">Jumlah *</label><input type="text" name="jumlah" id="jumlah_jurnal" onkeyup="formatNumber(this)" value="<?= isset($jumlah)?$jumlah:'' ?>" />
			
			
		</fieldset>
		
		<fieldset><legend>Rekening Debet</legend>
		
			<div id="rek_debet">
			
			<?php if (isset($id)) { 

			$idrek=1;
			foreach($rekening_debet as $rdebet) {
				echo "<script type='text/javascript'>addRekeningAutoComplete(\"rd".$idrek."\",\"id_debet".$idrek."\");</script>";
			
				echo "<div class='even t_debet'><label class='labelDebet'>Rekening Debet ke-".$idrek."</label>
					<input type='text' name='t_rekDebet[]' id='rd".$idrek."' class='rd' style='min-width: 350px' value='".$rdebet['kode_rekening']." ".$rdebet['nama_rekening']."'>
					<input class='hideauto' type='hidden' name='id_rekDebet[]' id='id_debet".$idrek."' value=".$rdebet['id_rekening']."-".$rdebet['id_kategori']."><span style='float: left'>Jumlah &nbsp; </span>
					<input type='text' onkeyup='formatNumber(this)' style='min-width: 140px' id='jumlah_debet".$idrek."' name='jumlah_rekdebet[]' value='".rupiah($rdebet['jumlah_rekening'])."'>";
				if ($idrek==1) echo "<div class='act-suddenly' title='Tambah Rekening Debet' onclick='addDebet()'><div class='icon button-sud-add'></div>Tambah</div></div>";
				else echo "<a href='#' class='autoadd-delete' onClick='deleteDebet(this)'></a>";
				
				echo "<input type='hidden' name='id_sebelum_rekDebet[]' value=".$rdebet['id_rekening'].">";
				
				$idrek+=1;
				
				
				
			}
			} else { 
			
			
			?>
			<script type="text/javascript">addRekeningAutoComplete('rd1','id_debet1');</script>
			
		
			<div class='even t_debet'><label>Rekening Debet ke-1</label><input type='text' name='t_rekDebet[]' id='rd1' class='rd' style='min-width: 350px' onblur="$('#jumlah_debet1').val($('#jumlah_jurnal').val())"><input class='hideauto' type='hidden' name='id_rekDebet[]' id='id_debet1'><span style='float: left'>Jumlah &nbsp; </span><input type='text' onkeyup='formatNumber(this)' style='min-width: 140px' id="jumlah_debet1" name='jumlah_rekdebet[]'>
			<div class="act-suddenly" title="Tambah Rekening Debet" onclick="addDebet()"><div class="icon button-sud-add"></div>Tambah</div></div>			
			<?php } ?>
			</div>
		</fieldset>
		
		<fieldset><legend>Rekening Kredit</legend>
		
			<div id="rek_kredit">
			<?php if (isset($id)) { 

			$idrek=1;
			foreach($rekening_kredit as $rkredit) {
				echo "<script type='text/javascript'>addRekeningAutoComplete(\"rk".$idrek."\",\"id_kredit".$idrek."\");</script>";
			
				echo "<div class='even t_debet'><label class='labelKredit'>Rekening Kredit ke-".$idrek."</label>
					<input type='text' name='t_rekKredit[]' id='rk".$idrek."' class='rk' style='min-width: 350px' value='".$rkredit['kode_rekening']." ".$rkredit['nama_rekening']."'>
					<input class='hideauto' type='hidden' name='id_rekKredit[]' id='id_kredit".$idrek."' value=".$rkredit['id_rekening']."-".$rkredit['id_kategori']."><span style='float: left'>Jumlah &nbsp; </span>
					<input type='text' onkeyup='formatNumber(this)' style='min-width: 140px' id='jumlah_kredit".$idrek."' name='jumlah_rekkredit[]' value='".rupiah($rkredit['jumlah_rekening'])."'>";
				if ($idrek==1) echo "<div class='act-suddenly' title='Tambah Rekening Kredit' onclick='addKredit()'><div class='icon button-sud-add'></div>Tambah</div></div>";
				else echo "<a href='#' class='autoadd-kredit' onClick='deleteKredit(this)'></a>";
				
				echo "<input type='hidden' name='id_sebelum_rekKredit[]' value=".$rkredit['id_rekening'].">";
				
				$idrek+=1;
				

			}
			} else {
		
			?>
			<script type="text/javascript">addRekeningAutoComplete('rk1','id_kredit1');</script>
			<div class='even t_kredit'><label>Rekening Kredit ke-1</label><input type='text' name='t_rekKredit[]' id='rk1' class='rk' style='min-width: 350px' onblur="$('#jumlah_kredit1').val($('#jumlah_jurnal').val())"><input class='hideauto' type='hidden' name='id_rekKredit[]' id='id_kredit1'><span style='float: left'>Jumlah &nbsp; </span><input type='text' onkeyup='formatNumber(this)' style='min-width: 140px'  id="jumlah_kredit1" name='jumlah_rekkredit[]'>
			<div class="act-suddenly" title="Tambah Rekening Kredit" onclick="addKredit()"><div class="icon button-sud-add"></div>Tambah</div></div>			
			<?php } ?>
			</div>
		</fieldset>
		
		<fieldset><legend>Peminjam / Pemberi Pinjaman <font style="color: #5090BA">( Opsional ) *</font></legend>
			<label for="status_terkait">Status Peminjam</label>
				<select id="status_terkait" name="status_terkait" class="select-style" onchange="piutangSelected($(this).val())">
					<option value="">--Pilih Peminjam/Pemberi Pinjaman--</option>
					<option value="1" <?php if (isset($statuspiutang) and $statuspiutang == '1') echo "selected "; ?>>Pasien</option>
					<option value="2" <?php if (isset($statuspiutang) and $statuspiutang == '2') echo "selected "; ?>>Pegawai</option>
					<option value="3" <?php if (isset($statuspiutang) and $statuspiutang == '3') echo "selected "; ?>>Instansi</option>
				</select>
		
				<script type="text/javascript">
					var casepiutang=<?php echo $statuspiutang; ?>;
					switch(casepiutang) {
						case 1: contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=piutangpasien'); ?>&nama=<?php echo isset($nama_terkait)?$nama_terkait:null; ?>&kode=<?php echo isset($idterkait)?$idterkait:null; ?>','#autopiutang'); break;
						case 2: contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=piutangpegawai'); ?>&nama=<?php echo isset($nama_terkait)?$nama_terkait:null; ?>&kode=<?php echo isset($idterkait)?$idterkait:null; ?>','#autopiutang'); break;
						case 3: contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=piutanginstansi'); ?>&nama=<?php echo isset($nama_instansi)?$nama_instansi:null; ?>&kode=<?php echo isset($idterkait)?$idterkait:null; ?>','#autopiutang'); break;
					}
				
				</script>
			<div id="autopiutang"><label>Nama/Instansi</label>
		<input type="text" readonly="readonly" id="piutang-plan"/></div>
			<label></label>
				<input type="hidden" name="tipejurnal" value="2">
				<input type="hidden" name="bulan" id="bulan" value="<?php echo $bulan; ?>">
				<input type="hidden" name="tahun" id="tahun" value="<?php echo $tahun; ?>">
				<input type="hidden" value="<?php echo isset($statuspiutang)?$statuspiutang:null; ?>" name="status_sebelum">
				<input type="hidden" value="<?php echo isset($idterkait)?$idterkait:null; ?>" name="id_terkait_sebelum">
				<input type="hidden" value="<?php echo isset($id)?$id:null; ?>" name="id">
				<input type="submit" value="Simpan" class="stylebutton" name="simpan" id='t_simpan'/>
				<input type="button" value="Batal" name="batal" class="stylebutton" onclick="$('#admission').html('');$('.even,.odd').show();"  style="margin-left: 5px"/>
		</fieldset>
		<font style="color: #5090BA">* Kosongkan jika tidak diperlukan</font>
				
	</form>
	</div>
	<?php
        
        
	break;
}
exit();
}



require_once 'app/lib/common/master-data.php';

require_once 'app/lib/common/functions.php';



$bulan=date('m');
$tahun=date('Y');
?>
<script type="text/javascript">

contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=tabeljurnalumum'); ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>','#content');

function showFormAdd(bulan,tahun) {
	contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=formjurnalumum'); ?>&bulan='+bulan+'&tahun='+tahun,'#admission');
}

function editJurnalUmum(bulan,tahun,id) {
    contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=formjurnalumum'); ?>&bulan='+bulan+'&tahun='+tahun+'&id='+id,'#admission');
	$('.even,.odd').hide();
	$('#'+id).show();
}

function piutangSelected(thisval) {
	switch(thisval){
		
		case "1": contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=piutangpasien'); ?>','#autopiutang'); break;
		case "2": contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=piutangpegawai'); ?>','#autopiutang'); break;
		case "3": contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=piutanginstansi'); ?>','#autopiutang'); break;
		default: contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=piutangplano'); ?>','#autopiutang'); break;
	}
}

function simpanJurnal(formid) {
	awaltotal = $('#jumlah_jurnal').val();
	var awaldec = awaltotal.replace(/\./g,'');
	var totalJurnal = awaldec.replace(/\,/g,'.');

	if ($('#transaksi').val() == '') {
		caution('Nama Jurnal harus diisi');
	} else if ($('#kode').val() == '') {
		caution('Tipe Nomor bukti harus diisi');
	} else if ($('#nomor_bukti').val() == '') {
		caution('Nomor bukti harus diisi');
	} else if (totalJurnal == '') {
		caution('Jumlah harus diisi');
	} else if ($('#status_terkait').val() != '' && $('#piutang').val() == '') {
		caution('Anda telah memilih Hutang Piutang namun isian masih kosong');
	} else {
		var status_debet=0;
		var status_kredit=0;
		var totalDebet=0;
		var totalKredit=0;
		var rekDebet = $('.rd').length;
		var rekKredit = $('.rk').length;
		
		for (var d=1; d<=rekDebet; d++) {
			if ($('#jumlah_debet'+d).val() == '' || $('#rd'+d).val() == '' ) {
				caution('Rekening Debet harus diisi lengkap');
			} else {
				awalDebet = $('#jumlah_debet'+d).val();
				tiapDebet_dec = awalDebet.replace(/\./g,'')
				tiapDebet = tiapDebet_dec.replace(/\,/g,'.')
				totalDebet = totalDebet + parseFloat(tiapDebet);
				status_debet = 1;
			}
		}
		if (status_debet==1) {
		for (var d=1; d<=rekKredit; d++) {
			if ($('#jumlah_kredit'+d).val() == '' || $('#rk'+d).val() == '' ) {
				caution('Rekening Kredit harus diisi lengkap');
			} else {
				awalKredit = $('#jumlah_kredit'+d).val();
				tiapKredit_dec = awalKredit.replace(/\./g,'')
				tiapKredit = tiapKredit_dec.replace(/\,/g,'.')
				totalKredit = totalKredit + parseFloat(tiapKredit);
				status_kredit = 1;
			}
		}
		}

		if (status_kredit == 1) {
				if (totalJurnal != totalDebet) {
					caution('Jumlah Jurnal dengan Jumlah pada Rekening Debet tidak sama<br>Coba periksa kembali');
				} else if (totalJurnal != totalKredit) {
					caution('Jumlah Jurnal dengan Jumlah pada Rekening Kredit tidak sama<br>Coba periksa kembali');
				} else {
					progressAdd(formid);
					var bulan = $('#bulan').val();
					var tahun = $('#tahun').val();
					setTimeout("contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=tabeljurnalumum'); ?>&bulan="+bulan+"&tahun="+tahun+"','#content')",1200);
					$('#admission').html('');
				}		
		}
	}
}

function tampilJurnalUmum(bulan,tahun) {
		contentloader('<?= app_base_url('/akuntansi/jurnal-penyesuaian?section=tabeljurnalumum'); ?>&bulan='+bulan+'&tahun='+tahun,'#content');
		$('#admission').html('');
	}
</script>




<?php

$setting = $_SESSION['setting_saldo_awal'];
if ($setting == 0) { ?>

<div id="laysetup">

<fieldset><legend>Set Saldo Awal</legend>
Sebelum memasukkan transaksi, saldo setiap rekening di-set terlebih dahulu dengan klik tombol di bawah ini:<br><br>
<a href="<?php echo app_base_url('/akuntansi/set-saldo'); ?>" onclick="contentloader('<?= app_base_url('/akuntansi/set-saldo?section=settanggal'); ?>','#laysetup');return false" ><input value="Set Saldo Awal" class="stylebutton" type="button"></a>

</fieldset>

</div>
<?php

} else {

set_time_zone();
$id_rek=null;
$bulanArr=array(''=>'Pilih Bulan','1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember',);
$bulanCb="<select name=bulan id=bulan class='search-input' style='margin-right: 5px; width: 140px'>";
if(empty($_GET['bulan'])) $bulan=date('m'); else $bulan=$_GET['bulan'];
if(empty($_GET['tahun'])) $tahun=date('Y'); else $tahun=$_GET['tahun'];

foreach($bulanArr as $key=>$b){
   if($key==$bulan) $selected='selected';
   else $selected='';
   $bulanCb.="<option value=$key $selected>$b</option>";
}
$bulanCb.="</select>";
?>

<h1 class="judul"><a href="<?= app_base_url('akuntansi/jurnal-penyesuaian') ?>">Transaksi Jurnal Penyesuaian</a></h1>

<!-- notifikasi/alert -->

<div id="box-notif"></div><div class="clear"></div>

<fieldset>
	<legend>Pilih Bulan & Tahun</legend>
	<form method="POST" class="search-form" style="float: none" onsubmit="tampilJurnalUmum($('#bulan').val(),$('#tahun').val());return false;" id="pilihbulan">
	<?= $bulanCb ?><input type="text" onkeyup="Angka(this)" name="tahun" id="tahun" maxlength="4" value="<?=$tahun?>" class="search-input" style="width: 30px !important">
	<input type="submit" value="" class="search-button">
	</form>
</fieldset>

<div id="admission"></div>

<div class="data-list full">
   
    <div id="content"></div>
	
</div>
<?php } ?>