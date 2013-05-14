<script type="text/javascript">
  $(function() {
        $('#nama').autocomplete("<?= app_base_url('/admisi/search?opsi=pasien') ?>",
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
                        //if (data.id_pasien == null) {
                        //var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                        //} else {
                        //var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                        var str='<div class=result><b>'+data.id+'</b> - '+data.nama+' <br/> <i>';
                            str+=data.alamat_jalan==null?'-':data.alamat_jalan;
                            str+=' ';
                            str+=data.kelurahan==null?'-':data.kelurahan;
                            str+='</i></div>';
                        //}
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                    $('#nama').attr('value',data.nama);
                    
            }
        );
});
</script>
<script type="text/javascript">
$(function() {
        $('#noRm').autocomplete("<?= app_base_url('/admisi/search?opsi=noRm') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].id_pasien // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result>'+data.id_pasien+' '+data.nama_pas+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#noRm').attr('value',data.id_pasien);                
            }
        );
});
</script>
<?php
$kategori = isset($_GET['kategori'])?$_GET['kategori']:NULL;

if($kategori == ''){
    exit ();
}
if($kategori == 1){?>
  <label for="nama">Nama</label>
  <input type='text' name='key' id="nama" class='form'/>
<?php exit ();}

if($kategori == 2){?>
    <label for="norm">No. RM</label>
    <input type='text' name='key' id="noRm" class="key"/>
<?php exit ();} 

