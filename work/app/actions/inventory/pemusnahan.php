<?php
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
include 'app/actions/admisi/pesan.php';
set_time_zone();
?>
<script type="text/javascript">
  function initBarang(counterr){
        $(function() {
            $('#saksi').focus();
            $('#barang'+counterr).autocomplete("<?= app_base_url('/inventory/search?opsi=barang_stok') ?>",
            {
                parse: function(data){
                    var parsed = [];
                    for (var i=0; i < data.length; i++) {
                        parsed[i] = {
                            data: data[i],
                            value: data[i].barang // nama field yang dicari
                        };
                    }
                    return parsed;
                },
                formatItem: function(data,i,max){
                    var str=ac_nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null)+'batch:'+data.batch;
                    return str;                    
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){                
                var str=nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik]);

                $(this).attr('value',str);
                $('#idPacking'+counterr).attr('value',data.id_packing);
                $('#stok'+counterr).html(data.sisa);
                $('#idStok'+counterr).attr('value',data.stok);
                $('#kemasan'+counterr).html(data.kemasan);
                $('#noBatch'+counterr).html(data.batch);
                $('#batch'+counterr).val(data.batch);
            });
        });
    }
    function cekJumlah(num){
        var sisa = $('#stok'+num).html()*1;
        var jumlah = $('#jumlah'+num).val()*1;
        if(jumlah > sisa){
            alert('Jumlah tidak mencukupi untuk transaksi');
            $('#jumlah'+num).val('');
            $('#jumlah'+num).focus();
        }
        
    }
</script>
<h2 class="judul">Pemusnahan</h2><?= isset($pesan) ? $pesan : NULL ?>
<form action="<?= app_base_url('inventory/control/pemusnahan') ?>" method="POST" onSubmit="return cekForm()">
    <div class="data-input">
        <fieldset>
            <legend>Form Pemusnahan Obat</legend>
            <label for="petugas">Petugas</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?></span>
            <label for="saksi">Saksi</label><input type="text" id="saksi" /><input type="hidden" name="idsaksi" id="idsaksi" />
            <label for="waktu">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= date('d-m-Y') ?></span><span style="font-size: 12px;margin-left: 5px;padding-top: 5px;" id="jam"></span>
        </fieldset>
    </div>
    <input type="button" value="Tambah Baris" id="addRow" class="tombol" style="margin-bottom: 5px;">
    <br />
  <div class="data-list tabelflexibel">
        <table id="tblPemusnahan" class="table-input" style="width:80%">
            <tr style="background: #F4F4F4;">
                <th>No</th>
                <th class="center" style="width:30%">Nama Packing Barang*</th>
                <th class="center" style="width:10%">Jumlah*</th>
                <th style="width:10%">Stok</th>
                <th>Kemasan</th>
                <th>Alasan*</th>
                <th class="no-wrap">No. Batch</th>
                <th>Hapus</th>
            </tr>
            <? for ($i = 1; $i <= 2; $i++) {
 ?>
                <tr class="barang_tr <?=$i%2!=0?'even':'odd'?>">
                    <td align="center"><?= $i ?></td>
                    <td><input type=text name=barang[] id=barang<?= $i ?> class=auto style="width: 35em;"/><input type=hidden name=idPacking[] id=idPacking<?= $i ?> class=auto /></td>
                    <td><input type=text name=jumlah[] id=jumlah<?= $i ?> class=auto onkeyup="Desimal(this)" onblur="cekJumlah(<?= $i?>)" style="width: 7em;" maxlength="11"/><input type="hidden" name="id_stok[]" class="auto" id="idStok<?= $i ?>"></td>
                    <td align="center" id="stok<?= $i ?>"></td>
                    <td align="center" id="kemasan<?= $i ?>"></td>
                    <td align="center">
                        <select name="alasan[]" id="alasan<?= $i ?>">
                            <option value="">Pilih alasan</option>
                             <option value="Sisa Pemakaian">Sisa Pemakaian</option>
                            <option value="Rusak">Rusak</option>
                            <option value="Kadaluarsa">Kadaluarsa</option>
                        </select>
                        <input type="hidden" name="no_batch[]" id="batch<?= $i ?>">
                    </td>
                    <td align="center" id="noBatch<?= $i ?>"></td>
                    <td align="center"><input type="button" onClick='hapusBarang(<?= $i ?>,this)' class="tombol" value="Hapus"></td>
                </tr>
                <script type="text/javascript">
                    initBarang(<?=$i?>);
                </script>
<? } ?>
        </table>
    </div>
    <div class="input-process">
        <input type="submit" value="Simpan" name="save" class="tombol" />
        <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/pemusnahan') ?>'"/>
    </div>
