<?
$noFakturs=array(
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title')
);
?>
<form action="<?= app_base_url('/pf/inventory/pembayaran_nota_pf') ?>" method="post">
    <h1 class="judul">PEMBAYARAN NOTA PF</h1>
    <div class="data-input">
            <fieldset>
                <label for="pembayaran_nota-no_faktur">No Faktur</label>
                <select name="no_faktur" id="pembayaran_nota-no_faktur" >
                <?
                    foreach ($noFakturs as $noFaktur){
                        echo"<option value='$noFaktur[id]'>$noFaktur[title]</option>";
                    }
                ?>
                </select>

                <label for="pembayaran_nota-tgl_cek">Tanggal Pengecekan</label>
                <input type="text" id="pembayaran_nota-tgl_cek" name="tgl_cek" value="" disabled>

                <label for="pembayaran_nota-tot_bayar">Total Harus Bayar</label>
                <input type="text" id="pembayaran_nota-tot_bayar" name="tot_bayar" value="" disabled>

                <label for="pembayaran_nota-cara_bayar">Cara Bayar</label>
                <input type="text" id="pembayaran_nota-cara_bayar" name="cara_bayar" value="" size="10" disabled>

                <label for="pembayaran_nota-jml_bayar">Jumlah Dibayar</label>
                <input type="text" id="pembayaran_nota-jml_bayar" name="jml_bayar" value="" size="10">

                <label for="pembayaran_nota-tgl_bayar">Tanggal Dibayar</label>
                <input type="text" id="pembayaran_nota-tgl_bayar" name="tgl_bayar" value="" size="10" disabled>

                <fieldset class="input-process">
                    <input type="Submit" name="simpan_btn" value="Simpan" class="tombol" />
                    <input type="button" name="simpan_btn" value="Batal" class="tombol" />
                </fieldset>
            </fieldset>
    </div>
</form>