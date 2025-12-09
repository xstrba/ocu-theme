<?php
/** @var \App\Services\GlobalDataResolver $globalDataResolver */
?>

<article class="b-news" id="novinka-{{ $post->post_name }}">

  <!-- if ilustrativny obrazok -->
  @php $url = get_the_post_thumbnail_url($post) ?: null @endphp
  @if ($url)
  <div class="b-news__image-wrapper">
    <a href="{{ $url }}"
       data-zoomable="true"
       data-caption="{{ $post->post_title }}"
       target="_blank"
       title="{{ $post->post_title }}">
      <img class="b-news__image" src="{{ $url }}" alt="{{ $post->post_title }}" />
    </a>
  </div>
  @endif
  <!-- endif -->

  <div class="b-news__content-wrapper">

    <h1 class="b-news__title">{{ $post->post_title }}</h1>

    <div class="b-news__body">
      {!! is_front_page() ? $globalDataResolver->strippedContent($post->post_content, "/novinky#novinka-" . $post->post_name) : wpautop($post->post_content, false) !!}
    </div>

    <div class="b-news__action-bar">
      <span class="b-news__date">{{ get_the_date('d. m. Y', $post) }}</span>
    </div>

  </div>

</article>
