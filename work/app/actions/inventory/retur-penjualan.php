<?php
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-data.php";
  include_once 'app/actions/admisi/pesan.php';
  set_time_zone();
  $date=Date('d').'/'.Date('m').'/'.(2000+Date('y'));
?>
<h2 class="judul">Retur Penjualan</h2><?= isset ($pesan)?$pesan:NULL?>
<div class="data-list" style="clear: left;">
    <a href="<?= app_base_url('inventory/surat-retur?do=add') ?>" class="add"><div class="icon button-add"></div>tambah</a>
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>No. Surat</th>
            <th>Tanggal</th>
            <th>Suplier</th>
            <th>No. Faktur</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        