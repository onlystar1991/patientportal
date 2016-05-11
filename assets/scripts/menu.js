$(function() {
    var $mainNav = $('#subnav'),
    navWidth = $mainNav.width();
    
    $mainNav.children('.subnav-item').hover(function(ev) {
        var $this = $(this),
        $dd = $this.find('.subnav-dd');
        
        // get the left position of this tab
        var leftPos = $this.find('.subnav-tab').position().left;
        
        // get the width of the dropdown
        var ddWidth = $dd.width(),
        leftMax = navWidth - ddWidth;
        
        // position the dropdown
        $dd.css('left', Math.min(leftPos, leftMax) );
        
        // show the dropdown
        $this.addClass('subnav-item-active');
    }, function(ev) {

        // hide the dropdown
        $(this).removeClass('subnav-item-active');
    });
});



 $(function () {
      $('.default').dropkick();

      $('.black').dropkick({
        theme : 'black'
      });

      $('.change').dropkick({
        change: function (value, label) {
          alert('You picked: ' + label + ':' + value);
        }
      });

      $('.existing_event').dropkick({
        change: function () {
          $(this).change();
        }
      });

      $('.custom_theme').dropkick({
        theme: 'black',
        change: function (value, label) {
          $(this).dropkick('theme', value);
        }
      });

      $('.dk_container').first().focus();
    });

$(function(){
  $('#homeslider').bxSlider({
	 controls: false,
    auto: true,
    pager: true,
  speed: 500,
        pause: 8000,  
	tickerSpeed: 5000, 
    infiniteLoop: true,      

  });
});

/*var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

function subnav_open()
{	subnav_canceltimer();
	subnav_close();
	ddmenuitem = $(this).find('ul').eq(0).css('visibility', 'visible');}

function subnav_close()
{	if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

function subnav_timer()
{	closetimer = window.setTimeout(subnav_close, timeout);}

function subnav_canceltimer()
{	if(closetimer)
	{	window.clearTimeout(closetimer);
		closetimer = null;}}

$(document).ready(function()
{	$('#subnav > li').bind('mouseover', subnav_open);
	$('#subnav > li').bind('mouseout',  subnav_timer);});

document.onclick = subnav_close;

//jkmegamenu.definemenu("anchorid", "menuid", "mouseover|click")
jkmegamenu.definemenu("megaanchor", "megamenu1", "mouseover")*/



// segments code

$("#segbutton1").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").show();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#goback").show();
	$("#contactnow").show();
})
$("#segbutton2").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").hide();
	$("#seginfodiv2").show();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#segbutton10").show();
	$("#segbutton11").show();
	$("#goback").show();
	$("#contactnow").show();
})
$("#segbutton3").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").show();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#goback").show();
	$("#contactnow").show();
})
$("#segbutton4").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").show();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#goback").show();
	$("#contactnow").show();
})
$("#segbutton5").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").show();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#goback").show();
	$("#contactnow").show();
})
$("#segbutton6").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").show();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#goback").show();
	$("#contactnow").show();
})
$("#segbutton7").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").show();
	$("#seginfodiv8").hide();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#goback").show();
	$("#contactnow").show();
})
$("#segbutton8").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").show();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#goback").show();
	$("#contactnow").show();
})
$("#segbutton10").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#seginfodiv9").show();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#segbutton10").hide();
	$("#segbutton11").hide();
	$("#goback").hide();
	$("#gobackscada").show();
	$("#contactnow").show();
})
$("#segbutton11").click(function(){
	$("#segmentsheader").hide();
    $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#seginfodiv9").hide();
	$("#seginfodiv10").show();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#segbutton10").hide();
	$("#segbutton11").hide();
	$("#goback").hide();
	$("#gobackscada").show();
	$("#contactnow").show();
})


$("#goback").click(function(){
	$("#segmentsheader").show();
	    $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#seginfodiv9").hide();
	$("#seginfodiv10").hide();
	$("#seginfodiv11").hide();
	$("#segbutton1").show();
	$("#segbutton2").show();
	$("#segbutton3").show();
	$("#segbutton4").show();
	$("#segbutton5").show();
	$("#segbutton6").show();
	$("#segbutton7").show();
	$("#segbutton8").show();
	$("#segbutton9").show();
	$("#goback").hide();
	$("#contactnow").hide();
	})
	
$("#gobackscada").click(function(){
	$("#segmentsheader").hide();
	$("#seginfodiv1").hide();
	$("#seginfodiv2").show();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#seginfodiv9").hide();
	$("#seginfodiv10").hide();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#segbutton10").show();
	$("#segbutton11").show();
	$("#goback").show();
	$("#gobackscada").hide();
	$("#contactnow").show();
	})
$("#segbutton9").click(function(){
	$("#segmentsheader").hide();
	 $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#seginfodiv9").hide();
	$("#seginfodiv10").hide();
	$("#seginfodiv11").show();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#contactnow").hide();
	$("#gobackscada").hide();
	$("#goback").show();
	})
$("#contactnow").click(function(){
	$("#segmentsheader").hide();
	 $("#seginfodiv1").hide();
	$("#seginfodiv2").hide();
	$("#seginfodiv3").hide();
	$("#seginfodiv4").hide();
	$("#seginfodiv5").hide();
	$("#seginfodiv6").hide();
	$("#seginfodiv7").hide();
	$("#seginfodiv8").hide();
	$("#seginfodiv9").hide();
	$("#seginfodiv10").hide();
	$("#seginfodiv11").show();
	$("#segbutton1").hide();
	$("#segbutton2").hide();
	$("#segbutton3").hide();
	$("#segbutton4").hide();
	$("#segbutton5").hide();
	$("#segbutton6").hide();
	$("#segbutton7").hide();
	$("#segbutton8").hide();
	$("#segbutton9").hide();
	$("#contactnow").hide();
	$("#gobackscada").hide();
	$("#goback").show();
	})
	//download
	$("#downloadbutton1").click(function(){
    $("#dwn1").show();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
	
	$("#downloadbutton2").click(function(){
    $("#dwn1").hide();
	$("#dwn2").show();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton3").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").show();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton4").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").show();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton5").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").show();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton6").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").show();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton7").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").show();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton8").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").show();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton9").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").show();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton10").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").show();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton11").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").show();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton12").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").show();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton13").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").show();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton14").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").show();
	$("#dwn15").hide();
	$("#dwn16").hide();
})
$("#downloadbutton15").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").show();
	$("#dwn16").hide();
})
$("#downloadbutton16").click(function(){
    $("#dwn1").hide();
	$("#dwn2").hide();
	$("#dwn3").hide();
	$("#dwn4").hide();
	$("#dwn5").hide();
	$("#dwn6").hide();
	$("#dwn7").hide();
	$("#dwn8").hide();
	$("#dwn9").hide();
	$("#dwn10").hide();
	$("#dwn11").hide();
	$("#dwn12").hide();
	$("#dwn13").hide();
	$("#dwn14").hide();
	$("#dwn15").hide();
	$("#dwn16").show();
})
	