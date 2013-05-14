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
               var str='';
            var str=ac_nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)
return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
      var str=nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)

$(this).attr('value', str);
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
<?
include_once "app/lib/common/master-data.php";
include  'app/actions/admisi/pesan.php';
$sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
$kelas = kelas_muat_data();
$barang = array_value($_GET, 'barang');
$idBarang = array_value($_GET, 'idBarang');
$idKelas = array_value($_GET, 'kelas');
$idKategori = array_value($_GET, 'idKategori');
$kategori = kategori_barang_muat_data();
$namaKelas = kelas_muat_data($idKelas);
$namaKelas = array_value($namaKelas, 'nama');
$page  = isset($_GET['page'])?$_GET['page']:NULL;
$admBarang=  adm_harga_muat_data($idBarang, $barang,$idKategori,$idKelas,$page, $dataPerPage = 15,$sort,$sortBy);
?>
<h2 class="judul">Informasi Harga Jual Barang</h2><? echo isset($pesan) ? $pesan : NULL; ?>
<div class="data-input">
    <form action="<?= app_base_url('inventory/info-harga-jual') ?>" method="GET">
        <fieldset><legend>Form Pencarian Barang</legend>
            <label for="barang">Nama Barang</label><input type="text" name="barang" id="barang" value="<?= $barang ?>" class="nama_barang"/><input type="hidden" name="idBarang" id="idBarang" value="<?= $idBarang ?>"/>
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
                <option value="">Pilih Sub Kategori</option>
                <?php foreach ($kategori['list'] as $rows): ?>
                    <option value="<?= $rows['id'] ?>" <?= ($idKategori == $rows['id']) ? 'selected' : '' ?>>
                    <? echo $rows['nama'] . "-" . $rows['kategori'] ?>
                </option>
                <?php endforeach; ?>
                </select>
                <fieldset class="input-process">
                    <input type="submit" name="cari" value="Cari" class="tombol"/>
                    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-harga-jual') ?>'"/>
                </fieldset>
            </fieldset>
        </form>
    </div>
<?
if(isset ($_GET['cari']) && $_GET['cari'] == "Cari"){
?>
<div class="data-list" style="clear:left;padding-top: 20px">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th><a href="<?= app_base_url('inventory/info-harga-jual?').generate_sort_parameter(1, $sortBy)?>" class="sorting">Nama Barang</a></th>
            <th><a href="<?= app_base_url('inventory/info-harga-jual?').generate_sort_parameter(2, $sortBy)?>" class="sorting">Kelas</a></th>
            <th>Harga Beli (Rp)</th>
            <th>Harga Jual (Rp)</th>
            <th style="width: 10%">Margin (%)</th>
            <th>Harga Jual (Rp)</th>
        </tr>
        <?
        foreach ($admBarang['list'] as $num => $rows){
	  $nama=nama_packing_barang(array($rows['generik'],$rows['barang'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan_terkecil'],$rows['pabrik']));
       ?>
            <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
                <td align="center" style="width: 5%"><?= ++$num + $admBarang['offset'] ?></td>
                <td><?=$nama?></td>
                <td style="width: 10%"><?= $rows['nama_kelas'] ?></td>
                <td style="width: 10%; text-align: right;"><?= rupiah(($rows['hpp']==null) ? '0' : $rows['hpp']).",00" ?></td>
                <td style="width: 10%; text-align: right;"><?= rupiah(($rows['hna']==null) ? '0' : $rows['hna']).",00" ?></td>
                <td style="width: 10%"><?= $rows['margin']?></td>
                <td style="width: 10%; text-align: right;">
                  <?
                     $hargaJual = ($rows['hna']*$rows['margin']/100)+$rows['hna'];
                     echo rupiah($hargaJual).",00";
                  ?>
                </td>
            </tr>
        <?
        }
        ?>
    </table>
</div>
<?= $admBarang['paging'] ?>
<?}?>
<script type="text/javascript">
    function setMarginValue(element){
        Angka(element);
        if($('input:checked').length>0){
            $('.margin').attr('value',$(element).attr('value'));
        }

    }
</script>
