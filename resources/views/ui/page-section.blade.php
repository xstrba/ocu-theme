{{--
  Page Section

  Needs properties:
    $row_content = content inside .row element (html string)... use @slot('row_content') @endslot

  Optional properties:
    $headline = section title (string)
    $id = section id (string)
    $white = white background setter (true or null)
    $last = bottom padding setter needed for last sections above the footer (true or null)
    $centered = centered section setter (true or null)
    $pt0 = if true, turns the top padding off
    $class = additional classes when needed (string)

--}}

<?php
$pt0 ??= false;
?>

<section @isset($id) id="{{ $id }}" @endisset class="@isset($white) bg-white @endisset @isset($last) pb-5 @endisset @isset($class) {{ $class }} @endisset">
  <div class="container @if($pt0) pb-5 @else py-5 @endif">
    @isset($headline)
      <div class="row">
        <h2 class="col-12 mb-3 @isset($centered) text-center @endisset">{{ $headline }}</h2>
      </div>
    @endisset
    <div class="row @isset($centered) justify-content-center @endisset">
      {{ $row_content }}
    </div>
  </div>
</section>
