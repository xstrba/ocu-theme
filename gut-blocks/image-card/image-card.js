export default function register() {
  ( function( blocks, editor, blockEditor, element ) {

    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var Image = blockEditor.MediaUpload;


    blocks.registerBlockType( 'rudno/image-card', {

      //
      // Meta info
      //
      title: 'Karta s obrázkom',
      icon: 'align-pull-right',
      category: 'layout',


      //
      // Atributes
      //
      attributes: {
        title: {
          type: 'string',
          source: 'text',
          selector: 'h1',
        },
        content: {
          type: 'array',
          source: 'children',
          selector: 'p',
        },
        imgUrl: {
          type: 'string'
        },
        imgAlt: {
          type: 'string'
        },
        btnLabel: {
          type: 'string'
        },
        btnUrl: {
          type: 'string'
        },
      },


      //
      // Example
      //
      example: {
        attributes: {
          title: 'Nadpis karty',
          content: 'Lorem ipsum dolor sit amet...',
          imgUrl: 'https://i.picsum.photos/id/10/2500/1667.jpg',
          imgAlt: '',
          btnLabel: 'Odkaz',
          btnUrl: ''
        }
      },


      //
      // Edit template
      //
      edit: function( props ) {

        var { content, title, btnUrl, btnLabel, imgUrl, imgAlt } = props.attributes;

        function onChangeContent( newContent ) {
          props.setAttributes( { content: newContent } );
        }

        function onChangeTitle( newTitle ) {
          props.setAttributes( { title: newTitle } );
        }

        function onChangeButtonUrl( event ) {
          props.setAttributes( { btnUrl: event.target.value } );
        }

        function onChangeBtnLabel( newLabel ) {
          props.setAttributes( { btnLabel: newLabel } );
        }

        function mediaRender( { open } ) {
          return el('button', { className: props.className + '__select-image', onClick: open }, imgUrl ? 'Zmeniť obrázok' : 'Vyberte obrázok');
        }

        function onSelectImage( media ) {
          props.setAttributes( { imgUrl: media.url, imgAlt: media.alt });
        }

        return el('article', { className: props.className }, [
          el('div', { className: props.className + '__content-wrapper'}, [
            el(RichText, { tagName: 'h1', className: props.className + '__title', onChange: onChangeTitle, value: title, placeholder: 'Nadpis', keepPlaceholderOnFocus: true }),
            el(RichText, { tagName: 'p', className: props.className + '__content', onChange: onChangeContent, value: content, placeholder: 'Lorem ipsum dolor sit amet...', keepPlaceholderOnFocus: true }),
            el('div', { className: btnUrl ? props.className + '__button-wrapper set' : props.className + '__button-wrapper empty' }, [
              el(RichText, { className: props.className + '__button-label', onChange: onChangeBtnLabel, value: btnLabel, placeholder: 'Text tlačítka', keepPlaceholderOnFocus: true }),
              el('input', { className: props.className + '__button-link', onChange: onChangeButtonUrl, value: btnUrl, placeholder: 'Odkaz, napr.: http://www.google.com', keepPlaceholderOnFocus: true })
            ])
          ]),
          el('div', { className: props.className + '__image-wrapper' }, [
            el('img', { className: props.className + '__image', src: imgUrl, alt: imgAlt }),
            el(Image, { allowedTypes: ['image'], render: mediaRender, onSelect: onSelectImage })
          ])
        ]);
      },


      //
      // Frontend template
      //
      save: function( props ) {

        return el('article', { className: 'b-image-card border-on-white-bg mb-5 h-auto' }, [
          el('div', { className: 'b-image-card__content-wrapper' }, [
            el('h1', { className: 'b-image-card__title' }, props.attributes.title),
            el(RichText.Content, { tagName: 'p', value: props.attributes.content, className: 'b-image-card__content' }),
            props.attributes.btnUrl ? el('a', { className: 'btn btn-primary mt-4', target: '_blank', href: props.attributes.btnUrl, rel: 'noopener noreferrer' }, props.attributes.btnLabel) : null
          ]),
          el('div', { className: 'b-image-card__image-wrapper' }, [
            el('img', { className: 'b-image-card__image', src: props.attributes.imgUrl, alt: props.attributes.imgAlt })
          ])
        ]);

      },


    });

  }(
    window.wp.blocks,
    window.wp.editor,
    window.wp.blockEditor,
    window.wp.element
  ) );
};
