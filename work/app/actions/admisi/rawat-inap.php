<?php
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-data.php";
  include_once 'app/actions/admisi/pesan.php';
  set_time_zone();
  $date		= Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $bed		= bed_rawat_inap();
  $layanan	= layanan_rawat_inap_muat_data();
  $code = (isset($_GET['code'])) ? $_GET['code'] : null;
  $idBilling = isset ($_GET['idBilling'])?$_GET['idBilling']:"";
    $action= isset ($_GET['action'])?$_GET['action']:"";
    $idTarif = isset ($_GET['idTarif'])?$_GET['idTarif']:"";
  $idKunjungan = isset ($_GET['idKunjungan'])?$_GET['idKunjungan']:"";
  if($code==null){
?>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#cetak").click(function(){
            var win = window.open('print/wristbands?norm=<?= isset($_GET['norm'])?$_GET['norm']:null ?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>  
<script type="text/javascript">
    function get_asuransi(id_kunjungan){
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
    };
    $(function() {
        $('#noRm').focus();
        $('#noRm').autocomplete("<?= app_base_url('/admisi/search?opsi=norm_kunjungan') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].penduduk // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        $('#tblRawatInap').html('');
                        if(data.alamat_jalan == null){
                            data.alamat_jalan = "";
                        }
                        if(data.kelurahan == null){
                            data.kelurahan = "";
                        }
                        if(data.kecamatan == null){
                            data.kecamatan = "";
                        }
                        if(data.kabupaten == null){
                            data.kabupaten = "";
                        }
						 if(data.asuransi == null){
                            data.asuransi = "";
                        }
                        var str='<div class=result>'+data.pasien+' '+data.penduduk+' <br/> <i>'+data.alamat_jalan+' '+data.kelurahan+' '+data.kecamatan+' '+data.kabupaten+'</i></div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                    $('#pasien').val(data.penduduk);
                    $('#idKunjungan').attr('value',data.id);
                    $('#noRm').val(data.pasien);
                    $('#billing').val(data.id_billing);
                    var carabayar="";
                    if(data.carabayar=="Charity"){
                        carabayar="Asuransi";
                    }else{
                        carabayar=data.carabayar;
                    }
		 $("#bayar").attr('value',carabayar);
		 $(".bayar").html(carabayar);
		 
		
                    $('#noKunjunganPasien').val(data.no_kunjungan_pasien);
                    var id_kunjungan=data.id;
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
                    
                    var id_pasien = data.pasien;
                    $.ajax({
                        url: "<?= app_base_url('admisi/rawat-inap-table')?>",
                        cache:false,
                        data: "&norm="+data.pasien+"&no_kunjungan_pasien="+data.no_kunjungan_pasien+"&billing="+data.id_billing+"&idKunjungan="+data.id,
                        success:function(msg){
                            $('#tblRawatInap').html(msg);
                        }
                    });
            });
    });
    
    $(function() {
        $('#pasien').autocomplete("<?= app_base_url('/admisi/search?opsi=kunjungan') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].penduduk // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        $('#tblRawatInap').html('');
                        if(data.alamat_jalan == null){
                            data.alamat_jalan = "";
                        }
                        if(data.kelurahan == null){
                            data.kelurahan = "";
                        }
                        if(data.kecamatan == null){
                            data.kecamatan = "";
                        }
                        if(data.kabupaten == null){
                            data.kabupaten = "";
                        }
						 if(data.asuransi == null){
                            data.asuransi = "";
                        }
                        var str='<div class=result>'+data.pasien+' '+data.penduduk+' <br/> <i>'+data.alamat_jalan+' '+data.kelurahan+' '+data.kecamatan+' '+data.kabupaten+'</i></div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                    $('#pasien').val(data.penduduk);
                    $('#idKunjungan').attr('value',data.id);
                    $('#noRm').val(data.pasien);
                    $('#billing').val(data.id_billing);
                    $('#noKunjunganPasien').val(data.no_kunjungan_pasien);
                    $("#bayar").attr('value',data.carabayar);
                    $(".bayar").html(data.carabayar);
                    var id_kunjungan=data.id;
                    
                    get_asuransi(id_kunjungan);
                    
                    var id_pasien = data.pasien;
                    $.ajax({
                        url: "<?= app_base_url('admisi/rawat-inap-table')?>",
                        cache:false,
                         data: "&norm="+data.pasien+"&no_kunjungan_pasien="+data.no_kunjungan_pasien+"&billing="+data.id_billing+"&idKunjungan="+data.id,
                        success:function(msg){
                            $('#tblRawatInap').html(msg);
                        }
                    });
            });
});

