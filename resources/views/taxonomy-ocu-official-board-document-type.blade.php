@php
  global $wp_query;
  $totalPosts = $wp_query->found_posts;

  $term = get_queried_object();
@endphp

@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')

  @component('ui.page-section', [ 'white' => true, 'pt0' => true ])
    @slot('row_content')
      <div class="col-12 mb-3">
        @php
          $search_action = $selected_term ? get_term_link($selected_term) : get_post_type_archive_link('ocu-official-board');
        @endphp
        @component('ui.searchform', ['field_id' => 'results-search-field', 'action' => $search_action, 'label' => __('Čo hľadáte?', 'ocu-theme'), 'aria_label' => __('Hľadať na úradnej tabuli', 'rudno-theme')])
          @if($selected_year)
            <input type="hidden" name="filter_year" value="{{ $selected_year }}">
          @endif
        @endcomponent
      </div>

      <div class="col-12 col-md-6 mb-3 mb-md-0">
        @component('ui.link-select', ['field_id' => 'results-search-category-field', 'label' => __('Vyberte kategóriu', 'ocu-theme'), 'aria_label' => __('Vyberte kategóriu', 'rudno-theme'), 'options' => $term_options, 'selected' => $selected_term])
        @endcomponent
      </div>

      <div class="col-12 col-md-6">
        @component('ui.link-select', ['field_id' => 'results-search-year-field', 'label' => __('Vyberte rok vyvesenia', 'ocu-theme'), 'aria_label' => __('Vyberte rok vyvesenia', 'rudno-theme'), 'options' => $year_options, 'selected' => $selected_year])
        @endcomponent
      </div>
    @endslot
  @endcomponent

  @if (! have_posts())
    @component('ui.page-section', [ 'last' => true ])
      @slot('row_content')
        <div class="col-12">
          <!-- Empty state -->
          @component('ui.empty-state')
            @slot('title', __('Bohužiaľ, vyzerá to tak, že pod zvolenými filtrami sme v tejto kategórii nič nenašli.', 'rudno-theme'))
          @endcomponent
        </div>
      @endslot
    @endcomponent
  @else
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
