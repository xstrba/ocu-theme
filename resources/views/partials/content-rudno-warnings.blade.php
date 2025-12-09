@if ($appWarning())
@component('ui.warning')
  @slot('message', $appWarning->post_content
  )
  <!-- if chceme zobrazit button -->
  @if ($appWarning->_type === 'link')
    @slot('link', [
      'url' => $appWarning->_link,
      'blank' => (bool)$appWarning->_blank,
      'label' => 'Zistiť viac'
    ])
  @endif

  @if ($appWarning->_type === 'file')
    @slot('link', [
      'url' => wp_get_attachment_url($appWarning->_file),
      'blank' => (bool)$appWarning->_blank,
      'label' => 'Zistiť viac'
    ])
  @endif

@endcomponent
@endif
