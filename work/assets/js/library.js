 var counter = 0;
 
 var message="Sorry, right-click has been disabled";
 

function clickIE() {
           if (document.all) {
                      (message);
           return false;
           }
}

function clickNS(e) {
           if (document.layers||(document.getElementById&&!document.all)) { 
                      if (e.which==2||e.which==3) {
                                 (message);return false;
                      }
           }
} 

 //Format Nilai Uang
 function number_format(a, b, c, d) {
            a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
            e = a + '';
            f = e.split('.');
            if (!f[0]) {
            f[0] = '0';
            }
            if (!f[1]) {
            f[1] = '';
            }
            if (f[1].length < b) {
            g = f[1];
            for (i=f[1].length + 1; i <= b; i++) {
            g += '0';
            }
            f[1] = g;
            }
            if(d != '' && f[0].length > 3) {
            h = f[0];
            f[0] = '';
            for(j = 3; j < h.length; j+=3) {
            i = h.slice(h.length - j,h.length - j + 3);
            f[0] = d + i +  f[0] + '';
            }
            j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
            f[0] = j + f[0];
            }
            c = (b <= 0) ? '' : c;
            return f[0] + c + f[1]; 
}
    
//Menghitung Umur dari tanggal ditentukan    

function hitungUmur(){
        var tanggal=$('#tglLahir').attr('value');
        var elem = tanggal.split('/');
        var tahun = elem[2];
        var bulan = elem[1];
        var hari  = elem[0];
        if((tahun==0 && bulan==0 && tahun==0)|| tanggal==null || tanggal==''){
            $('#umur-tahun').attr('value',0);
            $('#umur-bulan').attr('value',0);
            $('#umur-hari').attr('value',0);
            return false;
        }
        var now=new Date();
        var day =now.getUTCDate();
        var month =now.getUTCMonth()+1;
        var year =now.getYear()+1900;
        
        tahun=year-tahun;
        bulan=month-bulan;
        hari=day-hari;
        
        var jumlahHari;
        var bulanTemp=(month==1)?12:month-1;
        if(bulanTemp==1 || bulanTemp==3 || bulanTemp==5 || bulanTemp==7 || bulanTemp==8 || bulanTemp==10 || bulanTemp==12){
            jumlahHari=31;
        }else if(bulanTemp==2){
            if(tahun % 4==0)
                jumlahHari=29;
            else
                jumlahHari=28;
        }else{
            jumlahHari=30;
        }

        if(hari<=0){
            hari+=jumlahHari;
            bulan--;
        }
        if(bulan<0 || (bulan==0 && tahun!=0)){
            bulan+=12;
            tahun--;
        }
        $('#umur-tahun').attr('value',tahun);
        $('#umur-bulan').attr('value',bulan);
        $('#umur-hari').attr('value',hari);
        $('#umur').html(tahun+' Tahun ' +bulan+ ' Bulan ' +hari+ ' Hari');
}

function Angka(obj) {
        a = obj.value;
        b = a.replace(/[^\d]/g,'');
        c = '';
        lengthchar = b.length;
        j = 0;
        for (i = lengthchar; i > 0; i--) {
                j = j + 1;
                if (((j % 3) == 1) && (j != 1)) {
                        c = b.substr(i-1,1) + '' + c;
                } else {
                        c = b.substr(i-1,1) + c;
                }
        }
        obj.value = c;
}

function FormNum(obj) {
        a = obj.value;
        b = a.replace(/[^\d]/g,'');
        c = '';
        lengthchar = b.length;
        j = 0;
        for (i = lengthchar; i > 0; i--) {
                j = j + 1;
                if (((j % 3) == 1) && (j != 1)) {
                        c = b.substr(i-1,1) + '.' + c;
                } else {
                        c = b.substr(i-1,1) + c;
                }
        }
        obj.value = c;
}

function Desimal(obj){
    a=obj.value;   
    var reg=new RegExp(/[0-9]+(?:\.[0-9]{0,2})?/g)
    b=a.match(reg,'');
    if(b==null){
        obj.value='';
    }else{
        obj.value=b[0];
    }
    
}
function Desimal2(obj){
    a=obj.value;   
    var reg=new RegExp(/[0-9]+(?:\.[0-9])?/g)
    b=a.match(reg,'');
    if(b==null){
        obj.value='';
    }else{
        obj.value=b[0];
    }
    
}
function AlpaNumerik(obj){
    a=obj.value;   
    if(a!=null&&a!=''){
        var reg=new RegExp(/^[a-zA-Z0-9 ]+$/g);
        var b=a.substr(a.length-1,1);
        var c=b.match(reg,'');
        if(c!=null){
            obj.value=a;
        }else{
            obj.value=a.substr(0,a.length-1);
        }
        
    }else{
        obj.value='';
    }
       
}

