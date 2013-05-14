<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/wilayah.php';
require_once 'app/lib/pf/barang-pbf.php';

$provinsis= propinsi_muat_data();
$kabupatens=  kabupaten_muat_data();
$kecamatans= kecamatan_muat_data();
$barangs=  barang_muat_data();
?>
<script type="text/javascript">
$(function() {
    
    $('#barang-provinsi').autocomplete("<?= app_base_url('/pf/inventory/search?opsi=provinsi') ?>",
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
            var str='<div class=result>(id:'+data.id+') <i>'+data.nama+'</i> </div>';
            return str;
        },
        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    })
    .result(
        function(event,data,formated){

            $('#id-barang-provinsi').attr('value',data.id);
            $('#barang-provinsi').attr('value',data.nama);
            $('#barang-kabupaten').attr('value','');
            $('#id-barang-kabupaten').attr('value','');
            
        }
    );
});
</script>
<script type="text/javascript">

$(function() {
    
    $('#barang-kabupaten').focus(function(){
   
    var idProvinsi = $('#id-barang-provinsi').val();
    
    
    $('#barang-kabupaten').autocomplete("<?= app_base_url('/pf/inventory/search?opsi=kabupaten') ?>&idprovinsi="+ idProvinsi,
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
            var str='<div class=result>(id:'+data.id+') <i>'+data.nama+'</i> </div>';
            return str;
        },
        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
        function(event,data,formated){
            $('#id-barang-kabupaten').attr('value',data.id);
            $('#barang-kabupaten').attr('value',data.nama);
            $('#id-barang-kecamatan').attr('value','');
            $('#barang-kecamatan').attr('value','');
        }
    );
    });
});
</script>
<script type="text/javascript">

$(function() {

    $('#barang-kecamatan').focus(function(){

    var idKabupaten = $('#id-barang-kabupaten').val();


    $('#barang-kecamatan').autocomplete("<?= app_base_url('/pf/inventory/search?opsi=kecamatan') ?>&idkabupaten="+ idKabupaten,
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
            var str='<div class=result>(id:'+data.id+') <i>'+data.nama+'</i> </div>';
            return str;
        },
        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
        function(event,data,formated){
            $('#id-barang-kecamatan').attr('value',data.id);
            $('#barang-kecamatan').attr('value',data.nama);
        }
    );
    });
});
</script>
<h1 class="judul">INPUT & EDIT DATA PEMASOK BARANG FARMASI (PBF)</h1>
<div class="data-input">
    <form action="<?= app_base_url('/pf/barang/manajemen_barang') ?>" method="post">
        <fieldset>
            <legend>Input Data</legend>
            <label for="barang-kode">Kode PBF</label>
            <input type="text" id="barang-kode" name="kode-pbf" value="" disabled>
            <label for="barang-nama">Nama PBF</label>
            <input type="text" id="barang-nama" name="nama-pbf" value="">
            <label for="barang-alamat">Alamat</label>
            <textarea name="alamat" id="barang-alamat" cols="50" rows="5"></textarea>
            <label for="barang-provinsi">Provinsi</label>
            <input type="text" name="provinsi" id="barang-provinsi" autocomplete="off" />
            <input type="hidden" name="id-provinsi" id="id-barang-provinsi" />
            
            <label for="barang-kabupaten">Kabupaten</label>
            <input type="text" name="kabupaten" id="barang-kabupaten" autocomplete="off" />
            <input type="hidden" name="id-kabupaten" id="id-barang-kabupaten" />
            
            <label for="barang-kecamatan">Kecamatan</label>
            <input type="text" name="kecamatan" id="barang-kecamatan" autocomplete="off" />
            <input type="hidden" name="id-kecamatan" id="id-barang-kecamatan" />
            
            <fieldset class="input-process">
                <input type="submit" value="Tambah" class="tombol">
                <input type="submit" value="Batal" class="tombol">
            </fieldset>
        </fieldset>
        
    </form>
</div>

<div class="data-list">
    <table class="tabel">
        
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Kecamatan</th>
                <th>Kabupaten</th>
                <th>Provinsi</th>
                <th>Aksi</th>
            </tr>
       
            <? foreach ($barangs as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td><?= $row['kode'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['kecamatan'] ?></td>
                <td><?= $row['kabupaten'] ?></td>
                <td><?= $row['provinsi'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/inventory/manajemen_barang/?do=edit&id='.$row['id']) ?>" class="edit"><small>edit</small></a>
                </td>
            </tr>
            <? endforeach ?>
        </tbody>
    </table>
</div>
