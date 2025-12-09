@extends('layouts.app')

@section('content')

      @include('partials.page-header')

      @component('ui.page-section')
        @slot('row_content')

          <div class="col-12 col-md-7">
            <div class="b-default-page-content bg-white mb-5">
              @while(have_posts()) @php the_post() @endphp
                @include('partials.content-single-rudno-tutorials')
              @endwhile
            </div>
          </div>

          <div class="col-12 col-md-4 ml-md-5">
            <h2 class="h3 mb-3">{{ __('Kontaktná osoba', 'rudno-theme') }}</h2>
            @foreach($people as $person)
              @include('partials.content-rudno-people', [ 'post' => $person ])
            @endforeach

            <h2 class="h3 mt-5 mb-3">{{ __('Obecný úrad', 'rudno-theme') }}</h2>
            @component('ui.image-card', [ 'vertical' => true])
              @slot('img', [
                'src' => $ou['image'],
                'alt' => __('Obecný úrad Nitrianske Rudno', 'rudno-theme')
              ])

              @slot('content')
                @if($ou['address']) <p class="mb-3">{{ $ou['address'] }}</p> @endif
                @if($ou['phone']) <p class="mb-1 font-weight-bold">{{ $ou['phone'] }}</p> @endif
                @if($ou['mail']) <p class="font-weight-bold"><a href="mailto:{{ $ou['mail'] }}" target="_top">{{ $ou['mail'] }}</a></p> @endif
                @if($ou['hours'])
                  <h3 class="h5 mt-5 mb-2">{{ __('Úradné hodiny', 'rudno-theme')}}</h3>
                  @include('partials.openings', ['hours' => $ou['hours']])
                @endif
              @endslot
            @endcomponent
          </div>

        @endslot
      @endcomponent


@endsection
