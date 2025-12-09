@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')

  @component('ui.page-section', [ 'last' => true ])
    @slot('row_content')

      @foreach ($links as $title => $url)
      <!-- Tile links -->
      <div class="col-12 col-md-6 col-lg-4 mb-3">
        @component('ui.tile-link', [ 'url' => $url, 'label' => $title]) @endcomponent
      </div>
      @endforeach
    @endslot
  @endcomponent

@endsection