function titikKeKoma(obj){
    var a=obj.toString();
    var b='';
    if(a!=null){
        b=a.replace(/\./g,',');
    }
    return b;
}

function komaKeTitik(obj){
    var a=obj.toString();
    var b='';
    if(a!=null){
        b=a.replace(/\,/g,'.');
    }
    return b;
}

function numberToCurrency(a){
       if(a!=''&&a!=null){
       a=a.toString();       
        var b = a.replace(/[^\d\,]/g,'');
		var dump = b.split(',');
        var c = '';
        var lengthchar = dump[0].length;
        var j = 0;
        for (var i = lengthchar; i > 0; i--) {
                j = j + 1;
                if (((j % 3) == 1) && (j != 1)) {
                        c = dump[0].substr(i-1,1) + '.' + c;
                } else {
                        c = dump[0].substr(i-1,1) + c;
                }
        }
		
		if(dump.length>1){
			if(dump[1].length>0){
				c += ','+dump[1];
			}else{
				c += ',';
			}
		}
    return c;}
    else{
        return '';
    }
}



function numberToCurrency2(a){
        if(a!=null&&!isNaN(a)){
        //var b=Math.ceil(parseFloat(a));
        var b=parseInt(a);
        var angka=b.toString();        
        var c = '';    
        var lengthchar = angka.length;
        var j = 0;
        for (var i = lengthchar; i > 0; i--) {
                j = j + 1;
                if (((j % 3) == 1) && (j != 1)) {
                        c = angka.substr(i-1,1) + '.' + c;
                } else {
                        c = angka.substr(i-1,1) + c;
                }
        }        
        return c;
    }else{
        return '';
    }
}

function floatToCurrency(a){
    if(a!=''&&a!=null){
       a=a.toString();       
       var b = a.replace(/[^\d\.]/g,'');
       var temp=a.split('.');
       if(temp.length>1){
           return numberToCurrency2(temp[0])+','+temp[1];
       }else{
           return numberToCurrency2(b);
       }
       
    }else{
        return '';
    }    
}

function currencyToNumber(a){
    var b=a.toString();
    
    var c='';
    if(a!=null||a!=''){
        c=b.replace(/\.+/g, '');
    }
    
    return parseFloat(komaKeTitik(c));
}

function formatNumber(obj) {
	var a = obj.value;
	obj.value = numberToCurrency(a);
}
 

function addDynamicElement() {
	var holder  = document.getElementById('dynamic-elements'),
		el      = document.createElement('div'),
		trigName = 'dynval'+counter,
		destName = 'dynid['+counter+']',
		destID  = 'dynid'+counter,
		byrName  = 'byr['+counter+']',
		elInner = '';

	elInner += '<input type="text" name="'+trigName+'" id="'+trigName+'" class=formKcl>';
	elInner += '<input type="hidden" name="'+destName+'" id="'+destID+'">';
	elInner += '<select name="'+trigName+'" class=mini-select><option value="1">Reimbursment</option><option value="2">Kredit</option></select>';
	elInner += '<input type="button" value="Hapus" style="white-space: nowrap;" onclick="removeMe(this)">';

	el.innerHTML = elInner;
	holder.appendChild(el);

	$('#dynval'+counter).autocomplete("<?= app_base_url('/admisi/search?opsi=asuransi') ?>",
	{
	    parse: function(data){
		var parsed = [];
		for (var i=0; i < data.length; i++) {
		    parsed[i] = {
			data: data[i],
			value: data[i].jenis_asuransi // nama field yang dicari
		    };
		}
		return parsed;
	    },
	    formatItem: function(data,i,max){
		var str='<div class=result><b style="text-transform:capitalize">'+data.jenis_asuransi+'</b></div>';
		return str;
	    },
	    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
	    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
	}).result(
	function(event,data,formated){
	    $('#'+trigName).attr('value',data.jenis_asuransi);
	    $('#'+destID).attr('value',data.id_jenis_asuransi);
	}
	);

	counter++;
}