$(function(){
       $('#namaTarif').autocomplete("<?= app_base_url('/admisi/search?opsi=layananBillingRW') ?>",
       {
        //   extraParams:{
             //  jenis: function() { return "rawat_inap"; },
           //    instalasi: function() {return $('#idInstalasi').attr('value')}
           //},
           parse: function(data){
               var parsed = [];
               for (var i=0; i < data.length; i++) {
                   parsed[i] = {
                       data: data[i],
                       value: data[i].layanan // nama field yang dicari
                   };
               }
               return parsed;
           },
           formatItem: function(data,i,max){
                   var bobot=(data.bobot == 'Tanpa Bobot')?"":" "+data.bobot;
                               var profesi=(data.profesi == 'Tanpa Profesi')?"":" "+data.profesi;
                               var spesialisasi=(data.spesialisasi == 'Tanpa Spesialisasi')?"":" "+data.spesialisasi;
                               var kelas=(data.kelas == 'Tanpa Kelas'||data.kelas == 'Semua')?"":" "+data.kelas;
                               var instalasi;
                               if(data.instalasi == 'Rekam Medik'  || data.instalasi == 'Semua' || data.instalasi == 'Tanpa Instalasi'){
                                   instalasi = "";   
                               }else instalasi = " "+data.instalasi;
                            
                               var layanans=(data.jenis == "Rawat Inap" && data.instalasi != 'Semua' && data.instalasi != 'Tanpa Instalasi')?data.layanan+' '+data.instalasi:data.layanan;
                               
                               if (layanans == ' null') layanans = '';
                               if (bobot == ' null') bobot = '';
                               if (profesi == ' null') profesi = '';
                               if (spesialisasi == ' null') spesialisasi = '';
                               if (instalasi == ' null') instalasi = '';
                               if (kelas == ' null') kelas = '';

                               var layanan =layanans+profesi+spesialisasi+bobot+instalasi+kelas;
                            
                               var str='<div class=result>'+layanan+'</div>';
                               return str;
           },
           width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
           dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
       }).result(
       function(event,data,formated){
            var bobot=(data.bobot == 'Tanpa Bobot')?"":" "+data.bobot;
                           var profesi=(data.profesi == 'Tanpa Profesi')?"":" "+data.profesi;
                           var spesialisasi=(data.spesialisasi == 'Tanpa Spesialisasi')?"":" "+data.spesialisasi;
                           var kelas=(data.kelas == 'Tanpa Kelas'||data.kelas == 'Semua')?"":" "+data.kelas;
                           var instalasi;
                           if(data.instalasi == 'Rekam Medik'  || data.instalasi == 'Semua' || data.instalasi == 'Tanpa Instalasi'){
                               instalasi = "";    
                           }else instalasi = " "+data.instalasi;
                           var layanans=(data.jenis == "Rawat Inap" && data.instalasi != 'Semua' && data.instalasi != 'Tanpa Instalasi')?data.layanan+' '+data.instalasi:data.layanan;                           
                           if (layanans == ' null') layanans = '';
                               if (bobot == ' null') bobot = '';
                               if (profesi == ' null') profesi = '';
                               if (spesialisasi == ' null') spesialisasi = '';
                               if (instalasi == ' null') instalasi = '';
                               if (kelas == ' null') kelas = '';
                           var layanan =layanans+profesi+spesialisasi+bobot+instalasi+kelas;
                           $(this).attr('value',layanan);
           $("#idLayanan").val(data.id_layanan);
           $("#idTarif").val(data.tarif);
       }
   );
})

