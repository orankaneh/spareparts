<style type="text/css">
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px;}
    div#users-contain { width: 100%; margin: 20px 0; }
    #perhatian{
        background:#f9f9f9;
        text-align: justify;
        margin-left: 10px;
        margin-right: 10px;
    }
    #perhatian legend{
        font-size:8px;
        font-weight:bold;
        text-transform:uppercase;
        background:#f1f1f1;
        border-top:1px dotted #333;
        border-left:1px dotted #333;
        border-right:1px dotted #333;
        padding:3px;
        background:#ddd;
    }
</style>
<h2 class="judul">Penjualan</h2>
<?php
    require 'app/actions/admisi/pesan.php';
    require 'app/lib/common/master-inventory.php';
    require 'app/lib/common/master-data.php';
    
    $aturan_pakai = aturan_pakai_muat_data();
    $new_resep = resep_auto_increment();
    $kelas = kelas_muat_data();
    $biaya_apt = administrasi_apoteker_muat_data();

    foreach ($new_resep as $rowA
        );
    $baru = (isset($rowA['new_numb']) ? $rowA['new_numb'] : null);
    $nopenjualan = no_penjualan_new_id();
    $nopenjualan = isset($nopenjualan)?$nopenjualan:null;
?>
<script type="text/javascript">
    var startup=true;
    var url_control_temp='<?=app_base_url('inventory/control/penjualan-temp')?>';
    var url_control_penjualan='<?=app_base_url('inventory/control/penjualan-resep')?>';
    
    $(document).ready(function(){
        //form autocomplete bagian isi atas  form autocomplete bagian isi atas  form autocomplete bagian isi atas  form autocomplete bagian isi atas  ...     
    
        $('#norm').attr('disabled','disabled');
        $('#nama').attr('disabled','disabled');
        x = null;                                
                
        function setStartupDisabled(){
            for (i = 1; i <= 2; i++) {
                    $('#databarang'+i).attr('disabled','disabled');
                    $('#tebus'+i).attr('disabled','disabled');
                    $('#aturpakai'+i).attr('disabled','disabled');
                    $('#resep'+i).attr('disabled','disabled');
                    $('#dosisracik'+i).attr('disabled','disabled');
                    $('#jmlh'+i).attr('disabled','disabled');
                    $('#jmlpakai'+i).attr('disabled','disabled');
                    $('#detur'+i).attr('disabled','disabled');

             }        

             startup=false;
        }
            
            
        function cekFormAtas(){


            if(x=="resep"){
                if ($('#nama').val() == ''){
                    alert("Nama pasien tidak boleh kosong !");
                    $('#nama').focus();
                    return false;
                }   

                if ($('#norm').val() == ''){
                    alert("No RM pasien tidak boleh kosong !");
                    $('#norm').focus();
                    return false;
                }
                
                if ($('#iddokter').val() == '') {
                        alert("Nama dokter tidak boleh kosong !");
                        $('#dokter').focus();
                        return false;
                    }

                    if ($('#idpenduduk').val() == '') {
                        alert("Nama pasien tidak boleh kosong !");
                        $('#nama').focus();
                        return false;
                    }
            }

        }
                
        function setDisabled(){
            var panjangs = $('.barang_tr').length;
            if(x=="bebas"){
                for (i = 1; i <= panjangs; i++) {
                    $('#aturpakai'+i).attr('disabled','disabled');
                    $('#databarang'+i).removeAttr('disabled','disabled');
                    $('#tebus'+i).removeAttr('disabled','disabled');
                    $('#resep'+i).attr('disabled','disabled');
                    $('#dosisracik'+i).attr('disabled','disabled');
                    $('#jmlh'+i).attr('disabled','disabled');
                    $('#jmlpakai'+i).attr('disabled','disabled');
                    $('#detur'+i).attr('disabled','disabled');

                }
            }else{
                if ($('#nama').val() == ''){
                    return false;
                }

                 if ($('#norm').val() == ''){
                    return false;
                }

                if ($('#iddokter').val() == '') {
                    return false;
                }

                if ($('#idpenduduk').val() == '') {
                    return false;
                }    

                for (i = 1; i <= panjangs; i++) {
                    $('#databarang'+i).removeAttr('disabled','disabled');
                    $('#tebus'+i).removeAttr('disabled','disabled');
                    $('#aturpakai'+i).removeAttr('disabled','disabled');
                    $('#resep'+i).removeAttr('disabled','disabled');
                    $('#dosisracik'+i).removeAttr('disabled','disabled');
                    $('#jmlpakai'+i).removeAttr('disabled','disabled');
                    $('#jmlpakai'+i).attr('readonly','readonly');
                    $('#jmlh'+i).removeAttr('disabled','disabled');                            
                    $('#detur'+i).removeAttr('disabled','disabled');
                }
                
                $("#biaya_apt").removeAttr('readonly');
            }
            return true;
        }
                
        $('#bebas').click(function() {
                //$('#nopenjualan').removeAttr('disabled','disabled');
                $('#norm').attr('disabled','disabled');
                $('#nama').removeAttr('disabled','disabled');
                $('input[name=saveresep]').removeAttr('disabled','disabled');
                $('input[name=kitir]').removeAttr('disabled','disabled');
                $('#noresep').attr('disabled','disabled');
                $('#awal').attr('disabled','disabled');
                $('#dokter').attr('disabled','disabled');
                $('#addnewrow').removeAttr('disabled','disabled');

                $('#nama').focus();     

                x = "bebas";
                $('#nama').val('');
                $('#norm').val('');
                $('#iddokter').val('');
                $('#idpenduduk').val('');
                $('#dokter').val('');
                $('#nama').val('');
                $('#kelas').val('');
                $('#idkelas').val('');
                requiredField(x);
                setDisabled();
                $('#biaya_apt').attr('value',numberToCurrency2(0));
                $('#biaya_apt_1').html(numberToCurrency2(0));
                var total=$('#total').val()==''?0:currencyToNumber($('#total').val());
                $('#total_tagihan').attr('value', numberToCurrency2(total));
                $('#total_tagihan_1').html(numberToCurrency2(total));
        });
		
        $('#resep').click(function() {
                var panjang = $('.barang_tr').length;
                //$('#nopenjualan').removeAttr('disabled','disabled');
                $('#norm').removeAttr('disabled','disabled');
                $('#nama').removeAttr('disabled','disabled');
                $('#noresep').removeAttr('disabled','disabled');
                $('#awal').removeAttr('disabled','disabled');
                $('#dokter').removeAttr('disabled','disabled');
                $('#dokter').focus();
                $('#addnewrow').removeAttr('disabled','disabled');

                x = "resep"; 
                requiredField(x);
                setDisabled();
        });
                
        //autocomplete dataBarang
        $(".tbody").delegate(" tr td:nth-child(2) input:first-child", "acEvent",function(){
            $(this).unautocomplete();
            $(this).autocomplete("<?= app_base_url('/inventory/search?opsi=barang-resep') ?>",
            {
                extraParams:{
                    kelas:function(){
                        return  $("#idkelas").val();
                    }
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
                    var str=ac_nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)+"No. batch:"+data.batch
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated) {
                var str=nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null)
                $(this).attr('value',str);
                var tr=$(this).parent('td').parent('tr');
                var harga = numberToCurrency2(data.harga);
                tr.children('td:eq(1)').children('.iddatabarangs').attr('value',data.id);
                tr.children('td:eq(2)').children('.kekuatan').attr('value',data.kekuatan);
                tr.children('td:eq(2)').children('.kategori').attr('value',data.kategori);
                tr.children('td:eq(6)').children('.harga').attr('value',harga);
                tr.children('td:eq(7)').html(harga);
                tr.children('td:eq(3)').children('.packing').attr('value',data.id_packing);
				tr.children('td:eq(3)').children('.batch').attr('value',data.batch);
                tr.children('td:eq(5)').children('.sisa').attr('value',data.sisa);
                tr.children('td:eq(10)').children('.margin').attr('value',data.nilai_persentase);
            });
        });
                
                
                
        $("input[name=jenis]").click(function(){                   
            //anak kolom ke 6 #jmlhpakai   
            $(".tbody").delegate(" tr td:nth-child(6) input:first-child", "keyup",function(){
                    var tr=$(this).parent('td').parent('tr');
                    var kekuatan = tr.children('td:eq(2)').children('.kekuatan').val();

                    var harga = parseFloat(currencyToNumber(tr.children('td:eq(6)').children('input[type=hidden]').val()));
                    //var pakai = parseFloat(tr.children('td:eq(5)').children('input').val());
                    //var subtotal = numberToCurrency2(harga * pakai);
                    var tebus = parseFloat(tr.children('td:eq(4)').children('input').val());
                    var subtotal = numberToCurrency2(harga * tebus);
                    tr.children('td:eq(9)').html(subtotal);
                    tr.children('td:eq(6)').children('.subtotal').attr('value',subtotal);
                    var row = $('.barang_tr').length;
                    var harga = 0;
                    var embalage=0;
                    for (i = 1; i <= row; i++) {                            
                            if($('#kategori'+i).val()!='Embalase'){
                                harga = harga + parseFloat(currencyToNumber($('#subtotal'+i).val()==''?0:$('#subtotal'+i).val()));
                            }else{
                                embalage = embalage + parseFloat(currencyToNumber($('#subtotal'+i).val()==''?0:$('#subtotal'+i).val()));
                            }
                    }
                    $('#total').attr('value',numberToCurrency2(harga));
                    $('#total_1').html(numberToCurrency2(harga));
                    var biaya_apt=$('#biaya_apt').val()==''?0:currencyToNumber($('#biaya_apt').val());                      
                    $('#biaya_embalage').attr('value', numberToCurrency2(embalage));
                    $('#biaya_embalage_1').html(numberToCurrency2(embalage));
                    $('#total_tagihan').attr('value', numberToCurrency2(harga+biaya_apt+embalage));
                    $('#total_tagihan_1').html(numberToCurrency2(harga+biaya_apt+embalage));
            });
            
            //anak kolom ke 4 #jmlh
            $(".tbody").delegate(" tr td:nth-child(4) input:first-child", "keyup",function(){
                    var tr=$(this).parent('td').parent('tr');
                    var jumlh = $(this).val()*1;
                    var sisa = tr.children('td:eq(5)').children('.sisa').val()*1;
                    if(jumlh > sisa){
                            var string = 'Sisa stok tidak cukup untuk dilakukan penjualan, sisa stok '+sisa+'';
                            alert(string);
                            $(this).val('');
                            $(this).focus();
                    }
                    var tr=$(this).parent('td').parent('tr');
                    var hrg = parseFloat(currencyToNumber(tr.children('td:eq(6)').children('.harga').val()));
                    var tebus = parseFloat(tr.children('td:eq(4)').children('input').val());
                    var jumlah_r = parseFloat(tr.children('td:eq(3)').children('.jmlh').val());
                    var dosisracik = parseFloat(tr.children('td:eq(2)').children('.dosisracik').val());
                    var kekuatan = parseFloat(tr.children('td:eq(2)').children('.kekuatan').val());
                    var detur = jumlah_r - tebus;
                    if (x == 'bebas') {
                            var subtotal = '';
                            if (tebus != '') {
                                    var subtotal = numberToCurrency2(tebus * hrg);
                            }
                            tr.children('td:eq(5)').children('input[type=text]').attr('value',isNaN(tebus)?'':tebus);
                            tr.children('td:eq(9)').html(subtotal);
                            tr.children('td:eq(6)').children('.subtotal').attr('value',subtotal);
                            //alert(hrg);
                    }
                    if (x == 'resep') {
                            var jmlpakai = (dosisracik * jumlah_r) / kekuatan;
                            if (isNaN(dosisracik) || dosisracik == '0') {
                                    var jmlpakai = tebus;
                            }
                            //var subtotal = numberToCurrency2(jmlpakai * hrg);
                            var subtotal = numberToCurrency2(tebus * hrg);
                            tr.children('td:eq(5)').children('input[type=text]').attr('value',isNaN(jmlpakai)?'':jmlpakai);
                            tr.children('td:eq(8)').html(isNaN(detur)?'':detur);
                            tr.children('td:eq(6)').children('.detur').attr('value',detur);
                            tr.children('td:eq(9)').html(subtotal);
                            tr.children('td:eq(6)').children('.subtotal').attr('value',subtotal);
                            if (detur < 0) {
                                    alert('Tebus tidak boleh melebihi jumlah R !');
                                    tr.children('td:eq(4)').children('input[type=text]').attr('value','');
                                    tr.children('td:eq(5)').children('input[type=text]').attr('value','');
                                    tr.children('td:eq(8)').html('');
                                    tr.children('td:eq(6)').children('.detur').attr('value','');
                                    tr.children('td:eq(9)').html('');
                                    tr.children('td:eq(6)').children('.subtotal').attr('value','');
                            }
                    }

                    var row = $('.autocpl').length;
                    var harga = 0;
                    var embalage=0;
                    for (i = 1; i <= row; i++) {
                        if($('#kategori'+i).val()!='Embalase'){
                                harga = harga + parseFloat(currencyToNumber($('#subtotal'+i).val()==''?0:$('#subtotal'+i).val()));
                            }else{
                                embalage = embalage + parseFloat(currencyToNumber($('#subtotal'+i).val()==''?0:$('#subtotal'+i).val()));
                            }
                    }
                    //tr.children('td:eq(8)').children('input').attr('value',harga);
                    console.log("harga="+harga);
                    $('#total').attr('value',numberToCurrency2(harga));
                    $('#total_1').html(numberToCurrency2(harga));
                    var biaya_apt=$('#biaya_apt').val()==''?0:currencyToNumber($('#biaya_apt').val());
                    $('#biaya_embalage').attr('value', numberToCurrency2(embalage));
                    $('#biaya_embalage_1').html(numberToCurrency2(embalage));
                    $('#total_tagihan').attr('value', numberToCurrency2(harga+biaya_apt+embalage));
                    $('#total_tagihan_1').html(numberToCurrency2(harga+biaya_apt+embalage));
                    
            })

            //anak kolom ke 5 #tebus
            $(".tbody").delegate(" tr td:nth-child(5) input:first-child", "keyup",function(){
                    var tr=$(this).parent('td').parent('tr');
                    var hrg = parseFloat(currencyToNumber(tr.children('td:eq(6)').children('.harga').val()));
                    var tebus = parseFloat(tr.children('td:eq(4)').children('input').val());
                    var jumlah_r = parseFloat(tr.children('td:eq(3)').children('.jmlh').val());
                    var dosisracik = parseFloat(tr.children('td:eq(2)').children('.dosisracik').val());
                    var kekuatan = parseFloat(tr.children('td:eq(2)').children('.kekuatan').val());
                    var detur = jumlah_r - tebus;

                    if (x == 'bebas') {
                            var subtotal = '';
                            if (tebus != '') {
                                    var subtotal = numberToCurrency2(tebus * hrg);
                            }
                            tr.children('td:eq(5)').children('input[type=text]').attr('value',isNaN(tebus)?'':tebus);
                            tr.children('td:eq(9)').html(subtotal);
                            tr.children('td:eq(6)').children('.subtotal').attr('value',subtotal);
                            var sisa = tr.children('td:eq(5)').children('.sisa').val()*1;
                            if(tebus > sisa){
                                    var string = 'Sisa stok tidak cukup untuk dilakukan penjualan, sisa stok '+sisa+'';
                                    alert(string);
                                    $(this).val('');
                                    $(this).focus();
                                    tr.children('td:eq(9)').html('');
                                    $('#total').attr('value','');
                                    return false;
                            }
                    }
                    if (x == 'resep') {
                            var jmlpakai = (dosisracik * jumlah_r) / kekuatan;
                            if (isNaN(dosisracik) || dosisracik == '0') {
                                    var jmlpakai = tebus;
                            }
                            var subtotal = numberToCurrency2(tebus * hrg);
                            tr.children('td:eq(5)').children('input[type=text]').attr('value',isNaN(jmlpakai)?0:jmlpakai);
                            tr.children('td:eq(8)').html(isNaN(detur)?'':detur);
                            tr.children('td:eq(6)').children('.detur').attr('value',detur);
                            tr.children('td:eq(9)').html(subtotal);
                            tr.children('td:eq(6)').children('.subtotal').attr('value',subtotal);
                            if (detur < 0) {
                                    if($(this).attr('class')=='tebus_sisa'){
                                        alert('Tebus tidak boleh melebihi sisa tebusan');
                                    }else{
                                        alert('Tebus tidak boleh melebihi jumlah R !');
                                    }
                                    tr.children('td:eq(4)').children('input[type=text]').attr('value','');
                                    tr.children('td:eq(5)').children('input[type=text]').attr('value','');
                                    tr.children('td:eq(8)').html('');
                                    tr.children('td:eq(6)').children('.detur').attr('value','');
                                    tr.children('td:eq(9)').html('');
                                    tr.children('td:eq(6)').children('.subtotal').attr('value','');
                            }
                    }

                    var row = $('.autocpl').length;
                    var harga = 0;
                    var embalage=0;
                    for (i = 1; i <= row; i++) {
                            //alert($('#kategori'+i).val());
                            if($('#kategori'+i).val()!='Embalase'){
                                harga = harga + parseFloat(currencyToNumber($('#subtotal'+i).val()==''?0:$('#subtotal'+i).val()));
                            }else{
                                embalage = embalage + parseFloat(currencyToNumber($('#subtotal'+i).val()==''?0:$('#subtotal'+i).val()));
                            }
                    }
                    console.log("harga="+harga);
                    //tr.children('td:eq(8)').children('input').attr('value',harga);
                    $('#total').attr('value',numberToCurrency2(harga));
                    $('#total_1').html(numberToCurrency2(harga));
                    var biaya_apt=$('#biaya_apt').val()==''?0:currencyToNumber($('#biaya_apt').val());                    
                    $('#biaya_embalage').attr('value', numberToCurrency2(embalage));
                    $('#biaya_embalage_1').html(numberToCurrency2(embalage));
                    $('#total_tagihan').attr('value', numberToCurrency2(harga+biaya_apt+embalage));
                    $('#total_tagihan_1').html(numberToCurrency2(harga+biaya_apt+embalage));
            });
            
            //anak kolom ke 3 dosisracik
            $(".tbody ").delegate("tr td:nth-child(3) input:first-child", "keyup",function(){            
                    var tr=$(this).parent('td').parent('tr');
                    var hrg = parseFloat(currencyToNumber(tr.children('td:eq(6)').children('input[type=hidden]').val()));
                    var tebus = parseFloat(tr.children('td:eq(4)').children('input').val());
                    var jumlah_r = parseFloat(tr.children('td:eq(3)').children('.jmlh').val());
                    var dosisracik = parseFloat(tr.children('td:eq(2)').children('.dosisracik').val());
                    var kekuatan = parseFloat(tr.children('td:eq(2)').children('.kekuatan').val());
                    var detur = jumlah_r - tebus;
                    if (x == 'bebas') {
                            var subtotal = '';
                            if (tebus != '') {
                                    var subtotal = numberToCurrency2(tebus * hrg);
                            }
                            tr.children('td:eq(5)').children('input[type=text]').attr('value',isNaN(tebus)?'':tebus);
                            tr.children('td:eq(9)').html(subtotal);
                            tr.children('td:eq(6)').children('.subtotal').attr('value',subtotal);
                            //alert(hrg);
                    }
                    if (x == 'resep') {
                            var jmlpakai =(dosisracik * jumlah_r) / kekuatan;
                            if (isNaN(dosisracik) || dosisracik == '0') {
                                    var jmlpakai = tebus;
                            }
                            var subtotal = numberToCurrency2(tebus * hrg);
                            tr.children('td:eq(5)').children('input[type=text]').attr('value',isNaN(jmlpakai)?'':jmlpakai);
                            tr.children('td:eq(8)').html(isNaN(detur)?'':detur);
                            tr.children('td:eq(6)').children('.detur').attr('value',detur);
                            tr.children('td:eq(9)').html(subtotal);
                            tr.children('td:eq(6)').children('.subtotal').attr('value',subtotal);
                            if (detur < 0) {
                                    alert('Tebus tidak boleh melebihi jumlah R !');
                                    tr.children('td:eq(4)').children('input[type=text]').attr('value','');
                                    tr.children('td:eq(5)').children('input[type=text]').attr('value','');
                                    tr.children('td:eq(8)').html('');
                                    tr.children('td:eq(6)').children('.detur').attr('value','');
                                    tr.children('td:eq(9)').html('');
                                    tr.children('td:eq(6)').children('.subtotal').attr('value','');
                            }
                    }

                    var row = $('.autocpl').length;
                    var harga = 0;
                    for (i = 1; i <= row; i++) {
                            harga = harga + parseFloat(currencyToNumber($('#subtotal'+i).val()==''?0:$('#subtotal'+i).val()));
                    }

                    $('#total').attr('value',numberToCurrency2(harga));
                    $('#total_1').html(numberToCurrency2(harga));
                    var biaya_apt=$('#biaya_apt').val()==''?0:currencyToNumber($('#biaya_apt').val());
                    $('#total_tagihan').attr('value', numberToCurrency2(parseFloat(harga)+biaya_apt));
                    $('#total_tagihan_1').html(numberToCurrency2(parseFloat(harga)+biaya_apt));
            })

            $(".tbody").delegate("tr td:nth-child(1) input:first-child", "keyup",function(){
                            var jml_resep = $(this).val();
                            var adm_apotek= $('#hidebiayaapoteker').val()
                            var nilai = jml_resep * adm_apotek;
                            //alert(nilai);
                            if (jml_resep != '') {
                                $('#biaya_apt').attr('value',numberToCurrency2(nilai));
                                $('#biaya_apt_1').html(numberToCurrency2(nilai));
                                var total=$('#total').val()==''?0:currencyToNumber($('#total').val());
                                $('#total_tagihan').attr('value', numberToCurrency2(total+nilai));
                                $('#total_tagihan_1').html(numberToCurrency2(total+nilai));
                            }
                            
                        })
               $(".hasil_penghitungan").delegate('#biaya_apt','keyup',function(){
                    var total=currencyToNumber($('#total').attr('value'));
                    var biaya_apt=currencyToNumber($(this).attr('value'));
                    var embalage=currencyToNumber($('#biaya_embalage').attr('value'));
                    var diskon=currencyToNumber($('#diskon').attr('value'));
                    diskon2=isNaN(diskon)||diskon==''?0:diskon;
                    var total_biaya=total+biaya_apt+embalage-diskon2;
                    $("#total_tagihan").attr('value',numberToCurrency2(total_biaya));
                    $("#total_tagihan_1").html(numberToCurrency2(total_biaya));
                    $(this).attr('value',numberToCurrency2(biaya_apt));
                    //$('#hidebiayaapoteker').attr('value',biaya_apt);

                });         
                
                $(".hasil_penghitungan").delegate('#diskon','keyup',function(){ 
                    var total=currencyToNumber($('#total').attr('value'));  
                    var diskon=currencyToNumber($(this).attr('value'));
                    var biaya_apt=currencyToNumber($('#biaya_apt').attr('value'));                    
                    var embalage=currencyToNumber($('#biaya_embalage').attr('value'));
                    var diskon2=isNaN(diskon)||diskon==''?0:diskon;
                    var total_biaya=total+biaya_apt+embalage;
                    if(diskon2>total_biaya){                        
                        alert('Diskon melebihi total tagihan');
                        $('#diskon').attr('value',0);
                        $("#total_tagihan").attr('value',numberToCurrency(total_biaya));
                        $("#total_tagihan_1").html(numberToCurrency(total_biaya));
                    }else{                                              
                        total_biaya=total_biaya-diskon2;
                        $("#total_tagihan").attr('value',numberToCurrency(total_biaya));
                        $("#total_tagihan_1").html(numberToCurrency(total_biaya));
                        $('#diskon').attr('value',numberToCurrency(diskon2));
                    }

                    //$('#hidebiayaapoteker').attr('value',biaya_apt);
                });
                
                });
                
		
        $('#norm').focus(function() { if (x == null) alert('Pilih jenis terlebih dahulu');  });

        /*$('#nopenjualan').autocomplete("<?//= app_base_url('/inventory/search?opsi=nopenjualan') ?>",
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
                var str='<div class=result>'+data.nopenjualan+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nopenjualan);
            $('#noresep').attr('value',data.no_resep);
            $('#dokter').attr('value',data.dokter);
            $('#iddokter').attr('value',data.id_dokter);
            $('#idpenduduk').attr('value',data.id_penduduk_pasien);
            $('#norm').attr('value',data.norm);
            $('#nama').attr('value',data.nama_pasien);
            $('#idkelas').attr('value', data.id_kelas );
            $('#kelas').attr('value', data.nama_kelas);
			$('input[name=saveresep]').removeAttr('disabled');
                        $('input[name=kitir]').removeAttr('disabled','disabled');
            $('#addnewrow').attr('disabled','disabled');
            $.ajax({
                    url: "<?//=  app_base_url('inventory/penjualan-load-resep')?>",
                    cache: false,
                    data:'id='+data.no_resep+'&kelas='+data.id_kelas,
                    success: function(msg){
                        $('.tbody').html(msg);

                        //$('#awal').attr('value',hasil[0].tanggal);
                        $(".tbody tr td:nth-child(1) input:first-child").keyup();
                        $(".tbody tr td:nth-child(6) input:first-child").keyup();
                        $('input[name=kitir]').attr('disabled','disabled');
                        //$('input[name=tombol]').removeAttr("disabled","disabled");
                        //window.opener.document.forms[0].temp_penjualan.value=nopenjualan;
                    }
                });
        })*/
        
        $('#noresep').autocomplete("<?= app_base_url('/inventory/search?opsi=noresep') ?>",
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
                var str='<div class=result>'+data.no_resep+', <i>'+data.nama_pasien+', '+data.dokter+'</i><br>'+data.alamat_jalan+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#nopenjualan').attr('value',data.nopenjualan);
            $(this).attr('value',data.no_resep);
            $('#dokter').attr('value',data.dokter);
            $('#iddokter').attr('value',data.id_dokter);
            $('#idpenduduk').attr('value',data.id_penduduk_pasien);
            $('#norm').attr('value',data.norm);
            $('#nama').attr('value',data.nama_pasien);				
            $('#idkelas').attr('value', data.id_kelas );
            $('#kelas').attr('value', data.nama_kelas);
			$('input[name=saveresep]').removeAttr('disabled');
                        $('input[name=kitir]').removeAttr('disabled','disabled');
            $('#addnewrow').attr('disabled','disabled');
            
            $.ajax({
                    url: "<?=  app_base_url('inventory/penjualan-load-resep')?>",
                    cache: false,
                    data:'id='+data.no_resep+'&kelas='+data.id_kelas,
                    success: function(msg){
                        var data=jQuery.parseJSON(msg);
                        $('.tbody').html(data.data);
                        
                       //console.log(msg);
                        //$('#awal').attr('value',hasil[0].tanggal);                        
                        $(".tbody tr td:nth-child(1) input:first-child").keyup();
                        $(".tbody tr td:nth-child(6) input:first-child").keyup();                        
                        $('input[name=kitir]').attr('disabled','disabled');   
                        $("#biaya_apt").attr('value', data.biaya_apt);
                        $("#biaya_apt_1").html(data.biaya_apt);
                        //$("#biaya_apt").keyup();
                        //$('input[name=tombol]').removeAttr("disabled","disabled");
                        //window.opener.document.forms[0].temp_penjualan.value=nopenjualan;
                    }
                });
            //setDisabled();
					
        }
     );
        $('#dokter').autocomplete("<?= app_base_url('/admisi/search?opsi=dokter_rm') ?>",

            {
					
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama// nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                   formatItem: function(data,i,max){
                                var sip = data.sip!='NULL'?data.sip:'';
                                var str='<div class=result>Nama :<b>'+data.dokter+'</b><br /><i>SIP</i>: '+sip+'<br /><i>Alamat</i>: '+data.alamat_jalan+'<i> Kecamatan</i>: '+data.kecamatan+'<i> Kabupaten</i>: '+data.kabupaten+'<i> Provinsi</i>: '+data.provinsi+'</div>';
                                return str;
                            },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
           }).result(
            function(event,data,formated){
                $(this).attr('value',data.dokter);
                $('#iddokter').attr('value',data.id_dokter);
                setDisabled();
				
        });
        $('#nama').autocomplete("<?= app_base_url('/inventory/search?opsi=nama-penjualan') ?>",
        {
                extraParams:{
                        jenis: function() { return x }
                },
                parse: function(data){
                    var parsed = [];
                    for (var i=0; i < data.length; i++) {
                        parsed[i] = {
                            data: data[i],
                            value: data[i].nama_pas // nama field yang dicari
                        };
                    }
                    return parsed;
                },
                formatItem: function(data,i,max){

            if (data.id_pasien == null) {
                var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
            } else {
                var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
            }
            return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var kls=(data.nama_kelas!=null&&data.nama_kelas!='')?data.nama_kelas:'Tanpa Kelas';
            var id_kls=(data.id_kelas!=null&&data.id_kelas!='')?data.id_kelas:1;    
            console.log(data.nama_kelas);
            $('#norm').attr('value',data.id_pasien);
				var id_pasien=data.id_pasien;
                    $.ajax({
                        url: "<?= app_base_url('inventory/search?opsi=asuransi_penjualan')?>",                        
                        cache:false,
                        data: "&q=1&id_pasien="+id_pasien,
                        dataType:'json',
                        success:function(data){                            
                            var jml_asuransi=data.length;
                            if(jml_asuransi>1){
                                var str="<ol style='margin-left:0;padding-left:14px;'>";
                                for(var i=0;i<jml_asuransi;i++){
                                    str+="<li style='font-size:12px;padding-bottom:2px'>"+data[i].nama_asuransi+"</li>";
                                }
                                str+="</ol>";
                                $('.asuransi').html(str);
                            }else if(jml_asuransi>0){
                                $('.asuransi').html(data[0].nama_asuransi);
                            }
                        }
                    });
            $(this).attr('value',data.nama_pas);
            $('#idpenduduk').attr('value',data.id_penduduk);
            $('#idkelas').attr('value', id_kls );
            $('#kelas').attr('value', kls);
	    $('input[name=saveresep]').removeAttr('disabled');
            $('input[name=kitir]').removeAttr('disabled');
            $('#addnewrow').removeAttr('disabled');
            setDisabled();
            //$('#addnewrow').click();
            }
        );
		
        $('#norm').autocomplete("<?= app_base_url('/inventory/search?opsi=noRm') ?>",
        {
					extraParams:{
						jenis: function() { return x; }
					},
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama_pas // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        
                if (data.id_pasien == null) {
                    var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                } else {
                    var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                }
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var kls=(data.nama_kelas!=null&&data.nama_kelas!='')?data.nama_kelas:'Tanpa Kelas';
            var id_kls=(data.id_kelas!=null&&data.id_kelas!='')?data.id_kelas:1;    
            $(this).attr('value',data.id_pasien);
            $('#nama').attr('value',data.nama_pas);
            $('#idpenduduk').attr('value',data.id_penduduk);
            $('#idkelas').attr('value', id_kls );
            $('#kelas').attr('value', kls);
				var id_pasien=data.id_pasien;
                    $.ajax({
                        url: "<?= app_base_url('inventory/search?opsi=asuransi_penjualan')?>",                        
                        cache:false,
                        data: "&q=1&id_pasien="+id_pasien,
                        dataType:'json',
                        success:function(data){                            
                            var jml_asuransi=data.length;
                            if(jml_asuransi>1){
                                var str="<ol style='margin-left:0;padding-left:14px;'>";
                                for(var i=0;i<jml_asuransi;i++){
                                    str+="<li style='font-size:12px;padding-bottom:2px'>"+data[i].nama_asuransi+"</li>";
                                }
                                str+="</ol>";
                                $('.asuransi').html(str);
                            }else if(jml_asuransi>0){
                                $('.asuransi').html(data[0].nama_asuransi);
                            }
                        }
                    });
            $('input[name=saveresep]').removeAttr('disabled');
            $('input[name=kitir]').removeAttr('disabled');
            $('#addnewrow').removeAttr('disabled');
            setDisabled();
            //$('#addnewrow').click();
        }
    );
    
    //sing ngo addnew row barang.. sing ngo addnew row barang.. sing ngo addnew row barang.. sing ngo addnew row barang.. sing ngo addnew row barang.. sing ngo addnew row barang..(single add)

    counter = 1;
    barisdata = 1;
    
        
        
        $("#addnewrow").click(function(){
            
            
            kelas = $("#idkelas").val();
			
            string = "<tr class='barang_tr'>" +
                " <td align=center><input type=text maxlength=2 name=resep"+counter+" id=resep"+counter+" onKeyup='Angka(this)' autocomplete=off style='width:100%;'/></td>" +
                " <td align=center><input type=text name=databarang"+counter+" id=databarang"+counter+" autocomplete=off class=autocpl style='width:300px;'/>" +
                " <input type=hidden name=iddatabarang"+counter+" id=iddatabarang"+counter+" class=iddatabarangs /></td> " +
                " <td align=center><input type=text name=dosisracik"+counter+" id=dosisracik"+counter+" class=dosisracik style='width:50px' onKeyup='Desimal(this)'/> " +
                " <input type=hidden name=kekuatan"+counter+" id=kekuatan"+counter+" class=kekuatan>\n\
                  <input type=hidden name=kategori"+counter+" id=kategori"+counter+" class=kategori></td>" +
                " <td align=center><input type=text name=jmlh"+counter+" id=jmlh"+counter+" onKeyup='Desimal(this)' autocomplete=off class=jmlh style='width:30px;'/> " +
                " <input type=hidden name=idpacking"+counter+" id=idpacking"+counter+" class=packing /><input type=hidden name=batch"+counter+" id=ibatch"+counter+" class=batch /></td> " +
                " <td align=center><input type=text name=tebus"+counter+" style='width:75%;' id=tebus"+counter+" class=tebus autocomplete=off onKeyup='Desimal(this)'/></td> " +
                " <td align=center><input type=text name=jmlpakai"+counter+" id=jmlpakai"+counter+" maxlength=3 style='width:100%;' autocomplete=off readonly/><input type='hidden' id='sisa"+counter+"' class='sisa'> </td>" +
                " <td> " +
                    " <input type=hidden size=10 name=harga"+counter+" id=harga"+counter+" class='harga' /> " +
                    " <input type=hidden name=detur"+counter+" id=detur"+counter+" class='detur' />" +
                    " <input type=hidden size=8 name=subtotal"+counter+" id=subtotal"+counter+" class='subtotal' />" +
                " <select name=aturpakai"+counter+" id=aturpakai"+counter+"><option value=''>Aturan pakai ..</option> " +
                " <?php foreach ($aturan_pakai as $row) { ?> <option value='<?= $row['id'] ?>'><?= $row['nama'] ?></option> <?php } ?></select></td> " +
                " <td align=right></td> " +
                " <td align=center></td> " +
                " <td align=right></td> " +
                " <td align=center><input type=hidden name=jmldata value="+barisdata+" /> " +
                " <input type=button value=Hapus onClick='deleteMe("+counter+",this)' title=Delete class=tombol /> " +
                " <input type=hidden name=margin"+counter+" id=margin"+counter+" class=margin /></td>" +
                " </tr>";

            
            if(startup){
                $("#penjualan-resep").append(string);               
            }else{
                cekFormAtas();
                
                if(setDisabled()){
                    $("#penjualan-resep").append(string);
                    $('input[name=saveresep]').removeAttr('disabled','disabled');
                    if($('#temp_penjualan').val()==""){
                        $('input[name=kitir]').removeAttr('disabled','disabled');
                    } else{
                        $('input[name=kitir]').attr('disabled','disabled');
                    }
                }
            };
            
            if (x == 'bebas') {
                $('#resep'+counter).attr('disabled','disabled');
                $('#dosisracik'+counter).attr('disabled','disabled');
                $('#jmlh'+counter).attr('disabled','disabled');
                $('#jmlpakai'+counter).attr('disabled','disabled');
                $('#detur'+counter).attr('disabled','disabled');
                $('#aturpakai'+counter).attr('disabled','disabled');
            }
            $('.barang_tr:eq('+(counter-1)+')').addClass((counter % 2 == 1)?'even':'odd');
            $(".tbody tr td:nth-child(2) input:first-child").trigger('acEvent');

            
            barisdata++;
            counter++;
		
        });
        
        $("#addnewrow").removeAttr("disabled","disabled");
        for(var i=1;i<=2;i++){
            $("#addnewrow").click();
        }
        setStartupDisabled();
        $("#addnewrow").attr("disabled","disabled");
        
        $("input[name=saveresep]").click(function(event){
            event.preventDefault();
            if(cekdata()){
                //$("#nopenjualan").removeAttr("disabled");
                $("#noresep").removeAttr("disabled");
                $('form').unbind('submit');
                $("input[name=saveresep]").unbind('click').click();
            }
        });
        
        
        
        $("input[name=kitir]").click(function(event){
            //event.preventDefault();
            //open('','results', 'width=600px, height=500px, scrollbars=1');
            var kitir=$(this);
            var ke=kitir.data('events');
            //alert(ke);
            //if(ke!=null&&typeof(ke.click)!==undefined){           
            if(cekdata()){
                $('form').submit(function(){
                    var formdata=$(this).serialize();
                    //alert(formdata);
                    $("#loader").show();
                    formdata+='&kitir=1';
                    $.ajax(
                    {
                        type:'POST',
                        url:url_control_temp,
                        data:formdata,
                        success:function(data){
                           var hasil=jQuery.parseJSON(data);
                           var pesan='';
                           if(hasil){
                               $('#temp_penjualan').attr("value",hasil.id);
                               pesan="<div class='ui-state-highlight ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'><p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span><strong>Info!</strong> Proses transaksi berhasil dilakukan</p></div>";                               
                               $('.pesan').html(pesan);
                               $('.pesan').show();
                               $("#loader").hide();
                               $("html,body").scrollTop(0);
                                //alert(hasil.id+""+hasil.kelas);
                                window.open('print/nota-temp-penjualan?code='+hasil.id+'&kelas='+hasil.kelas, 'MyWindow', 'width=600px, height=500px, scrollbars=1');
                                $('input[name=kitir]').unbind('click');
                                $('input[name=kitir]').attr('disabled','disabled');
                                $('input[name=saveresep]').removeAttr('disabled');
                                $('.cetak_kitir').attr('id',hasil.id);
                                $('.cetak_kitir').removeAttr('disabled');                             
                           }else{
                               pesan="<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'><p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><strong>Alert:</strong> Proses transaksi gagal </p></div>";
                                $('.pesan').html(pesan);
                                $('.pesan').show();
                                $("#loader").hide();
                                $("html,body").scrollTop(0);
                           }
                        }
                    }
                    );
                    return false;
                });
            }else{
                event.preventDefault();
            }
        });
        
        $('.cetak_kitir').click(
            function(){
                var id=$(this).attr('id');
                window.open('print/nota-temp-penjualan?code='+id+'&kelas=', 'MyWindow', 'width=600px, height=500px, scrollbars=1');
            }
        );
        
        
        $('input[name=cari]').click(
            function(){                
                window.open('<?=app_base_url('inventory/penjualan-detail')?>', 'MyWindow', 'width=600px, height=500px, scrollbars=1');
            }
        );
        
        
    })
    
