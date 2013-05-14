<h2 class="judul">Informasi Pembayaran</h2>
<div class="data-input">
<?php
require_once "app/lib/common/master-data.php";
require_once "app/lib/common/functions.php";
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.Date('Y');
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.Date('Y');
$norm = isset($_GET['noRm']) ? $_GET['noRm'] : NULL;
$pasien = isset($_GET['pasien']) ? $_GET['pasien'] : NULL;
$pembayaran=info_pembayaran_muat_data($startDate, $endDate, $norm);
//show_array($pembayaran);
?>
<script type="text/javascript">
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
         }
            );
        });
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
           }
            );
        });
 function openCetak(id,utang){
    window.open('report/pembayaran-billing-dan-penjualan?id_pembayaran='+id+'&totaltagihansebelum='+utang, 'MyWindow', 'width=600px, height=500px, scrollbars=1');
}
</script>
<fieldset id="master"><legend>Form pencarian </legend>    
    <form action="" method="get" name="form" onSubmit="return cekform(this)">
      <fieldset class="field-group">    
        <legend>Tanggal</legend>
        <input type="text" id="awal" name="startDate" value="<?= $startDate ?>" class="tanggal"/>
        <label for="akhir" class="inline-title"> s . d </label>
        <input type="text" id="akhir" name="endDate" value="<?= $endDate ?>" class="tanggal"/>
      </fieldset>
          <label for="norm">No. RM</label><input type="text" id="noRm" name="noRm" value="<?= $norm ?>">
        <label for="nama">Nama Pasien*</label>    <input type="text" id="pasien" value="<?= $pasien?>" name="pasien" />
        <div id="field-dinamis">

        </div>
         <fieldset class="input-process">
            <input type="submit" value="Cari" id="cari" name="cari" class="tombol" />
            <input type="button" value="Cancel" class="tombol" onClick=javascript:location.href="<?= app_base_url('/billing/pembayaran')?>" />
         </fieldset>
            </form>
</fieldset>    
</div>
<div class="data-list">
	<? if (isset($_GET['cari']))
			{
				//show_array($pembayaran);
				?>
	<table cellpadding="0" cellspacing="0" border="0" id="tabel-pembayaran" class="tabel">
		
    <tr>
        <th>No</th>
        <th>Waktu</th>
        <th>No. Nota</th>
        <th>Nama Pasien/Pembeli</th>
           <th>Jumlah Tagihan</th>
              <th>Jumlah Bayar</th>
        <th>Jumlah Sisa Tagihan </th>
        <th>Aksi</th>
   </tr>
    <? 
	 $no = 1;
	foreach($pembayaran as $row){ ?>
      <tr>
        <td><?=$no++?></td>
        <td><?=datetime($row['tanggal'])?></td>
        <td><?=$row['nota']?></td>
        <td><?=$row['pembeli']?></td>
        <td><?=$row['tagihan']?></td>
         <td><?=$row['bayar']?></td>
        <td><?=$row['utang']?></td>
        <td>   <span class="cetak2" id="kitir" onclick="openCetak(<?=$row['nota'].",0"?>)">Cetak </span></td>
   </tr>
   <? } ?>
   </table>
   <? }?>
</div>