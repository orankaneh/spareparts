<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$code = isset($_GET['code'])?$_GET['code']:NULL;
$sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$key = isset($_GET['key'])?$_GET['key']:NULL;
$category = isset ($_GET['category'])?$_GET['category']:NULL;
$perPage = 15;
$layanan = layanan_muat_data($code, $sort,$sortBy, $page,$perPage,$key,$category);
$numb=nomer_paging($page,$perPage);
?>
<script type="text/javascript">
  $(function(){
      $('#nama').focus();
  })
</script>
<div class="judul"><a href="<?= app_base_url('admisi/data-layanan')?>">Master Data Layanan</a></div><?php echo isset($pesan)?$pesan:NULL;?>
<?
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'add') {
            require_once 'app/actions/admisi/add-layanan.php';
    }
    else if ($_GET['do'] == 'edit') {
            require_once 'app/actions/admisi/edit-layanan.php';
    }
}
?>
<script type="text/javascript">
$(function() {
        $('#spesialisasi').autocomplete("<?= app_base_url('/admisi/search?opsi=spesialisasi') ?>",
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
                        var str='<div class=result><b style="text-transform:capitalize">Spesialisasi: '+data.nama+'<br />Profesi: '+data.profesi+'</div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#spesialisasi').attr('value',data.profesi+' '+data.nama);
                $('#idSpesialisasi').attr('value',data.id);
            }
        );
            
        $('#k_tarif').autocomplete("<?= app_base_url('/inventory/search?opsi=data_kategori_tarif') ?>",
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
                    if(data.keterangan == null ){
                    keterangan = "";
                    }else{keterangan = " "+data.keterangan;}
                    
                    var str = '<div class=result>'+data.nama+'<br/> <i>'+keterangan+'</i></div>';
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                if(data.keterangan == null){
                   keterangan = "";
                }else  keterangan = " "+data.keterangan;
                $('#idk_tarif').attr('value',data.id);
                $('#k_tarif').attr('value',data.nama);
            }
        );

});

$(function() {
        $('#instalasi').autocomplete("<?= app_base_url('/admisi/search?opsi=instalasi') ?>",
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
                        var str='<div class=result><b style="text-transform:capitalize">'+data.nama+'</div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#instalasi').attr('value',data.nama);
                $('#idInstalasi').attr('value',data.id);
                //$('#jenis').val(data.jenis);
            }
        );
});
function checkdata(form) {   
    
    if($("input[name=nama]",form).val()== "") {
        alert('Nama layanan tidak boleh kosong');
        $("input[name=nama]",form).focus();
        return false;
    }
    if($('#idk_tarif').attr('value')==''){
      alert('kategori tarif tidak ditemukan');
      $('#idk_tarif').focus();
      return false;
    }

    else if($("input[name=idSpesialisasi]",form).val() == ""){
        $.ajax({
                url: "<?= app_base_url('/admisi/search?opsi=spesialisasi') ?>",
                data:'&q='+$("input[name=spesialisasi]",form).attr('value'),
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if (msg.length==1){
                        $("input[name=spesialisasi]",form).attr('value',msg[0].nama);
                        $("input[name=idSpesialisasi]",form).attr('value',msg[0].id);
                        cekForm();
                    }if(msg.length==0 || $("input[name=spesialisasi]",form).attr('value')==''){
                        alert('Spesialisasi belum ditemukan',form);
                        $("input[name=spesialisasi]",form).focus();
                    }else if(msg.length>1){
                        alert('Data spesialisasi ambigu, silakan input ulang');
                        $("input[name=spesialisasi]",form).focus();
                    }
                }
            });
            return false;    
    }
    else if($("input[name=idInstalasi]",form).val() == ""){
        $.ajax({
                url: "<?= app_base_url('/admisi/search?opsi=instalasi') ?>",
                data:'&q='+$("input[name=instalasi]",form).attr('value'),
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if (msg.length==1){
                        $("input[name=instalasi]",form).attr('value',msg[0].nama);
                        $("input[name=idInstalasi]",form).attr('value',msg[0].id);
                        cekForm();
                    }if(msg.length==0 || $("input[name=instalasi]",form).attr('value')==''){
                        alert('Instalasi belum ditemukan',form);
                        $("input[name=instalasi]",form).focus();
                    }else if(msg.length>1){
                        alert('Data instalasi ambigu, silakan input ulang');
                        $("input[name=instalasi]",form).focus();
                    }
                }
            });
            return false;
    }
    else if($("select[name=jenis]",form).val() == ""){
        alert('jenis tidak boleh kosong');
        $("select[name=jenis]",form).focus();
        return false;
    }
    return true;
}
function cekForm(){
  if($('#idk_tarif').attr('value')==''){
      alert('kategori tarif tidak ditemukan');
      $('#idk_tarif').focus();
      return false;
  }
}
function cekLayanan(){
    
    $.ajax({
        url: "<?= app_base_url('inventory/search?opsi=cek_layanan')?>",
        data:'&nama='+$('#nama').attr('value'),
        cache: false,
        dataType: 'json',
        success: function(msg){
            return msg.status;
        }
     });
}

