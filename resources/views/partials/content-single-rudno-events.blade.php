<!-- Content -->
@php $url = get_the_post_thumbnail_url($post) @endphp
<div class="container bg-white rounded p-4 p-lg-5">
  <div class="row">

    <!-- Event Image -->
    @if($url)
      <div class="col-12 col-md-6 order-md-last mb-4 mb-md-0">
        <img class="w-100" src="{{ $url }}" alt="{{ $post->post_title }}" data-high-res-src="{{ $url }}" data-zoomable />
      </div>
    @endif

    <!-- Event Content -->
    <div class="col-12 @if($url) col-md-6 @endif">
      <div class="pr-md-3">

          <!-- Event date -->
          <h2 class="h5 mb-2">{{ __('Kedy', 'rudno-theme') }}</h2>
          @include('ui.event-date-time', ['event' => $post])


          <!-- Event place  -->
          <h2 class="h5 mb-2">{{ __('Kde', 'rudno-theme') }}</h2>
          <p class="mb-5"><strong>{{ $post->_place }}</strong></p>


          <!-- Event description -->
          <h2 class="h5 mb-2">{{ __('Popis akcie', 'rudno-theme') }}</h2>
          <div class="mb-5">{!! wpautop($post->post_content, false) !!}</div>


          <!-- Link for more information -->
          @if ($post->_link)
            <h2 class="h5 mb-2">{{ __('Viac informácií', 'rudno-theme') }}</h2>
            <p class="mb-5"><a href="{{ $post->_link }}" target="_blank">{{ $post->_link }}</a></p>
          @endif

      </div>
    </div>

  </div>
</div>
