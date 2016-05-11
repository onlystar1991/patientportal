'use strict';
var Main = function() {
	var $html = $('html'), $win = $(window), wrap = $('.app-aside'), MEDIAQUERY = {}, app = $('#app');

	MEDIAQUERY = {
		desktopXL: 1200,
		desktop: 992,
		tablet: 768,
		mobile: 480
	};
	$(".current-year").text((new Date).getFullYear());
	//sidebar
	var sidebarHandler = function() {
		var eventObject = isTouch() ? 'click' : 'mouseenter', elem = $('#sidebar'), ul = "", menuTitle, _this;

		elem.on('click', 'a', function(e) {

			_this = $(this);
			if(isSidebarClosed() && !isSmallDevice() && !_this.closest("ul").hasClass("sub-menu"))
				return;

			_this.closest("ul").find(".open").not(".active").children("ul").not(_this.next()).slideUp(200).parent('.open').removeClass("open");
			if(_this.next().is('ul') && _this.parent().toggleClass('open')) {

				_this.next().slideToggle(200, function() {
					$win.trigger("resize");

				});
				e.stopPropagation();
				e.preventDefault();
			} else {
				//_this.parent().addClass("active");

			}
		});
		elem.on(eventObject, 'a', function(e) {
			if(!isSidebarClosed() || isSmallDevice())
				return;
			_this = $(this);

			if(!_this.parent().hasClass('hover') && !_this.closest("ul").hasClass("sub-menu")) {
				wrapLeave();
				_this.parent().addClass('hover');
				menuTitle = _this.find(".item-inner").clone();
				if(_this.parent().hasClass('active')) {
					menuTitle.addClass("active");
				}
				var offset = $("#sidebar").position().top;
				var itemTop = isSidebarFixed() ? _this.parent().position().top + offset : (_this.parent().position().top);
				menuTitle.css({
					position: isSidebarFixed() ? 'fixed' : 'absolute',
					height: _this.outerHeight(),
					top: itemTop
				}).appendTo(wrap);
				if(_this.next().is('ul')) {
					ul = _this.next().clone(true);

					ul.appendTo(wrap).css({
						top: menuTitle.position().top + _this.outerHeight(),
						position: isSidebarFixed() ? 'fixed' : 'absolute',
					});
					if(_this.parent().position().top + _this.outerHeight() + offset + ul.height() > $win.height() && isSidebarFixed()) {
						ul.css('bottom', 0);
					} else {
						ul.css('bottom', 'auto');
					}

					wrap.children().first().scroll(function() {
						if(isSidebarFixed())
							wrapLeave();
					});

					setTimeout(function() {

						if(!wrap.is(':empty')) {
							$(document).on('click tap', wrapLeave);
						}
					}, 300);

				} else {
					ul = "";
					return;
				}

			}
		});
		wrap.on('mouseleave', function(e) {
			$(document).off('click tap', wrapLeave);
			$('.hover', wrap).removeClass('hover');
			$('> .item-inner', wrap).remove();
			$('> ul', wrap).remove();

		});
	};
	// navbar collapse
	var navbarHandler = function() {
		var navbar = $('.navbar-collapse > .nav');
		var pageHeight = $win.innerHeight() - $('header').outerHeight();
		var collapseButton = $('#menu-toggler');
		if(isSmallDevice()) {
			navbar.css({
				height: pageHeight
			});
		} else {
			navbar.css({
				height: 'auto'
			});
		};
		$(document).on("mousedown touchstart", toggleNavbar);
		function toggleNavbar(e) {
			if(navbar.has(e.target).length === 0//checks if descendants of $box was clicked
			&& !navbar.is(e.target)//checks if the $box itself was clicked
			&& navbar.parent().hasClass("collapse in"))  {
				collapseButton.trigger("click");
				//$(document).off("mousedown touchstart", toggleNavbar);
			}
		};
	};
	// tooltips handler
	var tooltipHandler = function() {
		$('[data-toggle="tooltip"]').tooltip();
	};
	// popovers handler
	var popoverHandler = function() {
		$('[data-toggle="popover"]').popover();
	};
	// perfect scrollbar
	var perfectScrollbarHandler = function() {
		var pScroll = $(".perfect-scrollbar");

		if(!isMobile() && pScroll.length) {
			pScroll.perfectScrollbar({
				suppressScrollX: true
			});
			pScroll.on("mousemove", function() {
				$(this).perfectScrollbar('update');
			});

		}
	};
	//toggle class
	var toggleClassOnElement = function() {
		var toggleAttribute = $('*[data-toggle-class]');
		toggleAttribute.each(function() {
			var _this = $(this);
			var toggleClass = _this.attr('data-toggle-class');
			var outsideElement;
			var toggleElement;
			typeof _this.attr('data-toggle-target') !== 'undefined' ? toggleElement = $(_this.attr('data-toggle-target')) : toggleElement = _this;
			_this.on("click", function(e) {
				if(_this.attr('data-toggle-type') !== 'undefined' && _this.attr('data-toggle-type') == "on") {
					toggleElement.addClass(toggleClass);
				} else if(_this.attr('data-toggle-type') !== 'undefined' && _this.attr('data-toggle-type') == "off") {
					toggleElement.removeClass(toggleClass);
				} else {
					toggleElement.toggleClass(toggleClass);
				}
				e.preventDefault();
				if(_this.attr('data-toggle-click-outside')) {

					outsideElement = $(_this.attr('data-toggle-click-outside'));
					$(document).on("mousedown touchstart", toggleOutside);

				};

			});

			var toggleOutside = function(e) {
				if(outsideElement.has(e.target).length === 0//checks if descendants of $box was clicked
				&& !outsideElement.is(e.target)//checks if the $box itself was clicked
				&& !toggleAttribute.is(e.target) && toggleElement.hasClass(toggleClass)) {

					toggleElement.removeClass(toggleClass);
					$(document).off("mousedown touchstart", toggleOutside);
				}
			};

		});
	};
	//switchery
	var switcheryHandler = function() {
		var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

		elems.forEach(function(html) {
			var switchery = new Switchery(html);
		});
	};
	// function to allow a button or a link to open a tab
	var showTabHandler = function(e) {
		if($(".show-tab").length) {
			$('.show-tab').on('click', function(e) {
				e.preventDefault();
				var tabToShow = $(this).attr("href");
				if($(tabToShow).length) {
					$('a[href="' + tabToShow + '"]').tab('show');
				}
			});
		};
	};
	// function to enable panel scroll with perfectScrollbar
	var panelScrollHandler = function() {
		var panelScroll = $(".panel-scroll");
		if(panelScroll.length && !isMobile()) {
			panelScroll.perfectScrollbar({
				suppressScrollX: true
			});
		}
	};
	//function to activate the panel tools
	var panelToolsHandler = function() {

		// panel close
		$('body').on('click', '.panel-close', function(e) {
			var panel = $(this).closest('.panel');

                destroyPanel();

                function destroyPanel() {
                    var col = panel.parent();
                    panel.fadeOut(300, function () {
                        $(this).remove();
                        if (col.is('[class*="col-"]') && col.children('*').length === 0) {
                            col.remove();
                        }
                    });
                }
			e.preventDefault();
		});
		// panel refresh
		$('body').on('click', '.panel-refresh', function(e) {
			var $this = $(this), csspinnerClass = 'csspinner', panel = $this.parents('.panel').eq(0), spinner = $this.data('spinner') || "load1";
			panel.addClass(csspinnerClass + ' ' + spinner);
			
			window.setTimeout(function() {
				panel.removeClass(csspinnerClass);
			}, 1000);
			e.preventDefault();
		});
		// panel collapse
		$('body').on('click', '.panel-collapse', function(e) {
			e.preventDefault();
			var el = $(this);
			var panel = jQuery(this).closest(".panel");
			var bodyPanel = panel.children(".panel-body");
			bodyPanel.slideToggle(200, function() {
				panel.toggleClass("collapses");
			});

		});

	};
	// function to activate the Go-Top button
    var goTopHandler = function(e) {
        $('.go-top').on('click', function(e) {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            e.preventDefault();
        });
    };
	var customSelectHandler = function() {
		[].slice.call(document.querySelectorAll('select.cs-select')).forEach(function(el) {
			new SelectFx(el);
		});
	};
	// Window Resize Function
	var resizeHandler = function(func, threshold, execAsap) {
		$(window).resize(function() {
			navbarHandler();
		});
	};
	function wrapLeave() {
		wrap.trigger('mouseleave');
	}

	function isTouch() {
		return $html.hasClass('touch');
	}

	function isSmallDevice() {
		return $win.width() < MEDIAQUERY.desktop;
	}

	function isSidebarClosed() {
		return $('.app-sidebar-closed').length;
	}

	function isSidebarFixed() {
		return $('.app-sidebar-fixed').length;
	}

	function isMobile() {
		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			return true;
		} else {
			return false;
		};
	}

	return {
		init: function() {
			toggleClassOnElement();
			sidebarHandler();
			navbarHandler();
			tooltipHandler();
			popoverHandler();
			perfectScrollbarHandler();
			switcheryHandler();
			resizeHandler();
			showTabHandler();
			panelScrollHandler();
			panelToolsHandler();
			customSelectHandler();
			goTopHandler();
		}
	};
}();
