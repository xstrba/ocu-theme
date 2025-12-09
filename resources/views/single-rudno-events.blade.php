@extends('layouts.app')

@section('content')

  <!-- Header: Breadcrumbs + H1 -->
  @include('partials.page-header')

  <!-- Content -->
  @component('ui.page-section', [ 'centered' => true ])
    @slot('row_content')

      <div class="col-12 col-lg-9">
        @while(have_posts()) @php the_post() @endphp
          @include('partials.content-single-rudno-events')
        @endwhile
      </div>

    @endslot
  @endcomponent


  <!-- Next 3 events -->
  @component('ui.page-section', [ 'last' => true, 'centered' => true, 'white' => true ])
    @if(! empty($latests))

      @slot('headline', __('Mohlo by vás zaujímať', 'rudno-theme'))
      @slot('row_content')

        @foreach ($latests as $post)
        <div class="col-12 col-md-4 col-xl-3 mt-4">
          @include('partials.content-rudno-events')
        </div>
        @endforeach

        <div class="col-12 text-center mt-5">
          <a href="{{ get_post_type_archive_link('rudno-events') }}" class="btn btn-primary">{{ __('Všetky akcie', 'rudno-theme') }}</a>
        </div>

      @endslot

    @else

      @slot('row_content')
        <div class="col-12 text-center mt-5">
          <a href="{{ get_post_type_archive_link('rudno-events') }}" class="btn btn-primary">{{ __('Všetky akcie', 'rudno-theme') }}</a>
        </div>
      @endslot

    @endif
  @endcomponent

@endsection
