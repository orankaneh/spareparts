<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/satuan.php';
include 'app/actions/admisi/pesan.php';
$category = isset($_GET['category']) ? $_GET['category'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
$barangs = barang_muat_data($code, $sort, $sortBy, $page, $dataPerPage = 15, $key, $category);
$no=nomer_paging($page,$dataPerPage);
$barangTotal = barang_muat_data(NULL, NULL, NULL, NULL, NULL, $key, $category);
$kategori = sub_kategori_barang_muat_data();
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#barang').focus();
        $('input[name=batal]').mouseover(function(){
            $('input[name=batal]').addClass('focus');
        });
        $('input[name=batal]').mouseout(function(){
            $('input[name=batal]').removeClass('focus');
        });
        if($('#category').val()==0){
               $('#keyword').attr("disabled","disabled");
            }
        $('#category').change(function(){
            if($('#category').val()!=0){
                $('#keyword').removeAttr("disabled");
            }else{
                $('#keyword').attr("disabled","disabled");
            }
			
        });
        $('#pabrik').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier') ?>&jenis_instansi=5",
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
                $('#idpabrik').attr('value','');
                var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#pabrik').attr('value',data.nama);
            $('#idpabrik').attr('value',data.id);
        }
    );
    });

    function cekForm(){
        if($('#barang').attr('value')==''){
            alert('Nama barang masih kosong');
            $('#barang').focus();
            return false;
        }
		/*else if($('#idpabrik').attr('value')==''){
            $.ajax({
                url: "<?//= app_base_url('/inventory/search?opsi=suplier') ?>&jenis_instansi=5",
                data:'&q='+$('#pabrik').attr('value'),
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if (msg.length==1){
                        $('#pabrik').attr('value',msg[0].nama);
                        $('#idpabrik').attr('value',msg[0].id);
                        cekForm();
                    }if(msg.length==0 || $('#pabrik').attr('value')==''){
                        alert('Pabrik belum ditemukan');
                        $('#pabrik').focus();
                    }else if(msg.length>1){
                        alert('Data pabrik ambigu, silakan input ulang');
                        $('#pabrik').focus();
                    }
                }
            });
            return false;
        }
		*/else if($('#idKategori').attr('value')==''){
            alert('Kategori belum dipilih');
            $('#idKategori').focus();
            return false;
        }
        return true;
    }
    function validasiForm(){
        if(cekForm()){
            $.ajax({
                url: "<?= app_base_url('inventory/search?opsi=cek_barang') ?>&jenis_instansi=8",
                data:'&nama='+$('#barang').attr('value')+'&idbarang='+$('#idbarang').attr('value')+'&idpabrik='+$('#idpabrik').attr('value'),
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                        alert('Barang sudah ada di database!');
                        $('#barang').focus();
                        return false;
                    }else
                        $('form[name=barangForm]').submit();
                }
            });
        }
    }
    $(document).ready(function(){
   /*  $(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                        url: "<?= app_base_url('/inventory/search?opsi=paging_barang')?>",
                        data:'&page='+$(this).html()+'&perPage=<?php echo "$dataPerPage";?><?=isset($_GET['category'])?"&category=".$_GET['category']:""?><?=isset($_GET['sort'])?"&sort=".$_GET['sort']:""?><?=isset($_GET['sortBy'])?"&sortBy=".$_GET['sortBy']:""?><?=isset($_GET['key'])?"&key=".$_GET['key']:""?>',
                        cache: false,
                        dataType: 'json',
                        success: function(data){
                            
                            for(var i=0;i<data.length;i++){
                                value+='<li>'+data[i].nama+" ";
                                value+=data[i].kekuatan!=null?data[i].kekuatan+" ":"";
                                value+=data[i].sediaan!=null?data[i].sediaan+" ":"";
                                value+='</li>';
                            }
                            value+='</ul>';
                            $("span.tooltip").eq(index).children().html(value);
                            $("span.tooltip").eq(index).mouseover();
                        }
                });
            }else{
                $("span.tooltip").eq(index).mouseover();
            }
        });
    
        
        $("span.tooltip").tipsy({
            gravity:'w',
            html:true,
            title:function(){return $(this).children().html()}
        });    
        
        $(".block").mouseout(function(event){
            var index=$(".block").index($(this));
            $("span.tooltip").eq(index).mouseout();
            
        });
    
        */
   });
   
