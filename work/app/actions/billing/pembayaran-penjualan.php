<?php
require_once 'app/actions/admisi/pesan.php';
?>
<script type='text/javascript'>
$(function() {
    $('#nopenjualan').focus();
        $('#nopenjualan').autocomplete("<?= app_base_url('inventory/search?opsi=kodepenjualan') ?>",
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
                        if (data.id_penduduk_pembeli == null) {
                        var str='<div class=result>'+data.id+' '+data.jenis+' <br/> '+data.waktu+'</i></div>';
                        } else {
                        var str='<div class=result>'+data.id+' '+data.nama+' <i>'+data.jenis+' <br/> '+data.waktu+'</i></div>';
                        }
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                    $(this).attr('value',data.id);
                    $('#jenis').html(data.jenis);
                    $('#waktu').html(data.waktu);
                    $('#pembeli').html(data.nama);
                    console.log(data.biaya_apoteker+''+data.total_tagihan);
                    var biaya_apoteker=isNaN(data.biaya_apoteker_total)||data.biaya_apoteker_total==null||data.biaya_apoteker_total==''?0:data.biaya_apoteker_total;
                    $('#biaya').html(numberToCurrency(biaya_apoteker));
                    $('#tagihan').html(numberToCurrency(data.total_tagihan));
                    var nopenjualan = data.id;
                    $.ajax({
                        url: "<?=  app_base_url('billing/pembayaran-penjualan-table')?>",
                        cache: false,
                        data:'&nopenjualan='+nopenjualan,
                        success: function(msg){
                            $('#detail-penjualan').html(msg);
                        }
                    }
                );
            }
        );
});

</script>
<h2 class="judul">Pembayaran Penjualan</h2><?= isset ($pesan)?$pesan:NULL?>

<form action="<?= app_base_url('billing/control/pembayaran-penjualan') ?>" method="POST" onSubmit="return cek(this)">
<div class="data-input">
    
    <fieldset><legend>Form Pembayaran Penjualan</legend>
		<table>
		<tr><td>No. Penjualan</td><td><input type="text" name="nopenjualan" id="nopenjualan"><span class="bintang">*</span></td></tr>
		<tr><td>Jenis</td><td id="jenis"></td></tr>
                <tr><td>Waktu</td><td id="waktu"></td></tr>
		<tr><td>Pembeli</td><td id="pembeli"></td></tr>
		<tr><td>Biaya Apoteker</td><td id="biaya"></td></tr>
                <tr><td>Total Tagihan</td><td id="tagihan"></td></tr>
	</table>
    </fieldset> 
</div>
<div id="detail-penjualan">
    <div class="data-list">
    <table class="tabel" id="tblPembelian" style="width:70%">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th style="width: 10%">No.Penjualan</th>
        <th>Jumlah Bayar(Rp.)</th>
        <th>Sisa Tagihan(Rp.)</th>
    </tr>
    <?php
      for($i = 1;$i <= 2;$i++){
    ?>
    <tr class="<?php echo ($i%2)?"even":"odd";?>">
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php
      }
    ?>
    </table>
    </div>    
</div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#cetak").click(function(){
            var win = window.open('print/wristbands?norm=<?= isset($_GET['norm'])?$_GET['norm']:null ?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script> 