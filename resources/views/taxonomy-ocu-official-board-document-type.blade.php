@php
  global $wp_query;
  $totalPosts = $wp_query->found_posts;

  $term = get_queried_object();
@endphp

@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')

  @if (! have_posts())

    @component('ui.page-section', [ 'white' => true, 'pt0' => true ])
      @slot('row_content')
        <div class="col-12 col-md-6">
          @component('ui.select-link', ['field_id' => 'results-search-category-field', 'label' => __('Vyberte kategóriu', 'ocu-theme'), 'aria_label' => __('Vyberte kategóriu', 'rudno-theme'), 'options' => $term_options, 'selected' => $selected_term])
          @endcomponent
        </div>
      @endslot
    @endcomponent

    <!-- Empty state -->
    @component('ui.empty-state')
      @slot('title', __('Bohužiaľ, vyzerá to tak, že na úradnej tabuli momentálne nie je v tejto kategórii nič vyvesené.', 'rudno-theme'))
    @endcomponent

  @else
    @component('ui.page-section', [ 'white' => true, 'pt0' => true ])
      @slot('row_content')
        <div class="col-12 mb-3">
          @component('ui.searchform', ['field_id' => 'results-search-field', 'action' => get_term_link($term), 'label' => __('Čo hľadáte?', 'ocu-theme'), 'aria_label' => __('Hľadať na úradnej tabuli', 'rudno-theme')])
          @endcomponent
        </div>

        <div class="col-12 col-md-6">
          @component('ui.select-link', ['field_id' => 'results-search-category-field', 'label' => __('Vyberte kategóriu', 'ocu-theme'), 'aria_label' => __('Vyberte kategóriu', 'rudno-theme'), 'options' => $term_options, 'selected' => $selected_term])
          @endcomponent
        </div>
      @endslot
    @endcomponent
    @component('ui.page-section', [ 'last' => true ])
      @slot('row_content')
        <div class="col-12 mb-5">
          <p class="mb-0 mt-0">{!! $getTotalPostsLabel($totalPosts)  !!}</p>
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
