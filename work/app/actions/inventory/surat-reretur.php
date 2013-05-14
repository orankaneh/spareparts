<h2 class="judul"><a href="<?=app_base_url('inventory/surat-reretur')?>">Pengembalian Retur Pembelian</a></h2>
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
            $('#idSuplier').attr('value',data.id);
        }
    );
    });

    function initAutocomplete(count){
        $('#tanggal'+count).datepicker({changeMonth: true,
		changeYear: true});
        $('#barang'+count).autocomplete("<?= app_base_url('/inventory/search?opsi=barang_reretur') ?>",
        {
            extraParams:{
                no_retur: function() { return $('#no_retur'+count).val(); }
            },
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                }

                return parsed;
            },
            formatItem: function(data,i,max){
                if(data.kategori=='Obat'){
                    var pabrik='';
                    if(data.generik=='Generik'){
                        pabrik='<br>\n\<b>Pabrik :</b><i>'+data.pabrik+'</i>';
                    }
                    if(data.kekuatan!=null && data.kekuatan!=0){
                        var str='<div class=result><b>'+data.nama+'</b> <i>'+data.kekuatan+' '+data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
                    }else{
                        var str='<div class=result><b>'+data.nama+'</b> <i>' +data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
                    }
                }else{
                    if(data.kekuatan!=null && data.kekuatan!=0){
                        var str='<div class=result><b>'+data.nama+'</b> <i>'+data.kekuatan+' '+data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i></div>';
                    }else{
                        var str='<div class=result><b>'+data.nama+'</b> <i>'+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i></div>';
                    }
                }return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#idbarang'+count).attr('value', data.id_packing);
            $('#iddetail'+count).attr('value', data.id_detail);
            $('#no_retur'+count).attr('value', data.id_retur_pembelian);
            $('#satuan_terbesar'+count).html(data.satuan_terbesar);
            $('#idpacking'+count).attr('value', data.id_packing);
            var kekuatan=(data.kekuatan!=null && data.kekuatan!=0)?' '+data.kekuatan+',':'';
            var sediaan=(data.sediaan!=null)?' '+data.sediaan:'';
            var pabrik='';
            if(data.generik=='Generik'){
                pabrik=' '+data.pabrik;
            }
            $(this).attr('value', data.nama+kekuatan+sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+pabrik);
            $('#no_retur'+count).attr('value', data.no_retur);
        });
    }
    $(document).ready(function(){
        $("#tambahBaris").click(function(){
            var numb= $('.barang_tr').length+1;
            var string = "<tr class='barang_tr'>"+
                "<td align='center'>"+numb+"</td>"+
                "<td align='center'>"+
                "   <input type='text' style='width: 90%' name='barang["+counter+"][nama]' id='barang"+counter+"' class='auto'/>"+
                "  <input type='hidden' name='barang["+counter+"][idpacking]' id='idpacking"+counter+"' class='auto' />"+
                "  <input type='hidden' name='barang["+counter+"][iddetail]' id='iddetail"+counter+"' class='auto' />"+
                "</td>"+
                "<td align='center'><input type='text' name='barang["+counter+"][no_retur]' id='no_retur"+counter+"' class='auto'></td>"+
                "<td align='center'><input type='text' name='barang["+counter+"][batch]' class='auto'></td>"+
                '<td><input type="text" name="barang['+counter+'][ed]" id="tanggal'+counter+'"></td>'+
                "<td align='center'><input size=8 type='text' name='barang["+counter+"][jumlah]' class='auto'></td>"+
                "<td align=center><input size=8 type=text name='barang["+counter+"][harga]' class='auto right' onkeyup='formatNumber(this)'></td>"+
                "<td align='center' id='satuan_terbesar"+counter+"'></td>"+
                "<td align='center'><input type='button' class='tombol' value='Hapus' onclick='hapusBarang(1,this)'></td>"+
                "</tr>";
            $("#tblPemesanan").append(string);
            $('.barang_tr:eq('+(counter-1)+')').addClass((counter % 2 != 0)?'even':'odd');
            initAutocomplete(counter);
            counter++;
        });
    })

    function hapusBarang(count,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penerimaan=$('.barang_tr');
        var countPenerimaanTr=penerimaan.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
            $('.barang_tr:eq('+i+')').removeClass('even');
            $('.barang_tr:eq('+i+')').removeClass('odd');
            $('.barang_tr:eq('+i+')').addClass(((i+1) % 2 != 0)?'even':'odd');
        }
    }
</script>
<?
set_time_zone();
$noSurat = _select_arr("select (max(id)+1) as id from reretur_pembelian");
$noSurat = $noSurat[0]['id'];
if ($noSurat == NULL) {
    $noSurat = 1;
}
?>
<form action="<?= app_base_url('inventory/control/surat-reretur') ?>" method="post" >
    <div class="data-input">
        <fieldset><legend>Form Tambah Retur Pembelian</legend>
            <label for="pegawai">Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?></span>
            <label for="pegawai">No. Transaksi</label><span style="font-size: 12px;padding-top: 5px;"><?= $noSurat ?></span>
            <label for="pegawai">No. Surat</label><input type="text" name="no_surat">
        </fieldset>
    </div>
    <div class="field-group">
        <input type="button" class="tombol" value="Tambah Baris" id="tambahBaris"><br />
    </div>
    <table id="tblPemesanan" class="table-input">
        <tr>
            <th style="width: 2%">No</th>
            <th style="width: 40%">Nama Barang</th>
            <th style="width: 10%">No Retur</th>
            <th style="width: 10%">No Batch</th>
            <th style="width: 10%">Tgl Kadaluarsa</th>
            <th style="width: 5%">Jumlah</th>
            <th style="width: 5%">Harga</th>
            <th style="width: 10%">Kemasan</th>
            <th style="width: 10%">Aksi</th>
        </tr>
        <?php for ($i = 1; $i <= 2; $i++) {
        ?>
            <tr class="barang_tr <?= ($i % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $i ?></td>
                <td align="center">
                    <input type="text" style='width: 90%' name="barang[<?= $i ?>][nama]" id="barang<?= $i ?>" class="auto"/>
                    <input type="hidden" name="barang[<?= $i ?>][idpacking]" id="idpacking<?= $i ?>" class="auto" />
                    <input type="hidden" name="barang[<?= $i ?>][iddetail]" id="iddetail<?= $i ?>" class="auto" />
                </td>
                <td align="center"><input type="text" name="barang[<?= $i ?>][no_retur]" id="no_retur<?= $i ?>" class="auto"></td>
                <td align="center"><input type="text" name="barang[<?= $i ?>][batch]" class="auto"></td>
                <td><input type="text" name="barang[<?=$i?>][ed]" id="tanggal<?=$i?>"></td>
                <td align="center"><input size=8 type="text" name="barang[<?= $i ?>][jumlah]" class="auto"></td>
                <td align="center"><input size=8 type="text" name="barang[<?= $i ?>][harga]" class="auto right" onkeyup="formatNumber(this)"></td>
                <td align="center" id="satuan_terbesar<?= $i ?>"></td>
                <td align="center"><input type="button" class="tombol" value="Hapus" onclick="hapusBarang(1,this)"></td>
            </tr>
            <script type="text/javascript">initAutocomplete(<?= $i ?>);</script>
        <? } ?>
    </table>
    <span class="input-process" style="clear:left;float: left;margin: 10px;">
        <input type="submit" value="Simpan" name="save" class="tombol" /> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/surat-reretur') ?>'" />
    </span>
</form>
<script type="text/javascript">var counter= $('.barang_tr').length+1;</script>