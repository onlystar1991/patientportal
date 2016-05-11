'use strict';
var Main = function() {
	// navbar collapse
	var dropDownHandler = function() {
		$('.dropdown-toggle').click(function(e) {
			$(this).parent().toggleClass('open');
			e.stopPropagation();
		});

		$('body').click(function() {
			$('.dropdown-toggle').parent().removeClass('open');
		});

		$('.btn-group .dropdown-menu').click(function(e) {
			e.stopPropagation();
		})
	};

	return {
		init: function() {
			dropDownHandler();
		}
	};
}();
