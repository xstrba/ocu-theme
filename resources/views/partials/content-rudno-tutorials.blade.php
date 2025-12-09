@component('ui.big-icon-link', [ 'url' => get_post_permalink() ?? '#', 'class' => 'mb-3' ])
  @slot('label', $post->post_title)
@endcomponent
