<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/actions/admisi/pesan.php';
$preview=isset($_GET['norm'])?true:false;
?>
<script type="text/javascript" src="<?= app_base_url('assets/js/library.js') ?>" ></script>
<script type="text/javascript">
    function initAutocomplete(count){
        $('#nama'+count).unautocomplete().autocomplete("<?= app_base_url('rekam-medik/search?opsi=namaicd10') ?>",
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
                var str='<div class=result>'+data.nama+'<br><i>Kode:</i> '+data.kode+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idicd'+count).attr('value',data.id);
            $('#kode'+count).val(data.kode);
        }
        );
    
    $('#kode'+count).unautocomplete().autocomplete("<?= app_base_url('rekam-medik/search?opsi=kodeicd10') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].kode // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                var str='<div class=result>'+data.kode+'<br><i>Nama:</i> '+data.nama+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.kode);
            $('#idicd'+count).attr('value',data.id);
            $('#nama'+count).val(data.nama);
        }
        );
    }    
    function initPasien(){
        $.ajax({
            url:"<?= app_base_url('rekam-medik/search?opsi=noRm') ?>",
            type:"GET",
            dataType:"json",
            data:"mode=fix&q=<?=isset($_GET['norm'])?$_GET['norm']:''?>",
            cache:false,
            success:function(data){
                if(data!=null){
                    $('#no-rm').attr('value',data[0].norm);
                    $('#nama').attr('value',data[0].pasien);
                    $('#layanan').attr('value', data[0].id);
                    $('#tglLahir').attr('value', data[0].tanggal_lahir);
                    hitungUmur();
                    $('#agama').html(data[0].agama);
                    $('#pekerjaan').html(data[0].pekerjaan);
                    $('#alamat').html(data[0].alamat_jalan);
                    $('#kelurahan').html(data[0].kelurahan);
                }
            }
        });
    }
    
    $(function() {
        $('#save').click(function() {
            if ($('#no-rm').val() == '') {
                alert('No. RM tidak boleh kosong !')
                $('#no-rm').focus();
                return false;
            }
            if ($('#nama').val() == '') {
                alert('Nama pasien tidak boleh kosong !')
                $('#nama').focus();
                return false;
            }
            
            var baris = $('.icd_tr').length;
            var isi1 = false;
            for(var i = 1; i <= baris; i++) {
                if ($('#idicd'+i).val() != '') {
                    isi1 = true;
                    isi2 = true;
                }
            }
            if(!isi1){
                alert('Nama ICD 10 tidak boleh kosong !')
                return false;
            }
/*
            var bariss = $('.icd_tindakan_tr').length+1;
            var isi2 = false;
            for(var j = 1; j <= baris; j++) {
                if ($('#idicdTindakan'+j).val() != '') {
                    isi2 = true;
                }
            }*/
            if(!isi2){
                alert('Nama ICD 9 tidak boleh kosong !')
                return false;
            }
        })
            $('#no-rm').focus();
            $('#nama').autocomplete("<?= app_base_url('rekam-medik/search?opsi=nama') ?>",
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
                    var str='<div class=result><b>'+data.norm+'</b> - '+data.pasien+' <br/><i>No.Pelayanan:</i> '+data.id+' <i>Dokter:</i> '+data.dokter+' <i>Bed: </i> '+data.bed+'</i><br><i>Tanggal: </i>'+data.tanggal_pelayanan+'</div>';
                return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){

                $('#no-rm').attr('value',data.norm);
                $(this).attr('value',data.pasien);
                $('#layanan').attr('value', data.id);
                $('#tglLahir').attr('value', data.tanggal_lahir);
                hitungUmur();
                $('#agama').html(data.agama);
                $('#pekerjaan').html(data.pekerjaan);
                $('#alamat').html(data.alamat_jalan);
                $('#kelurahan').html(data.kelurahan);
                }
            );

            $('#no-rm').autocomplete("<?= app_base_url('rekam-medik/search?opsi=noRm') ?>",
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
                        var str='<div class=result><b>'+data.norm+'</b> - '+data.pasien+' <br/><i>No.Pelayanan:</i> '+data.id+' <i>Dokter:</i> '+data.dokter+' <i>Bed: </i> '+data.bed+'</i><br><i>Tanggal: </i>'+data.tanggal_pelayanan+'</div>';
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $(this).attr('value',data.norm);
                    $('#layanan').attr('value', data.id);
                    $('#nama').attr('value',data.pasien);
                    $('#tglLahir').attr('value', data.tanggal_lahir);
                    hitungUmur();
                    $('#agama').html(data.agama);
                    $('#pekerjaan').html(data.pekerjaan);
                    $('#alamat').html(data.alamat_jalan);
                    $('#kelurahan').html(data.kelurahan);
                }
            );
            $("#tambahBaris").click(function(){
                counter = $('.icd_tr').length+1;
                string = "<tr class=icd_tr> " +
                "<td align='center'>"+counter+"</td> " +
                "<td align='center'><input  style='width:80%' type='text' name='nama[]' id='nama"+counter+"' class='auto' /> " +
                "<td align='center'><input type='text' id='kode"+counter+"'><input type='hidden' name='idicd[]' id='idicd"+counter+"' class='hideauto' /></td> " +
                "<td align='center'><input type='button' value='Hapus' class='tombol' onClick='deleteElement(this)' title='Hapus'></td></tr>";
                    $("#diagnosa").append(string);
                    $('.icd_tr:eq('+(counter-1)+')').addClass((counter % 2 != 0)?'even':'odd');
                initAutocomplete(counter);
            })
    })
    function deleteElement(el) {
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penerimaan=$('.icd_tr');
        var countPenerimaanTr=penerimaan.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.icd_tr:eq('+i+')').children('td:eq(0)').html(i+1);
            $('.icd_tr:eq('+i+')').removeClass('even');
            $('.icd_tr:eq('+i+')').removeClass('odd');
            $('.icd_tr:eq('+i+')').addClass(((i+1) % 2 != 0)?'even':'odd');

            $('.icd_tr:eq('+i+')').children('td:eq(1)').children('.auto').attr('id','nama'+(i+1));
            $('.icd_tr:eq('+i+')').children('td:eq(1)').children('.hideauto').attr('id','idicd'+(i+1));
        }
    }
