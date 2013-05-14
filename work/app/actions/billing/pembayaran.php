<?php
include 'app/actions/admisi/pesan.php';
set_time_zone();
?>
<script type="text/javascript">
  function get_asuransi_terakhir(norm){
      $.ajax({
            url: "<?=  app_base_url('admisi/search?opsi=asuransi_terakhir_pasien')?>",
            cache: false,
            data:'q='+norm,
            dataType:'json',
            success: function(data){
               $('#asuransi').val(data.nama_asuransi);
               $('#id_asuransi').val(data.id_asuransi_produk);
               $('#id_asuransi_kunjungan').val(data.id_asuransi_kunjungan);
               $('#no_polis').val(data.no_polis);
            }
        }
        );
  }  
    
  $(function(){
      $('#noRm').focus();
        $('#btn-group').hide();
        $('#noRm').autocomplete("<?= app_base_url('/billing/search?opsi=norm_pembayaran') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].norm // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $("#pasien").html('');
                $("#alamat").html('');
                $("#kelurahan").html('');
                $("#noTagihan").html('');
                $("#id_penduduk").val('');
                $("#idPembayaran").val('');
       var str='<div class=result>'+data.norm+' '+data.pasien+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.norm);
            $("#no_penjualan").val('');
            $("#id_penjualan").val('');
            $("#pasien").val(data.pasien);
            $("#alamat").html(data.alamat_jalan);
            $("#kelurahan").html(data.kelurahan);
			$("#kecamatan").html(data.kecamatan);
            $("#id_penduduk").val(data.id_penduduk);
            $("#idPembayaran").val('');
            get_asuransi_terakhir(data.norm);
            var id=data.norm;
            $.ajax({
                url: "<?=  app_base_url('billing/pembayaran-table')?>",
                cache: false,
                data:'&id_pasien='+id,
                success: function(msg){
                    $('#tabel-billing').html(msg);
                    $('#btn-group').show();
                    $('#asuransi_block').show();
                }
            }
            );
        }
    );
    })
    $(function(){
      
        $('#btn-group').hide();
        $('#no_penjualan').autocomplete("<?= app_base_url('/billing/search?opsi=no_penjualan_bebas_pembayaran') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].norm // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $("#pasien").val('');
                $("#noRm").val('');
                $("#alamat").html('');
                $("#kelurahan").html('');
                $("#noTagihan").html('');
                $("#id_penduduk").val('');
                $("#idPembayaran").val('');
                var str='<div class=result>'+data.id_penjualan+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.id_penjualan);
            $("#id_penjualan").attr('value',data.id_penjualan);
            $("#pasien").val('');
            $("#noRm").val('');
            $("#alamat").html('');
            $("#kelurahan").html('');
            $("#noTagihan").html('');
            $("#id_penduduk").val('');
            $("#idPembayaran").val('');
            var id=data.id_penjualan;
            $.ajax({
                url: "<?=  app_base_url('billing/pembayaran-table')?>",
                cache: false,
                data:'&id_penjualan='+id,
                success: function(msg){
                    $('#tabel-billing').html(msg);
                    $('#btn-group').show();
                    
                }
            }
            );
        }
    );
    })
 $(function() {
      $('#pasien').focus();
        $('#btn-group').hide();
        $('#pasien').autocomplete("<?= app_base_url('/billing/search?opsi=nama_pembayaran') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].norm // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $("#noRm").html('');
                $("#alamat").html('');
                $("#kelurahan").html('');
                $("#noTagihan").html('');
                $("#id_penduduk").val('');
                $("#idPembayaran").val('');
       var str='<div class=result>'+data.norm+' '+data.pasien+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.pasien);
            $("#no_penjualan").val('');
            $("#id_penjualan").val('')
            $("#noRm").val(data.norm);
            $("#alamat").html(data.alamat_jalan);
            $("#kelurahan").html(data.kelurahan);
			 $("#kecamatan").html(data.kecamatan);
            $("#id_penduduk").val(data.id_penduduk);
            $("#idPembayaran").val('');
            get_asuransi_terakhir(data.norm);
            var id=data.norm;
            $.ajax({
                url: "<?=  app_base_url('billing/pembayaran-table')?>",
                cache: false,
                data:'&id_pasien='+id,
                success: function(msg){
                    $('#tabel-billing').html(msg);
                    $('#btn-group').show();
                    $('#asuransi_block').show();
                }
            }
            );
        }
    );
    })
    
    $(document).ready(function(){
        $('#asuransi').autocomplete("<?= app_base_url('/admisi/search?opsi=asuransiProduk') ?>",
            {
                parse: function(data){
                    var parsed = [];
                    for (var i=0; i < data.length; i++) {
                        parsed[i] = {
                            data: data[i],
                            value: data[i].nama_asuransi// nama field yang dicari
                        };
                    }
                    return parsed;
                },
                formatItem: function(data,i,max){
                    var str='<div class=result>'+data.nama_asuransi+' <br/><i><b>'+data.nama_pabrik+'</b> '+data.nama_kelurahan+'</i></div>';
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama_asuransi);               
                $('#id_asuransi').attr('value',data.id_asuransi);               
            }
        );
    
    
    
    
    $('#form_pembayaran').submit(function(event){
        event.preventDefault();
    });
        $("#save").click(function(event){
            event.preventDefault();
            var err=0;
            if($("#bayar").val() == ""){
                alert("Jumlah bayar tidak boleh kosong");
                $("#bayar").focus();       
                err++;
            }
            if($("#id_penjualan").val() != ""){
                if($("#sisaTagihan2").val()!=""){
                  alert("Jumlah bayar kurang");
                  $("#bayar").focus(); 
                  err++;
                }
            }
            if(err<=0){
                $("#loader").show();
                var formdata=$("#form_pembayaran").serialize();
                $.ajax(
                    {
                        type:'POST',
                        url:'<?= app_base_url('billing/control/pembayaran')?>',
                        data:formdata+'&save=1',
                        dataType:'json',
                        success:function(data){  
                            //console.log(data.status);
                            var pesan='';
                            if(data.status=='1'){                                
                               $("#noRm").attr('disabled','disabled');
                               $("#pasien").attr('disabled','disabled');
                               $("#no_penjualan").attr('disabled','disabled');
                               $("#bayar").attr('readonly','readonly');
                               $("#save").attr('disabled', 'disabled');   
                               $('#asuransi').attr('disabled', 'disabled');   
                               $('#no_polis').attr('disabled', 'disabled');   
                               $("#idPembayaran").val(data.id_pembayaran);
                               var id=data.id_pembayaran;
                                /*$.ajax({
                                    url: "<//?=  app_base_url('billing/pembayaran-table')?>",
                                    cache: false,
                                    data:'&id_pembayaran='+id,
                                    success: function(msg){                                        
                                        $('.data-list').html(msg); 
                                        
                                */
                                        $("html,body").scrollTop(0);
                                        $(".cetaks").removeAttr('disabled');
                                           pesan="<div class='ui-state-highlight ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'><p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span><strong>Info!</strong> Proses transaksi berhasil dilakukan</p></div>";                               
                                           $('.pesan').html(pesan);
                                           $('.pesan').show();
                                           $("#loader").hide();                                           
                                    /*}
                                }
                                );*/                               
                            }else{                                
                                $("html,body").scrollTop(0);
                                pesan="<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'><p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><strong>Alert:</strong> Proses transaksi gagal </p></div>";
                                $('.pesan').html(pesan);
                                $('.pesan').show();                                
                                $("#loader").hide();
                            }                               
                        }
                    }

                    );
            }
        });
    });
    
