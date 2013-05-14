<h2 class="judul">Riwayat Kunjungan Pasien</h2>
<?php
	require_once "app/lib/common/functions.php";
	require_once "app/lib/common/master-data.php";
	$id = isset($_GET['idPasien'])?$_GET['idPasien']:NULL;
	$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.Date('Y');
	$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.Date('Y');
	
	$nama = isset($_GET['pasien'])?$_GET['pasien']:NULL;
	$id_pas= isset($_GET['idPasien'])?$_GET['idPasien']:NULL;
        $wilayah = isset ($_GET['wilayah'])?$_GET['wilayah']:"&nbsp;";
        $wilayah2 = isset ($_GET['wilayah2'])?$_GET['wilayah2']:"&nbsp;";
        $wilayah3 = isset ($_GET['wilayah3'])?$_GET['wilayah3']:"&nbsp;";
        $wilayah4 = isset ($_GET['wilayah4'])?$_GET['wilayah4']:"&nbsp;";
        $alamat = isset ($_GET['alamat'])?$_GET['alamat']:"&nbsp";
?>
<script type="text/javascript">
    $(function() {	
		$('#pasien').autocomplete("<?= app_base_url('/admisi/search?opsi=info-pasien') ?>",
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
						$("#idPasien").attr('value','');
			            $("#alamat").html('');
			            $("#wilayah").html('');
						$("#wilayah1").html('');
						$("#wilayah2").html('');
						$("#wilayah3").html('');
	                        var str='<div class=result>'+data.norm+' - '+data.pasien+' <br/>'+data.alamat_jalan+' '+data.kelurahan+' '+data.kecamatan+' '+data.kabupaten+' '+data.provinsi+'</div>';
	                        return str;
	                    },
	                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
	                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
	        }).result(
	            function(event,data,formated){
					$(this).attr('value',data.pasien);
		            $("#idPasien").attr('value',data.norm);
		            $("#alamat").html(data.alamat_jalan);
                            $("#alamatt").val(data.alamat_jalan);
		            $("#wilayah").html("Kel. "+data.kelurahan);
                            $("#wilayaht").val("Kel. "+data.kelurahan);
                            $("#wilayah1").html("Kec. "+data.kecamatan);
                            $("#wilayaht2").val("Kec. "+data.kecamatan);
                            $("#wilayah2").html("Kab. "+data.kabupaten);
                            $("#wilayaht3").val("Kab. "+data.kabupaten);
                            $("#wilayah3").html("Prov. "+data.provinsi);
                            $("#wilayaht4").val("Prov. "+data.provinsi);
	            }
	        );
	    })
		 $(function() {	
		$('#idPasien').autocomplete("<?= app_base_url('/admisi/search?opsi=norm-pasien') ?>",
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
						$("#pasien").attr('value','');
			            $("#alamat").html('');
			            $("#wilayah").html('');
						$("#wilayah1").html('');
						$("#wilayah2").html('');
						$("#wilayah3").html('');
	                        var str='<div class=result>'+data.norm+' - '+data.pasien+' <br/>'+data.alamat_jalan+' '+data.kelurahan+' '+data.kecamatan+' '+data.kabupaten+' '+data.provinsi+'</div>';
	                        return str;
	                    },
	                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
	                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
	        }).result(
	            function(event,data,formated){
					$(this).attr('value',data.norm);
		            $("#pasien").attr('value',data.pasien);
		            $("#alamat").html(data.alamat_jalan);
                            $("#alamatt").val(data.alamat_jalan);
		            $("#wilayah").html("Kel. "+data.kelurahan);
                            $("#wilayaht").val("Kel. "+data.kelurahan);
                            $("#wilayah1").html("Kec. "+data.kecamatan);
                            $("#wilayaht2").val("Kec. "+data.kecamatan);
                            $("#wilayah2").html("Kab. "+data.kabupaten);
                            $("#wilayaht3").val("Kab. "+data.kabupaten);
                            $("#wilayah3").html("Prov. "+data.provinsi);
                            $("#wilayaht4").val("Prov. "+data.provinsi);
	            }
	        );
	    })
</script>
<div class="data-input">
	<form action="" method="get">
	<fieldset id="master"><legend>Form pencarian Riwayat Kunjungan Pasien </legend>
	<fieldset class="field-group">    
		<legend>Awal - akhir periode</legend>
		<input type="text" id="awal" name="startDate" value="<?= $startDate ?>" class="tanggal"/>

		<label for="akhir" class="inline-title"> s . d </label>
		<input type="text" id="akhir" name="endDate" value="<?= $endDate ?>" class="tanggal"/>
	</fieldset>
    <label for="noRm">No. Rekam Medik</label>
   <input type="text" name="idPasien" id="idPasien" value="<?= $id_pas ?>" />
	<label for="pasien">Nama Pasien</label><input type="text" name="pasien" id="pasien" value="<?= $nama ?>" />
	
	<label for="alamat">Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"><?= $alamat?></span>
        <input type="hidden" name="alamat" id="alamatt" value="<?= $alamat?>">
	<label for="alamat">Wilayah</label>
	<span id="wilayah" style='margin-right:3px;font-size: 12px;padding-top: 5px;'><?= $wilayah?></span> 
        <input type="hidden" name="wilayah" id="wilayaht" value="<?= $wilayah?>">
	<span id="wilayah1" style='margin-right:3px;font-size: 12px;padding-top: 5px;'><?= $wilayah2?></span> 
        <input type="hidden" name="wilayah2" id="wilayaht2" value="<?= $wilayah2?>">
        <label>&nbsp</label>
	<span id="wilayah2" style='margin-right:3px;font-size: 12px;padding-top: 5px;'><?= $wilayah3?></span> 
        <input type="hidden" name="wilayah3" id="wilayaht3" value="<?= $wilayah3?>">
	<span id="wilayah3" style='margin-right:3px;font-size: 12px;padding-top: 5px;'><?= $wilayah4?></span>
        <input type="hidden" name="wilayah4" id="wilayaht4" value="<?= $wilayah4?>">
	<fieldset class="input-process">
            <input type="submit" value="Cari" class="tombol" />
            <input type="button" value="Batal" class="tombol" onClick=javascript:location.href="<?= app_base_url('/admisi/informasi/riwayat-kunjungan-pasien')?>" />
         </fieldset>
	</fieldset>
	</form>
</div>
<div class="data-list">
	<table class="tabel full">
        <tr>
            <th style="width: 8%">No</th>
            <th style="width: 15%">Waktu</th>
            <th style="width: 15%">No. Kunjungan</th>
            <th>Instalasi</th>
            <th>Kelas</th>
            <th>No. Bed</th>
            <th>Status</th>
        </tr>
        <?
        if ($id != NULL) {
			$detail = info_riwayat_kunjungan_pasien($_GET['idPasien'], date2mysql($startDate), date2mysql($endDate));
	        foreach ($detail as $key => $row){?>
	        <tr class="<?= ($key%2) ? 'even':'odd' ?>">
	            <td align="center"><?= ++$key?></td>
                    <td align="center"><?= datetime($row['waktu']) ?></td>
	            <td align="center"><?= $row['no_kunjungan_pasien']?></td>
	            <td class="no-wrap"><?= $row['instalasi']?></td>
	            <td align="center"><?= $row['kelas'] ?></td>
	            <td align="center"><?= $row['no_bed'] ?></td>
                    <td><?php echo $row['status']?></td>
	        </tr>
	        <?php
			}
        }
        ?>
  </table>
</div>