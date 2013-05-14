<script type="text/javascript">
    $(function() {
        $('.cetak').click(function(){
           var win=window.open('<?=app_base_url('inventory/report/adm-harga').'?'.  generate_get_parameter($_GET)?>','MyWindow', 'width=300px,height=600px,scrollbars=1');
        });
        $('#barang').autocomplete("<?= app_base_url('/inventory/search?opsi=barang_margin') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama_barang // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                if(data.kekuatan == null){
                    kekuatan = "";
                }else kekuatan = "<b>Kekuatan: </b>"+data.kekuatan;
                if(data.sediaan == null){
                    sediaan = "";
                }else sediaan = " <b>Sediaan: </b>"+data.sediaan;
                
                $('#idBarang').removeAttr('value');
                var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+data.nilai_konversi+' '+data.satuan_terkecil+'</i><br>\n\
                '+kekuatan+''+sediaan+' <b>Pabrik :</b>'+data.pabrik+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var kekuatan,sediaan
            if(data.kekuatan == null){
                    kekuatan = "-";
                }else kekuatan = data.kekuatan;
                if(data.sediaan == null){
                    sediaan = "-";
                }else sediaan = data.sediaan;
            $(this).attr('value',data.nama_barang+' '+data.nilai_konversi+' '+data.satuan_terkecil+' Kekuatan: '+kekuatan+' Sediaan: '+sediaan+' Pabrik: '+data.pabrik);
            $('#idBarang').attr('value',data.id);
        });
    });
    function hitungHarga(index){
        var hargaJual;
        if($('input:checked').length>0){
            for(var i=0;i<=$('.margin').length;i++){
                index=i;
                hargaJual=($('#hna'+index).html()*$('#margin'+index).attr('value')/100)+$('#hna'+index).html()*1;
                $('#harga'+index).html(hargaJual);
            }
        }else{
            hargaJual=($('#hna'+index).html()*$('#margin'+index).attr('value')/100)+$('#hna'+index).html()*1;
            $('#harga'+index).html(hargaJual);
        }
    }
    function cekForm(){
        if($('select[name=kelas]').attr('value')==''){
            alert('Kelas harus diisi');
            return false;
        }else{
            return true;
        }
    }
</script>
<script type="text/javascript">
    function cekSearch(){
        if($('#idBarang').val() == "" && $('select[name=kelas]').val() == "" && $('select[name=idKategori]').val() == ""){
            alert('Masukkan minimal satu parameter pencarian untuk melakukan pencarian barang');
            return false;
        }
    }
</script>
<?
include_once "app/lib/common/master-data.php";
include  'app/actions/admisi/pesan.php';
$kelas = kelas_muat_data();
$barang = array_value($_GET, 'barang');
$idBarang = array_value($_GET, 'idBarang');
$idKelas = array_value($_GET, 'kelas');
$idKategori = array_value($_GET, 'idKategori');
$kategori = kategori_barang_muat_data();
$namaKelas = kelas_muat_data($idKelas);
$namaKelas = array_value($namaKelas, 'nama');
$page  = isset($_GET['page'])?$_GET['page']:NULL;
$pages  = isset($_GET['pages'])?$_GET['pages']:NULL;
$dataBarang = barang_adm_muat_data($idBarang, $barang,$idKategori,$idKelas,$pages,15);
$admBarang=  adm_harga_muat_data($idPacking=null, $barang=null, $idSubKategori=null, $idKelas=null,$page, $dataPerPage = 15);
?>
<h2 class="judul"><a href="<?php echo app_base_url('inventory/adm-harga');?>">Administrasi Harga Jual Barang</a></h2><? echo isset($pesan) ? $pesan : NULL; ?>
<div class="data-input">
    <form action="<?= app_base_url('inventory/adm-harga') ?>" method="GET" onSubmit="return cekSearch()">
        <fieldset><legend>Form Pencarian Barang</legend>
            <label for="barang">Nama Barang</label><input type="text" name="barang" id="barang" value="<?= $barang ?>"/><input type="hidden" name="idBarang" id="idBarang" value="<?= $idBarang ?>"/>
            <label for="kelas">Kelas</label>
            <select name="kelas">
                <option value="">Pilih Kelas</option>
                <?
                foreach ($kelas as $k) {
                    $selected = ($k['id'] == $idKelas) ? 'selected' : '';
                    echo"<option value='$k[id]' $selected>$k[nama]</option>";
                }
                ?>

            </select>
            <label for="kategori">Sub kategori</label>
            <select name="idKategori" id="kemasan">
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategori['list'] as $row): ?>
                    <option value="<?= $row['id'] ?>" <?= ($idKategori == $row['id']) ? 'selected' : '' ?>>
                    <? echo $row['nama'] . "-" . $row['kategori'] ?>
                </option>
                <?php endforeach; ?>
                </select>
                <fieldset class="input-process">
                    <input type="submit" name="cari" value="Cari" class="tombol"/>
                    <input type="reset" value="reset" class="tombol" />
                </fieldset>
            </fieldset>
        </form>
    </div>
