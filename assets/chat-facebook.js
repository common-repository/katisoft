function fbmcc_setupCustomerChat() {
	const FACEBOOK_URL = "https://www.facebook.com";
	var baseURL = "https://www.facebook.com/customer_chat/dialog/?domain=";
	var urlParam = encodeURI(
		window.location.protocol
		+ '//'
		+ window.location.hostname
		+ (window.location.port ? ':' + window.location.port : '')
	);
	var customerWindow = window.open(
		baseURL + urlParam,
		"_blank",
		"width=1200,height=800"
	);
	
	jQuery(window).on("message", function(e) {
		if (e.originalEvent.origin === FACEBOOK_URL) {
			$data_json = JSON.parse(e.originalEvent.data);
			console.log($data_json);
			var data = {
				'action' : 'update_options',
				'pageID' : fbmcc_sanitizeNumbersOnly($data_json["pageID"]),
				'locale' : fbmcc_sanitizeLocale($data_json["locale"]),
				'themeColor' : fbmcc_sanitizeHexColor($data_json["themeColorCode"]),
				'greetingText' : $data_json["greetingTextCode"],
			};
			data.generatedCode = fbmcc_genScript(
				data.pageID,
				data.locale,
				data.themeColor,
				data.greetingText,
			).replace(/^\s*\n/gm, "");
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: data,
				success: function(results) {
				jQuery('#fbmcc-codeArea').val(data.generatedCode);
				jQuery('#fbmcc-page-params').css('display', 'inline-block');
				jQuery('#fbmcc-enabled').prop('checked', true);
				}
			});
			}
		});
	}
	
	function fbmcc_genScript( pageID, locale, themeColor, greetingText ) {
		const hasNoGreeting = (greetingText === null || greetingText === undefined );

		return `<!-- Load Facebook SDK for JavaScript -->
		<div id="fb-root"></div>
		<script>
		  window.fbAsyncInit = function() {
			FB.init({
			  xfbml            : true,
			  version          : 'v3.3'
			});
		  };
		
		  (function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/${locale}/sdk/xfbml.customerchat.js';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		
		<!-- Your customer chat code -->
		<div class="fb-customerchat"
		  attribution=setup_tool
		  page_id="${pageID}"
		  ${themeColor === null ? '' : `theme_color="${themeColor}"`}
		  ${hasNoGreeting ? '' : `logged_in_greeting="${greetingText}"`}
		  ${hasNoGreeting ? '' : `logged_out_greeting="${greetingText}"`}>
		</div>`;
		}
		
		function fbmcc_editCode() {
		jQuery('#fbmcc-codeArea').prop('readonly', function(i, v) { return !v; });
		}
		
		function fbmcc_sanitizeNumbersOnly( number ) {
		if( /^\d+$/.test(number) ) {
			return number;
		} else {
			return '';
		}
		}
		
		function fbmcc_sanitizeLocale( locale ) {
		if( /^[A-Za-z_]{4,5}$/.test(locale) ) {
			return locale;
		} else {
			return '';
		}
	}
	
	function fbmcc_sanitizeHexColor( color ) {
		if( /^#([A-Fa-f0-9]{3}){1,2}$/.test(color) ) {
			return color;
		} else {
			return null;
		}
}