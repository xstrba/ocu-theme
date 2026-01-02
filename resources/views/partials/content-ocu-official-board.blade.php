@component('ui.big-icon-link', [ 'url' => $link])
  @slot('icon', 'ion:document-text-outline')
  @slot('label', $post->post_title)
  @slot('subtitle', \implode('<span class="mx-2 font-weight-bolder">&middot;</span>', $tags))
@endcomponent
