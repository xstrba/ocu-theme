@extends('layouts.app')

@section('content')

    <!-- Page header (image, breadcrumb, headline) -->
    @include('partials.page-header')

    @foreach ($comissions as $key => $people)
      @component('ui.page-section')
        @slot('headline', $key)
        @slot('row_content')
          @foreach ($people as $post)
          <div class="col-12 col-md-6 col-lg-4 mb-3">
            @include('partials.content-rudno-people', [$role = ($post->is_head ? 'Predseda komisie' : 'Člen komisie')])
          </div>
          @endforeach
        @endslot
      @endcomponent
    @endforeach

@endsection