</script>
<script type="text/javascript">
    function initAutocompletes(count){
        $('#namaTindakan'+count).unautocomplete().autocomplete("<?= app_base_url('rekam-medik/search?opsi=namaicd9') ?>",
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
                var str='<div class=result>'+data.nama+'<br><i>Kode:</i> '+data.kode+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idicdTindakan'+count).attr('value',data.id);
            $('#kode9'+count).val(data.kode);
        }
        );
            
        $('#kode9'+count).unautocomplete().autocomplete("<?= app_base_url('rekam-medik/search?opsi=kodeicd9') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].kode // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                var str='<div class=result>'+data.kode+'<br><i>Nama:</i> '+data.nama+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.kode);
            $('#idicdTindakan'+count).attr('value',data.id);
            $('#namaTindakan'+count).val(data.nama);
        }
        );    
    }
    $(function() {
            $("#tambahBarisTindakan").click(function(){
                counter = $('.icd_tindakan_tr').length+1;
                string = "<tr class=icd_tindakan_tr> " +
                "<td align='center'>"+counter+"</td> " +
                "<td align='center'><input  style='width:80%' type='text' name='namaTindakan[]' id='namaTindakan"+counter+"' class='auto' /> " +
                "<td align='center'><input type='text' id='kode9"+counter+"'><input type='hidden' name='idicdTindakan[]' id='idicdTindakan"+counter+"' class='hideauto' /></td> " +
                "<td align='center'> <input type='checkbox' name='ic[]' value='1' /></td>"+
                "<td align='center'><input type='button' value='Hapus' class='tombol' onClick='deleteElements(this)' title='Hapus'></td></tr>";
                    $("#diagnosa_tindakan").append(string);
                    $('.icd_tindakan_tr:eq('+(counter-1)+')').addClass((counter % 2 != 0)?'even':'odd');
                initAutocompletes(counter);
            })
    })
    function deleteElements(el) {
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penerimaan=$('.icd_tindakan_tr');
        var countPenerimaanTr=penerimaan.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.icd_tindakan_tr:eq('+i+')').children('td:eq(0)').html(i+1);
            $('.icd_tindakan_tr:eq('+i+')').removeClass('even');
            $('.icd_tindakan_tr:eq('+i+')').removeClass('odd');
            $('.icd_tindakan_tr:eq('+i+')').addClass(((i+1) % 2 != 0)?'even':'odd');

            $('.icd_tindakan_tr:eq('+i+')').children('td:eq(1)').children('.auto').attr('id','namaTindakan'+(i+1));
            $('.icd_tindakan_tr:eq('+i+')').children('td:eq(1)').children('.hideauto').attr('id','idicdTindakan'+(i+1));

            $('.icd_tindakan_tr:eq('+i+')').children('td:eq(2)').children('.chkbox').attr('name','ic'+(i+1));
        }
    }
    $(document).ready(function(){
        <?php
            if(isset($_GET['norm'])){
                echo "initPasien();";
            }
        ?>
    });
</script>
<h1 class="judul">Diagnosa & Tindakan Pelayanan Medik</h1>
<?= isset($pesan)?$pesan:NULL ?>

<div class="data-input">
    <form action="<?= app_base_url('rekam-medik/control/diagnosa-tindakan') ?>" method="post">
    <fieldset><legend>Data Pasien</legend>
        
        <input type="hidden" id="tglLahir" />
        <label for="no-rm">No. RM</label><input type="text" name="norm" id="no-rm" /> <input type="hidden" name="layanan" id="layanan" />
        <label for="nama">Nama</label><input type="text" name="nama" id="nama" />
        <label for="umur">Umur</label><span id="umur"></span>
        <label for="agama">Agama</label><span id="agama"></span>
        <label for="pekerjaan">Pekerjaan</label><span id="pekerjaan"></span>
        <label for="alamat">Alamat</label><span id="alamat"></span>
        <label for="kelurahan">Kelurahan</label><span id="kelurahan"></span>
    
    </fieldset>

    <?php if(!$preview):?>  
