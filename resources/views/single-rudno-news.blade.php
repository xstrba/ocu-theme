@extends('layouts.app')

@section('content')

  <!-- Header: Breadcrumbs + H1 -->
  @include('partials.page-header')

  <!-- Content -->
  @component('ui.page-section', [ 'centered' => true ])
    @slot('row_content')

      <div class="col-12 col-lg-9">
        @while(have_posts()) @php the_post() @endphp
          @include('partials.content-rudno-news')
        @endwhile
      </div>

    @endslot
  @endcomponent


  <!-- More news -->
  @component('ui.page-section', [ 'last' => true, 'centered' => true, 'white' => true ])
    @slot('row_content')

      <div class="col-12 text-center">
        <a href="/novinky" class="btn btn-primary">{{ __('Všetky novinky', 'rudno-theme') }}</a>
      </div>

    @endslot
  @endcomponent

@endsection
