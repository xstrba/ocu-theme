{{--
  Search form

  Needs properties:
    $field_id = id of search input (string)
    $label = string or null
    $action = string or null
    $aria_label = string or null
--}}

<form class="b-search-form" action="{{ $action ?? home_url('/') }}" method="GET" role="search" aria-label="{{ $aria_label ?? __('Hľadať na webe', 'rudno-theme') }}">
  <label class="@if(isset($label)) font-weight-bold @else sr-only @endif" for="{{ $field_id }}">{{ $label ?? __('Vyhľadávacie pole', 'rudno-theme') }}</label>
  <div class="b-search-form__field-wrapper">
    <input type="search" class="b-search-form__field" name="s" id="{{ $field_id }}" value="{{ the_search_query() }}" placeholder="{{ __('Napíšte, čo hľadáte', 'rudno-theme') }}" />
    <button type="submit" class="b-search-form__button">
      @component('ui.icon', [ 'size' => 'big', 'name' => 'ion:search', 'class' => 'b-search-form__button-icon']) @endcomponent
      <span class="sr-only">{{ __('Hľadať', 'rudno-theme') }}</span>
    </button>
  </div>
</form>
