<!-- Header: Breadcrumbs + H1 -->
@include('partials.page-header')

<!-- Content -->
@component('ui.page-section', [ 'centered' => true  ])
  @slot('row_content')

    @include('partials.content-rudno-warnings')

  @endslot
@endcomponent

<!-- More news -->
@component('ui.page-section', [ 'white' => true, 'last' => true, 'centered' => true ])
  @slot('row_content')

    <div class="col-12 text-center">
      <a href="#" class="btn btn-primary">{{ __('Všetky novinky', 'rudno-theme') }}</a>
    </div>

  @endslot
@endcomponent
