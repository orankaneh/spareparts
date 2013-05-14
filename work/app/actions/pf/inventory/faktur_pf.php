<?php
$faktur_pf=array(
    array('nama'=>'nama','satuan'=>'satuan','kemasan'=>'kemasan', 'sediaan'=>'sediaan','kekuatan'=>'kekuatan','no_batch'=>'no_batch','tgl_kadaluarsa'=>'tgl_kadaluarsa','jumlah'=>'jumlah','harga'=>'harga','bonus'=>'bonus','diskon'=>'diskon')
);
?>
<h1 class="judul">FAKTUR PF</h1>
<div class="data-input">
    <form name="faktur" action="<?= app_base_url('/pf/inventory/faktur_pf') ?>" method="post">
        <fieldset>
            <legend>Faktur</legend>
            <label for="faktur_pf-no">No Faktur</label>
            <input name="no" type="text" id="faktur_pf-no" value="">
            <label for="faktur_pf-tglTerima">Tgl Penerimaan Faktur</label>
            <input type="text" class="tanggal" id="faktur_pf-tglTerima" name="tglTerima">

            <fieldset>
                <legend>SP</legend>
                <label for="faktur_pf-bln_buat_sp">Bulan Pembuatan SP</label>
                <select name="bln_buat_sp" id="faktur_pf-bln_buat_sp">
                    <?
                        $bulan=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                        $i=0;
                        foreach ($bulan as $bln){
                            echo"<option value=$i>".$bln."</option>";
                            $i++;
                        }
                    ?>
                </select>
<?
                    date_default_timezone_set('Asia/Krasnoyarsk');
?>
                <fieldset class="field-group">
                <label for="faktur_pf-thn_buat_sp">Tahun Pembuatan SP</label>
                <table>
                    <tr><td>
                            <INPUT TYPE=BUTTON NAME="previousYear" id="faktur_pf-previous_year" VALUE=" <<  " >
                        </td><td>
                             <input type="text" name="thn_buat_sp" id="faktur_pf-thn_buat_sp" value='<?=date("Y")?>' >
                        </td><td>
                             <INPUT TYPE=BUTTON NAME="previousYear" id="faktur_pf-next_year" VALUE="  >> " ">
                    </td></tr>
                </table>
                </fieldset>
                <label for="faktur_pf-nmr_sp">Nomor SP</label>
                <select name="nmr_sp" id="faktur_pf-nmr_sp">
                    <option value="0">00000000</option>
                </select>
            </fieldset>
            <fieldset>
                <legend>PBF</legend>
                <label for="faktur_pf-nama_pbf">Nama PBF</label>
                <input type="text"  name="nama_pbf" id="faktur_pf-nama_pbf" disabled>
                <label for="faktur_pf-penjaga">Penjaga</label>
                <input type="text" name="penjaga" id="faktur_pf-penjaga">
            </fieldset>
            <fieldset class="input-process">
                <input type="button" id="faktur_pf-isi_harga_btn" value="Isi Harga" class="tombol">
            </fieldset>
            
            <label for="faktur_pf-materai">Materai</label>
            <input type="text" name="materai" id="faktur_pf-materai">

            <label for="faktur_pf-ppn">Ppn</label>
            <input type="text" name="ppn" id="faktur_pf-ppn">

            <label for="faktur_pf-biaya_krm">Biaya Kirim</label>
            <input type="text" name="biaya_krm" id="faktur_pf-biaya_krm">

            <label for="faktur_pf-total">Total Nilai yang Harus Dibayar</label>
            <input name="total" type="text" id="faktur_pf-total" disabled>

            <label for="faktur_pf-tgl_tempo">Tanggal Jatuh Tempo</label>
            <input type="text" name="tgl_tempo" class="tanggal" id="faktur_pf-tgl_tempo">

            <fieldset class="field-group">
                <legend>Cara Bayar</legend>
                <label class="field-option">
                    <input id="faktur_pf-cash" type="radio" name="cara_bayar" value="1" checked/>
                    Cash
                </label>
                <label class="field-option">
                    <input id="faktur_pf-kredit" type="radio" name="cara_bayar" value="0"/>
                    Kredit
                </label>
            </fieldset>
            <fieldset class="input-process">
                <input type="Submit" name="simpan_btn" id="faktur_pf-simpan_btn" value="Simpan" class="tombol" />
                <input type="Button" name="batal_btn" id="faktur_pf-batal_btn" value="Batal" class="tombol" />
            </fieldset>
        </fieldset>

    </form>
</div>

<div class="data-list" id="faktur_pf-lembar_harga">
    <table class="tabel">
        
            <tr>
                <th>No</th>
                <th>Nama PF</th>
                <th>Satuan</th>
                <th>Kemasan</th>
                <th>Macam Sediaan</th>
                <th>Kekuatan</th>
                <th>No Batch</th>
                <th>Tgl Kadaluarsa</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total Harga</th>
                <th>Bonus</th>
                <th>Diskon</th>
            </tr>
        
            <? foreach ($faktur_pf as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['satuan'] ?></td>
                <td><?= $row['kemasan'] ?></td>
                <td><?= $row['sediaan'] ?></td>
                <td><?= $row['kekuatan'] ?></td>
                <td><?= "<input type=text name=no_batch value='".$row['no_batch']."' >" ?></td>
                <td><?= "<input type=text name=tgl_kadaluarsa value='".$row['tgl_kadaluarsa']."' >" ?></td>
                <td><?= "<input type=text name=jumlah value='".$row['jumlah']."' >" ?></td>
                <td><?= "<input type=text name=harga value='".$row['harga']."' >" ?></td>
                <td><?= "jumlah otomatis" ?></td>
                <td><?= "<input type=text name=bonus value='".$row['bonus']."' >" ?></td>
                <td><?= "<input type=text name=diskon value='".$row['diskon']."' >" ?></td>
            </tr>
            <? endforeach ?>
        
    </table>
    <div align="center">
        <input type="Submit" name="simpan_harga_btn" value="Simpan" id="faktur_pf-simpan_harga_btn" class="tombol">
        <input type="Button" name="batal_harga_btn" value="Batal" id="faktur_pf-batal_harga_btn" class="tombol">
    </div>
</div>


<script type="text/javascript" >
    $(document).ready(function(){
        $(".tanggal").datepicker();
//        $("#faktur_pf-isi_harga_btn").click(function(){
//            $("#faktur_pf-lembar_harga").toggle();
//        });
//        $("#faktur_pf-lembar_harga").toggle(false);
        $("#faktur_pf-next_year").click(function(){
            var tahun=$('#faktur_pf-thn_buat_sp').val();
            if(tahun.length==4){
                tahun++;
                $('#faktur_pf-thn_buat_sp').attr('value', tahun);
            }
        });
        $("#faktur_pf-previous_year").click(function(){
            var tahun=$('#faktur_pf-thn_buat_sp').val();
            if(tahun.length==4){
                tahun--;
                $('#faktur_pf-thn_buat_sp').attr('value', tahun);
            }
        });
    });
</script>
