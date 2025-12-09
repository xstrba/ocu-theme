{{--
  Template Name: Rozcestnik
--}}

@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')

  @component('ui.page-section', [ 'last' => true ])
    @slot('row_content')

      @while (have_posts()) @php the_post() @endphp

      @foreach($links() as $key => $link)
      <!-- Tile links -->
      <div class="col-12 col-md-6 col-lg-4 mb-3">
        @component('ui.tile-link', [ 'url' => $link['link'], 'image' => $link['image'] ?? null,'label' => $key]) @endcomponent
      </div>
      @endforeach
      @endwhile
    @endslot
  @endcomponent

@endsection
