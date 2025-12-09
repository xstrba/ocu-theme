{{--
  Template name: Widepage
--}}

@extends('layouts.app')

@section('content')

    @if($globalDataResolver->pageImage())

      @include('partials.fancy-header')

      @component('ui.page-section', [ 'white' => true ])
        @slot('row_content')

          <div class="col-12">
            <div class="b-widepage-content">
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

          <div class="col-12">
            <div class="b-widepage-content">
              @while(have_posts()) @php the_post() @endphp
                @include('partials.content-page')
              @endwhile
            </div>
          </div>

        @endslot
      @endcomponent

    @endif

@endsection
