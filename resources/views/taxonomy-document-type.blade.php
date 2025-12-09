@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header', [
    'docsfilter' => $template->usesYearlyFilter(),
  ])

  <!-- Zoznam dokumentov -->
  @component('ui.page-section', [ 'last' => true ])
    @slot('row_content')

      @foreach ($posts as $post)
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      @endforeach

    @endslot
  @endcomponent

@endsection
