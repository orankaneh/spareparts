<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/lib/admisi/admisi-models.php';
require 'app/actions/admisi/pesan.php';
set_time_zone();
$profesi = profesi_muat_data();
$pekerjaan = pekerjaan_muat_data();
$agama = agama_muat_data();
$pendidikan = pendidikan_muat_data();
$instalasi = instalasi_muat_data();
$new_number = create_medical_record_number();
$new_number = $new_number['new_number'];

$bed = bed_by_kelas_instalasi();
$input = "disabled";

?>
<h1 class="judul">Kunjungan Rawat Jalan</h1>
<script type="text/javascript">
  $(function(){
      $('#layanan').focus();
  })
</script>
<?php echo isset($pesan) ? $pesan : null; ?>
<form action="<?= app_base_url('admisi/control/kunjungan-p/add') ?>" method="post" onsubmit="return field_check(this)">
    <div class="data-input">
        <fieldset><legend>Form Kunjungan Rawat Jalan</legend>
            <fieldset style="border: none">
                <table width="100%">
                    <tr>
                        <td valign="top">
                            <label for="layanan">Layanan*</label><input type="text" id="layanan" size="50%" width="50%">
                            <label for="dokter">Nakes *</label>
                           
                            <input type="text" size="50%" width="50%" id="dokter" <?= $input ?> >
                            <input type="hidden" id="idDokter" name="idDokter">
                            <label for="namaRuang">Klinik*</label>
                            <input type="text" id="bed" <?= $input ?>>
                            <input type="hidden" name="idBed" id="idBed">
                            <input type="hidden" name="no_antri" value="" />
                            <input type="hidden" name="layanan" id="idLayanan"/>
                            <label for="noRm">No. Rekam Medik</label> <input type="text" name="noRm" id="noRm" value="<?= noRm($new_number) ?>" <?= $input ?>>
                            <input type="hidden" name="no_rm" id="no_rm">
							
							<label for="nama">NIK*</label> <input type="text" name="nik" size="50%" width="50%" id="nik" <?= $input ?> onKeyup="new_nik('nik')">
							
                            <label for="nama">Nama Lengkap*</label> <input type="text" name="nama" size="50%" width="50%" onKeyup="new_nik('nama')" id="nama" <?= $input ?>>
							<input type="hidden" name="idPenduduk" id="idPenduduk">
							
							<fieldset class="field-group">
								<label for="alamatJln">Alamat / RT / RW*</label>
								<input type="text" name="alamatJln" id="alamatJln" <?= $input ?> size='35'>
								<!--<span><input type="text" name="rt" size='2' id="rt" <?= $input ?>></span>
								<span><input type="text" name="rw" size='2' id="rw" <?= $input ?>></span>-->
							</fieldset>
                            <label for="kelurahan">Desa / Kelurahan*</label>
                            <input type="text" name="kelurahan" id="kelurahan" <?= $input ?>>
                            <input type="hidden" name="idKel" id="idKel"> <br/>
							 <label></label><div id='wil'>
							<span id="wilayah" ></span>
							</div>
                            <input type="hidden" name="idKec" id="idKec">
                            <input type="hidden" name="idKab" id="idKab">
                            <fieldset class="field-group">
                                <legend>Jenis Kelamin </legend>&nbsp;
                                <label for="laki-laki" class="field-option"><input type="radio" name="kelamin" id="laki-laki" value="L" <?= $input ?>> Laki-laki</label>
                                <label for="perempuan" class="field-option"><input type="radio" name="kelamin" id="perempuan" value="P" <?= $input ?>> Perempuan</label>
                            </fieldset>

                            <label for="gol">Golongan Darah</label>
                            <select name="gol" id="gol" <?= $input ?>><option value="">Tidak tahu</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>

                            <fieldset class="field-group">
                                <label for="tglLahir">Tanggal lahir</label>
                                <input type="text" id="tglLahir" name="tglLahir" class="tgl" value="" <?= $input ?> />
                                <label for="umur-tahun" class="inline-title">Umur:</label>
                                <input type="text" id="umur-tahun"  value="" class="umur2" onKeyup="Angka(this)" />
                                <span>Thn</span>
                                <input type="text" id="umur-bulan"  value="" class="umur2" onKeyup="Angka(this)" />
                                <span>Bln</span>
                                <input type="text" id="umur-hari" value="" class="umur2" onKeyup="Angka(this)" />
                                <span>Hr</span>
                            </fieldset>
                            <label for="idPkw">Status Perkawinan</label>
                            <select name="idPkw" id="idPkw" <?= $input ?>>
								<option value="">Pilih status</option>
                                <option value="Lajang">Lajang</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Janda">Janda</option>
                            </select>

                                <label for="pendidikan">Pendidikan Terakhir</label>
                                <select name="pendidikan" id="pendidikan" <?= $input ?>>
                                <?php 
                                  foreach ($pendidikan as $row): 
                                      if($row['id'] == 1){
                                       echo "<option value='$row[id]'>Pilih pendidikan</option>";   
                                      }else{
                                ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                <?php } endforeach; ?>
                                    </select>

                                    <label for="namaPkj">Profesi</label>
                                    <select name="profesi" id="profesi" <?= $input ?>>
                                <?php 
                                  foreach ($profesi as $row): 
                                      if($row['id'] == 1){
                                       echo "<option value='$row[id]'>Pilih profesi</option>";   
                                      }else{
                                ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                <?php } endforeach; ?>
                                        </select>
                                        <label for="namaPkj">Pekerjaan</label>
                                        <select name="pekerjaan" id="pekerjaan" <?= $input ?>>
                                <?php 
                                  foreach ($pekerjaan['list'] as $row): 
                                     if($row['id'] == 1){
                                       echo "<option value='$row[id]'>Pilih pekerjaan</option>";   
                                      }else{ 
                                ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                <?php } endforeach; ?>
                                            </select>

                                <label for="idAgama">Agama</label>
                                <select name="agama" id="agama" <?= $input ?>>
                                    <option value="">Pilih agama</option>
                                <?php foreach ($agama['list'] as $row): ?>
                                                    <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                <?php endforeach; ?>
                                                </select>
                                            </td>
								<td valign="top">

                                                <fieldset>
                                                    <legend>Rencana Cara Pembayaran</legend>
                                                    <fieldset class="field-group">
                                                        <input type="radio" name="caraPembayaran" value="Bayar Sendiri" checked> Bayar Sendiri
                                                        <input type="radio" name="caraPembayaran" value="Charity"> Charity
                                                    </fieldset>
                                                </fieldset>
                                                <fieldset class="data-input">
                                                    <legend>Kepesertaan Asuransi</legend>
                                                    <input type="button" onclick="addAsuransi()" value="Tambah">
                                                    <div class="asuransi">

                                                    </div>
                                                </fieldset>

                                                <fieldset><legend id="subjudul-3" style="cursor: pointer"><span  class="icon-triangle"></span>Keluarga yang bisa dihubungi</legend>
                                                    <div id="sh-3">
                                                        <label for="nmKeluarga">Nama Kepala Keluarga</label>
                                                        <input type="text" name="nmKeluarga" size="50%" width="50%"  id="nmKeluarga" <?= $input ?>>
                                                        <input type="hidden" name="idNmKeluarga" id="idNmKeluarga">


                                                        <label for="hubKeluarga">Hubungan Keluarga</label>
                                                        <select name="hubKeluarga"  style="width: 25%;" id="hubKeluarga" <?= $input ?>>
                                                        <option value="">Pilih hubungan</option>
                                                        <option value="Ayah">Ayah</option>
                                                        <option value="Ibu">Ibu</option>
                                                        <option value="Anak">Anak</option>
                                                    </select>

                                                    <label for="alamatK">Alamat </label>
                                                    <input type="text" name="alamatK" size="50%" width="50%" id="alamatK" <?= $input ?>>

                                                    <label for="ntK">No. Telepon</label>
                                                    <input type="text" name="ntK" size="50%" width="50%" id="ntK" <?= $input ?> maxlength="15">

                                                </div>
                                            </fieldset>

                                            <fieldset><legend id="subjudul-4">Penanggung Jawab</legend>

                                                <div id="sh-4">
                                                    <label for="nmPjw">Nama</label>
                                                    <input type="text" name="nmPjw" size="50%" width="50%" id="nmPjw" <?= $input ?>>
                                                    <input type="hidden" name="idNmPjw" id="idNmPjw">

                                                    <label for="alamatPjw">Alamat </label>
                                                    <input type="text" name="alamatPjw" size="50%" width="50%" id="alamatPjw" <?= $input ?>>
                                                    <label for="telpPjw">No. Telepon</label>
                                                    <input type="text" size="50%" name="telpPjw" id="telpPjw" <?= $input ?> maxlength="15">
                                                </div>
                                            </fieldset>
                                            <fieldset><legend id="subjudul-5" style="cursor: pointer"><span  class="icon-triangle"></span>Pengantar</legend>

                                                <div id="sh-5">
                                                    <label for="namaP">Nama Lengkap</label>
                                                    <input type="text" name="namaP" size="50%" width="50%" id="namaP" <?= $input ?>>
                                                    <input type="hidden" name="idNamaP" id="idNamaP">
										
                                                    <label for="alamatP">Alamat </label>
                                                    <input type="text" name="alamatP" size="50%" width="50%" id="alamatP" <?= $input ?>>

                                                    <label for="telpP">No. Telepon</label>
                                                    <input type="text" name="telpP" size="50%" width="50%" id="telpP" <?= $input ?> maxlength="15">

                                                </div>
                                            </fieldset>


                                            <fieldset><legend id="subjudul-6" style="cursor: pointer"><span  class="icon-triangle"></span>Instansi Perujuk</legend>
                                                <div id="sh-6"  >
                                                    <label for="no_rujukan">No. Surat Rujukan</label>
                                                    <input type="text" name="no_rujukan" size="50%" width="50%" id="no_rujukan" <?= $input ?>>
                                                    <label for="rujukan">Rujukan Dari</label>
                                                    <input type="text" name="rujukan" size="50%" width="50%" id="rujukan" <?= $input ?>>
                                                    <input type="hidden" name="idRujukan" id="idRujukan">
                                                    <label for="nakes">Nama Nakes</label>
                                                    <input type="text" name="nakes" size="50%" width="50%" id="nakes" <?= $input ?>>
                                                    <input type="hidden" name="idNakes" id="idNakes">
                                                </div>
                                            </fieldset>
                                        </td>
            </tr>
            </table>
                            </fieldset>
                        </fieldset>
    </div>
                        <fieldset class="input-process">
                            <input type="submit" value="Simpan" class="tombol" name="save"  <?= $input ?> />
                            <input type="reset" value="Batal" class="tombol" <?= $input ?> />
                            <div id="cetak_kartu"></div>
                            
                        </fieldset>
                          </form>
                    
              
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('.cetak').click(function(){
                            var win = window.open('print/kartu-antrian?noAntrian='+$('#noAntrian').val()+'&nama='+$('#nama').val()+'&alamatJln='+$('#alamatJln').val()+'&tujuan='+$('#tujuan').val()+'', 'myWindow', 'width=500px, height=500px, scrollbars=1');
                        })
                    })
                    jQuery(document).ready(function(){
                        jQuery("#sh-1").hide();
                        //jQuery("#subjudul-1").css({"border":"none"});
                        jQuery("#sh-2").hide();
                        jQuery("#sh-3").hide();
                        jQuery("#sh-4").show();
                        jQuery("#sh-5").hide();
                        jQuery("#sh-6").hide();
                    });

                    $(function() {

                        $("#noRm").autocomplete({
                            url: '<?= app_base_url('/admisi/search') ?>',
                            sortFunction: function(a, b) {
                                a = String(a.data[0]).toLowerCase();
                                b = String(b.data[0]).toLowerCase();
                                if (a > b) {
                                    return 1;
                                }
                                if (a < b) {
                                    return -1;
                                }
                                return 0;
                            },
                            showResult: function(value, data) {
                                return '<span style=color:red;>'+value+'</span>';
                            },
                            onItemSelect: function(item) {
                                var text = item.value;
                                var explode = text.split(' - ');
                                var newid = explode[1];
                                var newval= explode[0];
                                $("#hide").val(newid);
                                $("#ac2").val(newval);
                            }
                        });


                    });

                    jQuery("#subjudul-1").click(function () {
                        jQuery("#sh-1").slideToggle("fast");
                        
                        
                    });
                    jQuery("#subjudul-2").click(function () {
                        jQuery("#sh-2").slideToggle("fast");
                    });
                    jQuery("#subjudul-3").click(function () {
                        jQuery("#sh-3").slideToggle("fast");
                        $('#subjudul-3 span').toggleClass('icon-triangle-close');

                    });
                    /*jQuery("#subjudul-4").click(function () {
                        jQuery("#sh-4").slideToggle("fast");

                });*/
                    jQuery("#subjudul-5").click(function () {
                        jQuery("#sh-5").slideToggle("fast");
                        $('#subjudul-5 span').toggleClass('icon-triangle-close');
                    });
                    jQuery("#subjudul-6").click(function () {
                        jQuery("#sh-6").slideToggle("fast");
                        $('#subjudul-6 span').toggleClass('icon-triangle-close');

                    });



                    (function(window, $){
                        window.hub = function(data) {

                            $("input[name=nmKeluarga]").val(data.nm_Keluarga);
                            $("input[name=idNmKeluarga]").val(data.id_NmKeluarga);
                            $("select[name=hubKeluarga]").val(data.hub_Keluarga);
                            $("input[name=alamatK]").val(data.alamat_K);
                            $("input[name=ntK]").val(data.nt_K);
                        };

                    })(window, jQuery);
                    var countAsuransi=$('.asuransi-list').size();
                    function addAsuransi(){
                        var count=$('.asuransi-list').size();
                        var html='<fieldset class="field-group asuransi-list">'+
                            '<input type="hidden" name="asuransi['+countAsuransi+'][id_asuransi]" class="id_asuransi" id="id_asuransi'+countAsuransi+'">'+
                            '<input type="text" size="30%" width="30%" id=asuransi'+countAsuransi+'>'+
                            '<label class=inline-title>No. Polis</label>'+
                            '<input type="text" name="asuransi['+countAsuransi+'][no_polis]" >'+
                            '<input type="button" value="Hapus" onclick="removeMe(this)">'+
                            '</fieldset>';
                        $('.asuransi').append(html);
                        initAsuransi(countAsuransi);
                        countAsuransi++;
                    }
                    function initAsuransi(countAsuransi){
                        $('#asuransi'+countAsuransi).autocomplete("<?= app_base_url('/admisi/search?opsi=asuransiProduk') ?>",
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
							if(data.id_asuransi==='4'){
								$.ajax({
									url: "<?= app_base_url('/admisi/search?opsi=kepesertaan_jamkesmas') ?>",
									data:'push='+$('#nik').val(),
									cache: false,
									dataType: 'json',
									success: function(msg,msg2){
										if(!msg.nik){
											alert('maaf, \'' + $('#nama').val() + '\' tidak terdaftar sebagai pengguna jamkesmas');
										}else if($('#nik').val() == ''){
											alert('maaf, \'' + $('#nama').val() + '\' tidak terdaftar sebagai pengguna jamkesmas');
										}
									}
								});
							}
								$(this).attr('value',data.nama_asuransi);
								if($(this).parent('fieldset').children('input.id_asuransi').attr('name')==null)
									$(this).parent('div').children('input.id_asuransi').attr('value',data.id_asuransi);
								else
									$(this).parent('fieldset').children('input.id_asuransi').attr('value',data.id_asuransi);
							
                           
                        }
                    );
                    }
					
                    function field_check(isian) {
                        if (isian.dokter.value == ""){
                            alert("Dokter tidak boleh kosong");
                            isian.dokter.focus();
                            return false;
                        }
                        if (isian.idDokter.value == ""){
                            alert("Dokter belum ditemukan");
                            isian.dokter.focus();
                            return false;
                        }
                        if(isian.bed.value == ""){
                            alert("No Klinnik tidak boleh kosong");
                            isian.bed.focus();
                            return false;
                        }
                        if(isian.idBed.value == ""){
                            alert("No Klinik belum diisi");
                            isian.bed.focus();
                            return false;
                        }
                        if (isian.noRm.value == "") {
                            alert("No Rekam medikF harus diisi");
                            isian.kelurahan.focus();
                            return false;
                        }
                        if (isian.nama.value == "") {
                            alert("Nama tidak boleh kosong");
                            isian.nama.focus();
                            return false;
                        }
                        if (isian.alamatJln.value == "") {
                            alert("Alamat jalan tidak boleh kosong");
                            isian.alamatJln.focus();
                            return false;
                        }
						if (isian.rt.value == "") {
                       //     alert("RT tidak boleh kosong");
                       //     isian.alamatJln.focus();
                       //     return false;
                        }
						if (isian.rw.value == "") {
                         //   alert("RW tidak boleh kosong");
                        //    isian.alamatJln.focus();
                        //    return false;
                        }
                        if (isian.kelurahan.value == ""){
                            alert('Desa/Keluarahan harus diisi');
                            isian.kelurahan.focus();
                            return false;
                        }
                        if(isian.idKel.value == ""){
                            alert('Pilih Desa/Kelurahan dengan benar');
                            isian.kelurahan.focus();
                            return false;
                        } 
                    }
                    function request_new_id(){
                        $('#idPenduduk').attr('value','');
                        $('#alamatJln').attr('value','');
                        $('#kelurahan').attr('value','');
                        $('#rt').attr('value','');
                        $('#rw').attr('value','');
                        $('#kecamatan').attr('value','');
                        $('#kabupaten').attr('value','');
                        $('#provinsi').attr('value','');
                        $('#idKel').attr('value','');
                        $('#idKec').attr('value','');
                        $('#idKab').attr('value','');
                        $('#idProv').attr('value','');
                        $('#gol').attr('value','');
                        $('#tglLahir').attr('value','');
                        $('#idPkw').attr('value','');
                        $('#pendidikan').attr('value','');
                        $('#laki-laki').attr('checked','');
                        $('#perempuan').attr('checked','');
                        $('.asuransi').html('');
                        $('#profesi').attr('value','');
                        $('#pekerjaan').attr('value','');
                        $('#agama').attr('value','');
                        $.ajax({
                            url: "<?= app_base_url('admisi/informasi/new-medical-record-id') ?>",
                            cache: false,
                            success: function(msg){
                                $("#noRm").attr('value',msg);
                            }
                        });
                    }
                    function hapusAsuransi(idx){
                        $('#as'+idx).html('');
                    }
					function new_nik(id){
                                            if(id=="nik"){
                                                 $('#nama').attr('value','');
                                            }else if(id=="nama"){
                                                 $('#nik').attr('value','');
                                            }
						request_new_id();
						get_data_pemda('');
					}
					
					function get_data_pemda(datas){
						if($('#nik').val().length==16){
                                                     $.ajax({
                                                            url: "<?= app_base_url('/admisi/search?opsi=penduduk_data_pemda') ?>",
                                                            data:'push='+$('#nik').val(),
                                                            cache: false,
                                                            dataType: 'json',
                                                            success: function(msg){
                                                                    if(msg.alamat){
                                                                            $('#nama').attr('value',msg.nama);
                                                                            $('#alamatJln').attr('value',msg.alamat+", / "+msg.rt+" / "+msg.rw);
                                                                            $('#idKel').attr('value',msg.id_kelurahan);
                                                                            $('#idKec').attr('value',msg.id_kecamatan);
                                                                            $('#idKab').attr('value',msg.id_kabupaten);
                                                                            $('#kelurahan').attr('value',msg.kelurahan);
                                                                            $('#wilayah').html('<i>Kec.'+msg.kecamatan+',  Kab.'+msg.kabupaten+',  Prov.'+msg.provinsi+'</i>');
                                                                    }
                                                            }
                                                        });
						}else if(datas!=null){
                                                        var kecamatan = datas.nama_kecamatan != undefined ? datas.nama_kecamatan : '-';
                                                        var kabupaten = datas.nama_kabupaten != undefined ? datas.nama_kabupaten : '-';
							$('#nama').attr('value',datas.nama_pas);
							$('#alamatJln').attr('value',datas.alamat_jalan);
							$('#idKel').attr('value',datas.kode_kelurahan);
							$('#idKec').attr('value',datas.kode_kecamatan);
							$('#idKab').attr('value',datas.kode_kabupaten);
							$('#kelurahan').attr('value',datas.nama_kelurahan);
							$('#wilayah').html('<i>Kec.'+kecamatan+',  Kab.'+kabupaten+' </i>');
						}
						
					}
					$(function() {
                        $('#nik').autocomplete("<?= app_base_url('/admisi/search?opsi=nik') ?>",
                        {
                            parse: function(data){
                                
                                var parsed = [];
                                for (var i=0; i < data.length; i++) {
                                    parsed[i] = {
                                        data: data[i],
                                        value: data[i].no_identitas // nama field yang dicari
                                    };
                                }
                                return parsed;
                            },
                            formatItem: function(data,i,max){
                                if(i == 1){
				    request_new_id();
                                }
                                if (data.id_pasien == null) {
                                    var str='<div class=result>( '+data.no_identitas+' ) '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                                } else {
                                    var str='<div class=result><b>'+data.id_pasien+'</b> - ( '+data.no_identitas+' ) '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                                }
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            if (data.id_pasien != null) {
                                $('#noRm').attr('value',data.id_pasien);
                            }
                            if(data.id_penduduk!=null || data.id_pasien!=null) {
                                $('#idPenduduk').attr('value',data.id_penduduk);
                                $('#nik').attr('value',data.no_identitas);
                                $('#nama').attr('value',data.nama_pas);
								$('#gol').attr('value',data.gol_darah);
								$('#tglLahir').attr('value',data.tanggal_lahir);
                                var tglNow = new Date();
                                var tanggal=$('#tglLahir').attr('value');
                                var elem = tanggal.split('/');
                                var tglLahir = new Date(elem[2],elem[1],elem[1]);
                                var selisih = Date.parse(tglNow.toGMTString()) - Date.parse(tglLahir.toGMTString());
                                var hasil = Math.round(selisih/(1000*60*60*24*350));
                                hitungUmur();
                                $('#idPkw').attr('value',data.status_pernikahan);
                                $('#pendidikan').attr('value',data.id_pendidikan_terakhir);
                                $('#profesi').attr('value',data.id_pro);
                                $('#pekerjaan').attr('value',data.id_pekerjaan);
                                $('#agama').attr('value',data.id_agama);
                                get_data_pemda(data);
                                if(data.jenis_kelamin == "L") {
                                    $('#laki-laki').attr('checked','checked');
                                }else if(data.jenis_kelamin == "P") {
                                    $('#perempuan').attr('checked','checked');
                                }
                            }
                        }
                    );
                    });
                    $(function() {
                        $('#nama').autocomplete("<?= app_base_url('/admisi/search?opsi=nama') ?>",
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
                                if(i==1){
                                      request_new_id();
                                }
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
                            if (data.id_pasien != null) {
                                $('#noRm').attr('value',data.id_pasien);
                            }
                            if(data.id_penduduk!=null || data.id_pasien!=null) {
                                $('#idPenduduk').attr('value',data.id_penduduk);
                                $('#nik').attr('value',data.no_identitas);
                                $('#nama').attr('value',data.nama_pas);
                                $('#gol').attr('value',data.gol_darah);
                                $('#tglLahir').attr('value',data.tanggal_lahir);
                                var tglNow = new Date();
                                var tanggal=$('#tglLahir').attr('value');
                                var elem = tanggal.split('/');
                                var tglLahir = new Date(elem[2],elem[1],elem[1]);
                                var selisih = Date.parse(tglNow.toGMTString()) - Date.parse(tglLahir.toGMTString());
                                var hasil = Math.round(selisih/(1000*60*60*24*350));
                                hitungUmur();
                                $('#idPkw').attr('value',data.status_pernikahan);
                                $('#pendidikan').attr('value',data.id_pendidikan_terakhir);
                                $('#profesi').attr('value',data.id_pro);
                                $('#pekerjaan').attr('value',data.id_pekerjaan);
                                $('#agama').attr('value',data.id_agama);
                                get_data_pemda(data);
                                if(data.jenis_kelamin == "L") {
                                $('#laki-laki').attr('checked','checked');
                                }else if(data.jenis_kelamin == "P") {
                                    $('#perempuan').attr('checked','checked');
                                }
                            }
                        }
                    );
                    });
                    $(function() {
                        $('#noRm').autocomplete("<?= app_base_url('/admisi/search?opsi=noRm') ?>",
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
                                var str='<div class=result>'+data.id_pasien+' '+data.nama_pas+'</div>';
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            $('#noRm').attr('value',data.id_pasien);
                            $('#idPenduduk').attr('value',data.id_penduduk);
                            $('#nama').attr('value',data.nama_pas);
                            $('#alamatJln').attr('value',data.alamat_jalan);
                            $('#kelurahan').attr('value',data.nama_kel);
                            $('#idKel').attr('value',data.id_kelurahan);
                            $('#gol').attr('value',data.gol_darah);
                            $('#tglLahir').attr('value',data.tanggal_lahir);
                            hitungUmur();
                            $('#idPkw').attr('value',data.status_pernikahan);
                            $('#pendidikan').attr('value',data.id_pendidikan_terakhir);
                            $('#profesi').attr('value',data.id_pro);
                            $('#pekerjaan').attr('value',data.id_pekerjaan);
                            $('#agama').attr('value',data.id_agama);
                            if(data.jenis_kelamin == "L")
                            {
                                $('#laki-laki').attr('checked','checked');
                            }
                            else if(data.jenis_kelamin == "P")
                            {
                                $('#perempuan').attr('checked','checked');
                            }
                        }
                    );
                    });
                    $(function() {
                        $('#nmKeluarga').autocomplete("<?= app_base_url('/admisi/search?opsi=nmKeluarga') ?>",
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
                                $('#idNmKeluarga').attr('value',data.id);
                                $('#alamatK').attr('value','');
                                $('#ntK').attr('value','');
                                $('#hubKeluarga').attr('value','');
                                var str='<div class=result>'+data.nama+', '+data.alamat_jalan+'</div>';
                                return str;
                            },
                            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            $('#nmKeluarga').attr('value',data.nama);
                            $('#idNmKeluarga').attr('value',data.id);
                            $('#alamatK').attr('value',data.alamat_jalan);
                            $('#ntK').attr('value',data.no_telp);
                            $('#hubKeluarga').attr('value',data.posisi_di_keluarga);
                        }
                    );
                    });
                    $(function() {
                        $('#kelurahan').autocomplete("<?= app_base_url('/admisi/search?opsi=kelurahan') ?>",
                        {
                            parse: function(data){
                                var parsed = [];
                                for (var i=0; i < data.length; i++) {
                                    parsed[i] = {
                                        data: data[i],
                                        value: data[i].nama_kel // nama field yang dicari
                                    };
                                }
                                return parsed;
                            },
                            formatItem: function(data,i,max){
                                var str='<div class=result><b style="text-transform:capitalize">'+data.nama_kel+'</b> <i>Kec: '+data.nama_kec+'<br/> Kab: '+data.nama_kab+' Prov: '+data.nama_pro+'</i></div>';
                                return str;
                            },
                            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            $('#kelurahan').attr('value',data.nama_kel);
                            $('#idKel').attr('value',data.id_kel);
                            $('#wilayah').html('<i>Kec.'+data.nama_kec+',  Kab.'+data.nama_kab+',  Prov.'+data.nama_pro+'</i>');
                            $('#idKec').attr('value',data.id_kec);
                            $('#idKab').attr('value',data.id_kab);
                            $('#idProv').attr('value',data.id_prov);
                        }
                    );
                    }); 
                    $(function() {
                        $('#nmPjw').autocomplete("<?= app_base_url('/admisi/search?opsi=nmPjw') ?>",
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
                                $('#idNmPjw').attr('value','');
                                $('#alamatPjw').attr('value','');
                                $('#telpPjw').attr('value','');
                                var str='<div class=result>'+data.nama+', '+data.alamat_jalan+'</div>';
                                return str;
                            },
                            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            var telp = data.no_telp!='NULL'?data.no_telp:'';
                            
                            $('#nmPjw').attr('value',data.nama);
                            $('#idNmPjw').attr('value',data.id);
                            $('#alamatPjw').attr('value',data.alamat_jalan);
                            $('#telpPjw').attr('value',telp);
                        }
                    );
                    });
                    $(function() {
                        $('#namaP').autocomplete("<?= app_base_url('/admisi/search?opsi=nmPjw') ?>",
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
                                var str='<div class=result>'+data.nama+', '+data.alamat_jalan+'</div>';
                                return str;
                            },
                            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            $('#namaP').attr('value',data.nama);
                            $('#idNamaP').attr('value',data.id);
                            $('#alamatP').attr('value',data.alamat_jalan);
                            $('#telpP').attr('value',data.no_telp);
                        }
                    );
                    });
                    $(function() {
                        $('#rujukan').autocomplete("<?= app_base_url('/admisi/search?opsi=rujukan') ?>",
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
                                var str='<div class=result>'+data.nama+'</div>';
                                return str;
                            },
                            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            $('#rujukan').attr('value',data.nama);
                            $('#idRujukan').attr('value',data.id);
                        }
                    );
                    });
                    $(function() {
                        $('#nakes').autocomplete("<?= app_base_url('/admisi/search?opsi=nakes') ?>",
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
                                var str='<div class=result>'+data.nama+'</div>';
                                return str;
                            },
                            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            $('#nakes').attr('value',data.nama);
                            $('#idNakes').attr('value',data.id);
                        }
                    );
                    });

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
                                var sip = data.sip!='NULL'?data.sip:'';
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
                    $(function() {
                        $('#bed').autocomplete("<?= app_base_url('/admisi/search?opsi=bed_rawat_jalan') ?>",
                        {
                            extraParams:{
                                //status: function(){return 'Kosong'}
                            },
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
                                var str='<div class=result>Klinik <b>'+data.nama+' '+data.instalasi+'</b></div>';
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                            $(this).attr('value','Klinik '+data.nama+' '+data.instalasi);
                            $('#idBed').attr('value',data.id);
                        });

        $('#layanan').autocomplete("<?= app_base_url('/admisi/search?opsi=layanan_rawat_jalan') ?>",
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
                var str='<div class=result>'+data.nama;
                str+=(data.profesi=='Tanpa Profesi'||data.profesi=='Semua')?'':' '+data.profesi;
                str+=(data.spesialisasi=='Tanpa Spesialisasi'||data.spesialisasi=='Semua')?'':' '+data.spesialisasi;
                str+=(data.bobot=='General'||data.bobot=='Tanpa Bobot'||data.bobot=='Semua')?'':' '+data.bobot;
                str+=(data.instalasi=='Tanpa Instalasi'||data.instalasi=='Semua')?'':' '+data.instalasi;
                //str+=(data.kelas=='Tanpa Kelas'||data.kelas=='Semua')?' ':' '+data.kelas;
                str+='</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var str=data.nama;
                str+=(data.profesi=='Tanpa Profesi'||data.profesi=='Semua')?'':' '+data.profesi;
                str+=(data.spesialisasi=='Tanpa Spesialisasi'||data.spesialisasi=='Semua')?'':' '+data.spesialisasi;
                str+=(data.bobot=='General'||data.bobot=='Tanpa Bobot'||data.bobot=='Semua')?'':' '+data.bobot;
                str+=(data.instalasi=='Tanpa Instalasi'||data.instalasi=='Semua')?'':' '+data.instalasi;
                //str+=(data.kelas=='Tanpa Kelas'||data.kelas=='Semua')?' ':' '+data.kelas;
                
                
            $(this).attr('value',str);
            $('#idLayanan').attr('value',data.id);
            $('input').removeAttr("disabled");
            $('select').removeAttr("disabled");
        });
    });
</script>
