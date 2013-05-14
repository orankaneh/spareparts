<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require 'app/actions/admisi/pesan.php';
set_time_zone();
$agama = agama_muat_data();
$level = level_muat_data();
$unit = unit_muat_data();
$page = isset($_GET['page'])?$_GET['page']:NULL;
$sort = isset($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
$key = isset($_GET['key'])?$_GET['key']:NULL;

$spesialisasi_dokter = spesialisasi_dokter_muat_data(NULL,$page,15,$sort,$sortBy,$key);
$numb=nomer_paging($page,15);
$input = "";
?>
<h1 class="judul"><a href="<?= app_base_url('admisi/spesialisasi_dokter') ?>">Master Data Dokter</a></h1>
<script type="text/javascript">
  $(function(){
      $('#no_identitas').focus();
  })
</script>
<?php echo isset($pesan) ? $pesan : null; ?>
<?php
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'add') {
            require_once 'app/actions/admisi/add_spesialisasi_dokter.php';
    }
    else if ($_GET['do'] == 'edit') {
            require_once 'app/actions/admisi/edit-spesialisasi-dokter.php';
    }
}
?>
<div class="data-list w700px">
    <div class="floleft">
       <a href="<?= app_base_url('admisi/spesialisasi_dokter/?do=add')?>" class="add"><div class="icon button-add"></div>tambah</a>
    </div>
    <div class="floright">
        <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
        </form>
    </div>
<table class="tabel full" cellspacing=0>
            <tr>
                <th style="width: 5%">NO</th>
              <th style="width: 30%"><a href='<?=app_base_url('admisi/spesialisasi_dokter?').  generate_sort_parameter(1, $sortBy)?>' class='sorting'>Nama Dokter</a></th>
                <th style="width: 15%">Spesialisasi</th>
		<th colspan="4" style="width: 10%;vertical-align: middle">Aksi</th>   
            </tr>
            <?php
	    if(count($spesialisasi_dokter['list'])<1) echo "<tr><td colspan='7' align='center'><b>Maaf, belum ada Master Data Dokter</b></td></tr>";
            $no=1 + $spesialisasi_dokter['offset'];
            foreach ($spesialisasi_dokter['list'] as $data) {
                ?>
                <tr class='<?php echo ($no%2==0)? 'odd':'even' ?>'>
                   <td><?php echo $numb++ ;?></td>
                   <td><?php echo $data['nama_dokter'] ;?></td>
                   <td><?php echo $data['profesi'].' '.$data['nama_spesialisasi'] ;?></td>
                  <td align=center class="aksi">
                        <a href="<?= app_base_url('/admisi/spesialisasi_dokter?do=edit&code=' . $data['id_penduduk'] . '') ?>" class="edit"><small>edit</small></a>
                        <a href="<?= app_base_url('/admisi/control/spesialisasi/delete?do=delete&id=' . $data['id_penduduk'] . '') ?>" class="delete"><small>delete</small></a>
                    </td>
                </tr>
                <?php
            $no++;
            }
            ?>
</table>
</div>
<?php
  echo $spesialisasi_dokter['paging'];
