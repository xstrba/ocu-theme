{{--
  WARNING

  Needs properties:
    $message = (html string)
    $link = (array with properties 'url', 'label' and optionally 'blank')

--}}
<article class="b-warning">
  <div class="b-warning__container">
    <h2 class="b-warning__title">{{ __('Dôležitý oznam', 'rudno-theme') }}</h2>
    <p class="b-warning__content">{!! $message !!}</p>
    @isset($link)
      <a href="{{ $link['url'] }}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif
      class="b-warning__link">
        {{ $link['label'] }}
      </a>
    @endisset
  </div>
</article>
