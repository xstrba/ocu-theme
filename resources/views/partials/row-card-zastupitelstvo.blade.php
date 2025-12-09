@component('ui.image-card', ['zoomable' => false])
  @slot('img', [ 'src' => home_url('wp-content/uploads/2020/05/DSC0010-scaled.jpg'), 'alt' => $globalDataResolver->title() ])
  @slot('content')
    @isset($heading)
      <h2 class="mb-3">{{ __('Najbližšie zasadnutie zastupiteľstva', 'rudno-theme') }}</h2>
    @endisset
    @if($seating)
      @php
        $dayNum = (int) date('N', strtotime($seating->_date));
      @endphp
      <p class="mb-2">{{ $globalDataResolver->fullDays()[$dayNum - 1] }},
        <strong>{{ date('d. m. Y', strtotime($seating->_date)) }}</strong> {{ __('od', 'rudno-theme') }}
        <strong>{{ $seating->_time }}</strong></p>
      <p class="font-weight-bold mb-4">{{ $seating->_place }}</p>
      @if ($seating->_file)
        <a href="{{ get_post($seating->_file)->guid }}"
           class="btn btn-primary">{{ __('Program schôdze', 'rudno-theme') }}</a>
      @endif
    @else
      <p class="text-muted-light-bg font-italic">
        {{ __('Termín najbližšieho zasadnutia ešte nie je známy. Obvykle ho starosta vyhlasuje minimálne s týždenným predstihom.', 'rudno-theme') }}
      </p>
    @endisset
  @endslot
@endcomponent
