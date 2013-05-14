<script type="text/javascript">
    $(function() {
        $('#noRm').focus();
        tambah_baris();
        tambah_baris();
        var kunjungan= $('#noKunjungan').val();
        if (kunjungan == '') {
            $('.service').attr('disabled','disabled');
        }
		
        $('#noRm').autocomplete("<?= app_base_url('/admisi/search?opsi=billing') ?>",
        {
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
                $("#alamat").html('');
                $(".noRm").html('');
                $(".noBilling").html('');
                $("#noBilling").val('');
				  $("#bayar").val('');
                //$('.barang_tr').remove();
                var str='<div class=result>'+data.id_pasien+' '+data.nama_pas+'<br/>No. Billing: '+data.id_billing+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
		
            $(this).attr('value',data.nama_pas);
            $("#alamat").html(data.alamat_jalan);
			 $("#kelurahan").html(data.kelurahan);
			$("#kecamatan").html(data.kecamatan);
			$("#pasien").val(data.nama_pas);
            $("#noRm").val(data.id_pasien);
            $(".noBilling").html(data.id_billing);
            $("#noBilling").attr('value',data.id_billing);
            $(".barang_tr").remove();
            $('.service').removeAttr('disabled','disabled');
$("#idKunjungan").val(data.id_kunjungan);
            var carabayar="";
            if(data.carabayar=="Charity"){
                carabayar="Asuransi";
            }else{
                carabayar=data.carabayar;
            }

			 $("#bayar").attr('value',carabayar);
		 $(".bayar").html(carabayar);

	   $('#noKunjunganPasien').val(data.no_kunjungan_pasien);
                    var id_kunjungan=data.id_kunjungan;
                    $.ajax({
                        url: "<?= app_base_url('admisi/search?opsi=asuransi_kunjungan')?>",                        
                        cache:false,
                        data: "&q=1&id_kunjungan="+id_kunjungan,
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
            //            event.preventDefault();
            $.ajax({
                url: "<?= app_base_url('billing/billing-tabel') ?>",
                cache: false,
                data:'&id='+data.id_billing,
                dataType: 'json',
                success: function(msg){
                    var str='';
                    var j = 1;
                    var total=0;
                    for(var i=0;i<msg.length;i++){
                        total=total+(msg[i].total*msg[i].frekuensi);
                        str="<tr class='"+((i % 2==0) ? 'even' : 'odd') +" barang_tr'>"
                            +"<td align=center>"+(i+1)+"</td>"
                            +"<td class=no-wrap>"+msg[i].layanan+"</td>"
							     +"<td class=right><span>"+numberToCurrency(msg[i].total)+"</span><input type='hidden' id='harga_"+j+"' value='"+numberToCurrency(msg[i].total)+"'/></td>"
                         //   +"<td class=no-wrap align=right><input type='text' id='harga_"+j+"' value='"+numberToCurrency(msg[i].total)+"' style='border:none;text-align:right' readonly></td>"
                            +"<td class=no-wrap align=center><input type='text' id='frekuensi_"+j+"' value='"+msg[i].frekuensi+"' style='border:none' readonly></td>"
                            +"<td class=no-wrap>"+msg[i].nakes1+"</td>"
                            +"<td class=no-wrap>"+msg[i].nakes2+"</td>"
                            +"<td class=no-wrap>"+msg[i].nakes3+"</td>"
                            +"<td>&nbsp</td></tr>";
                        $("#tblBilling").append(str);
                        j++;
                    }
                    $('#total_tagihan').html(numberToCurrency(total));
                    $('.total_tagihan').val(total);
                    tambah_baris();
                    tambah_baris();
                }
            });
        }
    );
    })
	
	    $(function() {
        $('#pasien').focus();
        var kunjungan= $('#noKunjungan').val();
        if (kunjungan == '') {
            $('.service').attr('disabled','disabled');
        }
		
        $('#pasien').autocomplete("<?= app_base_url('/admisi/search?opsi=ceknamabilling') ?>",
        {
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
                $("#alamat").html('');
                $(".noRm").html('');
                $(".noBilling").html('');
                $("#noBilling").val('');
				 $("#bayar").val('');
                //$('.barang_tr').remove();
                 var str='<div class=result>'+data.id_pasien+' '+data.nama_pas+'<br/>No. Billing: '+data.id_billing+'</div>';
                return str;
            },
            width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama_pas);
            $("#alamat").html(data.alamat_jalan);
			 $("#kelurahan").html(data.kelurahan);
			$("#kecamatan").html(data.kecamatan);
			$("#pasien").val(data.nama_pas);
            $("#noRm").val(data.id_pasien);
            $(".noBilling").html(data.id_billing);
            $("#noBilling").attr('value',data.id_billing);
            $(".barang_tr").remove();
            $('.service').removeAttr('disabled','disabled');
			if(data.carabayar=="Charity"){
                carabayar="Asuransi";
            }else{
                carabayar=data.carabayar;
            }
				 $("#bayar").attr('value',carabayar);
		 $(".bayar").html(carabayar);
$("#idKunjungan").val(data.id_kunjungan);
	   $('#noKunjunganPasien').val(data.no_kunjungan_pasien);
                    var id_kunjungan=data.id_kunjungan;
                    $.ajax({
                        url: "<?= app_base_url('admisi/search?opsi=asuransi_kunjungan')?>",                        
                        cache:false,
                        data: "&q=1&id_kunjungan="+id_kunjungan,
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
            //            event.preventDefault();
            $('#total_tagihan').html('');
            $('.total_tagihan').attr('value','');
            $.ajax({
                url: "<?= app_base_url('billing/billing-tabel') ?>",
                cache: false,
                data:'&id='+data.id_billing,
                dataType: 'json',
                success: function(msg){
                    var str='';
                    var j = 1;
                    var total=0;
                    for(var i=0;i<msg.length;i++){
                        total=total+(msg[i].total*msg[i].frekuensi);
                        str="<tr class='"+((i % 2==0) ? 'even' : 'odd') +" barang_tr'>"
                            +"<td align=center>"+(i+1)+"</td>"
                            +"<td class=no-wrap >"+msg[i].layanan+"</td>"
                            +"<td class=no-wrap><span>"+numberToCurrency(msg[i].total)+"</span><input type='hidden' id='harga_"+j+"' value='"+numberToCurrency(msg[i].total)+"'/></td>"
                        //+"<td class=no-wrap align=right><input type='text' id='harga_"+j+"' value='"+numberToCurrency(msg[i].total)+"' style='border:none;text-align:right' readonly></td>"-->
                            +"<td class=no-wrap align=center><input type='text' id='frekuensi_"+j+"' value='"+msg[i].frekuensi+"' style='border:none' readonly></td>"
                            +"<td class=no-wrap>"+msg[i].nakes1+"</td>"
                            +"<td class=no-wrap>"+msg[i].nakes2+"</td>"
                            +"<td class=no-wrap>"+msg[i].nakes3+"</td>"
                            +"<td>&nbsp</td></tr>";
                        $("#tblBilling").append(str);
                        j++;
                    }
                    $('#total_tagihan').html(numberToCurrency(total));
                    $('.total_tagihan').val(total);
                    //hitungTotal($('.barang_tr').length);
                    tambah_baris();
                    tambah_baris();
                }
            });
        }
    );
    })
	 
    function cek_pasien(){
        if($("#kelas").html()==''){
            $.ajax({
                url: "<?= app_base_url('/admisi/search?opsi=billing') ?>",
                data:'&q='+$('#pasien').attr('value'),
                cache: false,
                dataType: 'json',
                success: function(data){
                    if (data.length==1){
                        data=data[0];
                        $('#pasien').attr('value',data.pasien);
                        $("#alamat").html(data.alamat_jalan);
                        $("#noRm").html(data.id_pasien);
                        $('.service').removeAttr('disabled','disabled');
                        tambah_baris();
                    }if(data.length==0 || $('#pasien').attr('value')==''){
                        alert('Pasien belum ditemukan');
                        $('#pasien').focus();
                    }else if(data.length>1){
                        alert('Data Pasien ambigu, silakan input ulang');
                        $('#pasien').focus();
                    }
                }
            });
            return false;
        }else
            tambah_baris();
    }
    var count=$('.barang_tr').length+1;
    function tambah_baris(){
//        var counter = count++,
        var counter=$('.barang_tr').length+1,
        string = "<tr class='"+((counter % 2!=0) ? 'even' : 'odd') +" barang_tr'>\n\
           <td align='center'>"+counter+"</td>\n\
           <td align='left'><input type='text' style='width: 100%;' class='service' name='billing["+counter+"][layanan]' id='layanan_"+counter+"'><input type='hidden' name='billing["+counter+"][tarif]' id='tarif_"+counter+"'></td>\n\
           <td align='right'><span></span><input type='hidden' name='billing["+counter+"][harga]' id='harga_"+counter+"'></td>\n\
           <td align='center'><input type='text' class='service' style='width: 80%;' name='billing["+counter+"][frekuensi]' onKeyup='Angka(this)' id='frekuensi_"+counter+"' onBlur='hitungTotal("+counter+")'></td>\n\
           <td align='left'><input type='text' id='nakes1_"+counter+"' style='width:20em'><input type='hidden' name='billing["+counter+"][nakes1]' id='idNakes1_"+counter+"'></td>\n\
           <td align='left'><input type='text' id='nakes2_"+counter+"' style='width:20em'><input type='hidden' name='billing["+counter+"][nakes2]' id='idNakes2_"+counter+"'></td>\n\
           <td align='left'><input type='text' id='nakes3_"+counter+"' style='width:20em'><input type='hidden' name='billing["+counter+"][nakes3]' id='idNakes3_"+counter+"'></td>\n\
           <td align='center'><input type='button' class='tombol' value='Hapus' onclick='hapusBarang("+counter+",this)'></td></tr>";
                   $("#tblBilling").append(string);
                   /*$(function(){
                       $('#layanan_'+counter).keyup(function(){
                           //console.log($("#tarif_"+counter).attr('value'));
                          // $("#tarif_"+counter).attr('value','');
                       });
                       $('#nakes1_'+counter).keyup(function(){
                           //console.log($("#tarif_"+counter).attr('value'));
                           $("#idNakes1_"+counter).attr('value','');
                       });
                       $('#nakes2_'+counter).keyup(function(){
                           //console.log($("#tarif_"+counter).attr('value'));
                           $("#idNakes2_"+counter).attr('value','');
                       });
                       $('#nakes3_'+counter).keyup(function(){
                           //console.log($("#tarif_"+counter).attr('value'));
                           $("#idNakes3_"+counter).attr('value','');
                       });
                        })
						*/
                       $(function(){
					   $('#layanan_'+counter).autocomplete("<?= app_base_url('/admisi/search?opsi=layananBilling') ?>",
                       {
                           extraParams:{
                               idKelas: function() { return $('#idKelas').val(); }
                           },
                           parse: function(data){                               
                               var parsed = [];
                               for (var i=0; i < data.length; i++) {
                                   parsed[i] = {
                                       data: data[i],
                                       value: data[i].layanan+' '+data[i].profesi+' '+data[i].spesialisasi // nama field yang dicari
                                   };
                               }
                               return parsed;
                           },
                           formatItem: function(data,i,max){
                               var bobot=(data.bobot == 'Tanpa Bobot')?"":" "+data.bobot;
                               var profesi=(data.profesi == 'Tanpa Profesi')?"":" "+data.profesi;
                               var spesialisasi=(data.spesialisasi == 'Tanpa Spesialisasi')?"":" "+data.spesialisasi;
                               var kelas=(data.kelas == 'Tanpa Kelas'||data.kelas == 'Semua')?"":" "+data.kelas;
                               var instalasi;
                               if(data.instalasi == 'Rekam Medik'  || data.instalasi == 'Semua' || data.instalasi == 'Tanpa Instalasi'){
                                   instalasi = "";   
                               }else instalasi = " "+data.instalasi;
                            
                               var layanans=(data.jenis == "Rawat Inap" && data.instalasi != 'Semua' && data.instalasi != 'Tanpa Instalasi')?data.layanan+' '+data.instalasi:data.layanan;
                               
                               if (layanans == ' null') layanans = '';
                               if (bobot == ' null') bobot = '';
                               if (profesi == ' null') profesi = '';
                               if (spesialisasi == ' null') spesialisasi = '';
                               if (instalasi == ' null') instalasi = '';
                               if (kelas == ' null') kelas = '';

                                var layanan =layanans+profesi+spesialisasi+bobot+instalasi+kelas;
                            
                               var str='<div class=result>'+layanan+'</div>';
                               return str;
                           },
                           width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                           dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                       }).result(
                       function(event,data,formated){
                           var bobot=(data.bobot == 'Tanpa Bobot')?"":" "+data.bobot;
                           var profesi=(data.profesi == 'Tanpa Profesi')?"":" "+data.profesi;
                           var spesialisasi=(data.spesialisasi == 'Tanpa Spesialisasi')?"":" "+data.spesialisasi;
                           var kelas=(data.kelas == 'Tanpa Kelas'||data.kelas == 'Semua')?"":" "+data.kelas;
                           var instalasi;
                           if(data.instalasi == 'Rekam Medik'  || data.instalasi == 'Semua' || data.instalasi == 'Tanpa Instalasi'){
                               instalasi = "";    
                           }else instalasi = " "+data.instalasi;
                           var layanans=(data.jenis == "Rawat Inap" && data.instalasi != 'Semua' && data.instalasi != 'Tanpa Instalasi')?data.layanan+' '+data.instalasi:data.layanan;                           
                           if (layanans == ' null') layanans = '';
                               if (bobot == ' null') bobot = '';
                               if (profesi == ' null') profesi = '';
                               if (spesialisasi == ' null') spesialisasi = '';
                               if (instalasi == ' null') instalasi = '';
                               if (kelas == ' null') kelas = '';
                            var layanan =layanans+profesi+spesialisasi+bobot+instalasi+kelas;
                           $(this).attr('value',layanan);
                           $("#tarif_"+counter).attr('value',data.tarif);
//                           $(this).parent('td').parent('tr').children('td:eq(2)').html(numberToCurrency(data.total));
                           $("#harga_"+counter).val(numberToCurrency(data.total));
                           $("#harga_"+counter+"").prev().html(numberToCurrency(data.total));
                       }
                   );
                   })
               
                   for(var i=1;i<=3;i++){
                       $(function() {
                           $('#nakes'+i+'_'+counter).autocomplete("<?= app_base_url('/admisi/search?opsi=nakes') ?>",
                           {
							    extraParams:{
                    pasien:function(){
                        return  $("#pasien").val();
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
                                   var sip;
                                   if(data.sip == 'NULL' || data.sip == ''){
                                       sip = "-";
                                   }else sip = data.sip;
                                       
                                   var str='<div class=result><b style="text-transform:capitalize">'+data.nama+'<br /> SIP: '+sip+'</b></div>';
                                   return str;
                               },
                               width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                               dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                           }).result(
                           function(event,data,formated){
                               $(this).attr('value',data.nama);
                               $(this).next('input').attr('value',data.id);
                           });
                       });
                   }
               }
               function cekForm(){
               /*
                   if($("#pasien").val() == ""){
                       alert("Nama pasien tidak boleh kosong");
                       $("#pasien").focus();
                       return false;
                   }
                   else */if($("#noRm").val() == ""){
                       alert("Pilih nama pasien dengan benar, coba lagi");
                       $("#pasien").focus();
                       return false;
                   }
                   else if($("#noBilling").val() == "")
                   {
                       alert("Pasien belum melakukan pendaftaran");
                       $("#pasien").val('');
                       $("#noRm").val('');
                       $("#alamat").html('');
                       $(".noRm").html('');
                       $("#pasien").focus();
                       return false;
                   }
                   //cek form barang
                   var jumlahForm=$('.barang_tr').length;
                   var i=0;
                   var isi=false;
                   for(i=1;i<=jumlahForm;i++){
                       if($('#tarif'+i).attr('value')!=""){
                           if($('#frekuensi'+i).val()==''){
                               alert('frekuensi tidak boleh kosong')
                               $('#frekuensi'+i).focus();
                               return false;
                           }
                           if($('#nakes'+i).val()==''){
                               alert('Nakes tidak boleh kosong');
                               $('#nakes'+i).focus();
                               return false;
                           }
                           isi=true;
                       }
                   }
                   if(!isi){
                       alert('inputan barang masih kosong');
                       return false;
                   }
                   
                   var error=0;
                   var isi=0;
                    $('.barang_tr td:nth-child(2)').children('input:nth-child(1)').each(function(index,item){    
                        var tr=$(item).parents('tr').first();
                                    if($(item).val()!=''){                      
                                            isi++;
                                            if(($(item).next().val()=='')&&(error<1)){
                                                    alert('Nama tarif tersebut tidak ada');
                                                    $(item).focus();
                                                    error++;
                                                    return false;
                                            }else if(($('td:nth(3)',tr).children().val()=='')&&(error<1)){
                                                    alert('Anda belum memasukkan frekuensi');
                                                    $('td:nth(3)',tr).children().focus();
                                                    error++;
                                                    return false;
                                            }
                                            /*else if(($('td:nth(4)',tr).children('input:eq(0)').val())==''&&(error<1)){
                                                    alert('Anda belum memasukkan nama nakes');
                                                    error++;
                                                    return false;
                                            }*/else if(($('td:nth(4)',tr).children().val()!='')&&($('td:nth(4)',tr).children().next().val()=='')&&(error<1)){
                                                    alert('nama nakes tersebut tidak ada');
                                                    $('td:nth(4)',tr).children().focus();
                                                    error++;
                                                    return false;
                                            }else if(($('td:nth(5)',tr).children().val()!='')&&($('td:nth(5)',tr).children().next().val()=='')&&(error<1)){
                                                    alert('nama nakes tersebut tidak ada');
                                                    $('td:nth(5)',tr).children().focus();
                                                    error++;
                                                    return false;
                                            }else if(($('td:nth(6)',tr).children().val()!='')&&($('td:nth(6)',tr).children().next().val()=='')&&(error<1)){
                                                    alert('nama nakes tersebut tidak ada');
                                                    $('td:nth(6)',tr).children().focus();
                                                    error++;
                                                    return false;
                                            }
                                            
                                    }else{
                                        $('input',tr).not('.tombol').val('');
                                    }	   
                    })
                   if(isi<=0){
                       alert('Anda belum memasukkan data baru');
                       return false;
                   }
                   if(error<=0)return true;
               }
               function hitungTotal(no){
                   //alert('auo');
                   tot = 0;
                   var totalTemp = 0;
                   for(var i=1;i<$('.barang_tr').length;i++){
                       if(i!=no){
                        totalTemp = totalTemp + (currencyToNumber($('#harga_'+i).val())*$('#frekuensi_'+i).val());                        
                       }
                   }                   
                   var harga = currencyToNumber($('#harga_'+no).val());
                   var frekuensi = $('#frekuensi_'+no).val();
                   var total = totalTemp + (harga*frekuensi);
                   tot = tot + total;
                   $('#total_tagihan').html('Rp. '+numberToCurrency(tot)+',00');
                   $('.total_tagihan').val(tot);
               }
               function hapusBarang(count,el){
                   var totalTemp = 0;
                   for(var i=1;i<=$('.barang_tr').length;i++){
                       totalTemp = totalTemp + (currencyToNumber($('#harga_'+i).val())*$('#frekuensi_'+i).val());
                   }
                   var harga = currencyToNumber($('#harga_'+count).val());
                   var frekuensi = $('#frekuensi_'+count).val();
                   var total = harga*frekuensi;
                   totalTemp = totalTemp-total;
                   if(totalTemp > 0){
                       $('#total_tagihan').html('Rp. '+numberToCurrency(totalTemp)+',00');
                       $('.total_tagihan').val(totalTemp);
                   }
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
                   }
               }
               
$(document).ready(function(){
    $('#form_pembayaran').submit(function(event){
        event.preventDefault();
    });
    $('#save').click(function(event){
        event.preventDefault();
        if(cekForm()){
            var jumlahForm=$('.barang_tr').length; 
            for(i=1;i<=jumlahForm;i++){
               if($('#layanan'+i).attr('value')==""){
                   $('.barang_tr').eq(i-1).remove();
               }
            }
            
            $("#loader").show();
            var formdata=$("#form_billing").serialize();
                      
           
            $.ajax({
                type:'POST',
                url: "<?=  app_base_url('billing/control/billing')?>",
                cache: false,
                dataType:'json',
                data:formdata+'&save=1',
                success: function(msg){
                    var pesan='';                    
                    if(msg!=null){    
                        $('.barang_tr').each(function(){
                            if($('td:nth(1)>input',this).val()!=''&&$('td:nth(1)>input',this).length>0){
                                $('td:nth(1)',this).html($('td:nth(1) input',this).val());
                                //$('td:nth(3)',this).html($('td:nth(3) input',this).val());
                                $('td:nth(3) input',this).attr('readonly','readonly');
                                $('td:nth(4)',this).html($('td:nth(4) input',this).val());
                                $('td:nth(5)',this).html($('td:nth(5) input',this).val());
                                $('td:nth(6)',this).html($('td:nth(6) input',this).val());
                                $('input',this).not($('td:nth(2) input,td:nth(3) input',this)).remove();
                            }
                        })
                        pesan="<div class='ui-state-highlight ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'><p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span><strong>Info!</strong> Proses transaksi berhasil dilakukan</p></div>";                               
                         $("#nota").removeAttr('disabled');
                         //$("#save").attr('disabled', 'disabled');
                         $("#noRm").unautocomplete();
                         $("#noRm").attr('readonly','readonly');
                         $("#pasien").unautocomplete();
                         $("#pasien").attr('readonly','readonly');
                         $("input[value=hapus]").remove();
                    }else{
                        pesan="<div class='ui-state-error ui-corner-all' style='margin-top: 10px; padding: 0 .7em;'><p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><strong>Alert:</strong> Proses transaksi gagal tidak ada penambahan data </p></div>";
                    }
                    
                   $("html,body").scrollTop(0); 
                   $('.pesan').html(pesan);
                   $('.pesan').show();
                   $("#loader").hide();                                           
                }
            }
            );
            
            //alert('sukses');
        }
    });
});             
</script>
<?php
//include 'app/actions/admisi/pesan.php';
?>
<h2 class="judul">Billing</h2>
<div class='ui-widget pesan' id="pesan"></div>
<?= isset($pesan) ? $pesan : NULL ?>
<form id="form_billing" action="<?= app_base_url("billing/control/billing") ?>" method="POST" onsubmit="return cekForm()">
    <div class="data-input">
        <fieldset>
            <legend>Form Cari</legend>
            <label for="noRm">No. RM*</label><input type="text" id="noRm" name="noRm" /><!--<span style="font-size: 12px;padding-top: 5px;" class="noRm"></span>-->
            <label for="pasien">Nama Pasien</label><!--<span style="font-size: 12px; padding-top: 5px;" id="pasien">--></span>
            <input type="text" id="pasien" name="pasien" />
            <label for="alamat">Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"></span>
             <label for="kelurahan">Kelurahan/Kecamatan</label><span style="font-size: 12px;padding-top: 5px;" id="kelurahan"></span><span class="span-normal">&nbsp;/&nbsp;</span><span style="font-size: 12px;padding-top: 5px;" id="kecamatan"></span>
            <!--<input type="hidden" id="noRm" name="noRm">-->
            <label for="billing">No. Billing</label><span style="font-size: 12px;padding-top: 5px;" class="noBilling"></span>
            <input type="hidden" id="noBilling" name="noBilling">
            <label for="bayar">Cara Bayar</label><span style="font-size: 12px;padding-top: 5px;" class="bayar"></span>
            <input type="hidden" id="bayar" name="bayar">
             <label for="asuransi">Produk Asuransi</label><span style="font-size: 12px;padding-top: 5px;" class="asuransi"></span>
            <input type="hidden" id="asuransi" name="asuransi">
                <input type="hidden" id="idKunjungan" name="idKunjungan">
        </fieldset>
    </div>
    <div id="billingTable"></div>
    <input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;" onclick="cek_pasien()">
    <br />
    <div class="data-list tabelflexibel">
        <table id="tblBilling" width="35%" class="table-input" style="border: 1px solid #f4f4f4; float: left; width: 100%">
            <tr style="background: #F4F4F4;">
                <th style="width: 3%;" align="center">No</th>
                <th style="width: 20%;"  align="center">Nama Tarif*</th>
                <th style="width: 10%" align="center">Harga</th>
                <th style="width: 5%;" align="center">Frekuensi*</th>
                <th align="center" style="width: 15%;">Nakes 1</th>
                <th align="center" style="width: 15%;">Nakes 2</th>
                <th align="center" style="width: 15%;">Nakes 3</th>
                <th>Aksi</th>
            </tr>
        </table>    
    </div>
    <div class="data-input">
        <label style="width: 8em;">Total Tagihan :</label><span style="font-size: 11px;padding-top: 8px;" id="total_tagihan"></span><input type="hidden" class="total_tagihan" name="total_tagihan"/>
    </div>
    <div class="field-group" style="clear: left">
        <input type="submit" value="Simpan" name="save" class="tombol" id="save"/>
        <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('billing/billing') ?>'"/>
        <input type="button" id="nota" name="cetak_kitir" value="Cetak Kitir" disabled="disabled"/>  
        <div id="loader" style="background-image:url('<?=  app_base_url('/assets/images/contentload.gif')?>');background-repeat: no-repeat;width:100px;height: 35px;display: block;padding-left: 38px;padding-top: 10px;display: none;">
        Menyimpan data</div>
    </div>
</form>
<script type="text/javascript">
	$(function(){
		$("#nota").click(function(){
                    var win = window.open('print/nota-billing?id='+$('#noBilling').val()+'&cara='+$('#bayar').val()+'&idKunjungan='+$('#idKunjungan').val(), 'MyWindow', 'width=600px, height=500px, scrollbars=1');
		})
	})
</script>