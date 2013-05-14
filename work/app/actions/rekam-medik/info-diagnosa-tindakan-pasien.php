<h2 class="judul">Informasi Diagnosa dan Tindakan Pasien</h2>
<script type="text/javascript">
    $(function() {
        $('#pasien').autocomplete("<?= app_base_url('/admisi/search?opsi=nama') ?>",
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
                $('#noRm').val('');
				$('#alamat').val('');
                $('#wilayah').html('');
                if (data.id_pasien == null) {
                    var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                } else {
                    var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                }
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama_pas);
            $('#instalasi').attr('value',data.alamat_jalan);
            $('#noRm').attr('value',data.id_pasien);
            $('#alamat').attr('value',data.alamat_jalan);
            $('#wilayah').html(data.nama_kelurahan+', '+data.nama_kecamatan+', '+data.nama_kabupaten);
        }
    );
	
    $('#noRm').autocomplete("<?= app_base_url('/admisi/search?opsi=noRm') ?>",
        {
			
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].id_pasien // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $('#pasien').val('');
                $('#alamat').val('');
                $('#wilayah').html('');
                if (data.id_pasien == null) {
                    var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                } else {
                    var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                }
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.id_pasien);
            $('#instalasi').attr('value',data.alamat_jalan);
            $('#pasien').attr('value',data.nama_pas);
            $('#alamat').attr('value',data.alamat_jalan);
            $('#wilayah').html(data.nama_kelurahan);
        }
    );
	 $('#search').click(function(){
	  	$("#content").html("");
		if($('#noRm').attr('value')==''){
			caution('maaf, form input pencarian belum terisi dengan benar','#content');
		}else{
			contentloader('<?= app_base_url('rekam-medik/informasi/info-diagnosis-tindakan-pasien?opsi=info_diagnosis') ?>'+'&norm='+$('#noRm').attr('value'),'#content');
		}
	   });
    });
</script>
<div class="data-input">
<fieldset><legend>Form Pasien</legend>
        <form action="" method="get" >
            <label for="norm">No. RM</label><input type="text" name="noRm" id="noRm" />
            <label for="pasien">Pasien</label><input type="text" name="pasien" id="pasien">
            <label for="alamat">Alamat</label><input type="text" name="alamat" id="alamat" style="border:none;" readonly />
            <label for="wilayah">&nbsp;</label><span style="font-size: 12px;padding-top: 5px;" id="wilayah"></span>
            <fieldset class="input-process">
                <input type="button" value="Cari" id="search" class="tombol" />
                <input type="reset" value="Batal" class="tombol" onclick="$('#wilayah').html('');" />
            </fieldset>
        </form>
   </fieldset>
</div>
<div id="content"></div>