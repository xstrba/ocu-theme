jQuery(document).ready(function($){

  var meta_image_frame;

  $('#spost_file_area').click(function(e){

    e.preventDefault();

    let mime = $(this).data('mime');
    let multiple = $(this).data('multiple');

    if (meta_image_frame) {
      meta_image_frame.open();
      return;
    }

    meta_image_frame = wp.media({
      title: spost_file.title,
      button: { text: spost_file.button },
      multiple,
      library: { type: mime }
    });

    meta_image_frame.on('select', function(){

      let selection = meta_image_frame.state().get('selection');
      let ids = [];
      let names = [];
      let preview = '';

      selection.each(function(attachment){
        attachment = attachment.toJSON();

        ids.push(attachment.id);
        names.push(attachment.filename);

        if (attachment.sizes?.thumbnail) {
          preview += `<img src="${attachment.sizes.thumbnail.url}" style="max-width:80px;margin-right:5px;" />`;
        }
      });

      // uložené IDčka
      $('#spost_file').val(ids.join(','));

      // názvy súborov
      $('#spost_file_txt').val(names.join(', '));

      // preview (ak existuje)
      if ($('#spost_file_preview').length) {
        $('#spost_file_preview').html(preview);
      }
    });

    meta_image_frame.on('open', function () {
      let existingIds = $('#spost_file').val();

      let selection = meta_image_frame.state().get('selection');
      selection.reset();

      if (existingIds) {
        existingIds.split(',').forEach(function (id) {
          let attachment = wp.media.attachment(id);
          attachment.fetch();
          selection.add(attachment);
        });
      }
    });

    meta_image_frame.open();
  });
});
