@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')

  <!-- Zoznam poslancov -->
  @component('ui.page-section')
    @slot('row_content')

      @foreach ($people as $post)
      <div class="col-12 col-md-6 col-lg-4 mb-3">
        @include('partials.content-rudno-people')
      </div>
      @endforeach

    @endslot
  @endcomponent


  <!-- Odkaz na zapisnice -->
  @component('ui.page-section', ['white' => true, 'centered' => true, 'last' => true])
    @slot('headline', __('Zasadnutia zastupiteľstva', 'rudno-theme'))
    @slot('row_content')
      <div class="col-12 text-center">
        @if ($closestSeating)
        <p class="mb-5">{{ __('Najbližšie zasadnutie zastupiteľstva bude', 'rudno-theme') }} <strong>
        {{ date('d. m. Y', strtotime($closestSeating->_date)) }} {{ __('od', 'rudno-theme') }} {{ $closestSeating->_time }}</strong>. {{ __('Miesto konania') }}: <strong>{{ $closestSeating->_place }}</strong>
        </p>
        @endif
        <a href="/starosta-poslanci-komisie/zastupitelstvo/" class="btn btn-primary">{{ __('Zasadnutia zastupiteľstva', 'rudno-theme') }}</a>
        <small class="d-block text-muted-light-bg mt-2">{{ __('Budúce i minulé.', 'rudno-theme') }}</small>
      </div>
    @endslot
  @endcomponent

@endsection
