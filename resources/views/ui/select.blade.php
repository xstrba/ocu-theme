{{--
  Select dropdown for filtering

  Needs properties:
    $field_id = id of select input (string)
    $label = string or null
    $aria_label = string or null
    $selected = int or string or null
    $options = array [typeof $selected => array{url: string, label: string}]
--}}

<div class="form-group custom-select-wrapper">
  @if(isset($label))
    <label class="font-weight-bold" for="{{ $field_id }}">{!! $label !!}</label>
  @endif
  <select class="custom-select b-select-link-dropdown" 
          id="{{ $field_id }}" 
          aria-label="{{ $aria_label ?? $label }}" 
          onchange="window.location.href=this.value;">
    @foreach($options ?? [] as $key => $option)
      <option value="{{ $option['url'] }}" @if($key === $selected) selected @endif>
        {{ $option['label'] }}
      </option>
    @endforeach
  </select>
</div>