</script>
<script type="text/javascript">
    function deleteMe(count,el){
            
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penjualan=$('.barang_tr');
        var countPenjualanTr=penjualan.length;
        var harga = 0;
        for (i = 1; i <= countPenjualanTr; i++) {
            harga = harga + parseFloat(currencyToNumber($('#subtotal'+i).val()));
        }
        $('#total').attr('value',numberToCurrency2(harga));
        if (countPenjualanTr == 0) {
            $('#total').attr('value','');
            $('#total_1').html('');
            $('input[name=saveresep]').attr('disabled','disabled');
            $('input[name=kitir]').attr('disabled','disabled');
        }
        for(var i=0;i<countPenjualanTr;i++){
            //$('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
            $('.barang_tr:eq('+i+')').children('td:eq(10)').children('input[name=jmldata]').attr('value',i+1);
            $('.barang_tr:eq('+i+')').children('td:eq(1)').children('.iddatabarangs').removeAttr('id');
            $('.barang_tr:eq('+i+')').children('td:eq(1)').children('.iddatabarangs').removeAttr('name');
			  
        }
        for(var i=0;i<countPenjualanTr;i++){
            $('.barang_tr:eq('+i+')').children('td:eq(1)').children('.iddatabarangs').attr('id','iddatabarang'+(i+1));
            $('.barang_tr:eq('+i+')').children('td:eq(1)').children('.iddatabarangs').attr('name','iddatabarang'+(i+1));
            $('.barang_tr:eq('+i+')').removeClass('even');
            $('.barang_tr:eq('+i+')').removeClass('odd');
            $('.barang_tr:eq('+i+')').addClass(((i+1) % 2 == 1)?'even':'odd');
        }
        counter --;
        barisdata --;
            
    }
    
    function requiredField(jenis){
        if(jenis=='resep'){
            $('fieldset:eq(0) tr:eq(4) td:first').html('No. Resep*');
            $('fieldset:eq(0) tr:eq(5) td:first').html('Tgl Resep*');
            $('fieldset:eq(0) tr:eq(6) td:first').html('Nama Dokter*');
            $('fieldset:eq(0) tr:eq(7) td:first').html('No. R.M*');
            $('fieldset:eq(0) tr:eq(8) td:first').html('Nama Pasien/Pembeli*');
            $('#penjualan-resep th:eq(0)').html('No. R/ *')
            $('#penjualan-resep th:eq(1)').html('Packing Barang *')
            $('#penjualan-resep th:eq(2)').html('Dosis Racik *')
            $('#penjualan-resep th:eq(3)').html('Jml per R/ *')
            $('#penjualan-resep th:eq(4)').html('JML Tebus *')
            $('#penjualan-resep th:eq(5)').html('JML Pakai *')
            $('#penjualan-resep th:eq(6)').html('Aturan Pakai *')

        }else{
            $('fieldset:eq(0) tr:eq(4) td:first').html('No. Resep');
            $('fieldset:eq(0) tr:eq(5) td:first').html('Tgl Resep');
            $('fieldset:eq(0) tr:eq(6) td:first').html('Nama Dokter');
            $('fieldset:eq(0) tr:eq(7) td:first').html('No. R.M');
            $('fieldset:eq(0) tr:eq(8) td:first').html('Nama Pasien/Pembeli');
            $('#penjualan-resep th:eq(0)').html('No. R/')
            $('#penjualan-resep th:eq(1)').html('Packing Barang *')
            $('#penjualan-resep th:eq(2)').html('Dosis Racik')
            $('#penjualan-resep th:eq(3)').html('Jml per R/')
            $('#penjualan-resep th:eq(4)').html('JML Tebus *')
            $('#penjualan-resep th:eq(5)').html('JML Pakai')
            $('#penjualan-resep th:eq(6)').html('Aturan Pakai')

        }
    }
    
    function loadData(id,kelas){
       $.ajax({
            url: "<?= app_base_url('inventory/search?opsi=kodetemppenjualan') ?>",
            cache: false,
            data:"q="+id,
            success: function(data){
                var hasil=jQuery.parseJSON(data);
                
                if(hasil){
                var kls=hasil[0].kelas!=null&&hasil[0].kelas!=''?hasil[0].kelas:'Tanpa Kelas';
                var id_kls=hasil[0].id_kelas!=null&&hasil[0].id_kelas!=''?hasil[0].id_kelas:1;
                //$('#nopenjualan').attr('disabled','disabled');
                $('#dokter').attr('value',hasil[0].nama_dokter);
                $('#iddokter').attr('value',hasil[0].id_dokter);
                $('#norm').attr('value',hasil[0].no_rm);
                $('#nama').attr('value',hasil[0].nama_pembeli);
                $('#idpenduduk').attr('value',hasil[0].id_pembeli);
                $('#temp_penjualan').attr('value',hasil[0].id);
                $('#temp_resep').attr('value',hasil[0].id_resep);
                $('#kelas').attr('value',kls);
                $('#idkelas').attr('value',id_kls);
                $('#catatan').attr('value',hasil[0].catatan);
                //alert('alert');
                
                $.ajax({
                    url: "<?=  app_base_url('inventory/penjualan-detail-table')?>",
                    cache: false,
                    dataType:'json',
                    data:'id='+id+kelas+'&mode=load',
                    success: function(msg){
                        $('.tbody').html(msg.data);
                        if(hasil[0].jenis=='Resep'){
                            //$('#bebas').removeAttr('checked');
                            //$('#resep').attr('checked',true);
                            $('#resep').attr('checked','checked');
                            $('#biaya_apt').removeAttr('readonly');
                            //setDisabled();
                        }else{
                            //$('#resep').removeAttr('checked');
                            $('#bebas').attr('checked','checked');
                            //$('#bebas').click();
                            //setDisabled();
                        }
                        
                        $('#awal').attr('value',hasil[0].tanggal);
                        $(".tbody tr td:nth-child(2) input:first-child").trigger('acEvent');
                        //$(".tbody tr td:nth-child(1) input:first-child").keyup();
                        //$(".tbody tr td:nth-child(6) input:first-child").keyup();                        
                        //$("#biaya_apt").keyup();
                        $("#biaya_apt").attr('value', numberToCurrency(isNaN(msg.biaya_apt)?0:msg.biaya_apt));
                        $("#biaya_apt_1").html(numberToCurrency(isNaN(msg.biaya_apt)?0:msg.biaya_apt));
                        $("#total").attr('value', numberToCurrency(msg.total));
                        $("#total_1").html(numberToCurrency(msg.total));
                        $("#diskon").attr('value', numberToCurrency(msg.diskon));
                        //$("#diskon_1").html(numberToCurrency(msg.diskon));
                        $("#total_tagihan").attr('value', numberToCurrency(msg.total_tagihan));
                        $("#total_tagihan_1").html(numberToCurrency(msg.total_tagihan));
                        //$("#diskon").keyup();
                        $('input[value=Hapus]').click(function(event){
                            deleteMe($(this).index(),this);
                        });
                        $('input[name=kitir]').attr('disabled','disabled');
                        //$('input[name=tombol]').removeAttr("disabled","disabled");
                        //window.opener.document.forms[0].temp_penjualan.value=nopenjualan;
                    }
                });
                $('input[name=saveresep]').removeAttr('disabled');
                }
                //$('input[name=tombol]').removeAttr("disabled","disabled");
                //window.opener.document.forms[0].temp_penjualan.value=nopenjualan;
            }
        });
               
    }
    
    function cekdata(data) {	
        if($('#tanggal').val()==''){
            alert('Tanggal transaksi masih kosong');
            $('#tanggal').focus();
            return false;
        }
        else if(parseDate($('#tanggal').val())==null){
            alert('Tanggal transaksi belum berformat dd/mm/yyyy');
            $('#tanggal').focus();
            return false;
        }
        
        if($('#awal').val()==''){
            alert('Tanggal resep masih kosong');
            $('#awal').focus();
            return false;
        }
        else if(parseDate($('#awal').val())==null){
            alert('Tanggal resep belum berformat dd/mm/yyyy');
            $('#awal').focus();
            return false;
        }
        
        
        
        
        var row = $('.barang_tr').length;
        
        for (i = 1; i <= row; i++) {
            if($('#iddatabarang'+i).val() != ""||i==1){
                if (x == 'resep'&&$('#kategori'+i).val() != "Embalase") { // jika jenis transaksi penjualan resep
                    if ($('#resep'+i).val() == "") {
                        alert("No R/ tidak boleh kosong !");
                        $('#resep'+i).focus();
                        return false;
                    }
                    if ($('#iddatabarang'+i).val() == "") {
                        alert("Nama barang tidak boleh kosong !");
                        $('#databarang'+i).focus();
                        return false;
                    }
                    if ($('#jmlh'+i).val() == "") {
                        alert("Jumlah per R/ tidak boleh kosong !");
                        $('#jmlh'+i).focus();
                        return false;
                    }
                    if ($('#aturpakai'+i).val() == "") {
                        alert("Aturan pakai harus diisi !");
                        $('#aturpakai'+i).focus();
                        return false;
                    }
                }
                if ($('#iddatabarang'+i).val() == "") {
                    alert("Nama barang tidak boleh ada yang kosong !");
                    $('#databarang'+i).focus();
                    return false;
                }
                if ($('#tebus'+i).val() == "") {
                    alert("Tebus tidak boleh kosong !");
                    $('#tebus'+i).focus();
                    return false;
                }
               
            }
        }
        
        if (row == 0) {
                alert("Belum ada barang yang terpilih, silahkan tekan tombol Tambah R/ untuk menambah penjualan !");
                $('#addnewrow').focus();
                return false;
        }
        else if($('#biaya_apt').val() == ""){
            alert('Biaya apoteker harap diisi');
            $('#biaya_apt').focus();
            return false;
        }
        return true;
		
        //return false;
        //var row = $('#').val();
    }
	
