<?php
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
include 'app/actions/admisi/pesan.php';

$unit = unit_muat_data();
set_time_zone();
?>
<script type="text/javascript">
    $(function(){
        $('#namaUnit').focus();
    })
    function initBarang(counter){
        $(function() {
            $('#barang'+counter).autocomplete("<?= app_base_url('/inventory/search?opsi=packing_barang_distribusi') ?>",
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
                    var str=ac_nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                var str=nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik])

                $(this).attr('value', str);
                $('#idPacking'+counter).attr('value',data.id_packing);
                $('#idBatch'+counter).val(data.batch);
                $('#batch'+counter).html(data.batch);
                $('#kemasan'+counter).html(data.satuan_terbesar);
                $('#konversi'+counter).val(data.nilai_konversi);
                //$('#stok'+counter).html(data.sisa);
                $('#id_stok'+counter).val(data.stok);
                hitung_ROP(data.id, '#rop'+counter);
            });
            $('#batch'+counter).autocomplete("<?= app_base_url('/inventory/search?opsi=barang_stok').'&key=batch' ?>",
            {
                extraParams:{
                    id_packing: function() { return $('#idPacking'+counter).attr('value'); 
                    },
                    batch: function(){return $('#batch'+counter).attr('value')}
                    
                }, 
                parse: function(data){
                    var parsed = [];
                    for (var i=0; i < data.length; i++) {
                        parsed[i] = {
                            data: data[i],
                            value: data[i].batch // nama field yang dicari
                        };
                    }
                    return parsed;
                },
                formatItem: function(data,i,max){
                    return '<div class=result>'+data.batch+'</div>';
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
               $(this).attr('value',data.batch);
               $('#stok'+counter).html(data.sisa);
                $('#id_stok'+counter).attr('value',data.stok);
            });
        });
    }
    $(function() {
        $('#namaUnit').autocomplete("<?= app_base_url('/inventory/search?opsi=unitDistribusi') ?>",
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
                var str='<div class=result><b style="text-transform:capitalize">'+data.nama+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idUnit').attr('value',data.id);
        }
    );
    });

    function cekform() {
        if ($('#namaUnit').attr('value')=="" || ($('#idUnit').attr('value')*1)==0) {
            alert('Nama Unit tidak boleh kosong');
            $('#namaUnit').focus();
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
				else if($('#batch'+i).attr('value')==''){
                    alert('batch tidak boleh kosong');
                    $('#batch'+i).focus();
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
    function cekJumlah(num){
        var focus = $('#jumlah'+num);
        var sisa = $('#stok'+num).html()*1;
        var jumlah = $('#jumlah'+num).val()*1;
        
        if(jumlah > sisa){
            alert('Jumlah barang tidak mencukupi untuk melakukan transaksi');
            focus.val('');
        }
    }
</script>
<h2 class="judul">Distribusi</h2><?= isset($pesan) ? $pesan : NULL ?>
<form action="<?= app_base_url('inventory/control/distribusi') ?>" method="POST" onSubmit="return cekform()">
    <div class="data-input">
        <fieldset>
            <legend>Form Distribusi</legend>
            <label for="pegawai">Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?>
           </span>
            <label for="unit">Unit *</label>

            <input type="text" id="namaUnit">
            <input type="hidden" name="unit" id="idUnit">
        </fieldset>
    </div>
    <input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;">
    <br />
    <div class="data-list tabelflexibel">
        <table id="tblDistribusi" class="table-input" style="width: 80%">
            <tr style="background: #F4F4F4;">
                <th style="width: 5%">No</th>
                <th style="width: 40%">Nama Packing Barang*</th>
                <th>No. Batch*</th>
                <th style="width: 10%">Jumlah*</th>
                <th style="width: 10%">Sisa Stok</th>
                <th style="width: 5%">Kemasan</th>
                <th style="width: 5%">ROP</th>
                <th style="width: 10%">Aksi</th>
            </tr>
            <? for ($i = 1; $i <= 2; $i++) { ?>
                <tr class="barang_tr <?= ($i % 2 == 0) ? 'even' : 'odd' ?>">
                    <td align="center"><?= $i ?></td>
                    <td align="center">
                        <input type="text" id="barang<?= $i ?>" class="auto" style='width: 30em'>
                        <input type="hidden" name="idPacking[]" class="auto" id="idPacking<?= $i ?>">
                    </td>
                    <td align="center">
                        <input type="text" id="batch<?= $i ?>" name="batch[]">
                    </td>
                    <td align="center">
                        <input type="text" style="width: 45px" name="jumlah[]" class="auto" id="jumlah<?= $i ?>" onkeyup="Desimal(this);cekJumlah(<?= $i ?>)">
                    </td>
                    <td align="center" id="stok<?= $i ?>">
                    </td>
                    <input type="hidden" name="id_stok[]" class="auto" id="id_stok<?= $i ?>"><input type="hidden" name="konversi[]" class="auto" id="konversi<?= $i ?>`">
                    <td align="center" id="kemasan<?= $i ?>">
                    </td>
                    <td align="center" id="rop<?= $i ?>">
                    </td>
                    <td align="center">
                        <input type="button" class="tombol" value="Hapus" onclick="hapusBarang(<?= $i ?>,this)">
                    </td>
                </tr>
                <script type="text/javascript">
                    initBarang(<?= $i ?>);
                </script>
            <? } ?>
        </table>
    </div>
    <div class="field-group">
        <input type="submit" value="Simpan" name="save" class="tombol" />
        <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/distribusi') ?>'"/>
    </div>
</form>    
<script type="text/javascript">
    var counters = $('.barang_tr').length+1;
    $(document).ready(function(){
        $('#tambahBaris').click(function(){
            var counter = counters++,
            number = $('.barang_tr').length+1;
            var string = "<tr class='barang_tr'>"+
                "<td align='center'>"+number+"</td>"+
                "<td align='center'><input type='text' id='barang"+counter+"' class='auto' style='width: 30em' /><input type='hidden' name='idPacking[]' class='auto' id='idPacking"+counter+"' /></td>"+
                "<td align='center'><input type='text' id='batch"+counter+"' name='batch[]'></td>"+
                "<td align='center'><input type='text' name='jumlah[]' class='auto' style='width: 45px' id='jumlah"+counter+"' onkeyup='Desimal(this);cekJumlah("+counter+")'/></td>"+
                "<td align='center' id='stok"+counter+"'></td><input type='hidden' name='id_stok[]' class='auto' id='id_stok"+counter+"' /><input type='hidden' name='konversi[]' class='auto' id='konversi"+counter+"'>"+
                "<td align='center' id='kemasan"+counter+"'></td>"+
                "<td align='center' id='rop"+counter+"'></td>"+
                "<td align='center'><input type='button' class='tombol' align='center' value='Hapus' onclick='hapusBarang("+counter+",this)'></td>";
            
            $('#tblDistribusi').append(string);
            if(counter % 2 == 1){
                $('.barang_tr:eq('+(counter-1)+')').addClass('even');
            }else if(counter % 2 == 0){
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
            if((i+1) % 2 == 1){
                $('.barang_tr:eq('+i+')').addClass('even');
            }else{
                $('.barang_tr:eq('+i+')').addClass('odd');
            }
        }}
</script>
