<?php
$post = get_post();
?>


@extends('layouts.app')

@section('content')
  @include('partials.page-header', ['subtitle' => $document_type])

  @if ($files !== [])
    @component('ui.page-section', ['headline' => __('Prílohy', 'ocu-theme'), 'white' => true, 'pt0' => true])
      @slot('row_content')
        @foreach($files as $file)
          <div class="col-12 mb-2">
            @component('ui.big-icon-link', [ 'url' => $file->guid, 'blank' => true ])
              @slot('icon', 'ion:document-text-outline')
              @slot('label', __('Stiahnuť', 'ocu-theme') . ' ' . "„<i class='font-italic'>$file->post_title</i>“")
            @endcomponent
          </div>
        @endforeach
      @endslot
    @endcomponent

    @component('ui.page-section', ['headline' => __('Podrobnosti', 'ocu-theme'), 'last' => true])
      @slot('row_content')
        <div class="col-12 col-md-8">

          <div class="row mb-2">
            <h6 class="col-12 col-sm-4 mb-1">
              {{ __('Kategória', 'ocu-theme') }}
            </h6>
            <div class="col-12 col-sm-8">
              {{  $document_type }}
            </div>
          </div>

          <div class="row mb-2">
            <h6 class="col-12 col-sm-4 mb-1">
              {{ __('Popis', 'ocu-theme') }}
            </h6>
            <div class="col-12 col-sm-8">
              {{ $post->post_excerpt ?: '-' }}
            </div>
          </div>

          @if (isset($published_from))
          <div class="row mb-2">
            <h6 class="col-12 col-sm-4 mb-1">
              {{ __('Zverejnené od', 'ocu-theme') }}
            </h6>
            <div class="col-12 col-sm-8">
              {{  $published_from }}
            </div>
          </div>
          @endisset

          @if (isset($published_to))
            <div class="row mb-2">
              <h6 class="col-12 col-sm-4 mb-1">
                {{ __('Zverejnené do', 'ocu-theme') }}
              </h6>
              <div class="col-12 col-sm-8">
                {{  $published_to }}
              </div>
            </div>
          @endisset

        </div>
      @endslot
    @endcomponent
  @else
    @component('ui.empty-state')
      @slot('title', __('Prepáčte, ale dokument, ktorý hľadáte neobsahuje žiadne prílohy.', 'ocu-theme'))
      @slot('subtitle')
        {{ __('Skúste nájsť iný dokument na ', 'ocu-theme') }} <a href="{{ get_post_type_archive_link('ocu-official-board') }}">{{ __('úradnej tabuli', 'ocu-theme') }}</a>.
      @endslot
    @endcomponent
  @endif


@endsection