</script>
<form action="<?= app_base_url('inventory/control/penjualan-resep') ?>" method="post" name="fomname" onSubmit="//return cekdata(this)">
<?//= isset($pesan)?$pesan:NULL; ?>
<div class='ui-widget pesan' id="pesan"></div>    
<div class="data-input">
<table width="100%">
<tr>    
<td width="50%" valign="top">    
<fieldset><legend>Form Penjualan</legend>
                <table width="100%">
                <tr><td width="35%">No. Penjualan</td><td></td><td>
                        <!--<input type="text" name="nopenjualan" id="nopenjualan" value="<?php// if ($nopenjualan == null) echo "1"; else echo "$nopenjualan"; ?>" />-->
                        <input type="hidden" name="nopenjualan" id="nopenjualan" value="<?php if ($nopenjualan == null) echo "1"; else echo "$nopenjualan"; ?>" />
                        <?php if ($nopenjualan == null) echo "1"; else echo "$nopenjualan"; ?>
                    </td>
		<tr><td width="35%">Pegawai</td><td></td><td><?= $_SESSION['nama'] ?></td></tr>
		<tr><td width="35%">Tgl Transaksi*</td><td></td><td><input type="text" name="transaksi" id="tanggal" value="<?= date("d/m/Y") ?>" style="min-width:1em;" /><input type="button" name="cari" value="Cari Temp"/>   </td></tr>
                <tr>
			<td>Jenis*</td><td></td><td>
			Bebas <input type="radio" name="jenis" value="Bebas" id="bebas" /> &nbsp; &nbsp;
			Resep <input type="radio" name="jenis" value="Resep" id="resep" /></td>
		</tr>
		<tr><td width="35%">No. Resep</td><td></td><td><input type="text" name="noresep" id="noresep" value="<?php if ($baru == null) echo "1"; else echo "$baru"; ?>" disabled />
                                         
                    </td></tr>
                <tr><td width="35%">Tgl Resep</td><td></td><td><input type="text" name="tglresep" value="<?= date("d/m/Y") ?>" id="awal" style="min-width:1em;" disabled/></td></tr>
		<tr><td width="35%">Nama Dokter</td><td></td><td><input type="text" name="dokter" id="dokter" disabled /><input type="hidden" name="iddokter" id="iddokter" /></td></tr>
		<tr><td width="35%">No. R.M</td><td></td><td><input type="text" name="norm" id="norm" /></td></tr>		
		<tr><td width="35%">Nama Pasien/Pembeli</td><td></td><td><input type="text" name="nama" id="nama" /><input type="hidden" name="idpenduduk" id="idpenduduk" /></td></tr>
         	<tr><td width="35%">Produk Asuransi</td><td></td><td><span style="font-size: 12px;padding-top: 5px;" class="asuransi"></span></td></tr>
		<tr><td>Kelas</td><td></td><td><input type="text" id="kelas" style="border:none" readonly="readonly" />
		<input type="hidden" name="kelas" id="idkelas" style="border:none" />
                <input type="hidden" name="temp_penjualan" id="temp_penjualan"/>    
                <input type="hidden" name="temp_resep" id="temp_resep"/>
                </td></tr>
                <tr><td width="35%">Catatan</td><td></td><td><textarea name="catatan" id="catatan" ></textarea></td></tr>
		<tr>
                <td></td><td></td><td><input type="button" class="tombol" id="addnewrow" value="Tambah R/" disabled="disabled">
                </td>
		</tr>
	        </table>
