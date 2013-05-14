<?php
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
set_time_zone();
$tanggalCari = isset($_GET['tgl']) ? $_GET['tgl'] : NULL;
$tanggal = date('d/m/Y');
$obat = obat_muat_data();
$no = _select_arr("select id from formularium order by  id desc limit 0,1");
$nmr = isset($no[0]['id']) ? $no[0]['id'] + 1 : 0 + 1;

$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$id = isset($_GET['id']) ? $_GET['id'] : null;

$formularium = formularium_muat_data($id, $tanggalCari, $sort, $page, 15);
$id = $formularium['id'];
$content = $formularium['list'];
if (count($id) == 0) {
    $id = "";
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.tanggal').datepicker({
            changeYear:true,
            changeMonth:true
        })
        
        $('#obat').partsSelector({enableMoveControls:false});
    })
    
    $(function() {
        $('#formularium').autocomplete("<?= app_base_url('/inventory/search?opsi=formularium') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].id// nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                var str='<div class=result>'+data.id+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.id);
            $('#cariForm').submit();
        }
    );


        $('#obat').autocomplete("<?= app_base_url('/inventory/search?opsi=obat') ?>",
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
                $('.available-parts').html("");
                var nama=data.nama;
                $.ajax({
                    url: "<?= app_base_url('inventory/formularium-obat') ?>",
                    cache: false,

                    data:'&nama='+nama,
                    success: function(msg){
                        $('.available-parts').html(msg);
                    }
                });
                        
                var str='<div class=result>'+data.nama+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
        }
    );
    });
</script>
<h2 class="judul"><a href="<?= app_base_url('inventory/formularium') ?>">Administrasi Formularium</a></h2><? echo isset($pesan) ? $pesan : NULL; ?>
<form action="<?= app_base_url('inventory/control/formularium') ?>" method="POST">
    <div class="data-input">
        <fieldset>
            <legend>Form Tambah Data Formularium</legend>
            <label>No</label><span style="font-size: 12px;padding-top: 5px;"><?= $nmr ?></span>  
            <label>Tgl. Berlaku</label><input type="text" name="tanggal" class="tanggal" value="<?= $tanggal ?>" style="min-width: 15px">
        </fieldset>
    </div>        
    <fieldset>
        <select name="obat[]" multiple="multiple" id="searchable">
            <? foreach ($obat['list'] as $row) {
            
              if ($row['generik'] == 'Generik') {
                            $nama= ( $row['kekuatan'] != 0) ? " $row[id_barang] $row[nama_barang] $row[kekuatan]  $row[sediaan] $row[pabrik]" : " $row[id_barang] $row[nama_barang]";
                        }
						 if ($row['generik'] == 'Non Generik') {
                                $nama= ( $row['kekuatan'] != 0) ? " $row[id_barang] $row[nama_barang] $row[kekuatan] $row[pabrik]" : " $row[id_barang] $row[nama_barang]";
                        }
             
             
       ?>
                            <option value="<?= $row['id_barang'] ?>"><?=$nama?></option>
              
      <?      }?>
        </select>
        <fieldset class="input-process" style="border:none">
            <input type="submit" name="add" value="Simpan" class="tombol">
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/formularium') ?>'">
        </fieldset>
    </fieldset>
</form>
<div class="data-list">
    <fieldset>
            <form action="<?=  app_base_url('inventory/formularium')?>" method="GET">
                <span style="float:right;">Cari tanggal :
                <input type="text" name="tgl" class="tanggal" style="min-width: 15px" value="<?= $tanggalCari ?>">
                <input type="submit" value="Cari" />
                </span>
            </form>
                No. Formularium: <?= $id ?>
            <table class="tabel" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <th>No</th>
                    <?$_GET['sort']=1?>
                    <th><a href="<?= app_base_url('inventory/formularium/?').  generate_get_parameter($_GET) ?>" class="sorting">Obat</a></th>
                    <th>Farmakologi</th>
                </tr>
            <?
            $no = 1;
            foreach ($content as $rows) {
                $nama = "$rows[barang]";
               if ($row['generik'] == 'Generik') {
                            $nama.= ( $row['kekuatan'] != 0) ? " $row[kekuatan], $row[sediaan]" : " $row[sediaan]";
                        }
						 if ($row['generik'] == 'Non Generik') {
                            $nama.= $row['kekuatan'];
                        }
                $nama.= ( $rows['generik'] == 'Generik') ? ' ' . $rows['pabrik'] : '';

            ?>
                <tr class="<?= ($no % 2) ? "even" : "odd" ?>">
                    <td align="center"><?= $formularium['offset']+$no ?></td>
                    <td class="no-wrap"><?=$nama?></td>
                    <td class="no-wrap"><?= $rows['sub_sub_farmakologi'] . "-" . $rows['sub_farmakologi'] . "-" . $rows['farmakologi'] ?></td>
                </tr>
            <?
                $no++;
            }
            ?>
        </table>
    </fieldset>    
</div>
<?= $formularium['paging'] ?>

<script type="text/javascript">
    $('#searchable').multiselect2side({
        search: "Search: "
    });
</script>    