{{--
  Lonely road

  Needs properties:
    $icon = icon name from iconify (string)
    $title = destination page name (string)
    $description = link description (html string)
    $btnlabel = button label (string)

--}}

<div class="b-lonely-road">
  <div class="b-lonely-road__wrapper">
    @component('ui.road', [
      'icon' => $icon,
      'title' => $title,
      'description' => $description,
      'btnlabel' => $btnlabel,
      'link' => $link ?? '#'
    ])
    @endcomponent
  </div>
</div>
