<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/satuan.php';
include 'app/actions/admisi/pesan.php';

$satuan = satuan_muat_data_all();
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
$code = isset($_GET['code'])?$_GET['code']:NULL;
$barangs = packing_barang_muat_data($code, $page, $dataPerPage = 15, $sort, $sortBy, $key);
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/packing-barang')?>">Administrasi Packing Barang</a></h2><?= isset($pesan) ? $pesan : NULL; ?>
<?
if (isset($_GET['do']) && $_GET['do'] == "add") {
    $title = "Form Packing Barang";
} else if (isset($_GET['do']) && $_GET['do'] == "edit") {
    $title = "Form Packing Barang";
}else
    $title = "";
if (isset($_GET['do']) && ($_GET['do'] == 'edit' || $_GET['do'] == 'add')) {
    if ($_GET['do'] == 'edit') {
        $packingBarang = packing_barang_muat_data($_GET['id'], NULL, NULL);
    }else
    $packingBarang=array();
    $idBarang = array_value($packingBarang, "id_barang");
    $idPackingBarang = array_value($packingBarang, "id_packing");
    $namaBarang = array_value($packingBarang, "nama_barang");
    $idKemasan = array_value($packingBarang, "id_satuan_terbesar");
    $nilaiKonversi = array_value($packingBarang, "nilai_konversi");
    $kategori = array_value($packingBarang, "nama_kategori");
    $satuanTerkecil = array_value($packingBarang, "id_satuan_terkecil");
    $barcode = array_value($packingBarang, "barcode");
    $kekuatan = array_value($packingBarang, "kekuatan");
    $generik = array_value($packingBarang, "generik");
    $pabrik = array_value($packingBarang, "instansi_relasi");
    $sediaan = array_value($packingBarang, "sediaan");
    
    if($kekuatan == NULL || $kekuatan == 0){
        $kekuatans = "";
    }else $kekuatans = " ".$kekuatan;
    if($sediaan == NULL){
        $sediaans = "";
    }else $sediaans = " ".$sediaan;
    if($pabrik == NULL){
        $pabriks = "";
    }else $pabriks = " ".$pabrik;
    
    $barang = $namaBarang.$kekuatans.$sediaans.$pabriks;
?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#namaBarang').focus();
            $('#namaBarang').autocomplete("<?= app_base_url('/inventory/search?opsi=barang') ?>",
            {
                parse: function(data){
                    var parsed = [];
                    for (var i=0; i < data.length; i++) {
                        parsed[i] = {
                            data: data[i],
                            value: data[i].nama // nama field yang dicari
                        };
                    }
                    $('#idBarang').attr('value','');
                    return parsed;
                },
                formatItem: function(data,i,max){
                    if (data.generik == "Generik"||data.generik == "Non Generik"){
                    if(data.kekuatan == null || data.kekuatan == 0){
                        kekuatan = "";
                    }else kekuatan = " "+data.kekuatan;
                    if(data.sediaan == null){
                        sediaan = "";
                    }else sediaan = " "+data.sediaan;
                    pabrik='';
                    if(data.generik=="Generik"){
                        if(data.pabrik==null || data.pabrik=='None'){
                            pabrik='';
                        }else{
                            pabrik=' '+data.pabrik;
                        }
                    }
                }else{
                    kekuatan='';
                    sediaan='';
                    pabrik='';
                }
                    
                    var str = '<div class=result><b>'+data.nama+'</b> <i>'+kekuatan+sediaan+' '+pabrik+'</i></div>';
                    
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                if (data.generik == "Generik"||data.generik == "Non Generik"){
                    if(data.kekuatan == null || data.kekuatan == 0){
                        kekuatan = "";
                    }else kekuatan = " "+data.kekuatan;
                    if(data.sediaan == null){
                        sediaan = "";
                    }else sediaan = " "+data.sediaan;
                    pabrik='';
                    if(data.generik=="Generik"){
                        if(data.pabrik==null){
                            pabrik='';
                        }else{
                            pabrik=' '+data.pabrik;
                        }
                    }
                }else{
                    kekuatan='';
                    sediaan='';
                    pabrik='';
                }
                $('#idBarang').attr('value',data.id);
                $('#namaBarang').attr('value',data.nama+kekuatan+sediaan+' '+pabrik);
            }
        );
        });
        function cek_barcode(barcode)
        {
            $.ajax({
                url: "<?= app_base_url('/inventory/search?opsi=cek_barcode') ?>",
                data:'&barcode='+$('#barcode').attr('value'),
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(msg.length!=0){
                        alert('Barcode sudah dipakai');
						$('#barcode').attr('value','');
						$('#barcode').focus();
                    }else{
                        return false;
                    }
                }
            });
        }
        function cekForm(){
            if($('#idBarang').attr('value')==''){
                $.ajax({
                    url: "<?= app_base_url('/inventory/search?opsi=barang') ?>",
                    data:'&q='+$('#namaBarang').attr('value'),
                    cache: false,
                    dataType: 'json',
                    success: function(msg){
                        if (msg.length==1){
                            $('#namaBarang').attr('value',msg[0].nama);
                            $('#idBarang').attr('value',msg[0].id);
                            cekForm();
                        }if(msg.length==0 || $('#idBarang').attr('value')==''){
                            alert('Barang belum ditemukan');
                            $('#namaBarang').focus();
                        }else if(msg.length>1){
                            alert('Data barang ambigu, silakan input ulang');
                            $('#namaBarang').focus();
                        }
                    }
                });
            }else if($('#namaBarang').attr('value')==''){
                alert('Nama Barang belum diisi');
                $('#namaBarang').focus();
                return false;
            }else if($('#kemasan').attr('value')==''){
                alert('Kemasan belum dipilih');
                $('#kemasan').focus();
                return false;
            }else if($('#satuan').attr('value')==''){
                alert('Satuan belum dipilih');
                $('#satuan').focus();
                return false;
            }else if($('#konversi').attr('value')==''){
                alert('Nilai konversi harus diisi');
                $('#konversi').focus();
                return false;
            }
            //cek packing barang, dengan parameter id.barang, id satuan terkecil, id satuan terbesar dan nilai konversi
            $.ajax({
                url: "<?= app_base_url('/inventory/search?opsi=cek_packing_barang') ?>",
                data:'&id_barang='+$('#idBarang').attr('value')+'&satuan_terkecil='+$('#satuan').attr('value')+'&satuan_terbesar='+$('#kemasan').attr('value')+'&nilai_konversi='+$('#konversi').attr('value')+'&id_packing='+$('#idPackingBarang').attr('value'),
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(msg.length!=0){
                        alert('Packing barang sudah tersedia');
                    }else if ($('#idBarang').attr('value')!=''){
                        $('#packingForm').submit();
                    }else{
                        return false;
                    }
                }
            });
        }

    </script>
    <div class="data-input">
        <fieldset><legend><?= $title ?></legend>
            <form action="<?= app_base_url('inventory/control/packing-barang') ?>" method="post" id="packingForm" name="packing">
                <label for="barcode">Barcode</label><input type="text" name="barcode" id="barcode" value="<?= $barcode ?>" onkeyup="Angka(this)" onblur="cek_barcode(this)" />
                <input type="hidden" name="idBarang" id="idBarang" value="<?= $idBarang ?>"/>
                <input type="hidden" name="idPackingBarang" id="idPackingBarang" value="<?= $idPackingBarang ?>"/>
                <label for="barang">Barang</label><input type="text" name="namaBarang" id="namaBarang" value="<?= $barang ?>" style="min-width:300px"/><span class="bintang">*</span>
                <label for="kemasan">Kemasan</label>
                <select name="kemasan" id="kemasan">
                    <option value="">Pilih kemasan</option>
                <?php foreach ($satuan as $row): ?>
                    <option value="<?= $row['id'] ?>" <?= ($idKemasan == $row['id']) ? 'selected' : '' ?>>
                    <?= $row['nama'] ?>
                </option>
                <?php endforeach; ?>
                </select><span class="bintang">*</span>
                <label for="kemasan">Satuan terkecil</label>
                <select name="satuan" id="satuan">
                    <option value="">Pilih satuan</option>
                <?php foreach ($satuan as $row): ?>
                        <option value="<?= $row['id'] ?>"  <?= ($satuanTerkecil == $row['id']) ? 'selected' : '' ?>>
                    <?= $row['nama'] ?>
                    </option>
                <?php endforeach; ?>
                    </select><span class="bintang">*</span>
                    <label for="konversi">Nilai Konversi</label><input type="text" name="konversi" id="konversi" maxlength="9" value="<?= $nilaiKonversi ?>" onKeyup="Desimal(this)"/><span class="bintang">*</span>
                    <fieldset class="input-process">
                        <input type="button" value="Simpan" class="tombol tombol_ok" name="simpan" onclick="return cekForm()"/>
                        <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('inventory/packing-barang') ?>'"/>
                    </fieldset>
                </form>
            </fieldset>
        </div>
