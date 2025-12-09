<a href="{{ get_permalink($post) }}" class="b-event" title="{{ $post->post_title }}">

  @php $url = get_the_post_thumbnail_url($post) @endphp

  @if($url)
  <div class="b-event__image" style="background-image: url('{{ $url }}');">
  </div>
  @endif

  <div class="b-event__info border-on-white-bg border-top-0 d-flex flex-column">
    <h3 class="b-event__title">{{ $post->post_title }}</h3>

    <!-- Bud takto: Ak ma akcia len zaciatok -->
    @include('ui.event-date-time', ['event' => $post, 'time' => false])

    <p class="b-event__place mt-auto"><strong>{{ $post->_place }}</strong></p>
  </div>
</a>