$(document).ready(function(){
        $("form[name=dataform]").submit(
                
                function(event){
                    event.preventDefault();
                    
                    if(checkdata($("form[name=dataform]"))){
                        $.ajax({
                            url:"<?= app_base_url('admisi/search?opsi=cek_valid_layanan')?>",                        
                            data:$("form[name=dataform]").serialize(),
                            cache: false,
                            dataType: 'json',
                            success: function(msg){
                                if(msg.status){                          
                                    $("form[name=dataform]").unbind('submit').submit();    
                                }else{                            
                                    alert("Layanan sudah ada di database");                
                                 }
                            }
                         });
                    }
                }
            );

});
$(document).ready(function()
{
   /* $(".block").after('<span class="tooltip" style="width: 0px; height: 0px;"><span style="display: none;"></span></span>');
    $(".block").mouseover(function(event)
    {
        event.preventDefault();
        var index          = $(".block").index($(this));
        var tooltipContent = $("span.tooltip").eq(index).children().html();
        if(tooltipContent == '' || tooltipContent == null)
        {
            var value = '<ul class="tooltip" style="">';
            $.ajax(
            {
                url: "<?= app_base_url('/inventory/search?opsi=paging_data_layanan') ?>",
                data:'&page='+$(this).html()+'&perPage=<?= $perPage?><?=isset($_GET['category'])?"&category=".$_GET['category']:""?><?=isset($_GET['sort'])?"&sort=".$_GET['sort']:""?><?=isset($_GET['sortBy'])?"&sortBy=".$_GET['sortBy']:""?><?=isset($_GET['key'])?"&key=".$_GET['key']:""?>',
                cache: false,
                dataType: 'json',
                success: function(data)
                {
                    for(var i=0;i<data.length;i++)
                    {
                        value += '<li>'+data[i].nama+" ";
						value += data[i].profesi != null&&data[i].profesi != 'Tanpa Profesi' ? data[i].profesi+" " : "";
						value += data[i].spesialisai != null&&data[i].spesialisai != 'Tanpa Spesialisasi' ? data[i].spesialisasi+" " : "";
						value += data[i].bobot != null&&data[i].bobot != 'Tanpa Bobot' ? data[i].bobot+" " : "";
						value += data[i].instalasi != null&&data[i].instalasi != 'Tanpa Instalasi' ? data[i].instalasi+" " : "";
                        value += '</li>';
                    }
                    value += '</ul>';
                    $("span.tooltip").eq(index).children().html(value);
                    $("span.tooltip").eq(index).mouseover();
                }
            });
        } else
            $("span.tooltip").eq(index).mouseover();
    });
    
    $("span.tooltip").tipsy(
    {
        gravity:'w',
        html:true,
        title:function(){return $(this).children().html()}
    });    
    $(".block").mouseout(function(event)
    {
        var index = $(".block").index($(this));
        $("span.tooltip").eq(index).mouseout();
    });*/
});
</script>
<script type="text/javascript">
  $(function(){
         if($('#category').val()!=0){
            $('#keyword').removeAttr("disabled");
        }else{
            $('#category').change(function(){
                if($('#category').val()!=0){
                    $('#keyword').removeAttr("disabled");
                }else{
                    $('#keyword').attr("disabled","disabled");
                }
            });
        }
  })
  </script>
