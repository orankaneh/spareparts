<form action="<?= app_base_url('/pf/inventory/pembuatan_nota') ?>" method="post">
    <h1 class="judul">PEMBUATAN NOTA</h1>
    <div class="data-input">
            <fieldset>
                <label for="buat_nota-no_faktur">No Faktur</label>
                <input type="text" name="no_faktur" id="buat_nota-no_faktur" disabled>

                <label for="buat_nota-tgl_cek">Tanggal Pengecekan</label>
                <input type="text" id="buat_nota-tgl_cek" name="tgl_cek" value="" disabled>

                <label for="buat_nota-harus_bayar">Total Harus Dibayar</label>
                <input type="text" id="buat_nota-harus_bayar" name="harus_bayar" value="" size="10" disabled>

                <label for="buat_nota-no_nota">No. Nota</label>
                <input type="text" id="buat_nota-no_nota" name="no_nota" value="" size="10">
                <fieldset class="input-process">
                   <input type="Submit" name="simpan_btn" value="Simpan" class="tombol">
                    <input type="button" name="simpan_btn" value="Batal" class="tombol">
                </fieldset>
            </fieldset>
    </div>
</form>