function removeMe(el) {
	var parent = el.parentNode;
	parent.parentNode.removeChild(parent);
}

var counter = 0;
function addDynamicElement2() {
	var holder  = document.getElementById('dynamic-elements2'),
		el      = document.createElement('div'),
		trigName = 'dynaval'+counter,
		destName = 'dynaid['+counter+']',
		destiID  = 'dynaid'+counter,
		elInner = '';

	elInner += '<input type="text" name="'+trigName+'" id="'+trigName+'">';
	elInner += '<input type="hidden" name="'+destName+'" id="'+destiID+'" value="">';
	elInner += '<input type="button" value="Hapus" onclick="removeMe(this)">';

	el.innerHTML = elInner;
	holder.appendChild(el);

	$('#'+trigName).autocomplete("<?= app_base_url('/admisi/search?opsi=charity') ?>",
	{
	    parse: function(data){
		var parsed = [];
		for (var i=0; i < data.length; i++) {
		    parsed[i] = {
			data: data[i],
			value: data[i].jenis_acharity // nama field yang dicari
		    };
		}
		return parsed;
	    },
	    formatItem: function(data,i,max){
		var str='<div class=result><b style="text-transform:capitalize">'+data.jenis_charity+'</b> <i>Kode: '+data.id_jenis_charity+'</i></div>';
		return str;
	    },
	    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
	    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
	}).result(
	function(event,data,formated){
	    $('#'+trigName).attr('value',data.jenis_charity);
	    $('#'+destiID).attr('value',data.id_jenis_charity);
	}
	);

	counter++;

}

function removeMe2(el) {
	var parent = el.parentNode;
	parent.parentNode.removeChild(parent);
}


function removeHtmlTag(strx){
	if(strx.indexOf("<")!=-1) {
		var s = strx.split("<");
		for(var i=0;i<s.length;i++){
		if(s[i].indexOf(">")!=-1){
			s[i] = s[i].substring(s[i].indexOf(">")+1,s[i].length);
		}
	}
	strx = s.join(" ");
	}
	return strx;
}

/*
if (document.layers) {
           document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;
} else {
           document.onmouseup=clickNS;document.oncontextmenu=clickIE;
}

document.oncontextmenu=new Function("return false")    
*/ 
$(function() {
	//Aksi DOM umur
	$('#umur-hari, #umur-bulan, #umur-tahun').blur(function(){
	    if($('#umur-hari').attr('value')==0) $('#umur-hari').attr('value', '0');
	    if($('#umur-bulan').attr('value')==0) $('#umur-bulan').attr('value', '0');
	    if($('#umur-tahun').attr('value')==0) $('#umur-tahun').attr('value', '0');
	    var now=new Date();
	    var hari =now.getUTCDate()-$('#umur-hari').attr('value');
	    var bulan =now.getUTCMonth()+1-$('#umur-bulan').attr('value');
	    var tahun =now.getYear()-$('#umur-tahun').attr('value')+1900;
	    if(hari==null) hari=0;
	    if(bulan==null) bulan=0;
	    if(tahun==null) tahun=0;
	    var jumlahHari;
	    var bulanTemp=(bulan==1)?12:bulan-1;
	    if(bulanTemp==1 || bulanTemp==3 || bulanTemp==5 || bulanTemp==7 || bulanTemp==8 || bulanTemp==10 || bulanTemp==12){
		jumlahHari=31;
	    }else if(bulanTemp==2){
		if(tahun % 4==0)
		    jumlahHari=29;
		else
		    jumlahHari=28;
	    }else{
		jumlahHari=30;
	    }
	    if(hari<=0){
		bulan--;
		hari+=jumlahHari;
	    }
	    if(bulan<=0){
		tahun=tahun--;
		bulan+=12;
	    }

	    $('#tglLahir').attr('value',hari+'/'+bulan+'/'+tahun);
	});
	$('#tglLahir').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: 'c-50:c+10',
                dateFormat : 'dd/mm/yy',
		onSelect: function(dateText, inst){
		    hitungUmur();
		}
	});
	$('#awal').datepicker({
		changeMonth: true,
		changeYear: true,
                dateFormat : 'dd/mm/yy'
	});
	
	$('#akhir').datepicker({
		changeMonth: true,
		changeYear: true,
                dateFormat : 'dd/mm/yy'
	});

        
	$('#tanggal').datepicker({
			changeMonth: true,
			changeYear: true,
                        dateFormat : 'dd/mm/yy'
	});
        
        

});

