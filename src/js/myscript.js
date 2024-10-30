import 'code-prettify';

window.addEventListener("load", function() {

	PR.prettyPrint();

	// store tabs variables
	var tabs = document.querySelectorAll("ul.nav-tabs > li");

	for (var i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener("click", switchTab);
	}

	function switchTab(event) {
		event.preventDefault();

		document.querySelector("ul.nav-tabs li.active").classList.remove("active");
		document.querySelector(".tab-pane.active").classList.remove("active");

		var clickedTab = event.currentTarget;
		var anchor = event.target;
		var activePaneID = anchor.getAttribute("href");

		clickedTab.classList.add("active");
		document.querySelector(activePaneID).classList.add("active");

	}

});

jQuery(document).ready(function ($) {

	// For Widgets
	$(document).on('click', '.js-image-upload', function (e) {
		e.preventDefault();
		var $button = $(this);

		var file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image' // mime type
			},
			button: {
				text: 'Select Image'
			},
			multiple: false
		});

		file_frame.on('select', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$button.siblings('.image-upload').val(attachment.url);
		});

		file_frame.open();
	});

	// For Custom Login Page - Add Background Image
	$(document).on('click', '.js-upload-bg-login-page', function (e) {
		e.preventDefault();
		var $button = $(this);

		var file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image' // mime type
			},
			button: {
				text: 'Select Image'
			},
			multiple: false
		});

		file_frame.on('select', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$button.siblings('.preview-background').attr('src', attachment.url);
			$button.siblings('#background_image').val(attachment.url);
		});

		file_frame.open();
	});

	// For Custom Login Page - Remove Background Image
	$('.js-remove-bg-login-page').click(function(e) {
		e.preventDefault();
		var $button = $(this);
		$button.siblings('.preview-background').attr('src', '');
		$button.siblings('#background_image').val('');
		return false;
	});

	// For Custom Login Page - Add Background Image
	$(document).on('click', '.js-upload-logo-login-page', function (e) {
		e.preventDefault();
		var $button = $(this);

		var file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select or Upload an Image',
			library: {
				type: 'image' // mime type
			},
			button: {
				text: 'Select Image'
			},
			multiple: false
		});

		file_frame.on('select', function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$button.siblings('.preview-logo').attr('src', attachment.url);
			$button.siblings('#logo_image').val(attachment.url);
		});

		file_frame.open();
	});

	// For Custom Login Page - Remove Background Image
	$('.js-remove-logo-login-page').click(function(e) {
		e.preventDefault();
		var $button = $(this);
		$button.siblings('.preview-logo').attr('src', '');
		$button.siblings('#logo_image').val('');
		return false;
	});
});

(function( $ ) {
    // Add Color Picker to all inputs that have 'background_color' id
    $(function() {
        $('#background_color').wpColorPicker();
    });
})( jQuery );