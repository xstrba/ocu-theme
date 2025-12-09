<?php
/** @var \App\Services\GlobalDataResolver $globalDataResolver */
?>

<div class="b-fancy-header">
  <div class="b-fancy-header__image" style="background-image: url('{{ $globalDataResolver->pageImage() }}');">
  </div>
  <div class="b-fancy-header__content">
    <h1 class="b-fancy-header__title">{{ $globalDataResolver->title() }}</h1>
  </div>
</div>

@if (function_exists('yoast_breadcrumb'))
  <div class="bg-white">
    @php
      yoast_breadcrumb('
        <nav class="container" aria-label="' . __('Omrvinková navigácia', 'rudno-theme') .'">
          <div class="b-breadcrumb p-0 pt-3">',

         '</div>
        </nav>'
      );
    @endphp
  </div>
@endif
