<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
if ($tab == "prov")
{
    $_SESSION['tab_wilayah'] = $tab;
    $code      = isset ($_GET['code'])?$_GET['code']:NULL;
    $order     = isset ($_GET['order'])?$_GET['order']:NULL;
    $key       = isset ($_GET['key'])?$_GET['key']:NULL;
    $batas     = 15;
    $provinsi  = propinsi_muat_data($code,$order,$key,$page_prov,$batas);
    echo isset($pesan) ? $pesan : NULL; 
    if ($page_prov > 1)
        $no_prov = $batas * ($page_prov - 1) + 1;
    else
        $no_prov = 1;
} else
{
    $code     = null;
    $order    = null;
    $key      = null;
    $batas    = 15;
    $provinsi = propinsi_muat_data($code,$order,$key,$page_prov,$batas);
    $no_prov  = 1;
}
?>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#provinsi_prov').focus();
        
        $("#formProv").submit(function(event)
        {
            event.preventDefault();
            $("#formProv input[type=submit]").click();
        });
        $("#formProv input[type=submit]").click(function(event)
        {
            event.preventDefault();
            if($('#provinsi_prov').attr('value')=='')
            {
                alert('Nama provinsi tidak boleh kosong');
                $('#provinsi_prov').focus();
                return false;
            } else
            {
                var id = ($(this).attr("name")=="edit"?'&id='+$('input[name=idProvinsi_prov]').attr('value'):'');
                $.ajax(
                {
                    url: "<?= app_base_url('inventory/search?opsi=cek_Propinsi')?>",
                    data:'&nama='+$('#provinsi_prov').attr('value')+id,
                    cache: false,
                    dataType: 'json',
                    success: function(msg)
                    {
                        if(!msg.status)
                        {
                            alert('Nama yang sama sudah pernah diinputkan');
                            return false;
                        } else
                        {
                            $("#formProv input[type=submit]").unbind("click").click();
                        }
                    }
                });
            }
        });
    });
</script>
<?php
if(isset ($_GET['do']) && isset($_GET['tab']))
{
    if($_GET['do'] == "add" && $_GET['tab'] == "prov")
        require_once 'app/actions/admisi/add-provinsi.php';
    else if($_GET['do'] == "edit" && $_GET['tab'] == "prov")
        require_once 'app/actions/admisi/edit-provinsi.php';
}
?>
<div class="data-list w600px">
	<div class="floleft">
        <a href="<?php echo app_base_url('/admisi/data-wilayah2/?do=add&tab=prov'); ?>" class="add"><div class="icon button-add"></div>Tambah</a>
    </div>
	<div class="floright">
    <form action="<?= app_base_url('admisi/data-wilayah2/')?>" method="GET" class="search-form">
        <input type="text" name="key" class="search-input" value="<?= $key?>"/><input type="hidden" name="tab" value="prov" /><input type="submit" class="search-button" value="" />     
    </form>
	</div>
    <table cellpadding="0" cellspacing="0" class="tabel full">
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Kode</th>
            <th>Aksi</th>
        </tr>
        <?php
          foreach ($provinsi['list'] as $prov){
        ?>
        <tr class="<?= ($no_prov%2)?"even":"odd"?>">
            <td align="center" style="width: 5%"><?= $no_prov++?></td>
              <td><?= $prov['nama']?></td>
            <td align="center" style="width: 10%"><?= $prov['kode']?></td>
              <td class="aksi" style="width: 10%">
                  <a href="<?= app_base_url('admisi/data-wilayah2/?do=edit&id='.$prov['id'].'&tab=prov') ?>" class="edit"><small>edit</small></a>
                  <a href="<?= app_base_url('admisi/control/wilayah/delete-provinsi?id='.$prov['id'].'') ?>" class="delete"><small>delete</small></a></td>
              </td>
          </tr>
        <?php
          }
        ?>
    </table>
</div>
<a class=excel class=tombol href="<?=app_base_url('admisi/informasi/excel/propinsi-excel')?>">Cetak</a><p></p>
<?php
if (!$code)
{
    echo $provinsi['paging'];
    echo "<p>Total Nama Provinsi: ".$provinsi['propinsi']."</p>";
}
?>
