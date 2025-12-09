@extends('layouts.app')

@section('content')

  <!-- Homepage header (image, headline) -->
  @include('partials.home-header')

  <!-- Crossroad -->
  <section class="pb-5">
    <div class="container position-relative mt-n5">
      <div class="row no-gutters">
        @component('ui.crossroad', [ 'roads' => PageHome::roads()])
        @endcomponent
      </div>
    </div>
  </section>

  <!-- Events -->
  @if ($events = PageHome::events())
  @component('ui.page-section', ['white' => true ])
    @slot('headline', __('Najbližšie akcie', 'rudno-theme'))
    @slot('row_content')

      <div class="col-12 col-md-8 col-lg-9">
        <div class="row h-100">
          @foreach ($events as $post)
            @if ($post->_date_from >= date('Y-m-d'))
            <div class="col-12 col-md-6 col-lg-4 mb-3 mb-md-0">
              @include('partials.content-rudno-events')
            </div>
            @endif
          @endforeach
        </div>
      </div>


      <div class="col-12 col-md-4 col-lg-3">
          @component('ui.lonely-road', [
            'link' => get_post_type_archive_link('rudno-events'),
            'icon' => 'ion-beer-outline',
            'title' => __('Kalendár akcií', 'rudno-theme'),
            'description' => __('Lorem ipsum dolor sit amet', 'rudno-theme'),
            'btnlabel' => __('Kalendár akcií', 'rudno-theme')
          ])
          @endcomponent
      </div>

    @endslot
  @endcomponent
  @endif

  <!-- News -->
  @component('ui.page-section', ['last' => true ])
    @slot('headline', __('Novinky', 'rudno-theme'))
    @slot('row_content')

    <div class="col-12 col-md-8 col-lg-9">
      <div class="row h-100">
        @foreach (PageHome::news() ?? [] as $post)
          <div class="col-12 col-md-6 mb-3 mb-md-0">
            @include('partials.content-rudno-news')
          </div>
        @endforeach
      </div>
    </div>


    <div class="col-12 col-md-4 col-lg-3">
        @component('ui.lonely-road', [
          'link' => get_post_type_archive_link('rudno-news'),
          'icon' => 'ion-newspaper-outline',
          'title' => __('Novinky', 'rudno-theme'),
          'description' => __('Lorem ipsum dolor sit amet', 'rudno-theme'),
          'btnlabel' => __('Všetky novinky', 'rudno-theme')
        ])
        @endcomponent
    </div>

    @endslot
  @endcomponent


@endsection
