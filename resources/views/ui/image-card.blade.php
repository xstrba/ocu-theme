{{--
  Image card

  Needs properties:
    $img = array of properties 'src' (picture url) and 'alt' (string)
    $content = content of image card (html string)... use @slot('content')
    $zoomable = if true, user can zoom in the image
    $vertical = if true, image card stays in single column on all breakpoints

--}}

<?php
$vertical ??= false;
?>

<div class="b-image-card @if($vertical) b-image-card--vertical @endif border-on-white-bg h-100">
  <div class="b-image-card__image-wrapper">
    @if ($zoomable)
      <a href="{{ $img['src'] }}"
         data-zoomable="true"
         data-caption="{{ $img['alt'] }}"
         target="_blank"
         title="{{ $img['alt'] }}">
        <img class="b-image-card__image"
             src="{{ $img['src'] }}"
             alt="{{ $img['alt'] }}" />
      </a>
    @else
      <img class="b-image-card__image"
           src="{{ $img['src'] }}"
           alt="{{ $img['alt'] }}"/>
    @endif
  </div>
  <div class="b-image-card__content-wrapper">
    {{ $content }}
  </div>
</div>