<div class="data-list w900px">
        <div class="floleft">
            <?php echo addButton('/admisi/data-layanan/?do=add','Tambah'); ?>
        </div>
        <div class="floright" style="margin: -5px 0 0 0">
         <form action="<?=app_base_url('admisi/data-layanan')?>" method="GET" class="search-form"> 
       <select name="category" id="category" class="select-style" style="width: 150px">
          <option value="0">Cari Berdasarkan</option>
          <option value="1" <?if($category == 1){echo "selected";}?>>Nama</option>
          <option value="2" <?if($category == 2){echo "selected";}?>>Profesi</option>
       </select>    
       <input type="text" name="key" value="<?=get_value('key')?>" class="search-input" id="keyword" <?=(empty($_GET['key'])?'disabled':'')?>/>
       <input type="submit" value="" name="cari" class="search-button"/>
       </form>
        </div>
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel full">
        <tr>
            <th style=" width: 5%">NO</th>
          <th><a href="<?= app_base_url('admisi/data-layanan?').generate_sort_parameter(2, $sortBy)?>" class="sorting">Nama</a></th>
            <th><a href="<?= app_base_url('admisi/data-layanan?').generate_sort_parameter(5, $sortBy)?>" class="sorting">Profesi</a></th>
            <th><a href="<?= app_base_url('admisi/data-layanan?').generate_sort_parameter(4, $sortBy)?>" class="sorting">Spesialisasi</a></th>
            <th>Bobot</th>
            <th><a href="<?= app_base_url('admisi/data-layanan?').generate_sort_parameter(3, $sortBy)?>" class="sorting">Instalasi</a></th>
            <th>Jenis</th>
            <th>Kategori Tarif</th>
            <th style=" width: 15%">Aksi</th>
        </tr>
        <?
        foreach ($layanan['list'] as $num => $row){
		if ($row['bobot'] == 'Tanpa Bobot') $bobot = "";
			else $bobot = $row['bobot'];
			
		if ($row['profesi'] == 'Tanpa Profesi') $profesi = "";
		else $profesi = $row['profesi'];
		
		$spesialisasi = "";
		if ($row['spesialisasi'] == 'Tanpa Spesialisasi') $spesialiasi= "";
		else $spesialisasi = $row['spesialisasi'];
		
		if ($row['instalasi'] == 'Tanpa Instalasi') $instalasi= "";
		else if ($row['instalasi'] == 'Semua') $instalasi = "";
		else $instalasi = $row['instalasi'];
		
		
		$layanans = "$row[nama]";
		
        ?>
          <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
            <td align="center"><?= $numb++?></td>
            <td class="no-wrap"><?= $layanans ?></td>
            <td class="no-wrap"><?= $profesi ?></td>
            <td class="no-wrap"><?= $spesialisasi ?></td>
            <td class="no-wrap"><?= $bobot ?></td>
            <td class="no-wrap"><?= $instalasi ?></td>
            <td class="no-wrap"><?= $row['jenis'] ?></td>
            <td class="no-wrap"><?= $row['nama_ktarif'] ?></td>
            <td class="aksi">
            
        <?   
		$no=$row['id'];
		
		 if ($no == '1' || $no == '2' || $no == '790' || $no == '803'){
		echo "-";
		}
		else {
		?>
                <a href="<?= app_base_url('admisi/data-layanan/?do=edit&id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id'))?>" class="edit"><small>edit</small></a>
                <a href="<?= app_base_url('admisi/control/layanan/?id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id'))?>" class="delete"><small>delete</small></a>
            </td>
          </tr>    
        <?
		}
		$num += 1;
        }
        ?>
   </table>             
</div>
<?= (isset($layanan['paging']))?$layanan['paging']:null ?>