<?php 
 include 'app/actions/admisi/pesan.php';
?>
<h2 class="judul">Pelayanan Medik</h2><?= isset($pesan) ? $pesan : NULL ?>
<script type="text/javascript">
  $(function() {
       $('#waktu').datetimepicker({
           dateFormat: 'dd/mm/yy',
           timeFormat: 'hh:mm:ss',
           changeMonth: true,
           changeYear: true,
           showSecond: true
       });
       $('#namaPasien').autocomplete("<?= app_base_url('/admisi/search?opsi=pasien_rm') ?>",
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
               var str='<div class=result>'+data.id_pasien+' '+data.nama_pas+'<br /><i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
               return str;
           },
           width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
           dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
       }).result(
       function(event,data,formated){
           $(this).attr('value',data.nama_pas);
           $('#norm').val(data.id_pasien);
           $('#tglLahir').val(data.tanggal_lahir)
           hitungUmur();
           $('#agama').html(data.agama);
           $('#pekerjaan').html(data.pekerjaan);
           $('#alamat').html(data.alamat_jalan);
           $('#kelurahan').html(data.nama_kelurahan);
       });
       
       $('#norm').autocomplete("<?= app_base_url('/admisi/search?opsi=noRm') ?>",
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
               var str='<div class=result>'+data.id_pasien+' '+data.nama_pas+'<br /><i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
               return str;
           },
           width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
           dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
       }).result(
       function(event,data,formated){
           $(this).attr('value',data.id_pasien);
           $('#namaPasien').val(data.nama_pas);
           $('#tglLahir').val(data.tanggal_lahir)
           hitungUmur();
           $('#agama').html(data.agama);
           $('#pekerjaan').html(data.pekerjaan);
           $('#alamat').html(data.alamat_jalan);
           $('#kelurahan').html(data.nama_kelurahan);
       });
       
       $('#bed').autocomplete("<?= app_base_url('/admisi/search?opsi=bed_all') ?>",
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
               var str='<div class=result>Klinik <b>'+data.nama+' '+data.instalasi+'</b></div>';
               return str;
           },
           width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
           dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
       }).result(
       function(event,data,formated){
           $(this).attr('value','Klinik '+data.nama+' '+data.instalasi);
           $('#id_bed').val(data.id);
           $('#jenis').val(data.jenis);
           $('#jenis_label').html(data.jenis);
       });
       
       $('#dokter').autocomplete("<?= app_base_url('/admisi/search?opsi=dokter_rm') ?>",
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
               var sip = data.sip!='NULL'?data.sip:'';
               var str='<div class=result>Nama :<b>'+data.dokter+'</b><br /><i>SIP</i>: '+sip+'<br /><i>Alamat</i>: '+data.alamat_jalan+'<i> Kecamatan</i>: '+data.kecamatan+'<i> Kabupaten</i>: '+data.kabupaten+'<i> Provinsi</i>: '+data.provinsi+'</div>';
               return str;
           },
           width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
           dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
       }).result(
       function(event,data,formated){
           $(this).attr('value',data.dokter);
           $('#id_dokter').attr('value',data.id_dokter);
       });
       
       $('#kejadian').autocomplete("<?= app_base_url('/admisi/search?opsi=kejadian') ?>",
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
               var str='<div class=result>Nama :<b>'+data.nama+'</b><br /><i>Waktu tiba</i>: '+data.waktu_tiba+'<br /><i>Waktu kejadian</i>: '+data.waktu_kejadian+'<br /><i> Alamat</i>: '+data.alamat_jalan+'<i> Kelurahan</i>: '+data.kelurahan+'</div>';
               return str;
           },
           width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
           dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
       }).result(
       function(event,data,formated){
           $(this).attr('value',data.nama);
           $('#id_kejadian').attr('value',data.id);
           $('#waktu_tiba').html(data.waktu_tiba);
           $('#waktu_kejadian').html(data.waktu_kejadian);
           $('#alamat_kejadian').html(data.alamat_jalan);
           $('#kelurahan_kejadian').html(data.kelurahan);
           $('#penyebab_kejadian').html(data.penyebab_cedera);
       });
   });
   
   $(document).ready(function(){
       $('#alasanDatang').change(function(){
       if($(this).val()=='Penyakit'){
           $("#kejadian").attr('disabled','disabled');
           $("#kejadian").attr('value','');
           $('#id_kejadian').attr('value','');
           $('#waktu_tiba').html('');
           $('#waktu_kejadian').html('');
           $('#alamat_kejadian').html('');
           $('#kelurahan_kejadian').html('');
           $('#penyebab_kejadian').html('');       
       }else{
           $("#kejadian").removeAttr('disabled','disabled');
       }
   });
   });
   
   function cekForm(){
       if($('#norm').val() == ""){
           alert('No. RM harus diisi');
           $('#norm').focus();
           return false;
       }else if($('#namaPasien').val() == ""){
           alert('Nama pasien harus diisi');
           $('#namaPasien').focus();
           return false;
       }else if($('#bed').val() == ""){
           alert('Nama bed harus diisi');
           $('#bed').focus();
           return false;
       }else if($('#id_bed').val() == ""){
           alert('Pilih bed dengan benar');
           $('#bed').focus();
           return false;
       }else if($('#dokter').val() == ""){
           alert('Dokter tidak boleh kosong');
           $('#dokter').focus();
           return false;
       }else if($('#id_dokter').val() == ""){
           alert('Pilih dokter dengan benar');
           $('#dokter').focus();
           return false;
       }
//       else if($('#kejadian').val() == ""){
//           alert('Nama kejadian harus diisi');
//           $('#kejadian').focus();
//           return false;
//       }
//       else if($('#id_kejadian').val() == ""){
//           alert('Pilih nama kejadian dengan benar');
//           $('#id_kejadian').focus();
//           return false;
//       }
   }
