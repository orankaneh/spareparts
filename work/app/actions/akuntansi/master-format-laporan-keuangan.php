<?phprequire_once 'app/actions/admisi/pesan.php';require_once 'app/lib/common/master-akuntansi.php';$sort = isset($_GET['sort'])?$_GET['sort']:NULL;  $page = isset($_GET['page'])?$_GET['page']:1;$tab=(isset($_GET['tab']))?$_GET['tab']:'lr';?><h2 class="judul"><a href="#">Format Laporan Keuangan</a></h2><?= isset($pesan) ? $pesan : NULL ?><script type="text/javascript">function initAutocomplete(count,to,hidden,url){        $('#'+to+count).unautocomplete().autocomplete(url,        {            parse: function(data){                var parsed = [];                for (var i=0; i < data.length; i++) {                    parsed[i] = {                        data: data[i],                        value: data[i].nama // nama field yang dicari                    };                }                return parsed;            },            formatItem: function(data,i,max){                var str='<div class=result>'+data.nama+'<br><i>Kode:</i> '+data.kode+'</div>';                return str;            },            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON        }).result(        function(event,data,formated){           $(this).attr('value',data.nama);           $('#'+hidden+count).attr('value',data.id);        }        );   }$(document).ready(function() {	$("ul.tabs li").click(function() {		$("ul.tabs li").removeClass("active"); 		$(this).addClass("active");		$(".tab_content").hide(); 		var activeTab= $(this).find("a").attr("href"); 		$(activeTab).fadeIn(); 		return false;	});	});</script><br /><ul class="tabs">    <li class="<?=($tab=='lr')?'active':''?>"><a href="#lr">Laporan Laba Rugi</a></li>    <li class="<?=($tab=='pm')?'active':''?>"><a href="#pm">Laporan Perubahan Modal</a></li>    <li class="<?=($tab=='n')?'active':''?>"><a href="#n">Neraca</a></li></ul><div class="tab_container">    <?php        echo "<div id='lr' class='tab_content ".(($tab==NULL)?'active':'')."'>";            require_once 'app/actions/akuntansi/format-laba-rugi.php';        echo '</div>';        echo "<div id='pm' class='tab_content ".(($tab==NULL)?'active':'')."'>";            require_once 'app/actions/akuntansi/format-perubahan-modal.php';        echo '</div>';        echo "<div id='n' class='tab_content ".(($tab==NULL)?'active':'')."'>";            require_once 'app/actions/akuntansi/format-neraca.php';        echo '</div>';    ?></div><script type="text/javascript">	function cekTab(){            $(".tab_content").hide();            $('#<?=$tab?>').fadeIn();    }    $(document).ready(function(){        $('.active').fadeIn();        cekTab();            })</script>