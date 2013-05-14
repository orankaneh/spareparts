<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/actions/admisi/pesan.php';
$id = isset($_GET['id'])?$_GET['id']:NULL;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$data_perpage = 10;
$kejadian_sakit = kejadian_sakit_muat_data(NULL, $page, $data_perpage);
if(isset ($_GET['do']) && $_GET['do'] == "Edit"){
    $data_input = kejadian_sakit_muat_data($id);
    $nama = $data_input['nama'];
    $waktu_kejadian = datetime($data_input['waktu_kejadian']);
    $waktu_tiba = datetime($data_input['waktu_tiba']);
    $alamat = $data_input['alamat_jalan'];
    $kelurahan = $data_input['kelurahan'];
    $id_kelurahan = $data_input['id_kelurahan'];
    $penyebab_cedera = $data_input['penyebab_cedera'];
}else{
    $nama = "";
    $waktu_kejadian = "";
    $waktu_tiba = "";
    $alamat = "";
    $kelurahan = "";
    $id_kelurahan = "";
    $penyebab_cedera = "";
}
?>
<script type="text/javascript">
  function deleteConfirm(id, data) {
	$('.data-input').hide();
	$('#confirm-form').fadeIn();
	$('#idformhapus').val(id);
        $('#val').html(data);
	return false;
  }
  $(function() {
        $('#nama').focus();
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
            $('#id_kelurahan').attr('value',data.id_kel);
        }
    );
    
    $('#submit').click(function(){
        if($('#nama').val() == ""){
            alert('Nama kejadian kecelakaan harus diisi');
            $('#nama').focus();
            return false;
        }
        if($('#waktu_tiba').val() == ""){
            alert('Waktu tiba harus diisi');
            $('#waktu_tiba').focus();
            return false;
        }
        if($('#waktu_kejadian').val() == ""){
            alert('Waktu kejadian harus diisi');
            $('#waktu_kejadian').focus();
            return false;
        }
        if($('#alamat').val() == ""){
            alert('Alamat jalan harus diisi');
            $('#alamat').focus();
            return false;
        }
        if($('#kelurahan').val() == ""){
            alert('Kelurahan harus diisi');
            $('#kelurahan').focus();
            return false;
        }
        if($('#id_kelurahan').val() == ""){
            alert('Pilih kelurahan dengan benar');
            $('#kelurahan').focus();
            return false;
        }
        if($('#penyebab_cedera').val() == ""){
            alert('Penyebab cedera harus diisi');
            $('#penyebab_cedera').focus();
            return false;
        }
    })    
  })      
</script>
<h1 class="judul">Transaksi Kejadian Sakit</h1>
<? echo isset($pesan) ? $pesan : NULL; ?>
<div class="data-input">
    <fieldset>
        <legend>Form <?= isset($_GET['do'])?$_GET['do']:'Tambah' ?> Kejadian Sakit</legend>
        <form action="<?= app_base_url('rekam-medik/control/kejadian-sakit') ?>" method="POST">
          <label>Nama*</label><input type="text" name="nama" id="nama" value="<?php echo "$nama";?>"/>  
          <label>Waktu Tiba*</label><input type="text" name="waktu_tiba" id="waktu_tiba" class="datetimepicker" value="<?php echo "$waktu_tiba";?>"/>
          <label>Waktu Kejadian*</label><input type="text" name="waktu_kejadian" id="waktu_kejadian" class="datetimepicker" value="<?php echo "$waktu_kejadian";?>"/>
          <label>Alamat Jalan/RT/RW*</label><input type="text" name="alamat" id="alamat" value="<?php echo "$alamat";?>"/>
          <label>Desa/Kelurahan*</label><input type="text" name="kelurahan" id="kelurahan" value="<?php echo "$kelurahan";?>"/><input type="hidden" name="id_kelurahan" id="id_kelurahan" value="<?php echo "$id_kelurahan";?>"/>
          <label>Penyebab Cedera*</label><textarea name="penyebab_cedera" id="penyebab_cedera" ><?php echo "$penyebab_cedera";?></textarea>
          <fieldset class="input-process">
            <input type="hidden" value="<?= isset($_GET['id'])?$_GET['id']:NULL ?>" name="id" />
            <input type="submit" value="Simpan" name="submit" id="submit" />
            <input type="button" value="Cancel" onclick=location.href="<?= app_base_url('rekam-medik/kejadian-sakit') ?>" />
          </fieldset>
        </form>
    </fieldset>
</div>
<div id="confirm-form" class='hidden-obj'>
    Apakah anda setuju menghapus data <span id="val"></span>?<br />
    <form action="<?= app_base_url('rekam-medik/control/kejadian-sakit'); ?>" method="post">
    <input type='hidden' id='idformhapus' name='idformhapus' />
    <input type='submit' value='Hapus' name='hapus' />
    <input type='button' value='Batal' onclick=location.href="<?= app_base_url('rekam-medik/kejadian-sakit') ?>" />
    </form>
</div>
<div class="data-list tabelflexibel">
    <table class="tabel">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Waktu Tiba</th>
            <th>Waktu Kejadian</th>
            <th>Alamat</th>
            <th>Kelurahan</th>
            <th>Penyebab Cedera</th>
            <th>Aksi</th>
        </tr>
        <?php
        foreach ($kejadian_sakit['list'] as $key => $row){
        ?>
        <tr class="<?php echo ($key%2)?"even":"odd";?>">
            <td align="center"><?php echo $row['id'];?></td>
            <td><?php echo $row['nama'];?></td>
            <td style="width: 10%">
              <?php 
                echo datetime($row['waktu_tiba']);
              ?>
            </td>
            <td style="width: 10%">
              <?php 
                echo datetime($row['waktu_kejadian']);
              ?>
            </td>
            <td><?php echo $row['alamat_jalan'];?></td>
            <td style="width: 15%"><?php echo $row['kelurahan'];?></td>
            <td><?php echo $row['penyebab_cedera'];?></td>
            <td class="aksi" style="width: 10%">
                <a href="<?= app_base_url('rekam-medik/kejadian-sakit?do=Edit&id='.$row['id'].'&page='.$page.'') ?>" title="Edit" class="edit">Edit</a>
                <a title="Hapus" class="delete" onClick="deleteConfirm(<?= $row['id']; ?>,'<?= $row['nama'] ?>')">Delete</a>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
<?php
  echo $kejadian_sakit['paging'];
?>