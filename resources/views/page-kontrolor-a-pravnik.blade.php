@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header')

  @component('ui.page-section')
    @slot('row_content')
      @if ($lawyer)
        <div class="col-12 col-md-6 mb-3">
          @include('partials.content-rudno-people', ['role' => __('právnik obce', 'rudno-theme'), 'post' => $lawyer ])
        </div>
      @endif
      @if ($controller)
        <div class="col-12 col-md-6 mb-3">
          @include('partials.content-rudno-people', ['role' => __('kontrolór obce', 'rudno-theme'), 'post' => $controller ])
        </div>
      @endif
    @endslot
  @endcomponent

  <!-- Kontrolor -->
  @component('ui.page-section', ['white' => true, 'last' => true, 'id' => 'praca-kontrolora'])
    @slot('headline', __('Výsledky kontrol a plány činnosti hlavného kontrolóra', 'rudno-theme'))
    @slot('row_content')

      @if ($controllerDocsQuery->have_posts())

        <!-- Zoznam dokumentov -->
        @while($controllerDocsQuery->have_posts()) @php $controllerDocsQuery->the_post() @endphp
        @php $post = get_post(get_the_ID()); @endphp
        <div class="col-12 mb-2">
          @include('partials.content-rudno-dokumenty')
        </div>
        @endwhile
      @endif

      @php $link = get_term_link('vysledky-a-plany-hlavneho-kontrolora', 'document-type'); @endphp
      <div class="col-12 mt-4">
        <a href="{{ is_string($link) ? $link : '#' }}" class="btn btn-primary">{{ __('Zobraziť všetky') }}</a>
      </div>
    @endslot
  @endcomponent

@endsection