$(function() {
       $('#bed').autocomplete("<?= app_base_url('/admisi/search?opsi=bed_rawat_inap') ?>&status=Kosong",
       {
           parse: function(data){
               var parsed = [];
               for (var i=0; i < data.length; i++) {
                   parsed[i] = {
                       data: data[i],
                       value: data[i].nama+' '+data[i].instalasi // nama field yang dicari
                   };
               }
               return parsed;
           },
           formatItem: function(data,i,max){
               var kelas;
               if(data.kelas == "Semua" || data.kelas == "Tanpa Kelas"){
                   kelas = "";
               }else kelas = ' <i>Kelas : '+data.kelas+'</i>';
               var str='<div class=result>'+data.nama+' '+data.instalasi+kelas+'</div>';
               return str;
           },
           width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
           dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
       }).result(
       function(event,data,formated){
           var kelas;
           if(data.kelas == "Semua" || data.kelas == "Tanpa Kelas"){
               kelas = "";
           }else kelas = ' Kelas: '+data.kelas+'';
           
           $(this).attr('value',data.nama+' '+data.instalasi+kelas);
           $("#idBed").val(data.id);
           $("#idKelas").val(data.id_kelas);
           $("#idInstalasi").val(data.id_instalasi);
       }
   );
})
$(function() {
                        $('#dokter').autocomplete("<?= app_base_url('/inventory/search?opsi=caridokter') ?>",
                        {
                            parse: function(data){
                                var parsed = [];
                                for (var i=0; i < data.length; i++) {
                                    parsed[i] = {
                                        data: data[i],
                                        value: data[i].nama// nama field yang dicari
                                    };
                                }
                                return parsed;
                            },
                            formatItem: function(data,i,max){
                                var sip=data.sip=='NULL'?'-':data.sip;
                                var str='<div class=result>Nama :<b>'+data.nama+'</b><br /><i>SIP</i>: '+sip+'<br /><i>Alamat</i>: '+data.alamat_jalan+'<i> Kecamatan</i>: '+data.kecamatan+'<i> Kabupaten</i>: '+data.kabupaten+'<i> Provinsi</i>: '+data.provinsi+'</div>';
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            $(this).attr('value',data.nama);
                            $('#idDokter').attr('value',data.id);
                        });
                    });

function cek(data) {
        if($('#noRm').val() == ""){
            alert('No. RM harus diisi');
            $('#noRm').focus();
            return false;
        }
        if($('#pasien').val() == ""){
            alert('Nama pasien harus diisi');
            $('#pasien').focus();
            return false;
        }
        if($('#idKunjungan').val() == ""){
            alert('No. Tagihan belum terisi, ulangi pilih nama pasien atau No. RM');
            $('#noRm').focus();
            return false;
        }
        if ($('#bed').val() == "") {
                alert('No. Bed belum dipilih');
                $('#bed').focus();
                return false;
        }
        if($('#idBed').val() == ""){
               alert('No. Bed belum dipilih dengan benar, ulangi lagi');
               $('#bed').focus();
               return false;
        }
	if($('#idDokter').val() == ""){
            alert('Dokter harus diisi');
            $('#dokter').focus();
            return false;
        }
        if($('#pasien').val() == ""){
            alert('Nama pasien tidak boleh kosong');
            $('#pasien').focus();
            return false;
        }
        if($('#noRm').val() == ""){
            alert('No. RM harus diisi');
            $('#noRm').focus();
            return false;
        }
        if ($('#namaTarif').val() == "") {
            alert('Nama tarif tidak boleh kosong');
            $('#namaTarif').focus();
            return false;
        }
        if ($('#idTarif').val() == "") {
            alert('Tarif belum dipilih dengan benar, ulangi lagi');
            $('#namaTarif').focus();
            return false;
        }
}
</script>
<?php } 
  if(isset ($_GET['norm']) && isset ($_GET['idKunjungan'])){
    $rawatInap = confirm_rawat_inap($_GET['norm']);
    foreach ($rawatInap as $ri);
    $nota = $ri['id_billing'];
    $pasien = $ri['pasien'];
    $norm = $ri['norm'];
    $dokter = $ri['dokter'];
    $tarif = $ri['layanan'].' '.$ri['instalasi'].' '.$ri['kelas'];
    $detail = detail_rawat_inap($_GET['idKunjungan']);
    $getasuransi= detail_asuransi($_GET['norm']);

    foreach ($detail as $det);
    $beds = $det['bed'].' '.$det['instalasi'].' Kelas: '.$det['kelas'];
	 $bayar=$det['paying'];
  }else{
      $nota = '';
      $pasien = '';
      $norm = '';
      $dokter = '';
      $tarif = '';
      $beds = '';
      $asuransi = '';
      $bayar = '';
  }
