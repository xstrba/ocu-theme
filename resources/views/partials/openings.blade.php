@foreach ($hours as $key => $items)
<p class="mb-2">
  <strong class="mr-3">{{ __($globalDataResolver->shortDays()[$key], 'rudno-theme') }}</strong>
  @php $first = true; @endphp
  @foreach ($items as $hour)
    {{ $first ? '' : ', ' }} {{ $hour['from'] }}@if($hour['to']) - {{ $hour['to'] }} @endif
    @php
      $first = false;
    @endphp
  @endforeach
</p>
@endforeach
