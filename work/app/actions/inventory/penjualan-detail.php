<head>
    <style type="text/css">
        body {
            font-size: 0.9em;
            font-family: Arial;
        }
        
        table{
            border:1px solid black;
            width: 75%;
        }
        
        th{
            background: #999999;
            border-left: 1px solid black;
        }
        
        td{
            border-left: 1px solid black;
            
        }
    </style>
    <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/jquery.autocomplete.css') ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>" media="all" />
        <script type="text/javascript" src="<?= app_base_url('/assets/js/jquery-latest.js') ?>"></script>
        <script type="text/javascript" src="<?= app_base_url('/assets/js/jquery.autocomplete.js') ?>"></script>
        <script type="text/javascript">
            
            $(document).ready(function(){
                var nopenjualan;
                var id_kelas;
                   $('#no_penjualan').autocomplete("<?= app_base_url('inventory/search?opsi=kodetemppenjualan') ?>",
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
                            if (data.nama_pembeli == null) {
                            var str='<div class=result>'+data.id+' '+data.jenis+' <br/> '+data.waktu+'</i></div>';
                            } else {
                            var str='<div class=result>'+data.id+' '+data.nama_pembeli+' <i>'+data.jenis+' <br/> '+data.waktu+'</i></div>';
                            }
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                        $('#no_penjualan').attr('value',data.id);
                        $('#nama_dokter').html(data.nama_dokter==null?'':data.nama_dokter);
                        $('#nama_pembeli').html(data.nama_pembeli==null?'':data.nama_pembeli);
                        $('#no_rm').html(data.no_rm==null?'':data.no_rm);
                        $('#kelas').html(data.kelas==null?'':data.kelas);
                        $('#id_kelas').html(data.id_kelas==null?'':id_kelas);
                        //console.log(data.biaya_apoteker+''+data.total_tagihan);                        
                        nopenjualan =data.id;
                        id_kelas=data.id_kelas==null?'':'&kelas='+data.id_kelas;
                            if(nopenjualan!=null){
                            $.ajax({
                                url: "<?=  app_base_url('inventory/penjualan-detail-table')?>",
                                cache: false,
                                data:'id='+nopenjualan+id_kelas+'&mode=search',
                                success: function(msg){
                                    $('#detail-penjualan').html(msg);
                                    $('input[name=tombol]').removeAttr("disabled","disabled");

                                }
                            }

                            );
                        }
                }
            );             
                
                $('#tombol').live('click',function(){
                        window.opener.document.forms[0].temp_penjualan.value=nopenjualan;
                        window.opener.loadData(nopenjualan,id_kelas);
                        window.close();
                });
            });
            
        </script>
</head>
        
        
    
        <div class="data-input">
 
<fieldset><legend>Form Pencarian Penjualan</legend>
     
    <label for="no_penjualan">No. Penjualan Temp</label><input type="text" name="no_penjualan" id="no_penjualan"/>
    <label for="no_penjualan">Nama Dokter</label><span id="nama_dokter"></span>
    <label for="no_penjualan">No RM</label><span id="no_rm"></span>
    <label for="no_penjualan">Pembeli/Pasien</label><span id="nama_pembeli"></span>
    <label for="no_penjualan">Kelas</label><span id="kelas"><input type="hidden" id="id_kelas" name="id_kelas"/></span>
    
    
</fieldset>
        <fieldset><legend>Detail Penjualan Temp</legend>
        <div id="detail-penjualan">
            
        </div>            
        </fieldset>    

</div>    

<?php
        exit();
?>