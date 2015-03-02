
jQuery(document).ready( function($) {

// **************************************************************
//  get the jQuery version and add it to the page
// **************************************************************

    $('div.system-snapshot-wrap').each(function() {

		var version;
		var updated;

		version	= $().jquery;
		updated	= $(this).find('textarea#system-snapshot-textarea').val().replace('MYJQUERYVERSION', version);

		$('textarea#system-snapshot-textarea').val( updated );

    });

//********************************************************
// highlight stuff on click
//********************************************************

	$('div.system-snapshot-wrap').on('click', 'input.snapshot-highlight', function (event) {

		var infobox	= $('div.system-snapshot-wrap').find('textarea#system-snapshot-textarea');

		$(infobox).focus();
		$(infobox).select();

	});

//********************************************************
// you're still here? it's over. go home.
//********************************************************

});
