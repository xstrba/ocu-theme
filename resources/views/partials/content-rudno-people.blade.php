<article class="b-person border-on-white-bg h-100">

  <h1 class="b-person__name">{{ $post->_name }}</h1>

  @isset($role)
    <small class="b-person__role" aria-label="{{ __('Funkcia', 'rudno-theme') }}">
      {{ $role }}
    </small>
  @elseif($post->_position)
    <small class="b-person__role" aria-label="{{ __('Funkcia', 'rudno-theme') }}">
      {{ $post->_position }}
    </small>
  @endisset

  @if($post->_phone)
    <p class="b-person__phone" aria-label="{{ __('Telefón', 'rudno-theme') }}">{{ $post->_phone }}</p>
  @endif

  @if($post->_email)
    <p class="b-person__mail" aria-label="{{ __('E-mail', 'rudno-theme') }}"><a href="mailto:{{ $post->_email }}">{{ $post->_email }}</a></p>
  @endif
</article>
