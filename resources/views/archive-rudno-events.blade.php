@extends('layouts.app')

@section('content')
  <!-- Page header -->
  @include('partials.page-header')

  @if (empty($eventsByYearMonth()))
    <!-- Empty state -->
    @component('ui.empty-state')
      @slot('title', __('Bohužiaľ, v najbližšej dobe neplánujeme žiadne podujatia.', 'rudno-theme'))
    @endcomponent

  @else
    @php $white = false; @endphp

    <!-- CONTENT -->
    @foreach ($eventsByYearMonth as $yearNum => $eventsByMonth)
      @component('ui.page-section', ['headline' => $yearNum ?: null, 'white' => $white ? true : null])
        @php $white = !$white; @endphp

        @slot('row_content')
          <!-- YEAR CONTENT -->
          @foreach($eventsByMonth as $monthNum => $events)
            <div class="col-12 col-md-2 col-lg-1 mb-4 mb-md-0">
              <div class="events-month-headline">
                <h2 class="text-muted-light-bg">{{ __($globalDataResolver->months()[$monthNum], 'rudno-theme') }}</h2>
              </div>
            </div>
            <div class="col-12 col-md-8 col-lg-11 align-self-end">
              <div class="row">
                @foreach ($events as $post)
                  <div class="col-12 col-sm-6 col-lg-3 mb-4">
                    @include('partials.content-rudno-events')
                  </div>
                @endforeach
              </div>
            </div>
          @endforeach
          <!-- ... -->
        @endslot
      @endcomponent
    @endforeach
    <!-- ... -->
  @endif

@endsection
