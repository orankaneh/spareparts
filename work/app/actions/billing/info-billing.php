<h2 class="judul">Informasi Billing Pasien</h2>
<?php
require_once 'app/lib/common/master-data.php';
?>
<script type="text/javascript">
    $(function() {
        $('#pasien').autocomplete("<?= app_base_url('/inventory/search?opsi=billingPasien') ?>",
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
            $('#wilayah').html(data.nama_kelurahan+', '+data.kecamatan+', '+data.kabupaten+', '+data.provinsi);
            $('#idKelurahan').val(data.id_kelurahan);
			 $(".noBilling").html(data.id_billing);
            $("#noBilling").attr('value',data.id_billing);
				 $("#bayar").attr('value',data.carabayar);
		 $(".bayar").html(data.carabayar);
		 $("#idKunjungan").val(data.id_kunjungan);
		   $('#noKunjunganPasien').val(data.no_kunjungan_pasien);
                    var id_kunjungan=data.id_kunjungan;
                    $.ajax({
                        url: "<?= app_base_url('admisi/search?opsi=asuransi_kunjungan')?>",                        
                        cache:false,
                        data: "&q=1&id_kunjungan="+id_kunjungan,
                        dataType:'json',
                        success:function(data){                            
                            var jml_asuransi=data.length;
                            if(jml_asuransi>1){
                                var str="<ol style='margin-left:0;padding-left:14px;'>";
                                for(var i=0;i<jml_asuransi;i++){
                                    str+="<li style='font-size:12px;padding-bottom:2px'>"+data[i].nama_asuransi+"</li>";
                                }
                                str+="</ol>";
                                $('.asuransi').html(str);
                            }else if(jml_asuransi>0){
                                $('.asuransi').html(data[0].nama_asuransi);
                            }
                        }
                    });
        }
    );
    });
	 $(function() {
        $('#noRm').autocomplete("<?= app_base_url('/inventory/search?opsi=noRm') ?>",
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
            $('#wilayah').html(data.nama_kelurahan+', '+data.kecamatan+', '+data.kabupaten+', '+data.provinsi);
            $('#idKelurahan').val(data.id_kelurahan);
				 $("#bayar").attr('value',data.carabayar);
				 $("#idKunjungan").val(data.id_kunjungan);
				    $(".noBilling").html(data.id_billing);
            $("#noBilling").attr('value',data.id_billing);
            var carabayar="";
                    if(data.carabayar=="Charity"){
                        carabayar="Asuransi";
                    }else{
                        carabayar=data.carabayar;
                    }
		 $(".bayar").html(carabayar);
        $('#noKunjunganPasien').val(data.no_kunjungan_pasien);
                    var id_kunjungan=data.id_kunjungan;
                    $.ajax({
                        url: "<?= app_base_url('admisi/search?opsi=asuransi_kunjungan')?>",                        
                        cache:false,
                        data: "&q=1&id_kunjungan="+id_kunjungan,
                        dataType:'json',
                        success:function(data){                            
                            var jml_asuransi=data.length;
                            if(jml_asuransi>1){
                                var str="<ol style='margin-left:0;padding-left:14px;'>";
                                for(var i=0;i<jml_asuransi;i++){
                                    str+="<li style='font-size:12px;padding-bottom:2px'>"+data[i].nama_asuransi+"</li>";
                                }
                                str+="</ol>";
                                $('.asuransi').html(str);
                            }else if(jml_asuransi>0){
                                $('.asuransi').html(data[0].nama_asuransi);
                            }
                        }
                    });
        }
    );
    });
</script>
<script type="text/javascript">
    function cekdata(isian) {
        if (isian.pasien.value == '') {
            alert('Nama pasien tidak boleh kosong !');
            isian.pasien.focus();
            return false;
        }
    }
    $(function() {
        $('#search').click(function() {
            var noRm = $('#noRm').val();
			  var bill= $('#noBilling').val();
            $.ajax({
                url: "<?= app_base_url('billing/info-billing-table') ?>",
                cache: false,
                data:'noRm='+noRm+'&noBilling='+bill,
                success: function(msg){
                    $('#show').html(msg);
                }
            })
        })
    });
</script>
<div class="data-input">
<?php
$idKelurahan = isset($_GET['idKelurahan']) ? $_GET['idKelurahan'] : NULL;
?>
    <fieldset><legend>Form Informasi Billing Pasien</legend>
        <form action="" method="get" onSubmit="return cekdata(this)">
            <label for="norm">No. RM</label><input type="text" name="noRm" id="noRm" />
            <label for="pasien">Pasien</label><input type="text" name="pasien" id="pasien">
            <label for="alamat">Alamat</label><input type="text" name="alamat" id="alamat" style="border:none;" readonly />
            <label for="wilayah">&nbsp;</label><span style="font-size: 12px;padding-top: 5px;" id="wilayah"></span>
            <input type="hidden" name="idKelurahan" id="idKelurahan">
               <label for="bayar">Cara Bayar</label><span style="font-size: 12px;padding-top: 5px;" class="bayar"></span>
               <input type="hidden" id="noBilling" name="noBilling">
            <input type="hidden" id="bayar" name="bayar">
             <label for="asuransi">Produk Asuransi</label><span style="font-size: 12px;padding-top: 5px;" class="asuransi"></span>
            <input type="hidden" id="asuransi" name="asuransi">
                <input type="hidden" id="idKunjungan" name="idKunjungan">
            <fieldset class="input-process">
                <input type="button" value="Cari" id="search" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick=location.href="<?= app_base_url('billing/info-billing') ?>" />
            </fieldset>
        </form>
    </fieldset>
</div>

<div id="show"></div>
