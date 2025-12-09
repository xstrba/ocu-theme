@php
  /** @var \App\Services\GlobalDataResolver $globalDataResolver */

 $menuItems = wp_get_nav_menu_items( 'MainMenu' );
 $mobileId = 'Mobile';
 $topMenus = [];
 $subMenus = [];
 $currentTopItem = null;
 $selfServerPattern = '/^(((?!http).*)|.*' . $_SERVER['SERVER_NAME'] . '.*)$/';

 if ($menuItems) {
   foreach ($menuItems ?? [] as $key => $item) {
     if (! $item->menu_item_parent) {
       // top menu
       $currentTopItem = $item->ID;
       $topMenus[$item->ID] = [
         'title' => $item->title,
         'url' => $item->url,
         'target' => $globalDataResolver->isServerUrl($item->url) ? '_self' : '_blank',
       ];
     } else {
       if (isset($topMenus[$item->menu_item_parent])) {
         // submenu lvl 1
         $topMenus[$currentTopItem]['items'][$item->ID] = [
           'title' => $item->title,
           'title_link' => $item->url,
           'items' => [],
           'target' => $globalDataResolver->isServerUrl($item->url) ? '_self' : '_blank',
         ];
       } else {
         // is submenu lvl 2
         $topMenus[$currentTopItem]['items'][$item->menu_item_parent]['items'][$item->ID] = [
           'title' => $item->title,
           'url' => $item->url,
           'target' => $globalDataResolver->isServerUrl($item->url) ? '_self' : '_blank',
         ];
       }
     }
   }
 }
@endphp

<!-- Jump to main content for keyboard-only users -->
<a href="#main" class="d-block bg-primary text-white text-center text-underline p-3 sr-only sr-only-focusable">{{ __('Preskočiť na obsah') }}</a>

