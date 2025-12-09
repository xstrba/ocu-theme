<footer>

  <!-- Prefoooter -->
  <div class="footer-navigation py-5">
    <div class="container">
      <div class="row flex-lg-row-reverse justify-content-lg-between">

          <!-- Search -->
          <div class="col-12 col-lg-4 mb-5 mb-lg-0">
            <h2 class="mb-3 text-white">{{ __('Hľadať na webe', 'rudno-theme') }}</h2>
            @component('ui.searchform', ['field_id' => 'footer-search-field'])
            @endcomponent
          </div>

          <!-- Links -->
          <div class="col-12 col-lg-6">
            <h2 class="mb-3 text-white">{{ __('Ľudia často navštevujú', 'rudno-theme') }}</h2>
            @if(wp_get_nav_menu_items( 'FooterMenu' ))
              <ul class="nav row">
                @foreach ($menuItems = wp_get_nav_menu_items( 'FooterMenu' ) as $item)
                  <li class="nav-item col-6"><a href="{{ $item->url }}" class="nav-link p-0 my-1">{{ $item->title }}</a></li>
                @endforeach
              </ul>
            @endif
          </div>

      </div>
    </div>
  </div>

  <!-- Main Footer -->
  <div class="footer-credits py-5">
    <div class="container">
      <div class="row flex-column align-items-center">

        <!-- Erb -->
        <div class="col-12 pb-3 text-center">
          <a href="{{ home_url('/') }}" class="brand-link">
            <img src="{{ Vite::asset('resources/images/LogoBW.svg') }}" alt="Čiernobiely erb obce Nitrianske Rudno" />
          </a>
        </div>

        <!-- Copyright -->
        <div class="col-12 py-3 text-center ">
          <p class="m-0 p-0 text-muted-dark-bg">&copy; {{ date("Y") }}, {{ __('Obec Nitrianske Rudno', 'rudno-theme') }}, {{ get_option('rudno_ou_address') }}</p>
          <p class="m-0 p-0 text-muted-dark-bg">{{ __('Tel.:', 'rudno-theme') }} {{ get_option('rudno_ou_phone') }}, {{ __('E-mail:', 'rudno-theme') }} <a href="mailto:{{ get_option('rudno_ou_mail') }}" class="text-white">{{ get_option('rudno_ou_mail') }}</a></p>
        </div>

        <!-- Legals -->
        <div class="col-12 pt-3">
          <ul class="nav justify-content-center">
            <li class="nav-item"><a href="{{ home_url('/prehlasenie-o-pouzivani-cookies') }}" class="nav-link text-white my-1"><small>{{ __('Používanie cookies', 'rudno-theme') }}</small></a></li>
            <li class="nav-item"><a href="{{ home_url('/vyhlasenie-o-pristupnosti') }}" class="nav-link text-white my-1"><small>{{ __('Prehlásenie o prístupnosti', 'rudno-theme') }}</small></a></li>
            <li class="nav-item">
                <a href="{{ home_url('/feed') }}" class="nav-link text-white my-1">
                  <small>
                    @component('ui.icon', [ 'size' => 'regular', 'name' => 'ion-logo-rss', 'class' => 'mr-1' ])
                    @endcomponent
                    RSS
                  </small>
                </a>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </div>

</footer>
