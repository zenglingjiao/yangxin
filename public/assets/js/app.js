$(function () {
	"use strict";
	// search bar
	$(".search-btn-mobile").on("click", function () {
		$(".search-bar").addClass("full-search-bar");
	});
	$(".search-arrow-back").on("click", function () {
		$(".search-bar").removeClass("full-search-bar");
	});
	$(document).ready(function () {
		$(window).on("scroll", function () {
			if ($(this).scrollTop() > 300) {
				$('.top-header').addClass('sticky-top-header');
			} else {
				$('.top-header').removeClass('sticky-top-header');
			}
		});
		$('.back-to-top').on("click", function () {
			$("html, body").animate({
				scrollTop: 0
			}, 600);
			return false;
		});
	});
	$(function () {
		$('.metismenu-card').metisMenu({
			toggle: false,
			triggerElement: '.card-header',
			parentTrigger: '.card',
			subMenu: '.card-body'
		});
	});
	// Tooltips 
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	// Metishmenu card collapse
	$(function () {
		$('.card-collapse').metisMenu({
			toggle: false,
			triggerElement: '.card-header',
			parentTrigger: '.card',
			subMenu: '.card-body'
		});
	});
	// toggle menu button
	$(".toggle-btn").click(function () {
		if ($(".wrapper").hasClass("toggled")) {
			// unpin sidebar when hovered
			$(".wrapper").removeClass("toggled");
			$(".sidebar-wrapper").unbind("hover");
		} else {
			$(".wrapper").addClass("toggled");
			$(".sidebar-wrapper").hover(function () {
				$(".wrapper").addClass("sidebar-hovered");
			}, function () {
				$(".wrapper").removeClass("sidebar-hovered");
			})
		}
	});
	$(".toggle-btn-mobile").on("click", function () {
		$(".wrapper").removeClass("toggled");
	});

	// === sidebar menu activation js
	$(function () {
		for (var i = window.location, o = $(".metismenu li a").filter(function () {
			return this.href == i;
		}).addClass("").parent().addClass("mm-active");;) {
			if (!o.is("li")) break;
			o = o.parent("").addClass("mm-show").parent("").addClass("mm-active");
		}
	}),
	// metismenu
	$(function () {
		$('#menu').metisMenu();
	});
	/* Back To Top */
	$(document).ready(function () {
		$(window).on("scroll", function () {
			if ($(this).scrollTop() > 300) {
				$('.back-to-top').fadeIn();
			} else {
				$('.back-to-top').fadeOut();
			}
		});
		$('.back-to-top').on("click", function () {
			$("html, body").animate({
				scrollTop: 0
			}, 600);
			return false;
		});
	});
	/*switcher*/
	$(".switcher-btn").on("click", function () {
		$(".switcher-wrapper").toggleClass("switcher-toggled");
	});
	$("#darkmode").on("click", function () {
		$("html").addClass("dark-theme");
	});
	$("#lightmode").on("click", function () {
		$("html").removeClass("dark-theme");
	});
	$("#DarkSidebar").on("click", function () {
		$("html").toggleClass("dark-sidebar");
	});
	$("#ColorLessIcons").on("click", function () {
		$("html").toggleClass("ColorLessIcons");
	});

	$("#menu li a").each(function () {
	   
	});
	$("#menu li a").click(function (e) {
	    e.preventDefault();
	    var url = $(this).attr("href");
	    // var htmlHref = window.location.href;
	    // if (htmlHref.indexOf(url) >= 0) {
	    //     return false;
	    // }
	    //var addr = htmlHref.substr(htmlHref.lastIndexOf('/', htmlHref.lastIndexOf('/') - 1) + 1);
	    // $(".page-content").addClass("OutRight");
	    // setTimeout(function () {
		// 	window.location.href = url
	    // }, 600)
		window.location.href = url
	    return false;
	});

	$(document).ready(function () {
	    $(".page-content").addClass("InRight");
	    setTimeout(function () {
	        $(".page-content").removeClass("InRight");
	    }, 300)
	});
});