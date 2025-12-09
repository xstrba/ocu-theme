<?php
/** @var \App\Services\GlobalDataResolver $globalDataResolver */
?>

@extends('layouts.app')

@section('content')
    @if($globalDataResolver->pageImage())

      @include('partials.fancy-header')

      @component('ui.page-section', [ 'white' => true ])
        @slot('row_content')

          <div class="col-12 col-md-10 col-lg-8 col-xl-7">
            <div class="b-default-page-content p-0">
              @while(have_posts()) @php the_post() @endphp
                @include('partials.content-page')
              @endwhile
            </div>
          </div>

        @endslot
      @endcomponent

    @else

      @include('partials.page-header')

      @component('ui.page-section', [ 'white' => true, 'pt0' => true ])
        @slot('row_content')

          <div class="col-12 col-md-10 col-lg-8 col-xl-7">
            <div class="b-default-page-content">
              @while(have_posts()) @php the_post() @endphp
                @include('partials.content-page')
              @endwhile
            </div>
          </div>

        @endslot
      @endcomponent

    @endif

@endsection
