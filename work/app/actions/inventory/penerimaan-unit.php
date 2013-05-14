<?php
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
include_once 'app/actions/admisi/pesan.php';

set_time_zone();
?>
<script type="text/javascript">
    $(function() {
        $('#tblPenerimaan').html($('#temp').html());
        $('#distribusi').focus();
        $('#distribusi').autocomplete("<?= app_base_url('/inventory/search?opsi=distribusi') ?>",
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
                var str='<div class=result>'+data.id+', '+data.waktu+' <br><b>Kpd.</b> '+data.unit_tujuan+'</div>';
                        
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).val(data.id);
            $('#idDistribusi').val(data.id);
            $('.tombol').removeAttr('disabled');
            var id=data.id;
            $.ajax({
                url: "<?= app_base_url('inventory/penerimaan-unit-tabel') ?>",
                cache: false,
                data:'&id='+id,
                success: function(msg){
                    $('#tblPenerimaan').html(msg);
                }
            });
        });
    });
        

    function cekForm(){
        if($("#distribusi").val() == ""){
            alert("No. Distribusi tidak boleh kosong");
            $("#distribusi").focus();
            return false;
        }
        if($("#idDistribusi").val() == ""){
            alert("Pilih No. Distribusi dengan benar");
            $("#idDistribusi").focus();
            return false;
        }
        var ok=0;
        $('#tblPembelian td:nth-child(3)').children().each(function(){                
            if($(this).val()==""){                    
                $(this).focus();
                ok++;                
            }                
        });
        if(ok>0){
            alert("Jumlah tidak boleh kosong");
            return false;
        }
    }

</script>    
<h2 class="judul">Penerimaan Unit</h2><?= isset($pesan) ? $pesan : NULL ?>
<form action="<?= app_base_url('inventory/control/penerimaan-unit') ?>" method="POST" onSubmit="return cekForm()">
    <div class="data-input">
        <fieldset>
            <legend>Form Penerimaan Unit</legend>
            <label for="pegawai">Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?></span>
            <label for="unit">Unit</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['unit'] ?></span>
            <label for="distribusi">No. Distribusi</label><input type="text" name="distribusi" id="distribusi"><input type="hidden" name="id_distribusi" id="idDistribusi">
            <label for="waktu">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= date('d/m/Y') ?>&nbsp;</span><span style="font-size: 12px;padding-top: 5px;" id="jam"></span>
        </fieldset> 
    </div>    
    <div id="tblPenerimaan">

    </div>   
    <fieldset class="field-group">    
        <input type="submit" value="Simpan" name="save" class="tombol" disabled="disabled"/>
        <input type="button" value="Batal" class="tombol" disabled="disabled" onClick="javascript:location.href='<?= app_base_url('inventory/penerimaan-unit') ?>'"/>
    </fieldset>
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

<div id="temp" style="display: none">
<div class="data-list tabelflexibel">
    <table class="table-input" cellspacing="0" cellpadding="0" id="tblPembelian" style="width: 100%; ">
        <tr>
            <th>No</th>
            <th style="width: 32%">Nama Packing Barang</th>
            <th class="sleft no-wrap">Jumlah Terima</th>
            <th>Jumlah Distribusi</th>
            <th>Jumlah Telah Diterima</th>
            <th class="no-wrap">Kemasan</th>
            <th>Aksi</th>
        </tr> 
        <tr bgcolor="">
            <td align="center">1</td>
            <td class="no-wrap"></td>
            <td><input type="text" disabled></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="center"></td>
        </tr>
        <tr bgcolor="">
            <td align="center">2</td>
            <td class="no-wrap"></td>
            <td><input type="text" disabled></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="center"></td>
        </tr>
        </table>
</div>
</div>