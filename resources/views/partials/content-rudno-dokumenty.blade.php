@php
$file = get_post($post->_file);
@endphp

@component('ui.big-icon-link', [ 'url' => $file ? $file->guid : '#', 'blank' => true ])
  @slot('icon', 'ion:document-text-outline')
  @slot('label', $post->post_title)
@endcomponent