<div class="data-list tabelflexibel">
    <fieldset><legend>Detail Diagnosa</legend>
        <input type="button" class="tombol" value="Tambah Baris" id="tambahBaris">
        <table id="diagnosa" class="table-input" style="width: 50%">
        <tr>
          <th width="3%" style="width: 10%">No</th>
          <th width="32%" style="width: 30%">Nama*</th>
          <th width="21%" style="width: 20%">Kode ICD 10</th>
          <th width="7%" style="width: 10%">Aksi</th>
      </tr>
      
        <?php
        
        
        for ($i = 1; $i <= 2; $i++) {
        ?>
            <tr class="icd_tr <?= ($i % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $i ?></td>
                <td align="center">
                    <input type="text" style='width: 80%' name="nama[]" id="nama<?= $i ?>" class="auto"/>
                </td>
                <td align="center">
                    <input type="text" id="kode<?= $i ?>" />
                    <input type="hidden" name="idicd[]" id="idicd<?= $i ?>" />
                </td>
                
                <td align="center"><input type="button" class="tombol" value="Hapus" onclick="deleteElement(this)"></td>
            </tr>
            <script type="text/javascript">initAutocomplete(<?= $i ?>);</script>
        <? } ?>
    </table>
    
    </fieldset>
    
    <fieldset><legend>Detail Tindakan</legend>
        <input type="button" class="tombol" value="Tambah Baris" id="tambahBarisTindakan">
        <table id="diagnosa_tindakan" class="table-input" style="width: 50%">
        <tr>
          <th width="3%" style="width: 10%">No</th>
          <th width="32%" style="width: 30%">Nama*</th>
          <th width="21%" style="width: 20%">Kode ICD 9</th>
          <th width="21%" style="width: 25%">Informed Consent</th>
          <th width="7%" style="width: 10%">Aksi</th>
      </tr>
        <?php for ($i = 1; $i <= 2; $i++) {
        ?>
            <tr class="icd_tindakan_tr <?= ($i % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $i ?></td>
                <td align="center">
                    <input type="text" style='width: 80%' name="namaTindakan[]" id="namaTindakan<?= $i ?>" class="auto"/>
                </td>
                <td align="center">
                    <input type="text" id="kode9<?= $i ?>" />
                    <input type="hidden" name="idicdTindakan[]" id="idicdTindakan<?= $i ?>" />
                </td>
                <td align="center">
                    <input type="checkbox" class="chkbox" name="ic<?= $i ?>" value="1" />
                </td>
                <td align="center"><input type="button" class="tombol" value="Hapus" onclick="deleteElements(this)"></td>
            </tr>
            <script type="text/javascript">initAutocompletes(<?= $i ?>);</script>
        <? }
        ?>
    </table>

       
   <?php
   else:
   ?>
        <fieldset><legend>Diagnosa</legend>        
        <table class="tabel" style="width: 50%">
            <tr>
              <th width="3%" style="width: 10%">No</th>
              <th width="32%" style="width: 30%">Nama</th>
              <th width="21%" style="width: 20%">Kode ICD 10</th>
          </tr>
          <?php
            $diagnosa=unserialize($_GET['diagnosa']);
            $detail_diagnosa=  diagnosa_rekam_medik_muat_data(null, $diagnosa);
            $no=0;
            foreach($detail_diagnosa as $dd){
                $no++;
                echo "<tr>
                        <td>$no</td>
                        <td>".$dd['nama_diagnosa']."</td>
                        <td>".$dd['kode']."</td>  
                        </tr>
                    ";
            }
          ?>
       </table>
        </fieldset> 
        
        <fieldset><legend>Tindakan</legend>        
            <table class="tabel" style="width: 50%">
                <tr>
                  <th width="3%" style="width: 10%">No</th>
                  <th width="32%" style="width: 30%">Nama</th>
                  <th width="21%" style="width: 20%">Kode ICD 9</th>
                  <th width="21%" style="width: 25%">Informed Consent</th>
              </tr>
              <?php
            $tindakan=unserialize($_GET['tindakan']);
			if (!empty($tindakan))
			{
            $detail_tindakan= tindakan_rekam_medik_muat_data(null, $tindakan);
            $no=0;
            foreach($detail_tindakan as $dt){
                $no++;
                echo "<tr>
                        <td>$no</td>
                        <td>".$dt['nama_tindakan']."</td>
                        <td>".$dt['kode']."</td> 
                        <td>".$dt['ic']."</td>    
                        </tr>
                    ";
            }
			}
          ?>
           </table>
           </div>   
   <?php     
       //echo "<fieldset>";
    endif;
    
   ?>
  
    <input type="submit" value="Simpan" name="save" id="save" class="tombol" <?php if($preview) echo "disabled";?>/> 
    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('rekam-medik/diagnosa-tindakan') ?>'" />

    </fieldset>
    </form>
</div>