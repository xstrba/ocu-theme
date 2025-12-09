<?php
$post = get_post();
?>


@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @php
    $file = get_post($post->_file);
    $terms = get_the_terms($post, 'document-type');
    $term = $terms ? $terms[0] : null;
  @endphp

  @if ($file)
    @component('ui.page-section')
      @slot('row_content')
      <div class="col-12">
        @component('ui.big-icon-link', [ 'url' => $file->guid, 'blank' => true ])
          @slot('icon', 'ion:document-text-outline')
          @slot('label', __('Stiahnuť', 'rudno-theme') . ' ' . "„<i class='font-italic'>$post->post_title</i>“")
        @endcomponent
      </div>
      @endslot
    @endcomponent
  @else
    @component('ui.empty-state', [ 'search' => true ])
      @slot('title', __('Prepáčte, ale dokument, ktorý hľadáte sa nepodarilo načítať.', 'rudno-theme'))
      @if ($term)
        @slot('subtitle')
          {{ __('Skúste nájsť dokument v sekcii', 'rudno-theme') }} <a href="{{ get_term_link($term) }}">{{ strtolower(__($term->name, 'rudno-theme')) }}</a>.
        @endslot
      @endif
    @endcomponent
  @endif
@endsection
