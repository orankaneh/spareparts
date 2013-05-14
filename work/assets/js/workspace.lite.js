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


function notif(data) {
	$('#box-notif').removeClass('alert').addClass('notif').html(data).show();
	setTimeout("$('#box-notif').fadeOut(1200);", 2000); 
}

function caution(data) {
	$('#box-notif').removeClass('notif').addClass('alert').html(data).show();
	setTimeout("$('#box-notif').fadeOut(1200);", 2000); 
}

function contentloader(urldesire,contentbox){
   
   $.ajax({
      url: urldesire,
      cache: false,
      success: function(msg) {
         $(contentbox).html(msg);
      }
   });
}

function progressAdd(formid) {

      $.ajax({
            type: "POST",
            url: formid.attr('action'),
            data: formid.serialize(),
            dataType: "json",
            success: function(msg){
		
                    switch(parseInt(msg)) {
                        case 1: notif('Data berhasil ditambahkan');break;
                        case 2: notif('Ditemukan data dengan nama atau kode yang sama');break;
                        case 3: notif('Perubahan Data berhasil disimpan');break;
						case 404: caution('Kesalahan Sistem<br>Hubungi Administrator');break;
                        default: caution('Kesalahan Sistem<br>Hubungi Administrator');
                    }
                    
            }
    });
}

function acceptDelete(deleteid) {
      $.ajax({
            type: "POST",
            url: $('#formConfirm').attr('action'),
            data: $('#formConfirm').serialize(),
            dataType: "json",
            success: function(msg){
                    switch(parseInt(msg)) {
					case 1: $('tr#'+deleteid).slideUp(); notif('Data berhasil dihapus'); break
					case 2: notif('Data tak dapat dihapus karena terkait dengan data yang lain'); break;
                    default: notif('Kesalahan Sistem<br>Hubungi Administrator');
                    }
                    
            }
    });
}


function showFormConfirm(textconfirm,urldelete,deleteid) {
      $('#box-notif').removeClass('alert').addClass('notif').html(textconfirm+"<br><form style='margin-top: 10px' action='"+urldelete+"' method='post' id='formConfirm' onsubmit='acceptDelete("+deleteid+"); return false'><input type='hidden' name='id' value='"+deleteid+"'><input type='submit' value='Hapus' name='hapus' class='stylebutton'><input type='button' class='stylebutton' value='Batal' onclick='$(\"#box-notif\").html(\"\").hide(); $(\"tr#"+deleteid+"\").css(\"background\",\"#fff\");'></form>").show();
      $('tr#'+deleteid).css("background","#FCE1E3");
}

function changepage(url) {
	window.location=url;
}


$(function() {
      
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
		
     
      $("ul.asseticon li").click(function(){
          var url=$(this).find("div").attr("url");
          $('#openribbon').fadeOut();
	  setTimeout("changepage('"+url+"')",600);
      });
      
      
});