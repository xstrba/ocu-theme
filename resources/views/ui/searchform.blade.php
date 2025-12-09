{{--
  Search form

  Needs properties:
    $field_id = id of search input (string)

--}}

<form class="b-search-form" action="{{ home_url('/') }}" method="GET" role="search" aria-label="{{ __('Hľadať na webe', 'rudno-theme') }}">
  <div class="b-search-form__field-wrapper">
    <label class="sr-only" for="{{ $field_id }}">{{ __('Vyhľadávacie pole', 'rudno-theme') }}</label>
    <input type="search" class="b-search-form__field" name="s" id="{{ $field_id }}" value="{{ the_search_query() }}" placeholder="{{ __('Napíšte, čo hľadáte', 'rudno-theme') }}" />
    <button type="submit" class="b-search-form__button">
      @component('ui.icon', [ 'size' => 'big', 'name' => 'ion:search', 'class' => 'b-search-form__button-icon']) @endcomponent
      <span class="sr-only">{{ __('Hľadať', 'rudno-theme') }}</span>
    </button>
  </div>
</form>
