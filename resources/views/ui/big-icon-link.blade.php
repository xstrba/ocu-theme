{{--
  Big Icon link

  Needs properties:
    $url = destination url (string)
    $label = link label (string)

  Optionally:
    $icon = icon name from iconify (string)
    $blank = if true, link opens his destination on the blank page
    $subtitle = link description (string)
    $class = additional classes

--}}

<a href="{{ $url }}" @isset($blank) target="_blank" @endisset class="b-big-icon-link border-on-white-bg {{ $class ?? '' }}">
  @if($icon)
    @component('ui.icon', [ 'size' => 'md-huge', 'name' => $icon, 'class' => 'b-big-icon-link__icon']) @endcomponent
  @endif
  <span class="b-big-icon-link__label">{!! $label !!}</span>
  @isset($subtitle)
    <p class="mb-0 mt-3">{{ $subtitle }}</p>
  @endisset
</a>