function parseDate(str) {
  var m = str.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
  return (m) ? new Date(m[3], m[2]-1, m[1]) : null;
}

function isNama(str){
  var reg=/^[a-zA-Z ]+$/g;
  return reg.test(str);
}

function getCookies(c_name)
{
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++)
  {
      x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
      y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
      x=x.replace(/^\s+|\s+$/g,"");
      if (x==c_name)
        {
        return unescape(y);
        }
      }
}

function setCookies(c_name,value,exminutes)
{
    var exdate=new Date();
    exdate.setMinutes(exdate.getMinutes()+exminutes,0,0);
    var c_value=escape(value) + ((exminutes==null) ? "" : "; expires="+exdate.toUTCString());
    //alert(c_value+'-->'+exdate.getMinutes()+''+exminutes);
    document.cookie=c_name + "=" + c_value;
}

//fungsi ini untuk standarisasi nama packing barang di autocomplete packing barang, digunakan pada saat menampilkan pilihan autocomplete 
function ac_nama_packing_barang(data,kustomisasi){
    //urutan parameter array generik,nama_barang,kekuatan,sediaan,nilai_konversi,satuan_terkecil,pabrik   
    var str='';
    str+='<div class=result>';
    str+='<b>'+data[1]+'</b>';          
    var kekuatan=(data[2]!=null&&data[2]!=0)?' '+data[2]:'';
    var sep_kekuatan=(data[2]!=null && data[2]!=0)&&(data[0]=='Generik'||data[0]=='Non Generik')?',':'';
    var sediaan='';
    if((data[3]!=null&&data[3]!='')&&(data[0]=='Generik'||data[0]=='Non Generik')){
        sediaan=(data[0]!=''&&data[0]!=null)?' '+data[3]:'';
    }
    var factory = (data[6] != null && data[6] != 'None')?data[6]:'';
    var pabrik='';
    var kustom='';
    if(kustomisasi==null){
        pabrik=(data[0]=='Generik')?'<br>\n\<b>Pabrik :</b><i>'+factory+'</i>':'';
    }else{
        pabrik=(data[0]=='Generik')?' '+factory:'';
        kustom='<br>\n\<b>'+kustomisasi[0]+' :</b><i>'+kustomisasi[1]+'</i>';
        if(kustomisasi[2]!=null){
            kustom+='<br>\n\<b>'+kustomisasi[2]+' :</b><i>'+kustomisasi[3]+'</i>';
        }
        
    }   
    str+='<i>'+kekuatan+sep_kekuatan+sediaan+' @'+data[4]+' '+data[5]+'</i>'+pabrik+kustom;
    str+='</div>';
    
    return str;       
}

//fungsi ini untuk standarisasi nama packing barang di autocomplete packing barang, digunakan pada saat autocomplete dipilih dan terisi di textbox
function nama_packing_barang(data){
    //urutan parameter array generik,nama_barang,kekuatan,sediaan,nilai_konversi,satuan_terkecil,pabrik  
    var kekuatan=(data[2]!=null && data[2]!=0)?' '+data[2]:'';
    var sep_kekuatan=(data[2]!=null && data[2]!=0)&&(data[0]=='Generik'||data[0]=='Non Generik')?',':'';
    var sediaan='';
    if(data[3]!=null&&data[3]!=''){
        sediaan=(data[0]!=''&&data[0]!=null)&&(data[0]=='Generik'||data[0]=='Non Generik')?' '+data[3]:'';
    }
    var factory = (data[6] != null && data[6] != 'None')?data[6]:'';
    var pabrik=(data[0]=='Generik')?' '+factory:'';
    var str=data[1]+kekuatan+sep_kekuatan+sediaan+' @'+data[4]+' '+data[5]+pabrik;
   
    return str;
}

function toUpper(obj) {
var mystring = obj.value;
var sp = mystring.split(' ');
var wl=0;
var f ,r;
var word = new Array();
for (i = 0 ; i < sp.length ; i ++ ) {
f = sp[i].substring(0,1).toUpperCase();
r = sp[i].substring(1).toLowerCase();
word[i] = f+r;
}
newstring = word.join(' ');
obj.value = newstring;
return obj.value;
}
