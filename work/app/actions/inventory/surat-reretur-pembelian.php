<h2 class="judul"><a href="<?=app_base_url('inventory/surat-reretur-pembelian')?>">Pengembalian Retur Pembelian</a></h2>
<script type="text/javascript">
    $(function() {
         $('#waktu').datetimepicker({
           dateFormat: 'dd/mm/yy',
           timeFormat: 'hh:mm:ss',
           changeMonth: true,
           changeYear: true,
           showSecond: true
        });
       
        $('#list-barang').html($('#temp'));
        $('input[name=id_retur]').autocomplete("<?= app_base_url('/inventory/search?opsi=no_retur') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].id // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                if(data.suplier==null){
                    data.suplier='';
                }
                var str='<div class=result>'+data.id+' <br/><i> '+data.suplier+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.id);
            $('#suplier').html(data.suplier);
            $.ajax({
                url: "<?= app_base_url('inventory/surat-reretur-pembelian-table') ?>",
                cache: false,
                data:'&id='+data.id,
                success: function(msg){
                    $('#returOke').attr('value','yes');
                    $('#list-barang').html(msg);
                }
            });
        });
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
                var str=ac_nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null);
                return str;
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
            var str=nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null)
            $(this).attr('value',str);
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
                "<td align='center'><input type='text' name='barang["+counter+"][batch]' class='auto'  onkeyup='Angka(this)' maxlength='11'></td>"+
                '<td><input type="text" name="barang['+counter+'][ed]" id="tanggal'+counter+'"></td>'+
                "<td align='center'><input size=8 type='text' name='barang["+counter+"][jumlah]' class='auto'  onkeyup='Angka(this)' maxlength='11'></td>"+
                "<td align=center><input size=8 type=text name='barang["+counter+"][harga]' class='auto right' onkeyup='formatNumber(this)' maxlength='11'></td>"+
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
<form action="<?= app_base_url('inventory/control/surat-reretur-pembelian') ?>" id="form" method="post" >
    <div class="data-input">
        <fieldset><legend>Form Tambah Pengembalian Retur Pembelian</legend>
            <label>Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?></span>
            <label>No. Transaksi</label><span style="font-size: 12px;padding-top: 5px;"><?= $noSurat ?></span>
            <label>No. Surat</label><input type="text" name="no_surat" />
            <label for="waktu">Waktu</label><input type="text" name="waktu" id="waktu" class="timepicker"/>
            <label>No. Surat Retur</label><input type="text" name="id_retur" /><input type="hidden" name="returOke" id="returOke" value="" />
            <label>Suplier</label><span style="font-size: 12px;padding-top: 5px;" id="suplier"></span>
        </fieldset>
    </div>
<!--    <div class="field-group">
        <input type="button" class="tombol" value="Tambah Baris" id="tambahBaris"><br />
    </div>-->
    <div id="list-barang"></div>
    <span class="input-process" style="clear:left;float: left;margin: 10px;">
        <input type="submit" value="Simpan" name="save" class="tombol" /> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/surat-reretur-pembelian') ?>'" />
    </span>
</form>
<script type="text/javascript">var counter= $('.barang_tr').length+1;</script>

<div id="temp">
    <table id="tblPemesanan" class="table-input">
        <tr>
            <th style="width: 2%">No</th>
            <th style="width: 40%">Nama Packing Barang</th>
            <th style="width: 10%">No Retur</th>
            <th style="width: 10%">No Batch</th>
            <th style="width: 10%">Tgl Kadaluarsa</th>
            <th style="width: 5%">Jumlah</th>
           <th style="width: 5%">Uang</th>
            <th style="width: 10%">Kemasan</th>
            <th style="width: 10%">Aksi</th>
        </tr>
        <?php for ($i = 1; $i <= 2; $i++) {
        ?>
            <tr class="barang_tr <?= ($i % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $i ?></td>
                <td align="center">
                    <input type="text" style='width: 90%' class="auto" disabled/>
                </td>
                <td align="center"><input type="text" style='width: 90%' class="auto" disabled></td>
                <td align="center"><input type="text" style='width: 90%' class="auto" disabled></td>
                <td><input type="text" style='width: 90%' class="auto" disabled></td>
                <td align="center"><input size=8 type="text" style='width: 90%' class="auto" disabled></td>
                <td align="center"><input type='checkbox' name="jenis" value="Uang" disabled="disabled"></td>
                <td align="center" id="satuan_terbesar<?= $i ?>"></td>
                <td align="center"><input type="button" class="tombol" value="Hapus"></td>
            </tr>
            <script type="text/javascript">initAutocomplete(<?= $i ?>);</script>
        <? } ?>
    </table>
</div>

<script type="text/javascript">
$(document).ready(function()
{
    $("#form").submit(function(event)
    {
//        event.preventDefault();
        $("#form input[type=submit]").click();
    });
    $('#form').submit(function(event){
        if($('input[name=no_surat]').attr('value')==''){
            alert('Nomor surat reretur harus diisi!');
            $('input[name=no_surat]').focus();
            return false;
        }
        if($('input[name=id_retur]').attr('value')==''){
            alert('Nomor surat retur harus diisi!');
            $('input[name=id_retur]').focus();
            return false;
        }
        if($('input[name=returOke]').attr('value')==''){
            alert('No. surat tidak diketahui!');
            $('input[name=id_retur]').val('');
            $('input[name=id_retur]').focus();
            return false;
        }
        $.ajax(
        {
            url: "<?= app_base_url('inventory/search?opsi=cek_id_reretur')?>",
            data:'&id='+$('input[name=no_surat]').attr('value'),
            cache: false,
            dataType: 'json',
            success: function(msg)
            {
                if(msg.status)
                {
                    alert('No. surat sudah dipakai!');
                    $('input[name=no_surat]').val('');
                    $('input[name=no_surat]').focus();
                    return false;
                } else
                {
                    $("#form input[type=submit]").unbind("click").click();
                }
            }
        });
        var jumlahForm=$('.barang_tr').length;
        var i=0;
        var isi=false;
        for(i=1;i<=jumlahForm;i++)
        {
            if($('#jumlah'+i).val()=='')
            {
                alert('Jumlah belum diisi');
                $('#jumlah'+i).focus();
                return false;
            }
            isi=true;
        }
    });
})
</script>
