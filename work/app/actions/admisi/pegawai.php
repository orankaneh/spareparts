<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$key = isset ($_GET['key'])?$_GET['key']:NULL;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$sort = isset($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
$code = isset($_GET['code'])?$_GET['code']:NULL;
$dataPerPage = 15;
$no=nomer_paging($page,$dataPerPage);
$pegawaiList = pegawai_muat_data($code,$sort,$sortBy,$page,$dataPerPage,$key);

?>
<script type="text/javascript">
function checkdata() {
    var data=document.formpegawai;
    if (data.nip.value == "") {
        alert('NIP tidak boleh kosong');
        data.nip.focus();
        return false;
    }
    if (data.nama.value == "") {
        alert('Nama pegawai tidak boleh kosong');
        data.nama.focus();
        return false;
    }
    if(data.level.value == ""){
        alert('Level pegawai tidak boleh kosong');
        data.level.focus();
        return false;
    }
   // if(data.unit.value == ""){
     //   alert('Unit pegawai tidak boleh kosong');
       // data.level.focus();
        //return false;
    //}
	 if(data.no_identitas.value == ""){
        alert('no identitas tidak boleh kosong');
        data.no_identitas.focus();
        return false;
    }
    if(data.almt.value == ""){
        alert('Alamat tidak boleh kosong');
        data.almt.focus();
        return false;
    }
    if(data.kelurahan.value == ""){
        alert('Asal kelurahan tidak boleh kosong');
        data.kelurahan.focus();
        return false;
    }
    if(data.idKelurahan.value == ""){
        alert('Pilih asal kelurahan dengan benar');
        data.idKelurahan.focus();
        return false;
    }
    if((data.idProfesi.value == 3) && (data.sip.value == "")){
        alert('SIP wajib diisi');
		data.sip.value.focus();
        return false;
    }
    var telp = data.no_telp.value;
	if(telp.substring(0,1) != 0){
        alert('No. telp harus diawali dengan angka 0');
        data.no_telp.focus();
        return false;
    }
    return true;
}
function cekValidPegawai(){
    if(checkdata()){
        form=$('form[name=formpegawai]');
        $.ajax({
                url: "<?= app_base_url('/admisi/search?opsi=cekNip')?>",
                data:'&q='+$('#nip').attr('value')+'&'+'<?php if(isset ($_GET['do'])){echo $_GET['do']== "edit"?"edit=":"add=";}?>'+'&idpegawai='+$("#idpegawai").val(),
                cache: false,
                dataType: 'json',
                success: function(msg){
                        if (msg.length>=1){
                            alert("NIP pegawai tidak boleh sama");
                            $("#nip").val('');
                            $("#nip").focus();
                        }else{
                            $.ajax({
                                url: "<?= app_base_url('admisi/search?opsi=cek_valid_pegawai') ?>",
                                data:form.serialize(),
                                cache: false,
                                dataType: 'json',
                                success: function(msg){
                                    if(!msg.status){
                                        alert('Data pegawai tersebut sudah ada di database!');
                                        $('#nip').focus();
                                        return false;
                                    }else
                                        form.unbind("submit").submit();
                                }
                            });
                        }
                    }
                 });
             return false; 
    }
    else{
        return false;
    }
}

    $(document).ready(function(){
        $('#keyword').watermark('Nama pegawai');
        
        $("form[name=formpegawai]").submit(
            function(event){
                event.preventDefault();
               
                cekValidPegawai();
            }
        );
    });
</script>
<h2 class="judul"><a href="<?= app_base_url('admisi/pegawai')?>">Master Pegawai</a></h2>
<?php echo isset($pesan)?$pesan:NULL;?>
<?
  if(isset ($_GET['do'])){
      if($_GET['do'] == "edit"){
          include_once "edit-pegawai.php";
      }else if($_GET['do'] == "add"){
          include_once "add-pegawai.php";
      }
  }
?>

<div class="data-list full">
	<div class="floleft" style="padding: 10px 0">
		<?php 
		echo addButton("/admisi/pegawai/?do=add","Tambah"); 
		echo excelButton("admisi/report/pegawai-excel","Ekspor ke Excel"); ?>
	</div>
	<div class="floright">
      <form action="" method="GET" class="search-form">  
        <span style="float:right"><input type="text" name="key" class="search-input"  id="keyword" value="<?= $key?>"/><input type="submit" value="" class="search-button"/></span>
      </form>  
	</div>
    <table class="tabel full">
    
        <tr>
            <th><!--<a href='<?//=app_base_url('admisi/pegawai?').  generate_sort_parameter(1, $sortBy)?>' class='sorting'>D</a>-->NO</th>
            <th><a href='<?=app_base_url('admisi/pegawai?').  generate_sort_parameter(2, $sortBy)?>' class='sorting'>NIP</a></th>
            <th><a href='<?=app_base_url('admisi/pegawai?').  generate_sort_parameter(3, $sortBy)?>' class='sorting'>Nama Lengkap</a></th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Profesi</th>
            <th>Level</th>
            <!--<th>Unit</th>-->
            <th>Aksi</th>
        </tr>
<?php 

foreach($pegawaiList['list'] as $key => $row):?>
       
        <tr class="<?= ($key%2) ? 'even':'odd' ?>">
            <td width="3%" align="center"><?= $no++?></td>
            <td width="12%"><a href="<?= app_base_url('admisi/detail-pegawai')?>?id=<?= $row['id']?>" class=link title="Detail"><?= $row['nip'] ?></a></td>
            <td width="25%" class="no-wrap"><a href="<?= app_base_url('admisi/detail-pegawai')?>?id=<?= $row['id']?>" class=link title="Detail"><?= $row['nama'] ?></a></td>
            <td width="11%"><?= $row['kelurahan']?></td>
            <td width="11%"><?= $row['kecamatan']?></td>
            <td width="11%"><?= $row['profesi']?></td>
            <td width="11%" class="no-wrap"><?= $row['nama_level'] ?></td>
             <!-- <td width="11%" class="no-wrap"><?//$row['nama_unit'] ?></td>-->
            <td width="8%" class="aksi" width=40>
                <a href="<?= app_base_url("admisi/pegawai?do=edit&id=".$row['id']."")."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit" ><small>edit</small></a>
                <a href="<?= app_base_url("admisi/control/pegawai?do=delete&id=".$row['id']."")."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete" ><small>delete</small></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
</div>
<?= $pegawaiList['paging'] ?>

<? $count = $pegawaiList['total'];
      echo "<p>Jumlah Total Nama Pegawai: ".$count."</p>";?>

<script type="text/javascript">
    $(document).ready(function(){
       /* $(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                    url: "<?= app_base_url('/admisi/search?opsi=paging_pegawai') ?>",
                    data:'page='+$(this).html()+'&perPage=<?=$dataPerPage?>&<?= generate_get_parameter($_GET, null, array('page')) ?>',
                    cache: false,
                    dataType: 'json',
                    success: function(data){
                        data=data.list;
                        for(var i=0;i<data.length;i++){
                            value+='<li>'+data[i].nip+' '+data[i].nama+" ";
                            
                            value+='</li>';
                        }
                        value+='</ul>';
                        $("span.tooltip").eq(index).children().html(value);
                        $("span.tooltip").eq(index).mouseover();
                    }
                });
            }else{
                $("span.tooltip").eq(index).mouseover();
            }
        });*/
        
            
        $("span.tooltip").tipsy({
            gravity:'w',
            html:true,
            title:function(){return $(this).children().html()}
        });    
            
        $(".block").mouseout(function(event){
            var index=$(".block").index($(this));
            $("span.tooltip").eq(index).mouseout();
                
        });
    });
</script>