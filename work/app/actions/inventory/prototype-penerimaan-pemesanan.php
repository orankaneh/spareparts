<?set_time_zone();;
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-data.php";
  include_once 'app/actions/admisi/pesan.php';
  set_time_zone();
?>
<h2 class="judul">Simulasi Penerimaan 1</h2>
<script type="text/javascript">

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
                        $('#transaksi').html(fakturForm(data,++counter));
                        initAutocompleteBarang();
                    });
                }
            );
            $("#add-faktur").click(function(){
                $('#transaksi').append(fakturForm(null, ++counter));
                initAutocompleteBarang();
            });
        });
</script>
<div class="data-input">
    <form action="" method="GET" name="form">
    <fieldset><legend>Penerimaan</legend>
        <label for="Petugas">Petugas</label><?= User::$nama?>
    <label for="nosp">No SP</label><input type="text" name="nosp" id="nosp" value="<?= isset ($_GET['nosp'])?$_GET['nosp']:NULL?>"/>
    <label for="awal">Tanggal</label><input type="text" name="tgl_pemesanan" id="tanggal" value="<?= isset ($_GET['tgl_pemesanan'])?datefmysql($_GET['tgl_pemesanan']):NULL?>"/>
    <label for="awal">Suplier</label><input type="text" name="suplier" id="suplier" value="<?= isset ($_GET['suplier'])?$_GET['suplier']:NULL?>"/>
    </fieldset>
    </form>    
</div>
    
<div id="transaksi">

</div>
<fieldset class="input-process">
    <input type="submit" value="Tambah Faktur" class="tombol" id="add-faktur"/>
    <input type='submit' value='Simpan' class='tombol' />
</fieldset>

<script type="text/javascript">
    function initTanggal(){
        $('.tanggal').datepicker();
    }
    function hitungHarga(count,a){
        var jmlTerima=getIntVal($('#jmlterima_'+count+"_"+a).attr('value'));
        var harga=getIntVal($('#harga_'+count+"_"+a).attr('value'));
        var diskon=getIntVal($('#diskon_'+count+"_"+a).attr('value'));
        $('#total_'+count+"_"+a).html((jmlTerima*harga)-diskon);
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
                                    "<td align='center'><input type='text' name='barang' class='barang ac_inputs'  autocomplete='off' /></td>"+
                                    "<td align='center'><input type='text' name='nobatch' /></td>"+
                                    "<td align='center'><input type='text' name='tanggal' id='tglkadaluarsa' class='tanggal'/></td>"+
                                    "<td align='center'><input type=text></td>"+
                                    "<td align='center'><input type='text' name='jmlterima' id='jmlterima_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td></td>"+
                                    "<td align='center'><input type='text' name='harga_"+count+"_"+index+"' id='harga_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td align='center'><input type='text' name='diskon_"+count+"_"+index+"' id='diskon_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td id='total_"+count+"_"+index+"' class='jumlah_"+count+"'></td>"+
                                    "<td><input type='button' onclick='hapusBarang("+count+","+index+",this)' value='Hapus' class='tombol'></td>";
                                  "</tr>";
        $('#table_faktur_'+count).append(html);
        initAutocompleteBarang();
    }
    function hapusBarang(count,index,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var baris=$('.nomor_'+count);
        for(var i=0;i<baris.length;i++){
           $('.nomor_'+count+':eq('+i+')').html(i+1);
        }
    }
    function getIntVal(val){
        if(val==null){
            return 0;
        }else return val*1;
    }
    function tambahPenerimaan(index){
        $('#penerimaan_field_'+index).append(addPenerimaan(index));
        initTanggal();
    }
    function initAutocompleteBarang(){
        initTanggal();
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
    }
    function fakturForm(barang,count){
        var html="\n\
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
                            if(barang!=null){
                                for(var index=0;index<barang.length;index++){
                                   html+="<tr>"+
                                    "<td align='center' class='nomor_"+count+"'>"+(index+1)+"</td>"+
                                    "<td align='center'><input type='text' name='barang' class='barang ac_inputs' value='"+barang[index].nama_barang+"' autocomplete='off' /></td>"+
                                    "<td align='center'><input type='text' name='nobatch' /></td>"+
                                    "<td align='center'><input type='text' name='tanggal' id='tgl' class='tanggal'/></td>"+
                                    "<td align='center'><input type=text value='"+barang[index].jumlah_pesan+"'></td>"+
                                    "<td align='center'><input type='text' name='jmlterima' id='jmlterima_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td>"+barang[index].satuan+"</td>"+
                                    "<td align='center'><input type='text' name='harga_"+count+"_"+index+"' id='harga_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td align='center'><input type='text' name='diskon_"+count+"_"+index+"' id='diskon_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td id='total_"+count+"_"+index+"' class='jumlah_"+count+"'></td>"+
                                    "<td><input type='button' onclick='hapusBarang("+count+","+index+",this)' value='Hapus' class='tombol'></td>"+
                                  "</tr>";
                                }
                                index--;
                            }else{
                                var index=0;
                                html+="<tr>"+
                                    "<td align='center' class='nomor_"+(count)+"'>"+(index+1)+"</td>"+
                                    "<td align='center'><input type='text' name='barang' class='barang ac_inputs'  autocomplete='off' /></td>"+
                                    "<td align='center'><input type='text' name='nobatch' /></td>"+
                                    "<td align='center'><input type='text' name='tanggal' id='tgl' class='tanggal'/></td>"+
                                    "<td align='center'><input type=text name=jmlSp></td>"+
                                    "<td align='center'><input type='text' name='jmlterima' id='jmlterima_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td></td>"+
                                    "<td align='center'><input type='text' name='harga_"+count+"_"+index+"' id='harga_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td align='center'><input type='text' name='diskon_"+count+"_"+index+"' id='diskon_"+count+"_"+index+"' onblur='hitungHarga("+count+","+index+")' /></td>"+
                                    "<td id='total_"+count+"_"+index+"' class='jumlah_"+count+"'></td>"+
                                    "<td><input type='button' onclick='hapusBarang("+count+","+index+",this)' value='Hapus' class='tombol'></td>"+
                                  "</tr>";
                            }
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
                "</fieldset>\n\
        ";
            return html;
    }
    function addPenerimaan(index){
        var html='<fieldset>'+
        '    <table>'+
        '        <tr>'+
        '            <td>Tanggal</td><td> :</td> <td><input type="text" name="tanggal" id="tanggal" class="tanggal"/></td><td> Petugas</td><td> :</td><td><?= $_SESSION['nama'] ?></td>'+
        '        </tr>'+
        '    </table>'+
        '    <table id="tblPemesanan" class="tabel" style="width: 50%" cellpadding="0" cellspacing="0">'+
        '    <tr>'+
        '        <th>No</th>'+
        '        <th>Nama Barang</th>'+
        '        <th>No Faktur</th>'+
        '        <th>No Batch</th>'+
        '        <th>Tgl Kadaluarsa</th>'+
        '        <th>Jml Terima</th>'+
        '    </tr>'+
        '    <tr>'+
        '        <td align="center">1</td>'+
        '        <td align="center"><input type="text" name="barang" id="barang-penerimaan" class="barang ac_inputs" autocomplete="off"/></td>'+
        '        <td align="center"><input type=text name=faktur></td>'+
        '        <td align="center"><input type="text" name="nobatch" /></td>'+
        '        <td align="center"><input type="text" name="tanggal" id="tglLahir" /></td>'+
        '        <td align="center"><input type="text" name="diskon" /></td>'+
        '    </tr>'+
        '</table><br/>'+
        '</fieldset>';
        return html;
    }
</script>