</fieldset>
</td>
<td valign="top">
<fieldset id="perhatian">
        <legend>Perhatian</legend>
        <ul>
            <li style="list-style-type:lower-roman">Untuk R/ Tunggal (bukan racikan), kolom NO. R/ diisi nomor R/ Tunggal sedang DOSIS RACIK tidak perlu diisi.</li>
            <li style="list-style-type:lower-roman">Untuk R/ Racikan , NO. R/ diisi dengan nomor R/ yang sama dengan baris sebelumnya <br/>yang merupakan satu R/ racikan.</li>
            <li style="list-style-type:lower-roman">Untuk pemakaian Embalage dimasukkan juga sebagai baris barang yang akan di transaksikan kolom nama barang, <br/>jumlah tebus & jumlah pakai saja yang diisi.</li>
        </ul>
</fieldset>
</td>
</tr>
</table>
</div>

   <div class="data-list tabelflexibel">
        <table width="100%" id="penjualan-resep" class="table-input" cellspacing=0>
            <thead>
                <tr style="background: #F4F4F4; height:20px; white-space:nowrap;" cellspacing=0>
                    <th style='width:3%;'>R/</th>
                    <th style='width:25%;'>Packing Barang</th>
                    <th style='width:3%;'>Dosis Racik</th>
                    <th style='width:3%;'>Jml per R/</th>
                    <th style='width:3%;'>JML Tebus</th>
                    <th style='width:3%;'>Jml Pakai</th>
                    <th style='width:15%;'>Aturan Pakai</th>
                    <th style='width:5%;'>Harga @</th>
                    <th style='width:5%;'>Detur</th>
                    <th style='width:10%;'>Sub Total</th>
                    <th style='width:3%;'>Aksi</th>
                </tr>
            </thead>
            <tbody class="tbody">                

            </tbody>

        </table>
    </div>

