{{--
  DEPRECATED
--}}

<article>

    <!-- Header: Breadcrumbs + H1 -->
    @include('partials.page-header')

    <!-- Content -->
    @component('ui.page-section', [ 'white' => true ])
      @slot('row_content')

        @php $url = get_the_post_thumbnail_url($post) @endphp
        @if ($url)
        <div class="col-11 col-md-5 col-lg-4">
          <img src="{{ $url }}" alt="{{ $post->post_title }}" class="w-100"/>
        </div>
        @endif
        <div class="col-11 col-md-5 col-lg-4">
          <p class="text-muted-light-bg mb-2">{{ date('d. m. Y', strtotime($post->post_date)) }}</p>
          <div class="m-0">{!! wpautop($post->post_content, false) !!}</div>
        </div>

      @endslot
    @endcomponent

</article>

<!-- More news -->
@component('ui.page-section', [ 'last' => true, 'centered' => true ])
  @slot('row_content')

    <div class="col-12 text-center">
      <a href="/novinky" class="btn btn-primary">{{ __('Všetky novinky', 'rudno-theme') }}</a>
    </div>

  @endslot
@endcomponent
