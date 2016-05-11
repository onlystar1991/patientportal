<!-------------------- JS -------------------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

$(document).ready(function () {
    $('.controlpanel').on('click', function(event){
    	event.preventDefault();
    	// create menu variables
    	var slideoutMenu = $('.slideout-menu');
    	var slideoutMenuWidth = $('.slideout-menu').width();
    	
    	// toggle open class
    	slideoutMenu.toggleClass("open");
    	
    	// slide menu
    	if (slideoutMenu.hasClass("open")) {
	    	slideoutMenu.animate({
		    	left: "-10px"
	    	});	
    	} else {
	    	slideoutMenu.animate({
		    	left: -slideoutMenuWidth
	    	}, 250);	
    	}
    });
});

<!--<script>
        $(function () {
            var div = $('div.sc_menu'),
                 ul = $('ul.sc_menu'),
                 ulPadding = 15;
            var divWidth = div.width();
            div.css({ overflow: 'hidden' });
            var lastLi = ul.find('li:last-child');
            div.mousemove(function (e) {
                var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;

                var left = (e.pageX - div.offset().left) * (ulWidth - divWidth) / divWidth;
                div.scrollLeft(left);
            });
        });


--><script type="text/javascript">
$(document).ready(function () {
    $('.slideout-menu-toggle').on('click', function(event){
    	event.preventDefault();
    	// create menu variables
    	var slideoutMenu = $('.slideout-menu');
    	var slideoutMenuWidth = $('.slideout-menu').width();
    	
    	// toggle open class
    	slideoutMenu.toggleClass("open");
    	
    	// slide menu
    	if (slideoutMenu.hasClass("open")) {
	    	slideoutMenu.animate({
		    	left: "-10px"
	    	});	
    	} else {
	    	slideoutMenu.animate({
		    	left: -slideoutMenuWidth
	    	}, 250);	
    	}
    });
});

