@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header', [
    'subtitle' => '',
  ])

  <section class="bg-white">
    <div class="container pb-5">
      {!! $subtitle() !!}
    </div>
  </section>

  <!-- Adresa a uradne hodiny -->
  @component('ui.page-section', ['last' => true])
    @slot('row_content')

      <!-- Fotka + adresa -->
      <div class="col-12 col-lg-7 col-xl-8 mb-3 mb-lg-0">
        @component('ui.image-card', [ 'zoomable' => true ])
          @slot('img', [ 'src' => $picture(), 'alt' => $globalDataResolver->title() ])
          @slot('content')
            <h2 class="h5 mb-3">{{ __('Zberný dvor', 'rudno-theme') }}</h2>
            @if($address)
              <p class="mb-4">{{ $address() }} (<a href="{{"https://www.google.com/maps/place/" . urlencode($address) . ",+Slovakia"}}" target="_blank" rel="noreferrer noopener">{{ __('zobraziť na mape', 'rudno-theme') }}</a>)</p>
            @endif

            @if($contact())
              <p class="font-weight-bold mb-2">{{ $contact }}</p>
            @endif
          @endslot
        @endcomponent
      </div>

      <!-- Uradne hodiny -->
      @if ($opened())
      <div class="col-12 col-lg-5 col-xl-4">
        <div class="bg-white rounded border-on-white-bg p-4 p-lg-5">
          <h2 class="h5 mb-3">{{ __('Otvorené', 'rudno-theme') }}</h2>
          @foreach ($opened as $day => $hours)
            @if($hours['am'] || $hours['pm'])
              <p class="mb-2">
                <strong class="mr-3">{{ __($globalDataResolver->shortDays()[$day], 'rudno-theme') }}</strong>
                @if($hours['am'])
                  {{ $hours['am'] }}

                  @if($hours['pm'])
                    , {{ $hours['pm'] }}
                  @endif

                @else
                  {{ $hours['pm'] }}
                @endif
              </p>
            @endif
          @endforeach
        </div>
      </div>
      @endif

    @endslot
  @endcomponent

@endsection