?>
 <script type="text/javascript">
	
	$(function() {
		 $('#no_identitas').autocomplete("<?= app_base_url('/admisi/search?opsi=pegawai_dokter_nik') ?>",
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
                                
                                    var str='<div class=result>( '+data.no_identitas+' ) '+data.nama_dok+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                              
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result( function(event,data,formated){
							request_new_id();
                           $('#id_penduduk').attr('value',data.id_penduduk);
                           $('#no_identitas').attr('value',data.no_identitas);
                           $('#nama_dokter').attr('value',data.nama_dok);
                           $('#alamatJln').attr('value',data.alamat_jalan);
                           $('#rt').attr('value',data.rt);
                           $('#rw').attr('value',data.rw);
                           $('#kelurahan').attr('value',data.nama_kelurahan);
                           $('#idKel').attr('value',data.id_kelurahan);
						   if(data.jenis_kelamin == "L") {
                                    $('#laki-laki').attr('checked','checked');
                            }else if(data.jenis_kelamin == "P") {
                                    $('#perempuan').attr('checked','checked');
                            }
							$('#agama').attr('value',data.id_agama);
							$('#no_sip').attr('value',data.sip);
							$('#level').attr('value',data.id_level);
							$('#unit').attr('value',data.id_unit);
							$('input').removeAttr("disabled");
							$('select').removeAttr("disabled");
                        });
		$('#nama_dokter').autocomplete("<?= app_base_url('/admisi/search?opsi=pegawai_dokter_nama') ?>",
                        {
                            parse: function(data){
                                var parsed = [];
                                for (var i=0; i < data.length; i++) {
                                    parsed[i] = {
                                        data: data[i],
                                        value: data[i].nama_dok // nama field yang dicari
                                    };
                                }
                                return parsed;
                            },
                            formatItem: function(data,i,max){
                                request_new_id();
                                    var str='<div class=result>'+data.nama_dok+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result( function(event,data,formated){
                           $('#id_penduduk').attr('value',data.id_penduduk);
                           $('#no_identitas').attr('value',data.no_identitas);
                           $('#nama_dokter').attr('value',data.nama_dok);
                           $('#alamatJln').attr('value',data.alamat_jalan);
                           $('#rt').attr('value',data.rt);
                           $('#rw').attr('value',data.rw);
                           $('#kelurahan').attr('value',data.nama_kelurahan);
                           $('#idKel').attr('value',data.id_kelurahan);
						   if(data.jenis_kelamin == "L") {
                                    $('#laki-laki').attr('checked','checked');
                            }else if(data.jenis_kelamin == "P") {
                                    $('#perempuan').attr('checked','checked');
                            }
							$('#agama').attr('value',data.id_agama);
							$('#no_sip').attr('value',data.sip);
							$('#level').attr('value',data.id_level);
							$('#unit').attr('value',data.id_unit);
							$('input').removeAttr("disabled");
							$('select').removeAttr("disabled");
                        });
        $('#spesialisasi').autocomplete("<?= app_base_url('/admisi/search?opsi=spesialisasi') ?>",
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
                                    var str='<div class=result>'+data.profesi+' '+data.nama+'</div>';
                              
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                        }).result(
                        function(event,data,formated){
                           $('#spesialisasi').attr('value',data.profesi+' '+data.nama);
                           $('#id_spesialisasi').attr('value',data.id);
							
                        }
                    );
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
                        }
                    );
                    });
	 function request_new_id(){
                         $('#id_penduduk').attr('value','');
                           $('#alamatJln').attr('value','');
                           $('#rt').attr('value','');
                           $('#rw').attr('value','');
                           $('#kelurahan').attr('value','');
                           $('#kelurahan').attr('value','');
                           $('#laki-laki').attr('checked','');
                            $('#perempuan').attr('checked','');
							$('#agama').attr('value','');
							$('#no_sip').attr('value','');
							$('#spesialisasi').attr('value','');
                           $('#id_spesialisasi').attr('value','');
                    }
	function form_valid(form){
		
			if(form.nama_dokter.value == ""){
				alert("Nama Lengkap Tidak Boleh kosong");
				form.nama_dokter.focus();
				return false;
			}
			if(form.no_identitas.value == ""){
				alert("NO Identitas Tidak Boleh kosong");
				form.no_identitas.focus();
				return false;
			}
			if(form.alamatJln.value == ""){
				alert("Alamat Tidak Boleh kosong");
				form.alamatJln.focus();
				return false;
			}
			if(form.kelurahan.value == ""){
				alert("KelurahanTidak Boleh kosong");
				form.kelurahan.focus();
				return false;
			}
			if(form.idKel.value == ""){
				alert("KelurahanTidak Boleh kosong");
				form.idKel.focus();
				return false;
			}
		
			if(form.id_spesialisasi.value==""){
				alert("Spesialisasi tidak boleh kosong");
					form.id_spesialisasi.focus();
				return false;
			}
		}
 </script>