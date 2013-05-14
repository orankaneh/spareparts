<?php
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/zat-aktif.php';
include 'app/actions/admisi/pesan.php';
$page = isset($_GET['page'])?$_GET['page']:NULL;
$zat_aktif = zat_aktif_muat_data();
$komposisi = komposisi_obat_muat_data(null,$page,$dataPerPage = 15);


?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#obat').focus();
        $('.tanggal').datepicker({
            changeYear:true,
            changeMonth:true
        })

        $('#obat').partsSelector({enableMoveControls:false});
    })

$(function() {
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
                var str='<div class=result>'+data.nama+' '+data.ven+' <br/>'+data.generik+' '+data.kekuatan+' </div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idobat').attr('value',data.id);
            $.ajax({
                url: "<?= app_base_url('pf/komposisi-obat-zat-aktif') ?>",
                cache: false,
                data:'&id_obat='+data.id,
                success: function(msg){
                    $('#temp').html(msg);
                }
            });
        }
    );
        $('#add').click(function() {
            if ($('#idobat').val() == '') {
                alert('Nama obat belum terisi !')
                $('#obat').focus();
                return false;
            }
        })
});

</script>
<h2 class="judul"><a href="<?= app_base_url('pf/komposisi-obat') ?>">Administrasi Komposisi Obat</a></h2><? echo isset($pesan) ? $pesan : NULL; ?>
<form action="<?= app_base_url('pf/control/komposisi-obat') ?>" method="post">
    <div class="data-input">
        <fieldset>
            <legend>Form Pencarian Nama Obat</legend>
            <label>Nama Obat</label><input type="text" name="obat" id="obat" /><input type="hidden" name="idobat" id="idobat" />
        </fieldset>
    </div>
    <fieldset>
        <div id="temp">
        <select name="zat_aktif[]" multiple="multiple" id="searchable">
            <?foreach ($zat_aktif as $row) { ?>
                    <option value="<?= $row['id'] ?>"><? echo"$row[id] $row[nama]"; ?></option>
                    
        <?php }?>
        </select>
            </div>
        <fieldset class="input-process" style="border:none">
            <input type="submit" name="add" id="add" value="Simpan" class="tombol">
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('pf/komposisi-obat') ?>'">
        </fieldset>
    </fieldset>
</form>
<div class="data-list">
    <fieldset>                
            <table class="tabel" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <th>No</th>
                    <th>Obat</th>
                    <th>Komposisi</th>
                </tr>
                <?php
                foreach ($komposisi['list'] as $key => $row) {
                    $zat_aktif = detail_komposisi_obat_muat_data($row['id_obat']);
					?>
                    <tr class="<?= ($key%2)?'odd':'even'; ?>">
                        <td align="center"><?=  ++$key + $komposisi['offset']; ?></td>
                        <td><?= $row['obat'] ?></td>
                        <td>
                        
                    <?php
					
                    $zat_aktif_view = array();
                    foreach($zat_aktif as $data) {
                        $zat_aktif_view[] = "- $data[zat_aktif]";
                    }
                    ?>
                    <?php echo implode("<br/>",$zat_aktif_view) ?></td>
                    </tr>
                <?php }
			
                ?>
        </table>
    </fieldset>
    <?= $komposisi['paging'] ?>
</div>

<script type="text/javascript">
    $('#searchable').multiselect2side({
        search: "Search: "
    });
</script>