<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
if ($tab == "kel")
{
    $_SESSION['tab_wilayah'] = $tab;
    $code      = isset ($_GET['code'])?$_GET['code']:NULL;
    $order     = isset ($_GET['order'])?$_GET['order']:NULL;
    $key       = isset ($_GET['key'])?$_GET['key']:NULL;
    $batas     = 15;
    $kelurahan = kelurahan_muat_data($code,$order,$key,$page_kel,$batas);
    echo isset($pesan) ? $pesan : NULL; 
    if ($page_kel > 1)
        $no_kel = $batas * ($page_kel - 1) + 1;
    else
        $no_kel = 1;
} else
{
    $code      = null;
    $order     = null;
    $key       = null;
    $batas     = 15;
    $kelurahan = kelurahan_muat_data($code,$order,$key,$page_kel,$batas);
    $no_kel    = 1;
}

?>
<script type="text/javascript">
$(document).ready(function()
{
    $(function()
    {
        $('#kecamatan_kel').focus();
        
        $('#kecamatan_kel').autocomplete("<?= app_base_url('/admisi/search?opsi=kecamatan') ?>",
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
                $('#idKecamatan_kel').attr('value','');
                return parsed;
            },
            formatItem: function(data,i,max)
            {
                var str = '<div class=result><b style="text-transform:capitalize">'+data.nama+'</b><br />Kab: '+data.kabupaten+' - Prov: '+data.provinsi+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated)
            {
                $('#kecamatan_kel').attr('value',data.nama);
                $('#idKecamatan_kel').attr('value',data.id);
            }
        );
    });
    $("#formKel").submit(function(event)
    {
        event.preventDefault();
        $("#formKel input[type=submit]").click();
    });
    $("#formKel input[type=submit]").click(function(event)
    {
        event.preventDefault();
        if($('#kecamatan_kel').attr('value') == '')
        {
            alert('Nama kecamatan tidak boleh kosong');
            $('#kecamatan_kel').focus();
            return false;
        }
        if($('#idKecamatan_kel').attr('value') == '')
        {
            alert('Nama kecamatan harus dari list');
            $('#kecamatan_kel').focus();
            return false;
        }
        if($('#kelurahan_kel').attr('value') == '')
        {
            alert('Nama kelurahan tidak boleh kosong');
            $('#kelurahan_kel').focus();
            return false;
        }
       /* if($('#kelurahan_code').attr('value') == '')
        {
            alert('Kode kelurahan tidak boleh kosong');
            $('#kelurahan_code').focus();
            return false;
        }*/
        kel = $('#idKelurahan_kel').attr('value') != '' ? '&kel='+$('#idKelurahan_kel').attr('value') : '',
        $.ajax(
        {
            url: "<?= app_base_url('inventory/search?opsi=cek_kelurahan')?>",
            data:'&nama='+$('#kelurahan_kel').attr('value')+'&kecamatan='+$('#idKecamatan_kel').attr('value')+kel,
            cache: false,
            dataType: 'json',
            success: function(msg)
            {
                if(!msg.status)
                {
                    caution('Nama kelurahan yang sama sudah pernah diinputkan');
                    return false;
                } else
                {
                    $("#formKel input[type=submit]").unbind("click").click();
                }
            }
        });
    })
});
</script>
<div id="box-notif"></div><div class="clear"><div>
<?php
if(isset ($_GET['do']) && isset($_GET['tab']))
{
    if(($_GET['do'] == "add") && ($_GET['tab'] == "kel"))
        require_once 'app/actions/admisi/add-kelurahan.php';
    else if($_GET['do'] == "edit" && ($_GET['tab'] == "kel"))
        require_once 'app/actions/admisi/edit-kelurahan.php';
}
?>

<div class="data-list w700px">
	<div class="floleft"><?php echo addButton('/admisi/data-wilayah2/?do=add&tab=kel','Tambah'); ?></div>
	<div class="floright">
    <form action="<?= app_base_url('admisi/data-wilayah2')?>" method="GET" class="search-form">
        <input type="text" name="key" class="search-input" value="<?= $key?>"/><input type="hidden" name="tab" value="kel"/>
        <input type="submit" class="search-button" value=""/>    
    </form>
	</div>
    <table cellpadding="0" cellspacing="0" class="tabel">
        <tr>
            <th>NO</th>
            <th>Nama Kelurahan</th>
			<th>Nama Kecamatan</th>
            <th>Kode Wilayah</th>
            <th>Aksi</th>
        </tr>
        <?php
        foreach ($kelurahan['list'] as $kel)
        {
            $kode_wilayah = kode_wilayah($kel['kodeKelurahan'], $kel['id_kecamatan']);
        ?>
        <tr class="<?php echo ($no_kel%2) ? "even" : "odd" ?>">
            <td width=15 align="center"><?php echo $no_kel++;?></td>
            <td width=350><?php echo $kel['namaKelurahan']?></td>
            <td width=350><?php echo $kel['namaKecamatan'] ?></td>
            <td><?php echo $kode_wilayah; ?></td>
            <td width=45 class="aksi">
                <a href="<?php echo app_base_url('admisi/data-wilayah2/?do=edit&id='.$kel['idKelurahan'].'&kec='.$kel['id_kecamatan'].'&tab=kel'); ?>" class="edit"><small>edit</small></a>
                <a href="<?php echo app_base_url('admisi/control/wilayah/delete-kelurahan?id='.$kel['idKelurahan'].''); ?>" class="delete"><small>delete</small></a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
<a class=excel class=tombol href="<?=app_base_url('admisi/informasi/excel/kelurahan-excel')?>">Cetak</a><p></p>
<?php
echo $kelurahan['paging'];
echo "<p>Total Nama Kelurahan: ".$kelurahan['kelurahan']."</p>";
?>
