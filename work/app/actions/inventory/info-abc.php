<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

set_time_zone();
$kategori_barang = sub_kategori_barang_muat_data();
$id_sub_kategori = (isset($_GET['sub_kategori'])) ? $_GET['sub_kategori'] : null;

?>
<script type="text/javascript">
    $(function() {
        $('#display').click(function () {
            var awal = $('#awal').val();
            var akhir= $('#akhir').val();
            var sub_kategori = $('#kategori').val();
            $.ajax({
                url: "<?= app_base_url('inventory/info-abc-table') ?>",
                cache: false,
                data:'&startDate='+awal+'&endDate='+akhir+'&sub_kategori='+sub_kategori,
                success: function(msg){
                    $('#show').html(msg);
                }
            })
        })
    })
            
</script>
<h1 class="judul">Informasi Always Better Control</h1>

<div class="data-input pendaftaran">
    <fieldset id="master"><legend>Form pencarian </legend>

        <form action="<?= app_base_url('inventory/info-abc') ?>" method="get" name="form">

            <fieldset class="field-group">    
                <legend>Awal - akhir periode</legend>
                <input type="text" id="awal" name="startDate" value="<?= date("d/m/Y") ?>" class="tanggal"/>

                <label for="akhir" class="inline-title"> s . d </label>
                <input type="text" id="akhir" name="endDate" value="<?= date("d/m/Y") ?>" class="tanggal"/>
            </fieldset>
           
            <label for="filter">Sub Kategori Barang</label>

            <select id="kategori" name="sub_kategori" >
                <option value="">Pilih kategori</option>
<?php foreach ($kategori_barang as $rows): ?>
                    <option value="<?= $rows['id'] ?>" <?= ($id_sub_kategori == $rows['id']) ? 'selected' : '' ?>><?= $rows['nama'] ?></option>
                <?php endforeach; ?>
            </select>
            <div id="field-dinamis">

            </div>
            <fieldset class="input-process">
                <input type="button" value="Cari" id="display" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick=javascript:location.href="<?= app_base_url('/inventory/info-abc') ?>" />
            </fieldset>
        </form>
    </fieldset>
</div>
<div id="show"></div>
