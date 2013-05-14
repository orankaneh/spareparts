<?php
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
set_time_zone();
?>
<script type="text/javascript">
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

    });
</script>
<h2 class="judul"><a href="<?= app_base_url('inventory/info-formularium') ?>">Informasi Formularium</a></h2><? echo isset($pesan) ? $pesan : NULL; ?>
<div class="data-list">
    <fieldset>
        <?
            $page = isset($_GET['page']) ? $_GET['page'] : NULL;
            $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $formularium = formularium_muat_data($id, null, $sort, $page, 15);
            $id = $formularium['id'];
            $content = $formularium['list'];
            if (count($id) == 0) {
                $id = "";
            }
        ?>
            <form id="cariForm" method="GET" action="<?= app_base_url('inventory/info-formularium') ?>">
                No. Formularium : <input type="text" name="id" id="formularium" value="<?= $id ?>">
            </form>
            <table class="tabel" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <th>ID</th>
                    <?$_GET['sort']=1?>
                    <th><a href="<?= app_base_url('inventory/info-formularium/?').  generate_get_parameter($_GET) ?>" class="sorting">Obat</a></th>
                    <th>Farmakologi</th>
                </tr>
            <?
            $no = 1;
            foreach ($content as $rows) {
                $konversi = isset($rows['nilai_konversi']) ? $rows['nilai_konversi'] : "";
                $satuan = isset($rows['satuan']) ? $rows['satuan'] : "";
            ?>
                <tr class="<?= ($no % 2) ? "even" : "odd" ?>">
                    <td align="center"><?= $rows['id_detail'] ?></td>
                    <td class="no-wrap"><?= "$rows[barang] $rows[kekuatan] $rows[sediaan]" ?></td>
                    <td class="no-wrap"><?= $rows['sub_sub_farmakologi'] . "-" . $rows['sub_farmakologi'] . "-" . $rows['farmakologi'] ?></td>
                </tr>
            <?
                $no++;
            }
            ?>
        </table>
        <span class="cetak" >Cetak</span><a href="<?= app_base_url('inventory/report/formularium-excel/?id='.$id)?>" class="excel">Cetak Excel</a>
    </fieldset>
</div>
<?= $formularium['paging'] ?>

<script type="text/javascript">
    $('#searchable').multiselect2side({
        search: "Search: "
    });
    $(document).ready(function(){
        $(".cetak").click(function(){
            var win = window.open('report/formularium?id=<?=$id?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>