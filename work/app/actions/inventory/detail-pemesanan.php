<?
require_once "app/lib/common/master-data.php";
$sp=  sp_muat_data_by_id($_GET['nosp']);
?>
<h2 class="judul">Detail Pemesanan</h2>
<div class="data-input">
    <?
    foreach ($sp as $row);
    ?>
    <fieldset><legend>Detail Pemesanan</legend>
    <table>
        <tr><td>No. SP</td><td>:</td><td><?= $row['id']?></td></tr>
        <tr><td>Nama Suplier</td><td>:</td><td><?= $row['instansi']?></td></tr>
        <tr><td>Pembuat</td><td>:</td><td><?= $row['pegawai']?></td></tr>
    </table>
    </fieldset>
</div>
<fieldset><legend>Daftar Barang</legend>
<div class="data-list">
    
    <table class="tabel" style="width: 80%">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Satuan Terbesar</th>
            <th>Jumlah</th>
            <th>Diterima</th>
            <th>No. Faktur</th>
            <th>Penerima</th>
            <th>Jatuh Tempo</th>
        </tr>
        <?php 
        $detailPemesanan = detail_pemesanan_muat_data($_GET['nosp']);
        foreach ($detailPemesanan as $key => $content){
        $num = $key + 1;    
        ?>
        <tr class="<?= ($num%2) ? 'odd':'even' ?>">
            <td align="center"><?= $num ?></td>
            <td class="no-wrap"><?= $content['barang']?></td>
            <td align="center"><?= $content['satuan_terbesar']?></td>
            <td align="center"><?= $content['jumlah_pesan']?></td>
            <td align="center"><?= $content['jumlah_pembelian']?></td>
            <td><?= $content['no_faktur']?></td>
            <td class="no-wrap"><?= $content['penerima']?></td>
            <td><?= datefmysql($content['tanggal_jatuh_tempo'])?></td>
        </tr>
        <?php } ?>
    </table>
</div>
</fieldset>

<div class="data-list">
    <table class="tabel" style="width: 72%;">
        <tr>
            <th>No</th>
            <th>No. Faktur</th>
            <th>Penerima</th>
            <th>Jatuh Tempo</th>
        </tr>
<?php for($i = 1; $i <= 5; $i++) { ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#subhistorys<?= $i ?>').hide();
            $('#historys<?= $i ?>').click(function(){
                $('#subhistorys<?= $i ?>').toggle('fast');
            });
        });
    </script>
        <tr id="historys<?= $i ?>" class="parent-id">
            <td align="center"><?= $i ?></td>
            <td>NOFAK.00000<?= $i ?></td>
            <td>Ema Purwanti S.Farm Apt</td>
            <td align="center">12/09/2011</td>
        </tr>
        <tr id="subhistorys<?= $i ?>">
            <td colspan="4">
            <table class="tabel" style="width: 100%">
                    <tr>
                        <th>No</th>
                        <th>No. Faktur</th>
                        <th>No. Batch</th>
                        <th>Tanggal Kadaluwarsa</th>
                        <th>Jumlah SP</th>
                        <th>Jumlah Terima</th>
                        <th>Satuan</th>
                    </tr>
                    <?php
                    for($j = 1; $j <= 4; $j++) { ?>

                    <tr class="<?= ($j%2) ? 'odd':'even' ?>">
                        <td align="center"><?= $j ?></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    

    
            
<?php } ?>
         </table>
</div>
<div class="data-list">
    Riwayat Penerimaan : <br />
    <div class="button">Expand All</div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.button').click(function(){
                for (i = 1; i <= 5; i++) {
                    $('#subhistory'+i).slideToggle('fast');
                }
            });
        });
        </script>
    <div>
        <?php for($j = 1; $j <= 5; $j++) {?>
        <script type="text/javascript">
        $(document).ready(function(){
            $('#subhistory<?= $j ?>').hide();
            $('#history<?= $j ?>').click(function(){
                $('#subhistory<?= $j ?>').slideToggle('fast');
            });
        });
        </script>
        <a class="group-history" id="history<?= $j ?>">2<?= $j ?>/12/2011 (Slamet<?= $j ?> S.Pd)</a>
            
            <div id="subhistory<?= $j ?>">
                <table class="tabel" style="width: 72%">
                        <tr style="background: #F4F4F4;">
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>No. Batch</th>
                            <th>Tanggal Kadaluwarsa</th>
                            <th>Jumlah SP</th>
                            <th>Jumlah Terima</th>
                            <th>Satuan</th>
                        </tr>
                        <?php
                        for($i = 1; $i <= 4; $i++) { ?>
                        
                        <tr class="<?= ($i%2) ? 'odd':'even' ?>">
                            <td align="center"><?= $i ?></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                        </tr>
                        <?php } ?>
                        </table><br/>
            </div>
            
        
        <?php } ?>
    </div>
</div>