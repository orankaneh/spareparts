<?php
require 'app/lib/common/master-data.php';
require 'app/actions/admisi/pesan.php';
set_time_zone();
?>
<script type="text/javascript">
    function bonusAction(bonus,idx){
        if(bonus.checked){
            $('#diskon_'+idx).attr('value', '100');
        }else{
            $('#diskon_'+idx).attr('value', '0');
        }
        hitungTotal(idx);
    }
    $(function() {
        $('#nosp').focus();
        $('.ppn').attr("disabled","disabled");
        $('.materai').attr("disabled","disabled");
        $('#btn-group').hide();
        $('#nosp').blur(function(){
            if($('#nosp').attr('value')==null || $('#nosp').attr('value')==''){
                $('#tabel-barang').html($('#temp').html());
                $('#btn-group').hide();
            }
        });
        $('#nosp').autocomplete("<?= app_base_url('/inventory/search?opsi=nosp') ?>",
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
                $('#tabel-barang').html($('#temp').html());
                $('.ppn').attr("disabled","disabled");
                $('.materai').attr("disabled","disabled");
                $('#btn-group').hide();
                var str='<div class=result><b>NO</b> '+data.id+', '+data.instansi+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.id);
            $('#suplier').attr('value',data.instansi);
            $('#idSuplier').attr('value',data.idInstansi);
            $('#tanggalPemesanan').attr('value',data.tanggal);
            var nosp=data.id;
            $.ajax({
                url: "<?= app_base_url('inventory/pembelian-barang-table') ?>",
                cache: false,
                data:'&nosp='+nosp+'&do=new',
                success: function(msg){
                    $('#tabel-barang').html(msg);
                    $('.ppn').removeAttr("disabled");
                    $('.materai').removeAttr("disabled");
                    $('#btn-group').show();
                    initTanggal();
                }
            });
        });
    });
    function getPPN(){
        var ppn=$("input[name=ppn]").attr('value')*1;
        if(ppn==''||ppn==null||isNaN(ppn))
            ppn=0;
        return ppn;
    }
    function cekform() {
        if ($('#nofaktur').attr('value')=="") {
            alert('No Faktur tidak boleh kosong');
            $('#nofaktur').focus();
            return false;
        }else if ($('#awal').attr('value')=="") {
            alert('Tanggal tidak boleh kosong');
            $('#awal').focus();
            return false;
        }else if ($('#nofaktur').attr('value')=="") {
            alert('No Faktur tidak boleh kosong');
            $('#nofaktur').focus();
            return false;
        }
        //cek form barang
        var jumlahForm=$('.barang_tr').length;
        var i=0;
        var isi=false;
        for(i=1;i<=jumlahForm;i++){
            if($('#idBarang'+i).attr('value')!=""){
               if($('#jumlah_'+i).attr('value')=='' || ($('#jumlah_'+i).attr('value')*1)==0){
                    alert('Jumlah tidak boleh kosong');
                    $('#Jumlah_'+i).focus();
                    return false;
                }
				if($('#harga_'+i).attr('value')=='' || ($('#harga_'+i).attr('value')*1)==0){
                    alert('harga tidak boleh kosong');
                    $('#harga_'+i).focus();
                    return false;
                }
				 if($('#no_batch_'+i).attr('value')=='' || ($('#no_batch_'+i).attr('value')*1)==0){
                    alert('No. batch tidak boleh kosong');
                    $('#no_batch_'+i).focus();
                    return false;
                }
				 if($('#ed_'+i).attr('value')=='' || ($('#ed_'+i).attr('value')*1)==0){
                    alert('E.D tidak boleh kosong');
                    $('#ed_'+i).focus();
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
    function cekFaktur(){
        $.ajax({
        url: "<?= app_base_url('admisi/search?opsi=cek_faktur')?>",
        data:'&no='+$('#nofaktur').attr('value'),
        cache: false,
        dataType: 'json',
        success: function(msg){
            if(!msg.status){
                alert('No. Faktur yang sama sudah pernah diinputkan');
                $('#nofaktur').val('');
                $('#nofaktur').focus();
                return false;
             }
        }
     });
    }
</script>
<form action="<?= app_base_url('inventory/control/pembelian') ?>" method="post" onsubmit="return cekform()">
    <h2 class="judul">Pembelian</h2>
    <?= isset($pesan) ? $pesan : NULL; ?>
    <div class="data-input">
        <fieldset>
            <legend>Form Pembelian</legend>
            <label for="nosp">No. SP*</label><input type="text" name="nosp" id="nosp" maxlength="11"/>
            <input type="hidden" name="tanggalPemesanan" id="tanggalPemesanan" readonly>
            <label for="suplier">Suplier</label><input type="text" name="suplier" id="suplier" disabled/><input type="hidden" name="idsuplier" id="idSuplier" />
            <label for="nofaktur">No. Faktur*</label><input type="text" name="nofaktur" id="nofaktur" onblur="return cekFaktur()" maxlength="21"/>
            <label for="tanggal">Tanggal*</label><input type="text" name="tanggal" id="awal" value="<?= get_date_now() ?>" maxlength="11"/>
            <label for="ppn">PPN (%)</label><input type="text" name="ppn" onkeyup='Desimal(this)' class="mini ppn right" maxlength="5" />
            <label for="materai">Biaya Materai</label><input type="text" name="materai" class="materai right" onKeyup="formatNumber(this)" maxlength="11"/>
            <label for="tempo">Tanggal Jatuh Tempo*</label><input type="text" name="tempo" id="akhir" maxlength="11"/>
        </fieldset>
    </div>
    <div id="tabel-barang">

    </div>
    <div class="field-group" id="btn-group" style="clear:left">
        <input type="submit" value="Simpan" name="save" class="tombol" /> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/pembelian') ?>'"/>
    </div>
</form> 

<script type="text/javascript">
    $(document).ready(function(){
        $('#materai').keyup(function(){
            var materai = $('#materai').val();
            $('.materai').val(materai); 
        })
    });
    function initTanggal(){
        $('.tanggal').datepicker({
            changeMonth: true,
            changeYear: true,
			dateFormat  : "dd/mm/yy",
        });
    }
</script>


<div id="temp" style="display: none">
    <input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;">
     <div class="data-list tabelflexibel">
    <table class="table-input" id="tblPembelian" cellspacing="0" cellpadding="0" style="width:130%">
        <tr style="background: #F4F4F4;">
            <th>No</th>
            <th style="width: 30%">Nama Packing Barang</th>
            <th>No Batch</th>
            <th>E.D.</th>
            <th>Jumlah</th>
            <th>Kemasan</th>
            <th>Harga @</th>
            <th>Disc (%)</th>
            <th>Disc (Rp)</th>
            <th>Sub Total</th>
            <th>Bonus</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 0;
        for ($i = 0; $i < 2; $i++) {
        ?>
            <tr class=" <?= ($no % 2 == 1) ? "odd" : "even" ?>">
                <td align="center"  class="listBarang">
                <?= ++$no ?>
            </td>
            <td align="left">
                <input type="text" style="width:98%;" disabled="disabled">
            </td>
            <td align="center" ><input type="text" style="width:95%;" disabled="disabled"/></td>
            <td align="center"><input type="text" disabled/></td>
            <td align="center"><input type="text" disabled/></td>
            <td align="center">&nbsp</td>
            <td align="center"><input type="text" disabled/></td>
            <td align="center"><input type="text" disabled/></td>
            <td align="center">&nbsp</td>
            <td align="center"><input type="text" disabled/></td>
            <td align="center"><input type="checkbox" name="barang[bonus]" value="1" id="bonus<?= $no ?>"/></td>
            <td class="aksi">
                <input type="button" class="tombol" value="Hapus" onclick="hapusBarang(<?= $no ?>,this)" />
            </td>
        </tr>
        <?php } ?>
        
    </table>
    <table width="92%">
        <tr>
            <td width="72%">&nbsp;</td><td width="115px">Total Diskon</td><td width="5px">: </td><td id="total_diskon" align="right"></td><td width="2%">&nbsp;</td>
        </tr>
        <tr>
            <td width="">&nbsp;</td><td width="115px">Total</td><td width="5px">: </td><td id="totalAll" align="right"></td><td width="2%">&nbsp;</td>
        </tr>
        <tr>
             <td width="">&nbsp;</td><td width="115px">PPN (Rp)</td><td width="5px">: </td><td id="ppn_nominal" align="right"></td></td><td width="2%">&nbsp;</td>
        </tr>
        <tr>
             <td width="">&nbsp;</td><td width="115px">Materai (Rp.)</td><td width="5px">: </td><td id="materai2" align="right"></td></td><td width="2%">&nbsp;</td>
        </tr>
        <tr>
             <td width="">&nbsp;</td><td style="border-top: 1px solid #cccccc; ">Total Pembelian (Rp.)</td><td width="5px">: </td><td style="border-top: 1px solid #cccccc; " width="110px" id="bayar" align="right"></td>
             <td width="2%">&nbsp;</td>
        </tr>
    </table>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#tabel-barang').html($('#temp').html());
    });
</script>