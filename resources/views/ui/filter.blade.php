{{--
  Filter

  Needs properties:
      $label = filter title for screen readers (string)
      $items = array of filter items, each item is array with properties 'url' (string), 'name' (string) and 'active' (boolean)

--}}

<div class="horizontal-scroll-wrapper">
  <div class="b-docsfilter" role="group" aria-label="{{ $label }}">
    @foreach($items as $item)
      <a href="{{ $item['url'] }}" class="b-docsfilter__item @if($item['active']) active @endif">{{ $item['name'] }}</a>
    @endforeach
  </div>
</div>
