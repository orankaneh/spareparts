<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
if ($tab == "kec")
{
    $_SESSION['tab_wilayah'] = $tab;
    $code      = isset ($_GET['code'])?$_GET['code']:NULL;
    $order     = isset ($_GET['order'])?$_GET['order']:NULL;
    $key       = isset ($_GET['key'])?$_GET['key']:NULL;
    $batas     = 15;
    $kecamatan = kecamatan_muat_data($code,$order,$key,$page_kec,$batas);
    echo isset($pesan) ? $pesan : NULL; 
	if ($page_kec > 1)
        $no_kec = $batas * ($page_kec - 1) + 1;
    else
        $no_kec = 1;
} else
{
    $code      = null;
    $order     = null;
    $key       = null;
    $batas     = 15;
    $kecamatan = kecamatan_muat_data($code,$order,$key,$page_kec,$batas);
    $no_kec    = 1;
}
?>
<script type="text/javascript">
$(document).ready(function()
{
    $(function()
    {
        $('#kabupaten_kec').focus();
        $('#kabupaten_kec').autocomplete("<?= app_base_url('/admisi/search?opsi=kabupaten') ?>",
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
                $('#idKabupaten_kec').attr('value','');
                return parsed;
            },
            formatItem: function(data,i,max)
            {
                var str = '<div class=result><b style="text-transform:capitalize">'+data.nama+'</b> - '+data.provinsi+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated)
            {
                $('#kabupaten_kec').attr('value',data.nama);
                $('#idKabupaten_kec').attr('value',data.id);
            }
        );
    });
    $("#formKec").submit(function(event)
    {
        event.preventDefault();
        $("#formKec input[type=submit]").click();
    });
    $("#formKec input[type=submit]").click(function(event)
    {
        event.preventDefault();
        if($('#kabupaten_kec').attr('value') == '')
        {
            alert('Nama kabupaten tidak boleh kosong');
            $('#kabupaten_kec').focus();
            return false;
        }
        if($('#idKabupaten_kec').attr('value') == '')
        {
            alert('Nama kabupaten harus dari list');
            $('#kabupaten_kec').focus();
            return false;
        }
        if($('#kecamatan_kec').attr('value') == '')
        {
            alert('Nama kecamatan tidak boleh kosong');
            $('#kecamatan_kec').focus();
            return false;
        }
        kec = $('#idKecamatan_kec').attr('value') != '' ? '&kec='+$('#idKecamatan_kec').attr('value') : '',
        $.ajax(
        {
            url: "<?= app_base_url('inventory/search?opsi=cek_kecamatan')?>",
            data:'&nama='+$('#kecamatan_kec').attr('value')+'&kabupaten='+$('#idKabupaten_kec').attr('value')+kec,
            cache: false,
            dataType: 'json',
            success: function(msg)
            {
                if(!msg.status)
                {
                    alert('Nama kecamatan yang sama sudah pernah diinputkan');
                    return false;
                } else
                {
                    $("#formKec input[type=submit]").unbind("click").click();
                }
            }
        });
    })
});
</script>
<?php
if(isset ($_GET['do']) && isset($_GET['tab']))
{
    if(($_GET['do'] == "add") && ($_GET['tab'] == "kec"))
        require_once 'app/actions/admisi/add-kecamatan.php';
    else if($_GET['do'] == "edit" && ($_GET['tab'] == "kec"))
        require_once 'app/actions/admisi/edit-kecamatan.php';
}
?>
<div class="data-list">
	<div class="floleft"><?php echo addButton('/admisi/data-wilayah2/?do=add&tab=kec','Tambah'); ?></div>
	<div class="floleft" style='width: 640px; margin-top: -5px'>
    <form action="<?= app_base_url('admisi/data-wilayah2/')?>" method="GET" class="search-form">
          <input type="text" name="key" value="<?= $key?>" class="search-input" /><input type="hidden" name="tab" value="kec" /><input type="submit" class="search-button" value="" />
    </form>
	</div>
    <table cellpadding="0" cellspacing="0" class="tabel">
        <tr>
            <th>NO</th>
            <th>Nama Kecamatan</th>
			<th>Nama Kabupaten</th>
            <th>Aksi</th>
        </tr>
        <?php
        foreach ($kecamatan['list'] as $kec)
        {
        ?>
        <tr class="<?php echo ($no_kec%2) ? "even" : "odd" ?>">
            <td width=12 align="center"><?php echo $no_kec++;?></td>
            <td width=300><?php echo $kec['namaKecamatan']?></td>
            <td width=350><?php echo $kec['namaKabupaten'] ?></td>
            <td width=40 class="aksi">
                <a href="<?php echo app_base_url('admisi/data-wilayah2/?do=edit&id='.$kec['idKecamatan'].'&kab='.$kec['id_kabupaten'].'&tab=kec'); ?>" class="edit"><small>edit</small></a>
                <a href="<?php echo app_base_url('admisi/control/wilayah/delete-kecamatan?id='.$kec['idKecamatan'].''); ?>" class="delete"><small>delete</small></a>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
<a class=excel class=tombol href="<?=app_base_url('admisi/informasi/excel/kecamatan-excel')?>">Cetak</a><p></p>
<?php
if (!$code)
{
    echo $kecamatan['paging'];
    echo "<p>Total Kecamatan: ".$kecamatan['kecamatan']."</p>";
}
?>
