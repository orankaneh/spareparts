<?php
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-inventory.php";
  include_once "app/lib/common/master-data.php";
  set_time_zone();
  $pasien = isset ($_GET['pasien'])?$_GET['pasien']:"";
  $id_pas= isset($_GET['idPasien'])?$_GET['idPasien']:NULL;
  $idPenduduk = isset ($_GET['idPenduduk'])?$_GET['idPenduduk']:"";
  $idPerundangan= isset ($_GET['idperundangan'])?$_GET['idperundangan']:"";
  $perundangan= isset ($_GET['perundangan'])?$_GET['perundangan']:"";
  $idPacking= isset ($_GET['idPacking'])?$_GET['idPacking']:"";
  $packing_barang= isset ($_GET['packing_barang'])?$_GET['packing_barang']:"";
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
					 $("#idPenduduk").attr('value',data.idpddk);			
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
								 $("#idPenduduk").attr('value',data.idpddk);	
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
            $('#perundangan').autocomplete("<?= app_base_url('/admisi/search?opsi=perundangan') ?>",
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
                            $('#idPegawai').attr('value','');
                            var str='<div class=result>'+data.nama+'</div>';
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $(this).attr('value',data.nama);
                    $('#idperundangan').attr('value',data.id);
                }
            );
        });
	 $(function() {
        $('#packing_barang').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
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
                           var str='';
              var str=ac_nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)
return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
            var str=nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)

$(this).attr('value', str);
               $('#idPacking').attr('value',data.id);
            }
        );
});
</script>
<h2 class="judul">Riwayat Pemakaian Obat Psikotropik dan Narkotik  Pasien</h2>
<form action="" method="GET">
<div class="data-input">
    <fieldset>
        <legend>Parameter Pencarian</legend>
           <label for="noRm">No. Rekam Medik</label>
   <input type="text" name="idPasien" id="idPasien" value="<?= $id_pas ?>" />
        <label for="Pasien">Nama Pasien/Pembeli</label>
        <input type="text" name="pasien" id="pasien" value="<?= $pasien?>">
        <input type="hidden" name="idPenduduk" id="idPenduduk" value="<?= $idPenduduk?>">
        <label for="Perundangan">Golongan Perundangan</label>
          <input type="text" name="perundangan" id="perundangan" value="<?= $perundangan?>">
    <input type="hidden" name="idPerundangan" id="idPerundangan" value="<?= $idPerundangan?>">
      <label for="Packing Brang">Nama Packing Barang</label>
          <input type="text" name="packing_barang" id="packing_barang" value="<?= $packing_barang?>">
<input type="hidden" name="idPacking" id="idPacking" value="<?= $idPacking?>">
        <fieldset class="input-process">
            <input type="submit" class="tombol" value="Cari" name="cari">
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/info-ketersediaan-bed-rawat-inap') ?>'"/>
        </fieldset>
    </fieldset>
</div>
</form>  

<div class="data-list">
<?php if(isset ($_GET['cari'])){ ?>
    <table class="tabel" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <th>Waktu</th>
             <th>No.Nota Penjualan</th>
            <th>Packing Barang</th>
            <th>Jumlah</th>
        </tr>
        <?
          $no = 1;
          $info = riwayat_pemakaian_narkotik_muat_data($idPenduduk,$idPerundangan,$idPacking);
          foreach($info as $row){
		   if ($row['generik'] == 'Generik') {
                            $nama = ($row['kekuatan']!=0)?"$row[obats] $row[kekuatan], $row[sediaan]":"$row[obats] $row[sediaan]";
                   }
		   if ($row['generik'] == 'Non Generik') {
                            $nama = ($row['kekuatan']!=0)?"$row[obats] $row[kekuatan]":"$row[obats] ";
                   }else $nama = $row['obats'];
                    
              $nama .=" @$row[nilai_konversi] $row[satuan_terkecil]";
              $nama .=($row['generik'] == 'Generik')?' '. $row['pabrik']:'';
			  
		?>
          <tr class="<?= ($no%2)?"even":"odd"?>">
             
            <td><?= $row['waktu']?></td>
              <td><?= $row['nota']?></td>
               <td><?= $nama?></td>
              <td><?= $row['jumlah']?></td>
          </tr>
        <?
          }
        ?>
    </table>
</div>

<?
}
?>