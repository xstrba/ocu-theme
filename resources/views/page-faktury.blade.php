@extends('layouts.app')

@section('content')

  <!-- Page header (image, breadcrumb, headline) -->
  @include('partials.page-header', [
    'docsfilter' => true
  ])

  <!-- Zoznam dokumentov -->
  @component('ui.page-section', [ 'last' => true ])
    @slot('row_content')

      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>
      <div class="col-12 mb-2">
        @include('partials.content-rudno-dokumenty')
      </div>

    @endslot
  @endcomponent

@endsection
