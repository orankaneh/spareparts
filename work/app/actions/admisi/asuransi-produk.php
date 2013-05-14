<script type="text/javascript">
    $(document).ready(function(){
        $('#asuransi').focus();
        $('#perusahaan').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier') ?>&jenis_instansi=8",
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
                var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idperusahaan').attr('value',data.id);
        }
    );
    });
    function cekForm(){
        if($('#asuransi').val() == ""){
            alert('Nama asuransi tidak boleh kosong');
            $('#asuransi').focus();
            return false;
        }else if($('#idperusahaan').val() == ""){
            $.ajax({
                url: "<?= app_base_url('/inventory/search?opsi=suplier') ?>&jenis_instansi=8",
                data:'&q='+$('#pabrik').attr('value'),
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if (msg.length==1){
                        $('#pabrik').attr('value',msg[0].nama);
                        $('#idperusahaan').attr('value',msg[0].id);
                        cekForm();
                    }if(msg.length==0){
                        alert('Pabrik belum ditemukan');
                        $('#pabrik').focus();
                    }else if(msg.length>1){
                        alert('Data pabrik ambigu, silakan input ulang'+msg.length);
                        $('#pabrik').focus();
                    }
                }
             });
            return false;
        }else{
          var num=$(".nama").length;
          for(var i=0;i<num;i++){
              if($(".nama:eq("+i+")").html()==$('#asuransi').attr('value')&&$(".id:eq("+i+")").html()!=$('#idAsuransi').attr('value')){
                  alert('Nama '+$('#asuransi').attr('value')+' sudah di inputkan');
                  $('#asuransi').focus();
                  return false;
              }
          }
        }
    }
</script>    
<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';

$sort	= isset($_GET['sort']) ? $_GET['sort'] : NULL;
$by		= isset($_GET['by']) ? $_GET['by'] : 'asc';

//membuat link sorting
if($sort=='id' && $by == 'asc')
    $id = app_base_url('admisi/asuransi-produk?sort=id&by=desc');
else
    $id = app_base_url('admisi/asuransi-produk?sort=id&by=asc');

if($sort=='nama' && $by == 'desc')
    $nama = app_base_url('admisi/asuransi-produk?sort=nama&by=asc');
else
    $nama = app_base_url('admisi/asuransi-produk?sort=nama&by=desc');

$idProduk = isset ($_GET['idProduk'])?$_GET['idProduk']:NULL;
$kunci	  = isset ($_GET['key']) ? $_GET['key'] : NULL;
$asuransis = asuransi_produk_muat_data($idProduk,$kunci,$sort,$by);
?>

<h2 class="judul"><a href="<?= app_base_url('admisi/asuransi-produk')?>">Master Data Produk Asuransi</a></h2><? echo isset($pesan) ? $pesan : NULL; ?>
<?
if (isset($_GET['do']) && ($_GET['do'] == 'edit' || $_GET['do'] == 'add')) {
    if ($_GET['do'] == 'edit') {
        $asuransi = asuransi_produk_muat_data($_GET['id']);
    }else
    $asuransi[0]=array();
    $idAsuransi = array_value($asuransi[0], "id");
    $namaAsuransi = array_value($asuransi[0], "asuransi");
    $perusahaanAsuransi = array_value($asuransi[0], "perusahaan");
    $idPerusahaan = array_value($asuransi[0], "id_instansi_relasi");
?>
    <div class="data-input">
        <fieldset><legend>Form Produk Asuransi</legend>
            <form action="<?= app_base_url('admisi/control/asuransi-produk') ?>" method="post" onsubmit="return cekForm()">
                <input type="hidden" name="idAsuransi" id="idAsuransi" value="<?= $idAsuransi ?>"/>
                <label for="nama">Nama</label><input type="text" name="nama" id="asuransi" onkeyup="AlpaNumerik(this)" value="<?= $namaAsuransi ?>"/>
                <label for="instansi-relasi">Perusahaan Asuransi</label><input type="text" id="perusahaan" value="<?= $perusahaanAsuransi ?>"/><input type="hidden" name="idPerusahaan" id="idperusahaan" value="<?= $idPerusahaan ?>"/>
                <fieldset class="input-process">
                    <input type="submit" value="Simpan" class="tombol tombol_ok" name="simpan"/>
                    <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('admisi/asuransi-produk') ?>'"/>
                </fieldset>
            </form>
        </fieldset>
    </div>
<?
}
?>
<div class="data-list w600px">
	<div class="floleft"><?php echo addButton('/admisi/asuransi-produk/?do=add','Tambah Asuransi'); ?></div>
	<div class="floright">
    <form action="<?= app_base_url('admisi/asuransi-produk/')?>" method="GET" class="search-form" style="margin-top: -5px">
        <input type="text" name="key" class="search-input" value="<?= $kunci?>" /><input type="submit" class="search-button" value="" />     
    </form>
	</div>
    <table class="tabel full">
        <tr>
			<th width="10%">NO</th>
			<th width="30%"><a href="<?php echo $nama; ?>" class="sorting">Nama</a></th>
            <!--<th width="10%">ID</th>
            <th width="30%"><?= $sorting?></th>-->
            <th width="45%">Perusahaan</th>
            <th width="15%">Aksi</th>
        </tr>
        <?php
         foreach ($asuransis as $key => $row): 
        ?>
            <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                <td class="id" align="center"><?=++$key?></td>
                <td class="nama"><?= $row['asuransi'] ?></td>
                <td><?= $row['perusahaan'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('admisi/asuransi-produk?do=edit&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('admisi/control/asuransi-produk?do=del&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>delete</small></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?
      $count = count($asuransis);
      echo "<p>Jumlah Total Nama Asuransi: ".$count."</p>";
?>