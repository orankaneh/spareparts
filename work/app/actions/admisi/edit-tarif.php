<?php
require_once 'app/lib/common/master-data.php';
$page = isset($_GET['page'])?$_GET['page']:NULL;
$edittarif= tarif_muat_data($_GET['code'], $page, $dataPerPage = null);
foreach($edittarif['list'] as $num => $row);
$layanan="";
        $layanan.= $row['layanan'];
        
        if ($row['profesi'] == 'Tanpa Profesi') $layanan.= "";
        else $layanan.=" $row[profesi]";
        
        if ($row['spesialisasi'] == 'Tanpa Spesialisasi') $layanan.= "";
        else $layanan.=" $row[spesialisasi]";
        
        if ($row['bobot'] == 'Tanpa Bobot') $layanan.= "";
        else $layanan.=" $row[bobot]";
        
        if($row['jenis'] == "Rawat Inap") $layanan.=" $row[instalasi]";
        else if($row['instalasi'] == 'Rekam Medik' || $row['instalasi'] == 'Gawat Darurat' || $row['instalasi'] == 'Poliklinik' || $row['instalasi'] == 'Semua' || $row['instalasi'] == 'Tanpa Instalasi') $layanan.= "";
	else $layanan.=" $row[instalasi]";	
        
        if($row['kelas'] == 'Tanpa Kelas') $layanan.= "";
        else $layanan.=" $row[kelas]";
?>
<script type="text/javascript">
	
  function hitungHarga(){
      var harga_awal = $("#harga_awal").val()*1;
      var biaya_bhp = $("#biaya_bhp").val()*1;
      var profit = $("#profit").val()/100;
      var harga = ((harga_awal+biaya_bhp)*profit)+(harga_awal+biaya_bhp);
      $("#harga").val(harga);
  }
  function hitungNakes(el){
      if(el == 1){
          var ket = "Utama",
          nakes = "nakesUtama";
		  rs = "rsUtama";
      }else if(el == 2){
          var ket = "Pendamping",
          nakes = "nakesPendamping";
		  rs = "rsPendamping";
      }else if(el == 3){
          var ket = "Pendukung",
          nakes = "nakesPendukung";
		  rs = "rsPendukung";
      }
      var temp=currencyToNumber($('#total'+ket).val());
      temp=isNaN(temp)?0:temp;
      var tot = (100-$('#'+nakes).val())/100;
	  var total=Math.round(temp-(temp*tot));
	  var sisa=temp-total;
	  var siper=100-$('#'+nakes).val();
      total=isNaN(total)?0:total;
      $('#nakes_'+el).attr('value',total);
	  $('#rs_'+el).attr('value',sisa);
	  $('#'+rs).attr('value',Math.round(siper));
  }
    function hitungNakes_Rp(el){
      if(el == 1){
          var ket = "Utama",
          nakes = "nakesUtama";
      }else if(el == 2){
          var ket = "Pendamping",
          nakes = "nakesPendamping";
      }else if(el == 3){
          var ket = "Pendukung",
          nakes = "nakesPendukung";
      }
      
      var temp=currencyToNumber($('#total'+ket).val());
      temp=isNaN(temp)?0:temp;
      var pembilang = $('#nakes_'+el).val();
      var total = ((pembilang/temp)*100);
      total=isNaN(total)?0:total;
      $('#'+nakes).attr('value',Math.round(total));
  }
  function hitungRs(el){
      if(el == 1){
          var ket = "Utama",
          nakes = "rsUtama";
      }else if(el == 2){
          var ket = "Pendamping",
          nakes = "rsPendamping";
      }else if(el == 3){
          var ket = "Pendukung",
          nakes = "rsPendukung";
      }
      var temp=currencyToNumber($('#total'+ket).val());
      temp=isNaN(temp)?0:temp;
      var total = (temp*$('#'+nakes).val()/100);
      total=isNaN(total)?0:total;
      $('#rs_'+el).attr('value',Math.floor(total));
  }
  function hitungRs_Rp(el){
      if(el == 1){
          var ket = "Utama",
          nakes = "rsUtama";
      }else if(el == 2){
          var ket = "Pendamping",
          nakes = "rsPendamping";
      }else if(el == 3){
          var ket = "Pendukung",
          nakes = "rsPendukung";
      }
      var temp=currencyToNumber($('#total'+ket).val());
      temp=isNaN(temp)?0:temp;
      pembilang = currencyToNumber($('#rs_'+el).val());
      var nakes_rp    = currencyToNumber($('#nakes_'+el).val());
      var checking = temp - (pembilang + nakes_rp);
      if (checking != 0) {
            alert('Jumlah nakes & RS harus sama dengan total !');
            $('#'+nakes+',#rs_'+el).val(0);
            return false;
      }
      var total = ((pembilang/temp)*100);
      total=isNaN(total)?0:total;
      $('#'+nakes).attr('value',Math.round(total));
  }
  function hitungTotal(){
      var jasaSarana =currencyToNumber($('#jasaSarana').val()),
      bhp = currencyToNumber($('#bhp').val()),
      totalUtama = currencyToNumber($('#totalUtama').val()),
      totalPendamping = currencyToNumber($('#totalPendamping').val()),
      totalPendukung = currencyToNumber($('#totalPendukung').val()),
      profit = $('#profit').val()/100;
      
      jasaSarana =isNaN(jasaSarana)?0:jasaSarana;
      bhp = isNaN(bhp)?0:bhp;
      totalUtama = isNaN(totalUtama)?0:totalUtama;
      totalPendamping = isNaN(totalPendamping)?0:totalPendamping;
      totalPendukung =isNaN(totalPendukung)?0:totalPendukung;
      
      var total = ((jasaSarana+bhp+totalUtama+totalPendamping+totalPendukung)*profit)+(jasaSarana+bhp+totalUtama+totalPendamping+totalPendukung);
      var inttocur = number_format(total,2,',','.');
      $('#total').html('Rp. '+inttocur);
      $('#total2').val(total);
  }
  function cekform(){
    if($('#idk_pelayanan').attr('value')==''){
                alert('Kategori pelayanan tidak ditemukan');
                $('#k_pelayanan').focus();
                return false;
            }

  }
 
    $(document).ready(function(){
        $('#k_tarif').focus();
//        $("#nakesUtama,#rsUtama,#nakesPendamping,#rsPendamping,#nakesPendukung,#rsPendukung").keyup(function(){
//            Decimal2(this);
//        });
        
        $("#jasaSarana,#bhp,#totalPendamping,#totalUtama,#totalPendukung").blur(function(event){
            var nilai=$(this).val();
            if(nilai!=''||nilai!=null){
                $(this).val(numberToCurrency2(nilai));
            }else{
               $(this).val(0); 
            }            
            hitungTotal();
        });
        
       $("#nakes_1,#rs_1,#nakes_2,#rs_2,#nakes_3,#rs_3").blur(function(event){
            var nilai=$(this).val();
            if(nilai!=''||nilai!=null){
                $(this).val(numberToCurrency2(nilai));
            }else{
               $(this).val(0); 
            }        
        });
        
        $("#nakesUtama,#rsUtama,#nakesPendamping,#rsPendamping,#nakesPendukung,#rsPendukung,#jasaSarana,#bhp,#totalPendamping,#totalUtama,#totalPendukung,#profit,#nakes_1,#rs_1,#nakes_2,#rs_2,#nakes_3,#rs_3").css("text-align","right");
        

         $('#k_pelayanan').autocomplete("<?= app_base_url('/inventory/search?opsi=data_kategori_pelayanan') ?>",
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
                    var str = '<div class=result><b>'+data.nama+'</b></div>';
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                $('#idk_pelayanan').attr('value',data.id);
                $('#k_pelayanan').attr('value',data.nama);
            }
        );

});
  
