{{--
  Page header

  Accepts optional properties:
    $title = html string or null (optional)
    $subtitle = html string or null (optional)
    $docsfilter = true or false or null (optional)
    $with_search = true or null (optional)

--}}

<?php
/** @var \App\Services\GlobalDataResolver $globalDataResolver */

$docsfilter ??= false;
$with_search ??= null;
?>

<div class="b-page-header">

    <!-- hero image -->
    @if($globalDataResolver->pageImage())
      <div class="b-page-header__image" style="background-image: url('{{ $globalDataResolver->pageImage() }}');">
      </div>
    @endif

    <!-- Breadcrumbs -->
    @if (!is_home())
      @if (function_exists('yoast_breadcrumb'))
         @php
           yoast_breadcrumb('
              <nav class="container" aria-label="' . __('Omrvinková navigácia', 'rudno-theme') .'">
                <div class="b-breadcrumb p-0 pt-3">',

               '</div>
              </nav>'
            );
          @endphp
      @endif
    @endif

    <div class="b-page-header__container">
      <h1 class="b-page-header__title @if($docsfilter || $with_search) mb-4 @endif" id="page-headline">{!! $title ?? $globalDataResolver->title() !!}</h1>
      @isset($subtitle)
        <p class="b-page-header__subtitle">{!! $subtitle !!}</p>
      @endisset

      @if($docsfilter)
        @php

        $links = [];
        $currPage = $currentPage();

        foreach ($pagesYears as $year) {
          $links[] = [
            'url' => '/dokumenty/' . get_queried_object()->slug . ($year === (int) date('Y') ? '' : "/$year"),
            'active' => $currPage === $year,
            'name' => $year
          ];
        }

        @endphp

        @component('ui.filter')
          @slot('label', __('Filtrovať podľa rokov', 'rudno-theme'))
          @slot('items', $links)
        @endcomponent

      @endif

      @isset($with_search)
        <div class="row">
          <div class="col-12 col-md-6">
            @component('ui.searchform', ['field_id' => 'results-search-field'])
            @endcomponent
          </div>
        </div>
      @endisset

    </div>

</div>