<? if(isset($_GET['cari'])){?>
<form action="<?=  app_base_url('inventory/control/adm-harga')?>" method="POST">
    <input type="hidden" name="kelas" value="<?=$idKelas?>">
        <div class="data-list">
            <table class="tabel">
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Kelas</th>
                    <th>HPP</th>
                    <th>HNA</th>
                    <th style="width: 10%">Margin (%) <input type="checkbox" id="chekAll" checked></th>
                    <th>Harga Jual</th>
                </tr>
            <?php foreach ($dataBarang['list'] as $key => $row): ?>
                        <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                            <td align="center"><?= $row['id_margin'] ?></td>
                            <td><?= "$row[barang] $row[nilai_konversi] $row[satuan_terkecil]" ?></td>
                            <td><?= $row['nama_kelas'] ?></td>
                            <td id="hpp<?=$key?>"><?= ($row['hpp']==null)?'0':$row['hpp'] ?></td>
                            <td id="hna<?=$key?>"><?= ($row['hna']==null)?'0':$row['hna'] ?></td>
                            <td>
                                <input type="hidden" name="barang[<?=$key?>][id_margin]" value="<?=$row['id_margin']?>">
                                <input type="text" name="barang[<?=$key?>][margin]" onkeyup="setMarginValue(this)" class="margin" id="margin<?=$key?>" onblur="hitungHarga('<?=$key?>')" value="<?=$row['margin']?>">
                                <input type="hidden" name="barang[<?=$key?>][idPacking]" value="<?=$row['id_packing']?>">
                            </td>
                            <td id="harga<?=$key?>"></td>
                        </tr>
                        <script type="text/javascript">
                            hitungHarga(<?=$key?>);
                        </script>
            <?php endforeach; ?>
        </table>
        <?php
          echo $dataBarang['paging'];
        ?>    
         <div class="perpage" style="float:right">   
             <span class="cetak">Cetak</span>
             <a href="<?=app_base_url('inventory/report/adm-harga-excel').'?'.  generate_get_parameter($_GET)?>" class="excel">Cetak Excel</a>
         </div> 
   </div>
<span style="position: relative;float: left;clear: left;padding-top: 10px;">
    <input type="submit" value="Simpan" name="save" class="tombol" />
  <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/adm-harga') ?>'" />
 </span>
</form>
<?}?>
<div class="data-list" style="clear:left;padding-top: 20px">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Kelas</th>
            <th>HPP</th>
            <th>HNA</th>
            <th style="width: 10%">Margin (%)</th>
            <th>Harga Jual</th>
        </tr>
        <?
        foreach ($admBarang['list'] as $num => $rows){
            $kekuatan = isset ($rows['kekuatan'])?$rows['kekuatan']:"";
            $sediaan = isset ($rows['sediaan'])?$rows['sediaan']:"";
       ?> 
            <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num + $admBarang['offset'] ?></td>
                <td><?= "$rows[barang] $kekuatan $sediaan, $rows[pabrik] @$rows[nilai_konversi] $rows[satuan_terkecil]" ?></td>
                <td><?= $rows['nama_kelas'] ?></td>
                <td><?= ($rows['hpp']==null)?'0':$rows['hpp'] ?></td>
                <td><?= ($rows['hna']==null)?'0':$rows['hna'] ?></td>
                <td><?= $rows['margin']?></td>
                <td>
                  <?
                     $hargaJual = ($rows['hna']*$rows['margin']/100)+$rows['hna'];
                     echo "$hargaJual";
                  ?>
                </td>
            </tr>
        <?                
        }
        ?>
    </table>
</div>
<?= $admBarang['paging'] ?>
<script type="text/javascript">
    function setMarginValue(element){
        Angka(element);
        if($('input:checked').length>0){
            $('.margin').attr('value',$(element).attr('value'));
        }

    }
</script>