</script>
<h2 class="judul"><a href="<?= app_base_url('inventory/barang') ?>">Master Data Barang</a></h2><? echo isset($pesan) ? $pesan : NULL; ?>
<?
if (isset($_GET['do']) && ($_GET['do'] == 'edit' || $_GET['do'] == 'add')) {
    if ($_GET['do'] == 'edit') {
        $title = "Form Edit Data Barang";
    } else if ($_GET['do'] == 'add') {
        $title = "Form Tambah Data Barang";
    }else
        $title = "";
    if ($_GET['do'] == 'edit') {
        $barang = barang_muat_data($id = $_GET['id'], $sort = null, $sortBy = null, $page = NULL, $dataPerPage = NULL, $key = NULL, $kategori = NULL);
        $kategori = sub_kategori_barang_muat_data(NULL);
    }else
        $barang=array();
    $idBarang = array_value($barang, "id");
    $namaBarang = array_value($barang, "nama");
    $idKategori = array_value($barang, "id_sub_kategori_barang");
    $pabrik = array_value($barang, "pabrik");
    $idPabrik = array_value($barang, "idPabrik");
?>
    <div class="data-input">
        <fieldset><legend><?= $title ?></legend>
            <form action="<?= app_base_url('inventory/control/barang') ?>" method="post" name="barangForm"onsubmit="return cekForm()">
                <input type="hidden" name="idBarang" id="idbarang" value="<?= $idBarang ?>"/>
                <label for="barang">Nama Barang *</label><input type="text" name="nama" id="barang" value="<?= $namaBarang ?>" onblur="cekNamaBarang()"/>
                <label for="barang">Pabrik </label><input type="text" id="pabrik" value="<?= $pabrik ?>" onblur="cekPabrik()"/><input type="hidden" name="idPabrik" id="idpabrik" value="<?= $idPabrik ?>"/>
                <label for="subKategori">Sub kategori *</label>
                <select name="idKategori" id="idKategori">
                    <option value="">Pilih Kategori</option>
                <?php foreach ($kategori as $row): ?>
                    <option value="<?= $row['id'] ?>" <?= ($idKategori == $row['id']) ? 'selected' : '' ?>>
                    <? echo $row['nama'] . "-" . $row['kategori'] ?>
                </option>
                <?php endforeach; ?>
                </select>
                <fieldset class="input-process">
                    <input type="button" value="Simpan" class="tombol tombol_ok" name="simpan" onclick="validasiForm()"/>
                    <input type="button" value="Batal" name="batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('inventory/barang') ?>'"/>
                </fieldset>
            </form>
        </fieldset>
    </div>
<?
                }
?>

                <div class="data-list">
                    
                    <div id="perpage">
			<a href="<?= app_base_url('inventory/barang?do=add') ?>" class="add"><div class="icon button-add"></div>tambah</a>
                        <form action="" method="GET" class="search-form">
                            <select name="category" id="category" class="category">
                                <option value="0">Cari Berdasarkan</option>
                                <option value="1" <? if ($category == 1) echo "selected";?>>Nama</option>
				<option value="2" <? if ($category == 2) echo "selected";?>>Sub Kategori</option>
				<option value="3" <? if ($category == 3) echo "selected";?>>Pabrik</option>
			    </select>
			    <input type="text" name="key" class="formKcl" id="keyword" class="input-text" value="<?= $key ?>"/><input type="submit" class="search-button" value="" />
			</form>
    </div>

    <table class="tabel">
        <tr>
            <th><!--<a href="<?//= app_base_url('inventory/barang?') . generate_sort_parameter(0, $sortBy) ?>" class='sorting'></a>-->NO</th>
            <th style="width: 35%;"><a href="<?= app_base_url('inventory/barang?') . generate_sort_parameter(1, $sortBy) ?>" class='sorting'>Nama</a></th>
            <th style="width: 35%;"><a href="<?= app_base_url('inventory/barang?') . generate_sort_parameter(2, $sortBy) ?>" class='sorting'>Pabrik</a></th>
            <th style="width: 25%;"><a href="<?= app_base_url('inventory/barang?') . generate_sort_parameter(3, $sortBy) ?>" class='sorting'>Sub Kategori</a></th>
            <th style="width: 10%;">Aksi</th>
        </tr>
        <?php
                        foreach ($barangs['list'] as $key => $row):

                            if (($row['generik'] == 'Generik') || ($row['generik'] == 'Non Generik')) {
                                $nama = ($row['kekuatan']!=0)?"$row[nama] $row[kekuatan], $row[sediaan]":"$row[nama] $row[sediaan]";
                                $nama.=($row['generik'] == 'Generik')?' '. $row['pabrik']:'';
                            } else {
                                $nama = "$row[nama]";
                            }
        ?>
                            <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                                <td align="center"><?= ($no++) ?></td>
                                <td class="no-wrap"><?= $nama ?></td>
                                <td class="no-wrap"><?= $row['pabrik'] ?></td>
                                <td><?= $row['kategori'] ?></td>
                                <td class="aksi">
                                    <a href="<?= app_base_url('inventory/barang?do=edit&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                                    <a href="<?= app_base_url('inventory/control/barang?do=del&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>delete</small></a>
                                </td>
                            </tr>
        <?php endforeach; ?>
                        </table>
                    </div>
               <a class=excel class=tombol href="<?=app_base_url('inventory/report/barang-excel')?>">Cetak</a><p></p>
<?= $barangs['paging'] ?>
<?
                            $count = count($barangTotal['list']);
                            echo "<p>Jumlah Total Nama Barang: " . $count . "</p>";
?>
