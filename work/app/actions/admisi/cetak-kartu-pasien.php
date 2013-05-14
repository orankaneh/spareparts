<h2 class="judul">Cetak kartu Pasien</h2>
<script type="text/javascript">
$(function() {
	$('#pasien').autocomplete("<?= app_base_url('/admisi/search?opsi=pasien') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama_pas // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        
                        
                        var str='<div class=result><b>'+data.id+'</b> - '+data.nama+' <br/> <i>'+data.alamat_jalan+' '+data.kelurahan+'</i></div>';
                        
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){

		    $(this).attr('value',data.nama);
                    $('#norm').attr('value',data.id);
                    $('#alamat').attr('value',data.alamat_jalan);
		    $('#kelurahan').attr('value',data.kelurahan);
            }
        );
});
</script>
<div class="data-input">
	<?php
		$nama = isset($_GET['pasien'])?$_GET['pasien']:NULL;
		$kunjungan = isset($_GET['kunjungan'])?$_GET['kunjungan']:NULL;
		$norm = isset($_GET['norm'])?$_GET['norm']:NULL;
		$alamat = isset($_GET['alamat'])?$_GET['alamat']:NULL;
		$instalasi = isset($_GET['instalasi'])?$_GET['instalasi']:NULL;
		$nobed = isset($_GET['nobed'])?$_GET['nobed']:NULL;
	?>
	<fieldset><legend>Form Informasi Billing Pasien</legend>
		
		<label for="pasien">Pasien</label><input type="text" name="pasien" id="pasien" value="<?= $nama ?>"> 
		<input type="hidden" name="kunjungan" id="kunjungan" value="<?= $kunjungan ?>">
		<label for="norm">No. RM</label><input type="text" name="norm" id="norm" style="border:none;" readonly value="<?= $norm ?>">
		<label for="alamat">Alamat</label><input type="text" name="alamat" id="alamat" style="border:none;" readonly value="<?= $alamat ?>">
		<label for="instalasi">Kelurahan</label><input type="text" name="kelurahan" id="kelurahan" style="border:none;" readonly value="<?= $instalasi ?>">

		<fieldset class="input-process">
			<input type="submit" value="Cetak" class="tombol cetaks" onClick="" /> 
		</fieldset>
		
	</fieldset>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".cetaks").click(function(){
			if ($('#norm').val() == "") {
				alert('Isikan data pasien terlebih dahulu !');
				$('#pasien').focus();
				return false;
			}
			else {
            var win = window.open('kartu-pasien?idp='+$('#norm').val()+'', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
			}
        })
    })
</script>  
