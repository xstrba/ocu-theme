{{--
  Crossroad

  Needs properties:
      roads = array of links (array)... See "road.blade.php" for more info about array items
--}}

<div class="b-crossroad container">
  <ul class="b-crossroad__list row">
    @foreach ($roads as $road)
      <li class="b-crossroad__list__item col-12 col-md">
        @component('ui.road', [
          'link' => $road['link'],
          'icon' => $road['icon'],
          'title' => $road['title'],
          'target' => $road['target'],
          'description' => $road['description'],
          'btnlabel' => $road['btnlabel'],
          'highlighted' => $road['highlighted']
        ])
        @endcomponent
      </li>
    @endforeach
  </ul>
</div>
