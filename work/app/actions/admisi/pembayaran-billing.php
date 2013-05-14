<?php
include 'app/actions/admisi/pesan.php';
set_time_zone();
?>
<script type="text/javascript">
  $(function() {
        $('#btn-group').hide();
        $('#pasien').autocomplete("<?= app_base_url('/admisi/search?opsi=pembayaranBilling') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].pasien // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $("#noRm").html('');
                $("#alamat").html('');
                $("#kelurahan").html('');
                $("#noTagihan").html('');
                $("#idKunjungan").val('');
                $("#idBilling").val('');
                var str='<div class=result>'+data.pasien+'<br />Alamat: '+data.alamat_jalan+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.pasien);
            $("#noRm").html(data.norm);
            $("#alamat").html(data.alamat_jalan);
            $("#kelurahan").html(data.kelurahan);
            $("#idKunjungan").val(data.id_kunjungan);
            $("#noTagihan").html(data.id+" / Pembayaran ke-"+data.pembayaran);
            $("#idBilling").val(data.id);
            var id=data.id;
            $.ajax({
                url: "<?=  app_base_url('admisi/pembayaran-billing-table')?>",
                cache: false,
                data:'&id='+id,
                success: function(msg){
                    $('#tabel-billing').html(msg);
                    $('#btn-group').show();
                }
            }
            );
        }
    );
    })
    
    function cekForm(){
    if($("#bayar").val() == ""){
        alert("Jumlah bayar tidak boleh kosong");
        $("#bayar").focus();
        return false;
    }
    }
</script>
<h2 class="judul">Pembayaran Billing Pasien</h2><?php echo isset($pesan)?$pesan:NULL;?>
<form action="<?= app_base_url('admisi/control/pembayaran-billing')?>" method="POST" onSubmit="return cekForm()">
<div class="data-input">
    <fieldset>
        <legend>Form Pembayaran Billing</legend>
        <label for="tanggal">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= date("d/m/Y")?></span>
        <label for="nama">Nama Pasien</label><input type="text" id="pasien">
        <label for="norm">No. RM</label><span style="font-size: 12px;padding-top: 5px;" id="noRm"></span>
        <label for="alamat">Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"></span>
        <label for="kelurahan">Kelurahan</label><span style="font-size: 12px;padding-top: 5px;" id="keluraham"></span>
        <label for="noTagihan">No. Tagihan</label><span style="font-size: 12px;padding-top: 5px;" id="noTagihan"></span>
        <input type="hidden" name="idKunjungan" id="idKunjungan">
        <input type="hidden" name="idBilling" id="idBilling">
    </fieldset>
</div>  
<div id="tabel-billing">
    
</div>
<div class="field-group" id="btn-group" style="clear:left;margin-top: 10px">
    <input type="submit" value="Simpan" name="save" class="tombol" /> 
    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/pembayaran-billing')?>'"/>
    <input type="button" value="Cetak" class="tombol cetaks">
</div>
</form>    
<script type="text/javascript">
  $(document).ready(function(){
      $(".cetaks").click(function(){
          var win = window.open('report/pembayaran-billing?id='+$("#idBilling").val()+'&bayar='+$("#bayar").val()+'&kembali='+$("#kembali2").val()+'', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
      })
  })
</script>