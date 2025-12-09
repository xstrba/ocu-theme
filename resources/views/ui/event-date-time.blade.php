<?php
  $time ??= true;
?>

@if (! $event->_date_to || $event->_date_to === $event->_date_from)
  <p class="mb-5">
    <strong>{{ date('d. m. Y', strtotime($event->_date_from)) }}</strong>
    @if ($time && $event->_time_from)
      <span>{{ __('od', 'rudno-theme') }}</span>
      <strong>{{ $event->_time_from }}</strong>
    @endif
    @if ($time && $event->_time_to)
      <span>{{ __('do', 'rudno-theme') }}</span>
      <strong>{{ $event->_time_to }}</strong>
    @endif
  </p>
@else
  <p class="mb-5">
    <strong>{{ date('d. m. Y', strtotime($event->_date_from)) }}</strong>
    @if ($time && $event->_time_from)
      <span> </span>
      <strong>{{ $event->_time_from }}</strong>
    @endif
    <span> - </span>
    <strong>{{ date('d. m. Y', strtotime($event->_date_to)) }}</strong>
    @if ($time && $event->_time_to)
      <span> </span>
      <strong>{{ $event->_time_to }}</strong>
    @endif
  </p>
@endif
