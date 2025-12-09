@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header', [
    'subtitle' => "{$currentHours()} (<a href='#contact'>úradné hodiny</a>)."
  ])

  <!-- Adresa a uradne hodiny -->
  @component('ui.page-section', [ 'id' => 'contact'])
    @slot('row_content')

      <!-- Fotka + adresa -->
      <div class="col-12 col-lg-7 col-xl-8 mb-3 mb-lg-0 d-flex align-items-stretch">
        @component('ui.image-card', [ 'zoomable' => true ])
          @slot('img', [ 'src' => $preview(), 'alt' => $globalDataResolver->title()])
          @slot('content')
            <h2 class="h5 mb-3">{{ __('Adresa a kontakty', 'rudno-theme') }}</h2>
            <p class="mb-4">{{ $address() }} (<a href="https://www.google.com/maps/place/972+26+Nitrianske+Rudno,+Slovakia/@48.7978119,18.4777043,19.48z/data=!4m5!3m4!1s0x4714c16758074055:0x400f7d1c6971e80!8m2!3d48.7986596!4d18.4768007" target="_blank"
              rel="noreferrer noopener">{{ __('zobraziť na mape', 'rudno-theme') }}</a>)</p>
            <p class="font-weight-bold mb-2">{{ $phone }}</p>
            <p class="font-weight-bold m-0"><a href="mailto:{{ $email }}">{{ $email() }}</a></p>
          @endslot
        @endcomponent
      </div>

      <!-- Uradne hodiny -->
      @if($hours)
      <div class="col-12 col-lg-5 col-xl-4 d-flex align-items-stretch">
        <div class="bg-white rounded border-on-white-bg w-100 p-4 p-lg-5">
          <h2 class="h5 mb-3">{{ __('Úradné hodiny', 'rudno-theme') }}</h2>
          @include('partials.openings', [ 'hours' => $hours() ])
        </div>
      </div>
      @endif

    @endslot
  @endcomponent

  <!-- Uzitocne odkazy -->
  @component('ui.page-section', [ 'white' => true ])
    @slot('headline', __('Užitočné odkazy', 'rudno-theme'))
    @slot('row_content')
      @foreach($usefulLinks() ?? [] as $link)
        <div class="col-12 col-md-6 col-lg-4 mb-md-3">
          @component('ui.big-icon-link', [ 'url' => $link->_link ])
            @slot('icon', $link->_icon)
            @slot('label', $link->post_title)
          @endcomponent
        </div>
      @endforeach
    @endslot
  @endcomponent

  <!-- Zamestnanci -->
  @component('ui.page-section', [ 'last' => true ])
    @slot('headline', __('Zamestnanci úradu', 'rudno-theme'))
    @slot('row_content')
      @foreach ($employeesTop() ?? [] as $post)
      <div class="col-12 col-md-6 col-lg-4 mb-3">
        @include('partials.content-rudno-people')
      </div>
      @endforeach

      <div class="col-12">
        <hr class="my-4 pb-3"/>
      </div>

      @foreach ($employeesBottom() ?? [] as $post)
      <div class="col-12 col-md-6 col-lg-4 mb-3">
        @include('partials.content-rudno-people')
      </div>
      @endforeach
    @endslot
  @endcomponent

@endsection
