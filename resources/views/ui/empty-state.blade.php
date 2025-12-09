{{--
  Empty state

  Needs properties:
    $title = main message (string)

  Optional properties:
    $subtitle = optional secondary message (html string)
    $search = show search or not (true or null)

--}}

@component('ui.page-section', ['last' => true, 'centered' => true])
  @slot('row_content')
    <div class="col-12 col-lg-7">

      <div class="b-empty-state">
        @component('ui.icon', [ 'size' => 'huge', 'name' => 'ion:sad-outline', 'class' => 'b-empty-state__icon']) @endcomponent
        <h2 class="b-empty-state__title">{{ $title }}</h2>

        @isset($subtitle)
          <p class="b-empty-state__subtitle">{!! $subtitle !!}</p>
        @endisset

        @isset($search)
          <div class="b-empty-state__search">
            @component('ui.searchform', ['field_id' => 'empty-state-search-field'])
            @endcomponent
          </div>
        @endisset

      </div>

    </div>
  @endslot
@endcomponent
