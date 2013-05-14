<?php
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
include 'app/actions/admisi/pesan.php';
set_time_zone();

$sessionunit = $_SESSION['id_unit'];
$unit = unit_muat_data($sessionunit);
//echo $sessionunit;
?>
<script type="text/javascript">
  function initBarang(counterr){
        $(function() {
            $('#barang'+counterr).autocomplete("<?= app_base_url('/inventory/search?opsi=barang_pemakaian')."&id_unit=$sessionunit" ?>",
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
                    var batch = '';
                    if(data.batch!=null){
                        batch = '\n No. Batch :'+data.batch;
                    }
                          
                    var str=ac_nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null);
                    return str + batch;
                    
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                var str=nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null)
                $(this).attr('value',str);
                $('#idPacking'+counterr).attr('value',data.id_packing);
                $('#stok'+counterr).html(data.sisa);
		$('#jmlstk'+counterr).val(data.sisa);
                $('#idStok'+counterr).attr('value',data.stok);
                $('#kemasan'+counterr).html(data.satuan_terbesar);
                $('#batch'+counterr).val(data.batch);
               
            });
        });
    }
    $(document).ready(function(){
      $('#addRow').click(function(){
          var counter = $('.barang_tr').length+1;
          var strings = "<tr class='barang_tr'>"+
                        "<td align='center'>"+counter+"</td>"+
                        "<td><input type=text name=barang[] id=barang"+counter+" class=auto style='width: 32em;'/><input type=hidden name=idPacking[] id=idPacking"+counter+" class=auto /><input type='hidden' name='batch[]' id='batch"+counter+"'/></td>"+
                        "<td align='center'><input type=text name=jumlah[] id=jumlah"+counter+" class=auto onkeyup='Angka(this)' style='width: 7em;'/><input type='hidden' name='id_stok[]' class='auto' id='idStok"+counter+"'></td>"+
                        "<td align='center' id='stok"+counter+"'></td>"+
                        "<td align='center' id='kemasan"+counter+"'></td>"+
                        "<!--<td align='center'><input type='text' name='batch[]' id='batch"+counter+"' readonly='readonly'></td>-->"+
                        "<td align='center'><input type='button' onClick='hapusBarang("+counter+",this)' class='tombol' value='Hapus'></td></tr>";
            $('#tblPemakaian').append(strings);   
            
            if(counter % 2 == 0){
                $('.barang_tr:eq('+(counter-1)+')').addClass('even');
            }else if(counter % 2 == 1){
                $('.barang_tr:eq('+(counter-1)+')').addClass('odd');
            }
                                
            initBarang(counter);
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
		
		  function cekJumlah(num){
        var sisa = $('#jmlstk'+num).val()*1;
        var jumlah = $('#jumlah'+num).val()*1;
        if(jumlah > sisa){
            alert('stok tidak cukup untuk dipakai');
            $('#jumlah'+num).val('');
            $('#jumlah'+num).focus();
        }
        
    }
</script>
<script type="text/javascript">
    function cekForm(){
        //cek form barang
		
        var jumlahForm=$('.barang_tr').length;
        var i=0;
        var isi=false;
        for(i=1;i<=jumlahForm;i++){
		var sisa = $('#jmlstk'+i).val()*1;
        var jumlah = $('#jumlah'+i).val()*1;
            if($('#idPacking'+i).attr('value')!=""){
			if($('#jumlah'+i).attr('value')=='' || ($('#jumlah'+i).attr('value')*1)==0){
                    alert('Jumlah tidak boleh kosong');
                    $('#jumlah'+i).focus();
                    return false;
                }
			else if(jumlah > sisa){
                     alert('stok tidak cukup untuk dipakai');
			         $('#jumlah'+i).val('');
                     $('#jumlah'+i).focus();
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
<h2 class="judul">Pemakaian</h2><?= isset($pesan) ? $pesan : NULL ?>
<form action="<?= app_base_url('inventory/control/pemakaian')?>" method="POST" onSubmit="return cekForm()">
    <div class="data-input">
        <fieldset>
            <legend>Form Pemakaian Barang</legend>
            <label for="petugas">Petugas</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?></span>
            <label for="unit">Unit</label><input type="text" style="border: none;" readonly="readonly" value="<?= $unit['nama']?>"/><input type="hidden" name="idUnit" id="idUnit" value="<?= $unit['id']?>"/>
            <label for="waktu">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= date('d-m-Y') ?></span><span style="font-size: 12px;margin-left: 5px;padding-top: 5px;" id="jam"></span>
        </fieldset>
    </div>
    <input type="button" value="Tambah Baris" id="addRow" class="tombol" style="margin-bottom: 5px;">
    <br />
    <div class="data-list tabelflexibel">
        <table id="tblPemakaian" class="table-input" style="width:90%">
            <tr style="background: #F4F4F4;">
                <th>No</th>
                <th style="width:30%">Nama Packing Barang</th>
                <th style="width:10%">Jumlah</th>
                <th style="width:10%">Stok</th>
                <th style="width:10%">Kemasan<!--Satuan Terkecil--></th>
<!--                <th class="no-wrap">No. Batch</th>-->
                <th>Hapus</th>
            </tr>
            <?
              for ($i = 1; $i <= 2; $i++) {
            ?>
              <tr class="barang_tr <?=$i%2!=0?'even':'odd'?>">
                    <td align="center"><?= $i ?></td>
                    <td>
                        <input type=text name=barang[] id=barang<?= $i ?> class=auto style="width: 32em;"/>
                        <input type=hidden name=idPacking[] id=idPacking<?= $i ?> class=auto />
                        <input type=hidden name=batch[] id=batch<?= $i ?> class=auto />
                        <input type="hidden" name="jmlstk<?= $i ?>" class="auto" id="jmlstk<?= $i ?>"></td>
                    <td align="center">
                        <input type=text name=jumlah[] id=jumlah<?= $i ?> class="auto" onkeyup="Angka(this)" style="width: 7em;" onblur="cekJumlah(<?= $i?>)"/>
                        <input type="hidden" name="id_stok[]" class="auto" id="idStok<?= $i ?>"></td>
                    <td align="center" id="stok<?= $i ?>"></td>
                    <td align="center" id="kemasan<?= $i ?>"></td>
<!--                    <td align="center"><input type="text" name="batch[]" id="batch<?= $i?>" readonly="readonly"></td>-->
                    <td align="center"><input type="button" onClick='hapusBarang(<?= $i ?>,this)' class="tombol" value="Hapus"></td>
                </tr>
                <script type="text/javascript">
                    initBarang(<?=$i?>);
                </script>
            <?
              }
            ?>
        </table>        
    </div>
    <div class="input-process">
        <input type="submit" value="Simpan" name="save" class="tombol" />
        <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/pemakaian') ?>'"/>
    </div>
</form>
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