</script>
<div class="data-input">
    <form action="<?= app_base_url("rekam-medik/control/lembar-rekam-medik") ?>" method="POST" onsubmit="return cekForm()">
    <fieldset>
        <legend>Form Lembar Rekam Medik</legend>
        <table width="100%">
            <tr>
                <td valign="top" width="50%">
                    <fieldset style="width: 90%">
                        <legend>Pasien</legend>
                        <label>No. RM*</label><input type="text" name="norm" id="norm" />
                        <label>Nama Lengkap*</label><input type="text" name="namaPasien" id="namaPasien" />
                        <fieldset class="field-group">
                            <label>Umur</label>
                            <input type="hidden" id="tglLahir"/>
                            <span style="font-size: 12px;padding-top: 5px;" id="umur"></span>
                        </fieldset>
                        <label>Agama</label><span style="font-size: 12px;padding-top: 5px;" id="agama"></span>
                        <label>Pekerjaan</label><span style="font-size: 12px;padding-top: 5px;" id="pekerjaan"></span>
                        <label>Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"></span>
                        <label>Kelurahan</label><span style="font-size: 12px;padding-top: 5px;" id="kelurahan"></span>
                    </fieldset>
                    <label>Waktu</label><input type="text" name="waktu" id="waktu" class="timepicker"/>
                    <label>Bed*</label><input type="text" name="bed" id="bed" /><input type="hidden" name="id_bed" id="id_bed"/>
                    <label>Dokter*</label><input type="text" name="dokter" id="dokter"/><input type="hidden" name="id_dokter" id="id_dokter"/>
                    <label>Jenis Pelayanan</label>
                    <input type="hidden" name="jenis" id="jenis" value=""/>
                    <span id="jenis_label"></span>
                    <!--<select name="jenis" id="jenis">                        
                        <option value="">Pilih jenis pelayanan</option>
                        <option value="Rawat Jalan">Rawat Jalan</option>
                        <option value="Rawat Inap">Rawat Inap</option>
                    </select>-->
                    <fieldset style="width: 90%">
                        <legend>Anamnesa</legend>
                        <textarea name="anamnesa" id="anamnesa"></textarea>
                    </fieldset>
                    <fieldset style="width: 90%">
                        <legend>Pemeriksaan</legend>
                        <label>KU</label><textarea name="ku" id="ku"></textarea>
                        <label>Laboratorium</label><textarea name="laboratorium" id="laboratorium"></textarea>
                        <label>Radiologi</label><textarea name="radiologi" id="radiologi"></textarea>
                    </fieldset>
                </td>
                <td valign="top">
                    <fieldset style="width: 90%">
                        <legend>Terapi</legend>
                        <textarea name="terapi" id="terapi"></textarea>
                    </fieldset>
                    <label>Alasan Datang</label>
                    <select name="alasanDatang" id="alasanDatang">
                        <option value="">Pilih alasan datang</option>
                        <option value="Penyakit">Penyakit</option>
                        <option value="KLL">KLL</option>
                        <option value="Kecelakaan Kerja">Kecelakaan Kerja</option>
                        <option value="Kecelakaan Lain">Kecelakaan Lain</option>
                        <option value="Trauma">Trauma</option>
                    </select>
                    <fieldset style="width: 90%">
                        <legend>Kejadian</legend>
                        <label>Nama</label><input type="text" name="kejadian" id="kejadian" /><input type="hidden" name="id_kejadian" id="id_kejadian"/>
                        <label>Waktu Tiba</label><span style="font-size: 12px;padding-top: 5px;" id="waktu_tiba"></span>
                        <label>Waktu Kejadian</label><span style="font-size: 12px;padding-top: 5px;" id="waktu_kejadian"></span>
                        <label>Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat_kejadian"></span>
                        <label>Kelurahan</label><span style="font-size: 12px;padding-top: 5px;" id="kelurahan_kejadian"></span>
                        <label>Penyebab Kejadian</label><span style="font-size: 12px;padding-top: 5px;" id="penyebab_kejadian"></span>
                    </fieldset>
                    <fieldset style="width: 90%">
                        <legend>Keterangan</legend>
                        <textarea name="keterangan" id="keterangan"></textarea>
                    </fieldset>
                    <fieldset class="field-group">
                       <legend>Resusitasi</legend>
                       <label class="field-option">
                           <input id="resusitasiY" type="radio" value="Ya" name="resusitasi" />Ya
                       </label>
                       <label class="field-option">
                           <input id="resusitasiT" type="radio" value="Tidak" name="resusitasi" />Tidak
                       </label>
                    </fieldset>
                    <label>Tindak Lanjut</label>
                    <select name="tindakLanjut" id="tindakLanjut">
                        <option value="">Pilih tindak lanjut</option>
                        <option value="Dipulangkan">Dipulangkan</option>
                        <option value="Rawat Inap">Rawat Inap</option>
                        <option value="Dirujuk">Dirujuk</option>
                        <option value="APS">APS</option>
                        <option value="Meninggal">Meninggal</option>
                    </select>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="field-group">
        <input type="submit" value="Simpan" name="save" class="tombol" />
        <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('rekam-medik/lembar-rekam-medik') ?>'"/>
    </fieldset>    
    </form>    
</div>

