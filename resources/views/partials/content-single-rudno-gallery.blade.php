@php
$images = get_post_meta(get_the_ID(), '_files') ?? [];
@endphp
<article>

    <!-- Header: Breadcrumbs + H1 -->
    @include('partials.page-header')

    <!-- Content -->
    @component('ui.page-section', ['centered' => true ])
      @slot('row_content')

        <div class="col-12 col-md-8">
          <div class="fotorama"
                data-allowfullscreen="true"
                data-nav="thumbs"
                data-fit="contain"
                data-transition="slide"
                data-clicktransition="crossfade"
                data-hash="true"
                data-loop="true">
            @foreach ($images as $image)
            <img src="{{ get_post($image)->guid }}">
            @endforeach
          </div>
        </div>

        <!-- Fotorama from CDNJS, 19 KB -->
        <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

      @endslot
    @endcomponent

</article>

<!-- More galleries -->
@component('ui.page-section', [ 'white' => true, 'last' => true, 'centered' => true ])
  @slot('row_content')

    @foreach (ArchiveRudnoGallery::latests($post->ID) as $post)
    <div class="col-12 col-sm-6 col-lg-3 mb-3">
      @include('partials.content-rudno-gallery')
    </div>
    @endforeach

    <div class="col-12 text-center mt-5">
      <a href="{{ get_post_type_archive_link('rudno-gallery') }}" class="btn btn-primary">{{ __('Všetky fotogalérie', 'rudno-theme') }}</a>
    </div>

  @endslot
@endcomponent