<table width="100%" class="hasil_penghitungan">
	<tr>
            <td colspan="8" width="75%">&nbsp;</td><td>Total (Rp.)</td><td align="center">
                <!--<input type="text" id="total" name="total" style="border:none;" class="right" readonly />-->
                <span id="total_1" class="right"></span>
                <input type="hidden" id="total" name="total"/>
            </td><td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="8" width="75%">&nbsp;</td><td>Jasa Pelayanan (Rp.)</td><td align="center">
                <input type="hidden" id="hidebiayaapoteker" value="<?= $biaya_apt[0]['nilai'] ?>" />
                <!--<input type="text" id="biaya_apt" name="biaya_apt" style="border:none;" class="right" onkeyup="Angka(this)" />-->
                <span id="biaya_apt_1" class="right"></span>
                <input type="hidden" id="biaya_apt" name="biaya_apt"/>
            </td><td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="8" width="75%">&nbsp;</td><td>Jasa Sarana (Rp.)</td><td align="center">                
                <!--<input type="text" id="biaya_embalage" name="biaya_embalage" style="border:none;" class="right" readonly />-->
                <span id="biaya_embalage_1" class="right"></span>
                <input type="hidden" id="biaya_embalage" name="biaya_embalage" />
            </td><td colspan="4">                
            </td>        
        </tr>
        <tr>
            <td colspan="8" width="75%">&nbsp;</td><td>Diskon (Rp.)</td><td align="left">                
                <input type="text" id="diskon" name="diskon" style="border:none;" class="right" onkeyup="Angka(this)" size="15"/>                
            </td><td colspan="4">                
            </td>        
        </tr>
        <tr>
            <td colspan="8" width="75%"></td><td><b>Total Tagihan (Rp.)</b></td>
            <td align="center">
                <!--<input type="text" name="total_tagihan" id="total_tagihan" style="border:none;font-weight: bolder;margin-right: 10px" class="right" readonly=""/>-->
                <span id="total_tagihan_1" class="right"></span>
                <input type="hidden" id="total_tagihan" name="total_tagihan"/>
            </td><td colspan="4"></td>
        </tr>
    <tr>

        <td colspan="8">&nbsp;</td><td colspan="4">
            <div id="loader" style="background-image:url('<?=  app_base_url('/assets/images/contentload.gif')?>');background-repeat: no-repeat;width:100px;height: 35px;display: block;padding-left: 38px;padding-top: 10px;display: none;">
            Menyimpan data</div>
            <input type="submit" name="kitir" value="Simpan Temp" disabled="disabled"/>
            <input type="submit" name="saveresep" disabled value="Simpan"  />
            <input type="button" value="Batal" onclick=location.href="<?= app_base_url('inventory/penjualan') ?>"  />
            <input type="submit" class="cetak_kitir" name="cetak_kitir" value="Cetak Kitir Temp" disabled="disabled"/>
        </td>
    </tr>
</table>    
</form>