</script>
<h2 class="judul">Pembayaran</h2>
<div class='ui-widget pesan' id="pesan"></div>
<form action="<?= app_base_url('billing/control/pembayaran')?>" method="POST" id="form_pembayaran" >
<div class="data-input">
    <fieldset>
        <legend>Form Pembayaran</legend>
        <label for="tanggal">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= date("d/m/Y")?></span>
                <label for="norm">No. RM</label><input type="text" id="noRm" name="noRm">
        <label for="nama">Nama Pasien*</label>    <input type="text" id="pasien" name="pasien" />
        <label for="no_penjualan">No. Penjualan Bebas</label><input type="text" id="no_penjualan" name="no_penjualan_temp" />
        <input type="hidden" name="no_penjualan" id="id_penjualan"/>
        <label for="alamat">Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"></span>
        <label for="kelurahan">Kelurahan/Kecamatan</label><span style="font-size: 12px;padding-top: 5px;" id="kelurahan"></span><span class="span-normal">&nbsp;/&nbsp;</span><span style="font-size: 12px;padding-top: 5px;" id="kecamatan"></span>
        <input type="hidden" name="id_penduduk" id="id_penduduk">
        <input type="hidden" name="idPembayaran" id="idPembayaran">
        <div id="asuransi_block" style="display: none">
        <label for="asuransi">Asuransi</label><input type="text" id="asuransi" name="asuransi" />
        <input type="hidden" name="id_asuransi" id="id_asuransi">
        <input type="hidden" name="id_asuransi_kunjungan" id="id_asuransi_kunjungan">
        <label for="no_polis">No Polis</label><input type="text" id="no_polis" name="no_polis" />
        </div>
    </fieldset>
</div>  
<div id="tabel-billing">
    
</div>
<div class="field-group" id="btn-group" style="clear:left;margin-top: 10px">   
    <input type="submit" value="Simpan" name="save" class="tombol" id="save" disabled="disabled"/> 
    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('billing/pembayaran')?>'"/>
    <input type="button" value="Cetak" class="tombol cetaks" disabled="disabled">
     <div id="loader" style="background-image:url('<?=  app_base_url('/assets/images/contentload.gif')?>');background-repeat: no-repeat;width:100px;height: 35px;display: block;padding-left: 38px;padding-top: 10px;display: none;">
        Menyimpan data</div>    
</div>
</form>    
<script type="text/javascript">
  $(document).ready(function(){
      $(".cetaks").click(function(){
          var bayar=isNaN($("#bayar1").val())?'':$("#bayar1").val();
          var kembali=isNaN($("#kembali2").val())?'':$("#kembali2").val();
          var win = window.open('report/pembayaran-billing-dan-penjualan?id_pembayaran='+$("#idPembayaran").val()+'&totaltagihansebelum='+currencyToNumber($('#sisaTagihanSebelum').html())+'', 'MyWindow', 'width=700px,height=600px,scrollbars=1');
      })
  })
</script>