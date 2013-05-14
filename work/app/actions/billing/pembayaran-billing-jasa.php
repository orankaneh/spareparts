<h2 class="judul">Informasi Pembayaran</h2>
<div class="data-input">
<?php
require_once "app/lib/common/master-data.php";
require_once "app/lib/common/functions.php";
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.Date('Y');
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.Date('Y');
?>
<script type="text/javascript">
  $(function(){
      $('#noRm').focus();
        $('#btn-group').hide();
        $('#noRm').autocomplete("<?= app_base_url('/billing/search?opsi=pembayaranBilling') ?>",
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
                $("#idKunjungan").val('');
                $("#idBilling").val('');
       var str='<div class=result>'+data.norm+' '+data.pasien+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.norm);
            $("#pasien").val(data.pasien);
            $("#alamat").html(data.alamat_jalan);
            $("#kelurahan").html(data.kelurahan);
            $("#idKunjungan").val(data.id_kunjungan);
            $("#noTagihan").html(data.id+" / Pembayaran ke-"+data.pembayaran);
            $("#idBilling").val(data.id);
            var id=data.id;
            $.ajax({
                url: "<?=  app_base_url('billing/pembayaran-billing-table')?>",
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
                $("#idKunjungan").val('');
                $("#idBilling").val('');
       var str='<div class=result>'+data.norm+' '+data.pasien+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.pasien);
            $("#noRm").val(data.norm);
            $("#alamat").html(data.alamat_jalan);
            $("#kelurahan").html(data.kelurahan);
            $("#idKunjungan").val(data.id_kunjungan);
            $("#noTagihan").html(data.id+" / Pembayaran ke-"+data.pembayaran);
            $("#idBilling").val(data.id);
            var id=data.id;
            $.ajax({
                url: "<?=  app_base_url('billing/pembayaran-billing-table')?>",
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
</script>
<fieldset id="master"><legend>Form pencarian </legend>    
    <form action="" method="get" name="form" onSubmit="return cekform(this)">
      <fieldset class="field-group">    
        <legend>Tanggal</legend>
        <input type="text" id="awal" name="startDate" value="<?= $startDate ?>" class="tanggal"/>
        <label for="akhir" class="inline-title"> s . d </label>
        <input type="text" id="akhir" name="endDate" value="<?= $endDate ?>" class="tanggal"/>
      </fieldset>
          <label for="norm">No. RM</label><input type="text" id="noRm">
        <label for="nama">Nama Pasien*</label>    <input type="text" id="pasien" name="pasien" />
        <div id="field-dinamis">

        </div>
         <fieldset class="input-process">
            <input type="submit" value="Cari" class="tombol" />
            <input type="button" value="Cancel" class="tombol" onClick=javascript:location.href="<?= app_base_url('/billing/pembayaran')?>" />
         </fieldset>
            </form>
</fieldset>    
</div>
<div class="data-list">
<?php
if (isset($_GET['idLayanan'])) {
$beginDate = date2mysql($startDate);
$endTheDate= date2mysql($endDate);
$pembayaran = pembayaran_muat_data($_GET['idLayanan'], $_GET['kelas'], $beginDate, $endTheDate);
?>
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel">
		
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>No. Tagihan</th>
        <th>Total Tagihan</th>
        <th>Total Bayar</th>
   </tr>
   <?php
   $subtotal = 0;
   $jml_bayar= 0;
   foreach($pembayaran as $num => $row):
   $subtotal = $subtotal + $row['subtotal'];
   $jml_bayar= $jml_bayar + $row['jumlah_bayar'];
   ?>
   <tr class="<?= ($num%2)? 'odd':'even'  ?>">
		<td align="center"><?= ++$num ?></td>
		<td align="center"><?= datefmysql($row['waktu']) ?></td>
		<td align="center"><?= $row['id'] ?></td>
		<td><?= int_to_money($row['subtotal']) ?></td>
		<td><?= int_to_money($row['jumlah_bayar']) ?></td>
   </tr>
   <?php endforeach; ?>
   <tr>
		<td colspan="3">TOTAL</td>
		<td><?= int_to_money($subtotal) ?></td>
		<td><?= int_to_money($jml_bayar) ?></td>
   </tr>
	</table>
<?php
}
?>
</div>