<?
                    }
?>
                    <div class="data-list w900px">
                        <div class="floleft">
                            <a href="<?= app_base_url('inventory/packing-barang?do=add') ?>" class="add"><div class="icon button-add"></div>Tambah</a>
                        </div>
                        <div class="floright" style="margin: -5px 0 0 0">
                            <form action="" method="GET" class="search-form">
                                 <span style="float:right;">Nama: <input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" value="" class="search-button"/></span>
                            </form>
                        </div>    
                        <table class="tabel full">
                            <tr>
                                <th>NO</th>
                                <th><a href="<?= app_base_url('inventory/packing-barang?') . generate_sort_parameter(2, $sortBy) ?>" class="sorting">Barcode</a></th>
                                <th><a href="<?= app_base_url('inventory/packing-barang?') . generate_sort_parameter(3, $sortBy) ?>" class="sorting">Barang</a></th>
                                <th>Kemasan</th>
                                <th>Konversi</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </tr>
        <?php
		 $no=nomer_paging($page,15);
                    foreach ($barangs['list'] as $key => $row):
                      
                        $nama=nama_packing_barang(array($row['generik'],$row['nama_barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan'],$row['instansi_relasi']));
        ?>
                        <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                            <td align="center"><?= $no++ ?></td>
                            <td>
                <?
                        if ($row['barcode'] == "") {
                            echo "$row[id_packing]";
                        }else
                            echo "$row[barcode]";
                ?>
                    </td>
                    <td class="no-wrap"><?= $nama ?></td>
                    <td><?= $row['kemasan'] ?></td>
                    <td><?= $row['nilai_konversi'] ?></td>
                    <td><?= $row['satuan'] ?></td>
                    <td class="aksi">
                        <a href="<?= app_base_url('inventory/packing-barang?do=edit&id=' . $row['id_packing'].'&'.generate_get_parameter($_GET, null, array('msr','msg','do','id'))) ?>" class="edit"><small>edit</small></a>
                        <a href="<?= app_base_url('inventory/control/packing-barang?do=del&id=' .$row['id_packing'].'&'.generate_get_parameter($_GET, null, array('msr','msg','do','id'))) ?>" class="delete"><small>delete</small></a>
                </tr>
        <?php endforeach; ?>
                    </table>
                    <a href="<?= app_base_url('pf/report/packing-barang-excel') ?>" class="excel" style="float:right;" >Cetak Excel</a>    
                    </div>
<?= $barangs['paging'] ?>