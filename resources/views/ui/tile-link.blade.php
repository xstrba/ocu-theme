{{--
  Tile link

  Needs properties:
    $url = url of link destination (string)
    $label = link label (string)
    $image = preview image (string | null)

--}}

@if ($image ?? false)
  <a href="{{ $url }}" class="b-tile-link b-tile-link-with-image">
    <div class="b-tile-link--image">
      <img src="{{ $image }}" alt="{{ $label  }}" />
    </div>
    <div class="b-tile-link--label">
      <div>
        {{ $label }}
      </div>

      @component('ui.icon', [ 'size' => 'big', 'name' => 'ion:arrow-forward', 'class' => '']) @endcomponent
    </div>
  </a>
@else
  <a href="{{ $url }}" class="b-tile-link">
    {{ $label }}
  </a>
@endisset
