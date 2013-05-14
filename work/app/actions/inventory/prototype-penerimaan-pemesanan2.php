<?set_time_zone();;
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-data.php";
  include_once 'app/actions/admisi/pesan.php';
  set_time_zone();
?>
<h2 class="judul">Simulasi Penerimaan 1</h2>
<script type="text/javascript">
    function getDate(){
        return getDay()+'/'+getMonth()+'/'+getYear();
    }
    var count=0;
    var banyak_barang_penerimaan_kurang=0;
    var faktur=[{"petugas":"Hettyca Astuningdyas","tanggal":"01/02/2010","no_faktur":"001","barang":[{"nosp":"2","nama_barang":"Milanta","jumlah_pesan":"90","jumlah_terima":"50","harga":"1000","diskon":"10000","satuan":"box","batch":"001"},
        {"nosp":"2","nama_barang":"Bodrex","jumlah_pesan":"100","jumlah_terima":"100","harga":"1000","diskon":"10000","satuan":"butir","batch":"004"},
        {"nosp":"2","nama_barang":"Budreksin","jumlah_pesan":"60","jumlah_terima":"50","harga":"10000","diskon":"10000","satuan":"butir","batch":"001"}]},
        {"petugas":"dr. Adhi Midjaja, Sp. A ","tanggal":"01/02/2010","no_faktur":"002","barang":[{"nosp":"2","nama_barang":"Milanta","jumlah_pesan":"90","jumlah_terima":"50","harga":"1000","diskon":"10000","satuan":"box","batch":"001"},
        {"nosp":"2","nama_barang":"Bodrex","jumlah_pesan":"100","jumlah_terima":"100","harga":"1000","diskon":"10000","satuan":"butir","batch":"004"}]}];
    var ppn=10;
    var materai=6000;
    function getBarangKurang(){
        var brg=new Object();
        var barang=new Object();
        var a=0;
        for(var index=0;index<faktur.length;index++){
            barang=faktur[index].barang;
            for(var i=0;i<barang.length;i++){
                if(barang[i].jumlah_terima<barang[i].jumlah_pesan){
                    brg[a]=barang[i];
                    a++;
                }
            }
        }
        banyak_barang_penerimaan_kurang=a;
        return brg;
    }
    var counter;
        $(function() {
            $('#nosp').autocomplete("<?= app_base_url('/inventory/search?opsi=nosp') ?>",
            {
                        parse: function(data){
                            var parsed = [];
                            for (var i=0; i < data.length; i++) {
                                parsed[i] = {
                                    data: data[i],
                                    value: data[i].id
                                };
                            }
                            return parsed;
                        },
                        formatItem: function(data,i,max){
                            var str='<div class=result>NO SP: '+data.id+'</div>';
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $('#nosp').attr('value',data.id);
                    $.getJSON('<?= app_base_url('/inventory/search?opsi=nosp2')?>&q='+$('#nosp').val(), function(data) {
                        $('#transaksi').html(fakturForm(faktur  ,++counter));
                        initTanggal();
                        initAutocompleteBarang();
                    });
                }
            );
            $("#add-faktur").click(function(){
                $('#transaksi').append(fakturForm(null, ++counter));
                initAutocompleteBarang();
                initTanggal();
            });
        });
</script>
<div class="data-input">
    <form action="" method="GET" name="form">
    <fieldset><legend>Penerimaan</legend>
        <label for="Petugas">Petugas</label><?= User::$nama?>
    <label for="nosp">No SP</label><input type="text" name="nosp" id="nosp" value="<?= isset ($_GET['nosp'])?$_GET['nosp']:NULL?>"/>
    <label for="awal">Tanggal</label><input type="text" name="tgl_pemesanan" value="<?= isset ($_GET['tgl_pemesanan'])?datefmysql($_GET['tgl_pemesanan']):NULL?>"/>
    <label for="awal">Suplier</label><input type="text" name="suplier" id="suplier" value="<?= isset ($_GET['suplier'])?$_GET['suplier']:NULL?>"/>
    </fieldset>
    </form>
</div>

<div id="transaksi"></div>
<div id="penerimaan_field"></div>
<fieldset class="input-process">
    <input type="submit" value="Tambah Faktur" class="tombol" id="add-faktur"/>
    <input type='submit' value='Simpan' class='tombol' />
    <input type="button" id="add-penerimaan" value="Tambah Penerimaan" class="tombol" onclick="tambahPenerimaan()">
</fieldset>
<script type="text/javascript">
    function initTanggal(){
        $('.tanggal').datepicker({
                        changeMonth: true,
                        changeYear: true
                });
    }
    function hapusBarang(count,index,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var baris=$('.nomor_'+count);
        for(var i=0;i<baris.length;i++){
           $('.nomor_'+count+':eq('+i+')').html(i+1);
        }
    }
    function hitungHarga(count,a){
        var jumlah_terima=getIntVal($('#jumlah_terima_'+count+"_"+a).attr('value'));
        var harga=getIntVal($('#harga_'+count+"_"+a).attr('value'));
        var diskon=getIntVal($('#diskon_'+count+"_"+a).attr('value'));
        $('#total_'+count+"_"+a).html((jumlah_terima*harga)-diskon);
        hitungJumlahTransaksi(count);
    }
    function hitungJumlahTransaksi(count){
        var ppn=getIntVal($('#ppn_'+count).attr('value'));
        var materai=getIntVal($('#materai_'+count).attr('value'));
        //array jumlah
        var jumlah=$('.jumlah_'+count);
        var total=0;
        for(var i=0;i<jumlah.length;i++){
            total+=(getIntVal($('#total_'+count+'_'+i).html())*1);
        }
        var jumlah_bayar=total+ppn+materai;
        $('#jumlah_bayar_'+count).attr('value', jumlah_bayar);
    }
    function tambahBarang(count){
        var index=$('#count_'+count).attr('value');
        index++; 
        $('#count_'+count).attr('value',index);
        var nomor=$('.nomor_'+count).length+1;
        var html="<tr>"+
                                    "<td align='center' class='nomor_"+count+"'>"+nomor+"</td>"+
                                    "<td align='center'><input type='text' name='barang' class='barang'  autocomplete='off' /></td>"+
                                    "<td align='center'><input type='text' name='nobatch' /></td>"+
                                    "<td align='center'><input type='text' name='tanggal'  class='tanggal'/></td>"+
                                    "<td align='center'><input type=text name=jumlah_pesan></td>"+
                                    "<td align='center'><input type='text' name='jumlah_terima' id='jumlah_terima_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td></td>"+
                                    "<td align='center'><input type='text' name='harga_"+count+"_"+index+"' id='harga_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td align='center'><input type='text' name='diskon_"+count+"_"+index+"' id='diskon_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td id='total_"+count+"_"+index+"' class='jumlah_"+count+"'></td>"+
                                    "<td><input type='button' onclick='hapusBarang("+count+","+index+",this)' value='Hapus' class='tombol'></td>";
                                  "</tr>";
        $('#table_faktur_'+count).append(html);
        initAutocompleteBarang();
    }
    function editBarang(count,index,el){
        var idx='_'+count+'_'+index;
        if($('#edit_'+count+'_'+index).attr('value')=='Edit'){
            $('.disable'+idx).removeAttr('disabled');
            $('#edit_'+count+'_'+index).attr('value','Simpan');
        }else{
            $('.disable'+idx).attr('disabled','disabled');
            faktur[count].barang[index].nama_barang=$('#nama_barang'+idx).attr('value');
            faktur[count].barang[index].jumlah_pesan=$('#jumlah_pesan'+idx).attr('value');
            faktur[count].barang[index].jumlah_terima=$('#jumlah_terima'+idx).attr('value');
            faktur[count].barang[index].harga=$('#harga'+idx).attr('value');
            faktur[count].barang[index].diskon=$('#diskon'+idx).attr('value');
            faktur[count].barang[index].batch=$('#no_batch'+idx).attr('value');
            $('#edit_'+count+'_'+index).attr('value','Edit');
        }

    }
    function getIntVal(val){
        if(val==null){
            return 0;
        }else return val*1;
    }
    function tambahPenerimaan(){
        if($('#penerimaan_field').html()==""){
            $('#penerimaan_field').append(addPenerimaan(getBarangKurang()));
        }else{
            addBarangPenerimaan();
        }
        initTanggal();
        initAutocompleteBarang();
    }
    function initAutocompleteBarang(){
        $('.barang').autocomplete('<?= app_base_url('/inventory/search?opsi=barangsp')?>',
                    {
                        parse: function(data){
                                var parsed = [];
                                for (var i=0; i < data.length; i++) {
                                    parsed[i] = {
                                        data: data[i],
                                        value: data[i].nama_barang// nama field yang dicari
                                    };
                                }
                                return parsed;
                            },
                         formatItem: function(data,i,max){
                                var str='<div class=result><b>'+data.nama_barang+'</b><br /><i>Satuan:</i> '+data.satuan+'</div>';
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                   }).result(
                    function(event,data,formated){
                        $(this).val(data.nama_barang);
                        $(this).parent('td').parent('tr').children('td:eq(4)').children('input').attr('value',data.jumlah_pesan);
                        $(this).parent('td').parent('tr').children('td:eq(6)').html(data.satuan);
                    });
       $('.barang2').autocomplete('<?= app_base_url('/inventory/search?opsi=barangsp')?>',
                    {
                        parse: function(data){
                                var parsed = [];
                                for (var i=0; i < data.length; i++) {
                                    parsed[i] = {
                                        data: data[i],
                                        value: data[i].nama_barang// nama field yang dicari
                                    };
                                }
                                return parsed;
                            },
                         formatItem: function(data,i,max){
                                var str='<div class=result><b>'+data.nama_barang+'</b><br /><i>Satuan:</i> '+data.satuan+'</div>';
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                   }).result(
                    function(event,data,formated){
                        $(this).val(data.nama_barang);
                    });
             disbaledBarangForm();
    }
    function disbaledBarangForm(){
        for(var i=0;i<faktur.length;i++){
            for(var ii=0;ii<faktur[i].barang.length;ii++){
                $('.disable_'+i+'_'+ii).attr('disabled','disabled');
            }
        }
    }
    function fakturForm(faktur,count){
        var banyak_faktur=count;
        var html="";
        if(faktur!=null){
            for(count=0;count<=banyak_faktur;count++){
                html+="\n\
                <fieldset>"+
                        "<table>"+
                        "        <tr>"+
                        "            <td>No. Faktur</td><td> :</td> <td><input type='text' name='nofaktur' value='"+faktur[count].no_faktur+"'/></td><td> Jatuh Tempo</td><td> :</td><td> <input type=text name=jatuhTempo  class=tanggal></td><td>Petugas</td><td>:</td><td>"+faktur[count].petugas+"</td><td>Tanggal</td><td>:</td><td><input type=text name=tgl value='"+faktur[count].tanggal+"' class=tanggal></td>"+
                        "        </tr>"+
                        "    </table>"+
                        "        <table id='table_faktur_"+count+"' class='tabel' style='width: 80%' cellpadding='0' cellspacing='0'>"+
                        "           <tr>"+
                        "                <th>No</th><th>Nama Barang</th><th>No Batch</th><th>Tgl Kadaluarsa</th><th>Jml SP</th><th>Jml Terima</th><th>Satuan</th><th>Harga</th><th>Diskon</th><th>Total</th><th>Aksi</th>"+
                        "            </tr>";
                    var jumlah=0;
                    var tot=0;
                    for(var index=0;index<faktur[count].barang.length;index++){
                                tot=(faktur[count].barang[index].jumlah_terima*faktur[count].barang[index].harga-faktur[count].barang[index].diskon);
                                jumlah+=tot;
                                html+="<tr>"+
                                "<td align='center' class='nomor_"+count+"'>"+(1+index)+"</td>"+
                                "<td align='center'><input type='text' name='barang' class='disable_"+count+"_"+index+" barang' value='"+faktur[count].barang[index].nama_barang+"' autocomplete='off' id='nama_barang_"+count+"_"+index+"' /></td>"+
                                "<td align='center'><input type='text' name='nobatch' class='disable_"+count+"_"+index+"' value='"+faktur[count].barang[index].batch+"' id='no_batch_"+count+"_"+index+"' /></td>"+
                                "<td align='center'><input type=text name='tanggal' class='tanggal disable_"+count+"_"+index+"' id='tanggal_"+count+"_"+index+"'></td>"+
                                "<td align='center'><input type=text value='"+faktur[count].barang[index].jumlah_pesan+"' class='disable_"+count+"_"+index+"' name='jumlah_pesan' id='jumlah_pesan_"+count+"_"+index+"'></td>"+
                                "<td align='center'><input type='text' name='jumlah_terima' class='disable_"+count+"_"+index+"' value='"+faktur[count].barang[index].jumlah_terima+"' id='jumlah_terima_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                "<td>box</td>"+
                                "<td align='center'><input type='text' name='harga_"+count+"_"+index+"' class='disable_"+count+"_"+index+"' id='harga_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' value='"+faktur[count].barang[index].harga+"'/></td>"+
                                "<td align='center'><input type='text' name='diskon_"+count+"_"+index+"' id='diskon_"+count+"_"+index+"' class='disable_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' value='"+faktur[count].barang[index].diskon+"'/></td>"+
                                "<td id='total_"+count+"_"+index+"' class='jumlah_"+count+"'>"+tot+"</td>"+
                                "<td><input type='button' onclick='editBarang("+count+","+index+",this)' value='Edit' class='tombol' id='edit_"+count+"_"+index+"'></td>"+
                              "</tr>";
                    }
                    jumlah=jumlah+(jumlah*ppn)+materai;
                                html+="</table>"+
                                "<input type='hidden' name='count' value='"+index+"' id='count_"+count+"'>"+
                                " <fieldset class='input-process' style='margin-top: 10px;'>"+
                                "<span style='position:relative;float:right;right:121px;'>"+
                                "    <table>"+
                                "        <tr>"+
                                "            <td>PPN Rp.</td><td><input type='text' name='ppn'   id='ppn_"+count+"'  onblur='hitungJumlahTransaksi("+count+")' value='"+ppn+"'/></td>"+
                                "        </tr>"+
                                "        <tr>"+
                                "            <td>Materai Rp.</td><td><input type='text' name='materai'  id='materai_"+count+"' onblur='hitungJumlahTransaksi("+count+")' value='"+materai+"'/></td>"+
                                "        </tr>"+
                                "        <tr>"+
                                "            <td colspan='2'>____________________________ +</td>"+
                                "        </tr>"+
                                "        <tr>"+
                                "            <td>Total Rp.</td><td><input type='text' name='total'  disabled='disabled' value='"+jumlah+"' id='jumlah_bayar_"+count+"'/></td>"+
                                "        </tr>"+
                                "    </table>"+
                                "</span>"+
                                "</fieldset>"+
                                "<br/>"+
                        "</fieldset>";
                }
            }else{var index=0;
                html+="\n\
                <fieldset>"+
                        "<table>"+
                        "        <tr>"+
                        "            <td>No. Faktur</td><td> :</td> <td><input type='text' name='nofaktur' /></td><td> Jatuh Tempo</td><td> :</td><td> <input type='text' name='tempo' id='akhir' class='tanggal' /></td><td><input type='button' onclick='tambahBarang("+count+")' value='Tambah Barang' class='tombol'></td>"+
                        "        </tr>"+
                        "    </table>"+
                        "        <table id='table_faktur_"+count+"' class='tabel' style='width: 80%' cellpadding='0' cellspacing='0'>"+
                        "           <tr>"+
                        "                <th>No</th><th>Nama Barang</th><th>No Batch</th><th>Tgl Kadaluarsa</th><th>Jml SP</th><th>Jml Terima</th><th>Satuan</th><th>Harga</th><th>Diskon</th><th>Total</th><th>Aksi</th>"+
                        "            </tr>";
                    html+="<tr>"+
                                    "<td align='center' class='nomor_"+(count)+"'>"+(index+1)+"</td>"+
                                    "<td align='center'><input type='text' name='barang' class='barang ac_inputs'  autocomplete='off' /></td>"+
                                    "<td align='center'><input type='text' name='nobatch' /></td>"+
                                    "<td align='center'><input type='text' name='tanggal' class='tanggal'/></td>"+
                                    "<td align='center'><input type=text name=jmlSp></td>"+
                                    "<td align='center'><input type='text' name='jmlterima' id='jmlterima_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td></td>"+
                                    "<td align='center'><input type='text' name='harga_"+count+"_"+index+"' id='harga_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td align='center'><input type='text' name='diskon_"+count+"_"+index+"' id='diskon_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td id='total_"+count+"_"+index+"' class='jumlah_"+count+"'></td>"+
                                    "<td><input type='button' onclick='hapusBarang("+count+","+index+",this)' value='Hapus' class='tombol'></td>"+
                                  "</tr>";
                              html+="</table>"+
                        "<input type='hidden' name='count' value='"+index+"' id='count_"+count+"'>"+
                        "<span style='clear:left;position:relative;left:700px'>"+
                        "    <table>"+
                        "        <tr>"+
                        "            <td>PPN Rp.</td><td><input type='text' name='ppn'   id='ppn_"+count+"'  onblur='hitungJumlahTransaksi("+count+")'/></td>"+
                        "        </tr>"+
                        "        <tr>"+
                        "            <td>Materai Rp.</td><td><input type='text' name='materai'  id='materai_"+count+"' onblur='hitungJumlahTransaksi("+count+")'/></td>"+
                        "        </tr>"+
                        "        <tr>"+
                        "            <td colspan='2'>____________________________ +</td>"+
                        "        </tr>"+
                        "        <tr>"+
                        "            <td>Total Rp.</td><td><input type='text' name='total'  disabled='disabled' value='11000' id='jumlah_bayar_"+count+"'/></td>"+
                        "        </tr>"+
                        "    </table>"+
                        "</span>"+
                        "<br/>"+
                "</fieldset>";
            }
            return html;
    }
    function addPenerimaan(barang){
        $('#add-penerimaan').hide();
        var html='<fieldset>'+
        '    <table>'+
        '        <tr>'+
        '            <td>Tanggal</td><td> :</td> <td><input type="text" name="tanggal" class="tanggal"/></td><td> Petugas</td><td> :</td><td><?= $_SESSION['nama'] ?></td><td><input type="button" value="Tambah Barang" onclick="addBarangPenerimaan()" class="tombol"></td>'+
        '        </tr>'+
        '    </table>'+
        '    <table id="tblTambahPenerimaan" class="tabel" style="width: 50%" cellpadding="0" cellspacing="0">'+
        '    <tr>'+
        '        <th>No</th>'+
        '        <th>Nama Barang</th>'+
        '        <th>No Faktur</th>'+
        '        <th>No Batch</th>'+
        '        <th>Tgl Kadaluarsa</th>'+
        '        <th>Jml Terima</th>'+
        '        <th>Aksi</th>'+
        '    </tr>';
        for(var i=0;i<banyak_barang_penerimaan_kurang;i++){
            html+=''+
            '    <tr class="penerimaan_tr">'+
            '        <td align="center">'+(i+1)+'</td>'+
            '        <td align="center"><input type="text" name="barang" value="'+barang[i].nama_barang+'" id="barang-penerimaan" class="barang2" autocomplete="off"/></td>'+
            '        <td align="center"><input type=text name=faktur></td>'+
            '        <td align="center"><input type="text" name="nobatch" /></td>'+
            '        <td align="center"><input type="text" name="tanggal" class="tanggal"/></td>'+
            '        <td align="center"><input type="text" name="diskon" /></td>'+
            '        <td align="center"><input type="button" class="tombol" value="hapus" onclick="hapusBarangPenerimaan('+i+',this)"></td>'+
            '    </tr>';
        }
        html+=''+
        '</table><br/>'+
        '</fieldset>';
        return html;
    }
    function addBarangPenerimaan(){
        var count=$('.penerimaan_tr').length;
        var html=''+
            '    <tr class="penerimaan_tr">'+
            '        <td align="center">'+(count+1)+'</td>'+
            '        <td align="center"><input type="text" name="barang" id="barang-penerimaan" class="barang2" autocomplete="off"/></td>'+
            '        <td align="center"><input type=text name=faktur></td>'+
            '        <td align="center"><input type="text" name="nobatch" /></td>'+
            '        <td align="center"><input type="text" name="tanggal" class="tanggal"/></td>'+
            '        <td align="center"><input type="text" name="diskon" /></td>'+
            '        <td align="center"><input type="button" class="tombol" value="hapus" onclick="hapusBarangPenerimaan('+count+',this)"></td>'+
            '    </tr>';
        $('#tblTambahPenerimaan').append(html);
        initTanggal();
        initAutocompleteBarang();
    }
    function hapusBarangPenerimaan(count,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penerimaan=$('.penerimaan_tr');
        var countPenerimaanTr=penerimaan.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.penerimaan_tr:eq('+i+')').children('td:eq(0)').html(i+1);
        }
    }
</script>