</form>   
<script type="text/javascript">
        $(function() {
        $('#saksi').autocomplete("<?= app_base_url('/inventory/search?opsi=saksi') ?>",
        {
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
                var str='<div class=result><b>'+data.nama+' </b>'+((data.profesi!=null)?data.profesi:'')+'<br>'+data.kecamatan+', '+data.kabupaten+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idsaksi').attr('value',data.id);
        }
    );
    });
    var counters = $('.barang_tr').length+1;
    $(document).ready(function(){
        $("#addRow").click(function(){
            var counterr = counters++,
            number = $('.barang_tr').length+1;
            var barang = 'barang'+counterr,
            satuan = 'satuan'+counterr,
            sisa = 'sisa'+counterr,
            rop = 'rop'+counterr

            string = "<tr class='barang_tr'>"+
                "<td align=center>"+number+"</td>"+
                "<td><input type=text name=barang[] id=barang"+counterr+" class=auto style='width: 35em;'/><input type=hidden name=idPacking[] id=idPacking"+counterr+" class=auto /></td>"+
                "<td><input type=text name=jumlah[] id='jumlah"+counterr+"' class=auto onkeyup='Desimal(this)' onblur='cekJumlah("+counterr+")' style='width: 7em;' maxlength='11'/><input type='hidden' name='id_stok[]' class='auto' id='idStok"+counterr+"'></td>"+
                "<td align='center' id='stok"+counterr+"'></td>"+
                "<td align='center' id='kemasan"+counterr+"'></td>"+
                "<td align=center><select name='alasan[]' id='alasan"+counterr+"'>"+
                "<option value=''>Pilih alasan</option>"+
                "<option value='Rusak'>Rusak</option><option value='Kadaluarsa'>Kadaluarsa</option></select><input type='hidden' name='no_batch[]' id='batch"+counterr+"'></td>"+
                "<td align='center' id='noBatch"+counterr+"'></td>"+
                "<td align='center'><input type='button' value='Hapus' onClick='hapusBarang("+counterr+",this)' class='tombol'></td>"+
                "</tr>";
            $("#tblPemusnahan").append(string);
            if(counterr % 2 == 0){
                $('.barang_tr:eq('+(counterr-1)+')').addClass('even');
            }else if(counterr % 2 == 1){
                $('.barang_tr:eq('+(counterr-1)+')').addClass('odd');
            }
                                
            initBarang(counterr);
        })
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
            if((i+1) % 2 == 0){
                $('.barang_tr:eq('+i+')').addClass('even');
            }else{
                $('.barang_tr:eq('+i+')').addClass('odd');
            }
        }}
</script>
<script type="text/javascript">
    function cekForm(){
        if ($('#saksi').attr('value')=="" || ($('#idsaksi').attr('value')*1)==0) {
            alert('Nama saksi tidak boleh kosong');
            $('#saksi').focus();
            return false;
        }
        //cek form barang
        var jumlahForm=$('.barang_tr').length;
        var i=0;
        var isi=false;
        for(i=1;i<=jumlahForm;i++){
            if($('#idPacking'+i).attr('value')!=""){
                if($('#jumlah'+i).attr('value')=='' || ($('#jumlah'+i).attr('value')*1)==0){
                    alert('Jumlah tidak boleh kosong');
                    $('#jumlah'+i).focus();
                    return false;
                }
                if($('#alasan'+i).val()==''){
                    alert('Alasan pemusnahan tidak boleh kosong');
                    $('#alasan'+i).focus();
                    return false;
                }
                isi=true;
            }
        }
        if(!isi){
            alert('inputan barang masih kosong');
            return false;
        }
    }
</script>
<script type="text/javascript">
    function jam(){
        var waktu = new Date();
        var jam = waktu.getHours();
        var menit = waktu.getMinutes();
        var detik = waktu.getSeconds();

        if (jam < 10){
            jam = "0" + jam;
        }
        if (menit < 10){
            menit = "0" + menit;
        }
        if (detik < 10){
            detik = "0" + detik;
        }
        var jam_div = document.getElementById('jam');
        jam_div.innerHTML = jam + ":" + menit + ":" + detik;
        setTimeout("jam()", 1000);
    }
    jam();
</script>