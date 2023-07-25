// Loading
$(function () {
	$("#loading-wrapper").fadeOut(3000);
});

// Card Loading
$(function () {
	$(".card-loading").fadeOut(10000);
});

// Toggle sidebar
$("#toggle-sidebar").on("click", function () {
	$(".page-wrapper").toggleClass("toggled");
});

// Sidebars JS
jQuery(function ($) {
	$(".sidebar-dropdown > a").on("click", function () {
		console.log($(".sidebar-submenu").slideUp("fast"));

		if ($(this).parent().hasClass("active")) {
			$(".sidebar-dropdown").removeClass("active");
			$(this).parent().removeClass("active");
		} else {
			$(".sidebar-dropdown").removeClass("active");
			$(this).next(".sidebar-submenu").slideDown("fast");
			$(this).parent().addClass("active");
		}
	});

	// Added by Srinu
	$(function () {
		// When the window is resized,
		$(window).resize(function () {
			// When the width and height meet your specific requirements or lower
			if ($(window).width() <= 768) {
				$(".page-wrapper").removeClass("pinned");
			}
		});
		// When the window is resized,
		$(window).resize(function () {
			// When the width and height meet your specific requirements or lower
			if ($(window).width() >= 768) {
				$(".page-wrapper").removeClass("toggled");
			}
		});
	});
});

// Toggle Pricing Plan
$(".pricing-change-plan a").on("click", function () {
	if ($(this).hasClass("active-plan")) {
		$(".pricing-change-plan a").removeClass("active-plan");
	} else {
		$(".pricing-change-plan a").removeClass("active-plan");
		$(this).addClass("active-plan");
	}
});

// Download File
$(".download-reports").on("click", function () {
	$.ajax({
		url: "sample.txt",
		crossOrigin: null,
		xhrFields: {
			responseType: "blob",
		},
		success: function (blob) {
			console.log(blob.size);
			var link = document.createElement("a");
			link.href = window.URL.createObjectURL(blob);
			link.download = "Reports" + ".txt";
			link.click();
		},
	});
});

$("#play-pause").on("click", function () {
	$("a i").toggleClass("icon-play_circle_outline");
});


/***********
***********
***********
	Bootstrap JS 
***********
***********
***********/

// Tooltip
var tooltipTriggerList = [].slice.call(
	document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Popover
var popoverTriggerList = [].slice.call(
	document.querySelectorAll('[data-bs-toggle="popover"]')
);
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
	return new bootstrap.Popover(popoverTriggerEl);
});
