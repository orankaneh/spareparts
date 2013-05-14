<?php
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
$norm = isset ($_GET['norm'])?$_GET['norm']:"";
$namaPasien = isset ($_GET['namaPasien'])?$_GET['namaPasien']:"";
$umur = isset ($_GET['tglLahir'])?($_GET['tglLahir']):"";
$agama = isset ($_GET['agama'])?$_GET['agama']:"";
$pekerjaan = isset ($_GET['pekerjaan'])?$_GET['pekerjaan']:"";
$alamat = isset ($_GET['alamat'])?$_GET['alamat']:"";
$kelurahan = isset ($_GET['kelurahan'])?$_GET['kelurahan']:"";
?>
<script type="text/javascript">
    $(document).ready(function(){
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
           $('#tglLahir').val(data.tanggal_lahir);
           hitungUmur();
           $('#agama').html(data.agama);
           $('#pekerjaan').html(data.pekerjaan);
           $('#alamat').html(data.alamat_jalan);
           $('#kelurahan').html(data.nama_kelurahan);
           $('.agama').val(data.agama);
           $('.pekerjaan').val(data.pekerjaan);
           $('.alamat').val(data.alamat_jalan);
           $('.kelurahan').val(data.nama_kelurahan);
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
           $('#tglLahir').val(data.tanggal_lahir);
           hitungUmur();
           $('#agama').html(data.agama);
           $('#pekerjaan').html(data.pekerjaan);
           $('#alamat').html(data.alamat_jalan);
           $('#kelurahan').html(data.nama_kelurahan);
           $('.agama').val(data.agama);
           $('.pekerjaan').val(data.pekerjaan);
           $('.alamat').val(data.alamat_jalan);
           $('.kelurahan').val(data.nama_kelurahan);
       });
    })
</script>
<h2 class="judul">Rekam Medik</h2>
<div class="data-input">
    <fieldset>
        <form action="" method="GET">
        <legend>Parameter Pencarian</legend>
        <label>No. RM*</label><input type="text" name="norm" id="norm" value="<?php echo "$norm";?>"/>
        <label>Nama Lengkap*</label><input type="text" name="namaPasien" id="namaPasien" value="<?php echo "$namaPasien";?>"/>
        <fieldset class="field-group">
            <label>Umur</label>
            <input type="hidden" id="tglLahir" name="tglLahir"/>
            <span style="font-size: 12px;padding-top: 5px;" id="umur"><?php echo "$umur";?></span>
        </fieldset>
        <label>Agama</label><span style="font-size: 12px;padding-top: 5px;" id="agama"><?php echo "$agama";?></span><input type="hidden" name="agama" class="agama" value="<?php echo "$agama";?>"/>
        <label>Pekerjaan</label><span style="font-size: 12px;padding-top: 5px;" id="pekerjaan"><?php echo "$pekerjaan";?></span><input type="hidden" name="pekerjaan" class="pekerjaan" value="<?php echo "$pekerjaan";?>"/>
        <label>Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"><?php echo "$alamat";?></span><input type="hidden" name="alamat" class="alamat" value="<?php echo "$alamat";?>"/>
        <label>Kelurahan</label><span style="font-size: 12px;padding-top: 5px;" id="kelurahan"><?php echo "$kelurahan";?></span><input type="hidden" name="kelurahan" class="kelurahan" value="<?php echo "$kelurahan";?>"/>
        <fieldset class="input-process">
            <input type="submit" value="Cari" class="tombol" name="cari"/> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('rekam-medik/informasi/info-rekam-medik') ?>'"/>
        </fieldset>
        </form>
    </fieldset>
</div>
<?php
 if(isset ($_GET['cari']) && $_GET['cari'] != ""){
     $pelayanan = pelayanan_muat_data($norm);
?>     
<div class="data-list">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Waktu</th>
            <th>Bed</th>
            <th>Dokter</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        foreach ($pelayanan as $row){
        ?>
        <tr class="<?php echo ($no%2)?"even":"odd";?>">
            <td><?php echo $no++;?></td>
            <td><?php echo datetime($row['waktu'])?></td>
            <td><?php echo "Klinik ".$row['bed']." ".$row['instalasi']?></td>
            <td><?php echo $row['dokter']?></td>
            <td class="aksi">
                <a href="?<?php echo generate_get_parameter($_GET)."&id=$row[id]&do=detail";?>" class="detail">detail</a>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
<?php
if (isset($_GET['id']))
{
?>
    <fieldset>
        <legend>Diagnosa & Tindakan Pelayanan Medik</legend>
        <?php
          $diagnosa = diagnosa_tindakan_rekam_medik($_GET['id']);
        ?>
        <fieldset style="width:90%">
            <legend>Detail Diagnosa</legend>
            <div class="data-list">
                <table class="tabel">
                    <tr>
                        <th>No</th>
                        <th>Nama ICD 10</th>
                        <th>Kode ICD 10</th>
                    </tr>
                    <?php
                        $i = 1;
                        foreach ($diagnosa['diagnosa'] as $rows){
                    ?>
                    <tr class="<?php echo ($i%2)?"even":"odd";?>">
                        <td align="center"><?php echo $i++;?></td>
                        <td><?php echo $rows['penyakit']?></td>
                        <td><?php echo $rows['kode_icd10']?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>
        </fieldset>
        <fieldset style="width:90%">
            <legend>Detail Tindakan</legend>
            <div class="data-list">
                <table class="tabel">
                    <tr>
                        <th>No</th>
                        <th>Nama ICD 9</th>
                        <th>Kode ICD 9</th>
                        <th>Informed Consent</th>
                    </tr>
                    <?php
                        $j = 1;
                        foreach ($diagnosa['tindakan'] as $rowz){
                    ?>
                    <tr class="<?php echo ($j%2)?"even":"odd";?>">
                        <td align="center"><?php echo $j++?></td>
                        <td><?php echo $rowz['penyakit']?></td>
                        <td><?php echo $rowz['kode_icd9']?></td>
                        <td><?php echo $rowz['informed_consent']?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>    
        </fieldset>
    </fieldset>
<?php
}    
 }
?>