<!-- Banner -->
<header class="nr-banner">

  <!-- Navigation -->
  <div class="nr-banner__base-menu" role="navigation" aria-label="{{ __('Hlavná navigácia', 'rudno-theme') }}">

    <!-- Base menu -->
    <div class="nr-banner__container">

        <!-- Brand -->
        <a href="{{ home_url('/') }}" class="nr-banner__brand">
          <img class="nr-banner__brand-logo" src="{{ Vite::asset('resources/images/Logo.png') }}" alt="{{ __('Erb obce', 'rudno-theme') . ' ' . $globalDataResolver->siteName() }}"/>
          <h1 class="nr-banner__brand-title">{{ get_bloginfo('name', 'display') }}</h1>
        </a>

        <!-- Desktop menu -->
        <nav class="nr-banner__nav">
          <ul class="nr-banner__nav w-100">
          @foreach ($topMenus as $key => $item)
            @isset ($item['items'])
              <li class="nr-banner__nav-item">
                <a id="item-{{ $key }}" class="nr-banner__nav-link" href="{{ $item['url'] }}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="{{ ltrim($item['url'], '#') }}"
                  @if($item['target'] === '_blank') rel="noreferrer noopener" @endif>
                  {{ $item['title'] }}
                </a>
              </li>
            @else
              <li class="nr-banner__nav-item">
                <a class="nr-banner__nav-link" href="{{ $item['url'] }}" target="{{ $item['target'] }}"
                  @if($item['target'] === '_blank') rel="noreferrer noopener" @endif>
                  {{ $item['title'] }}
                </a>
              </li>
            @endisset
          @endforeach
          </ul>
        </nav>

        <!-- Menu control buttons -->
        <div class="nr-banner__actions">
          <button class="nr-banner__action-btn" data-toggle="modal" data-target="#search-modal" aria-haspopup="true">
            <span class="iconify icon-big mr-1" data-icon="ion:search" data-inline="false"></span>{{ __('Hľadať', 'rudno-theme') }}
          </button>
          <button id="mobile-menu-item" class="nr-banner__action-btn d-lg-none" data-toggle="collapse" data-target="#mobile-dropdown-nav" aria-expanded="false" aria-controls="mobile-dropdown-nav">
            <span class="iconify icon-big mr-1" data-icon="ion:menu" data-inline="false"></span>{{ __('Menu', 'rudno-theme') }}
          </button>
        </div>


    </div>

    <!-- Mobile dropdown menu -->
    <div class="collapse d-lg-none" id="mobile-dropdown-nav" aria-labelledby="mobile-menu-item">
      <div id="mobile-accordion" class="accordion py-5 text-center">

          <ul class="nav flex-column py-5">

            @foreach ($topMenus as $key => $item)
            <li class="nav-item">
                @isset ($item['items'])
                <a id="mobile-item-{{ $key }}" class="big-nav-link p-0 mt-2 mb-3" href="{{ $item['url'] . $mobileId }}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="{{ ltrim($item['url'], '#') }}"
                  @if($item['target'] === '_blank') rel="noreferrer noopener" @endif>
                  {{ $item['title'] }}
                </a>

                <div id="{{ ltrim($item['url'], '#')  . $mobileId }}" class="collapse mb-3" aria-labelledby="mobile-item-{{ $key }}" data-parent="#mobile-accordion">
                  <ul class="nav flex-column">
                    @foreach ($item['items'] as $subItem)
                    <li class="nav-item">
                      <a class="nav-link" href="{{ $subItem['title_link'] }}" target="{{ $subItem['target'] }}"
                        @if($subItem['target'] === '_blank') rel="noreferrer noopener" @endif>
                        {{ $subItem['title'] }}
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                @else
                <a href="{{ $item['url'] }}" class="big-nav-link p-0 mt-2 mb-3" target="{{ $item['target'] }}"
                  @if($item['target'] === '_blank') rel="noreferrer noopener" @endif>
                    {{ $item['title'] }}
                </a>
                @endisset
            </li>
            @endforeach

          </ul>

      </div>
    </div>

    <!-- Desktop dropdow menus -->
    <div class="accordion w-100 d-none d-lg-block" id="desktop-accordion">

      @foreach ($topMenus as $key => $item)
      @isset($item['items'])
      <div class="collapse w-100" id="{{ ltrim($item['url'], '#') }}" data-parent="#desktop-accordion" aria-labelledby="item-{{ $key }}">
        <div class="container py-5">
          <div class="row">
            {{-- start item --}}
            @foreach ($item['items'] ?? [] as $subItem)
            <div class="col-4">
              <div class="card h-100 border border-theme-color p-4 p-lg-5">
                <a href="{{ $subItem['title_link'] }}" class="big-nav-link p-0 m-0 text-left"
                  target="{{ $subItem['target'] }}"
                  @if($subItem['target'] === '_blank') rel="noreferrer noopener" @endif>
                  {{ $subItem['title'] }}
                </a>
                @if($subItem['items'])
                <ul class="nav flex-column mt-3">
                  @foreach ($subItem['items'] as $subSubItem)
                  <li class="nav-item">
                    <a class="nav-link mt-2 p-0" href="{{ $subSubItem['url'] }}" target="{{ $subSubItem['target'] }}">
                    {{ $subSubItem['title'] }}
                    </a>
                  </li>
                  @endforeach
                </ul>
                @endif
              </div>
            </div>
            @endforeach
            {{-- end item --}}
          </div>
        </div>
      </div>
      @endisset
      @endforeach

    </div>

    <!-- Search modal -->
    <div class="modal" id="search-modal" role="dialog" data-backdrop="false" tabindex="-1" aria-label="{{ __('Vyhľadávač', 'rudno-theme') }}" aria-hidden="true">
      <div class="modal-dialog mw-100" role="document">
        <div class="modal-content py-3 py-lg-4">
          <div class="modal-header border-0 p-0">
            <div class="nr-banner__container">

              <!-- Brand -->
              <a href="{{ home_url('/') }}" class="nr-banner__brand">
                <img class="nr-banner__brand-logo" src="{{ Vite::asset('resources/images/Logo.png') }}" alt="{{ __('Erb obce', 'rudno-theme') . ' ' . get_bloginfo('name', 'display') }}"/>
                <span class="nr-banner__brand-title">{{ get_bloginfo('name', 'display') }}</span>
              </a>

              <!-- Close button -->
              <div class="nr-banner__actions">
                <button type="button" class="nr-banner__action-btn" data-dismiss="modal" aria-label="{{ __('Zavrieť', 'rudno-theme') }}">
                  <span class="iconify icon-big mr-1" data-icon="ion:close" data-inline="false"></span>{{ __('Zavrieť', 'rudno-theme') }}
                </button>
              </div>

            </div>
          </div>

          <!-- Search form -->
          <div class="modal-body d-flex justify-content-center p-0 mt-5 pt-5">
            <div class="container">
                <form action="{{ home_url('/') }}" method="GET" role="search" autocomplete="off" aria-label="{{ __('Hľadať na webe', 'rudno-theme') }}">
                  <div class="input-wrapper d-flex py-3">
                    <label class="sr-only" for="menu-search-field">{{ __('Vyhľadávacie pole', 'rudno-theme') }}</label>
                    <input type="text" class="flex-grow-1 border-0 p-0 m-0" name="s" id="menu-search-field" placeholder="{{ __('Napíšte, čo hľadáte', 'rudno-theme') }}" />
                    <button type="submit" class="btn px-0">
                      <span class="iconify icon-big icon-md-huge mr-1" data-icon="ion:search" data-inline="false"></span>
                      <span class="sr-only">{{ __('Hľadať', 'rudno-theme') }}</span>
                    </button>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</header>

<!-- Warning ak ma na stranke byt zobrazeny -->
@include('partials.content-rudno-warnings')
