(function ($) {
	"use strict";

	// Sticky menu 
	var $window = $(window);
	$window.on('scroll', function () {
		var scroll = $window.scrollTop();
		if (scroll < 300) {
			$(".sticky").removeClass("is-sticky");
		} else {
			$(".sticky").addClass("is-sticky");
		}
	});

	// Background Image JS start
	var bgSelector = $(".bg-img");
	bgSelector.each(function (index, elem) {
		var element = $(elem),
			bgSource = element.data('bg');
		element.css('background-image', 'url(' + bgSource + ')');
	});

	// offcanvas search form active start
	$(".offcanvas-btn").on('click', function () {
		$("body").addClass('fix');
		$(".offcanvas-search-inner").addClass('show')
	})

	$(".minicart-btn").on('click', function () {
		$("body").addClass('fix');
		$(".minicart-inner").addClass('show')
	})

	$(".offcanvas-close, .minicart-close,.offcanvas-overlay").on('click', function () {
		$("body").removeClass('fix');
		$(".offcanvas-search-inner, .minicart-inner").removeClass('show')
	})

	// nice select active start
	$('select').niceSelect();

	// Off Canvas Open close start
	$(".off-canvas-btn").on('click', function () {
		$("body").addClass('fix');
		$(".off-canvas-wrapper").addClass('open');
	});

	$(".btn-close-off-canvas,.off-canvas-overlay").on('click', function () {
		$("body").removeClass('fix');
		$(".off-canvas-wrapper").removeClass('open');
	});


	// slide effect dropdown
	function dropdownAnimation() {
		$('.dropdown').on('show.bs.dropdown', function (e) {
			$(this).find('.dropdown-menu').first().stop(true, true).slideDown(500);
		});

		$('.dropdown').on('hide.bs.dropdown', function (e) {
			$(this).find('.dropdown-menu').first().stop(true, true).slideUp(500);
		});
	}
	dropdownAnimation();

	//offcanvas mobile menu start 
	var $offCanvasNav = $('.mobile-menu'),
		$offCanvasNavSubMenu = $offCanvasNav.find('.dropdown');

	/*Add Toggle Button With Off Canvas Sub Menu*/
	$offCanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i></i></span>');

	/*Close Off Canvas Sub Menu*/
	$offCanvasNavSubMenu.slideUp();

	/*Category Sub Menu Toggle*/
	$offCanvasNav.on('click', 'li a, li .menu-expand', function (e) {
		var $this = $(this);
		if (($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand'))) {
			e.preventDefault();
			if ($this.siblings('ul:visible').length) {
				$this.parent('li').removeClass('active');
				$this.siblings('ul').slideUp();
			} else {
				$this.parent('li').addClass('active');
				$this.closest('li').siblings('li').removeClass('active').find('li').removeClass('active');
				$this.closest('li').siblings('li').find('ul:visible').slideUp();
				$this.siblings('ul').slideDown();
			}
		}
	});

	// tooltip active js
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


	// Hero main slider active
	$('.hero-slider-active').slick({
		fade: true,
		autoplay: true,
		speed: 1000,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
		responsive: [{
			breakpoint: 992,
			settings: {
				arrows: false,
				dots: true
			}
		},
		{
			breakpoint: 480,
			settings: {
				arrows: false,
				dots: false
			}
		}]
	});


	// product carousel active
	$('.product-carousel-4').slick({
		slidesToShow: 4,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});


	// blog carousel active-2 js
	$('.top-seller-carousel').slick({
		rows: 2,
		arrows: false,
		slidesToShow: 2,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 992,
				settings: {
					rows: 1,
					slidesToShow: 1
				}
			}
		]
	});


	// blog carousel active-2 js
	$('.blog-carousel-active').slick({
		arrows: false,
		slidesToShow: 3,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});

	// brand slider active js
	$('.brand-active-carousel').slick({
		arrows: false,
		slidesToShow: 4,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});



	// prodct details slider active
	$('.product-large-slider').slick({
		fade: true,
		arrows: false,
		asNavFor: '.pro-nav'
	});


	// product details slider nav active
	$('.pro-nav').slick({
		slidesToShow: 4,
		asNavFor: '.product-large-slider',
		arrows: false,
		focusOnSelect: true
	});

	// testimonial carousel active js
	$('.testimonial-active').slick({
		dots: true,
		arrows: false,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					dots: false
				}
			}
		]
	});


	// image zoom effect
	$('.img-zoom').zoom();




	// product view mode change js
	$('.product-view-mode a').on('click', function (e) {
		e.preventDefault();
		var shopProductWrap = $('.shop-product-wrap');
		var viewMode = $(this).data('target');
		$('.product-view-mode a').removeClass('active');
		$(this).addClass('active');
		shopProductWrap.removeClass('grid-view list-view').addClass(viewMode);
	})


	// quantity change js
	$('.pro-qty').prepend('<span class="dec qtybtn">-</span>');
	$('.pro-qty').append('<span class="inc qtybtn">+</span>');
	$('.qtybtn').on('click', function () {
		var $button = $(this);
		var oldValue = $button.parent().find('input').val();
		if ($button.hasClass('inc')) {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 0) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 0;
			}
		}
		$button.parent().find('input').val(newVal);
	});


	// Checkout Page accordion
	$("#create_pwd").on("change", function () {
		$(".account-create").slideToggle("100");
	});

	$("#ship_to_different").on("change", function () {
		$(".ship-to-different").slideToggle("100");
	});


	// Payment Method Accordion
	$('input[name="paymentmethod"]').on('click', function () {
		var $value = $(this).attr('value');
		$('.payment-method-details').slideUp();
		$('[data-method="' + $value + '"]').slideDown();
	});


	// scroll to top
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > 600) {
			$('.scroll-top').removeClass('not-visible');
		} else {
			$('.scroll-top').addClass('not-visible');
		}
	});
	$('.scroll-top').on('click', function (event) {
		$('html,body').animate({
			scrollTop: 0
		}, 1000);
	});


	$(document).ready(function () {
		// Initialize wishlist from LocalStorage
		let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

		// Update buttons based on wishlist items on page load
		wishlist.forEach(productId => {
			const $btn = $(`#wishlist-btn-${productId} i`);
			if ($btn.length) {
				$btn.removeClass('bi-heart').addClass('bi-heart-fill');
				$btn.attr('title', 'Remove from Wishlist');
			}
		});

		if (wishlist.length > 0) {
			$('.wishlist-section').show()
			$('.wishlist-count').text(wishlist.length)
		}
		else {
			$('.wishlist-section').hide()
		}

		// Handle wishlist toggle
		$('body').on('click', '.wishlist-btn', function (e) {
			e.preventDefault();

			const $btn = $(this).find('i');
			const productId = $(this).data('product-id');

			if (wishlist.includes(productId)) {
				// Remove from wishlist
				wishlist = wishlist.filter(id => id !== productId);
				$btn.removeClass('bi-heart-fill').addClass('bi-heart');
				$(this).attr('title', 'Add to Wishlist');
				// wishlist.pop(productId);
			} else {
				// Add to wishlist
				wishlist.push(productId);
				$btn.removeClass('bi-heart').addClass('bi-heart-fill');
				$(this).attr('title', 'Remove from Wishlist');
			}

			// Update LocalStorage
			localStorage.setItem('wishlist', JSON.stringify(wishlist));

			if (wishlist.length > 0) {

				$('.wishlist-section').show()
				$('.wishlist-count').text(wishlist.length)
			}
			else {
				$('.wishlist-section').hide()
			}
		});

		$('body').on('click', '#wishlist-btn-view', function (e) {
			$.ajax({
				url: '/wishlist',
				method: 'GET',
				data: { wishlist: wishlist },
				success: function (response) {
					$('.wishlistBody').html(response);
				}
			});
		});

		$('body').on('click', '.wishlist-btn-remove', function (e) {
			e.preventDefault();
			const product_Id = $(this).data('product-id');

			if (wishlist.includes(product_Id)) {
				// Remove the product from the wishlist array
				wishlist = wishlist.filter(id => id !== product_Id);

				// Update LocalStorage
				localStorage.setItem('wishlist', JSON.stringify(wishlist));

				// Remove the item's HTML from the DOM
				$(this).closest('.wishlist-item').remove();

				// Update wishlist count
				if (wishlist.length > 0) {
					$('.wishlist-count').text(wishlist.length);
				} else {
					$('.wishlist-section').hide();
				}
			}
		});


		$('body').on('click', '.quick_view-btn', function (e) {
			e.preventDefault();
			var Id = $(this).data('product-id');
			$.ajax({
				url: '/quick-view',
				method: 'GET',
				data: { product_id: Id },
				success: function (response) {
					$('.quickBody').html(response);
					// Reinitialize slick if necessary
					// prodct details slider active
					$('.product-large-slider').slick({
						fade: true,
						arrows: false,
						asNavFor: '.pro-nav'
					});


					// product details slider nav active
					$('.pro-nav').slick({
						slidesToShow: 4,
						asNavFor: '.product-large-slider',
						arrows: false,
						focusOnSelect: true
					});
				}
			});
		});



	});





}(jQuery));