</script>
<div class="data-input">
<fieldset><legend>Form Edit Data tarif</legend>
    <form action="<?= app_base_url('/admisi/control/tarif/edit') ?>" method="post" onSubmit="return cekform()">
        <input type="hidden" name="id" value="<?=$row['id']?>">
        <label for="kode">Kode Tarif</label>
            <span style="font-size: 12px; padding-top: 5px; "><?=$row['id']?></span>
        <label for="tarif">Nama Layanan</label><span style="font-size: 12px; padding-top: 5px; "><?=$layanan?></span>
        <label for="jasaSarana">Jasa Sarana</label><input type="text" name="jasaSarana" id="jasaSarana" value="<?= inttocur($row['jasa_sarana']) ?>" onKeyup='Decimal2(this)'>
<!--        <label for="jasaSarana">Nama Layanan</label><input type="text" name="k_pelayanan" id="k_pelayanan" value="<?=$row['layanan']?>" ><span class="bintang">*</span>-->
        <input type="hidden" name="idk_pelayanan" id="idk_pelayanan" value="<?=$row['id_layanan']?>" >
        <label for="bhp">B.H.P</label><input type="text" name="bhp" id="bhp" value="<?=inttocur($row['bhp'])?>" onKeyup='Decimal2(this)'>
        <label for="utama">Utama</label>
        <label for="totalUtama">- Total</label><input type="text" name="totalUtama" id="totalUtama" value="<?=  inttocur($row['total_utama'])?>" onKeyup='Decimal2(this)'>
        <fieldset class="field-group">
            <label for="nakesUtama">- Nakes </label><input type="text" name="nakesUtama" id="nakesUtama" class="small-input" value="<?= $row['persen_nakes_utama']?>" onBlur="hitungNakes(1)" onKeyup='Decimal2(this)'>
            <span class="span-normal">% / Rp.</span>
            <input type="text" id="nakes_1" class="tgl" onBlur="hitungNakes_Rp(1)" value="<?=inttocur($row['total_utama']*($row['persen_nakes_utama']/100))?>" onkeyup="Decimal2(this)" />
        </fieldset>
        <fieldset class="field-group">
            <label for="rsUtama">- R.S</label><input type="text" name="rsUtama" id="rsUtama" class="small-input" value="<?= $row['persen_rs_utama']?>" onBlur="hitungRs(1)" onKeyup='Decimal2(this)' readonly="readonly">
            <span class="span-normal">% / Rp.</span>
            
            <input type="text" id="rs_1" onBlur="hitungRs_Rp(1)" class="tgl" value="<?=inttocur($row['total_utama']*($row['persen_rs_utama']/100))?>" onkeyup="Decimal2(this)" readonly="readonly"/>
        </fieldset>
        <label for="pendamping">Pendamping</label>
        <label for="totalPendamping">- Total</label><input type="text" name="totalPendamping" id="totalPendamping" value="<?= inttocur($row['total_pendamping'])?>" onKeyup='Decimal2(this)'>
        <fieldset class="field-group">
            <label for="nakesPendamping">- Nakes</label>
            <input type="text" name="nakesPendamping" id="nakesPendamping" class="small-input" value="<?= $row['persen_nakes_pendamping']?>" onBlur="hitungNakes(2)" onKeyup='Decimal2(this)'>
            <span class="span-normal">% / Rp.</span>
            
            <input type="text" id="nakes_2" class="tgl" onBlur="hitungNakes_Rp(2)" value="<?=inttocur($row['total_pendamping']*($row['persen_nakes_pendamping']/100))?>" onkeyup="Decimal2(this)" />
        </fieldset>
        <fieldset class="field-group">
            <label for="rsPendamping">- R.S</label><input type="text" name="rsPendamping" id="rsPendamping" class="small-input" value="<?= $row['persen_rs_pendamping']?>" onBlur="hitungRs(2)" onKeyup='Decimal2(this)' readonly="readonly">
            <span class="span-normal">% / Rp.</span>
            
            <input type="text" id="rs_2" class="tgl" onBlur="hitungRs_Rp(2)" value="<?=inttocur($row['total_pendamping']*($row['persen_rs_pendamping']/100))?>" onkeyup="Decimal2(this)" readonly="readonly"/>
        </fieldset>
        <label for="pendukung">Pendukung</label>
        <label for="totalPendukung">- Total</label><input type="text" name="totalPendukung" id="totalPendukung" value="<?= inttocur($row['total_pendukung'])?>" onKeyup='Decimal2(this)'>
        <fieldset class="field-group">
            <label for="nakesPendukung">- Nakes</label>
            <input type="text" name="nakesPendukung" id="nakesPendukung" class="small-input" value="<?= $row['persen_nakes_pendukung']?>" onBlur="hitungNakes(3)" onKeyup='Decimal2(this)'>
            <span class="span-normal">% / Rp.</span>
            
            <input type="text" id="nakes_3" onBlur="hitungNakes_Rp(3)" class="tgl" value="<?=inttocur($row['total_pendukung']*($row['persen_nakes_pendukung']/100))?>" onkeyup="Decimal2(this)" />
        </fieldset>
        <fieldset class="field-group">
            <label for="rsPendukung">- R.S</label><input type="text" name="rsPendukung" id="rsPendukung" class="small-input" value="<?= $row['persen_rs_pendukung']?>" onBlur="hitungRs(3)" onKeyup='Decimal2(this)' readonly="readonly">
            <span class="span-normal">% / Rp.</span>
             <input type="text" id="rs_3" class="tgl" onBlur="hitungRs_Rp(3)" value="<?=inttocur($row['total_pendukung']*($row['persen_rs_pendukung']/100))?>" onkeyup="Decimal2(this)" readonly="readonly"/>
        </fieldset>
        <fieldset class="field-group">
            <label for="profit">Profit</label><input type="text" class="small-input" name="profit" id="profit" value="<?= $row['persen_profit']?>" onBlur="hitungTotal()" onKeyup='Decimal2(this)'>
            <span class="span-normal">%</span>
        </fieldset>    
        <label for="total">Total</label><span style="font-size: 12px; padding-top: 5px;" id="total"><?= inttocur($row['total']);?></span>
        <input type="hidden" name="total" id="total2" value="<?= inttocur($row['total']);?>">
<fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="update" />&nbsp;  
            <input type="submit" value="Simpan Baru" class="tombol" name="insert" />&nbsp;
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-tarif') ?>'" />
     </fieldset>
    </form>
</fieldset>
</div>

