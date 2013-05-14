<h2 class="judul">Informasi Penerimaan</h2>
<?php
    require_once 'app/lib/common/master-data.php';
    require_once 'app/lib/common/functions.php';
    set_time_zone();
    $startDate=(isset($_GET['awal']))? $_GET['awal']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
    $endDate=(isset($_GET['akhir']))? $_GET['akhir']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
    $suplier = isset($_GET['idsuplier'])?$_GET['idsuplier']:NULL;
    $status = NULL;
?>
<script type="text/javascript">
        $(function() {
        $('#suplier').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].id_pasien // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#suplier').attr('value',data.nama);
                $('#idsuplier').attr('value',data.id);
            }
        );
        });
</script>
<div class="data-input">
    <fieldset><legend>Form Laporan Penerimaan</legend>
        <form action="" method="get">
        <fieldset class="field-group">
            <legend>Tgl. Penerimaan</legend>
            <input type="text" name="awal" class="tanggal" id="awal" value="<?= date("d/m/Y") ?>" /><label class="inline-title">s . d &nbsp;</label><input type="text" name="akhir" class="tanggal" id="akhir" value="<?= date("d/m/Y") ?>" />

        </fieldset>
        <label for="suplier">Nama Suplier</label><input type="text" name="suplier" id="suplier" />
        <input type="hidden" name="idsuplier" id="idsuplier" />
        <fieldset class="field-group">
            <legend>Status Penerimaan</legend>&nbsp;
            <label for="diterima" class="field-option"><input type="radio" name="status" id="diterima" value="L"> Sudah Diterima</label>
            <label for="belum" class="field-option"><input type="radio" name="status" id="belum" value="P"> Belum Diterima</label>
        </fieldset>
        <fieldset class="input-process">
            <input type="submit" value="Tampil" class="tombol" /> <input type="button" value="Cetak" class="tombol" />
        </fieldset>
        </form>
    </fieldset>
</div>
<div class="data-list">

<table width="55%" class="tabel">
    <tr>
        <th>No</th>
        <th>Tanggal SP</th>
        <th>No SP</th>
        <th>Nama Barang</th>
        <th>Jumlah Pesan</th>
        <th>Jumlah Faktur</th>
        <th>Tanggal Terima</th>
        <th>Jumlah Terima</th>
        <th>Lead Time</th>
        <th>Aksi</th>
    </tr>
    <?php
      $penerimaan = penerimaan_muat_data($startDate,$endDate,$suplier,$status);
      foreach($penerimaan as $key => $row): 
    ?>
    <tr class="<?= ($key%2) ? 'even':'odd' ?>">
        <td align="center"><?= ++$key ?></td>
        <td align="center"><?= datefmysql($row['tanggal_pemesanan']) ?></td>
        <td align="center"><?= $row['id_pemesanan'] ?></td>
        <td align="center"><?= $row['nama_barang'] ?></td>
        <td align="center"><?= $row['jumlah_pemesanan'] ?></td>
        <td align="center">xxx</td>
        <td align="center"><?= datefmysql($row['tanggal_penerimaan']) ?></td>
        <td align="center"><?= $row['jumlah_penerimaan'] ?></td>
        <td align="center"><?= $row['lead_time'] ?> Hari</td>
        <td class="aksi"><a href="" class="edit"><small>edit</small></a> <a href="" class="delete"><small>delete</small></a></td>
    </tr>
    <?php endforeach; ?>
</table>

    </div>
