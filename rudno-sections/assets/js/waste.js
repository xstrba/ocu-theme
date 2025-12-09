jQuery(function($){

	/*
	 * Select/Upload image(s) event
	 */
	$('body').on('click', 'button[data-show="media"]', function(e){
		e.preventDefault();

 		var button = $(this);
    var image = $('img[data-fillableby="media"]');
    var input = $('input[data-fillableby="media"]');

    var custom_uploader = wp.media({

    			title: 'Vybrať obrázok',
    			library : {
    				type : 'image'
    			},
    			button: {
    				text: 'Vybrať obrázok'
    			},
    			multiple: false

		}).on('select', function() {

			var attachment = custom_uploader.state().get('selection').first().toJSON();

      image.attr('src', attachment.url);
      input.val(attachment.url);

		})
		.open();

	});

});
