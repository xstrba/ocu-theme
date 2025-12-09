<!-- Header: Breadcrumbs + H1 -->
@include('partials.page-header')

<!-- Content -->
@component('ui.page-section', [ 'centered' => true ])
  @slot('row_content')

    <div class="col-12 col-md-6">
      @include('partials.content-rudno-people')
    </div>

  @endslot
@endcomponent


<!-- More contacts -->
@component('ui.page-section', [ 'white' => true, 'last' => true, 'centered' => true ])
  @slot('headline', __('Hľadáte kontakt na niekoho iného?'))
  @slot('row_content')

    <div class="col-12 text-center">
      <a href="/kontakty" class="btn btn-primary">{{ __('Kontakty', 'rudno-theme') }}</a>
    </div>

  @endslot
@endcomponent