if ($action =='preview'){
$disable="disabled='disabled'";
$ro="readonly='readonly'";
}
else{
$disable="";
$ro="";
}
?>
<h2 class="judul">Mutasi Rawat Inap</h2><?=  isset ($pesan)?$pesan:''?>
<div class="data-input">   
	<form action="<?= app_base_url('admisi/control/rawat-inap') ?>" method="POST" onSubmit="return cek(this)">
		<fieldset>
			<legend>Form Rawat Inap</legend>
			<label for="noRm">No. Rekam Medik*</label><input type="text" name="noRm" id="noRm" value="<?php echo "$norm";?>" <?=$ro?> />
                        <label for="pasien">Nama Pasien*</label>
                        <input type="text" name="pasien" id="pasien" value="<?php echo "$pasien";?>" <?=$ro?> />
                        <label for="billing">No. Tagihan*</label><input type="text" name="billing" id="billing" style="border:none" readonly="readonly" value="<?php echo "$nota";?>"/>
                            <label for="bayar">Cara Bayar</label><span style="font-size: 12px;padding-top: 5px;" class="bayar"><?=$bayar;?></span>
                            <input type="hidden" id="bayar" name="bayar" value="<?=$bayar;?>">
                <label for="asuransi">Produk Asuransi</label><span style="font-size: 12px;padding-top: 5px;" class="asuransi"> <ol style='margin-left:0;padding-left:14px;'>
				 
				<?  
				 if(isset ($_GET['norm']) && isset ($_GET['idKunjungan'])){
				foreach ($getasuransi as $get){?>
				
				<li style='font-size:12px;padding-bottom:2px'><?=$get['nama_asuransi']?></li>
              <?  }
			  }?>
              </ol>
                </span>
                <input type="hidden" id="asuransi" name="asuransi" value="<?=$asuransi?>">
        
                        <label for="waktu">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= date('d-m-Y')?></span><span style="font-size: 12px;padding-top: 5px;margin-left: 5px" id="jam"></span>
                        <label for="petugas">Petugas*</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama']?></span>
                        <label for="bed">Bed</label><input type="text" name="bed" id="bed" value="<?php echo "$beds";?>" <?=$ro?> //>
			<input type="hidden" name="idBed" id="idBed" />
            <input type="hidden" name="idKelas" id="idKelas" />
            <input type="hidden" name="idInstalasi" id="idInstalasi" />
                        <label for="dokter">Dokter*</label>
                        
                        <input type="text" id="dokter" value="<?php echo "$dokter";?>" <?=$ro?> //>
			<input type="hidden" id="idDokter" name="idDokter" />
			<input type="hidden" name="idKunjungan" id="idKunjungan" />
			<label for="tarif">Nama Tarif*</label><input type="text" name="namaTarif" id="namaTarif" value="<?php echo "$tarif";?>" <?=$ro?> //>
                        <input type="hidden" name="idTarif" id="idTarif" />
			<input type="hidden" name="idLayanan" id="idLayanan" />
                        <input type="hidden" name="noKunjunganPasien" id="noKunjunganPasien" />
			<fieldset class="input-process">
                          
                            <input type="submit" name="submit" class="tombol" value="Simpan" <?=$disable?> />
                            <input type="button" name="cancel" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('admisi/rawat-inap')?>'" />
			</fieldset>
			
		</fieldset>
        
                <div id="tblRawatInap">
                    
                </div>
		<?php
                    if (isset($_GET['idKunjungan']))
                    {
		?>
                       <div class="data-list">
                           <table class="tabel" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <th width="5%">No</th>
                           <!--     <th width="12%">Waktu</th>-->
                              <th width="15%">Instalasi</th>
                                 <!-- <th>Nama Pasien</th>
                                <th>No. RM</th>
                                <th>Alamat</th>
                                <th>Kelurahan</th>
                                <th>Nama Dokter</th>
                               -->
                             
                              <th width="10%">Kelas</th>
                              <th width="20%">No. Bed</th>
                              <th width="20%">Nama Dokter</th>
                              <th width="20%">Aksi</th>
                            </tr>
                            <?
                              $no = 1;
                              $info = detail_rawat_inap($_GET['idKunjungan']);
                              foreach($info as $row){
							  
                            ?>
                          
                              <tr class="<?= ($no%2)?"even":"odd"?>">
                                  <td align="center"><?= $no++?></td>
                              <!--    <td align='center'><?//datetime($row['tanggal'])?></td>-->
                                    <td align='center'><?= $row['instalasi']?></td>
                                 <!-- <td class="no-wrap"><? //$row['pasien']?></td>
                                  <td><? //$row['norm']?></td>
                                  <td class="no-wrap"><? // $row['alamat_jalan']?></td>
                                  <td><?  //$row['kelurahan']?></td>
                                  <td><? //$row['nama_dokter']?></td>
                               -->
                                
                                  <td><?= $row['kelas']?></td>
                                     <td><?= $row['bed']?></td>
                                     <td><?=$row['nama_dokter']?></td>
                                  <td align='center'>
                                  <? if ($action !='preview'){?>
                                   <!-- <span class="discharge"><a href="<?//app_base_url('admisi/control/discharge?idBilling=').$idBilling."&idKunjungan=".$idKunjungan."&idTarif=".$id_detail_billing['id_tarif']?>" onClick="return confirm('Apakah Anda yakin akan mendischarge pasien berikut?')">Discharge</a></span>-->
                                          <span class='cetak' id='cetak' style='margin-left: 10px'>Cetak Gelang</span>
                                          <? }
										  else{
										  echo "&nbsp;";
										  }
										  ?>
                                  </td> 
                            <?
                              }
                            ?>
                           </table>
                       </div>
	</form>    

</div>  
<?php
  if ($action !='preview'){
        //echo date("Y-m-d");
        $id = $_GET['idKunjungan'];
        echo "<span class=\"cetak\" onclick=\"win = window.open('".app_base_url('admisi/print/rawat-inap')."?idKunjungan=$id', 'mywindow', 'location=1, status=1, scrollbars=1, width=800px');\">Cetak Lembar Rawat Inap</span>";
    }
    }else if($code!=null){
        require_once "app/actions/admisi/rawat-inap-table.php";
    }
?>

<script type="text/javascript">
    function jam(){
        var waktu = new Date();
        var jam = waktu.getHours();
        var menit = waktu.getMinutes();
        var detik = waktu.getSeconds();

        if (jam < 10){
        jam = "0" + jam;
        }
        if (menit < 10){
        menit = "0" + menit;
        }
        if (detik < 10){
        detik = "0" + detik;
        }
        var jam_div = document.getElementById('jam');
        jam_div.innerHTML = jam + ":" + menit + ":" + detik;
        setTimeout("jam()", 1000);
    }
    jam();
</script>
