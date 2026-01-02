@php
  global $wp_query;
  $totalPosts = $wp_query->found_posts;
@endphp

@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')

  @if (! have_posts())

    <!-- Empty state -->
    @component('ui.empty-state')
      @slot('title', __('Bohužiaľ, vyzerá to tak, že na úradnej tabuli momentálne nie je nič vyvesené.', 'rudno-theme'))
    @endcomponent

  @else
    @component('ui.page-section', [ 'last' => true ])
      @slot('row_content')
        <div class="col-12 mb-5">
          <p class="mb-0 mt-0">{{ $getTotalPostsLabel($totalPosts) }}</p>
        </div>

        <div class="col-12">
          @while (have_posts()) @php the_post(); $post = get_post(get_the_ID()); @endphp
          <div class="mb-2">
            @include('partials.content-ocu-official-board', [
              'post' => $post,
              'link' => get_permalink(),
              'tags' => $getPostTags($post),
            ])
          </div>
          @endwhile
        </div>

        <div class="col-12 mt-3">
          {!!
            get_the_posts_pagination([
                'mid_size'           => 2,
                'prev_next'          => true,
                'prev_text'          => __('Späť'),
                'next_text'          => __('Ďalej')
            ])
          !!}
        </div>
      @endslot
    @endcomponent
  @endif

@endsection
