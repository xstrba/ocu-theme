@extends('layouts.app')

@section('content')

    <!-- Page header -->
    @include('partials.page-header')

    @component('ui.page-section')
      @slot('row_content')

        @if($categories)
          @foreach($categories as $category)
            <div class="col-12 col-md-4">
              @component('ui.lonely-road', [
                'link' => get_term_link($category),
                'icon' => 'ion-beer-outline',
                'title' => $category->name,
                'description' => $category->description,
                'btnlabel' => $category->name
              ])
              @endcomponent
            </div>
          @endforeach
        @endif

      @endslot
    @endcomponent

@endsection
