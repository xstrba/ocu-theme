@extends('layouts.app')

@php
  $content = get_the_content();
@endphp

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')

  <section class="bg-white">
    <div class="container pb-5">
      {!! $content !!}

      <div class="row">
        <div class="col-12 mt-4">
          <a href="/starosta-poslanci-komisie/poslanci/" class="btn btn-primary">{{ __('Zoznam poslancov') }}</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact info -->
  @component('ui.page-section')
    @slot('row_content')
      <div class="col-12">
        <h2 class="mb-3">{{ __('Najbližšie zasadnutie zastupiteľstva', 'rudno-theme') }}</h2>
      </div>
      <div class="col-12 col-lg-8 col-xl-7">
        @include('partials.row-card-zastupitelstvo')
      </div>
    @endslot
  @endcomponent

  <!-- Work -->
  @component('ui.page-section', ['white' => true, 'last' => true, 'id' => 'zapisnice'])
    @slot('headline', __('Zápisnice zo zastupiteľstiev', 'rudno-theme'))
    @slot('row_content')

      @if ($seatingQuery->have_posts())
        <!-- Zoznam dokumentov -->
        @while($seatingQuery->have_posts())
          @php $seatingQuery->the_post() @endphp
          @php $post = get_post(get_the_ID()) @endphp
          <div class="col-12 mb-2">
            @include('partials.content-rudno-dokumenty')
          </div>
        @endwhile
      @endif

      @php $link = get_term_link('zapisnice-zo-zastupitelstiev', 'document-type'); @endphp
      <div class="col-12 mt-4">
        <a href="{{ is_string($link) ? $link : '#' }}" class="btn btn-primary">{{ __('Všetky zápisnice') }}</a>
      </div>
    @endslot
  @endcomponent
@endsection
