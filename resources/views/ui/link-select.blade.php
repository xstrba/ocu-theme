{{--
  Stylized link-based select component
  
  Properties:
    $field_id (string)
    $label (string|null)
    $options (array) - [key => ['url' => string, 'label' => string]]
    $selected (mixed) - key of the selected option
--}}

<div class="b-link-select">
  @if(isset($label))
    <label class="b-link-select__label" for="{{ $field_id }}">{!! $label !!}</label>
  @endif

  <div class="b-link-select__container">
    <input type="checkbox" id="{{ $field_id }}_toggle" class="b-link-select__toggle" hidden>
    
    <label for="{{ $field_id }}_toggle" class="b-link-select__current" tabindex="0">
      <span class="b-link-select__current-text">
        {{ $options[$selected]['label'] ?? ($options[0]['label'] ?? '---') }}
      </span>
      <span class="b-link-select__caret"></span>
    </label>

    <div class="b-link-select__dropdown">
      @foreach($options as $key => $option)
        @if(($option['count'] ?? 1) > 0)
          <a href="{{ $option['url'] }}" 
             class="b-link-select__option @if($key === $selected) is-selected @endif">
            {{ $option['label'] }}
            @if($key === $selected)
              <span class="b-link-select__option-check"></span>
            @endif
          </a>
        @else
          <div class="b-link-select__option is-disabled">
            {{ $option['label'] }}
          </div>
        @endif
      @endforeach
    </div>

    {{-- Overlay to close on click outside --}}
    <label for="{{ $field_id }}_toggle" class="b-link-select__overlay" hidden></label>
  </div>
</div>
