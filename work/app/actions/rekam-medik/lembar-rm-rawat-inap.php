<?php 
 include 'app/actions/admisi/pesan.php';
?>
<h2 class="judul">Rekam Medis Rawat Inap</h2><?= isset($pesan) ? $pesan : NULL ?>
<div class="data-input">
	<form id='fPasien' action='<?php echo '#' ?>' method='post' onsubmit="return cekForm()">
		<fieldset>
		<legend>Pasien</legend>
			<label for='norm'>No.RM</label><input type='text' name='no_rm' id='no_rm' >
			<label for='nama'>Nama Pasien</label><input type='text' name='nama_pasien' id='nama_pasien' >
			<input type='hidden' name='id_pasien' id='id_pasien' >
            <label>Umur</label><span style="font-size: 12px;padding-top: 5px;" id="umur"></span>
			<label>Agama</label><span style="font-size: 12px;padding-top: 5px;" id="agama"></span>
            <label>Pekerjaan</label><span style="font-size: 12px;padding-top: 5px;" id="pekerjaan"></span>
            <label>Kelurahan</label><span style="font-size: 12px;padding-top: 5px;" id="kelurahan"></span>
		</fieldset>
	</form>
</div>
<div class="data-list">
	<fieldset>
		<legend>Rekam Medis</legend>
		<div class="field-group">
		<label for='bed'>Bed</label><span style="font-size: 12px;padding-top: 5px;" id="bed"></span><br><br>
		<label for='dokter'>Dokter</label><input type='text' name='dokter' id='dokter' >
		</div><br><br>
		<input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 10px;" disabled>
		<br>
		<table class='table-input' id='t_input' >
			<tbody>
				<tr >
					<th>No</th><th>Tanggal Waktu</th><th>Anamnesa</th><th>Diagnosis</th><th>Layanan</th><th>Aksi</th>
				</tr>
				<?php for($i=1;$i<=2;$i++){?>
				<tr class="medis<?php ($i%2)? 'even':'odd' ;?> ">
					<td id='no<?php echo $i;?>'>1</td>
					<td id='tanggal<?php echo $i;?>'><?php echo date('Y-m-d');?></td>
					<td id='anamnesa<?php echo $i;?>'><input type='text' name='anamnesa' id='anamnesa'></td>
					<td id='diagnosa<?php echo $i;?>'><input type='text' name='diagnosa' id='diagnosa'></td>
					<td id='layanan<?php echo $i;?>'><input type='text' name='layanan' id='layanan'></td>
					<td align="center" id="del<?= $i ?>"><input type="button" class="tombol" value="Hapus" onclick="hapusMedis(this)" ></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</fieldset>
	</fieldset>
</div>
<script type="text/javascript">
  $(function() {
        $('#no_rm').focus();
        $('#no_rm').autocomplete("<?= app_base_url('/rekam_medik/search?opsi=noRm') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].no_rm // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#nama_pasien').attr('value',data.nama);
            $('#id_pasien').attr('value',data.id_pasien);
        });
		
		$('#nama_pasien').autocomplete("<?= app_base_url('/rekam_medik/search?opsi=nama') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#nama_pasien').attr('value',data.nama);
            $('#id_pasien').attr('value',data.id_pasien);
        });
    
	});
    function hapusMedis(el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var jumlah=$('.barang_tr').length;
        for(var i=0;i<=jumlah;i++){
            $('.medis:eq('+i+')').children('td:eq(0)').html(i+1);
            $('.medis:eq('+i+')').removeClass('even');
            $('.medis:eq('+i+')').removeClass('odd');
            if((i+1) % 2 == 1){
                $('.medis:eq('+i+')').addClass('even');
            }else{
                $('.medis:eq('+i+')').addClass('odd');
            }
        }
    }
	
	
</script>