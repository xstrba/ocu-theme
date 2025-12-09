@extends('layouts.app')

@section('content')

    <!-- Page header -->
    @include('partials.page-header')


    @if (!have_posts())

      <!-- Empty state -->
      @component('ui.empty-state')
        @slot('title', __('Bohužiaľ, v archíve sme nenašli žiadne fotky.', 'rudno-theme'))
      @endcomponent

    @else

      <!-- CONTENT -->
      @component('ui.page-section', ['last' => true])
        @slot('row_content')
            @foreach ($galleries as $post)
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
              @include('partials.content-rudno-gallery')
            </div>
            @endforeach
        @endslot
      @endcomponent


    @endif

@endsection
