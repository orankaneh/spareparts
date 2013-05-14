<?
$rakSimpans=array(
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title'),
    array('id'=>'id','title'=>'title')
);
?>
<form action="<?= app_base_url('/pf/inventory/terima_simpan_pf') ?>" method="post">
    <h1 class="judul">PENERIMAAN/PENYIMPANAN PF</h1>
    <div class="data-input">
            <fieldset>
                <label for="terima_pf-no_faktur">Nama PF</label>
                <input type="text" name="nama" id="terima_pf-nama" disabled>

                <label for="terima_pf-no_batch">No. Batch</label>
                <input type="text" id="terima_pf-no_batch" name="no_batch" value="" disabled>

                <label for="terima_pf-tgl_kadaluarsa">Tanggal Kadaluarsa</label>
                <input type="text" id="terima_pf-tgl_kadaluarsa" name="tgl_kadaluarsa" value="" size="10" disabled>

                <label for="terima_pf-harga">Harga</label>
                <input type="text" id="terima_pf-harga" name="harga" value="" size="10" disabled>

                <label for="terima_pf-jumlah">Jumlah</label>
                <input type="text" id="terima_pf-jumlah" name="jumlah" value="" size="10">

                <label for="terima_pf-harga">Total Harga</label>
                <input type="text" id="terima_pf-total_harga" name="total_harga" value="" size="10" disabled>

                <label for="terima_pf-rak_simpanan">Rak</label>
                <select name="rak_simpan" id="terima_pf-rak_simpan">
                <?
                    foreach ($rakSimpans as $rakSimpan){
                        echo"<option value='$rakSimpan[id]'>$rakSimpan[title]</option>";
                    }

                ?>
                </select>

                <fieldset class="input-process">
                    <input type="submit" name="cetak_btn" value="Simpan" class="tombol" />
                    <input type="reset" name="cetak_btn" value="Batal" class="tombol" />
                </fieldset>
            </fieldset>
    </div>
</form>
