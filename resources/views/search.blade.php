@extends('layouts.app')

@section('content')

  <!-- Page header -->
  @include('partials.page-header', [ 'with_search' => true ])


  @if (!have_posts())

    <!-- Empty state -->
    @component('ui.empty-state', [ 'search' => true ])
      @slot('title', __('Je nám to ľúto, ale nič sa nepodarilo nájsť.', 'rudno-theme'))
      @slot('subtitle')
        {{ __('Skúste iný výraz alebo pokračujte na', 'rudno-theme') }} <a href="{{ home_url('/') }}">{{ __('úvodnú stránku.', 'rudno-theme') }}</a>
      @endslot
    @endcomponent

  @else

    <!-- Content -->
    @component('ui.page-section', ['last' => true])
      @slot('row_content')
        @while(have_posts()) @php the_post() @endphp
          <div class="col-12">
            @include('partials.content-search')
          </div>
        @endwhile

        {!!
          get_the_posts_pagination([
              'mid_size'           => 2,
              'prev_next'          => true,
              'prev_text'          => __('Späť'),
              'next_text'          => __('Ďalej')
          ])
        !!}
      @endslot
    @endcomponent

  @endif

@endsection
