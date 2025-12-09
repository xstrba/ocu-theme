@php
$image = get_post($post->_files);
$url = $image ? $image->guid : null;
@endphp
<a href="{{ get_permalink($post->ID) }}" class="b-gallery" title="{{ __('Otvoriť galériu', 'rudno-theme') }}">
  <div class="b-gallery__image" @if($url) style="background-image: url('{{ $url }}');" @endif></div>
  <h3 class="b-gallery__title">{{ $post->post_title }}</h3>
</a>
