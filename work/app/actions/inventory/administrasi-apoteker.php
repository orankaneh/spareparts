<?php
  require 'app/lib/common/master-data.php';
  require 'app/actions/admisi/pesan.php';
  $tanggal = isset($_GET['tanggal'])?$_GET['tanggal']:NULL;
  $apoteker = administrasi_apoteker_muat_data(NULL,$tanggal);
?>
<script type="text/javascript">
  $(function(){
      $('#nilai').focus();
  })
</script>
<div class="judul"><a href="<?= app_base_url('inventory/administrasi-apoteker')?>">Administrasi Jasa Pelayanan</a>
</div>
<?= isset($pesan)?$pesan:NULL?>
<?php
  if(isset ($_GET['do']) and $_GET['do']=="edit"){
      require 'app/actions/inventory/edit-administrasi-apoteker.php';
  }
?>

<div class="data-list">
    <table class="tabel" style="width: 35%">
        <tr>
          <th>Nilai (Rp.)</th>
          <th>Aksi</th>
        </tr>  
        <?
        foreach ($apoteker as $key => $value) {
        ?>
          <tr class="<?= ($key%2) ? 'even':'odd' ?>">
            <td><?= $value['nilai']?></td>
            <td class="aksi">
                <a href="<?= app_base_url('inventory/administrasi-apoteker')?>?do=edit&id=<?= $value['id']?>" class="edit"><small>edit</small></a>
            </td>
          </tr>    
        <?
        }
        ?>
    </table>    
</div>    
<script type="text/javascript">
    $(document).ready(function(){
        $('#tombol').click(function(){
            $('.hidden').slideToggle();
        })
        $('.hidden').toggle(false);
    })
</script>    
