{{--
  Icon

  Needs properties:
      $size = ['regular', 'big', 'huge', 'md-huge'] (string)
      $name = icon name from iconify (string)

  Accepts properties:
      $class = string of additional classes such as bootstrap's utility classes or BEM classes and so on... (string)
--}}

<span class="iconify icon-{{ $size }} {{ $class }}" data-icon="{{ $name }}" data-inline="false"></span>
