var maxt;

function showTime() {

   maxt = setTimeout("showTime()",1000);
   myDate = new Date();
   
   hours   = myDate.getHours();
   minutes = myDate.getMinutes();
   seconds = myDate.getSeconds();

   if (hours < 10)   hours   = "0" + hours;
   if (minutes < 10) minutes = "0" + minutes;
   if (seconds < 10) seconds = "0" + seconds;

   document.getElementById("maxtime").innerHTML = hours+":"+minutes+":"+seconds;
}


function setIn(id) {
	var z=$(id).attr("temp");
	if ($(id).val()==z) $(id).val('');
    $(id).removeClass("inputstyle").addClass("focusField");
}

function setOut(id){
	$(id).removeClass("focusField").addClass("inputstyle");
	var z=$(id).attr("temp");
	if ($(id).val() == "") $(id).val(z).css("color","#ccc");
	else $(id).css("color","#000");
}

function notif(data,box) {
	var onbox;
	if (box != null) onbox=box;
	else onbox='#box-notif';
	$(onbox).removeClass('alert').addClass('notif').html(data).show();
	setTimeout("$('"+onbox+"').fadeOut(1200);", 2000); 
}

function caution(data,box) {
	var onbox;
	if (box != null) onbox=box;
	else onbox='#box-notif';
	$(onbox).removeClass('notif').addClass('alert').html(data).show();
	setTimeout("$('"+onbox+"').fadeOut(1200);", 2000); 
}

function contentloader(urldesire,contentbox){
   $('#load').show();
   $.ajax({
      url: urldesire,
      cache: false,
      success: function(msg) {
         $(contentbox).html(msg);
		 $('#load').hide();
      },error:function(error){
		$('#load').hide();
		caution("ERROR : "+error);
		}
   });
}

function progressAdd(formid,onbox) {
      $.ajax({
            type: "POST",
            url: formid.attr('action'),
            data: formid.serialize(),
            dataType: "json",
            success: function(msg){
			if (onbox != null) {
                    switch(parseInt(msg)) {
                        case 1: notif('Data berhasil ditambahkan',onbox);break;
                        case 2: caution('Ditemukan data dengan nama atau kode yang sama',onbox);break;
                        case 3: notif('Perubahan Data berhasil disimpan',onbox);break;
						case 404: caution('Kesalahan Sistem<br>Hubungi Administrator',onbox);break;
                        default: caution('Kesalahan Sistem<br>Hubungi Administrator',onbox);
                    }
                    
            } else {
				switch(parseInt(msg)) {	
                        case 1: notif('Data berhasil ditambahkan');break;
                        case 2: caution('Ditemukan data dengan nama atau kode yang sama');break;
                        case 3: notif('Perubahan Data berhasil disimpan');break;
						case 404: caution('Kesalahan Sistem<br>Hubungi Administrator');break;
                        default: caution('Kesalahan Sistem<br>Hubungi Administrator');
                    }
			}
			}
			
    });
}


function acceptDelete(deleteid,urlcontent) {
	  
	  var urlrd;
	  if (urlcontent != null) urlrd=urlcontent;

      $.ajax({
            type: "POST",
            url: $('#formConfirm').attr('action'),
            data: $('#formConfirm').serialize(),
            dataType: "json",
            success: function(msg){
                    switch(parseInt(msg)) {
					case 1: $('tr#'+deleteid).slideUp(); notif('Data berhasil dihapus'); $('#confirmbox').hide(); break;
					case 3: setTimeout("contentloader('"+urlrd+"','#content')",1200); notif('Data berhasil dihapus'); $('#confirmbox').hide(); break;
					case 2: caution('Data tidak dapat dihapus karena terkait dengan data yang lain'); $('#confirmbox').hide(); break;
                    default: caution('Kesalahan Sistem<br>Hubungi Administrator');
                    }
                    
            }
    });
}


function showFormConfirm(textconfirm,urldelete,deleteid,urlcontent) {
	  var winleft = ($(window).width()/2)-200;
	  if (urlcontent != null) {	 
			$('#confirmbox').addClass('confirmbox').css('left',winleft).html(textconfirm+"<br><form style='margin-top: 10px' action='"+urldelete+"' method='post' id='formConfirm' onsubmit='acceptDelete("+deleteid+",\""+urlcontent+"\"); return false'><input type='hidden' name='id' value='"+deleteid+"'><input type='submit' value='Hapus' name='hapus' class='stylebutton'><input type='button' class='stylebutton' value='Batal' onclick='$(\"#confirmbox\").slideUp(); $(\"tr#"+deleteid+", td."+deleteid+"\").css(\"background\",\"#fff\");'></form>").slideDown();
	  } else {
			$('#confirmbox').addClass('confirmbox').css('left',winleft).html(textconfirm+"<br><form style='margin-top: 10px' action='"+urldelete+"' method='post' id='formConfirm' onsubmit='acceptDelete("+deleteid+"); return false'><input type='hidden' name='id' value='"+deleteid+"'><input type='submit' value='Hapus' name='hapus' class='stylebutton'><input type='button' class='stylebutton' value='Batal' onclick='$(\"#confirmbox\").slideUp(); $(\"tr#"+deleteid+"\").css(\"background\",\"#fff\");'></form>").slideDown();
      }
	  $('tr#'+deleteid+',td.'+deleteid).css("background","#FCE1E3");
	  
}


$(function() {
      var ribbonheight=$(".ribbon").height()+30;
      $(".main").css('margin-top',ribbonheight);
      
      $("#timepanel a,#userpanel a").click(function() {
              if($(this).next(".subpanel").is(':visible')){
                      $(this).next(".subpanel").hide();
                      $("#mainpanel li a").removeClass('active');
              } else { 
                      $(".subpanel").hide();
                      $(this).next(".subpanel").toggle();
                      $("#mainpanel li a").removeClass('active');
                      $(this).toggleClass('active');
              }
              return false;
      });

      $(document).click(function() {
              $(".subpanel").hide();
              $("#mainpanel li a").removeClass('active');
      });
      
      $('.subpanel').click(function(e) { 
              e.stopPropagation();
      });
		
      $(".mainmodule li").click(function() {
            
            var no_split=$(this).attr("class");
            var no=no_split.split("-");

            $(".assetnav").hide();
            $('.leafribbon,#box-'+no[1]).show();
            $(".mainmodule li").css({background: 'none', color: '#fff', margin: '0'});
            $(this).css({background: '#efefef', color: '#000', margin: '2px 0 0 0'});
            var leafheight=($(".leafribbon").height())+40;
            $(".main").css('margin-top',leafheight+'px')
      });
   
      
      $("ul.asseticon li").click(function(){
          var url=$(this).find("div").attr("url");
          window.location=url;
      });
      
      $('#hidegrid').click(function(){
		setCookies('menu', 'tutup', '10');
        $('.leafribbon,#hidegrid').hide();
        $('#showgrid').show();
        $('.main').css('margin-top','35px');
      });
      
      $('#showgrid').click(function(){
		setCookies('menu', 'buka', '10');
        $('.leafribbon,#hidegrid').show();
        $('#showgrid').hide();
        var leafheight=($(".leafribbon").height())+40;
        $(".main").css('margin-top',leafheight+'px');
      });
      
});



