<?php
  /** @var \App\Services\GlobalDataResolver $globalDataResolver */
?>

<div class="b-home-header">
  <div class="b-home-header__image" style="background-image: url('{{ $globalDataResolver->pageImage() }}');">
  </div>
  <div class="b-home-header__content">
    <h1 class="b-home-header__title">{{ $globalDataResolver->siteName() }}</h1>
    <p class="b-home-header__pretitle"><i>{{ __('Vitajte v obci', 'rudno-theme') }}</i></p>
  </div>
</div>
