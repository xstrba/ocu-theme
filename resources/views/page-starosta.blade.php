<?php
/** @var \App\Services\GlobalDataResolver $globalDataResolver */
?>

@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')

  <!-- Contact info -->
  @component('ui.page-section')
    @slot('row_content')

      <!-- Kontakty -->
      <div class="col-12 col-lg-7 col-xl-8 mb-5 mb-lg-0">
        @if ($mayor)
        @component('ui.image-card', [ 'zoomable' => true ])
          @slot('img', [ 'src' => get_the_post_thumbnail_url($mayor->ID), 'alt' => $globalDataResolver->title() ])
          @slot('content')
            <h2 class="h5 mb-1">{{ $mayor->_name }}</h2>
            <small class="d-block mb-4">{{ $mayor->_position }}</small>
            <p class="font-weight-bold mb-2">{{ $mayor->_phone }}</p>
            <p class="font-weight-bold m-0"><a href="mailto:{{ $mayor->_email }}">{{ $mayor->_email }}</a></p>
          @endslot
        @endcomponent
        @endif
      </div>

      <!-- Zastupca -->
      <div class="col-12 col-lg-5 col-xl-4 d-flex flex-column">
        <h2 class="mb-3">{{ __('Zástupca starostu', 'rudno-theme') }}</h2>
        @if ($viceMayor)
          @include('partials.content-rudno-people', [ 'role' => __('zástupca starostu', 'rudno-theme'), 'post' => $viceMayor ])
        @endif
      </div>

    @endslot
  @endcomponent

  <!-- Work -->
  @component('ui.page-section', ['white' => true, 'last' => false, 'id' => 'praca-starostu'])
    @slot('headline', __('Práca starostu', 'rudno-theme'))
    @slot('row_content')

      @if ($worksQuery && $worksQuery->have_posts())
        <!-- Zoznam dokumentov -->
        @while($worksQuery->have_posts()) @php $worksQuery->the_post() @endphp
        @php $post = get_post(get_the_ID()); @endphp
        <div class="col-12 mb-2">
          @include('partials.content-rudno-dokumenty')
        </div>
        @endwhile
      @endif

      @php $link = get_term_link('praca-starostu', 'document-type'); @endphp
      <div class="col-12 mt-4">
        <a href="{{ is_string($link) ? $link : '#' }}" class="btn btn-primary">{{ __('Zobraziť všetky') }}</a>
      </div>
    @endslot
  @endcomponent

  @if ($pageContent)
    @component('ui.page-section', [ 'last' => true, 'id' => 'informacie' ])
      @slot('headline', __('Ďalšie informácie', 'rudno-theme'))
      @slot('row_content')

        <div class="col-12">
          <div>
            {!! $pageContent !!}
          </div>
        </div>

      @endslot
    @endcomponent
  @endif

@endsection
