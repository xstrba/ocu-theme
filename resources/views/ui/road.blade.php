{{--
  Road (a.k.a. crossroad-item)

  Needs properties:
      $link = destination url (string)
      $icon = icon name from iconify (string)
      $title = destination page name (string)
      $target = destination target (string)
      $description = destination page description (html string)
      $btnlabel = button label (string)
      $highlighted = highlighted tile (bool)

--}}

<?php
/** @var \App\Services\GlobalDataResolver $globalDataResolver */

$highlighted ??= false;
$target ??= null;
?>

<a href="{{ $link }}" class="b-road @if($highlighted) b-road--highlight @endif"
  @if($target) target="{{ $target }}" @endif
  @if(!$globalDataResolver->isServerUrl($link)) rel="noreferrer noopener" @endif>
  @component('ui.icon', [ 'size' => 'huge', 'name' => $icon, 'class' => 'b-road__icon']) @endcomponent
  <h3 class="b-road__title">{{ $title }}</h3>
  <p class="b-road__desc">{!! $description !!}</p>
  <span class="b-road__button">{{ $btnlabel }}</span>
</a>
