<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
if ($tab == "kab")
{
    $_SESSION['tab_wilayah'] = $tab;
    $code      = isset ($_GET['code'])?$_GET['code']:NULL;
    $order     = isset ($_GET['order'])?$_GET['order']:NULL;
    $key       = isset ($_GET['key'])?$_GET['key']:NULL;
    $batas     = 15;
    $kabupaten = kabupaten_muat_data($code,$order,$key,$page_kab,$batas);
    echo isset($pesan) ? $pesan : NULL; 
    if ($page_kab > 1)
        $no_kab = $batas * ($page_kab - 1) + 1;
    else
        $no_kab = 1;
} else
{
    $code      = null;
    $order     = null;
    $key       = null;
    $batas     = 15;
    $kabupaten = kabupaten_muat_data($code,$order,$key,$page_kab,$batas);
    $no_kab    = 1;
}
?>
<script type="text/javascript">
$(document).ready(function()
{
    $(function()
    {
        $('#provinsi_kab').focus();
        $('#provinsi_kab').autocomplete("<?= app_base_url('/admisi/search?opsi=provinsi') ?>",
        {
            parse: function(data)
            {
                var parsed = [];
                for (var i=0; i < data.length; i++)
                {
                    parsed[i] =
                    {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                }
                $('#idProvinsi_kab').attr('value','');
                return parsed;
            },
            formatItem: function(data,i,max)
            {
                var str = '<div class=result><b style="text-transform:capitalize">'+data.nama+'</b></div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated)
            {
                $('#provinsi_kab').attr('value',data.nama);
                $('#idProvinsi_kab').attr('value',data.id);
            }
        );
    });
    $("#formKab").submit(function(event)
    {
        event.preventDefault();
        $("#formKab input[type=submit]").click();
    });
    $("#formKab input[type=submit]").click(function(event)
    {
        event.preventDefault();
        if($('#provinsi_kab').attr('value') == '')
        {
            alert('Nama provinsi tidak boleh kosong');
            $('#provinsi_kab').focus();
            return false;
        }
        if($('#idProvinsi_kab').attr('value') == '')
        {
            alert('Nama provinsi harus dari list');
            $('#provinsi_kab').focus();
            return false;
        }
        if($('#kabupaten_kab').attr('value') == '')
        {
            alert('Nama kabupaten tidak boleh kosong');
            $('#kabupaten_kab').focus();
            return false;
        }
        kab = $('#idKabupaten_kab').attr('value') != '' ? '&kab='+$('#idKabupaten_kab').attr('value') : '',
        $.ajax(
        {
            url: "<?= app_base_url('inventory/search?opsi=cek_kabupaten')?>",
            data:'&nama='+$('#kabupaten_kab').attr('value')+'&provinsi='+$('#idProvinsi_kab').attr('value')+kab,
            cache: false,
            dataType: 'json',
            success: function(msg)
            {
                if(!msg.status)
                {
                    caution('Nama kabupaten yang sama sudah pernah diinputkan');
                    return false;
                } else
                {
                    $("#formKab input[type=submit]").unbind("click").click();
                }
            }
        });
    })
});
</script>
<div id="box-notif"></div><div class="clear"></div>
<?php
if(isset ($_GET['do']) && isset($_GET['tab']))
{
    if(($_GET['do'] == "add") && ($_GET['tab'] == "kab"))
        require_once 'app/actions/admisi/add-kabupaten.php';
    else if($_GET['do'] == "edit" && ($_GET['tab'] == "kab"))
        require_once 'app/actions/admisi/edit-kabupaten.php';
}
?>
<div class="data-list w600px">
	<div class="floleft">
        <?php echo addButton('/admisi/data-wilayah2/?do=add&tab=kab','Tambah'); ?>
    </div>
	<div class="floright">
    <form action="<?= app_base_url('admisi/data-wilayah2/')?>" method="GET" class="search-form">
        <input type="text" name="key" class="search-input" value="<?= $key?>"/><input type="hidden" name="tab" value="kab" /><input type="submit" class="search-button" value=""/>     
    </form>
	</div>
 <table cellpadding="0" cellspacing="0" class="tabel">
        <tr>
            <th>NO</th>
            <th>Nama Kabupaten</th>
            <th>Nama Provinsi</th>
            <th>Aksi</th>
        </tr>
        <?php
        foreach ($kabupaten['list'] as $kab)
        {
        ?>
        <tr class="<?php echo ($no_kab%2) ? "even" : "odd" ?>">
            <td width="10" align="center"><?php echo $no_kab++;?></td>
            <td width="350"><?php echo $kab['namaKabupaten']?></td>
            <td width="350"><?php echo $kab['namaProvinsi'] ?></td>
            <td width="40" class="aksi">
                <a href="<?php echo app_base_url('admisi/data-wilayah2/?do=edit&id='.$kab['idKabupaten'].'&prov='.$kab['id_provinsi'].'&tab=kab'); ?>" class="edit"><small>edit</small></a>
                <a href="<?php echo app_base_url('admisi/control/wilayah/delete-kabupaten?id='.$kab['idKabupaten'].''); ?>" class="delete"><small>delete</small></a>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
<a class=excel class=tombol href="<?=app_base_url('admisi/informasi/excel/kabupaten-excel')?>">Cetak</a><p></p>
<?php
if (!$code)
{
    echo $kabupaten['paging'];
    echo "<p>Total Nama Kabupaten: ".$kabupaten['kabupaten']."</p>";
}

?>
