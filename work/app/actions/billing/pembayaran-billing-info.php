<?php
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
set_time_zone();
$billing = billing_muat_data($_GET['id']);
?>
<h2 class="judul"><a href="<?= app_base_url('billing/pembayaran-billing') ?>">Pembayaran Billing Pasien</a></h2><?php echo isset($pesan) ? $pesan : NULL; ?>
<div class="data-input">
    <fieldset>
        <legend>Form Pembayaran Billing</legend>
        <label for="tanggal">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= date("d/m/Y") ?></span>
        <label for="nama">Nama Pasien</label><span style="font-size: 12px;padding-top: 5px;"><?= $billing['pasien'] ?></span>
        <label for="norm">No. RM</label><span style="font-size: 12px;padding-top: 5px;"><?= $billing['norm'] ?></span>
        <label for="alamat">Alamat</label><span style="font-size: 12px;padding-top: 5px;"><?= $billing['alamat_jalan'] ?></span>
        <label for="kelurahan">Kelurahan</label><span style="font-size: 12px;padding-top: 5px;"><?= $billing['kelurahan'] ?></span>
        <label for="noTagihan">No. Tagihan</label><span style="font-size: 12px;padding-top: 5px;"><?= $billing['id'] . "/ Pembayaran ke-" . $billing['pembayaran'] ?></span>
    </fieldset>
</div>
<div id="tabel-billing">
    <?php
    $detail = detail_billing_muat_data($_GET['id']);
    $sql = "select sum(jumlah_bayar) as jumlah_bayar from detail_pembayaran_billing where id_billing='$_GET[id]'";
    $data = _select_unique_result($sql);
    ?>
    <div class="data-list">
        <table class="tabel" cellpadding="0" cellspacing="0" style="width: 100%">
            <tr>
                <th>No</th>
                <th width="50%">Nama Layanan</th>
                <th>Kelas</th>
                <th>Frekuensi</th>
                <th>Harga</th>
                <th>Subtotal (Rp.)</th>
            </tr>
            <?
            $totalAll = 0;
            $no = 0;
            foreach ($detail as $row) {
                ?>
                <tr class="<?= ($no % 2) ? 'even' : 'odd' ?>">
                    <td align="center"><?= ++$no ?></td>
                    <td><?php
            if ($row['bobot'] == 'Tanpa Bobot')
                $bobot = "";
            else
                $bobot = $row['bobot'];

            if ($row['profesi'] == 'Tanpa Profesi')
                $profesi = "";
            else
                $profesi = $row['profesi'];

            $spesialisasi = "";
            if ($row['spesialisasi'] == 'Tanpa Spesialisasi')
                $spesialiasi = "";
            else
                $spesialisasi = $row['spesialisasi'];

            if ($row['instalasi'] == 'Rekam Medik' || $row['instalasi'] == 'Gawat Darurat' || $row['instalasi'] == 'Poliklinik' || $row['instalasi'] == 'Semua')
                $instalasi = "";
            else
                $instalasi = $row['instalasi'];

            $layanans = "$row[layanan] $profesi $spesialisasi $bobot $instalasi";
            echo $layanans;
                ?></td>
                    <td><?= $row['kelas'] ?></td>
                    <td width="10%"><?= $row['frekuensi'] ?></td>
                    <td align="right"><?= rupiah($row['total']) ?></td>
                    <td align="right">
                        <?
                        $subtotal = $row['frekuensi'] * $row['total'];
                        echo rupiah($subtotal);
                        ?>
                    </td>
                </tr>
                <?
                $totalAll += $subtotal;
            }
            if ($totalAll == $data['jumlah_bayar']) {
                $bayar = '0';
            } else if ($totalAll > $data['jumlah_bayar']) {
                $bayar = $totalAll - $data['jumlah_bayar'];
            } else if ($data['jumlah_bayar'] > $totalAll) {
                $bayar = $data['jumlah_bayar'] - $totalAll;
            }
            $jum = base64_decode(base64_decode($_GET['jumlah']));
            if($jum < $_GET['bayar']){
                $kembali = $_GET['bayar'] - $jum;
                $sisaTagihan = '-';
            }else{
                $kembali = '-';
                $sisaTagihan = rupiah($jum - $_GET['bayar']);
            }
            ?>
        </table>
    </div>
    <span style="position: relative;float: right;padding-top: 10px;width: 100%">
        <table style="float:right">    
            <tr>    
                <td>Tagihan</td><td>:</td><td align="right"><b><?= rupiah($totalAll) ?></b></td>
            </tr>    
            <tr>    
                <td>Total Tagihan</td><td>:</td><td align="right"><b><?= rupiah($jum) ?></b></td>
            </tr>    
            <tr>    
                <td>Bayar</td><td>:</td><td style="font-weight:bold" align="right"><?= rupiah($_GET['bayar']) ?></td>
            </tr>    
            <tr>    
                <td>Kembali</td><td>:</td><td id="kembali1" style="font-weight:bold" align="right"><?= $kembali ?></td>

            </tr>    
            <tr>    
                <td>Sisa Tagihan</td><td>:</td><td id="sisaTagihan1" align="right" style="font-weight:bold"> 
                <?= $sisaTagihan ?></td>
            </tr>    
        </table>    
    </span>    
</div> 

<div class="field-group" id="btn-group" style="clear:left;margin-top: 10px">
    <input type="submit" value="Simpan" name="save" class="tombol" disabled=""/> 
    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('billing/pembayaran-billing') ?>'" disabled=""/>
    <input type="button" value="Cetak" class="tombol cetaks">
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".cetaks").click(function(){
            var bayar=isNaN($("#bayar1").val())?'':$("#bayar1").val();
            var kembali=isNaN($("#kembali2").val())?'':$("#kembali2").val();
            var win = window.open('report/pembayaran-billing?id=<?= $_GET['id'] ?>&bayar=<?= $_GET['bayar'] ?>&kembali=<?= $kembali ?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>