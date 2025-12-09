@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())

    @component('ui.empty-state', [ 'search' => true ])
      @slot('title', __('Prepáčte, ale stránka, ktorú hľadáte pravdepodobne neexistuje.', 'rudno-theme'))
      @slot('subtitle')
        {{ __('Skúste prosím použiť vyhľadávanie alebo pokračujte na', 'rudno-theme') }} <a href="{{ home_url('/') }}">{{ __('úvodnú stránku.', 'rudno-theme') }}</a>
      @endslot
    @endcomponent

  @endif
@endsection
