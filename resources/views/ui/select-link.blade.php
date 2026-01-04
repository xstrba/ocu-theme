{{--
  Search form

  Needs properties:
    $field_id = id of search input (string)
    $field_name = id of search input (string)
    $label = string or null
    $aria_label = string or null
    $selected = int or string or null
    $options = array [typeof $selected => array{url: string, label: string}]
--}}
<?php
$is_first = true;
?>


<div>
  <p class="mb-1 font-weight-bold">{!! $label !!}</p>

  <div class="px-0 mb-0 d-flex flex-wrap yst-gap-1" name="{{ $field_name ?? $field_id }}" id="{{ $field_id }}" aria-label="{{ $aria_label }}">
    @foreach($options ?? [] as $key => $option)
      @if (! $is_first)
        <span class="mx-2 font-weight-bolder">&middot;</span>
      @endif

      @php
        $is_first = false;
      @endphp

        @if ($key === $selected)
          <div class="text-muted">{{ $option['label'] }}</div>
        @else
          <a href="{{ $option['url'] }}">{{ $option['label'] }}</a>
        @endif
    @endforeach
  </div>
</div>
