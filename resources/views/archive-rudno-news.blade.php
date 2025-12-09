@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')


  @if (! have_posts())

    <!-- Empty state -->
    @component('ui.empty-state')
      @slot('title', __('Bohužiaľ, vyzerá to tak, že v obci sa nedeje nič nové.', 'rudno-theme'))
    @endcomponent

  @else

    <!-- Content -->
    <div class="container py-5">
      <div class="row justify-content-lg-between align-items-start">

        <!-- News feed -->
        <section class="b-newsfeed col-12 col-md-8 col-lg-7 pb-5 mb-5">
          @while (have_posts()) @php the_post(); $post = get_post(get_the_ID()); @endphp
            @include('partials.content-rudno-news')
          @endwhile

          {!!
            get_the_posts_pagination([
                'mid_size'           => 2,
                'prev_next'          => true,
                'prev_text'          => __('Späť'),
                'next_text'          => __('Ďalej')
            ])
          !!}
        </section>

        <!-- Web content updates -->
        <aside class="col-12 col-md-4 border-left border-theme-color px-4">
          <h2 class="h4 mb-4">{{ __('Novinky na webe', 'rudno-theme') }}</h2>

          @foreach ($webNews() ?? [] as $post)
          <article class="mb-4">
            <small class="d-block text-muted-light-bg">{{ date('d. m. Y', strtotime($post->post_modified)) }}</small>
            <p class="mb-0">
              <i>
                {{ __($post->post_modified === $post->post_date ? "Na web bol pridaný dokument" : "Bol upravený dokument", "rudno-theme") }}
                <a href="{{ get_post($post->_file)->guid ?? '#' }}" target="_blank">{{ $post->post_title }}</a>
              </i>
            </p>
          </article>
          @endforeach
        </aside>

      </div>
    </div>

  @endif


@endsection
