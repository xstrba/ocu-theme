export default function register() {
  (function (
    blocks,
    blockEditor,
    element,
    components
  ) {

    const el = element.createElement;
    const SelectBtn = blockEditor.MediaUpload;
    const InspectorControls = blockEditor.InspectorControls;
    const PanelBody = components.PanelBody;
    const TextControl = components.TextControl;


    blocks.registerBlockType('rudno/document', {

      //
      // Meta info
      //
      title: 'Dokument',
      icon: 'media-text',
      category: 'layout',


      //
      // Atributes
      //
      attributes: {
        url: {
          type: 'string',
        },
        label: {
          type: 'string',
          default: 'Tlačivo-123',
        },
        icon: {
          type: 'string',
          default: 'document-text-outline',
        }
      },


      //
      // Example
      //
      example: {
        attributes: {
          url: '',
          label: 'Tlačivo-123',
          icon: 'document-text-outline',
        }
      },


      //
      // Edit template
      //
      edit: function (props) {

        const {label, icon} = props.attributes;

        function mediaRender({open}) {
          return el('button', {
            className: props.className + '__select-image',
            onClick: open
          }, label ? 'Zmeniť' : 'Vybrať dokument');
        }

        function onSelectDoc(media) {
          props.setAttributes({url: media.url, label: media.title});
        }

        function iconChanged(value) {
          props.setAttributes({icon: value})
        }

        function labelChanged(value) {
          props.setAttributes({label: value})
        }

        return el('div', {}, [
          el(InspectorControls, {}, [
            el(PanelBody, {title: 'Nastavenia'}, [
              el(TextControl, {label: 'Ikona', value: icon || 'document-text-outline', onChange: iconChanged}),
              el(TextControl, {label: 'Nadpis', value: label || 'Dokument', onChange: labelChanged})
            ]),
          ]),
          el('div', {className: props.className}, [
            el('span', {className: props.className + '__label text-truncate'}, label),
            el(SelectBtn, {render: mediaRender, onSelect: onSelectDoc})
          ]),
        ]);
      },


      //
      // Frontend template
      //
      save: function (props) {

        return el('a', {
          className: 'b-big-icon-link border-on-white-bg mb-5',
          href: props.attributes.url,
          target: '_blank'
        }, [
          el('span', {
            className: 'iconify icon-md-huge b-big-icon-link__icon',
            'data-icon': 'ion:' + props.attributes.icon,
            'data-inline': 'false'
          }),
          el('span', {className: 'b-big-icon-link__label'}, props.attributes.label)
        ]);

      },


    });

  }(
    window.wp.blocks,
    window.wp.blockEditor,
    window.wp.element,
    window.wp.components
  ));
}
